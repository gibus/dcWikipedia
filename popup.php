<?php
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
$value = isset($_GET['value']) ? rawurldecode($_GET['value']) : '';
$lang  = isset($_GET['lang']) ? rawurldecode($_GET['lang']) : '';

$parser = dcWikipediaReader::quickParse('http://' . $lang . '.wikipedia.org/w/api.php?action=opensearch&format=xml&search=' . rawurlencode($value), DC_TPL_CACHE);

$flag = 'no';
$flag = dcCore::app()->blog->settings->dcwikipedia->dcwp_add_lang_flag ? 'yes' : 'no';

?>

<html>
<head>
    <title><?php echo __('dcWikipedia'); ?></title>
    <?php echo dcPage::jsLoad(DC_ADMIN_URL . '?pf=dcWikipedia/js/popup.js'); ?>
    <style type="text/css">@import '<?php echo DC_ADMIN_URL; ?>?pf=dcWikipedia/style.css';</style>
  <script type="text/javascript">
  //<![CDATA[
  const dcWikipedia_option_langFlag = '<?php echo $flag; ?>';
  //]]>
  </script>
</head>

<body>
<h2><?php echo __('Add a Wikipedia link'); ?></h2>

<?php

$rs         = dcCore::app()->blog->getLangs(['order' => 'asc']);
$all_langs  = l10n::getISOcodes(false, true);
$lang_combo = ['' => '', __('Most used') => [], __('Available') => l10n::getISOcodes(true, true)];
while ($rs->fetch()) {
    if (isset($all_langs[$rs->field('post_lang')])) {
        $lang_combo[__('Most used')][$all_langs[$rs->field('post_lang')]] = $rs->field('post_lang');
        unset($lang_combo[__('Available')][$all_langs[$rs->field('post_lang')]]);
    } else {
        $lang_combo[__('Most used')][$rs->field('post_lang')] = $rs->field('post_lang');
    }
}
unset($rs);

echo
'<form id="dcwikipedia-lang-form" action="' . DC_ADMIN_URL . 'plugin.php" method="get">' .
form::hidden('p', 'dcWikipedia') .
form::hidden('popup', '1') .
form::hidden('value', $value) .
'<p><label for="lang">' . __('Lang:') . '' .
form::combo('lang', $lang_combo, $lang) .
'</label></p>' .
dcCore::app()->formNonce() .
'</form>';

if (count($parser->getItems()) == 0) {
    echo
    '<p>' . sprintf(
        __('No suggestion found for : %s in %s'),
        '<strong><q>' . $value . '</q></strong>',
        '<em>' . $all_langs[$lang] . '</em>'
    ) . '</p>';
} else {
    echo '<form id="dcwikipedia-insert-form" action="#" method="get">';
    foreach ($parser->getItems() as $v => $k) {
        echo
        '<div class="dcwikipedia_item">' .
        '<p class="wikipedia_value">' .
        form::radio(['dcwikipedia_uri'], $k['uri']) .
        $k['value'] . '&nbsp;<a href="' . $k['uri'] .
        '" class="wikipedia_uri">(' . __('Read more...') . ')</a></p>' .
        '<p class="wikipedia_desc">' . $k['desc'] . '</p>' .
        '</div>' . "\n";
    }
    echo
    '<input type="hidden" name="dcwikipedia_value" value="' . $value . '" />' .
    '<input type="hidden" name="dcwikipedia_lang" value="' . $lang . '" />' .
    '</form>' .
    '<p><a class="button" href="#" id="dcwikipedia-insert-cancel">' . __('cancel') . '</a> - ' .
    '<strong><a class="button" href="#" id="dcwikipedia-insert-ok">' . __('insert') . '</a></strong></p>' . "\n";
}

?>

</body>
</html>
