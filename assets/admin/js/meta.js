jQuery(document).ready(function() {

	if(jQuery('.meta-upload').length > 0 ) {
			
		window.formfield = '';

		jQuery('body').on('click', '.meta-upload-button', function() {
		
			window.formfield = jQuery(this).parent().children('.meta-upload');
			
			tb_show('', 'media-upload.php?type=file&TB_iframe=true');
			
			return false;
			
		});

		window.original_send_to_editor = window.send_to_editor;
			
		window.send_to_editor = function(html) {
		
			if (window.formfield) {
			
				imgurl = jQuery('a','<div>'+html+'</div>').attr('href');
				
				window.formfield.val(imgurl);
				
				tb_remove();
				
			} else {
			
				window.original_send_to_editor(html);
				
			}
			
			window.formfield = '';
			
			window.imagefield = false;
			
		}

	}

	jQuery('.meta-add-button').on('click', function() {
			
		var field = jQuery(this).parent().find('div.meta-repeatable-wrapper:last').clone(true);

		jQuery('input[type=text]', field).val('');

		jQuery('textarea', field).text('');

		var fieldLocation = jQuery(this).parent().find('div.meta-repeatable-wrapper:last');
		
		field.insertAfter(fieldLocation);
		
		return false;

	});

	jQuery('.meta-remove-button').on('click', function() {

		var field = jQuery(this).parent();
		
		field.remove();
		
		return false;
	
	});

	jQuery('.meta-sortable > div').sortable({

		cursor: 'move',
		placeholder: 'sortable-placeholder',
		forcePlaceholderSize: true,
		containment: 'parent',
		axis: 'y'

	});

	jQuery('.meta-datepicker').each(function() {

		var dateformat = jQuery(this).attr('data-dateformat');

		jQuery(this).datepicker({

			dateFormat: dateformat

		});

	});

	jQuery('.meta-colorpicker').each(function() {

		var target = jQuery(this);

		var target_demo = jQuery(this).next('.meta-colorpicker-color');

		target.ColorPicker({

			onSubmit: function (hsb, hex, rgb) {

				target.val('#'+hex);

				target_demo.css({
					'background': '#'+hex,
					'display': 'block'
				});

			}

		});

	});

	// load up rich editor windo and populate content
	jQuery('.meta-rich-editor').click(function() {

		jQuery(this).addClass('meta-editor-target').attr("disabled","disabled");

		var data = jQuery(this).data();

		var content = {}

		content = jQuery(this).text();

		// process content via AJAX call to apply wpautop
		jQuery.ajax({

			type: 'post',

			dataType: 'json',

			url: ajaxurl,

			data: {
				action: 'meta_format_content', content: content
			},
			success: function(response) {

				if(response.type == 'success') {

					tinyMCE.get('editor'+data.editor).setContent(response.content);

					jQuery('#meta-wrapper-editor-bg-'+data.editor).fadeIn('fast',function() {

						jQuery('#meta-wrapper-editor'+data.editor).fadeIn('fast');

					});

				} else {

					alert(response);

				}

			}

		});

	});

	// push content back to text area
	jQuery('.meta-insert-content').click(function() {

		var data = jQuery(this).data();

		var content = tinyMCE.get('editor'+data.editor).getContent();

		jQuery(data.editorwrap).fadeOut('fast',function() {

			jQuery('.meta-editor-target').empty().text(content).removeClass('meta-editor-target').prop('disabled', false);

			jQuery(data.bg).fadeOut('fast');

		});

		tinyMCE.get('editor'+data.editor).setContent('');

		return false;

	});

	// close popup window
	jQuery('.meta-close-editor-window').click(function() {

		var data = jQuery(this).data();
		
		jQuery(data.editorwrap).fadeOut('fast',function() {

			jQuery(data.bg).fadeOut('fast');

			jQuery('.meta-editor-target').removeClass('meta-editor-target').prop('disabled', false);

		});

		tinyMCE.get('editor'+data.editor).setContent('');
		
		return false;
	
	});

});