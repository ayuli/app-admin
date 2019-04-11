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
            &nbsp;管理员展示
        </div>
    </div>
    <div class="page ">
        <!-- 上传广告页面样式 -->
        {{--<div class="banneradd bor">--}}
            <div class="baTopNo">
                <span>管理员展示</span>
            </div>
            <div class="baBody">

                <table border="1" cellspacing="0" cellpadding="0">
                    <tr>
                    <tr>
                        <td width="66px" class="tdColor tdC">序号</td>
                        <td width="355px" class="tdColor">管理员名称</td>
                        <td width="260px" class="tdColor">管理员邮箱</td>
                        <td width="275px" class="tdColor">管理员电话</td>
                        <td width="275px" class="tdColor">添加时间</td>
                        <td width="130px" class="tdColor">操作</td>
                    </tr>
                    </tr>
                    @foreach($admininfo as $v)
                        <td class="abc">{{$v->admin_id}}</td>
                        <td class="abc">{{$v->admin_name}}</td>
                        <td>{{$v->admin_email}}</td>
                        <td>{{$v->admin_tel}}</td>
                        <td><?php echo date("Y-m-d H:i:s",$v->create_time)?></td>
                        <td admin_id={{$v->admin_id}}>
                            <a href="adminUpdate?admin_id={{$v->admin_id}}}"><img class="operation" src="img/update.png"></a>
                            <img class="operation delban" src="img/delete.png">
                        </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>

        <!-- 上传广告页面样式end -->
    {{--</div>--}}
</div>
</body>
</html>

<script>
        $('.delban').click(function(){
//            alert(111)
            var admin_id = $(this).parent().attr('admin_id');
            $.post(
                'adminDel',
                {admin_id:admin_id},
                function(res){
                    console.log(res);
                }
            ),'json'
        })
</script>