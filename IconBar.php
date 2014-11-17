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
 * Description of IconBar
 *
 * @author Nicola Tomassoni <nicola@digisin.it>
 */
class IconBar extends Widget{
  
  /**
   *
   * @var type array
   * 
   *  'icon' => 'fi-icon'
   *  'label' => 'label'
   * 	'url' => 'url'
   * 	'options' => []
   * 
   */
  public $items = [];
  
  public $encodeLabels = true;
  
  /**
   * 
   */
  public function init() {
    parent::init();
    
    Html::addCssClass($this->options, 'icon-bar');

    if (empty($this->options['role'])) {
      $this->options['role'] = 'navigation';
    }
    
    echo Html::beginTag('div', $this->options);
  }
  
  /**
   * 
   */
  public function run() {
    echo implode("\n", $this->renderItems());
    echo Html::endTag('div');
  }
  
  /**
   * 
   * @return type
   */
  public function renderItems() {
    $out = [];
    
    foreach ($this->items as $i => $item) {
      if(!empty($label)) {
      $encodeLabel = isset($item['encode']) ? $item['encode'] : $this->encodeLabels;
      $label = $encodeLabel ? Html::encode($item['label']) : $item['label'];
      } else {
        $label = '';
      }
      
      $options = ArrayHelper::getValue($item, 'options', []);
      $url = ArrayHelper::getValue($item, 'url', '#');
      
      $icon = Html::tag('i', $label, ['class' => $item['icon']]);
      Html::addCssClass($options, 'item');
      $options['role'] = 'button';
      $options['tabindex'] = 0;
      $out[] = Html::a($icon, $url, $options);
    }
    
    return $out;
  }
}
