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
use Illuminate\Support\Facades\Cache;
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

    public function showForm(Request $request)
    {
        $setting = null;
        return view('backend.settings.form', ['setting' => $setting]);
    }

    public function store(Request $request)
    {
        $rules = [
            'key' => ('required|max:30|unique:system_settings,key,' .
                ($request -> has('id')  ? $request -> id : 'NULL') . ',id,isDelete,0'),
            'description' => 'required|max:255',
            'value' => 'required|max:255'
        ];
        $message = [
            'key.required' => 'Please enter setting key.',
            'key.max' => 'The setting key must be less than :max characters.',
            'key.unique' => 'The setting key is exist, please try again.',
            'description.required' => 'Please enter the description.',
            'description.max' => 'The description must be less than :max characters.',
            'value.required' => 'Please select the permissions.',
            'value.max' => 'The value must be less than :max characters.',
        ];

        $this -> validate($request, $rules, $message);
        try {
            if ($request -> has('id')) {
                DB::table('system_settings')
                    -> where('id', $request -> id)
                    -> update([
                        'key' => $request -> key,
                        'value' => $request -> value,
                        'description' => $request -> description
                    ]);
            } else {
                DB::table('system_settings')
                    -> insert([
                        'key' => $request -> key,
                        'value' => $request -> value,
                        'description' => $request -> description
                    ]);
            }
        } catch (\Exception $e) {
            return redirect(route('adminSettings'))
                -> with('error', 'Filed to store site settings: ' . $e -> getMessage());
        }

        $this -> cacheSettings();
        return redirect(route('adminSettings')) -> with('success', 'Site settings store successfully!');
    }

    public function cacheSettings()
    {
        Cache::forget(env('APP_NAME') . '_SETTINGS');
        $settingsArray = [];
        $settings = DB::table('system_settings') -> select('key', 'value') -> where('isDelete', 0) -> get();
        if (count($settings) > 0) {
            foreach ($settings as $setting) {
                $settingsArray[$setting -> key] = $setting -> value;
            }
            Cache::forever(env('APP_NAME') . '_SETTINGS', $settingsArray);
        }
    }
}
