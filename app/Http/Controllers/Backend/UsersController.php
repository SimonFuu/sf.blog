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

class UsersController extends BackendController
{
    public function showIndex(Request $request)
    {
        $users = DB::table('system_users')
            -> select('id', 'username', 'name', 'email')
            -> where(function ($query) use ($request) {
                $query -> where('isDelete', 0);

            })
            -> paginate(self::BACKEND_PER_PAGE_RECORD_COUNT);
        return view('backend.acl.users.list', ['users' => $users]);
    }

    public function showForm(Request $request)
    {
        $user = null;
        if ($request -> has('id')) {
            $u = DB::table('system_users')
                -> select('id', 'username', 'name', 'email')
                -> where('isDelete', 0)
                -> where('id', $request -> id)
                -> first();
            if ($u) {
                $rolesId = DB::table('system_users_roles')
                    -> select('rid')
                    -> where('isDelete', 0)
                    -> where('uid', $request -> id)
                    -> get();
                $user = $u;
                if (count($rolesId) > 0) {
                    foreach ($rolesId as $roleId) {
                        $user -> rid[] = $roleId -> rid;
                    }
                }
            }
        }
        $roles = DB::table('system_roles')
            -> select('id', 'roleName')
            -> where('isDelete', 0)
            -> get();
        return view('backend.acl.users.form', ['user' => $user, 'roles' => $roles]);
    }

    public function store(Request $request)
    {
        $rules = [
            'username' => 'required|max:30|unique:system_users,username,'
                . ($request -> has('id') ? $request -> id : 'NULL') . ',id,isDelete,0',
            'password' => 'required_without:id|confirmed|max:64' . ($request -> password == '' ? '' : '|min:6'),
            'name' => 'required|max:30',
            'email' => 'required|email|max:64|unique:system_users,email,'
                . ($request -> has('id') ? $request -> id : 'NULL') . ',id,isDelete,0',
            'roles' => 'required|array'
        ];
        $messages = [
            'username.required' => 'Please enter the username.',
            'username.max' => 'The username must be less than :max characters.',
            'username.unique' => 'The username is exist, please change another username.',
            'password.required_without' => 'Please enter the password.',
            'password.confirmed' => 'These passwords don\'t match.',
            'password.max' => 'The password must be less than :max characters.',
            'password.min' => 'The password must be longer than :min characters.',
            'name.required' => 'Please enter the name.',
            'name.max' => 'The name must less than :max characters.',
            'email.required' => 'Please enter the e-mail address.',
            'email.email' => 'The e-mail address is invalid.',
            'email.max' => 'The e-mail address must less than characters.',
            'email.unique' => 'The e-mail address is exist, please change another e-mail.',
            'roles.required' => 'Please select the roles.',
            'roles.array' => 'The roles is invalid, please contact with the administrator.',
        ];

        $this -> validate($request, $rules, $messages);
        $userRoles = [];
        DB::beginTransaction();
        try {
            if ($request -> has('id')) {
                $data = [
                    'username' => $request -> username,
                    'name' => $request -> name,
                    'email' => $request -> email,
                ];
                if (!$request -> password) {
                    $data['password'] = bcrypt($request -> password);
                }
                DB::table('system_users')
                    -> where('id', $request -> id)
                    -> update($data);
                DB::table('system_users_roles')
                    -> where('uid', $request -> id)
                    -> update(['isDelete' => 1]);
                if ($request -> id > 1) {
                    foreach ($request -> roles as $role) {
                        $userRoles[] = [
                            'uid' => $request -> id,
                            'rid' => $role
                        ];
                    }
                }

            } else {
                $data = [
                    'username' => $request -> username,
                    'name' => $request -> name,
                    'email' => $request -> email,
                    'password' => bcrypt($request -> password)
                ];
                $uid = DB::table('system_users')
                    -> insertGetId($data);
                foreach ($request -> roles as $role) {
                    $userRoles[] = [
                        'uid' => $uid,
                        'rid' => $role
                    ];
                }
            }
            if ($userRoles) {
                DB::table('system_users_roles')
                    -> insert($userRoles);
            }
            DB::commit();
            return redirect(route('adminUsers')) -> with('success', 'User store successfully.');
        } catch (\Exception $e) {
            return redirect(route('adminUsers')) -> with('error', 'Failed to store the user ' . $e -> getMessage());
        }
    }

    public function delete(Request $request)
    {

    }
}