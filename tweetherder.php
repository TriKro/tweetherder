<?php
/**
 * @package Tweet Herder
 * @version 1.0
 */
/*
Plugin Name: Tweet Herder
Plugin URI: http://grasshopperherder.com/
Description: Adds TinyMCE button for Tweeting selected text in a post.
Author: Travis Vocino
Version: 1.0
Author URI: http://vocino.com/
*/

/**
  Set this to your tweet username.
  This is the only thing that needs to be set.
*/

$twittername = "TriKro";

/**
  Set up the shortcode
*/

function tweet_herder( $atts, $content = null ) {
  extract( shortcode_atts( array (
    'href' => get_permalink( $post->ID )
  ), $atts ) );
  global $twittername;
  return '<a href="http://twitter.com/share?url='.$href.'&text='.$content.'&via='.$twittername.'" rel="nofollow" title="Click here to tweet this." target="_blank" class="tweetherder">'.$content.'</a>';
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
        padding-right: 47px !important;
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