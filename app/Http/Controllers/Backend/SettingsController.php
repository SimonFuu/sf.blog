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


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettingsController extends BackendController
{
    public function showIndex(Request $request)
    {
        $settings = DB::table('system_settings')
            -> select('id', 'key', 'value', 'description')
            -> where(function ($query) use ($request) {
                $query -> where('isDelete', 0);
                if ($request -> has('words') && $request -> words !== '') {
                    $query -> where('key', 'like', '%'.$request -> words.'%');
                    $query -> orWhere('value', 'like', '%'.$request -> words.'%');
                    $query -> orWhere('description', 'like', '%'.$request -> words.'%');
                }
            })
            -> paginate(self::PER_PAGE_RECORD_COUNT);
        return view('backend.settings.list', ['settings' => $settings]);
    }
}