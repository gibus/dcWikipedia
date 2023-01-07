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
 * @copyright GPL-2.0 https://www.gnu.org/licenses/gpl-2.0.html
 */
if (!defined('DC_RC_PATH')) {
    return;
}

$this->registerModule(
		'dcWikipedia',                                               // Name
		'Search, find and link any word or expression on Wikipedia', // Description
		'Tomtom & Gibus',                                            // Author
		'0.3.1',                                                     // Version
    [
        'requires'    => [['core', '2.24']],                     // Dependencies
        'permissions' => 'usage,contentadmin',                   // Permissions
        'type'        => 'plugin',                               // Type
        'priority'    => 666,                                    // Priority
        'support'     => 'https://github.com/gibus/dcWikipedia', // Support URL
        'settings'    => [                                       // Settings
            'self' => false
        ]
    ]
);

?>
