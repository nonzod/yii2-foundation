<?php

/**
 *  @copyright Copyright &copy; Digisin soc. coop, digisin.it 2014
 *  @package nonzod/yii2-foundation
 *  @version 1.0.0
 */

namespace nonzod\foundation;

use Yii;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

/**
 * Description of TopBarSection
 *
 * @author Nicola Tomassoni <nicola@digisin.it>
 */
class TopBarSection extends NavigationWidget {

  /**
   *
   * @var type array
   * 
   *  'label' => 'label'
   * 	'url' => 'url'
   * 	'linkOptions' => []
   * 	'options' => []
   * 	'active => true|false
   *  'visible => true|false
   * 	'items' => [],
   * 	'position' => 'left|right'
   * 
   */
  public $items = [];

  /**
   * 
   */
  public function run() {
    echo Html::beginTag('section', ['class' => 'top-bar-section']);
    echo $this->renderItems();
    echo Html::endTag('section');

    FoundationAsset::register($this->getView());

  }

  /**
   * 
   * @param type $childrens
   * @return type
   */
  public function renderItems($childrens = null) {
    $items = [];
    $out = '';

    $elements = $childrens != null ? $childrens : $this->items;

    foreach ($elements as $i => $item) {
      $position = isset($item['position']) ? $item['position'] : 'right';

      if (isset($item['visible']) && !$item['visible']) {
        unset($items[$i]);
        continue;
      }

      $items[$position][] = $this->renderItem($item);
    }

    
    
    if (isset($items['left'])) {
      $class = $childrens != null ? 'dropdown' : 'left';
      $out .= Html::tag('ul', implode("\n", $items['left']), ['class' => $class]);
    }

    if (isset($items['right'])) {
      $class = $childrens != null ? 'dropdown' : 'right';
      $out .= Html::tag('ul', implode("\n", $items['right']), ['class' => $class]);
    }

    return $out;
  }

  /**
   * 
   * @param type $item
   * @return type
   * @throws InvalidConfigException
   */
  public function renderItem($item) {
    if (is_string($item)) {
      return $item;
    }

    if (!isset($item['label'])) {
      throw new InvalidConfigException("The 'label' option is required.");
    }

    $encodeLabel = isset($item['encode']) ? $item['encode'] : $this->encodeLabels;
    $label = $encodeLabel ? Html::encode($item['label']) : $item['label'];
    $options = ArrayHelper::getValue($item, 'options', []);
    $items = ArrayHelper::getValue($item, 'items');
    $url = ArrayHelper::getValue($item, 'url', '#');
    $linkOptions = ArrayHelper::getValue($item, 'linkOptions', []);

    if (isset($item['active'])) {
      $active = ArrayHelper::remove($item, 'active', false);
    } else {
      $active = $this->isItemActive($item);
    }

    if ($items !== null) {
      Html::addCssClass($options, 'has-dropdown');

      if (is_array($items)) {
        if ($this->activateItems) {
          $items = $this->isChildActive($items, $active);
        }
        
        $items = $this->renderItems($items);
      }
    }

    if ($this->activateItems && $active) {
      Html::addCssClass($options, 'active');
    }

    return Html::tag('li', Html::a($label, $url, $linkOptions) . $items, $options);
  }
}
