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

use Dotclear\App;
use Dotclear\Core\Backend\Combos;
use Dotclear\Core\Backend\Page;
use Dotclear\Helper\Html\Form\Button;
use Dotclear\Helper\Html\Form\Div;
use Dotclear\Helper\Html\Form\Form;
use Dotclear\Helper\Html\Form\Hidden;
use Dotclear\Helper\Html\Form\Label;
use Dotclear\Helper\Html\Form\Link;
use Dotclear\Helper\Html\Form\Para;
use Dotclear\Helper\Html\Form\Radio;
use Dotclear\Helper\Html\Form\Select;
use Dotclear\Helper\Html\Form\Text;
use Dotclear\Helper\L10n;

$value = isset($_GET['value']) ? rawurldecode($_GET['value']) : '';
$lang  = isset($_GET['lang']) ? rawurldecode($_GET['lang']) : '';

$parser = dcWikipediaReader::quickParse('http://' . $lang . '.wikipedia.org/w/api.php?action=opensearch&format=xml&search=' . rawurlencode($value), DC_TPL_CACHE);

$flag = 'no';
$flag = App::blog()->settings->dcwikipedia->dcwp_add_lang_flag ? 'yes' : 'no';

$head = My::jsLoad('popup') . My::cssLoad('style');

Page::openModule(My::name(), $head);

echo (new Text('h2', __('Add a Wikipedia link')))->render();

$lang_combo = Combos::getLangsCombo(App::blog()->getLangs(['order' => 'asc']), true);
$all_langs  = L10n::getISOcodes(false, true);

echo (new Form('dcwikipedia-lang-form'))
    ->action(My::manageUrl())
    ->method('get')
    ->fields([
        (new Hidden('process', 'Plugin')),
        (new Hidden('p', 'dcWikipedia')),
        (new Hidden('popup', '1')),
        (new Hidden('value', $value)),
        (new Para())->items([
            (new Select('lang'))
                ->label(new Label(__('Language:'), Label::INSIDE_LABEL_BEFORE))
                ->items($lang_combo)
                ->default($lang),
        ]),
        App::nonce()->formNonce(),
    ])
->render();

$items = $parser->getItems();
if (!$items) {
    echo
    '<p>' . sprintf(
        __('No suggestion found for : %s in %s'),
        '<strong><q>' . $value . '</q></strong>',
        '<em>' . $all_langs[$lang] . '</em>'
    ) . '</p>';
} else {
    $choices = [];
    foreach ($items as $v => $k) {
        $choices[] = (new Div())->class('dcwikipedia_item')->items([
            (new Para())->class('wikipedia_value')->items([
                (new Radio('dcwikipedia_uri'))
                    ->value($k['uri']),
                (new Text(null, $k['value'] . '&nbsp;' . (new Link())->href($k['uri'])->class('wikipedia_uri')->text(__('Read more...'))->render())),
                (new Para())->class('wikipedia_desc')->items([
                    (new Text(null, $k['desc'])),
                ]),
            ]),
        ]);
    }

    echo (new Form('dcwikipedia-insert-form'))
        ->method('get')
        ->fields([
            (new Para())->items([
                ...$choices,
            ]),
            (new Hidden('dcwikipedia_value', $value)),
            (new Hidden('dcwikipedia_lang', $lang)),
            (new Hidden('dcwikipedia_langFlag', $flag)),
            (new Button('dcwikipedia-insert-ok'))
                ->class('submit')
                ->value(__('Insert')),
            (new Button('dcwikipedia-insert-cancel'))
                ->class('submit')
                ->value(__('Cancel')),
        ])
        ->render();
}

Page::closeModule();
