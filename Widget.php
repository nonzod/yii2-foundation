<?php

/**
 *  @copyright Copyright &copy; Digisin soc. coop, digisin.it 2014
 *  @package nonzod/yii2-foundation
 *  @version dev
 */

namespace nonzod\foundation;

/**
 * Description of Widget
 *
 * @author Nicola Tomassoni <nicola@digisin.it>
 * @since 0.0.1
 * @see
 */
class Widget extends \yii\base\Widget {

  /**
   * @var array the HTML attributes for the widget container tag.
   * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
   */
  public $options = [];
  /**
   * @var array Specific options of the Foundation plugin in use.
   * @see http://foundation.zurb.com/docs/javascript.html 
   */
  public $clientOptions = [];
  /**
   * @var array Specific methods to call
   * @see http://foundation.zurb.com/docs/javascript.html 
   */
  public $clientFireMethods = [];

  /**
   * Initialize the widget
   */
  public function init() {
    parent::init();
    if (empty($this->options['id'])) {
      $this->options['id'] = $this->getId();
    }
  }

  /**
   * Registers a specific Foundation plugin and call related methods
   * @param string $name the name of the Foundation plugin
   * @todo far caricare solo i js dei plugin in uso
   */
  protected function registerPlugin($name = '') {
    $view = $this->getView();
    
    //$id = $this->options['id'];
    
    if ($this->clientOptions !== false) {
      $options = empty($this->clientOptions) ? '' : Json::encode($this->clientOptions);
      $js = "$(document).foundation({ $name : { $options } });";
      $view->registerJs($js);
    }
    
    if (!empty($this->clientFireMethods)) {
      $js = [];
      foreach ($this->clientFireMethods as $method) {
        $js[] = "$(document).foundation('$name', '$method');";
      }
      $view->registerJs(implode("\n", $js));
    }
  }

}
