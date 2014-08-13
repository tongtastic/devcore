<?php

namespace devcore;

if(!class_exists('TaxonomyMetaBox')) {

	class TaxonomyMetaBox {
		
		var $tax_fields;

		function __construct() {

			$this->tax_fields = array();

		}

		function init($args) {

			$this->tax_fields = $args;
			
			add_action('admin_head', array($this, 'load_scripts'));
			
			add_action('admin_head', array($this, 'admin_head'));
			
			add_action('edit_term', array($this, 'save_tax_meta'));
			
			add_action('create_term', array($this, 'save_tax_meta'));

			add_action('admin_head', array($this, 'remove_default_tax_description'));

			remove_filter('pre_term_description', 'wp_filter_kses');

			remove_filter('term_description', 'wp_kses_data');
			
		}
		
		function admin_head() {
		
			$taxonomy = $this->tax_fields;

			add_action($taxonomy['taxonomy'].'_add_form_fields', array($this, 'tax_description'));

			add_action($taxonomy['taxonomy'].'_edit_form_fields', array($this, 'tax_description'));
			
			add_action($taxonomy['taxonomy'].'_add_form_fields', array($this, 'tax_field'));
			
			add_action($taxonomy['taxonomy'].'_edit_form_fields', array($this, 'tax_field'));
							
		}
		
		function load_scripts() {
			
			global $pagenow;
		
			$tax = $this->tax_fields;
					
			if($pagenow == 'edit-tags.php' && $_GET['taxonomy'] == $tax['taxonomy']) {
		
				wp_register_script('meta', get_bloginfo('template_directory').'/assets/admin/js/meta.js', array('jquery'), null, true);

				wp_enqueue_script('meta');
			
			}
					
		}

		function tax_description($tag) {

	    	?>
	            <tr class="form-field">
	                <th scope="row" valign="top"><label for="description"><?php _e('Description', 'Taxonomy Description'); ?></label></th>
	                <td>
	                <?php
	                    $editor = new Meta;

	                    echo $editor->load_editor('cat_description', false, wp_kses_post($tag->description , ENT_QUOTES, 'UTF-8'));
	                ?>
	                <br />
	                <span class="description"><?php _e('The description is not prominent by default; however, some themes may show it.'); ?></span>
	                </td>
	            </tr>
		    <?php

		}

		function remove_default_tax_description() {

		    global $pagenow;
		
			$tax = $this->tax_fields;
					
			if($pagenow == 'edit-tags.php' && $_GET['taxonomy'] == $tax['taxonomy']) {

			    ?>
		        <script type="text/javascript">

		        jQuery(function() {

		            jQuery('textarea#description').closest('tr.form-field').remove();

		            jQuery('textarea#tag-description').closest('div.form-field').remove();

		        });

		        </script>	        
			    <?php

		    }

		}
		
		function tax_field($taxonomy) {
		
			$tax_fields = $this->tax_fields;
			
			wp_enqueue_style('thickbox');
						
			wp_enqueue_script('thickbox');
			
			foreach($tax_fields['fields'] as $tax_field) {
			
				$data = null;
			
				$val = get_option($tax_field['id'].'_'.$taxonomy->term_id);

				$field = new Meta;
			
				switch ($tax_field['type']) {
					
					case 'upload' :

						$data .= '<tr class="form-field"><th scope="row" valign="top"></th>';

						$data .= '<td>';

						$data .= $field->upload($tax_field, $val);

						$data .= '<br /><br /></td></tr>';
					
					break;
					
					case 'text' :
					
						$data .= '<tr class="form-field"><th scope="row" valign="top"></th><td>';

						$data .= $field->text($tax_field, $val);

						$data .= '<br /><br /></td></tr>';
					
					break;
					
					case 'textarea' :
					
						$data .= '<tr class="form-field"><th scope="row" valign="top"></th><td>';

						$data .= $field->textarea($tax_field, $val);
					
						$data .= '</td></tr>';
											
					break;

					case 'select':

						$data .= '<tr class="form-field"><th scope="row" valign="top"></th><td>';

						$data .= $field->select($tax_field, $val);
					
						$data .= '</td></tr>';
						
					break;

					case 'colorpicker':

						$data .= '<tr class="form-field"><th scope="row" valign="top"></th><td>';

						$data .= $field->colorpicker($tax_field, $val);
					
						$data .= '</td></tr>';
						
					break;

					case 'datepicker':

						$data .= '<tr class="form-field"><th scope="row" valign="top"></th><td>';

						$data .= $field->datepicker($tax_field, $val);
					
						$data .= '</td></tr>';
						
					break;

					case 'checkbox':

						$data .= '<tr class="form-field"><th scope="row" valign="top"></th><td>';

						$data .= $field->checkbox($tax_field, $val);
					
						$data .= '</td></tr>';
						
					break;

					case 'radio':

						$data .= '<tr class="form-field"><th scope="row" valign="top"></th><td>';

						$data .= $field->radio($tax_field, $val);
					
						$data .= '</td></tr>';
						
					break;
					
				}
				
				echo $data;
			
			}
					
		}

		function save_tax_meta($term_id) {
		
			$tax_fields = $this->tax_fields;
			
			foreach($tax_fields['fields'] as $tax_field) {
		
				if (isset($_POST[$tax_field['id']])) {
				
					update_option($tax_field['id'].'_'.$term_id, $_POST[$tax_field['id']]);
					
				}
			
			}
		}
			
	}

}