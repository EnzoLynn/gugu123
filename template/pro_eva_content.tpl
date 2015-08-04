{{#each this}}
<div class="row">
    <div class="col-md-60 content">
        <div class="row">
            <div class="col-md-120 text">
                {{content-text}}
            </div>
            <div class="col-md-120 pictrue">
                {{#each content-pictrue}}
                <img src={{this}} alt=""> {{/each}}
            </div>
        </div>
    </div>
    <div class="col-md-20 grade"> 
        <div class="grade-star  {{grade}}"></div>
    </div>
    <div class="col-md-20 info text-center">
        {{info}}
    </div>
    <div class="col-md-20 owner text-center">
        {{owner}}
    </div>
    <div class="col-md-120 praise"><a href="javascript:void(0);">赞{{#compare praise '!=' '0'}} ({{praise}}) {{/compare}}</a></div>
</div>
{{/each}}
