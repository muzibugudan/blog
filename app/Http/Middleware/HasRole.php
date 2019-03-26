<?php

namespace App\Http\Middleware;


use App\Model\Permission;
use App\Model\User;
use Closure;

class HasRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
//        获取当前请求的路由 对应的控制器的方法名
//        "App\Http\Controllers\Admin\LoginController@index"
            $route=\Route::current()->getActionName();
//            dd($route);
//        获取当前用户的权限组
            $user=User::find(session()->get('user')->user_id);
//         获取当亲用户的角色组
           $roles=$user->role;
//        dd($roles);
        $arr=[];
//        存放权限对应的per_url值
//         根据用户拥有的角色找权限
            foreach ($roles as $v){
                $perms=$v->permission;
                foreach ($perms as $n){
                    $arr[]=$n->per_url;
                }
            }
//            除去重复的权限
                $arr= array_unique($arr);
//            dd($arr);
//            判断当前请求的路由是否在对应的数组中

        if(in_array($route,$arr)){
            return $next($request);
        }else{
            return redirect('noaccess');
        }

    }
}
