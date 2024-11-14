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

if (!dcCore::app()->newVersion(basename(__DIR__), dcCore::app()->plugins->moduleInfo(basename(__DIR__), 'version'))) {
    return;
}

try {
    dcCore::app()->blog->settings->addNamespace('dcwikipedia');
    dcCore::app()->blog->settings->dcwikipedia->put('dcwp_add_lang_flag', true, 'boolean', 'Add Wikipedia lang flag', false, true);

    return true;
} catch (Exception $e) {
    dcCore::app()->error->add($e->getMessage());
}

return false;
