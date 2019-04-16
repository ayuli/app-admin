<link rel="stylesheet" type="text/css" href="css/goods.css" />
<link rel="stylesheet" href="layui/css/layui.css"  media="all">
<script type="text/javascript" charset="utf-8" src="ueditor/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="ueditor/ueditor.all.min.js"> </script>
<!--建议手动加在语言，避免在ie下有时因为加载语言失败导致编辑器加载失败-->
<!--这里加载的语言文件会覆盖你在配置项目里添加的语言类型，比如你在配置项目里配置的是英文，这里加载的中文，那最后就是中文-->
<script type="text/javascript" charset="utf-8" src="ueditor/lang/zh-cn/zh-cn.js"></script>
<script type="text/javascript" charset="utf-8" src="js/jquery.min.js"></script>
<script src="layui/layui.js" charset="utf-8"></script>
<script type="text/javascript" src="js/ajaxfileupload.js"></script>
<!--  <div style="padding: 15px;"><h3>商品管理</h3></div> -->
<hr/>
<style>
    *{
        font-size: 12px;
    }
</style>
<script type="text/javascript">
    $(function () {
        window.onload = function ()
        {
            var $li = $('#tab li');
            var $ul = $('.condiv');

            $li.click(function () {
                var $this = $(this);
                var $t = $this.index();
                //	alert($t);
                $li.removeClass();
                $this.addClass('current');
                $ul.css('display', 'none');
                $ul.eq($t).css('display', 'block');
                if( $t==1 ){
                    $('#editordiv div').css('display', 'block');
                    $('#edui1_toolbarmsg').css('display','none');
                }
            });
        }
    });
    //console.log($("span").parents().text());

