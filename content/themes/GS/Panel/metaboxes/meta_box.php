<?php

// finds any item in any level of an array
function meta_box_find_field_type( $needle, $haystack ) {
    foreach ( $haystack as $item )
        if ( $item['type'] == $needle )
            return true;
    return false;
}

// sanitize boolean inputs
function meta_box_santitize_boolean( $string ) {
	if ( ! isset( $string ) || $string != 1 )
		return false;
	else
		return true;
}

// outputs properly sanitized data
function meta_box_sanitize( $string, $function = 'sanitize_text_field' ) {
	switch ( $function ) {
		case 'nofilter':
			return $string;
		case 'intval':
			return intval( $string );
		case 'absint':
			return absint( $string );
		case 'wp_kses_post':
			return wp_kses_post( $string );
		case 'wp_kses_data':
			return wp_kses_data( $string );
		case 'wp_rel_nofollow':
			return wp_rel_nofollow( $string );
		case 'esc_html':
			return esc_html( $string );
		case 'esc_textarea':
			return esc_textarea( $string );
		case 'esc_attr':
			return esc_attr( $string );
		case 'esc_url':
			return esc_url( $string );
		case 'esc_url_raw':
			return esc_url_raw( $string );
		case 'urlencode':
			return urlencode( $string );
		case 'urlencode_deep':
			return urlencode_deep( $string );
		case 'sanitize_title':
			return sanitize_title( $string );
		case 'santitize_boolean':
			return santitize_boolean( $string );
		case 'sanitize_text_field':
		default:
			return sanitize_text_field( $string );
	}
}

// for sanitizing arrays
function meta_box_array_map_r( $func, $meta, $sanitizer )
{
		
    $newMeta = array();
	
	foreach( $meta as $key => $array ) {
		$array = array_map( $func, $array, $sanitizer );
		$newMeta[$key] = array_combine( array_keys( $sanitizer), array_values( $array ) );
	}
        
    return $newMeta;
}

class Custom_Add_Meta_Box {
	
	var $id; // string meta box id
	var $title; // string title
	var $fields; // array fields
	var $page; // string|array post type to add meta box to
	var $js; // bool including javascript or not
	
