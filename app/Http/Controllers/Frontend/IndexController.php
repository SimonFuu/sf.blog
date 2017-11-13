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
        $about = Redis::hget('archives', 'about');
        if (!$about) {
            $about = DB::table('archives')
                -> select('title', 'body')
                -> where('catalogId', 2)
                -> where('publishAt', '<=', $this -> now())
                -> orderBy('publishAt', 'DESC')
                -> first();
            $parser = new Parser();
            $about -> body = $parser -> makeHtml($about -> body);
            if ($about) {
                Redis::hset('archives', 'about', json_encode($about));
                return view('frontend.about', ['about' => $about]);
            } else {
                return abort(404);
            }
        }
        return view('frontend.about', ['about' => json_decode($about)]);
    }

    public function showAllDaily()
    {
        return view('frontend.daily');

    }

    public function showResume()
    {
        return view('frontend.resume');
    }
}