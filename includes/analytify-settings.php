<?php
  $wp_analytify = new WP_Analytify_Simple();

  if (! function_exists( 'curl_init' ) ) {
      esc_html_e('This plugin requires the CURL PHP extension');
    return false;
  }

  if (! function_exists( 'json_decode' ) ) {
    esc_html_e('This plugin requires the JSON PHP extension');
    return false;
  }

  if (! function_exists( 'http_build_query' )) {
    esc_html_e('This plugin requires http_build_query()');
    return false;
  }

  $url = http_build_query( array(
                                'next'          =>  admin_url('admin.php?page=analytify-settings'),
                                'scope'         =>  'https://www.googleapis.com/auth/analytics',
                                'response_type' =>  'code',
                                'redirect_uri'  =>  'urn:ietf:wg:oauth:2.0:oob',
                                'client_id'     =>  '958799092305-pfb9msi30152k3lfakbgauspuqr01g1d.apps.googleusercontent.com'
                                )
                          );

  // Save access code
  if ( isset( $_POST["save_code"]) and isset($_POST["access_code"]) ) {

    if( $wp_analytify->wpa_save_data( $_POST["access_code"] )){
        $update_message = '<div id="setting-error-settings_updated" class="updated settings-error below-h2"><p><strong>Access code saved.</strong></p></div>';
    }
  }

// Clear Authorization and other data
  if (isset($_POST[ "clear" ])) {

    delete_option( 'access_code' );
    delete_option('access_token');
    $update_message = '<div id="setting-error-settings_updated" class="updated settings-error below-h2"> 
                        <p><strong>Authentication Cleared login again.</strong></p></div>';
  }

    // Saving Profiles
  if (isset($_POST[ 'save_profile' ])) {

    update_option( 'pt_webprofile_dashboard', $_POST[ 'webprofile_dashboard' ] );

    $update_message = '<div id="setting-error-settings_updated" class="updated settings-error below-h2"> 
                        <p><strong>Your Google Analytics Profile Saved.</strong></p></div>';
  }

?>

<div class="wrap">
  <h2 class='opt-title'><span id='icon-options-general' class='analytics-options'><img src="<?php echo plugins_url('wp-analytify/images/wp-analytics-logo.png');?>" alt=""></span>
    <?php echo __( 'Analytify Plugin Settings', 'wp-analytify'); ?>
  </h2>
  
  <?php
  if (isset($update_message)) echo $update_message;
  
  if ( isset ( $_GET['tab'] ) ) $wp_analytify->pa_settings_tabs($_GET['tab']); 
  else $wp_analytify->pa_settings_tabs( 'authentication' );

  if ( isset ( $_GET['tab'] ) ) 
    $tab = $_GET['tab']; 
  else 
    $tab = 'authentication';
  
  // Authentication Tab section
  if( $tab == 'authentication' ) {
  ?>

  <form action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>" method="post" name="settings_form" id="settings_form">
    <table width="1004" class="form-table">
      <tbody>
      <?php if( get_option( 'access_token' ) ) { ?>
        <tr>
          <p>Do you want to re-authenticate ? Click reset button and get your new Access code.<p>
          
        </tr>
        <tr>
          <th><?php esc_html_e( 'Clear Authentication', 'wp-analytify' ); ?></th>
          <td><input type="submit" class="button-primary" value="Reset" name="clear" /></td>
        </tr>
      <?php 
      }
      else { ?>
        <tr>
          <th width="115"><?php esc_html_e( 'Authentication:' )?></th>
              <td width="877">
                    <a target="_blank" href="javascript:void(0);" onclick="window.open('https://accounts.google.com/o/oauth2/auth?<?php echo $url ?>','activate','width=700,height=500,toolbar=0,menubar=0,location=0,status=1,scrollbars=1,resizable=1,left=0,top=0');">Click here to Authenticate</a>
              </td>
        </tr>
        <tr>
              <th><?php esc_html_e('Your Access Code:')?> </th>
              <td>
                <input type="text" name="access_code" value="" style="width:450px;"/>
              </td>
        </tr>
        <tr>
          <th></th>
          <td>
            <p class="submit">
              <input type="submit" class="button-primary" value = "Save Changes" name = "save_code" />
            </p>
          </td>
        </tr>
      <?php } ?>
      </tbody>
    </table>
  </form>
  <?php
  } // endif
// Choose profiles for dashboard and posts at front/back.
if( $tab == 'profile' ){
  $profiles = $wp_analytify->pt_get_analytics_accounts();
  if( isset( $profiles ) ) { ?>
    <p><?php esc_html_e( 'Select profile for dashboard data.', 'wp-analytify' ); ?></p>

    <form action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>" method="post">
      <table width="1004" class="form-table">
        <tbody>
          <tr>
            <th width="115"><?php esc_html_e( 'Dashboard :', 'wp-analytify' );?></th>
            <td width="877">
                <select name='webprofile_dashboard' id='webprofile-dashboard'>
                  <?php foreach ($profiles->items as $profile) { ?>
                  <option value="<?php echo $profile[ 'id' ];?>"
                              <?php selected( $profile[ 'id' ], get_option( 'pt_webprofile_dashboard' )); ?>
                              >
                              <?php echo $profile[ 'websiteUrl' ];?> - <?php echo $profile[ 'name' ];?>
                  </option>
                  <?php } ?>
                </select>
            </td>
          </tr>
          <tr>
            <th></th>
            <td>
              <p class="submit">
                <input type="submit" name="save_profile" value="Save Changes" class="button-primary">
              </p>
            </td>
          </tr>
          <?php } ?>
      </tbody>
    </table>
  </form>
<?php } ?>

</div>
</div>
</div>