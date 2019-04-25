
@foreach($info as $v)
     <input type="hidden" name="like[write]"   node_id="{{$v->node_id}}"  title="{{$v->node_name}}">
        <div class="layui-unselect layui-form-checkbox " lay-skin>
            <span class="{{$names}}">{{$v->node_name}}</span>
            <i class="layui-icon {{$names}}" ></i>
        </div>
 @endforeach


<script>
    $(function(){
        var wwww="{{$names}}";
        $('.'+wwww+'').click(function(){
//            alert(123)
            if($(this).parent().hasClass("layui-form-checked")){
                $(this).parent().removeClass('layui-form-checked');
            }else{
                $(this).parent().addClass('layui-form-checked');
            }

        })
    })
</script>