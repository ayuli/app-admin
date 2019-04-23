<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>订单管理-有点</title>
    <link rel="stylesheet" type="text/css" href="css/css.css" />
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <!-- <script type="text/javascript" src="js/page.js" ></script> -->

</head>

<body>
<div id="pageAll">
    <div class="pageTop">
        <div class="page">
            <img src="img/coin02.png" />
            <span>
                <a href="#">首页</a>
                &nbsp;-&nbsp;
                <a href="#">订单管理</a>
                &nbsp;-
            </span>
            &nbsp;订单详情
        </div>
    </div>

    <div class="page">
        <!-- banner页面样式 -->
        <div class="connoisseur">
            <div class="conform">
                <form>
                    <div class="cfD">
                        <input class="addUser" type="text" placeholder="输入用户名/ID/手机号/城市" />
                        <button class="button">搜索</button>
                    </div>
                </form>
            </div>
            <!-- banner 表格 显示 -->
            @foreach($data as $v)
            <div class="conShow" style="float: left; margin-left: 20px;">
                <table border="1" cellspacing="0" cellpadding="0">
                    <tr>
                        <td width="120px" class="tdColor">订单号</td>
                        <td width="340px">{{$v['order_sn']}}</td>
                    </tr>
                    <tr>
                        <td width="100px" class="tdColor">用户</td>
                        <td>{{$v['user_name']}}</td>
                    </tr>
                    <tr>
                        <td width="100px" class="tdColor">购买商品</td>
                        <td>{{$v['goods_name']}}</td>
                    </tr>
                    <tr>
                        <td width="100px" class="tdColor">商品图片</td>
                        <td><img src="{{$v['goods_img']}}" style="margin: 2px 2px 2px 2px" width="100px" height="100px" alt=""></td>
                    </tr>
                    <tr>
                        <td width="100px" class="tdColor">购买数量</td>
                        <td>{{$v['buy_number']}}</td>
                    </tr>
                    <tr>
                        <td width="100px" class="tdColor">商品价格</td>
                        <td>{{$v['goods_price']}}￥</td>
                    </tr>
                    <tr>
                        <td width="100px" class="tdColor">添加时间</td>
                        <td>{{date('Y-m-d H:i:s',$v['add_time'])}}</td>
                    </tr>
                    <tr>
                        <td width="100px" class="tdColor">支付状态</td>
                        <td>@if($v['is_pay']==1)
                                已支付
                            @elseif($v['is_pay']==2)
                                未支付
                            @endif</td>
                    </tr>
                    <tr>
                        <td width="100px" class="tdColor">支付平台</td>
                        <td>@if($v['pay_way']==1)
                                微信
                            @else
                                支付宝
                            @endif</td>
                    </tr>

                </table>
            </div>
            @endforeach

            <!-- banner 表格 显示 end-->
        </div>
        <!-- banner页面样式end -->
    </div>

</div>
<div style="margin-bottom:60px; "></div>

</body>

<script type="text/javascript">

</script>
</html>