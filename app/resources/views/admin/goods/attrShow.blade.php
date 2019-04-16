<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>管理员添加-有点</title>
    <link rel="stylesheet" href="layui/css/layui.css"  media="all">
    <link rel="stylesheet" type="text/css" href="css/css.css" />
    <script src="layui/layui.js"></script>
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/ajaxfileupload.js"></script>
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
                <a href="#">属性管理</a>
                &nbsp;-
            </span>
            &nbsp;属性展示
        </div>
    </div>
    <div class="page ">
        <!-- 上传广告页面样式 -->
        {{--<div class="banneradd bor">--}}
        <div class="baTopNo">
            <span>当前类型：{{$type_name}}</span>
            <a href="attrAdd?type_id={{$type_id}}" style="float: right;margin-top:10px;"><button class="layui-btn layui-btn-radius">属性添加</button></a>

        </div>
        <div class="baBody">

            <table border="1" cellspacing="0" cellpadding="0">
                <tr>
                    <td width="120px" class="tdColor tdC">序号</td>
                    <td width="400px" class="tdColor">属性名称</td>
                    <td width="400px" class="tdColor">录入方式</td>
                    <td width="400px" class="tdColor">可选值</td>
                    <td width="180px" class="tdColor">操作</td>
                </tr>
                </tr>
                @foreach($attrInfo as $v)
                <tr>
                    <td class="abc" height="60">{{$v->attr_id}}</td>
                    <td class="abc">🍖{{$v->attr_name}}</td>
                    <td></td>
                    <td>{{$v->attr_values}}</td>
                    <td attr_id={{$v->attr_id}}>
                        <a href="attrUpdate?attr_id={{$v->attr_id}}"><img class="operation" src="img/update.png"></a>
                        <img class="operation delban" src="img/delete.png">
                    </td>
                </tr>
                @endforeach
            </table>
        </div>
    </div>
    <div class="paging">
        <div id="pull_right">
            <div class="pull-right">
                {!! $attrInfo->render() !!}
            </div>
        </div>
    </div>
    <!-- 上传广告页面样式end -->
    {{--</div>--}}
</div>
</body>
</html>

<script>
    layui.use('layer', function() {
        var layer = layui.layer;
        $('.delban').click(function(){
            var _this = $(this);
            var attr_id = $(this).parent().attr('attr_id');
            layer.open({
                type:0,
                content: '是否确认删除？',
                btn:['确认','取消'],
                yes:function(index,layero){
                    $.get(
                        'attrDelete',
                        {attr_id:attr_id},
                        function(res){
                            console.log(res);
                            layer.msg(res.msg);
                            if(res.code==1){
                                _this.parents('tr').remove();
                            }
                        },'json'
                    )
                },
                btn2:function(){
//                    location.href="adminList";
                    return true;
                }
            })

        })
    })
</script>