<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>权限添加-有点</title>
    <link rel="stylesheet" type="text/css" href="css/css.css" />
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
                <a href="#">权限管理</a>
                &nbsp;-
            </span>
            &nbsp;权限添加
        </div>
    </div>
    <div class="page ">
        <!-- 上传广告页面样式 -->
        <div class="banneradd bor">
            <div class="baTopNo">
                <span>权限添加</span>
            </div>
            <div class="baBody">

                <div class="bbD">
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;权限名称：<input type="text" name="node_name" class="input3" />
                </div>
                <div class="bbD">
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;方法名称：<input type="text" name="action_name" class="input3" />
                </div>
                <div class="bbD">
                    <p class="bbDP">
                        <button class="btn_ok btn_yes" id="btn" href="#" >提交</button>
                        <a class="btn_ok btn_no" href="nodeList">取消</a>
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
    layui.use('layer', function() {
        var layer = layui.layer;
        $('#btn').click(function(){
            var node_name = $("input[name='node_name']").val();
            var action_name = $("input[name='action_name']").val();

            $.post(
                'nodeInsert',
                {node_name:node_name,action_name:action_name},
                function(res){
                    if(res.code==0) {
                        layer.open({
                            type:0,
                            content:'添加成功',
                            btn:['继续添加','列表展示'],
                            yes:function(index,layero){
                                location.href="nodeAdd";
                                return true;
                            },
                            btn2:function(){
                                location.href="nodeList";
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