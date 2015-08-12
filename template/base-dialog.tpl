<div class="modal fade {{itemId}}" style="margin:auto auto;">
    <div class="modal-dialog {{cls}}">
        <div class="modal-content">
            <div class="modal-header">
                {{#compare iconclose '==' true}}
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                {{/compare}}
                <h4 class="modal-title">{{title}}</h4>
            </div>
            <div class="modal-body">
                {{msg}}
            </div>
            <div class="modal-footer">
                {{#compare btnok '==' true}}
                <button class="btn btn-primary alert-ok" type="button">{{oktext}}</button>
                {{/compare}} {{#compare btncancel '==' true}}
                <button class="btn btn-primary alert-cancel" type="button">{{canceltext}}</button>
                {{/compare}}
            </div>
        </div>
    </div>
</div>
