{{#each this}}
<div class="row">
	<div class="col-md-120 owner-ct">
		<label>网&nbsp;&nbsp;&nbsp;&nbsp;友:</label>
		<label class="name">{{owner-name}}</label>
		<label class="date">{{owner-date}}</label>
	</div>
	<div class="clearfix"></div>
	<div class="col-md-120 content-ct">
		<label>咨询内容:</label><label class="content">{{content}}</label>
	</div>
	<div class="col-md-120 reply-ct">
		<label>谷谷回复:</label>
		<label class="reply">{{reply}}</label>
		<label class="date">{{reply-date}}</label>
	</div>
	<div class="clearfix"></div>
	<div class="col-md-120 line"></div>
</div>
{{/each}}