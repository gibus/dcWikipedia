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
if (!defined('DC_RC_PATH')) {
    return;
}

$this->registerModule(
    'dcWikipedia',
    'Search, find and link any word or expression on Wikipedia',
    'Tomtom & Gibus',
    '0.3.1',
    [
        'requires'    => [['core', '2.24']],
        'permissions' => dcCore::app()->auth->makePermissions([
            dcAuth::PERMISSION_USAGE,
            dcAuth::PERMISSION_CONTENT_ADMIN,
        ]),
        'type'        => 'plugin',
        'priority'    => dcModuleDefine::DEFAULT_PRIORITY + 6,
        'settings'    => [
            'self' => false,
        ],

        'details'     => 'https://plugins.dotaddict.org/dc2/details/dcWikipedia',
        'support'     => 'https://github.com/gibus/dcWikipedia',
        'repository'  => 'https://raw.githubusercontent.com/gibus/dcWikipedia/master/dcstore.xml',
    ]
);
