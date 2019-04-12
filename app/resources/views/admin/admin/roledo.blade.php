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
            &nbsp;管理员添加
        </div>
    </div>
    <div class="page ">
        <!-- 上传广告页面样式 -->
        <div class="banneradd bor">
            <div class="baTopNo">
                <span>管理员添加</span>
            </div>
            <div class="baBody">

                <div class="bbD">
                    &nbsp;&nbsp;&nbsp;&nbsp;管理员名称：<input type="text" name="admin_name" value="{{$admininfo->admin_name}}" class="input3" />
                    <input type="hidden" name="admin_id" value="{{$admininfo->admin_id}}">
                </div>
                <br>
                <form  class="layui-form">
                    <div class="layui-inline">
                        <label class="layui-form-label"> 选择角色:</label>&nbsp;&nbsp;
                        <div class="layui-input-inline">
                            <select name="modules" class="selects" lay-verify="required" lay-search="">
                                <option value="">选择角色</option>
                                @foreach($roleinfo as $v)
                                    <option value="{{$v->role_id}}">{{$v->role_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </form>
                <div class="bbD">
                    <p class="bbDP">
                        <button class="btn_ok btn_yes" id="btn" href="#" >提交</button>
                        <a class="btn_ok btn_no" href="#">取消</a>
                    </p>
                </div>
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
            var role_id = $(".selects").val();
            var admin_id = $("input[name='admin_id']").val();


            $.post(
                'adminrole',
                {role_id:role_id,admin_id:admin_id},
                function(res){
                    if(res.code==0) {
                        layer.open({
                            type:0,
                            content:'添加成功',
                            btn:['确定'],
                            yes:function(index,layero){
                                location.href="adminList";
                                return true;
                            }
                        })
                    }else if(res.code==1){
                        layer.msg(res.msg);
                    }
                },'json'
            )
        })
    })

</script>