@if(!empty($goods_attr))
    <table width="100%" id="attrTable">
        <tbody>
        @foreach($attrInfo as $key=>$val)
            @if($val->attr_type==0 && $val->attr_input_type== 0)
                <tr>
                    <td class="label">{{$val->attr_name}}</td>
                    <td>
                        <input name="attr_value_list[{{$val->attr_id}}]" <?php foreach($goods_attr as $kk=>$vv){ if("$val->attr_id" == $vv->attr_id ){ ?> value="<?php echo $vv->attr_value;?>" <?php } }?> type="text" size="40">
                    </td>
                </tr>
            @endif
            @if($val->attr_type == 0 && $val->attr_input_type == 1)
                <tr><td class="label">{{$val->attr_name}}</td><td>

                        <select name="attr_value_list[{{$val->attr_id}}]">
                            <option value="0">请选择...</option>
                            @foreach($val->attr_values as $k=>$v)
                `               @if(!empty($v))
                                    <option value="{{rtrim($v)}}"  <?php foreach($goods_attr as $kk=>$vv){  if( $val->attr_id == $vv->attr_id && rtrim($v) == rtrim($vv->attr_value) ){ echo "selected"; } }?> >{{$v}}</option>
                                @endif
                            @endforeach
                        </select>
                </tr>
            @endif
            @if($val->attr_type == 1 && $val->attr_input_type == 0 )
                <?php $num=0;?>
                @foreach($goods_attr as $kk=>$vv)
                    @if($val->attr_id == $vv->attr_id )
                        <tr><td class="label">
                                @if($num==0)
                                    <a href="javascript:;" onclick="addSpec(this)">[+]</a>{{$val->attr_name}}
                                @else
                                    <a href="javascript:;" onclick="lessSpec(this)">[ - ]</a>{{$val->attr_name}}
                                @endif
                            </td>
                            <td>
                                <input name="attr_value_list[{{$val->attr_id}}][]" <?php if("$val->attr_id" == $vv->attr_id ){ ?> value="<?php echo $vv->attr_value;?>" <?php  }?> type="text" size="40">
                                属性价格 <input type="text" name="attr_price_list[{{$val->attr_id}}][]"  <?php  if("$val->attr_id" == $vv->attr_id ){ ?> value="<?php echo $vv->attr_value;?>" <?php  }?> size="5" maxlength="10">
                            </td>
                        </tr>
                        <?php $num++;?>

                    @endif
                @endforeach
            @endif
            @if($val->attr_type == 1 && $val->attr_input_type == 1 )
                <?php $num=0;?>
                @foreach($goods_attr as $kk=>$vv)
                    @if($val->attr_id == $vv->attr_id )
                        <tr><td class="label">
                            @if($num==0)
                                    <a href="javascript:;" onclick="addSpec(this)">[+]</a>{{$val->attr_name}}
                                @else
                                    <a href="javascript:;" onclick="lessSpec(this)">[ - ]</a>{{$val->attr_name}}
                            @endif
                            <td>
                                <select name="attr_value_list[{{$val->attr_id}}][]">
                                    <option value="0">请选择...</option>
                                    @foreach($val->attr_values as $k=>$v)
                                        `               @if(!empty($v))
                                            <option value="{{$v}}" <?php   if( $val->attr_id == $vv->attr_id && rtrim($v) == rtrim($vv->attr_value) ){ echo "selected";  }?>>{{$v}}</option>
                                        @endif
                                    @endforeach
                                </select> 属性价格
                                <input type="text" name="attr_price_list[{{$val->attr_id}}][]" <?php  if("$val->attr_id" == $vv->attr_id ){ ?> value="<?php echo $vv->attr_price;?>" <?php  }?> size="5" maxlength="10">
                            </td>
                        </tr>
                        <?php $num++;?>
                    @endif
                @endforeach
            @endif

        @endforeach
        </tbody>
    </table>
@else
    <table width="100%" id="attrTable">
        <tbody>
        @foreach($attrInfo as $key=>$val)
            @if($val->attr_type==0 && $val->attr_input_type== 0)
                <tr>
                    <td class="label">{{$val->attr_name}}</td>
                    <td>
                        <input name="attr_value_list[{{$val->attr_id}}]" type="text" size="40">
                    </td>
                </tr>
            @endif
            @if($val->attr_type == 0 && $val->attr_input_type == 1)
                <tr><td class="label">{{$val->attr_name}}</td><td>
                        <select name="attr_value_list[{{$val->attr_id}}]">
                            <option value="0">请选择...</option>
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
                        <input name="attr_value_list[{{$val->attr_id}}][]" type="text" size="40">
                        属性价格 <input type="text" name="attr_price_list[{{$val->attr_id}}][]" size="5" maxlength="10">
                    </td>
                </tr>
            @endif
            @if($val->attr_type == 1 && $val->attr_input_type == 1 )
                <tr><td class="label">
                        <a href="javascript:;" onclick="addSpec(this)">[+]</a>{{$val->attr_name}}</td>
                    <td>
                        <select name="attr_value_list[{{$val->attr_id}}][]">
                            <option value="0">请选择...</option>
                            @foreach($val->attr_values as $k=>$v)
                                `               @if(!empty($v))
                                    <option value="{{$v}}">{{$v}}</option>
                                @endif
                            @endforeach
                        </select> 属性价格
                        <input type="text" name="attr_price_list[{{$val->attr_id}}][]" value="" size="5" maxlength="10">
                    </td>
                </tr>
            @endif

        @endforeach
        </tbody>
    </table>
@endif


