/**
 * @brief dcWikipedia, a plugin for Dotclear 2
 *
 * @package Dotclear
 * @subpackage Plugins
 *
 * @author Tomtom and Gibus
 *
 * @copyright Tomtom & Gibus
 * @copyright GPL-2.0-only
 */
$(function() {
  $('#dcwikipedia-insert-cancel').click(function() {
    window.close();
  });

  $('#dcwikipedia-insert-ok').click(
    function(e)
    {
      e.preventDefault();

      let editor = 0;
      try {
          editor = window.opener.CKEDITOR.instances[window.opener.$.getEditorName()];
      } catch (err) {
          console.log(err.name);
          console.log(err.message);
      }

      if (editor) {
        let link ='';
        const selected_text=editor.getSelection().getNative().toString();

        if (editor.mode=='wysiwyg') {
          if ($("input[name='dcwikipedia_uri']:checked").val().length > 0) {
            var dcWikipediaUri = $("input[name='dcwikipedia_uri']:checked").val();
            var dcWikipediaValue = $("input[name='dcwikipedia_value']").val();
            var dcWikipediaLang = $("input[name='dcwikipedia_lang']").val();

            link = '<a href="' + dcWikipediaUri + '" class="dcwikipedia" title="' + dcWikipediaValue + '"' + (dcWikipedia_option_langFlag == 'yes' ? ' hreflang="' + dcWikipediaLang + '"' : '') + '>' + selected_text + '</a>';
            const element = window.opener.CKEDITOR.dom.element.createFromHtml(link);
            editor.insertElement(element);
          }
        }
      } else {
        var insert_form = $('#dcwikipedia-insert-form').get(0);

        if (insert_form == undefined) { return; }

        var tb = window.opener.the_toolbar;
        var data = tb.elements.dcWikipedia.data;

        if ($("input[name='dcwikipedia_uri']:checked").val().length > 0) {
          data.dcWikipediaUri = $("input[name='dcwikipedia_uri']:checked").val();
          data.dcWikipediaValue = $("input[name='dcwikipedia_value']").val();
          data.dcWikipediaLang = $("input[name='dcwikipedia_lang']").val();

          tb.elements.dcWikipedia.fncall[tb.mode].call(tb);

        }
      }
      window.close();
    }
  );

  $('#lang').parent().toggleWithLegend($('#lang'),{});

  $($('#lang').get(0)).change(function() {
    $('#dcwikipedia-lang-form').submit();
  });
});