</script>
<style>
    .label {color:#333;}
</style>


<div id="pageAll">

    <div class="page ">
        <!-- 会员注册页面样式 -->
        <form class="form-inline">
            <div class="banneradd bor">
                <ul id="tab">
                    <li class="current">商品基本信息</li>
                    <li>详细描述</li>
                    <li>商品属性</li>
                    <li>轮播图</li>
                </ul>
                <div id="content">
                    <!-- 通用信息 start-->
                    <div class="condiv" style="display:block">
                        <div class="layui-form-item">
                            <table  id="general-table"  >
                                <tbody>
                                <tr>
                                    <td class="label">商品名称：</td>
                                    <td><input type="text" name="goods_name"  size="30" class="layui-input"><span class="require-field">*</span></td>
                                </tr>

                                <tr>
                                    <td class="label">商品分类：</td>
                                    <td>

                                        <select name="cate_id" class="form-control">
                                            <option value="0">--请选择--</option>
                                            @foreach($cateInfo as $v)
                                                <option value="{{$v['cate_id']}}">{{$v['level']}}{{$v['cate_name']}}</option>
                                            @endforeach
                                        </select>

                                    </td>
                                </tr>
                                <tr>
                                    <td class="label">商品品牌：</td>
                                    <td>
                                        <select name="brand_id" class="form-control" >
                                            <option value="0">请选择...</option>
                                            @foreach($brandInfo as $k=>$v)
                                            <option value="{{$v->brand_id}}">{{$v->brand_name}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="label">商品价格：</td>
                                    <td><input type="text" name="goods_price"  size="20"  class="layui-input">

                                        <span class="require-field">*</span></td>
                                </tr>

                                <tr>
                                    <td class="label">商品积分：</td>
                                    <td><input type="text" name="goods_score"  size="20"  class="layui-input">

                                        <span class="require-field">*</span></td>
                                </tr>

                                <tr>
                                    <td class="label">商品库存数量：</td>
                                    <!--            <td><input type="text" name="goods_number" value="4" size="20" readonly="readonly" /><br />-->
                                    <td><input type="text" name="goods_number"  size="20" class="layui-input"><br>
                                        <span class="notice-span" style="display:block" id="noticeStorage"></span></td>
                                </tr>

                                <tr>
                                    <td class="label">加入推荐：</td>
                                    <td><input type="checkbox" name="is_best" value="1" checked="checked">精品 <input type="checkbox" name="is_new" value="1" checked="checked">新品 <input type="checkbox" name="is_hot" value="1" checked="checked">热销</td>
                                </tr>
                                <tr id="alone_sale_1">
                                    <td class="label" id="alone_sale_2">上架：</td>
                                    <td id="alone_sale_3"><input type="checkbox" name="is_show" value="1" checked="checked"> 打勾表示允许销售，否则不允许销售。</td>
                                </tr>

                                <tr>
                                    <td class="label">上传商品图片：</td>
                                    <td>
                                        <input type="file" id="file" name="goods_img" onchange="upload(this)" size="35" >
                                    </td>
                                </tr>
                                </tbody></table>

                        </div>
                    </div>
                    <!-- 通用信息 end-->
                    <!-- 编辑器详细信息 start-->
                    <div class="condiv" id="editordiv" style="display: none">
                        <script id="editor" type="text/plain" name="goods_desc" style="width:1024px;height:500px;"></script>
                        </div>
                        <!-- 编辑器详细信息 end-->
                        <!-- 其他信息 start-->


                            <!-- 其他信息 end-->
                            <!-- 商品属性start -->
                            <div class="condiv" style="display: none">

                            <!-- 商品属性 -->
                            <table id="properties-table" >
                            <tbody>
                            <tr>
                            <td class="label">商品类型：</td>
                        <td>
                        <select class='form-control goods_type' name="type_id" >
                            <option value="0">请选择商品类型</option>
                                @foreach($typeInfo as $k=>$v)
                                    <option value="{{$v->type_id}}">{{$v->type_name}}</option>
                                @endforeach
                        </select><br>
                        <span class="notice-span" style="display:block" id="noticeGoodsType">请选择商品的所属类型，进而完善此商品的属性</span>
                        </td>
                        </tr>
                        <tr>
                        <td id="tbody-goodsAttr" colspan="2" style="padding:0">

                            </td>
                            </tr>
                            </tbody>
                            </table>

                            </div>
                            <!-- 商品属性 end -->
                            <!-- 商品相册start -->
                            <div class="condiv" style="display: none">
                            <table id="gallery-table" >
                            <tbody>
                            <!--              <tr>
                            <td>
                            <div id="gallery_41" style="float:left; text-align:center; border: 1px solid #DADADA; margin: 4px; padding:2px;">
                            <a href="javascript:;" onclick="if (confirm('您确实要删除该图片吗？')) dropImg('41')">[-]</a><br>
                            <a href="goods.php?act=show_image&amp;img_url=images/200905/goods_img/32_P_1242110760641.jpg" target="_blank">
                            <img src="../images/200905/thumb_img/32_thumb_P_1242110760997.jpg" width="100" height="100" border="0">
                            </a><br>
                            <input type="text" value="" size="15" name="old_img_desc[41]">
                            </div>
                            </td>
                            </tr>-->
                            <tr><td>&nbsp;</td></tr>
                        <tr>
                        <td>
                        <a href="javascript:;" onclick="addUpload(this)">[+]</a>
                            <input type="file" id='1' name="goods_imgs[]" onchange="upload(this)">

                            </td>
                            </tr>
                            </tbody></table>


                        </div>
                        <!--商品相册 end-->
                        </div>

                        <div class="goods_img"></div>

                        </form>

                        <p align="left" style='margin-left:250px;'>
                                <input type='button' value='提交' class='button_ok'>
                            </p>

                            </div>
                            </div>
                            <script type="text/javascript">
                            var ue = UE.getEditor('editor');

                            $(document).on('change','.goods_type',function(){
                                var type_id = $(this).val();
                                var url="changeType";
                                var data={};
                                data.type_id=type_id;
                                if( type_id ){
                                    $.ajax({
                                        type: "get",
                                        url: url,
                                        data: data,
                                        success: function(msg){
                                            $('#tbody-goodsAttr').html(msg);
                                        }
                                    });
                                }
                            });

                            //追加一行
                            var num=1;
                            function addUpload(obj){
                                num+=1;

                                var newtr="<tr>\n" +
                                    "                        <td>\n" +
                                    "                        <a href=\"javascript:;\" onclick=\"lessSpec(this)\">[ - ]</a>\n" +
                                    "                            <input type=\"file\" id='"+num+"' name=\"goods_imgs[]\" onchange=\"upload(this)\">\n" +
                                    "                            </td>\n" +
                                    "                            </tr>";

                                $(obj).parent().parent().after(newtr);
                            }

                            function addSpec(obj){
                                var newtr=$(obj).parent().parent().clone();
                                newtr.find('a').text('[ - ]');
                                newtr.find('a').attr('onclick','lessSpec(this)');
                                $(obj).parent().parent().after(newtr);
                            }

                            //减一行
                            function lessSpec(obj){
                                $(obj).parent().parent().remove();
                            }

                        </script>
                        <script>

                            function upload(obj){
                                var _this=$(obj);
                                var id=$(obj).attr('id');

                                var fileInfo=document.getElementById(id).files[0];


                                var form = new FormData();//表单对象
                                form.append("file",fileInfo,fileInfo.name);
                                $.ajax({
                                    type : "post",
                                    data : form,
                                    url : "goodsUpload",
                                    processData : false,
                                    contentType : false,
                                    cache : false,
                                    dataType : "json",
                                    async : true,
                                    success : function( res ){
                                        if(isNaN(id)) {
                                            _this.after("<img src='"+ res.filename +"' width='100px' height='50px'>");
                                            $(".goods_img").append("<input type='hidden' name='goods_img'  value='" + res.filename + "'>");
                                        }else{
                                            $(".goods_img").append("<input type='hidden' name='goods_imgs["+id+"]'  value='" + res.filename + "'>");
                                            $("#"+id+"").parent().append("<img src='" + res.filename + "' width='100px' height='50px'>");

                                        }
                                    }
                                });
                            }
                            $(function(){



                                $(".button_ok").click(function(){
                                    var form=$(".form-inline").serialize();

                                    var url="goodsAddDo";
                                    $.ajax({
                                        url:url,
                                        type:'post',
                                        data:form,
                                        dataType:'json',
                                        success:function(res){
                                            alert(res.msg);
                                            if(res.code==1){
                                                location.href='goodsShow';
                                            }
                                        }
                                    });
                                });
                            })
                        </script>
