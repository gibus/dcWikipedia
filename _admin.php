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
$core->addBehavior('adminPostEditor', ['dcWikipediaBehaviors', 'adminPostEditor']);
$core->addBehavior('ckeditorExtraPlugins', ['dcWikipediaBehaviors', 'ckeditorExtraPlugins']);

class dcWikipediaBehaviors
{
    public static function postHeaders()
    {
        global $core;
        
        $flag = 'no';
        $flag = $core->blog->settings->dcwikipedia->dcwp_add_lang_flag ? 'yes' : 'no';
        $params['post_id'] = $_REQUEST['id'];
        $post = $core->blog->getPosts($params);

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

    public static function adminPostEditor($editor = '', $context = '', array $tags = [], $syntax = '')
    {
        global $core;

        $rs = $core->blog->getLangs(array('order'=>'asc'));
        $all_langs = l10n::getISOcodes(0,1);
        $lang_combo = array('' => '', __('Most used') => array(), __('Available') => l10n::getISOcodes(1,1));
        while ($rs->fetch()) {
          if (isset($all_langs[$rs->post_lang])) {
            $lang_combo[__('Most used')][$all_langs[$rs->post_lang]] = $rs->post_lang;
            unset($lang_combo[__('Available')][$all_langs[$rs->post_lang]]);
          } else {
            $lang_combo[__('Most used')][$rs->post_lang] = $rs->post_lang;
          }
        }
        unset($rs);

        $res = '';
        if ($editor == 'dcCKEditor') {
            $res .= dcPage::jsJson('ck_editor_dcwikipedia', [
                'admin_url'     => DC_ADMIN_URL,
                'title'         => __('dcWikipedia'),
                'add_label'     => __('Add a Wikipedia link'),
                'most_used'     => __('Most used'),
                'available'     => __('Available'),
                'lang'          => __('Lang:'),
                'no_suggestion' => __('No suggestion found for : %s in %s'),
                'read_more'     => __('Read more...'),
                'cancel'        => __('cancel'),
                'insert'        => __('insert'),
                'langs'         => $lang_combo
            ]);
            $res .= dcPage::cssLoad(dcPage::getPF('dcWikipedia/cke-addon/style.css'));
        }

        return $res;
    }

    public static function ckeditorExtraPlugins(ArrayObject $extraPlugins, $context = '')
    {
        $extraPlugins[] = [
            'name'   => 'dcwikipedia',
            'button' => 'dcWikipedia',
            'url'    => DC_ADMIN_URL . 'index.php?pf=dcWikipedia/cke-addon/'
        ];
    }
}
