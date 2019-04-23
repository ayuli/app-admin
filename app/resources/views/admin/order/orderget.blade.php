<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>订单管理-有点</title>
    <link rel="stylesheet" type="text/css" href="css/css.css" />
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <!-- <script type="text/javascript" src="js/page.js" ></script> -->
    <style type="text/css">
        #pull_right{
            text-align:center;
        }
        .pull-right {
            /*float: left!important;*/
        }
        .pagination {
            display: inline-block;
            padding-left: 0;
            margin: 20px 0;
            border-radius: 4px;
        }
        .pagination > li {
            display: inline;
        }
        .pagination > li > a,
        .pagination > li > span {
            position: relative;
            float: left;
            padding: 6px 12px;
            margin-left: -1px;
            line-height: 1.42857143;
            color: #428bca;
            text-decoration: none;
            background-color: #fff;
            border: 1px solid #ddd;
        }
        .pagination > li:first-child > a,
        .pagination > li:first-child > span {
            margin-left: 0;
            border-top-left-radius: 4px;
            border-bottom-left-radius: 4px;
        }
        .pagination > li:last-child > a,
        .pagination > li:last-child > span {
            border-top-right-radius: 4px;
            border-bottom-right-radius: 4px;
        }
        .pagination > li > a:hover,
        .pagination > li > span:hover,
        .pagination > li > a:focus,
        .pagination > li > span:focus {
            color: #2a6496;
            background-color: #eee;
            border-color: #ddd;
        }
        .pagination > .active > a,
        .pagination > .active > span,
        .pagination > .active > a:hover,
        .pagination > .active > span:hover,
        .pagination > .active > a:focus,
        .pagination > .active > span:focus {
            z-index: 2;
            color: #fff;
            cursor: default;
            background-color: #428bca;
            border-color: #428bca;
        }
        .pagination > .disabled > span,
        .pagination > .disabled > span:hover,
        .pagination > .disabled > span:focus,
        .pagination > .disabled > a,
        .pagination > .disabled > a:hover,
        .pagination > .disabled > a:focus {
            color: #777;
            cursor: not-allowed;
            background-color: #fff;
            border-color: #ddd;
        }
        .clear{
            clear: both;
        }
    </style>
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
            &nbsp;订单展示
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
            <div class="conShow">
                <table border="1" cellspacing="0" cellpadding="0">
                    <tr>
                        <td width="66px" class="tdColor tdC">序号</td>
                        <td width="355px" class="tdColor">订单号</td>
                        <td width="355px" class="tdColor">用户</td>
                        <td width="275px" class="tdColor">支付状态</td>
                        <td width="275px" class="tdColor">支付平台</td>
                        <td width="275px" class="tdColor">操作</td>
                    </tr>
                    @foreach($data as $v)
                    <tr barnd_id="">
                        <td height="60px;">{{$v['order_id']}}</td>
                        <td>{{$v['order_sn']}}</td>
                        <td>{{$v['user_name']}}</td>
                        <td>
                            @if($v['is_pay']==1)
                                已支付
                            @elseif($v['is_pay']==2)
                                未支付
                            @endif
                        </td>
                        <td>
                            @if($v['pay_way']==1)
                                微信
                            @else
                                支付宝
                            @endif</td>
                        <td><a href="/orderdetails?order_id={{$v['order_id']}}">点击查看详情</a></td>

                    </tr>
                    @endforeach
                </table>
                <div class="paging">
                    <div id="pull_right">
                        <div class="pull-right">
                            {!! $data->render() !!}
                        </div>
                    </div>
                </div>
            </div>
            <!-- banner 表格 显示 end-->
        </div>
        <!-- banner页面样式end -->
    </div>

</div>

</body>

<script type="text/javascript">

</script>
</html>