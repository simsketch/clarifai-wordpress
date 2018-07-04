<?php
/**
 * @package clarifai_plugin
 * @version 1.1
 */
/*
Plugin Name: Clarifai Keyword Tagger for Featured Images
Plugin URI: http://wordpress.org/extend/plugins/#
Description: This is a Clarifai plugin for keyword tagging a post base on the Featured Image.
Author: Elon Zito
Version: 1.1
Updated: 7/4/2018
Author URI: http://github.com/simsketch/
*/
function wpdocs_theme_name_scripts() {
    wp_enqueue_script( 'script-name', get_template_directory_uri() . '/js/clarifai.js', array(), '1.0.0', true );
}
add_action( 'wp_enqueue_scripts', 'wpdocs_theme_name_scripts' );

function custom_meta_box_markup($object)
{
    wp_nonce_field(basename(__FILE__), "meta-box-nonce");
    ?>
        <div style="text-align:center;">
		    <img src="https://clarifai.com/cms-assets/20180307033326/logo2.svg" align="center" style="margin: 20px;width: 120px;"/>
		    <input type="button" id="goButton" value="Get Keywords" onclick="getTags()" style="width:100%;"/>
		    <div id="status"></div>
		    <script src="https://sdk.clarifai.com/js/clarifai-latest.js"></script>
		    <script>
		    //window.onload = function () { featuredImageTagger() }
			//window.goButton = document.getElementById('goButton');
		    //goButton.addEventListener('click', getTags());
	    	//debugger;
		    function getTags() {
		    	var img = document.querySelector('#postimagediv img').getAttribute("src");
		    	document.getElementById('status').innerHTML = 'Fetching tags...';
	    		var app = new Clarifai.App({
			        apiKey: '<?php echo get_option('clarifai_api_key')?>'
				});
		    	app.models.predict(Clarifai.GENERAL_MODEL, img).then(
				  function(response) {
				      console.log(response);
				      var el = document.getElementById('new-tag-post_tag');
				      var keywords = [];
					  var keywordTags = response.outputs[0].data.concepts;
					  //console.log("array: "+keywordTags);
				      for(var i=0;i<keywordTags.length;i++){
				        var name = keywordTags[i].name;
				      	keywords.push(name);
				      }
				      //console.log(keywords);
				      keywords = JSON.stringify(keywords);
					  keywords = keywords.replace(/"/g,"");
					  keywords = keywords.replace("[","");
					  keywords = keywords.replace("]","");
				      el.value = keywords;
				      document.querySelector('.tagadd').click();
				      window.savedClarifaiResponse = response;
				      document.getElementById('status').innerHTML = '';
				  },
				  function(err) {
				      console.error(err);
				      document.getElementById('status').innerHTML = 'Please enter API credentials';
				  }
				);
		    }
		    </script>
        </div>
    <?php  
}
function save_clarifai_data( $post_id ){
	// verify taxonomies meta box nonce
	if ( !isset( $_POST['clarifai_meta_box_nonce'] ) || !wp_verify_nonce( $_POST['clarifai_meta_box_nonce'], basename( __FILE__ ) ) ){
		return;
	}
	// return if autosave
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ){
		return;
	}
	// Check the user's permissions.
	if ( ! current_user_can( 'edit_post', $post_id ) ){
		return;
	}
	// store custom fields values
	if ( isset( $_REQUEST['ai_apiKey_value'] ) ) {
		update_post_meta( $post_id, 'ai_apiKey_value', sanitize_text_field( $_POST['ai_apiKey_value'] ) );
	}
	
	// store custom fields values
	if ( isset( $_REQUEST['ai_apiSecret'] ) ) {
		update_post_meta( $post_id, 'ai_apiSecret_value', sanitize_text_field( $_POST['ai_apiSecret_value'] ) );
	}
	
}
add_action( 'save_post_clarifai', 'save_clarifai_data' );

function add_custom_meta_box()
{
    add_meta_box("clarifai-meta-box", "Clarifai Image Recognition", "custom_meta_box_markup", "post", "side", "low", null);
}

add_action("add_meta_boxes", "add_custom_meta_box");

include('plugin_interface.php');