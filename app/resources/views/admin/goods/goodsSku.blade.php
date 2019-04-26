<script type="text/javascript" charset="utf-8" src="js/jquery.min.js"></script>
<link rel="stylesheet" href="css/css.css" />
<script src="layui/layui.js"></script>
<link rel="stylesheet" href="layui/css/layui.css"  media="all">

<style>
    input[type="checkbox"] { height:20px;width:20px; }
    tr{height: 40px;}
    td{text-align:center;}
</style>

<div class="list-div" style="margin-bottom: 5px; margin-top: 10px;" id="listDiv">
    <form name="addForm" id="addForm">
        <input type="hidden" name="goods_id" value="{{$goods_info->goods_id}}">
        <table width="100%" cellpadding="3" cellspacing="1" id="table_list" border="1">
            <tbody><tr>
                <th colspan="20" scope="col">商品名称：{{$goods_info->goods_name}}&nbsp;&nbsp;&nbsp;&nbsp;货号：{{$goods_info->goods_sn}}</th>
            </tr>
            <tr>
                <!-- start for specifications -->
                @foreach($attr_name as $k=>$v)
                <td scope="col" style="background-color: rgb(255, 255, 255);"><div align="center"><strong>{{$v}}</strong></div></td>
                @endforeach
                <!-- end for specifications -->
                <td class="label_2" style="background-color: rgb(255, 255, 255);">库存</td>
                <td class="label_2" style="background-color: rgb(255, 255, 255);">&nbsp;</td>
            </tr>
            @if(!empty($product_info))
            @foreach($product_info as $k=>$v)
            <tr>
                @foreach($v->goods_attr as $kk=>$vv)
                <td>{{$vv}}</td>
                @endforeach
                <td>{{$v->product_number}}</td>
            </tr>
            @endforeach
            @endif

            <tr id="attr_row">
                <!-- start for specifications_value -->
                @foreach($attr_values as $k=>$v)
                <td align="center">
                    <select name="attr[{{$k}}][]">
                        <option value="0" selected="">请选择...</option>
                        @foreach($v as $key=>$val)
                        <option value="{{$key}}">{{$val}}</option>
                        @endforeach
                    </select>
                </td>
                @endforeach
            <!-- end for specifications_value -->

                <td class="label_2"><input type="text" name="product_number[]" value="1" size="10"></td>
                <td><input type="button" class="button" value=" + " onclick="javascript:add_attr_product(this);"></td>
            </tr>

            <tr>
                <td align="center" colspan="6">
                    <input type="button" class="submit" value=" 保存 " >
                </td>
            </tr>
            </tbody></table>
    </form>

</div>
<script>
    //追加一行
    function add_attr_product(obj){
        var newtr=$(obj).parent().parent().clone();
        newtr.find('.button').val(" - ");
        newtr.find('.button').attr("onclick",'less_attr_product(this)');
        $(obj).parent().parent().after(newtr);
    }
    //减少一行
    function less_attr_product(obj){
        console.log($(obj));
        $(obj).parent().parent().remove();
    }
</script>
<script>
    $(function(){
        layui.use('layer', function() {
            var layer = layui.layer;
                $(".submit").click(function(){
                    var form=$("#addForm").serialize();

                    var url="productAddDo";
                    $.ajax({
                        url:url,
                        type:'post',
                        data:form,
                        dataType:'json',
                        success:function(res){
                            if(res.code==1){
                                layer.open({
                                    type:0,
                                    content:'保存成功',
                                    btn:['确定'],
                                    yes:function(index,layero){
                                        location.href='goodsShow';
                                        return true;
                                    }
                                })
                            }else{
                                layer.msg(res.msg);
                            }
                        }
                    });
                });
        });
    })
</script>

