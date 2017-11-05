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
    const FRONTEND_PER_PAGE_RECORD_COUNT = 5;
    const BACKEND_PER_PAGE_RECORD_COUNT = 15;

    private $now = null;

    protected function now()
    {
        if (is_null($this -> now)) {
            $this -> now = date('Y-m-d H:i:s');
        }
        return $this -> now;
    }

    /**
     * 树状结构
     * @param array $data 需要处理的数据
     * @param string $field 根据这个字段进行分级区分
     * @param int $id
     * @param int $level
     * @return array
     */
    protected function treeView($data = array(), $field = 'level', $id = 0, $level = 0)
    {
        $tree = [];
        foreach ($data as $value) {
            if (is_array($value)) {
                if ($value[$field] == $id) {
                    $value['level'] = $level;
                    $value['children'] = $this -> treeView($data, $field, $value['id'], $level+1);
                    $tree[] = $value;
                }
            } elseif(is_object($value)) {
                if ($value -> $field == $id) {
                    $value -> level = $level;
                    $value -> children = $this -> treeView($data, $field, $value -> id, $level+1);
                    $tree[] = $value;
                }
            }
        }
        return $tree;
    }


}
