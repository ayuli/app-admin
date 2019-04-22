<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>广告添加-有点</title>
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
                <a href="#">广告管理</a>
                &nbsp;-
            </span>
            &nbsp;广告添加
        </div>
    </div>
    <div class="page ">
        <!-- 上传广告页面样式 -->
        <div class="banneradd bor">
            <div class="baTopNo">
                <span>广告添加</span>
            </div>
            <div class="baBody">

                <div class="bbD">
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;广告名称：
                    <input type="text" class="input3" id="name"/>
                </div>

                <div class="bbD" style="margin-left: 24px;">
                    广告图片：
                    <div class="bbDd">
                        <div class="bbDImg" >+</div>
                        <input type="file" style="cursor:pointer" class="file" id="file" name="file"/>
                    </div>
                </div>

                <div class="bbD">
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    是否前台展示：
                    <label>
                        <input type="radio" checked="checked" value="1" name="is_show"/>
                        &nbsp;是
                    </label>
                    <label>
                        <input type="radio" value="2" name="is_show" />
                        &nbsp;否
                    </label>
                </div>
                <div class="bbD">
                    <p class="bbDP">
                        <button class="btn_ok btn_yes" href="#" id="addbtn">提交</button>
                        <a class="btn_ok btn_no" href="#">取消</a>
                    </p>
                </div>
            </div>
        </div>

        <!-- 上传广告页面样式end -->
    </div>
</div>

<div class="banDel">
    <div class="delete">
        <div class="close">
            <a><img src="img/shanchu.png" /></a>
        </div>
        <p class="delP1"></p>
        <p class="delP2">
            <a href="#" class="ok yes">确定</a>
        </p>
    </div>
</div>

</body>
</html>
<script>
    $(".bbDd").change(function(){
        $.ajaxFileUpload({
            url: '/brandlogo',
            type: 'post',
            secureuri: false, //是否需要安全协议，一般设置为false
            fileElementId: 'file', //文件上传域的ID
            dataType: 'json',
            success: function (resule)
            {
                $(".bbDImg").html("<img src='"+resule+"'width='160px;' height='180px;' id='logo' style='cursor:pointer'>");
                // console.log(resule)
            }
        })
    })

</script>
<script>

    //点击删除
    $(".bbDDel").click(function(){
        $(".bbDImg").html('+')
    });

    $("#addbtn").click(function(){
        var logo = $("#logo").prop('src');
        var name = $("#name").val();
        $("[name='is_show']").each(function(){
                if($(this).prop('checked')==true){
                    is_show =$(this).val()
                }
        });

        var data = {};
        data.name = name;
        data.logo = logo;
        data.is_show = is_show;

        $.ajax({
            url : '/advadd',
            type: 'post',
            data : data,
            dataType: 'json',
            success: function(d){
                if(d.code==0){
                    // 广告弹出框
                    $(".banDel").show();
                    $(".delP1").text(d.msg);
                    $(".yes").click(function(){
                        $(".banDel").hide();
                        location.href='/adv'
                    });
                }else{
                    // 广告弹出框
                    $(".banDel").show();
                    $(".delP1").text(d.msg);
                    $(".yes").click(function(){
                        $(".banDel").hide();
                        location.href='/adv'
                    });
                }

            }
        })

    })

</script>