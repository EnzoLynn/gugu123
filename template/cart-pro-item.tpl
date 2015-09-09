{{#each this}}
{{#compare @index '!=' '0'}}
<tr data-flag="{{pro-id}}">
    <td colspan="2"><div class="line"></div></td> 
</tr>
{{/compare}}
<tr data-flag="{{pro-id}}">
    <td>
        <a href=""><img class="cart-pro-img" src="{{pro-img}}" alt=""></a>
    </td>
    <td>
        <div class="text-left"><a href="">{{pro-name}}</a></div>
        <div class="input-group numberGroup left">
            <span class="input-group-addon addon-control btn-default" controller="txtNum{{@index}}" data-limit="1" data-step="-1">-</span>
            <input type="text" class="form-control txtNum{{@index}} text-center" data-min='1' data-max='99' value="{{pro-num}}" placeholder="数量">
            <span class="input-group-addon addon-control btn-default" controller="txtNum{{@index}}" data-limit="99" data-step="1">+</span>
        </div>
        <div class="cart-pro-price text-right">
            <span>{{pro-price}}</span> 
            <span style="color:black;">元</span>
        </div>
        <div class="text-right delpro">
          <a data-flag="{{pro-id}}" href="javascript:void(0);">删除</a> 
        </div>
    </td>
</tr>
{{/each}}
