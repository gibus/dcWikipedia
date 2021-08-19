/*global $, CKEDITOR, dotclear */
CKEDITOR.dialog.add('dcWikipediaDialog', function (editor) {
    const str = editor.getSelection().getNative().toString();
    const lang = $('#post_lang').val();
    var results;
    $.ajax({
        url: dotclear.ck_dcwikipedia.admin_url+'/plugin.php?p=dcWikipedia&popup=1&json=1'+'&value='+encodeURIComponent(str)+'&lang='+encodeURIComponent(lang),
        cache: false,
        type: 'get',
        async: false,
        dataType: 'json',
        success: function(data) {
            results = data;
        }
    });

    var wpitems = [];
    for (var item in results) {
        wpitems.push([results[item].value, results[item].uri]);
    }
    
    return {
        title: dotclear.ck_dcwikipedia.title,
        minWidth: 400,
        minHeight: 150,
        contents: [
            {
                id: 'wp-items',
                label: dotclear.ck_dcwikipedia.tab_align,
                elements: [
                    {
                        type: 'radio',
                        id: 'wp-item',
                        label: dotclear.ck_dcwikipedia.add_label,
                        items: wpitems,
                        default: 'none',
                        className: 'wp-item'
                    },
                ],
            },
        ],
        onOk: function () {
            console.log("BLUP OK");
        },
        onShow: function () {
            console.log("BLUP Show");
            this.definition.removeContents('wp-items');
            console.log("BLUP Show AFTER removeContents");
            this.definition.addContents(
                {
                    id: 'wp-items',
                    label: dotclear.ck_dcwikipedia.tab_align,
                    elements: [
                        {
                            type: 'radio',
                            id: 'wp-item',
                            label: dotclear.ck_dcwikipedia.add_label,
                            items: ["BLUP0", "BLUP1"],
                            default: 'none',
                            className: 'wp-item'
                        },
                    ],
                }
            );
            console.log("BLUP Show AFTER addContents");
        },
  };
});
