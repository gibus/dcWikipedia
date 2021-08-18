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
 * @copyright GPL-2.0 https://www.gnu.org/licenses/gpl-2.0.html
 */

if (!defined('DC_CONTEXT_ADMIN')) {
    return;
}

$core->addBehavior('adminPostHeaders',array('dcWikipediaBehaviors','postHeaders'));
$core->addBehavior('adminPageHeaders',array('dcWikipediaBehaviors','postHeaders'));
$core->addBehavior('adminRelatedHeaders',array('dcWikipediaBehaviors','postHeaders'));

class dcWikipediaBehaviors
{
	public static function postHeaders()
    {
        global $core;
        
        $flag = 'no';
        $flag = $core->blog->settings->dcwikipedia->dcwp_add_lang_flag ? 'yes' : 'no';

        return
        '<script type="text/javascript" src="index.php?pf=dcWikipedia/js/post.js"></script>'.
        '<script type="text/javascript">'."\n".
        "//<![CDATA[\n".
        dcPage::jsVar('jsToolBar.prototype.elements.dcWikipedia.title',__('Wikipedia')).
        dcPage::jsVar('dcWikipedia.option.langFlag',$flag).
        dcPage::jsVar('dcWikipedia.msg.noselection',__('Please, select a word or an expression')).
        "\n//]]>\n".
        "</script>\n";
    }
}
