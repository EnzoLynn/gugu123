<div class="row">
    <table>
        <tbody>
            {{#each this}}
            <tr>
                <td>
                    <a href=""><img class="cart-pro-img" src="../picBase/pics/cart-pro.png" alt=""></a>
                </td>
                <td>
                    <div class="text-left"><a href=""> BANEZ j200 ddddd 阿迪的的  BANEZ j200  {{@index}}</a></div>
                    <div class="input-group numberGroup objLeft">
                        <span class="input-group-addon addon-control btn-default" controller="txtNum" data-limit="1" data-step="-1">-</span>
                        <input type="text" class="form-control txtNum text-center" data-min='1' data-max='99' value="1" placeholder="数量">
                        <span class="input-group-addon addon-control btn-default" controller="txtNum" data-limit="99" data-step="1">+</span>
                    </div>
                    <div class="cart-pro-price">3400元</div>
                </td>
            </tr>
            {{/each}}
        </tbody>
    </table>
</div>
