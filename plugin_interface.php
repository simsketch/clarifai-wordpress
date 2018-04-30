<?php
// create custom plugin settings menu
add_action('admin_menu', 'clarifai_create_menu');

function clarifai_create_menu() {
	add_options_page('Clarifai AI', 'Clarifai AI', 'administrator', __FILE__, 'clarifai_settings_page');
	add_action('admin_init', 'register_clarifaisettings');
}

function register_clarifaisettings() {
	register_setting('clarifai-settings-group', 'clarifai_api_key');
	register_setting('clarifai-settings-group', 'clarifai_api_secret');
}

function clarifai_settings_page() {
	$clarifai_api_key = get_option('clarifai_api_key');
	$clarifai_api_secret = get_option('clarifai_api_secret');
	include('includes/clarifai_header.php');
	include('includes/clarifai_image_select.php');
	include('includes/clarifai_footer.php');
}