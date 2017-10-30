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

class RolesController extends BackendController
{
    public function showIndex()
    {
        $roles = DB::table('system_roles')
            -> select('id', 'roleName', 'description')
            -> where('isDelete', 0)
            -> paginate(self::PER_PAGE_RECORD_COUNT);
        return view('backend.acl.roles.list', ['roles' => $roles]);
    }

    public function showForm(Request $request)
    {
        $role = null;
        if ($request -> has('id')) {
            if ($request -> id <= 2) {
                return redirect(route('adminRoles')) -> with('error', 'Unable to edit the system reserved role.');
            }
            $r = DB::table('system_roles')
                -> select('id', 'roleName', 'description')
                -> where('id', $request -> id)
                -> first();
            if ($r) {
                $actionsId = DB::table('system_roles_actions')
                    -> select('aid')
                    -> where('rid', $request -> id)
                    -> where('isDelete', 0)
                    -> get();
                $role = $r;
                if (count($actionsId) > 0) {
                    foreach ($actionsId as $actionId) {
                        $role -> aid[] = $actionId -> aid;
                    }
                }
            }
        }
        $actions = DB::table('system_actions')
            -> select('id', 'actionName', 'parentId')
            -> where('isDelete', 0)
            -> get();

        $actions = json_decode(json_encode($actions), true);
        if ($actions) {
            $actions = $this -> treeView($actions, 'parentId');
        }
        return view('backend.acl.roles.form', ['role' => $role, 'actions' => $actions]);
    }

    public function store(Request $request)
    {
        $rules = [
            'roleName' => ('required|max:30|unique:system_roles,roleName,' .
                ($request -> has('id')  ? $request -> id : 'NULL') . ',id,isDelete,0'),
            'description' => 'required|max:255',
            'actions' => 'required|array'
        ];
        $message = [
            'roleName.required' => 'Please enter the role name.',
            'roleName.max' => 'The role name must be less than :max characters.',
            'roleName.unique' => 'The role name is exist, please try again.',
            'description.required' => 'Please enter the description.',
            'description.max' => 'The description must be less than :max characters.',
            'actions.required' => 'Please select the permissions.',
            'actions.array' => 'Invalid permissions, please contact with the administrator.',
        ];
        $this -> validate($request, $rules, $message);

        $roleActions = [];
        DB::beginTransaction();
        try {
            if ($request -> has('id')) {
                if ($request -> id <= 2) {
                    DB::commit();
                    return redirect(route('adminRoles')) -> with('error', 'Unable to edit the system reserved role.');
                }
                DB::table('system_roles')
                    -> where('id', $request -> id)
                    -> update(['roleName' => $request -> roleName, 'description' => $request -> description]);
                DB::table('system_roles_actions')
                    -> where('rid', $request -> id)
                    -> update(['isDelete' => 1]);
                foreach ($request -> actions as $action) {
                    $roleActions[] = [
                        'rid' => $request -> id,
                        'aid' => $action
                    ];
                }
            } else {
                $rid = DB::table('system_roles')
                    -> insertGetId(['roleName' => $request -> roleName, 'description' => $request -> description]);
                foreach ($request -> actions as $action) {
                    $roleActions[] = [
                        'rid' => $rid,
                        'aid' => $action
                    ];
                }
            }
            if ($roleActions) {
                DB::table('system_roles_actions')
                    -> insert($roleActions);
            }
            DB::commit();
            return redirect(route('adminRoles')) -> with('success', 'Role store successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect(route('adminRoles')) -> with('error', 'Failed to store the role: ' . $e -> getMessage());
        }
    }

    public function delete(Request $request)
    {
        try {
            if ($request -> has('id')) {
                if ($request -> id <= 2) {
                    return redirect(route('adminRoles')) -> with('error', 'Unable to delete the system reserved role.');
                }
            }
            return redirect(route('adminRoles')) -> with('success', 'Action delete successfully.');
        } catch (\Exception $e) {
            return redirect(route('adminRoles')) -> with('error', 'Failed to delete the action: ' . $e -> getMessage());
        }
    }
}