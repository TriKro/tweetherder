<?php
/**
 * @package TweetHerder
 * @version 1.0
 */
/*
Plugin Name: TweetHerder
Plugin URI: http://grasshopperherder.com/
Description: Adds TinyMCE button for Tweeting selected text in a post.
Author: Travis Vocino, Tristan Kromer, Peter Backx
Version: 1.0
Author URI: http://grasshopperherder.com/
License: GPLv2

Copyright 2011 Tristan Kromer, Peter Backx, Travis Vocino (email : tristan@grasshopperherder.com)
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

/**
  Set up the shortcode
*/

function tweet_herder( $atts, $content = null ) {
  extract( shortcode_atts( array (
    'href' => get_permalink( $post->ID ),
    'text' => $content
  ), $atts ) );
  
  $options     = get_option('tweetherder_options');
  $twittername = $options['twitter_name'];
  $custom_css  = $options['custom_css'];
  $text        = urlencode($text);
    
  $share_link  = "http://twitter.com/share?url=$href&text=$text&via=$twittername&related=$twittername";
  $style_attr  = empty($custom_css) ? '' : 'style="' . $custom_css . '"';
  
  return '<a href="'. $share_link . '" rel="nofollow" title="Click here to tweet this." target="_blank" class="tweetherder" '. $style_attr . ' >'.$content.'</a>';
}

/**
  Create the Initialization Function
*/
 
function tweetherder_button() {
  if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') ) {
    return;
  }
  if ( get_user_option('rich_editing') == 'true' ) {
   add_filter( 'mce_external_plugins', 'add_plugin' );
   add_filter( 'mce_buttons', 'register_button' );
  }
}

/**
  Register the MCE Button
*/
 
function register_button( $buttons ) {
  array_push( $buttons, "|", "tweetherder" );
  return $buttons;
}

/**
  Register TinyMCE Plugin
*/
 
function add_plugin( $plugin_array ) {
  $plugin_array['tweetherder'] = WP_PLUGIN_URL.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__)) . 'tweetherder.js';
  return $plugin_array;
}

/**
  CSS for the Link
*/
function tweetherder_css() {
  echo "<style type='text/css'>
      a.tweetherder {
        padding-right: 52px !important;
        background: url(".WP_PLUGIN_URL.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__)) ."retweet.png) no-repeat right center !important;
      }
    </style>
    ";
}

/**
  Finally, Hook into WordPress
*/

add_action( 'wp_head', 'tweetherder_css' );
add_shortcode( 'tweetherder', 'tweet_herder' );
add_action('init', 'tweetherder_button');

/**
 * plugin activation code
 */
function tweetherder_create_options() {
    $options = array(
      'twitter_name' => 'TriKro',
      'custom_css' => ''
    );
    $dbOptions = get_option("tweetherder_options");
    if(!empty($dbOptions)) {
      foreach($dbOptions as $key => $option) {
        $options[$key] = $option;
      }
    }
    update_option("tweetherder_options", $options);
}

register_activation_hook(__FILE__, 'tweetherder_create_options');

/**
 * admin code
 */
if ( is_admin() ) {
	require_once(plugin_dir_path(__FILE__).'/includes/admin.php' );
	add_action('admin_menu', 'tweetherder_admin_menu');
	add_action('admin_init', 'tweetherder_admin_init');
}

?>
