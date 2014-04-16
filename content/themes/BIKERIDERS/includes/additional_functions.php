<?php
add_action( 'admin_init', 'vp_meta_boxes');
function vp_meta_boxes() {
	add_meta_box('vp_post_meta', 'Options', 'vp_post_meta', 'page', 'normal', 'high');
}
function vp_post_meta() {
	global $post;
	$temp = maybe_unserialize(get_post_meta($post->ID,'vp_settings',true));
	$slogan_bg = isset($temp['slogan_bg']) ? $temp['slogan_bg'] : '';
?>
	<div>	
   <div style="margin: 15px 0px 15px 4px">
      <label style="font-weight: bold" for="vp_sloganbg">Background image url:</label><br />
      <input type="text" name="vp_sloganbg" id="vp_sloganbg" value="<?php echo $slogan_bg;?>" style="width: 40em" />
    </div>
	</div>
<?php 
}
add_action('save_post', 'vp_save_metadata', 10, 2);
function vp_save_metadata($post_id, $post) 
{
	// verify if this is an auto save routine. 
    // If it is our form has not been submitted, so we dont want to do anything
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
   		 return;
   	// Check permissions
    if ( 'page' == $post->post_type ) 
    {
 	   if ( !current_user_can( 'edit_page', $post_id ) )
       		 return;
 	}
  	else
  	{
    	if ( !current_user_can( 'edit_post', $post_id ) )
        	return;	
    }
    $temp['slogan_bg'] = isset($_POST['vp_sloganbg']) ? esc_attr($_POST['vp_sloganbg']) : '';
    update_post_meta($post_id, 'vp_settings', $temp);
}

?>