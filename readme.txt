=== TweetHerder ===

Contributors: Travis Vocino, trikro, pbackx
Donate link: http://grasshopperherder.com/
Tags: plugin, widget, automatic, ad, manage
Requires at least: 3.0
Tested up to: 3.2.1
Stable tag: 1.0


== Description ==

TweetHerder introduces a shortcode to easily add "Tweet This" buttons to quotes inside your posts. Mark any piece of text inside a post or page as "tweetable" and TweetHerder will automatically add a "Tweet This" button. 


== Installation ==

Install through the admin interface, or manually in wp-content/plugins/tweetherder

Once TweetHerder is enabled, you should configure the Twitter user on the settings page. You can leave the custom CSS field blank if you're happy with the default.


== Frequently Asked Questions ==

= How do I mark a piece of my post as tweetable =

* In the visual editor: mark the selection you want to tweet and click the big T button.
* In the HTML editor: add the [tweetherder] shortcode around the fragment you want to tweet.

= Can I change the tweeted text? =

By default, TweetHerder will tweet the text inside the shortcode. If you want to tweet something else, add the "text" parameter. For instance:

    [tweetherder text="Text to be tweeted"]A nice quote[/tweetherder]

= Can I change the style? =

Yes you can. 

* TweetHerder attaches the "tweetherder" class to the link. You can use that in your stylesheets. 
* In the settings page there is a custom CSS field. All CSS entered there will be added verbatim to the "style" tag.

== Screenshots ==

1. Example of a Tweet button inside a post.
2. Tweetherder settings screen.


== Changelog ==

= Version 1.0 =

* Initial version.
