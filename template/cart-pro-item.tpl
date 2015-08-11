{{#each this}}
{{#compare @index '!=' '0'}}
<tr>
    <td colspan="2"><div class="line"></div></td> 
</tr>
{{/compare}}
<tr>
    <td>
        <a href=""><img class="cart-pro-img" src="{{pro-img}}" alt=""></a>
    </td>
    <td>
        <div class="text-left"><a class="{{pro-id}}" href="">{{pro-name}}{{@index}}</a></div>
        <div class="input-group numberGroup left">
            <span class="input-group-addon addon-control btn-default" controller="txtNum{{@index}}" data-limit="1" data-step="-1">-</span>
            <input type="text" class="form-control txtNum{{@index}} text-center" data-min='1' data-max='99' value="{{pro-num}}" placeholder="数量">
            <span class="input-group-addon addon-control btn-default" controller="txtNum{{@index}}" data-limit="99" data-step="1">+</span>
        </div>
        <div class="cart-pro-price">
            <span>{{pro-price}}</span> 
            <span>元</span>
        </div>

    </td>
</tr>
{{/each}}
