<?php
/**
 * Created by PhpStorm.
 * User: simon
 * Date: 09/10/2017
 * Time: 4:00 PM
 * https://www.fushupeng.com
 * contact@fushupeng.com
 */

namespace App\Http\Controllers\Frontend;


use HyperDown\Parser;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class IndexController extends FrontendController
{
    public function showIndex()
    {
        return view('frontend.index');
    }

    public function showAbout()
    {
        $about = Redis::hget('archives', config('app.about_catalog_name'));
        if (!$about) {
            $about = DB::table('archives')
                -> select('sid', 'title', 'body')
                -> where('catalogId', 2)
                -> where('createdAt', '<=', $this -> now())
                -> orderBy('createdAt', 'DESC')
                -> first();
            $parser = new Parser();
            $about -> body = $parser -> makeHtml($about -> body);
            if ($about) {
                Redis::hset('archives', config('app.about_catalog_name'), json_encode($about));
            } else {
                return abort(404);
            }
        } else {
            $about = json_decode($about);
        }
        return view('frontend.about', ['about' => $about]);
    }

    public function showAllDaily()
    {
        return view('frontend.daily');
    }

    public function showResume()
    {
        $resume = Redis::hget('archives', config('app.resume_catalog_name'));
        if (!$resume) {
            $resume = DB::table('archives')
                -> select('sid', 'title', 'body')
                -> where('catalogId', 3)
                -> where('createdAt', '<=', $this -> now())
                -> orderBy('createdAt', 'DESC')
                -> first();
            $parser = new Parser();
            $resume -> body = $parser -> makeHtml($resume -> body);
            if ($resume) {
                Redis::hset('archives', config('app.resume_catalog_name'), json_encode($resume));
            } else {
                return abort(404);
            }
        } else {
            $resume = json_decode($resume);
        }
        return view('frontend.resume', ['resume' => $resume]);
    }
}