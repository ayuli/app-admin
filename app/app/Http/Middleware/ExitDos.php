<?php

namespace App\Http\Middleware;

use Closure;

class ExitDos
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
        $objredis = new \Redis();
        $objredis->connect('127.0.0.1',6379);
        $ipaddr = $_SERVER['REMOTE_ADDR'];
        $num = $objredis->get($ipaddr);
        if($num >20){
            echo '调用次数太过频繁';
        }else{
            $num = $num+1;
            $time = 3600;
            $objredis->set($ipaddr,$num,$time);
        }
    }
}
