<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>管理员添加-有点</title>
    <link rel="stylesheet" type="text/css" href="css/css.css" />
    <script type="text/javascript" src="js/jquery.min.js"></script>
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
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;管理员名称：<input type="text" name="admin_name" value="{{$admininfo->admin_name}}" class="input3" />
                </div>
                <div class="bbD">
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;管理员邮箱：<input type="text" name="admin_email" value="{{$admininfo->admin_email}}" class="input3" />
                </div>
                <div class="bbD">
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;管理员电话：<input type="text" name="admin_tel" value="{{$admininfo->admin_tel}}" class="input3" />
                    <input type="hidden"  name="admin_id" value="{{$admininfo->admin_id}}">
                </div>
                <div class="bbD">
                    <p class="bbDP">
                        <button class="btn_ok btn_yes" id="btn" href="#" >修改</button>
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
    $('#btn').click(function(){
        var admin_name = $("input[name='admin_name']").val();
        var admin_id = $("input[name='admin_id']").val();
        var admin_email = $("input[name='admin_email']").val();
        var admin_tel = $("input[name='admin_tel']").val();


        $.post(
            'adminUpdataDo',
            {admin_name:admin_name,admin_id:admin_id,admin_email:admin_email,admin_tel:admin_tel},
            function(res){
                alert(res.msg);
            }
        ),'json'
    })

</script>