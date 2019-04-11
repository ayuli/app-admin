<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>商品管理-有点</title>
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
                <a href="#">商品管理</a>
                &nbsp;-
            </span>
            &nbsp;品牌展示
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
                        <td width="355px" class="tdColor">品牌名称</td>
                        <td width="260px" class="tdColor">品牌logo</td>
                        <td width="275px" class="tdColor">品牌地址</td>
                        <td width="290px" class="tdColor">是否展示</td>
                        <td width="130px" class="tdColor">操作</td>
                    </tr>
                    @foreach($data as $v)
                    <tr>
                        <td>{{$v['brand_id']}}</td>
                        <td>
                            华莱士
                        </td>
                        <td>
                            <div style="margin-top: 25px;margin-bottom:25px;">
                            <img src="img/userPICS.png" width="75px;" height="75px;">
                            </div>
                        </td>
                        <td>
                            <a href="{{$v['site_url']}}" target="_blank">{{$v['site_url']}}</a>
                        </td>
                        <td>
                            @if($v['is_show']==1)
                            是
                            @elseif($v['is_show']==2)
                            否
                            @endif
                        </td>
                        <td>
                            <a href="connoisseuradd.html">
                                <img class="operation" src="img/update.png">
                            </a>
                            <img class="operation delban" src="img/delete.png">
                        </td>
                    </tr>
                    @endforeach
                </table>
                <div class="paging">此处是分页</div>
            </div>
            <!-- banner 表格 显示 end-->
        </div>
        <!-- banner页面样式end -->
    </div>

</div>


<!-- 删除弹出框 -->
<div class="banDel">
    <div class="delete">
        <div class="close">
            <a><img src="img/shanchu.png" /></a>
        </div>
        <p class="delP1">你确定要删除此条记录吗？</p>
        <p class="delP2">
            <a href="#" class="ok yes">确定</a><a class="ok no">取消</a>
        </p>
    </div>
</div>
<!-- 删除弹出框  end-->
</body>

<script type="text/javascript">
    // 广告弹出框
    $(".delban").click(function(){
        $(".banDel").show();
    });
    $(".close").click(function(){
        $(".banDel").hide();
    });
    $(".no").click(function(){
        $(".banDel").hide();
    });
    // 广告弹出框 end
</script>
</html>