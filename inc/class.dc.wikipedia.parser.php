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

class dcWikipediaParser
{
	protected $xml;
	protected $items;

	public function __construct($data)
	{
		$this->xml = @simplexml_load_string($data);

		if (!$this->xml) {
			return false;
		}

		$this->_parse();
		unset($data);
		unset($this->xml);
	}

	protected function _parse()
	{
		if ($this->xml)
		{
			if (empty($this->xml->Section)) {
				return;
			}

			foreach ($this->xml->Section->Item as $i)
			{
				$item = array();

				$item['value']		= (string) $i->Text;
				$item['desc']		= (string) $i->Description;
				$item['uri']		= (string) $i->Url;

				$this->items[$item['value']] = $item;
			}
		}
	}

	public function getItems()
	{
		return $this->items;
	}
}

?>
