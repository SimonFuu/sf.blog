<?php
/**
 * Created by PhpStorm.
 * User: simon
 * Date: 09/10/2017
 * Time: 3:57 PM
 * https://www.fushupeng.com
 * contact@fushupeng.com
 */

namespace App\Http\Controllers\Backend;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BackendController extends Controller
{
    public function redirectIndex()
    {
        return redirect(route('adminIndex'));
    }

    public function showDashboard()
    {
        return view('backend.index');
    }

    public function showNotification()
    {
        return view('backend.notify');
    }

    public function ajaxValidate(Request $request, array $rules,
                             array $messages = [], array $customAttributes = [])
    {

        $res = false;
        $validator = $this->getValidationFactory()->make($request -> all(), $rules, $messages, $customAttributes);

        if ($validator->fails()) {
            $validateErrors = $validator->errors()->getMessages();
            reset($validateErrors);
            return current($validateErrors)[0];
        }
        return $res;
    }
}