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

namespace Dotclear\Plugin\dcWikipedia;

use ArrayObject;
use Dotclear\App;
use Dotclear\Core\Process;

class Prepend extends Process
{
    public static function init(): bool
    {
        return self::status(App::config()->configPath() != '');
    }

    public static function process(): bool
    {
        if (!self::status()) {
            return false;
        }

        return true;
    }
}
