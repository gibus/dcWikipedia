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

$popup = isset($_GET['popup']) ? true : false;

if ($popup) {
    require dirname(__FILE__) . '/popup.php';
}
