<?php

/**
 *  @copyright Copyright &copy; Digisin soc. coop, digisin.it 2014
 *  @package nonzod/yii2-foundation
 *  @version 1.0.0
 */

namespace nonzod\foundation;

use yii\helpers\Html;

/**
 * Description of Button
 *
 * @author Nicola Tomassoni <nicola@digisin.it>
 * @see http://foundation.zurb.com/docs/components/buttons.html
 */
class Button extends Widget {

  /**
   *
   * @var array 
   */
  public $options = ['class' => 'button'];
  
  /**
   * @var string the tag to use to render the button
   */
  public $tagName = 'a';

  /**
   * @var string the button label
   */
  public $label = 'Button';

  /**
   *
   * @var string|array the button link, used only if tagName is 'a' 
   */
  public $url = '#';
  
  /**
   * @var boolean whether the label should be HTML-encoded.
   */
  public $encodeLabel = true;

  /**
   * Initializes the widget.
   * If you override this method, make sure you call the parent implementation first.
   */
  public function init() {
    parent::init();
    $this->clientOptions = false;
    $this->options['role'] = 'button';
  }

  /**
   * Renders the widget.
   */
  public function run() {
    if($this->tagName == 'a') {
      echo Html::a($this->encodeLabel ? Html::encode($this->label) : $this->label, $this->url, $this->options);
    } else {
      $this->options['tabindex'] = '0';
      echo Html::tag($this->tagName, $this->encodeLabel ? Html::encode($this->label) : $this->label, $this->options);
    }
  }

}
