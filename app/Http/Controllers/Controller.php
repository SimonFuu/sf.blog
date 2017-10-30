<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * 分页，单页显示数量
     */
    const PER_PAGE_RECORD_COUNT = 5;

    private $now = null;

    protected function now()
    {
        if (is_null($this -> now)) {
            $this -> now = date('Y-m-d H:i:s');
        }
        return $this -> now;
    }


}
