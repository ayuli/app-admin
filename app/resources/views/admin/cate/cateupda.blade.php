<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>分类添加-有点</title>
    <link rel="stylesheet" type="text/css" href="css/css.css" />
    <link rel="stylesheet" href="/layui/css/layui.css">
    <script type="text/javascript" src="/js/jquery.min.js"></script>
    <script src="/layui/layui.js"></script>
</head>
<body>
<div id="pageAll">
    <div class="pageTop">
        <div class="page">
            <img src="img/coin02.png" />
            <span>
                <a href="#">首页</a>
                &nbsp;-&nbsp;
                <a href="#">商品分类管理</a>
                &nbsp;-
            </span>
            &nbsp;分类修改
        </div>
    </div>
    <div class="page ">
        <!-- 上传广告页面样式 -->
        <div class="banneradd bor">
            <div class="baTopNo">
                <span>分类修改</span>
            </div>
            <div class="baBody">

                <div class="bbD">
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;分类名称：
                    <input type="text" class="input3" id="name" value="{{$cate['cate_name']}}"/>
                </div>

                <div class="cfD">
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    父分类：
                    <select name="" id="p_id">
                        <option value="0">--请选择--</option>
                        @foreach($cateInfo as $v)
                            @if($cate['p_id']==$v['cate_id'])
                            <option value="{{$v['cate_id']}}" selected>{{$v['level']}}{{$v['cate_name']}}</option>
                            @else
                            <option value="{{$v['cate_id']}}">{{$v['level']}}{{$v['cate_name']}}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="bbD">
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    导航栏展示：
                    @if($cate['show_in_nav']==1)
                    <label><input type="radio" checked="checked" value="1" name="styleshoice2"/>&nbsp;是</label>
                    <label><input type="radio" value="2" name="styleshoice2" />&nbsp;否</label>
                    @else
                    <label><input type="radio" value="1" name="styleshoice2"/>&nbsp;是</label>
                    <label><input type="radio" checked="checked" value="2" name="styleshoice2" />&nbsp;否</label>
                    @endif
                </div>
                <div class="bbD">
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    前台展示：
                    @if($cate['is_show']==1)
                    <label><input type="radio" checked="checked" value="1" name="styleshoice3"/>&nbsp;是</label>
                    <label><input type="radio" value="2" name="styleshoice3" />&nbsp;否</label>
                    @else
                    <label><input type="radio" value="1" name="styleshoice3"/>&nbsp;是</label>
                    <label><input type="radio" checked="checked" value="2" name="styleshoice3" />&nbsp;否</label>
                    @endif
                </div>
                <div class="bbD">
                    <p class="bbDP">
                        <button class="btn_ok btn_yes" href="#" id="addbtn">修改</button>
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


    $("#addbtn").click(function(){
        var name = $("#name").val();
        var p_id = $("#p_id").val();
        var cate_id = "{{$cate['cate_id']}}";

        $("input[name=styleshoice2]").each(function(){
            if($(this).prop('checked')==true){
                nav = $(this).val()
            }
        });

        $("input[name=styleshoice3]").each(function(){
            if($(this).prop('checked')==true){
                show = $(this).val()
            }
        });

        var data = {};
        data.name = name;
        data.p_id = p_id;
        data.nav = nav;
        data.show = show;
        data.cate_id = cate_id;
        $.ajax({
            url : '/cateupdado',
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
                        location.href='/categet'
                    });
                }else{
                    // 广告弹出框
                    $(".banDel").show();
                    $(".delP1").text(d.msg);
                    $(".yes").click(function(){
                        $(".banDel").hide();
                        location.href='/categet'
                    });
                }

            }
        })

    })

</script>