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
 * Description of TopBar
 *
 * @author Nicola Tomassoni <nicola@digisin.it>
 */
class TopBar extends Widget {

  public $options = ['data-topbar' => ''];
  public $containerOptions = [];
  public $titleLabel;
  public $titleLink;
  public $titleOptions = [];
  public $toggleText = 'Menu';
  public $showToggleIcon = true;
  public $toggleOptions = ['class' => 'toggle-topbar'];

  /**
   * 
   */
  public function init() {
    parent::init();

    Html::addCssClass($this->options, 'top-bar');

    if (empty($this->options['role'])) {
      $this->options['role'] = 'navigation';
    }

    $options = $this->options;
    $tag = ArrayHelper::remove($options, 'tag', 'nav');

    echo Html::beginTag($tag, $options);
    echo Html::tag('ul', implode("\n", $this->headerItems()), ['class' => 'title-area']);
  }

  /**
   * 
   */
  public function run() {
    $tag = ArrayHelper::remove($this->options, 'tag', 'nav');
    echo Html::endTag($tag);
    
    $this->registerPlugin();
  }

  /**
   * 
   */
  protected function headerItems() {
    Html::addCssClass($this->titleOptions, 'name');
    
    $title = Html::tag('h1', Html::a($this->titleLabel, $this->titleLink));

    if ($this->showToggleIcon) {
      Html::addCssClass($this->toggleOptions, 'menu-icon');
    }

    return [
        Html::tag('li', $title, $this->titleOptions),
        Html::tag('li', Html::a(Html::tag('span', $this->toggleText), '#'), $this->toggleOptions)
    ];
  }
}
