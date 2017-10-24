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


use Illuminate\Support\Facades\DB;

class IndexController extends FrontendController
{
    public function showIndex()
    {
        return view('frontend.index');
    }

    public function showAbout()
    {
        return view('frontend.about');
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