<?php
/*
Copyright 2011 Tristan Kromer, Peter Backx (email : tristan@grasshopperherder.com)
This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.
This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA
*/

// TweetHeder MCE button
function tweetherder_button() {
  if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') ) {
    return;
  }
  if ( get_user_option('rich_editing') == 'true' ) {
   add_filter( 'mce_external_plugins', 'tweetherder_add_plugin' );
   add_filter( 'mce_buttons', 'tweetherder_register_button' );
  }
}

function tweetherder_register_button( $buttons ) {
  array_push( $buttons, "|", "tweetherder" );
  return $buttons;
}

function tweetherder_add_plugin( $plugin_array ) {
  $plugin_array['tweetherder'] = plugins_url('js/tweetherder-admin.js',dirname(__FILE__));
  return $plugin_array;
}


// TweetHerder admin menu
function tweetherder_admin_menu () {
	add_options_page('TweetHerder', 'TweetHerder', 'manage_options', 'tweetherder', 'tweetherder_options_page');
}

function tweetherder_admin_init () {
	register_setting('tweetherder_options', 'tweetherder_options');
	
	add_settings_section('tweetherder_main', 'Settings', 'tweetherder_main_text', 'tweetherder');
	add_settings_field('tweetherder_twitter_name', 'Twitter username',      'tweetherder_twitter_name_input', 'tweetherder', 'tweetherder_main');
	add_settings_field('tweetherder_custom_css',   'Custom CSS (optional)', 'tweetherder_custom_css_input',   'tweetherder', 'tweetherder_main');
	add_settings_field('tweetherder_analytics',    'Enable analytics',      'tweetherder_analytics_input',    'tweetherder', 'tweetherder_main');
}

function tweetherder_main_text() { ?>
	<p>Configure the TweetHerder plugin here.</p>
	<p><em>Important</em> For TweetHerder Analytics, you need to have the asynchronuous Google Analytics tracking code installed.
		May we suggests <a href="http://wordpress.org/extend/plugins/google-analyticator/">Google Analyticator</a>.
	</p>
<?php }

function tweetherder_twitter_name_input() {
	$options = get_option('tweetherder_options');
	$value   = $options['twitter_name'];
	echo "<input id='twitter_name' name='tweetherder_options[twitter_name]' type='text' value='$value' />";
}

function tweetherder_custom_css_input() {
	$options = get_option('tweetherder_options');
	$value   = $options['custom_css'];
	echo "<input id='custom_css' name='tweetherder_options[custom_css]' type='text' value='$value' />";
}

function tweetherder_analytics_input() {
	$options = get_option('tweetherder_options');
	$value   = $options['analytics'];
	echo "<input id='analytics' name='tweetherder_options[analytics]' type='checkbox' value='1' " 
		. checked(1, $value, false)
		. "/>";
}

function tweetherder_options_page() {
	?>
	<div class="wrap">
		<?php screen_icon(); ?>
		<h2>TweetHerder</h2>
		
		<?php include(plugin_dir_path(__FILE__).'/../template/feedback.php'); ?>

		<form style="float: left; width: 70%;" action="options.php" method="post">
			<?php
				settings_fields('tweetherder_options');
				do_settings_sections('tweetherder');
			?>
			<input name="submit" type="submit" value="Save Changes"/>
		</form>
	</div>
	<?php
}
?>
