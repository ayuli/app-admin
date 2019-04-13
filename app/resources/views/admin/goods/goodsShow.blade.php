<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>商品管理-有点</title>
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
                        <td width="66px" class="tdColor tdC">id</td>
                        <td width="355px" class="tdColor">商品名称</td>
                        <td width="260px" class="tdColor">商品分类</td>
                        <td width="275px" class="tdColor">商品品牌</td>
                        <td width="290px" class="tdColor">商品价格</td>
                        <td width="290px" class="tdColor">是否精品</td>
                        <td width="290px" class="tdColor">是否新品</td>
                        <td width="290px" class="tdColor">是否热卖</td>
                        <td width="130px" class="tdColor">操作</td>
                    </tr>
                    @foreach($goods_info as $k=>$v)
                        <tr goods_id="{{$v->goods_id}}">
                            <td>{{$v->goods_id}}</td>
                            <td>
                                {{$v->goods_name}}
                            </td>
                            <td>
                                {{$v->cate_name}}
                            </td>
                            <td>
                                {{$v->brand_name}}
                            </td>
                            <td>
                                {{$v->goods_price}}
                            </td>
                            <td>
                                {{$v->is_best}}
                            </td>
                            <td>
                                {{$v->is_hot}}
                            </td>
                            <td>
                                {{$v->is_new}}
                            </td>
                            <td>
                                <a href="/goodsUpdate?goods_id={{$v->goods_id}}">
                                    <img class="operation" src="img/update.png">
                                </a>
                                <img class="operation delban" src="img/delete.png">
                            </td>
                        </tr>
                    @endforeach
                </table>
                <div class="paging">
                    <div id="pull_right">
                        <div class="pull-right">
                            {{--{!! $goods_info->render() !!}--}}
                        </div>
                    </div>
                </div>
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
            <a class="ok yes" id="yes">确定</a><a class="ok no">取消</a>
        </p>
    </div>
</div>
<!-- 删除弹出框  end-->
</body>

<script type="text/javascript">
    // 广告弹出框
    $(".delban").click(function(){
        _barnd_id= $(this).parents('tr').attr('barnd_id')
        $(".banDel").show();

        $("#yes").click(function(){

            var brand_id=_barnd_id;
            $.ajax({
                url : '/branddel',
                type: 'post',
                data : {brand_id:brand_id},
                dataType: 'json',
                success: function(d){
                    if(d.code==0){
                        // 广告弹出框
                        $(".banDel").show();
                        $(".delP1").text(d.msg);
                        $(".delP2").html("<a class='ok no'>确定</a>");
                        $(".no").click(function(){
                            $(".banDel").hide();
                            location.href='/brandget'
                        });
                    }else{
                        // 广告弹出框
                        $(".banDel").show();
                        $(".delP1").text(d.msg);
                        $(".delP2").html("<a class='ok no'>确定</a>");
                        $(".no").click(function(){
                            $(".banDel").hide();
                            location.href='/brandget'
                        });
                    }
                }
            })

        });
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