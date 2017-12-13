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


use HyperDown\Parser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class ArchivesController extends BackendController
{
    private $search = null;

    public function showIndex(Request $request)
    {
        $archives = DB::table('archives')
            -> select(
                'archives.id',
                'archives.title',
                'archives.publishAt',
                'archives.pv',
                'archives.uv',
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
                if ($request -> has('words') && $request -> words !== '') {
                    $query -> where(function ($q) use ($request) {
                        $q -> where('archives.title', 'like', '%' . $request -> words . '%');
                        $q -> orWhere('archives.sid', $request -> words);
                    });
                    $this -> search['word'] = $request -> words;
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
        $catalogsAndCategories = $this -> getCatalogsAndCategories();
        $catalogs = $catalogsAndCategories['catalogs'];
        $categories = $catalogsAndCategories['categories'];
        return view('backend.archives.list', [
            'archives' => $archives,
            'search' => $this -> search,
            'catalogs' => $catalogs,
            'categories' => $categories,
        ]);
    }

    public function showForm(Request $request)
    {
        $archive = null;
        $catalogsAndCategories = $this -> getCatalogsAndCategories();
        $catalogs = $catalogsAndCategories['catalogs'];
        $categories = $catalogsAndCategories['categories'];

        $archive = DB::table('archives') -> select('*') -> where('id', $request -> id) -> first();

        return view('backend.archives.form', [
            'archive' => $archive,
            'catalogs' => $catalogs,
            'categories' => $categories
        ]);
    }

    public function store(Request $request)
    {
        // TODO 将url参数自定义化，代替id。
        $rules = [
            'title' => 'required|max:255|unique:archives,title,' .
                ($request -> has('id') ? $request -> id : 'NULL') . ',id,isDelete,0',
            'thumb' => 'sometimes',
            'archive' => 'required',
            'catalog' => 'required|exists:catalogs,id,isDelete,0',
            'category' => (
                ($request -> has('catalog') && $request -> catalog == 1) ?
                    'required|exists:categories,id,isDelete,0' : 'sometimes'
            ),
            'publishAt' => 'required|date',
            'isTop' => 'required|boolean'
        ];
        $messages = [
            'title.required' => 'Please enter the title.',
            'title.max' => 'The title must be less than :max characters.',
            'title.unique' => 'The title is exist, please try again.',
            'archive.required' => 'Please enter the content.',
            'catalog.required' => 'Please select the catalog.',
            'catalog.exists' => 'The catalog is invalid.',
            'publishAt.required' => 'Please select the publish time.',
            'publishAt.date' => 'The publish time is invalid.',
            'isTop.required' => 'Please select is top archive.',
            'isTop.boolean' => 'The is top select is invalid.',
        ];
        $this -> validate($request, $rules, $messages);
        $data = [
            'title' => $request -> title,
            'body' => $request -> archive,
            'catalogId' => $request -> catalog,
            'categoryId' => $request -> category < 1 ? 1 : $request -> category,
            'isTop' => $request -> isTop,
            'publishAt' => $request -> publishAt,
            'sid' => uniqid(),
            'filing' => substr($request -> publishAt, 0, 7),
        ];
        if ($request -> has('thumb') && $request -> thumb) {
            $data['thumb'] = $request -> thumb;
        }

        try {
            if ($request -> isTop) {
                DB::table('archives') -> where('isTop', 1) -> update(['isTop' => 0]);
            }
            if ($request -> has('id')) {
                unset($data['sid']);
                DB::table('archives') -> where('id', $request -> id) -> update($data);
                $id = $request -> id;
            } else {
                $id = DB::table('archives') -> insertGetId($data);
            }
            Cache::forget('SITE_SIDEBARS');
            $this -> cacheArchive($id, $data['catalogId']);
            return redirect(route('adminArchives')) -> with('success', 'Archive store successfully!');
        } catch (\Exception $e) {
            return redirect(route('adminArchives')) -> with('error', 'Failed to store archive: ' . $e -> getMessage());
        }
    }

    public function delete(Request $request)
    {
        if ($request -> id <= 2) {
            return redirect(route('adminArchives'))
                -> with('error', 'Sorry, the "About" and "Resume" couldn\'t be deleted!');
        }
        try {
            $archive = DB::table('archives') -> select('sid', 'catalogId')
                -> where('id', $request -> id) -> where('isDelete', 0) -> first();
            if ($archive) {
                DB::table('archives') -> where('id', $request -> id) -> update(['isDelete' => 1]);
                Cache::forget('SITE_SIDEBARS');
                if ($archive -> catalogId == 1) {
                    Redis::hdel('archives', config('app.about_catalog_name'));
                } elseif ($archive -> catalogId == 2) {
                    Redis::hdel('archives', config('app.resume_catalog_name'));
                } else {
                    Redis::hdel('archives', $archive -> sid);
                }
            } else {
                return redirect(route('adminArchives'))
                    -> with('error', 'Failed to delete archive: the archive has been deleted!');
            }
            return redirect(route('adminArchives')) -> with('success', 'Archive delete successfully!');
        } catch (\Exception $e) {
            return redirect(route('adminArchives')) -> with('error', 'Failed to delete archive: ' . $e -> getMessage());
        }
    }

    private function getCatalogsAndCategories()
    {
        $catalogs = [-1 => 'Catalog'];
        $categories = [-1 => 'Category'];
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
        return ['catalogs' => $catalogs, 'categories' => $categories];
    }

    private function cacheArchive($id = 0, $catalogId = 0)
    {
        if ($catalogId == 2 || $catalogId == 3) {
            $archive = DB::table('archives')
                -> select('sid', 'title', 'body')
                -> where('catalogId', $catalogId)
                -> where('isDelete', 0)
                -> where('publishAt', '<=', $this -> now())
                -> orderBy('publishAt', 'DESC')
                -> first();
        } else {
            $archive = DB::table('archives')
                -> select(
                    'archives.id', 'archives.title', 'archives.body', 'archives.thumb', 'archives.sid', 'categories.name',
                    'archives.publishAt'
                )
                -> leftJoin('categories', 'categories.id', '=', 'archives.categoryId')
                -> where('archives.id', $id)
                -> where('archives.isDelete', 0)
                -> where('archives.publishAt', '<=', $this -> now())
                -> first();
        }
        if (!is_null($archive)) {
            Redis::del('archives');
            switch ($catalogId) {
                case 2:
                    $field = config('app.about_catalog_name');
                    break;
                case 3:
                    $field = config('app.resume_catalog_name');
                    break;
                default:
                    $field = $archive -> sid;
                    break;
            }
            $parse = new Parser();
            $archive -> body = $parse -> makeHtml($archive -> body);
            if ($catalogId != 2 && $catalogId != 3) {
                $archive -> nextArchive = $this -> getNextArchive($archive -> publishAt);
                $archive -> prepArchive = $this -> getPreArchive($archive -> publishAt);
            }
            Redis::hset('archives', $field, json_encode($archive));
        }
    }

    private function getNextArchive($date = '1990-01-01')
    {
        return DB::table('archives')
            -> select('sid', 'title')
            -> where('isDelete', 0)
            -> where('catalogId', 1)
            -> where('publishAt', '<', $date)
            -> orderBy('publishAt', 'DESC')
            -> first();
    }

    private function getPreArchive($date = '1990-01-01')
    {
        return DB::table('archives')
            -> select('sid', 'title')
            -> where('isDelete', 0)
            -> where('catalogId', 1)
            -> where('publishAt', '>', $date)
            -> orderBy('publishAt', 'ASC')
            -> first();
    }
}