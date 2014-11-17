<?php

/**
 *  @copyright Copyright &copy; Digisin soc. coop, digisin.it 2014
 *  @package nonzod/yii2-foundation
 *  @version 1.0.0
 */

namespace nonzod\foundation;

use nonzod\foundation\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\base\InvalidConfigException;

/**
 * Description of IconBar
 *
 * @author Nicola Tomassoni <nicola@digisin.it>
 */
class IconBar extends Widget {

  /**
   *
   * @var type array
   *  'icon' => string|array
   *    string: the icons name without prefix
   *    array: params for [[nonzod\foundation\helpers\Html::Icon]] object (['name' => '', 'options' => [], 'prefix' => '', 'tag' => ''])
   *  'img' => 'path/to/img'
   *    ignored if 'icon' is set
   *  'label' => 'label'
   * 	'url' => 'url'
   * 	'options' => []
   * 
   * examples:
   * 
   * Only icon's name
   * ~~~
   * 'items' => [
   *  ['icon' => 'home']
   * ]
   * ~~~
   * 
   * Icon's with parameters
   * ~~~
   * 'items' => [
   *    [
   *    'icon' => [
   *      'name' => 'trash', 
   *      'options' => ['class' => 'icon-class']
   *      ], 
   *    'url' => ['site/index']
   *    ]
   *  ]
   * ~~~
   * 
   * Icon as img
   * 
   * ~~~
   * 'items' => [
   *  ['img' => '/images/fi-info.svg', 'url' => ['site/index']]
   * ]
   * ~~~
   * 
   * 
   * @see [[nonzod\foundation\helpers\Html::icon()]]
   */
  public $items = [];

  /**
   *
   * @var boolean 
   */
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

    FoundationIconAsset::register($this->getView());
  }

  /**
   * 
   */
  public function run() {
    echo Html::beginTag('div', $this->options);
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
      if (!empty($item['label'])) {
        $encodeLabel = isset($item['encode']) ? $item['encode'] : $this->encodeLabels;
        $label = $encodeLabel ? Html::encode($item['label']) : $item['label'];
        $label = Html::tag('label', $label);
      } else {
        $label = '';
      }

      $options = ArrayHelper::getValue($item, 'options', []);
      $url = ArrayHelper::getValue($item, 'url', '#');

      if (isset($item['icon'])) {
        if (is_array($item['icon'])) {
          $iconOptions = ArrayHelper::getValue($item['icon'], 'options', []);
          $iconPrefix = ArrayHelper::getValue($item['icon'], 'prefix', 'fi-');
          $iconTag = ArrayHelper::getValue($item['icon'], 'tag', 'i');

          $icon = Html::icon($item['icon']['name'], $iconOptions, $iconPrefix, $iconTag);
        } else {
          $icon = Html::icon($item['icon']);
        }
      } elseif (isset($item['img'])) {
        $icon = Html::img($item['img']);
      } else {
        throw new InvalidConfigException("'icon' or 'img' must be set");
      }

      Html::addCssClass($options, 'item');
      $options['role'] = 'button';
      $options['tabindex'] = 0;
      $out[] = Html::a($icon.$label, $url, $options);
    }

    return $out;
  }

}
