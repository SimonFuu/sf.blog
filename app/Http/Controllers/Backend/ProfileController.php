<?php
/**
 * Created by PhpStorm.
 * User: simon
 * Date: 23/11/2017
 * Time: 3:04 PM
 * https://www.fushupeng.com
 * contact@fushupeng.com
 */

namespace App\Http\Controllers\Backend;


use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\DB;

class ProfileController extends BackendController
{
    public function showIndex()
    {
        return view('backend.profiles.profile');
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|max:64',
            'email' => 'required|email|max:255|unique:system_users,email,'. Auth::user() -> id . ',id,isDelete,0',
            'password' => 'confirmed|max:64' . ($request -> password == '' ? '' : '|min:6'),
        ];
        $messages = [
            'name.required' => 'Please enter your name.',
            'name.max' => 'The name must be less than :max.',
            'email.required' => 'Please enter your e-mail address.',
            'email.email' => 'The e-mail address is invalid.',
            'email.max' => 'The e-mail address must be less than :max characters.',
            'email.unique' => 'The e-mail address is exists.',
            'password.confirmed' => 'The passwords are mismatched.',
            'password.max' => 'The password must be less than :max characters.',
            'password.min' => 'The password must be longer than :min characters.',
        ];
        $this -> validate($request, $rules, $messages);

        $data = [
            'name' => $request -> name,
            'email' => $request -> email,
        ];
        if ($request -> password) {
            $data['password'] = bcrypt($request -> password);
        }
        DB::table('system_users') -> where('id', '1')
            -> update($data);
        return redirect(route('profile'))
            -> with('success', 'Profile updated, and will take effect in next signing in.');
    }
}