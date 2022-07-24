<?php
/**
* Plugin Name: Users View
* Description: Users view (import users and table view).
* Version: 1.0
* Author: Kosta Binov
**/

function register_top_level_menu_calc(){
	add_menu_page(
		'Users View',
		'Users View',
		'manage_options',
		'users-view-table',
		'display_top_level_menu_page_uesrs_view',
		'',
		6
	);
}
add_action( 'admin_menu', 'register_top_level_menu_calc' );

function display_top_level_menu_page_uesrs_view(){
	include( plugin_dir_path( __FILE__ ) . 'dashboard-settings.php');
}

function users_view_active() {
	add_option('users_view_activation_redirect', true);
}
register_activation_hook( __FILE__, 'users_view_active' );
add_action('admin_init', 'users_view_redirect');

function users_view_redirect() {
    if (get_option('users_view_activation_redirect', false)) {
        delete_option('users_view_activation_redirect');
		wp_redirect( get_home_url().'/wp-admin/admin.php?page=users-view-table', 301 ); exit;
    }
}

function users_view_shortcode(){
	ob_start();
	include( plugin_dir_path( __FILE__ ) . 'users-view-table.php');
	return ob_get_clean();
}
add_shortcode('users-view', 'users_view_shortcode'); 

function users_view_scripts(){
	wp_register_script('custom_js', plugins_url('/assets/js/script.js',__FILE__ ), array('jquery'), '', true);
	wp_enqueue_script('custom_js');

	wp_register_script('dataTables_js', 'https://cdn.datatables.net/1.12.1/js/jquery.dataTables.js', '', true);
	wp_enqueue_script('dataTables_js');

	wp_register_style( 'style', plugins_url( '/users-view/assets/css/style.css') );
	wp_enqueue_style( 'style' );

	wp_register_style( 'dataTables', 'https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css' );
	wp_enqueue_style( 'dataTables' );
}
add_action('wp_enqueue_scripts', 'users_view_scripts');

function users_view_enqueue($hook) {
    wp_register_script('custom_js_admin', plugins_url('/assets/js/admin-scripts.js',__FILE__ ), array('jquery'), '', true);
	wp_enqueue_script('custom_js_admin');

	wp_register_style( 'style_admin', plugins_url( '/users-view/assets/css/admin-style.css') );
	wp_enqueue_style( 'style_admin' );
}

add_action('admin_enqueue_scripts', 'users_view_enqueue');

global $usersSuccess;
global $errMessage;

class UsersImport{
	
	private $message = '<p class="">Please import the users</p>';

	public function importUsers(){
		if (isset($_POST['importUsers'])){
			$tmpName = $_FILES['csvDocument']['tmp_name'];
			$csvAsArray = array_map('str_getcsv', file($tmpName));
			$count = 0;
			foreach ($csvAsArray as $data){
				if ($count != 0){
					if ($data[0] != 'username' && $count == 0){
						$this->message = '<p class="errorUserss">Wrong file, please use the file provided in the task!</p>';
					} else {
						$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*()_+';
						$charactersLength = strlen($characters);
						$randomString = '';
						for ($i = 0; $i < 8; $i++) {
							$randomString .= $characters[rand(0, $charactersLength - 1)];
						}
						$password = $randomString;
			
						$user_id = wp_create_user( $data[0], $password, $data[1] );
						$u = new WP_User( $user_id );
						$u->remove_role( 'subscriber' );
						$u->add_role( $data[2] );
					}
				}
				$count ++;
			}
			$this->message = '<p class="usersSuccess">Succssfully imported users!</p>';
		}
	}
	public function print_message(){
		echo $this->message;
	}

}
$userImport = new UsersImport;

add_action( 'init', [ $userImport, 'importUsers' ] );
add_action( 'print_message', [ $userImport, 'print_message' ] );

