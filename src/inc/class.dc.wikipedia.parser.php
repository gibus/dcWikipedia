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

class dcWikipediaParser
{
    protected $xml;
    protected $items;

    public function __construct($data)
    {
        $this->xml = @simplexml_load_string($data);

        if ($this->xml) {
            $this->_parse();
            unset($data, $this->xml);
        }
    }

    protected function _parse()
    {
        if ($this->xml) {
            if (empty($this->xml->Section)) {
                return [];
            }

            foreach ($this->xml->Section->Item as $i) {
                $item = [];

                $item['value'] = (string) $i->Text;
                $item['desc']  = (string) $i->Description;
                $item['uri']   = (string) $i->Url;

                $this->items[$item['value']] = $item;
            }
        }
    }

    public function getItems()
    {
        return $this->items;
    }
}
