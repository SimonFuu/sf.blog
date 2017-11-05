<?php
/**
 * Created by PhpStorm.
 * User: simon
 * Date: 04/11/2017
 * Time: 10:45 PM
 * https://www.fushupeng.com
 * contact@fushupeng.com
 */

namespace App\Http\Controllers\Backend;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class CatalogsController extends BackendController
{
    public function showIndex()
    {
        $catalogs = DB::table('catalogs')
            -> select('id', 'name', 'isLeftSideMenu', 'isIndexMenu')
            -> where('isDelete', 0)
            -> orderBy('weight', 'ASC')
            -> paginate(self::BACKEND_PER_PAGE_RECORD_COUNT);
        return view('backend.catalogs.list', ['catalogs' => $catalogs]);
    }

    public function showForm(Request $request)
    {
        $catalog = null;
        if ($request -> has('id')) {
            $c = DB::table('catalogs')
                -> select('*') -> where('id', $request -> id) -> first();
            if ($c) {
                $catalog = $c;
            } else {
                return redirect(route('adminCatalogs')) -> with('error', 'Item not found');
            }
        }
        return view('backend.catalogs.form', ['catalog' => $catalog]);
    }

    public function store(Request $request)
    {
        if ($request -> has('action') && substr($request -> action, 0, 1) === '/') {
            $request -> action = substr($request -> action, 1);
        }
        $rules = [
            'name' => ('required|max:30|unique:catalogs,name,' .
                ($request -> has('id') ? $request -> id : 'NULL') . ',id,isDelete,0'),
            'action' => ('required|max:30|unique:catalogs,action,' .
                ($request -> has('id') ? $request -> id : 'NULL') . ',id,isDelete,0'),
            'weight' => 'required|numeric|min:1|max:100',
            'isLeftSideMenu' => 'required|boolean',
            'isIndexMenu' => 'required|boolean',
            'description' => 'required|max:255'
        ];
        $messages = [
            'name.required' => 'Please enter the catalog name.',
            'name.max' => 'The catalog name must be less than :max characters.',
            'name.unique' => 'The catalog name is exist, please change another one.',
            'action.required' => 'Please enter the catalog url.',
            'action.max' => 'The catalog url must be less than :max characters.',
            'action.unique' => 'The catalog url is exist, please change another one.',
            'weight.required' => 'Please enter the display weight.',
            'weight.numeric' => 'The display weight must between :min and :max.',
            'weight.min' => 'The display weight must between :min and :max.',
            'weight.max' => 'The display weight must between :min and :max.',
            'isLeftSideMenu.required' => 'Please confirm the catalog type.',
            'isLeftSideMenu.boolean' => 'The catalog type is invalid, please try again.',
            'isIndexMenu.required' => 'Please confirm the catalog type.',
            'isIndexMenu.boolean' => 'The catalog type is invalid, please try again.',
            'description.required' => 'Please enter the description.',
            'description.max' => 'The description must be less than :max characters.',
        ];
        $this -> validate($request, $rules, $messages);
        try {
            if ($request -> has('id')) {
                DB::table('catalogs') -> where('id', $request -> id) -> update([
                    'name' => $request -> name,
                    'action' => $request -> action,
                    'weight' => $request -> weight,
                    'isLeftSideMenu' => $request -> isLeftSideMenu,
                    'isIndexMenu' => $request -> isIndexMenu,
                    'description' => $request -> description,
                ]);
            } else {
                DB::table('catalogs') -> insert([
                    'name' => $request -> name,
                    'action' => $request -> action,
                    'weight' => $request -> weight,
                    'isLeftSideMenu' => $request -> isLeftSideMenu,
                    'isIndexMenu' => $request -> isIndexMenu,
                    'description' => $request -> description,
                ]);
            }
            Cache::forget('SITE_CATALOGS');
            return redirect(route('adminCatalogs')) -> with('success', 'Catalog store successfully!');
        } catch (\Exception $e) {
            return redirect(route('adminCatalogs')) -> with('error', 'Failed to store the catalog!');
        }
    }

    public function delete(Request $request)
    {

    }
}