    public function __construct( $id, $title, $fields, $page, $js ) {
		$this->id = $id;
		$this->title = $title;
		$this->fields = $fields;
		$this->page = $page;
		$this->js = $js;
		
		if( ! is_array( $this->page ) ) {
			$this->page = array( $this->page );
		}
		
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );
		add_action( 'admin_head',  array( $this, 'admin_head' ) );
		add_action( 'add_meta_boxes', array( $this, 'add_box' ) );
		add_action( 'save_post',  array( $this, 'save_box' ));
    }
	
	function admin_enqueue_scripts() {
		global $pagenow;
		if ( in_array( $pagenow, array( 'post-new.php', 'post.php' ) ) && in_array( get_post_type(), $this->page ) ) {
			// js
			$deps = array( 'jquery' );
			if ( meta_box_find_field_type( 'date', $this->fields ) )
				$deps[] = 'jquery-ui-datepicker';
			if ( meta_box_find_field_type( 'slider', $this->fields ) )
				$deps[] = 'jquery-ui-slider';
			if ( meta_box_find_field_type( 'color', $this->fields ) )
				$deps[] = 'farbtastic';
			if ( meta_box_find_field_type( 'chosen', $this->fields ) || meta_box_find_field_type( 'post_chosen', $this->fields ) ) {
				wp_register_script( 'chosen', get_template_directory_uri() . '/metaboxes/js/chosen.js', array( 'jquery' ) );
				$deps[] = 'chosen';
				wp_enqueue_style( 'chosen', get_template_directory_uri() . '/metaboxes/css/chosen.css' );
			}
			if ( meta_box_find_field_type( 'image', $this->fields ) || meta_box_find_field_type( 'repeatable', $this->fields ) || meta_box_find_field_type( 'post_drop_sort', $this->fields ) || meta_box_find_field_type( 'chosen', $this->fields ) || meta_box_find_field_type( 'post_chosen', $this->fields ) )
				wp_enqueue_script( 'meta_box', get_template_directory_uri() . '/metaboxes/js/scripts.js', $deps );
			// css
			$deps = array();
			wp_register_style( 'jqueryui', get_template_directory_uri() . '/metaboxes/css/jqueryui.css' );
			if ( meta_box_find_field_type( 'date', $this->fields ) || meta_box_find_field_type( 'slider', $this->fields ) )
				$deps[] = 'jqueryui';
			if ( meta_box_find_field_type( 'color', $this->fields ) )
				$deps[] = 'farbtastic';
			wp_enqueue_style( 'meta_box', get_template_directory_uri() . '/metaboxes/css/meta_box.css', $deps );
		}
	}
	
	// scripts
	function admin_head() {
		global $post, $post_type;
		
		if ( in_array( get_post_type(), $this->page ) && $this->js == true ) : 
		
			echo '<script type="text/javascript">
						jQuery(function($) {';
			
			foreach ( $this->fields as $field ) {
				// date
				if( $field['type'] == 'date' )
					echo '$("#' . $field['id'] . '").datepicker({
							dateFormat: \'yy-mm-dd\'
						});';
				// slider
				if ( $field['type'] == 'slider' ) {
					$value = get_post_meta( $post->ID, $field['id'], true );
					if ( $value == '' ) $value = $field['min'];
					echo '
							$( "#' . $field['id'] . '-slider" ).slider({
								value: ' . $value . ',
								min: ' . $field['min'] . ',
								max: ' . $field['max'] . ',
								step: ' . $field['step'] . ',
								slide: function( event, ui ) {
									$( "#' . $field['id'] . '" ).val( ui.value );
								}
							});';
				}
			}
			
			echo '});
				</script>';
		
		endif;
	}
	
	function add_box() {
		foreach ( $this->page as $page ) {
			add_meta_box( $this->id, $this->title, array( $this, 'meta_box_callback' ), $page, 'normal', 'high');
		}
	}
	
	function meta_box_callback() {
		global $post;
		// Use nonce for verification
		wp_nonce_field( 'custom_meta_box_nonce_action', 'custom_meta_box_nonce_field' );
		
		// Begin the field table and loop
		echo '<table class="form-table meta_box">';
		foreach ( $this->fields as $field) {
			
			if ( $field['type'] == 'section' ) {
				echo '<tr><th colspan="2"><h2>' . $field['label'] . '</h2></th></tr>';
				$sanitizer = null;
			}
			
			else {
			
				// get data for this field
				unset( $sanitizer );
				extract( $field );
				
				if ( !empty( $desc ) )
					$desc = '<span class="description">' . $desc . '</span>';
					
				// get sanitized value of this field
				$sanitizer = isset( $sanitizer ) ? $sanitizer : 'sanitize_text_field';
				$meta = get_post_meta( $post->ID, $id, true );
				if ( is_array( $meta ) )
					$meta = meta_box_array_map_r( 'meta_box_sanitize', $meta, $sanitizer );
				else
					$meta = meta_box_sanitize( $meta, $sanitizer );
					
				// begin a table row with
				echo '<tr>
						<th><label for="' . esc_attr( $id ) . '">' . $label . '</label></th>
						<td>';
						switch( $type ) {
							// basic
							case 'text':
							case 'url':
							case 'email':
							case 'tel':
							case 'number':
							default:
								echo '<input type="' . $type . '" name="' . esc_attr( $id ) . '" id="' . esc_attr( $id ) . '" value="' . $meta . '" class="regular-text" size="30" />
										<br />' . $desc;
							break;
							// textarea
							case 'textarea':
								echo '<textarea name="' . esc_attr( $id ) . '" id="' . esc_attr( $id ) . '" cols="60" rows="4">' . esc_textarea( $meta ) . '</textarea>
										<br />' . $desc;
							break;
							// editor
							case 'editor':
								echo wp_editor( $meta, $id, $settings ) . '<br />' . $desc;
							break;
							// checkbox
							case 'checkbox':
								echo '<input type="checkbox" name="' . esc_attr( $id ) . '" id="' . esc_attr( $id ) . '" ' . checked( $meta, true, false ) . ' value="1" />
										<label for="' . esc_attr( $id ) . '">' . $desc . '</label>';
							break;
							// select, chosen
							case 'select':
							case 'chosen':
								echo '<select name="' . esc_attr( $id ) . '" id="' . esc_attr( $id ) . '"' , $type == 'chosen' ? ' class="chosen"' : '' , isset( $multiple ) && $multiple == true ? ' multiple="multiple"' : '' , '>
										<option value="">Select One</option>'; // Select One
								foreach ( $options as $option )
									echo '<option' . selected( $meta, $option['value'], false ) . ' value="' . $option['value'] . '">' . $option['label'] . '</option>';
								echo '</select><br />' . $desc;
							break;
							// radio
							case 'radio':
								echo '<ul class="meta_box_items">';
								foreach ( $options as $option )
									echo '<li><input type="radio" name="' . esc_attr( $id ) . '" id="' . esc_attr( $id ) . '-' . $option['value'] . '" value="' . $option['value'] . '" ' . checked( $meta, $option['value'], false ) . ' />
											<label for="' . esc_attr( $id ) . '-' . $option['value'] . '">' . $option['label'] . '</label></li>';
								echo '</ul>' . $desc;
							break;
							// checkbox_group
							case 'checkbox_group':
								echo '<ul class="meta_box_items">';
								foreach ( $options as $option )
									echo '<li><input type="checkbox" value="' . $option['value'] . '" name="' . esc_attr( $id ) . '[]" id="' . esc_attr( $id ) . '-' . $option['value'] . '"' , is_array( $meta ) && in_array( $option['value'], $meta ) ? ' checked="checked"' : '' , ' /> 
											<label for="' . esc_attr( $id ) . '-' . $option['value'] . '">' . $option['label'] . '</label></li>';
								echo '</ul>' . $desc;
							break;
							// color
							case 'color':
								$meta = $meta ? $meta : '#';
								echo '<input type="text" name="' . esc_attr( $id ) . '" id="' . esc_attr( $id ) . '" value="' . $meta . '" size="10" />
									<br />' . $desc;
								echo '<div id="colorpicker-' . esc_attr( $id ) . '"></div>
									<script type="text/javascript">
									jQuery(function(jQuery) {
										jQuery("#colorpicker-' . esc_attr( $id ) . '").hide();
										jQuery("#colorpicker-' . esc_attr( $id ) . '").farbtastic("#' . esc_attr( $id ) . '");
										jQuery("#' . esc_attr( $id ) . '").bind("blur", function() { jQuery("#colorpicker-' . esc_attr( $id ) . '").slideToggle(); } );
										jQuery("#' . esc_attr( $id ) . '").bind("focus", function() { jQuery("#colorpicker-' . esc_attr( $id ) . '").slideToggle(); } );
									});
									</script>';
							break;
							// post_select, post_chosen
							case 'post_select':
							case 'post_chosen':
								if ( isset( $multiple ) && $multiple == true )
									echo '<select data-placeholder="Select One" name="' . esc_attr( $id ) . '[]" id="' . esc_attr( $id ) . '"' , $type == 'post_chosen' ? ' class="chosen"' : '' , ' multiple="multiple">';
								else
									echo '<select data-placeholder="Select One" name="' . esc_attr( $id ) . '" id="' . esc_attr( $id ) . '"' , $type == 'post_chosen' ? ' class="chosen"' : '' , '>';
								echo '<option value=""></option>'; // Select One
								$posts = get_posts( array( 'post_type' => $post_type, 'posts_per_page' => -1, 'orderby' => 'name', 'order' => 'ASC' ) );
								foreach ( $posts as $item ) {
									$selected = is_array( $meta ) ? selected( in_array( $item->ID, $meta ), true, false ) : selected( $item->ID, $meta, false );
									echo '<option value="' . $item->ID . '"' . $selected . '>' . $item->post_title . '</option>';
								}
								$post_type_object = get_post_type_object( $post_type );
								echo '</select> &nbsp;<span class="description"><a href="' . admin_url( 'edit.php?post_type=' . $post_type . '">Manage ' . $post_type_object->label ) . '</a></span><br />' . $desc;
							break;
							// post_checkboxes
							case 'post_checkboxes':
								$posts = get_posts( array( 'post_type' => $post_type, 'posts_per_page' => -1 ) );
								echo '<ul class="meta_box_items">';
								foreach ( $posts as $item ) 
									echo '<li><input type="checkbox" value="' . $item->ID . '" name="' . esc_attr( $id ) . '[]" id="' . esc_attr( $id ) . '-' . $item->ID . '"' , is_array( $meta ) && in_array( $item->ID, $meta ) ? ' checked="checked"' : '' , ' />
											<label for="' . esc_attr( $id ) . '-' . $item->ID . '">' . $item->post_title . '</label></li>';
								$post_type_object = get_post_type_object( $post_type );
								echo '</ul> ' . $desc , ' &nbsp;<span class="description"><a href="' . admin_url( 'edit.php?post_type=' . $post_type . '">Manage ' . $post_type_object->label ) . '</a></span>';
							break;
							// post_drop_sort
							case 'post_drop_sort':
								//areas
								$post_type_object = get_post_type_object( $post_type );
                                echo '<p>' . $desc . ' &nbsp;<span class="description"><a href="' . admin_url( 'edit.php?post_type=' . $post_type . '">Manage ' . $post_type_object->label ) . '</a></span></p><div class="post_drop_sort_areas">';
								foreach ( $areas as $area ) {
                                	echo '<ul id="area-' . $area['id'] .'" class="sort_list">
											<li class="post_drop_sort_area_name">' . $area['label'] . '</li>';
											if ( is_array( $meta ) ) {
												$items = explode( ',', $meta[$area['id']] );
												foreach ( $items as $item ) {
													$output = $display == 'thumbnail' ? get_the_post_thumbnail( $item, array( 204, 30 ) ) : get_the_title( $item ); 
													echo '<li id="' . $item . '">' . $output . '</li>';
												}
											}
									echo '</ul>
										<input type="hidden" name="' . esc_attr( $id ) . '[' . $area['id'] . ']" 
										class="store-area-' . $area['id'] . '" 
										value="' , $meta ? $meta[$area['id']] : '' , '" />';
								}
								echo '</div>';
								// source
								$exclude = null;
								if ( !empty( $meta ) ) {
									$exclude = implode( ',', $meta ); // because each ID is in a unique key
									$exclude = explode( ',', $exclude ); // put all the ID's back into a single array
								}
								$posts = get_posts( array( 'post_type' => $post_type, 'posts_per_page' => -1, 'post__not_in' => $exclude ) );
                                echo '<ul class="post_drop_sort_source sort_list">
										<li class="post_drop_sort_area_name">Available ' . $label . '</li>';
								foreach ( $posts as $item ) {
									$output = $display == 'thumbnail' ? get_the_post_thumbnail( $item->ID, array( 204, 30 ) ) : get_the_title( $item->ID ); 
                                	echo '<li id="' . $item->ID . '">' . $output . '</li>';
								}
                                echo '</ul>';
							break;
							// date
							case 'date':
								echo '<input type="text" class="datepicker" name="' . esc_attr( $id ) . '" id="' . esc_attr( $id ) . '" value="' . $meta . '" size="30" />
										<br />' . $desc;
							break;
							// slider
							case 'slider':
							$value = $meta != '' ? intval( $meta ) : '0';
								echo '<div id="' . esc_attr( $id ) . '-slider"></div>
										<input type="text" name="' . esc_attr( $id ) . '" id="' . esc_attr( $id ) . '" value="' . $value . '" size="5" />
										<br />' . $desc;
							break;
							// image
							case 'image':
								$image = get_template_directory_uri() . '/metaboxes/images/image.png';	
								echo '<span class="meta_box_default_image" style="display:none">' . $image . '</span>';
								if ( $meta ) {
									$image = wp_get_attachment_image_src( intval( $meta ), 'medium' );
									$image = $image[0];
								}				
								echo	'<input name="' . esc_attr( $id ) . '" type="hidden" class="meta_box_upload_image" value="' . $meta . '" />
											<img src="' . $image . '" class="meta_box_preview_image" alt="" />
												<input class="meta_box_upload_image_button button" type="button" rel="' . $post->ID . '" value="Choose Image" />
												<small>&nbsp;<a href="#" class="meta_box_clear_image_button">Remove Image</a></small>
												<br clear="all" />' . $desc;
							break;
							// file
							case 'file':		
								$iconClass = 'meta_box_file';
								if ( $meta ) $iconClass .= ' checked';
								echo	'<input name="' . esc_attr( $id ) . '" type="hidden" class="meta_box_upload_file" value="' . $meta . '" />
											<span class="' . $iconClass . '"></span>
											<span class="meta_box_filename">' . $meta . '</span>
												<input class="meta_box_upload_file_button button" type="button" rel="' . $post->ID . '" value="Choose File" />
												<small>&nbsp;<a href="#" class="meta_box_clear_file_button">Remove File</a></small>
												<br clear="all" />' . $desc;
							break;
							// repeatable
							case 'repeatable':
								$field_titles = wp_list_pluck( $repeatable_fields, 'repeatable_label' );
								$field_titles = array_filter( $field_titles ); // remove empty values
								echo '<table id="' . esc_attr( $id ) . '-repeatable" class="meta_box_repeatable" cellspacing="0">
									<thead>
										<tr>
											<th><span class="sort_label"></span></th>
											<th>Fields</th>
											<th><a class="meta_box_repeatable_add" href="#"></a></th>
										</tr>
									</thead>
									<tbody>';
								$i = 0;
								// create an empty array
								if ( $meta == '' ) {
									$keys = wp_list_pluck( $repeatable_fields, 'repeatable_id' );
									$meta = array ( array_fill_keys( $keys, null ) );
								}
								$meta = array_values( $meta );
								foreach( $meta as $row ) {
									echo '<tr>
											<td><span class="sort hndle"></span></td><td>';
									foreach ( $repeatable_fields as $repeatable_field ) {
										extract( $repeatable_field );
										echo '<label>' . $repeatable_label .'</label><p>';
										switch ( $repeatable_type ) {
											// checkbox
											case 'checkbox':
												$checked = isset( $meta[$i][$repeatable_id] ) ? $meta[$i][$repeatable_id] : '';
												echo '<p><input type="checkbox" name="' . esc_attr( $id ) . '[' . $i . '][' . $repeatable_id .']" id="' . esc_attr( $id ) . '[' . $i . '][' . $repeatable_id .']" value="1"' . checked( $checked, $repeatable_id, false ) . ' style="display:inline;" /> <label style="display:inline;" for="' . esc_attr( $id ) . '[' . $i . '][' . $repeatable_id .']">' . $repeatable_label .'</label></p>';
											break;
											// radio
											case 'radio':
												$checked = isset( $meta[$i][$repeatable_id] ) ? $meta[$i][$repeatable_id] : '';
												echo '<p><input type="radio" name="' . esc_attr( $id ) . '[' . $i . '][' . $repeatable_id .']" id="' . esc_attr( $id ) . '[' . $i . '][' . $repeatable_id .']" value="' . $repeatable_id . '"' . checked( $checked, $repeatable_id, false ) . ' style="margin-top:7px" /></p>';
											break;
											// text
											case 'text':
												echo '<input type="text" name="' . esc_attr( $id ) . '[' . $i . '][' . $repeatable_id .']" value="' . $meta[$i][$repeatable_id] . '" size="30" class="regular-text" placeholder="' . $repeatable_label .'" />';
											break;
											// textarea
											case 'textarea':
												echo '<textarea name="' . esc_attr( $id ) . '[' . $i . '][' . $repeatable_id .']" cols="30" rows="4" placeholder="' . $repeatable_label .'">' . $meta[$i][$repeatable_id] . '</textarea>';
											break;
											// image
											case 'image':
											$image = get_template_directory_uri() . '/metaboxes/images/image.png';	
											echo '<span class="meta_box_default_image" style="display:none">' . $image . '</span>';
											if ( $meta[$i][$repeatable_id] ) {
												$image = $meta[$i][$repeatable_id];
												if ( intval( $image ) ) {
													$image = wp_get_attachment_image_src( $image, 'medium' );
													$image = $image[0];
												}
											}				
											echo	'<input name="' . esc_attr( $id ) . '[' . $i . '][' . $repeatable_id .']" type="hidden" class="meta_box_upload_image" value="' . intval( $meta[$i][$repeatable_id] ) . '" />
														<img src="' . $image . '" class="meta_box_preview_image" alt="" />
															<input class="meta_box_upload_image_button button" type="button" rel="' . $post->ID . '" value="Choose Image" />
															<small>&nbsp; <a href="#" class="meta_box_clear_image_button">Remove Image</a></small>
															<br clear="all" />';
											break;
											// unique id
											case 'id':
												echo '<input type="hidden" name="' . esc_attr( $id ) . '[' . $i . '][' . $repeatable_id .']" value="' , $meta[$i][$repeatable_id] != '' ? $meta[$i][$repeatable_id] : substr( ereg_replace("[^0-9]", "", uniqid() ), 3, 2 ) , '" size="5" class="repeatable_id" readonly="readonly" />';
											break;
										} // end switch
										echo '</p>';
									} // end each field
									echo '</td><td><a class="meta_box_repeatable_remove" href="#"></a></td></tr>';
									$i++;
								} // end each row
								echo '</tbody>';
								echo '
									<tfoot>
										<tr>
											<th><span class="sort_label"></span></th>
											<th>Fields</th>
											<th><a class="meta_box_repeatable_add" href="#"></a></th>
										</tr>
									</tfoot>';
								echo '</table>
									' . $desc;
							break;
						} //end switch
				echo '</td></tr>';
			} // end ! $type = section
		} // end foreach
		echo '</table>'; // end table
	}
	
	// Save the Data
	function save_box( $post_id ) {
		$post_type = get_post_type();
		
		// verify nonce
		if ( ! ( in_array( $post_type, $this->page )) || !isset( $_POST['custom_meta_box_nonce_field'] ) || !wp_verify_nonce( $_POST['custom_meta_box_nonce_field'],  'custom_meta_box_nonce_action' ) ) 
			return $post_id;
		// check autosave
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
			return $post_id;
		// check permissions
		if ( ! current_user_can( 'edit_page', $post_id ) )
			return $post_id;
		
		// loop through fields and save the data
		foreach ( $this->fields as $field ) {
			if( $field['type'] == 'section' ) {
				$sanitizer = null;
				continue;
			}
			if( $field['type'] == 'tax_select' ) {
				// save taxonomies
				if ( isset( $_POST[$field['id']] ) )
					$term = $_POST[$field['id']];
				wp_set_object_terms( $post_id, $term, $field['id'] );
			}
			else {
				// save the rest
				$old = get_post_meta( $post_id, $field['id'], true );
				if ( isset( $_POST[$field['id']] ) )
					$new = $_POST[$field['id']];
				if ( isset( $new ) && $new != $old ) {
					$sanitizer = isset( $field['sanitizer'] ) ? $field['sanitizer'] : 'sanitize_text_field';
					if ( is_array( $new ) )
						$new = meta_box_array_map_r( 'meta_box_sanitize', $new, $sanitizer );
					else
						$new = meta_box_sanitize( $new, $sanitizer );
					update_post_meta( $post_id, $field['id'], $new );
				} elseif ( isset( $new ) && '' == $new && $old ) {
					delete_post_meta( $post_id, $field['id'], $old );
				}
			}
		} // end foreach
	}
}