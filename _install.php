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

$new_version = $core->plugins->moduleInfo('dcWikipedia', 'version');
$old_version = $core->getVersion('dcWikipedia');

if (version_compare($old_version, $new_version, '>=')) {
    return;
}


try {
    $core->blog->settings->addNamespace('dcwikipedia');
    $core->blog->settings->dcwikipedia->put('dcwp_add_lang_flag', true, 'boolean', 'Add Wikipedia lang flag', false, true);

    $core->setVersion('dcWikipedia', $new_version);

    return true;
} catch (Exception $e) {
    $core->error->add($e->getMessage());
}

return false;
