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
		function()
		{
			var insert_form = $('#dcwikipedia-insert-form').get(0);

			if (insert_form == undefined) { return; }

			var tb = window.opener.the_toolbar;
			var data = tb.elements.dcWikipedia.data;

			if ($("input[name='dcwikipedia_uri']:checked").val().length > 0)
			{
				data.dcWikipediaUri = $("input[name='dcwikipedia_uri']:checked").val();
				data.dcWikipediaValue = $("input[name='dcwikipedia_value']").val();
				data.dcWikipediaLang = $("input[name='dcwikipedia_lang']").val();

				tb.elements.dcWikipedia.fncall[tb.mode].call(tb);

				window.close();
			}
		}
	);

	$('#lang').parent().toggleWithLegend($('#lang'),{});

	$($('#lang').get(0)).change(function() {
		$('#dcwikipedia-lang-form').submit();
	});
});
