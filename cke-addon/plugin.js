/*global CKEDITOR, dotclear */
'use strict';

dotclear.ck_dcwikipedia = dotclear.getData('ck_editor_dcwikipedia');

(function () {
    CKEDITOR.plugins.add('dcwikipedia', {
        requires: 'dialog',

        init: function (editor) {
            editor.addCommand('dcWikipediaCommand', new CKEDITOR.dialogCommand('dcWikipediaDialog'));

            CKEDITOR.dialog.add('dcWikipediaDialog', this.path + 'dialogs/popup.js');

            editor.ui.addButton('dcWikipedia', {
                label: dotclear.ck_dcwikipedia.title,
                command: 'dcWikipediaCommand',
                icon: this.path + 'icons/icon.png',
            });
        },
    });
})();
