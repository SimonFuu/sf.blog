<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    protected $protectUri = [];

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this -> protectUri = [
            config('app.backend_prefix') => true,
            config('app.backend_prefix') . '/upload/new' => true,
            config('app.backend_prefix') . '/upload/delete' => true,
            config('app.backend_prefix') . '/notify' => true,
            config('app.backend_prefix') . '/profile' => true,
            config('app.backend_prefix') . '/profile/store' => true,
        ];
        $this->middleware('guest')->except('logout');
    }

    public function showLogin()
    {
        return view('backend.login');
    }

    public function doUserLogin(Request $request)
    {
        if (Auth::attempt([
            $this -> username() => $request -> username,
            'password' => $request -> password,
            'isDelete' => 0
        ])) {
            $rolesId = DB::table('system_users_roles')
                -> select('rid') -> where('isDelete', 0) -> where('uid', Auth::user() -> id) -> get();
            if (count($rolesId) > 0) {
                $isRootAdmin = false;
                $rid = [];
                foreach ($rolesId as $roleId) {
                    if ($roleId -> rid == 2) {
                        $isRootAdmin = true;
                        break;
                    } else {
                        $rid[] = $roleId -> rid;
                    }
                }
                if ($isRootAdmin) {
                    $actions = DB::table('system_actions')
                        -> select('id', 'actionName', 'actions', 'url', 'icon', 'parentId')
                        -> where('isDelete', 0) -> orderBy('weight', 'ASC') -> get();
                } else {
                    $actions = DB::table('system_roles_actions')
                        -> select(
                            'system_actions.id',
                            'system_actions.actionName',
                            'system_actions.actions',
                            'system_actions.url',
                            'system_actions.icon',
                            'system_actions.parentId'
                        )
                        -> leftJoin('system_actions', 'system_actions.id', '=', 'system_roles_actions.aid')
                        -> where('system_actions.isDelete', 0)
                        -> where('system_roles_actions.isDelete', 0)
                        -> whereIn('system_roles_actions', $rid)
                        -> orderBy('system_actions.weight', 'ASC')
                        -> get();
                }
                $permissions = $this -> protectUri;
                foreach ($actions as $action) {
                    $permission = json_decode($action -> actions, true);
                    foreach ($permission as $value) {
                        $permissions[config('app.backend_prefix') . $value] = 1;
                    }
                }
                $actions = json_decode(json_encode($actions), true);
                $menus = $this -> treeView($actions, 'parentId');
                session(['adminMenus' => $menus]);
                session(['permissions' => $permissions]);
                DB::table('system_users') -> increment('loginTimes', 1, ['lastLoginIp' => $request -> getClientIp()]);
                return redirect(route('adminIndex'));
            } else {
                Auth::logout();
                return redirect(route('login'))
                    -> with('error', 'There is something wrong, please contact with the administrator.');
            }
        } else {
            return $this -> sendFailedLoginResponse($request);
        }
    }

    private function username()
    {
        return 'username';
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        $errors = [$this->username() => 'Your account or password is incorrect..'];

        if ($request->expectsJson()) {
            return response()->json($errors, 422);
        }

        return redirect(route('login'))
            ->withInput($request->only($this->username(), 'remember'))
            ->withErrors($errors);
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->flush();

        $request->session()->regenerate();

        return redirect(route('index')) -> with('success', 'You\'ve signed out.');
    }
}
