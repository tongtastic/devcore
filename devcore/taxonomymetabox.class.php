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
	                    $settings = array('wpautop' => true, 'media_buttons' => true, 'quicktags' => true, 'textarea_rows' => '15', 'textarea_name' => 'description' );
	                    wp_editor(wp_kses_post($tag->description , ENT_QUOTES, 'UTF-8'), 'cat_description', $settings);
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
			
				switch ($tax_field['type']) {
					
					case 'upload' :

						$data .= '<tr class="form-field"><th scope="row" valign="top"><label for="'.$tax_field['id'].'">'.$tax_field['name'].'</label></th>';

						$data .= '<td>';

						if($val) {

							$data .= '<img src="'.$val.'" style="width:100px;height:auto;" alt="" /><br /><br /><small>To delete image, clear text box below and click "Update".</small><br /><br />';

						}

						$data .= '<input type="text" class="meta-upload" style="width: 100%" name="'.$tax_field['id'].'" id="'.$tax_field['id'].'" value="' . $val . '" /><br /><br />';

						$data .= '<input class="meta-upload-button button-secondary" type="button" value="Upload Image" style="width:120px;" /><br /><br />'. stripslashes($tax_field['desc']).'<br /><br /></td></tr>';
					
					break;
					
					case 'text' :
					
						$data .= '<tr class="form-field"><th scope="row" valign="top"><label for="'.$tax_field['id'].'">'.$tax_field['name'].'</label></th><td><input type="text" class="text_field" style="width: 100%" name="'.$tax_field['id'].'" id="'.$tax_field['id'].'" value="' . $val . '" /><br /><br />'. stripslashes($tax_field['desc']).'<br /><br /></td></tr>';
					
					break;
					
					case 'textarea' :
					
						if ($tax_field['rich_editor'] == true) {

							$editor = new MetaBox;

							$data .= $editor->load_editor($tax_field['id'], false, $val);
					
						} else {
					
							$data .= '<tr class="form-field"><th scope="row" valign="top"><label for="'.$tax_field['id'].'">'.$tax_field['name'].'</label></th><td><textarea class="textarea_field" style="width: 97%" rows="10" name="'.$tax_field['id'].'" id="'.$tax_field['id'].'">' . $val . '</textarea><br /><br />'. stripslashes($tax_field['desc']).'<br /><br /></td></tr>';
						
						}
					
					break;

					case 'select':

						$data .= '<tr class="form-field"><th scope="row" valign="top"><label for="'.$tax_field['id'].'">'.$tax_field['name'].'</label></th><td>';
											
						$data .= '<select name="'.$tax_field['id'].'" id="'.$tax_field['id'].'" style="width: 97%">';
						
						$data .= '<option value="">Default</option>';

						if(isset($tax_field['options'])) {
						
							foreach ($tax_field['options'] as $key => $value) {
							
								if($value == $val) {
								
									$data .= '<option value="'.$value.'" selected="selected">'.$key.'</option>';
									
								} else {
							
									$data .= '<option value="'.$value.'">'.$key.'</option>';
								
								}
								
							}

						}
						
						$data .= '</select><br />'.stripslashes($tax_field['desc']);

						$data .= '<br /><br /></td></tr>';
						
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