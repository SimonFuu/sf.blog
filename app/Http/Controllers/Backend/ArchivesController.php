<?php
/**
 * Created by PhpStorm.
 * User: simon
 * Date: 06/11/2017
 * Time: 2:38 PM
 * https://www.fushupeng.com
 * contact@fushupeng.com
 */

namespace App\Http\Controllers\Backend;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ArchivesController extends BackendController
{
    private $search = null;

    public function showIndex(Request $request)
    {
        $catalogs = [-1 => 'Catalog'];
        $categories = [-1 => 'Category'];
        $archives = DB::table('archives')
            -> select(
                'archives.id',
                'archives.title',
                'archives.publishAt',
                'archives.read',
                'archives.sid',
                'archives.isTop',
                DB::raw('0 as comment'),
                'catalogs.name as catalog',
                'categories.name as category'
            )
            -> leftJoin('catalogs', 'catalogs.id', '=', 'archives.catalogId')
            -> leftJoin('categories', 'categories.id', '=', 'archives.categoryId')
            -> where(function ($query) use ($request) {
                $query -> where('archives.isDelete', 0);
                $query -> where('catalogs.isDelete', 0);
                $query -> where('categories.isDelete', 0);
                if ($request -> has('word') && $request -> word !== '') {
                    $query -> where('archives.title', 'like', '%' .$request -> word. '%');
                    $query -> orWhere('archives.sid', $request -> word);
                    $this -> search['word'] = $request -> word;
                }
                if ($request -> has('catalog') && $request -> catalog > 0) {
                    $query -> where('archives.catalogId', $request -> catalog);
                    $this -> search['catalog'] = $request -> catalog;
                }
                if ($request -> has('category') && $request -> category > 0) {
                    $query -> where('archives.categoryId', $request -> category);
                    $this -> search['category'] = $request -> category;
                }
                if ($request -> has('publish') && $request -> publish !== '') {
                    $publish = explode(' - ', $request -> publish);
                    if (count($publish) > 1) {
                        $start = strtotime($publish[0]);
                        $end = strtotime($publish[1]);
                        if ($start && $end) {
                            $query -> where('archives.publishAt', '>=', date('Y-m-d 00:00:00', $start));
                            $query -> where('archives.publishAt', '<=', date('Y-m-d 23:59:59', $end));
                            $this -> search['publish'] = $request -> publish;
                        }
                    }
                }
            })
            -> orderBy('archives.isTop', 'DESC')
            -> orderBy('archives.publishAt', 'DESC')
            -> paginate(self::BACKEND_PER_PAGE_RECORD_COUNT);
            $catalogs_d = DB::table('catalogs')
                -> select('id', 'name')
                -> where('isDelete', 0)
                -> get();
            if (count($catalogs_d) > 0) {
                foreach ($catalogs_d as $catalog) {
                    $catalogs[$catalog -> id] = $catalog -> name;
                }
            }
            $categories_d = DB::table('categories')
                -> select('id', 'name')
                -> where('isDelete', 0)
                -> get();
            if (count($categories_d) > 0) {
                foreach ($categories_d as $category) {
                    $categories[$category -> id] = $category -> name;
                }
            }
        return view('backend.archives.list', [
            'archives' => $archives,
            'search' => $this -> search,
            'catalogs' => $catalogs,
            'categories' => $categories,
        ]);
    }

    public function showForm(Request $request)
    {

    }

    public function store(Request $request)
    {

    }

    public function delete(Request $request)
    {

    }
}