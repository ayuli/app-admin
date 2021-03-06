<link rel="stylesheet" href="layui/css/layui.css"  media="all">
<script src="layui/layui.js" charset="utf-8"></script>
<script type="text/javascript" charset="utf-8" src="js/jquery.min.js"></script>
<div style="padding: 15px;"><h3>属性管理</h3></div><hr/>

<form class="form-inline"  style="width:90%" >
    <div class="layui-form-item">
        <label class="layui-form-label">属性名称</label>
        <div class="layui-input-block">
            <input type="text" name="attr_name" value="" placeholder="请输入属性名称" autocomplete="off" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">所属商品类型</label>
        <div class="layui-input-block">
            <div class="layui-inline">

                <div class="layui-input-inline">
                    <select name="type_id" class="form-control">
                        <option value="0" >请选择所属商品类型</option>
                        @foreach($typeInfo as $k=>$v)
                        <option value="{{$v->type_id}}" @if(!empty(!empty($type_id)))  @if($v->type_id == $type_id ) selected @endif @endif >{{$v->type_name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">属性/规格</label>
        <div class="checkbox">
            <input type="radio" name="attr_type" value="0" title="属性"  class="layui-radio" checked="checked"> 属性
            <input type="radio" name="attr_type" value="1" title="规格"  class="layui-radio"> 规格
        </div>
    </div>


    <div class="layui-form-item layui-form-text">
        <label class="layui-form-label">录入方式</label>
        <div class="checkbox">
            <input type="radio" name="attr_input_type" value="0" title="手工录入"  class="layui-radio" onclick='changetextarea($(this))' checked="checked"> 手工录入
            <input type="radio" name="attr_input_type" value="1" title="从下面的列表中选择"  class="layui-radio" onclick='changetextarea($(this))'> 从下面的列表中选择
        </div>
    </div>
    <div class="form-group">
        <label class="layui-form-label">可选值 :</label>
        <textarea name="attr_values" class="form-control attr_values" rows="3" disabled="disabled"></textarea>
    </div>


    <div class="layui-form-item" style="margin-top:10px;">
        <div class="layui-input-block">
            <input type="button" class="layui-btn"  lay-filter="demo1" value="立即提交">
        </div>
    </div>
</form>

<script>

    function changetextarea(obj){
        var status = obj.val();
        if( status==1 ){
            $('.attr_values').removeAttr('disabled');
        }else{
            $('.attr_values').attr('disabled','disabled');
        }
    }

    $(function(){
        layui.use('layer', function() {
            var layer = layui.layer;



            $(".layui-btn").click(function(){
                var form=$(".form-inline").serialize();

                var url="attrAddDo";

                $.post(url,form,function(res){

                    if(res.code==1){
                        layer.open({
                            type:0,
                            content:'添加成功',
                            btn:['确定'],
                            yes:function(index,layero){
                                location.href="attrShow?type_id="+res.type_id;
                                return true;
                            }
                        })
                    }else{
                        layer.msg(res.msg);
                    }
                },'json');
            });
        })
    })
</script>