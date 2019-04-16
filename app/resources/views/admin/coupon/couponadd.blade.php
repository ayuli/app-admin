<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>优惠券添加-有点</title>
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
                <a href="#">优惠券管理</a>
                &nbsp;-
            </span>
            &nbsp;优惠券添加
        </div>
    </div>
    <div class="page ">
        <!-- 上传广告页面样式 -->
        <div class="banneradd bor">
            <div class="baTopNo">
                <span>优惠券添加</span>
            </div>
            <div class="baBody">
                <input type="hidden" name="goods_id" value="{{$goods_id}}">
                <div class="bbD">
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;优惠券名称：<input type="text" name="coupon_name" class="input3" />
                </div>
                <div class="bbD">
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;优惠券数量：<input type="text" name="coupon_num" class="input3" />
                </div>
                <div class="bbD">
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;优惠券价格：<input type="text" name="coupon_price" class="input3" />
                </div>
                <br>
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
            var coupon_name = $("input[name='coupon_name']").val();
            var coupon_num = $("input[name='coupon_num']").val();
            var coupon_price = $("input[name='coupon_price']").val();
            var goods_id = $("input[name='goods_id']").val();


            $.post(
                'couponInsert',
                {coupon_name:coupon_name,coupon_num:coupon_num,coupon_price:coupon_price,goods_id:goods_id},
                function(res){
                    if(res.code==0) {
                        layer.open({
                            type:0,
                            content:'添加成功',
                            btn:['添加完成'],
                            yes:function(index,layero){
                                location.href="goodsShow";
                                return true;
                            },
                        })
                    }else if(res.code==1){
                        layer.msg(res.msg);
                    }
                },'json'
            )
        })
    })

</script>