<?php

/**
 *  @copyright Copyright &copy; Digisin soc. coop, digisin.it 2014
 *  @package nonzod/yii2-foundation
 *  @version 1.0.0
 */

namespace nonzod\foundation;

use yii\helpers\Html;
use yii\helpers\ArrayHelper;

/**
 * Description of SideNav
 *
 * @author Nicola Tomassoni <nicola@digisin.it>
 */
class SideNav extends NavigationWidget {

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
   * 
   */
  public $items = [];

  /**
   * 
   */
  public function run() {
    Html::addCssClass($this->options, 'side-nav');

    if (empty($this->options['role'])) {
      $this->options['role'] = 'navigation';
    }
    
    echo Html::tag('ul', implode("\n", $this->renderItems()), $this->options);
  }

  /**
   * 
   * @return type
   */
  public function renderItems() {
    $out = [];
    
    foreach ($this->items as $i => $item) {
      $encodeLabel = isset($item['encode']) ? $item['encode'] : $this->encodeLabels;
      $label = $encodeLabel ? Html::encode($item['label']) : $item['label'];
      $options = ArrayHelper::getValue($item, 'options', []);
      $url = ArrayHelper::getValue($item, 'url', '#');
      $linkOptions = ArrayHelper::getValue($item, 'linkOptions', []);

      if (isset($item['active'])) {
        $active = ArrayHelper::remove($item, 'active', false);
      } else {
        $active = $this->isItemActive($item);
      }

      if ($this->activateItems && $active) {
        Html::addCssClass($options, 'active');
      }

      $out[] = Html::tag('li', Html::a($label, $url, $linkOptions), $options);
    }
    
    return $out;
  }
}
