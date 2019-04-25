<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\DB;
class AdminRole
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
        $admin_id = $request->session()->get('admin_id');
        if(!empty($admin_id)){
            $route = $request->path();
            $role_data = DB::table('app_admin_role')->join('app_role','app_admin_role.role_id','=','app_role.role_id')->where('admin_id',$admin_id)->first();
            if(empty($role_data)){
                echo '您未拥有该权限';exit;
            }
            $role_id = $role_data->role_id;
            $node_data = DB::table('app_role_node')->join('app_node','app_role_node.node_id','=','app_node.node_id')->where('role_id',$role_id)->get();

            $action_name = [];
            foreach($node_data as $v){
                $action_name[] =$v->action_name;
            }

            if(in_array($route,$action_name)){
                return $next($request);
            }
            echo "您没有权限";exit;
        }

        echo '<a href="adminLogin" target="_top">未登录,点击登录</a>';exit;
//        return $next($request);
    }
}
