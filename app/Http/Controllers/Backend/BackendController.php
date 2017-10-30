<?php
/**
 * Created by PhpStorm.
 * User: simon
 * Date: 09/10/2017
 * Time: 3:57 PM
 * https://www.fushupeng.com
 * contact@fushupeng.com
 */

namespace App\Http\Controllers\Backend;


use App\Http\Controllers\Controller;

class BackendController extends Controller
{
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