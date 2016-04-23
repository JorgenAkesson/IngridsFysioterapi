<?php
/**
 * Plugin Name: MyAdminMenu
 */
add_action( 'admin_menu', 'my_plugin_menu' );

function my_plugin_menu() {
	add_options_page( 'My Plugin Options', 'Custom', 'manage_options', 'my-unique-identifier', 'my_plugin_options' );
    add_action( 'admin_init', 'register_mysettings' );
}

function register_mysettings() {
	//register our settings
	register_setting( 'baw-settings-group', 'new_option_name' );
}

function my_dropdown() {
    $urls = '';
    $query_images_args = array('post_type' => 'attachment', 'post_mime_type' =>'image', 'post_status' => 'inherit', 'posts_per_page' => -1,);

    $query_images = new WP_Query( $query_images_args );
    $images = array();
    foreach ( $query_images->posts as $image) {
        $images[]= wp_get_attachment_url( $image->ID );
        $name = wp_get_attachment_url( $image->ID );
        $urls = $urls ."\n\t<option selected='selected' value=$name>$name</option>";
    }
    
	echo $urls;
}

function my_plugin_options() {
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
    ?>
<div class="wrap">
<h2>Your Plugin Name</h2>

<!-- <form method="post" action="options.php"> -->
<form method="POST" action="">
    <?php settings_fields( 'baw-settings-group' ); ?>
    <?php do_settings_sections( 'baw-settings-group' ); ?>
    <table class="form-table">
        <tr valign="top">
        <th scope="row">Select portrait image</th>
        <td><select name="default_role" id="default_role"><?php my_dropdown(); ?></select></td>
        </tr>
    </table>
    <?php submit_button(); ?>
</form>
    <?php
        $selected_val = $_POST['default_role']; 
        print_r($_POST['default_role']);
        update_option( 'new_option_name', $selected_val );
    ?>
</div>
<?php
    
}
?>