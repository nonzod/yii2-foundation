<?php

/**
 *  @copyright Copyright &copy; Digisin soc. coop, digisin.it 2014
 *  @package nonzod/yii2-foundation
 *  @version 0.0.1
 */

namespace nonzod\foundation;

/**
 * Description of ActiveForm
 *
 * @author Nicola Tomassoni <nicola@digisin.it>
 */
class ActiveForm extends \yii\widgets\ActiveForm {

  public $fieldClass = 'nonzod\foundation\ActiveField';
  public $layout = 'default';

  /**
   * @inheritdoc
   */
  public function init() {
    if (!in_array($this->layout, ['default', 'inline'])) {
      throw new InvalidConfigException('Invalid layout type: ' . $this->layout);
    }

    if ($this->layout !== 'default') {
      Html::addCssClass($this->options, 'form-' . $this->layout);
    }
    parent::init();
  }

}
