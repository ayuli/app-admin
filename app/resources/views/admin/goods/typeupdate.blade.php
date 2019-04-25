<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>管理员添加-有点</title>
    <link rel="stylesheet" type="text/css" href="css/css.css" />
    <link rel="stylesheet" href="layui/css/layui.css">
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script src="layui/layui.js"></script>
    <script type="text/javascript" src="layui/layui.js"></script>
    <script type="text/javascript" src="js/ajaxfileupload.js"></script>
</head>
<body>
<div id="pageAll">
    <div class="pageTop">
        <div class="page">
            <img src="img/coin02.png" />
            <span>
                <a href="#">首页</a>
                &nbsp;-&nbsp;
                <a href="#">类型管理</a>
                &nbsp;-
            </span>
            &nbsp;类型修改
        </div>
    </div>
    <div class="page ">
        <!-- 上传广告页面样式 -->
        <div class="banneradd bor">
            <div class="baTopNo">
                <span>类型修改</span>
            </div>
            <div class="baBody">

                <div class="bbD">
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;类型名称：<input type="text" name="type_name" value="{{$typeinfo->type_name}}" id="rolename" class="input3" />
                </div>
                <br>
                <input type="hidden" id="typeid" value="{{$typeinfo->type_id}}">
                <div class="bbD">
                    <br>
                    <p class="bbDP">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <button class="layui-btn layui-btn-lg layui-btn-normal" id="btn">修改</button>
                        <a href="typeList"><button class="layui-btn layui-btn-primary layui-btn-lg">取消</button></a>
                    </p>
                </div>
                <br>
                <br>
                <br>
            </div>
        </div>

        <!-- 上传广告页面样式end -->
    </div>
</div>
</body>
</html>

<script>
    layui.use('layer', function() {
        var layer = layui.layer;
        $('#btn').click(function(){
            var type_name = $("input[name='type_name']").val();
            var typeid = $('#typeid').val();


            $.post(
                'typeUpdateDo',
                {type_name:type_name,typeid:typeid},
                function(res){
                    if(res.code==0){
                        layer.open({
                            type:0,
                            content:'修改成功',
                            btn:['返回列表','继续修改'],
                            btn1:function(){
                                location.href="typeList";
                                return true;
                            },
                            btn2:function(){
                                return true;
                            }

                        })
                    }else if(res.code==1){
                        layer.msg(res.msg)
                    }else{
                        layer.msg(res.msg)
                    }

                },'json'
            )
        })
    })
</script>