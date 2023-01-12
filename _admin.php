<?php
/**
 * @brief dcWikipedia, a plugin for Dotclear 2
 *
 * @package Dotclear
 * @subpackage Plugins
 *
 * @author Tomtom and Gibus
 *
 * @copyright Tomtom, Gibus gibus@sedrati.xyz
 * @copyright WTFLP Version 2 http://www.wtfpl.net/
 */
if (!defined('DC_CONTEXT_ADMIN')) {
    return;
}

dcCore::app()->addBehavior('ckeditorExtraPlugins', [dcWikipediaBehaviors::class, 'ckeditorExtraPlugins']);
dcCore::app()->addBehavior('adminPostEditor', [dcWikipediaBehaviors::class,'adminPostEditor']);

class dcWikipediaBehaviors
{
    public static function adminPostEditor($editor = '')
    {
        $flag = 'no';
        $flag = dcCore::app()->blog->settings->dcwikipedia->dcwp_add_lang_flag ? 'yes' : 'no';

        $res = '';
        if ($editor == 'dcLegacyEditor') {
            $res = dcPage::jsJson('dc_editor_dcwikipedia', [
                'title'       => __('Wikipedia media'),
                'langFlag'    => $flag,
                'noselection' => __('Please, select a word or an expression'),
            ]) .
            dcPage::jsModuleLoad('dcWikipedia/js/post.js', dcCore::app()->getVersion('dcWikipedia'));
        } elseif ($editor == 'dcCKEditor') {
            $res = dcPage::jsJson('ck_editor_dcwikipedia', [
                'title' => __('Wikipedia'),
            ]);
        }

        return $res;
    }

    public static function ckeditorExtraPlugins(ArrayObject $extraPlugins, $context = '')
    {
        $extraPlugins[] = [
            'name'   => 'dcwikipedia',
            'button' => 'dcWikipedia',
            'url'    => DC_ADMIN_URL . 'index.php?pf=dcWikipedia/cke-addon/',
        ];
    }
}
