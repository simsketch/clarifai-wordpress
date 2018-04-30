<style>
.form-table.noborder td, .form-table.noborder th{ border:none;}
</style>
<table class="wp-list-table widefat fixed bookmarks">
    <thead>
        <tr>
            <th>Clarifai AI API settings</th>
        </tr>
    </thead>
    <tbody>
    <tr>
        <td>
			<form method="post" action="options.php">
			<?php settings_fields( 'clarifai-settings-group' ); ?>
            <table class="form-table noborder">
                <tr valign="top">
                    <th scope="row">Paste in your API keys, then click Save Changes.</th>
                    <td>
            <label for="clarifai_api_key">API key</label>
            <input type="text" id="clarifai_api_key" name="clarifai_api_key" placeholder="API key" value="<?php echo $clarifai_api_key?>" />
            <br/>
            <label for="clarifai_api_secret">API secret</label>
            <input type="text" id="clarifai_api_secret" name="clarifai_api_secret" placeholder="API secret" value="<?php echo $clarifai_api_secret ?>" />
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">&nbsp;</th>
                    <td bordercolor="red">
                        <input type="submit" name="submit-bpu" class="button-primary" value="<?php _e('Save Changes') ?>" />
                    </td>
                </tr>
               
            </table>
        </form><br />

            
</td>
</tr>
</tbody>
</table><br/>