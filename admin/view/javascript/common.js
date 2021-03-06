function getURLVar(key) {
	var value = [];

	var query = String(document.location).split('?');

	if (query[1]) {
		var part = query[1].split('&');

		for (i = 0; i < part.length; i++) {
			var data = part[i].split('=');

			if (data[0] && data[1]) {
				value[data[0]] = data[1];
			}
		}

		if (value[key]) {
			return value[key];
		} else {
			return '';
		}
	}
}

(function($) {
    $.fn.imgShow = function(){
        var img = $(this);
        if(img.attr("origin-src") == ''){
            return;
        }else{
            var src = img.attr("origin-src");
        }
        img.mouseenter(function(){
            var temp = document.createElement("div");
            temp.id = "temp_img_div";
            temp.style.cssText = "position:fixed; border:1px solid #f60; top:5px; right:5px; z-index:1001;";
            temp.innerHTML = '<img src="'+ src +'"/>';
            document.body.appendChild(temp);
        }).mouseleave(function(){
            if($("#temp_img_div").length>0){
                $("#temp_img_div").remove();
            }
        });
    }
})(window.jQuery);

$(document).ready(function() {
	//Form Submit for IE Browser
	$('button[type=\'submit\']').on('click', function() {
		$("form[id*='form-']").submit();
	});

	// Highlight any found errors
	$('.text-danger').each(function() {
		var element = $(this).parent().parent();
		
		if (element.hasClass('form-group')) {
			element.addClass('has-error');
		}
	});
	
	// Set last page opened on the menu
	$('#menu a[href]').on('click', function() {
		sessionStorage.setItem('menu', $(this).attr('href'));
	});

	if (!sessionStorage.getItem('menu')) {
		$('#menu #dashboard').addClass('active');
	} else {
		// Sets active and open to selected page in the left column menu.
		$('#menu a[href=\'' + sessionStorage.getItem('menu') + '\']').parents('li').addClass('active open');
	}

	if (localStorage.getItem('column-left') == 'active') {
		$('#button-menu i').replaceWith('<i class="fa fa-dedent fa-lg"></i>');
		
		$('#column-left').addClass('active');
		
		// Slide Down Menu
		$('#menu li.active').has('ul').children('ul').addClass('collapse in');
		$('#menu li').not('.active').has('ul').children('ul').addClass('collapse');
	} else {
		$('#button-menu i').replaceWith('<i class="fa fa-indent fa-lg"></i>');
		
		$('#menu li li.active').has('ul').children('ul').addClass('collapse in');
		$('#menu li li').not('.active').has('ul').children('ul').addClass('collapse');
	}

	// Menu button
	$('#button-menu').on('click', function() {
		// Checks if the left column is active or not.
		if ($('#column-left').hasClass('active')) {
			localStorage.setItem('column-left', '');

			$('#button-menu i').replaceWith('<i class="fa fa-indent fa-lg"></i>');

			$('#column-left').removeClass('active');

			$('#menu > li > ul').removeClass('in collapse');
			$('#menu > li > ul').removeAttr('style');
		} else {
			localStorage.setItem('column-left', 'active');

			$('#button-menu i').replaceWith('<i class="fa fa-dedent fa-lg"></i>');
			
			$('#column-left').addClass('active');

			// Add the slide down to open menu items
			$('#menu li.open').has('ul').children('ul').addClass('collapse in');
			$('#menu li').not('.open').has('ul').children('ul').addClass('collapse');
		}
	});

	// Menu
	$('#menu').find('li').has('ul').children('a').on('click', function() {
		if ($('#column-left').hasClass('active')) {
			$(this).parent('li').toggleClass('open').children('ul').collapse('toggle');
			$(this).parent('li').siblings().removeClass('open').children('ul.in').collapse('hide');
		} else if (!$(this).parent().parent().is('#menu')) {
			$(this).parent('li').toggleClass('open').children('ul').collapse('toggle');
			$(this).parent('li').siblings().removeClass('open').children('ul.in').collapse('hide');
		}
	});
	
	// Override summernotes image manager
	$('button[data-event=\'showImageDialog\']').attr('data-toggle', 'image').removeAttr('data-event');
	
	$(document).delegate('button[data-toggle=\'image\']', 'click', function() {
		$('#modal-image').remove();
		
		$(this).parents('.note-editor').find('.note-editable').focus();
				
		$.ajax({
			url: 'index.php?route=common/filemanager&token=' + getURLVar('token'),
			dataType: 'html',
			beforeSend: function() {
				$('#button-image i').replaceWith('<i class="fa fa-circle-o-notch fa-spin"></i>');
				$('#button-image').prop('disabled', true);
			},
			complete: function() {
				$('#button-image i').replaceWith('<i class="fa fa-upload"></i>');
				$('#button-image').prop('disabled', false);
			},
			success: function(html) {
				$('body').append('<div id="modal-image" class="modal">' + html + '</div>');
	
				$('#modal-image').modal('show');
			}
		});	
	});

    $('img[origin-src]').each(function(){
        $(this).imgShow();
    });
	// Image Manager
	$(document).delegate('a[data-toggle=\'image\']', 'click', function(e) {
		e.preventDefault();
		
		$('.popover').popover('hide', function() {
			$('.popover').remove();
		});
					
		var element = this;

		$(element).popover({
			html: true,
			placement: 'right',
			trigger: 'manual',
			content: function() {
				return '<button type="button" id="button-image" class="btn btn-primary"><i class="fa fa-pencil"></i></button> <button type="button" id="button-clear" class="btn btn-danger"><i class="fa fa-trash-o"></i></button>';
			}
		});
		
		$(element).popover('show');

        if(typeof($(element).attr("directory"))=="undefined" || $(element).attr("directory")==undefined || $(element).attr("directory") == '') {
            var ajax_url = 'index.php?route=common/filemanager&token=' + getURLVar('token') + '&target=' + $(element).parent().find('input').attr('id') + '&thumb=' + $(element).attr('id');
        }else{
            var ajax_url = 'index.php?route=common/filemanager&token=' + getURLVar('token') + '&directory=' + $(element).attr("directory") + '&target=' + $(element).parent().find('input').attr('id') + '&thumb=' + $(element).attr('id');
        }

		$('#button-image').on('click', function() {
			$('#modal-image').remove();

			$.ajax({
				url: ajax_url,
				dataType: 'html',
				beforeSend: function() {
					$('#button-image i').replaceWith('<i class="fa fa-circle-o-notch fa-spin"></i>');
					$('#button-image').prop('disabled', true);
				},
				complete: function() {
					$('#button-image i').replaceWith('<i class="fa fa-pencil"></i>');
					$('#button-image').prop('disabled', false);
				},
				success: function(html) {
					$('body').append('<div id="modal-image" class="modal">' + html + '</div>');
		
					$('#modal-image').modal('show');
				}
			});
			
			$(element).popover('hide', function() {
				$('.popover').remove();
			});
		});		
		
		$('#button-clear').on('click', function() {
			$(element).find('img').attr('src', $(element).find('img').attr('data-placeholder'));
			
			$(element).parent().find('input').attr('value', '');
			
			$(element).popover('hide', function() {
				$('.popover').remove();
			});
		});
	});
	
	// tooltips on hover
	$('[data-toggle=\'tooltip\']').tooltip({container: 'body', html: true});

	// Makes tooltips work on ajax generated content
	$(document).ajaxStop(function() {
		$('[data-toggle=\'tooltip\']').tooltip({container: 'body'});
	});
	
	// https://github.com/opencart/opencart/issues/2595
	$.event.special.remove = {
		remove: function(o) {
			if (o.handler) { 
				o.handler.apply(this, arguments);
			}
		}
	}
	
	$('[data-toggle=\'tooltip\']').on('remove', function() {
		$(this).tooltip('destroy');
	});	
});

