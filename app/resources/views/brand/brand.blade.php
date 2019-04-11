<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>品牌添加-有点</title>
    <link rel="stylesheet" type="text/css" href="css/css.css" />
    <script type="text/javascript" src="js/jquery.js"></script>
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
                <a href="#">商品管理</a>
                &nbsp;-
            </span>
            &nbsp;品牌添加
        </div>
    </div>
    <div class="page ">
        <!-- 上传广告页面样式 -->
        <div class="banneradd bor">
            <div class="baTopNo">
                <span>品牌添加</span>
            </div>
            <div class="baBody">

                <div class="bbD">
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;品牌名称：
                    <input type="text" class="input3" />
                </div>

                <div class="bbD" style="margin-left: 24px;">
                    品牌logo：
                    <div class="bbDd">
                        <div class="bbDImg">+
                            {{--<img src="img/userPICS.png" width="160px;" height="180px;">--}}
                        </div>
                        <input type="file" class="file" id="file" />
                    </div>
                </div>

                <div class="bbD">
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;品牌网址：
                    <input type="text" class="input3" />
                </div>

                <div class="bbD">
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    是否展示：
                    <label>
                        <input type="radio" checked="checked" name="styleshoice2" />
                        &nbsp;是
                    </label>
                    <label>
                        <input type="radio" name="styleshoice2" />
                        &nbsp;否
                    </label>
                </div>
                <div class="bbD">
                    <p class="bbDP">
                        <button class="btn_ok btn_yes" href="#" >提交</button>
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
    $("#file").change(function() {

        $.ajaxFileUpload({
            type: 'post',
            url: '/brandlogo',
            secureuri: false, //是否需要安全协议，一般设置为false
            fileElementId: 'file', //文件上传域的ID
            dataType: 'json',
            success: function (resule)
            {
                console.log(resule)
            }
        })
    })

</script>