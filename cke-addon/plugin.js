/*global CKEDITOR, dotclear */
'use strict';

dotclear.ck_dcwikipedia = dotclear.getData('ck_editor_dcwikipedia');

(function () {
    CKEDITOR.plugins.add('dcwikipedia', {
        init: function (editor) {
            const popup_params={width:760,height:500,};
            editor.addCommand('dcWikipediaCommand', {
                exec: function(editor) {
                    const str = editor.getSelection().getNative().toString();
                    const lang = $('#post_lang').val();
                    if (str != '') {
                        $.toolbarPopup('plugin.php?p=dcWikipedia&popup=1'+'&value='+encodeURIComponent(str)+'&lang='+encodeURIComponent(lang), popup_params);
                    }
                },
            });

            editor.ui.addButton('dcWikipedia', {
                label: dotclear.ck_dcwikipedia.title,
                command: 'dcWikipediaCommand',
                icon: this.path + 'icons/icon.png',
                toolbar: 'insert',
            });
        },
    });
})();
