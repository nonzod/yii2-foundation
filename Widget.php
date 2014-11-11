<?php

/**
 *  @copyright Copyright &copy; Nicola Tomassoni, digisin.it 2014
 *  @package nonzod/yii2-foundation
 *  @version 0.0.1
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

  public $clientOptions = [];

  public $clientEvents = [];

  /**
   * Registers a specific Foundation plugin and the related events
   * @param string $name the name of the Foundation plugin
   */
  protected function registerPlugin($name) {
    $view = $this->getView();

    FoundationAsset::register($view);
  }

}
