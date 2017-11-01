<?php
/**
 * Created by PhpStorm.
 * User: simon
 * Date: 01/11/2017
 * Time: 5:59 PM
 * https://www.fushupeng.com
 * contact@fushupeng.com
 */

namespace App\Http\Controllers\Backend;


use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class SettingsController extends BackendController
{
    public function __destruct()
    {
        $settings = DB::table('system_settings')
            -> select('key', 'value')
            -> where('isDelete', 0)
            -> get();
    }
}