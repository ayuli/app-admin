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
            &nbsp;角色修改
        </div>
    </div>
    <div class="page ">
        <!-- 上传广告页面样式 -->
        <div class="banneradd bor">
            <div class="baTopNo">
                <span>角色修改</span>
            </div>
            <div class="baBody">

                <div class="bbD">
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;角色名称：<input type="text" name="role_name" value="{{$roleinfo->role_name}}" id="rolename" class="input3" />
                </div>
                <br>
                <input type="hidden" id="roleid" value="{{$roleinfo->role_id}}">
                <form  class="layui-form">
                    <div class="layui-collapse"style="width:900px;" lay-filter="test">
                        <div class="layui-colla-item" style="width:900px;">
                            <h2 class="layui-colla-title  layui-bg-blue" name="管理员">管理员管理</h2>
                            <div class="layui-colla-content">
                            </div>
                        </div>
                        <div class="layui-colla-item"style="width:900px;">
                            <h2 class="layui-colla-title layui-bg-gray" name="角色">角色管理</h2>
                            <div class="layui-colla-content">

                            </div>
                        </div>
                        <div class="layui-colla-item"style="width:900px;">
                            <h2 class="layui-colla-title layui-bg-blue" name="权限">权限管理</h2>
                            <div class="layui-colla-content">

                            </div>
                        </div>
                        <div class="layui-colla-item"style="width:900px;">
                            <h2 class="layui-colla-title layui-bg-gray" name="品牌">品牌管理</h2>
                            <div class="layui-colla-content">
                            </div>
                        </div>
                        <div class="layui-colla-item"style="width:900px;">
                            <h2 class="layui-colla-title layui-bg-blue" name="分类">分类管理</h2>
                            <div class="layui-colla-content">
                            </div>
                        </div>
                        <div class="layui-colla-item"style="width:900px;">
                            <h2 class="layui-colla-title layui-bg-gray" name="订单">订单管理</h2>
                            <div class="layui-colla-content">
                            </div>
                        </div>
                        <div class="layui-colla-item"style="width:900px;">
                            <h2 class="layui-colla-title layui-bg-blue" name="广告">广告管理</h2>
                            <div class="layui-colla-content">
                            </div>
                        </div>
                        <div class="layui-colla-item"style="width:900px;">
                            <h2 class="layui-colla-title layui-bg-gray" name="优惠券">优惠券管理</h2>
                            <div class="layui-colla-content">
                            </div>
                        </div>
                    </div>
                </form>
                <div class="bbD">
                    <br>
                    <p class="bbDP">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <button class="layui-btn layui-btn-lg layui-btn-normal" id="btn">修改</button>
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
//    $(function(){
//        $('.layui-colla-title').each(function(){
////            return false;
//            var _this = $(this)
//            var names = _this.attr('name')
//            var role_id = $('#roleid').val();
//            $.ajax({
//                url:'roleUpdateNodeDo',
//                type:'post',
//                dataType:'json',
//                data:{names:names,role_id:role_id},
//                async:false,
//                success:function(msg){
//                    var name = msg.names;
//                    $('[name='+name+']').next().html(msg.data);
//                }
//            })
////            $.post(
////                'roleUpdateNodeDo',
////                {names:names,role_id:role_id},
////                function(res){
////                    var name = res.names;
////                    $('[name='+name+']').next().html(res.data);
////                },'json'
////            )
//        })
//    })
</script>


<script>
    layui.use(['element','layer','form'], function() {
        var element = layui.element;
        var layer = layui.layer;
        var form = layui.form;



        $(".layui-colla-title").click(function(){
            var _this = $(this)
            var names = _this.attr('name');
            var role_id = $('#roleid').val();
            $.post(
                'roleUpdateNodeDo',
                {names:names,role_id:role_id},
                function(res){
                    var name = res.names
//                    $('#'+name+'')
                    _this.next().html(res.data);
                },'json'
            )
        })

    })
    layui.use('layer', function() {
        var layer = layui.layer;
        $('#btn').click(function(){
            var role_name = $("input[name='role_name']").val();
            var role_id = $('#roleid').val();
            var data = [];
            $('.layui-unselect').each(function(){
                if($(this).hasClass("layui-form-checked")){
                    data.push($(this).prev().attr('node_id'));
                }
            })


            $.post(
                'roleUpdateDo',
                {data:data,role_name:role_name,role_id:role_id},
                function(res){
                    if(res.code==0){
                        layer.open({
                            type:0,
                            content:'修改成功',
                            btn:['返回列表','继续修改'],
                            btn1:function(){
                                location.href="roleList";
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
