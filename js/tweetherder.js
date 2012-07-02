(function($) {
  $(function() {
    if(typeof _gaq=='undefined') {
      console.log("Google Analytics not correctly installed for TweetHerder analytics");
      return;
    }

    $(".tweetherder").each(function(index) {
      var tweettext = $(this).text();
      
      // track views
      _gaq.push(['_trackEvent', 'tweetherder', 'view', tweettext]);

      // track clicks
      $(this).click(function() {
        _gaq.push(['_trackEvent', 'tweetherder', 'click', tweettext]);
      });
    });

  });
})(jQuery);
