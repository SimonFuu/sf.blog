<?php
/**
 * Created by PhpStorm.
 * User: simon
 * Date: 27/10/2017
 * Time: 3:18 PM
 * https://www.fushupeng.com
 * contact@fushupeng.com
 */

namespace App\Http\Controllers\Backend;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ActionsController extends BackendController
{
    public function showIndex(Request $request)
    {
        return view('backend.acl.actions.list');
    }

    public function showForm($id = 0)
    {
        $action = null;
        $menus = [];
        if ($id !== 0) {

        }
        $menus['一级菜单'] = ['根目录'];
        $pActs = DB::table('system_actions')
            -> select('id', 'actionName')
            -> where('deleteAt', '>=', $this -> now())
            -> where('parentId', 0)
            -> get();
        if (count($pActs) !== 0) {
            foreach ($pActs as $pAct) {
                $menus['二级菜单'][$pAct -> id] = $pAct -> actionName;
            }
        }
        $icons = [];
        $iconsItems = DB::table('system_icons')
            -> select('icon') -> get();
        if ($iconsItems) {
            foreach ($iconsItems as $iconItem) {
                $icons[] = $iconItem -> icon;
            }
        }
        return view('backend.acl.actions.form', ['action' => $action, 'menus' => $menus, 'icons' => json_encode($icons)]);
    }

    public function delete()
    {
        
    }

    public function adminStoreRoles(Request $request)
    {
        
    }
}