// Autocomplete */
(function($) {
	$.fn.autocomplete = function(option) {
		return this.each(function() {

            this.val_old = $(this).val();
            this.val_new = this.val_old;

			this.timer = null;
			this.items = new Array();

            this.multiple = true; //默认多选

			$.extend(this, option);

			$(this).attr('autocomplete', 'off');
			
			// Focus
			$(this).on('focus', function() {
                if(this.multiple) {
                    this.val_old = $(this).val();
                    if (this.val_new == this.val_old && $(this).siblings('ul.dropdown-menu').html()!='') {
                        $(this).siblings('ul.dropdown-menu').show();
                    }else{
                        //this.hide();
                        this.request();
                    }
                }else{
                    $(this).siblings('ul.dropdown-menu').hide();
                    if( this.val_old != '') {
                        this.request();
                    }
                }
			});
			
			// Blur
			$(this).on('blur', function() {
                this.val_new = $(this).val();
				setTimeout(function(object) {
					object.hide();
				}, 200, this);
			});
			
			// Keydown
			$(this).on('keyup', function(event) {
				switch(event.keyCode) {
					case 27: // escape
                        $(this).siblings('ul.dropdown-menu').hide();
						break;
					default:
                        $(this).siblings('ul.dropdown-menu').hide();
						this.request();
						break;
				}				
			});
			
			// Click
			this.click = function(event) {
				event.preventDefault();
	
				value = $(event.target).parent().attr('data-value');
	
				if (value && this.items[value]) {
					this.select(this.items[value]);
				}
                if(this.multiple == false) {
                    $(this).siblings('ul.dropdown-menu').hide();
                }
			}
			
			// Show
			this.show = function() {
				var pos = $(this).position();
	
				$(this).siblings('ul.dropdown-menu').css({
					top: pos.top + $(this).outerHeight(),
					left: pos.left
				});
	
				$(this).siblings('ul.dropdown-menu').show();
			}
			
			// Hide
			this.hide = function() {
				$(this).siblings('ul.dropdown-menu').hide();
			}		
			
			// Request
			this.request = function() {
				clearTimeout(this.timer);
		        if($(this).val() == '') {
                    return ;
                }

				this.timer = setTimeout(function(object) {
					object.source($(object).val(), $.proxy(object.response, object));
				}, 200, this);
			}
			
			// Response
			this.response = function(json) {
				html = '';
	
				if (json.length) {
					for (i = 0; i < json.length; i++) {
						this.items[json[i]['value']] = json[i];
					}
	
					for (i = 0; i < json.length; i++) {
						if (!json[i]['category']) {
							html += '<li data-value="' + json[i]['value'] + '"><a href="#">' + json[i]['label'] + '</a></li>';
						}
					}
	
					// Get all the ones with a categories
					var category = new Array();
	
					for (i = 0; i < json.length; i++) {
						if (json[i]['category']) {
							if (!category[json[i]['category']]) {
								category[json[i]['category']] = new Array();
								category[json[i]['category']]['name'] = json[i]['category'];
								category[json[i]['category']]['item'] = new Array();
							}
	
							category[json[i]['category']]['item'].push(json[i]);
						}
					}
	
					for (i in category) {
						html += '<li class="dropdown-header">' + category[i]['name'] + '</li>';
	
						for (j = 0; j < category[i]['item'].length; j++) {
							html += '<li data-value="' + category[i]['item'][j]['value'] + '"><a href="#">&nbsp;&nbsp;&nbsp;' + category[i]['item'][j]['label'] + '</a></li>';
						}
					}
				}
	
				if (html) {
					this.show();
				} else {
					this.hide();
				}
	
				$(this).siblings('ul.dropdown-menu').html(html);
			}
			
			$(this).after('<ul class="dropdown-menu"></ul>');
			$(this).siblings('ul.dropdown-menu').delegate('a', 'click', $.proxy(this.click, this));	
			
		});
	}
})(window.jQuery);

// 周辉 20150630
// 替换当前url的某个key=value
function replaceURLVar(key, value) {
    var url = location.href;
    var url_new = "";
    if (url.indexOf("&" + key + "=") == -1) {
        url_new = url + "&" + key + "=" + encodeURIComponent(value);
    } else {
        var url_base = url.substr(0, url.indexOf("?"));
        var pars = new Array();
        var query = url.split('?');
        if (query[1]) {
            var part = query[1].split('&');
            for (i = 0; i < part.length; i++) {
                var data = part[i].split('=');
                if (data[0] == key) {
                    pars.push(key + "=" + encodeURIComponent(value));
                } else {
                    pars.push(data[0] + "=" + data[1]);
                }
            }
        }
        url_new = url_base + "?" + pars.join('&');
    }
    return url_new;
}

//href删除的时候，先确认消息提示
function deleteByConfirm(url, title) {
    if(window.confirm(title)) {
        location.href = url;
    }
}