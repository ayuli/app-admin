<table width="100%" id="attrTable">
    <tbody>
    @foreach($attrInfo as $key=>$val)
    @if($val->attr_type==0 && $val->attr_input_type== 0)
    <tr>
        <td class="label">{{$val->attr_name}}</td>
        <td>
            <input name="attr_value_list[{$val.attr_id}]" type="text" size="40">
        </td>
    </tr>
    @endif
    @if($val->attr_type == 0 && $val->attr_input_type == 1)
    <tr><td class="label">{{$val->attr_name}}</td><td>
            <select name="attr_value_list[{{$val->attr_id}}]">
                <option value="">请选择...</option>
                @foreach($val->attr_values as $k=>$v)
`               @if(!empty($v))
                <option value="{{$v}}">{{$v}}</option>
                @endif
                @endforeach
            </select>
    </tr>
    @endif
    @if($val->attr_type == 1 && $val->attr_input_type == 0 )
    <tr><td class="label">
            <a href="javascript:;" onclick="addSpec(this)">[+]</a>{{$val->attr_name}}
        </td>
        <td>
            <input name="attr_value_list[{$val.attr_id}][]" type="text" size="40">
            属性价格 <input type="text" name="attr_price_list[{$val.attr_id}][]" size="5" maxlength="10">
        </td>
    </tr>
    @endif
    @if($val->attr_type == 1 && $val->attr_input_type == 1 )
    <tr><td class="label">
            <a href="javascript:;" onclick="addSpec(this)">[+]</a>{{$val->attr_name}}</td>
        <td>
            <select name="attr_value_list[{$val.attr_id}][]">
                <option value="">请选择...</option>
                @foreach($val->attr_values as $k=>$v)
    `               @if(!empty($v))
                        <option value="{{$v}}">{{$v}}</option>
                    @endif
                @endforeach
            </select> 属性价格
            <input type="text" name="attr_price_list[{$val.attr_id}][]" value="" size="5" maxlength="10">
        </td>
    </tr>
    @endif

    @endforeach
    </tbody>
</table>


