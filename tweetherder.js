(function() {
    tinymce.create('tinymce.plugins.tweetherder', {
        init : function(ed, url) {
            ed.addButton('tweetherder', {
                title : 'Tweet Header',
                image : url+'/twitter.png',
                onclick : function() {
                     ed.selection.setContent('[tweetherder]' + ed.selection.getContent() + '[/tweetherder]');
 
                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('tweetherder', tinymce.plugins.tweetherder);
})();