<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>登录-有点</title>
    <link rel="stylesheet" type="text/css" href="css/public.css" />
    <link rel="stylesheet" type="text/css" href="css/page.css" />
    <link rel="stylesheet" href="layui/css/layui.css"  media="all">
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/public.js"></script>
</head>
<body>

<!-- 登录页面头部 -->
<div class="logHead">
    <img src="img/logLOGO.png" />
</div>
<!-- 登录页面头部结束 -->

<!-- 登录body -->
<div class="logDiv">
    <img class="logBanner" src="img/logBanner.png" />
    <div class="logGet">
        <!-- 头部提示信息 -->
        <div class="logD logDtip">
            <p class="p1">登录</p>
            <p class="p2">有点人员登录</p>
        </div>
        <!-- 输入框 -->
        <div class="lgD">
            <img class="img1" src="img/logName.png" />
            <input type="text" name="admin_name" placeholder="输入用户名" />
        </div>
        <div class="lgD">
            <img class="img1" src="img/logPwd.png" />
            <input type="password" name="admin_pwd" placeholder="输入用户密码" />
        </div>
        <div class="lgD logD2">
            <input class="getYZM" type="text" name="code" />
            <div class="logYZM">
                <img src="{{ URL('codeImg/1') }}" name="codeImg" alt="验证码" title="刷新图片" width="100" height="40" id="c2c98f0de5a04167a9e427d883690ff6" border="0">
            </div>
        </div>
        <div class="logC">
            <button>登 录</button>
        </div>
    </div>
</div>
<!-- 登录body  end -->

<!-- 登录页面底部 -->
<div class="logFoot">
    <p class="p1">版权所有：南京设易网络科技有限公司</p>
    <p class="p2">南京设易网络科技有限公司 登记序号：苏ICP备11003578号-2</p>
</div>
<!-- 登录页面底部end -->
</body>
</html>
<script src="layui/layui.js" charset="utf-8"></script>
<script>
    $(function() {
        layui.use('layer', function () {
            var layer = layui.layer;

            //点击登录
            $(".logC").click(function () {
                var code = $("[name='code']").val();
                var admin_name = $("[name='admin_name']").val();
                var admin_pwd = $("[name='admin_pwd']").val();
                var url = "adminLoginDo";
                var data = {};
                data.admin_name = admin_name;
                data.admin_pwd = admin_pwd;
                data.code = code;
                $.post(url, data, function (res) {
                    if (res.code == 1) {
                        layer.alert(res.msg,function(index){
                            location.href = 'index';
                        });
                    }else{
                        layer.alert(res.msg);
                    }
                }, 'json');
            });

            //点击刷新图片
            $("[name='codeImg']").click(function () {
                $url = "{{ URL('codeImg') }}";
                $url = $url + "/" + Math.random();
                document.getElementById('c2c98f0de5a04167a9e427d883690ff6').src = $url;
            });

        })
    });
</script>