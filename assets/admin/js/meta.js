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

		alert(data);

	});

});