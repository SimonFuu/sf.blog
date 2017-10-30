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
            -> paginate(self::PER_PAGE_RECORD_COUNT);
        return view('backend.acl.actions.list', ['actions' => $actions]);
    }

    public function showForm(Request $request)
    {
        $action = null;
        $menus = [];
        if ($request -> has('id')) {
            $action = DB::table('system_actions')
                -> select('id', 'actionName', 'url', 'icon', 'description', 'actions', 'weight', 'parentId')
                -> where('isDelete', 0)
                -> where('id', $request -> id)
                -> first();
            if (!$action) {
                return redirect() -> back() -> with('error', 'Item not found');
            }
        }
        $menus['一级菜单'] = ['根目录'];
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
                    $menus['二级菜单'][$pAct -> id] = $pAct -> actionName;
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
            'actions' => 'required|max:1000',
            'parentId' => 'required|' .
                (($request -> has('parentId') && $request -> parentId > 0) ? 'exists:system_actions,id,isDelete,0'  : ''),
            'weight' => 'required|numeric|min:1|max:10000',
            'icon' => 'required|exists:system_icons,icon'
        ];
        $message = [
            'actionName.required' => '请输入权限名称！',
            'actionName.unique' => '已存在同名的权限，请确认！',
            'actionName.max' => '权限名称不要超过:max个字符！',
            'url.required' => '请输入左侧菜单URL地址！',
            'url.max' => '长度请不要超过:max！',
            'description.required' => '请输入权限描述',
            'description.max' => '长度不要超过:max！',
            'actions.required' => '请输入权限对应的URL地址，一行一个！',
            'actions.max' => 'URL地址总体长度不要该超过:max！',
            'parentId.required' => '请选择父级菜单',
            'parentId.exists' => '选择的父级菜单不存在',
            'weight.required' => '请输入菜单展示权重！',
            'weight.numeric' => '菜单展示权重格式不正确，请输入:min-:max的数字！',
            'weight.min' => '菜单展示权重格式不正确，请输入:min-:max的数字！',
            'weight.max' => '菜单展示权重格式不正确，请输入:min-:max的数字！',
            'icon.required' => '请选择菜单图标！',
            'icon.exists' => '请选择系统提供的图标！'
        ];
        $this -> validate($request, $rules, $message);
        $req = $request -> except('_token');
        if ($request -> has('actions')) {
            $req['actions'] = json_encode(explode("\r\n", $request -> actions));
        }
        try {
            if ($request -> has('id')) {
                DB::table('system_actions')
                    -> where('id', $request -> id)
                    -> where('isDelete', 0)
                    -> update($req);
            } else {
                DB::table('system_actions')
                    ->insert($req);
            }
            return redirect(route('adminActions')) -> with('success', '保存权限成功！');
        } catch (\Exception $e) {
            return redirect(route('adminActions')) -> with('error', '保存权限失败：' . $e -> getMessage());
        }
    }

    public function delete(Request $request)
    {
        try {
            return redirect(route('adminActions')) -> with('success', '删除权限成功！');
        } catch (\Exception $e) {
            return redirect(route('adminActions')) -> with('error', '删除权限失败：' . $e -> getMessage());
        }
    }
}
