<?php
/**
 * @brief dcWikipedia, a plugin for Dotclear 2
 *
 * @package Dotclear
 * @subpackage Plugin
 *
 * @author Tomtom & Gibus
 *
 * @copyright Tomtom, Gibus gibus@sedrati.xyz
 * @copyright WTFLP Version 2 http://www.wtfpl.net/
 */
declare(strict_types=1);

namespace Dotclear\Plugin\dcWikipedia;

use ArrayObject;
use Dotclear\App;
use Dotclear\Core\Backend\Page;

class BackendBehaviors
{
    public static function adminPostEditor($editor = '')
    {
        $flag = 'no';
        $flag = App::blog()->settings->dcwikipedia->dcwp_add_lang_flag ? 'yes' : 'no';

        $res = '';
        if ($editor == 'dcLegacyEditor') {
            $res = Page::jsJson('dc_editor_dcwikipedia', [
                'title'       => __('Wikipedia'),
                'langFlag'    => $flag,
                'noselection' => __('Please, select a word or an expression'),
            ]) .
            My::jsLoad('post.js');
        } elseif ($editor == 'dcCKEditor') {
            $res = Page::jsJson('ck_editor_dcwikipedia', [
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
