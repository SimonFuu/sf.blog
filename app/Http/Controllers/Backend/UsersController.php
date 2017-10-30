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
            -> paginate(self::PER_PAGE_RECORD_COUNT);
        return view('backend.acl.users.list', ['users' => $users]);
    }

    public function showForm(Request $request)
    {
        $user = null;
        if ($request -> has('id')) {

        }
        $roles = DB::table('system_roles')
            -> select('id', 'roleName')
            -> where('isDelete', 0)
            -> get();
        return view('backend.acl.users.form', ['user' => $user, 'roles' => $roles]);
    }

    public function store(Request $request)
    {

    }

    public function delete(Request $request)
    {

    }
}