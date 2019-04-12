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
                <a href="#">管理员管理</a>
                &nbsp;-
            </span>
            &nbsp;角色添加
        </div>
    </div>
    <div class="page ">
        <!-- 上传广告页面样式 -->
        <div class="banneradd bor">
            <div class="baTopNo">
                <span>角色添加</span>
            </div>
            <div class="baBody">

                <div class="bbD">
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;角色名称：<input type="text" name="role_name" id="rolename" class="input3" />
                </div>
                <br>
                <form  class="layui-form">
                <div class="layui-form-item">
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;权限：
                    @foreach($roleinfo as $v)
                        <input type="checkbox" name="like[write]" node_id="{{$v->node_id}}"  title="{{$v->node_name}}">
                    @endforeach
                </div>
                </form>
                <div class="bbD">
                    <br>
                    <p class="bbDP">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <button class="layui-btn layui-btn-lg layui-btn-normal" id="btn">提交</button>
                        <button class="layui-btn layui-btn-primary layui-btn-lg">取消</button>
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
    layui.use(['layer','form'], function() {
        var layer = layui.layer;
        var form = layui.form;

    })
layui.use('layer', function() {
    var layer = layui.layer;
    $('#btn').click(function(){
        var data = [];
        var role_name = $("input[name='role_name']").val();
        $('.layui-unselect').each(function(){
            if($(this).hasClass("layui-form-checked")){
                data.push($(this).prev().attr('node_id'));
            }
        })
        var role_name= $('#rolename').val();

        $.post(
            'roleInsert',
            {data:data,role_name:role_name},
            function(res){
                if(res.code==0) {
                    layer.open({
                        type:0,
                        content:'添加成功',
                        btn:['继续添加','列表展示'],
                        yes:function(index,layero){
                            location.href="roleAdd";
                            return true;
                        },
                        btn2:function(){
                            location.href="roleList";
                            return true;
                        }
                    })
                }else{
                    layui.msg(res.msg)
                }
            },'json'
        )
    })
})
</script>