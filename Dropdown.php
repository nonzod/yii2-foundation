<?php

/**
 *  @copyright Copyright &copy; Digisin soc. coop, digisin.it 2014
 *  @package nonzod/yii2-foundation
 *  @version 1.0.0
 */

namespace nonzod\foundation;

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\base\InvalidConfigException;

/**
 * Description of SplitButton
 *
 * @author Nicola Tomassoni <nicola@digisin.it>
 */
class Dropdown extends Widget {

  /**
   * @var array|string List of dropdown elements or html content
   * 
   * if array set :
   * - label: string, required, the label of the item link
   * - url: string, optional, the url of the item link. Defaults to "#".
   * - visible: boolean, optional, whether this menu item is visible. Defaults to true.
   * - linkOptions: array, optional, the HTML attributes of the item link.
   * - options: array, optional, the HTML attributes of the item.
   *
   * Use as a string for html content.
   */
  public $items;

  /**
   * @var boolean whether the labels for header items should be HTML-encoded.
   */
  public $encodeLabels = true;

  /**
   * @var array the HTML attributes for the widget container tag.
   * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
   */
  protected $_containerOptions = [];

  /**
   * Initializes the widget.
   * If you override this method, make sure you call the parent implementation first.
   */
  public function init() {
    parent::init();

    Html::addCssClass($this->options, 'f-dropdown');
    $this->options['data-dropdown-content'] = 1;
    $this->options['tabindex'] = '-1';
    $this->_containerOptions = $this->options;
  }

  /**
   * Renders the widget.
   */
  public function run() {
    echo $this->renderDropdown($this->items);
    $this->registerPlugin('dropdown');
  }

  protected function renderDropdown($items) {
    if (is_string($items)) {
      $items = $this->renderAsContent($items);
    } else {
      $items = $this->renderAsItems($items);
    }
    
    return Html::tag('ul', $items, $this->_containerOptions);
  }

  /**
   * Renders menu items.
   * @param array $items the menu items to be rendered
   * @return string the rendering result.
   * @throws InvalidConfigException if the label option is not specified in one of the items.
   */
  protected function renderAsItems($items) {
    $lines = [];
    foreach ($items as $i => $item) {
      if (isset($item['visible']) && !$item['visible']) {
        unset($items[$i]);
        continue;
      }
      if (is_string($item)) {
        $lines[] = $item;
        continue;
      }
      if (!isset($item['label'])) {
        throw new InvalidConfigException("The 'label' option is required.");
      }

      $encodeLabel = isset($item['encode']) ? $item['encode'] : $this->encodeLabels;
      $label = $encodeLabel ? Html::encode($item['label']) : $item['label'];
      $options = ArrayHelper::getValue($item, 'options', []);
      $linkOptions = ArrayHelper::getValue($item, 'linkOptions', []);
      $content = Html::a($label, ArrayHelper::getValue($item, 'url', '#'), $linkOptions);
      $lines[] = Html::tag('li', $content, $options);
    }

    return implode("\n", $lines);
  }

  protected function renderAsContent($item) {
    return Html::encode($item);
  }
}
