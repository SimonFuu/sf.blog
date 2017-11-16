<?php
/**
 * Created by PhpStorm.
 * User: simon
 * Date: 27/10/2017
 * Time: 3:18 PM
 * https://www.fushupeng.com
 * contact@fushupeng.com
 */

namespace App\Http\Controllers\Backend;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ActionsController extends BackendController
{
    public function showIndex()
    {
        $actions = DB::table('system_actions')
            -> select('id', 'actionName', 'icon', 'description', 'actions', 'weight', 'parentId')
            -> where('isDelete', 0)
            -> orderBy('weight', 'ASC')
            -> paginate(self::BACKEND_PER_PAGE_RECORD_COUNT);
        return view('backend.acl.actions.list', ['actions' => $actions]);
    }

    public function showForm(Request $request)
    {
        $action = null;
        $menus = [];
        if ($request -> has('id')) {
            if ($request -> id <= 5) {
                return redirect(route('adminActions')) -> with('error', 'Unable to edit the system reserved action');
            }
            $action = DB::table('system_actions')
                -> select('id', 'actionName', 'url', 'icon', 'description', 'actions', 'weight', 'parentId')
                -> where('isDelete', 0)
                -> where('id', $request -> id)
                -> first();
            if (!$action) {
                return redirect() -> back() -> with('error', 'Item not found');
            }

            $actions = json_decode($action -> actions, true);
            $prefix = $action -> url . '/';
            $t = [];
            foreach ($actions as $key => $item) {
                if ($action -> url === $item) {
                    continue;
                }
                $t[] = str_replace($prefix, '', $item);
            }
            $action -> actions = $t;
            $action -> url = substr($action -> url, 1);
        }
        $menus['Level 1'] = ['Root'];
        $pActs = DB::table('system_actions')
            -> select('id', 'actionName')
            -> where('isDelete', 0)
            -> where('parentId', 0)
            -> get();
        if (count($pActs) !== 0) {
            foreach ($pActs as $pAct) {
                if ($request -> id == $pAct -> id) {
                    continue;
                } else {
                    $menus['Level 2'][$pAct -> id] = $pAct -> actionName;
                }
            }
        }
        $icons = [];
        $iconsItems = DB::table('system_icons')
            -> select('icon') -> get();
        if ($iconsItems) {
            foreach ($iconsItems as $iconItem) {
                $icons[] = $iconItem -> icon;
            }
        }
        return view('backend.acl.actions.form', ['action' => $action, 'menus' => $menus, 'icons' => json_encode($icons)]);
    }

    public function store(Request $request)
    {
        $rules = [
            'actionName' => 'required|max:20|unique:system_actions,actionName,'
                . ($request -> has('id')  ? $request -> id : 'NULL') . ',id,isDelete,0',
            'url' => 'required|max:255',
            'description' => 'required|max:255',
            'actions' => 'required|array',
            'parentId' => 'required|' .
                (($request -> has('parentId') && $request -> parentId > 0) ? 'exists:system_actions,id,isDelete,0'  : ''),
            'weight' => 'required|numeric|min:1|max:10000',
            'icon' => 'required|exists:system_icons,icon'
        ];
        $message = [
            'actionName.required' => 'Please enter the action name.',
            'actionName.unique' => 'The action name is exist.',
            'actionName.max' => 'The action name must be less than :max characters.',
            'url.required' => 'Please enter the base url.',
            'url.max' => 'The url must be less than :max characters.',
            'description.required' => 'Please enter the action description.',
            'description.max' => 'The description must less than :max characters',
            'actions.required' => 'Please enter the actions.',
            'actions.array' => 'The actions is invalid please contact with the administrator.',
            'parentId.required' => 'Please select the parent menu.',
            'parentId.exists' => 'The parent menu is not exist, please try again.',
            'weight.required' => 'Please enter the display weight！',
            'weight.numeric' => 'The display weight must between :min and :max.',
            'weight.min' => 'The display weight must between :min and :max.',
            'weight.max' => 'The display weight must between :min and :max.',
            'icon.required' => 'Please select the menu icon.',
            'icon.exists' => 'The icon you select is not exist, please try again.'
        ];
        $this -> validate($request, $rules, $message);
        $req = $request -> except('_token');
        if (substr($req['url'], 0, 1) !== '/') {
            $req['url'] = '/' . $req['url'];
        }
        if (substr($req['url'], -1, 1) === '/') {
            $req['url'] = substr($req['url'], 0, -1);
        }
        if ($request -> has('actions')) {
            $t = [$req['url']];
            foreach ($request -> actions as  $action) {
                if (substr($action, 0, 1) !== '/') {
                    $action = '/' . $action;
                }
                if (substr($action, -1, 1) === '/') {
                    $action = substr($action, 0, -1);
                }
                $t[] = $req['url'] . $action;
            }
            $req['actions'] = json_encode(array_unique($t));
        }
        try {
            if ($request -> has('id')) {
                if ($request -> id <= 5) {
                    return redirect(route('adminActions')) -> with('error', 'Unable to edit the system reserved action');
                }
                DB::table('system_actions')
                    -> where('id', $request -> id)
                    -> where('isDelete', 0)
                    -> update($req);
            } else {
                DB::table('system_actions')
                    ->insert($req);
            }
            return redirect(route('adminActions')) -> with('success', 'Action store successfully.');
        } catch (\Exception $e) {
            return redirect(route('adminActions')) -> with('error', 'Failed to store the action: ' . $e -> getMessage());
        }
    }

    public function delete(Request $request)
    {
        try {
            if ($request -> has('id')) {
                if ($request -> id <= 5) {
                    return redirect(route('adminActions')) -> with('error', 'Unable to delete the system reserved action');
                }
            }
            return redirect(route('adminActions')) -> with('success', 'Action delete successfully.');
        } catch (\Exception $e) {
            return redirect(route('adminActions')) -> with('error', 'Failed to delete the action: ' . $e -> getMessage());
        }
    }
}
