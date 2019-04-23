@foreach($info as $v)
    @if(in_array($v->node_id,$data))
        <input type="checkbox" name="like[write]"  node_id="{{$v->node_id}}"  title="{{$v->node_name}}">
        <div class="layui-unselect layui-form-checkbox layui-form-checked" lay-skin>
            <span class="{{$names}}">{{$v->node_name}}</span>
            <i class="layui-icon {{$names}}" ></i>
        </div>
    @else
        <input type="checkbox" name="like[write]"  node_id="{{$v->node_id}}"  title="{{$v->node_name}}">
        <div class="layui-unselect layui-form-checkbox" lay-skin>
            <span class="{{$names}}">{{$v->node_name}}</span>
            <i class="layui-icon {{$names}}" ></i>
        </div>
    @endif
@endforeach

<script>
    $(function(){
//        alert(12345)
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