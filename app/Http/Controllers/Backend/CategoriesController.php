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

class CategoriesController extends BackendController
{
    public function showIndex()
    {
        $categories = DB::table('categories')
            -> select('id', 'name', 'description', 'weight')
            -> where('isDelete', 0)
            -> orderBy('weight', 'ASC')
            -> paginate(self::BACKEND_PER_PAGE_RECORD_COUNT);
        return view('backend.categories.list', ['categories' => $categories]);
    }

    public function showForm(Request $request)
    {
        $category = null;
        if ($request -> has('id')) {
            if ($request -> id == 1) {
                return redirect(route('adminCategories')) -> with('error', 'Could not edit the default category.');
            }
            $c = DB::table('categories')
                -> select('*') -> where('id', $request -> id) -> first();
            if ($c) {
                $category = $c;
            } else {
                return redirect(route('adminCategories')) -> with('error', 'Item not found');
            }
        }
        return view('backend.categories.form', ['category' => $category]);
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => ('required|max:30|unique:categories,name,' .
                ($request -> has('id') ? $request -> id : 'NULL') . ',id,isDelete,0'),
            'weight' => 'required|numeric|min:1|max:100',
            'description' => 'required|max:255'
        ];
        $messages = [
            'name.required' => 'Please enter the category name.',
            'name.max' => 'The category name must be less than :max characters.',
            'name.unique' => 'The category name is exist, please change another one.',
            'weight.required' => 'Please enter the display weight.',
            'weight.numeric' => 'The display weight must between :min and :max.',
            'weight.min' => 'The display weight must between :min and :max.',
            'weight.max' => 'The display weight must between :min and :max.',
            'description.required' => 'Please enter the description.',
            'description.max' => 'The description must be less than :max characters.',
        ];
        $this -> validate($request, $rules, $messages);
        try {
            if ($request -> has('id')) {
                if ($request -> id == 1) {
                    return redirect(route('adminCategories')) -> with('error', 'Could not edit the default categories.');
                }
                DB::table('categories') -> where('id', $request -> id) -> update([
                    'name' => $request -> name,
                    'weight' => $request -> weight,
                    'description' => $request -> description,
                ]);
            } else {
                DB::table('categories') -> insert([
                    'name' => $request -> name,
                    'weight' => $request -> weight,
                    'description' => $request -> description,
                ]);
            }
            Cache::forget('SITE_SIDEBARS');
            return redirect(route('adminCategories')) -> with('success', 'Category store successfully!');
        } catch (\Exception $e) {
            return redirect(route('adminCategories')) -> with('error', 'Failed to store the category: ' . $e -> getMessage());
        }
    }

    public function delete(Request $request)
    {
        if ($request -> has('id') && $request -> id != 1) {
            try {
                DB::table('categories') -> where('id', $request -> id) -> update(['isDelete' => 1]);
                DB::table('archives') -> where('categoryId', $request -> id) -> update(['categoryId' => 1]);
                Cache::forget('SITE_SIDEBARS');
                return redirect(route('adminCategories'))
                    -> with('success', 'Category delete successfully, all the archives in this category has been move to the "Daily" category!');
            } catch (\Exception $e) {
                return redirect(route('adminCategories')) -> with('error', 'Failed to delete the category: ' . $e -> getMessage());
            }
        } else {
            return redirect(route('adminCategories')) -> with('error', 'Failed to delete the default category!');
        }
    }
}