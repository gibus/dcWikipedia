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

dcCore::app()->addBehavior('adminPostHeaders',array('dcWikipediaBehaviors','postHeaders'));
dcCore::app()->addBehavior('adminPageHeaders',array('dcWikipediaBehaviors','postHeaders'));
dcCore::app()->addBehavior('adminRelatedHeaders',array('dcWikipediaBehaviors','postHeaders'));
dcCore::app()->addBehavior('ckeditorExtraPlugins', ['dcWikipediaBehaviors', 'ckeditorExtraPlugins']);

class dcWikipediaBehaviors
{
    public static function postHeaders()
    {
        $flag = 'no';
        $flag = dcCore::app()->blog->settings->dcwikipedia->dcwp_add_lang_flag ? 'yes' : 'no';
        $params['post_id'] = $_REQUEST['id'];
        $params['post_type'] = '';
        $post = dcCore::app()->blog->getPosts($params);

        $res = '';
        if (!$post->isEmpty() && $post->post_format == 'wiki') {
            $res .=
                '<script type="text/javascript" src="index.php?pf=dcWikipedia/js/post.js"></script>'.
                '<script type="text/javascript">'."\n".
                "//<![CDATA[\n".
                dcPage::jsVar('jsToolBar.prototype.elements.dcWikipedia.title',__('Wikipedia')).
                dcPage::jsVar('dcWikipedia.option.langFlag',$flag).
                dcPage::jsVar('dcWikipedia.msg.noselection',__('Please, select a word or an expression')).
                "\n//]]>\n".
                "</script>\n";
        }

        return $res;
    }

    public static function ckeditorExtraPlugins(ArrayObject $extraPlugins, $context = '') {
        $extraPlugins[] = [
            'name'   => 'dcwikipedia',
            'button' => 'dcWikipedia',
            'url'    => DC_ADMIN_URL . 'index.php?pf=dcWikipedia/cke-addon/'
        ];
    }
}
