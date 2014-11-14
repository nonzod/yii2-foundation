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
 * Description of ButtonGroup
 *
 * @author Nicola Tomassoni <nicola@digisin.it>
 * @see http://foundation.zurb.com/docs/components/button_groups.html
 */
class ButtonGroup extends Widget {

  /**
   * @var array list of buttons. Each array element represents a single button
   * which can be specified as a string or an array of the following structure:
   *
   * - label: string, required, the button label.
   * - url: string|array, optional, the url for the button link
   * - options: array, optional, the HTML attributes of the button.
   */
  public $buttons = [];

  /**
   * @var boolean whether to HTML-encode the button labels.
   */
  public $encodeLabels = true;

  /**
   * Initializes the widget.
   * If you override this method, make sure you call the parent implementation first.
   */
  public function init() {
    parent::init();
    Html::addCssClass($this->options, 'button-group');
  }

  /**
   * Renders the widget.
   */
  public function run() {
    echo Html::tag('ul', $this->renderButtons(), $this->options);
  }

  /**
   * Generates the buttons that compound the group as specified on [[buttons]].
   * @return string the rendering result.
   */
  protected function renderButtons() {
    $buttons = [];
    foreach ($this->buttons as $button) {
      if (is_array($button)) {
        $label = ArrayHelper::getValue($button, 'label');
        $url = ArrayHelper::getValue($button, 'url');
        $options = ArrayHelper::getValue($button, 'options');
        $button = Button::widget([
                'label' => $label,
                'url' => $url,
                'options' => $options,
                'encodeLabel' => $this->encodeLabels
        ]);
        $buttons[] = Html::tag('li', $button);
      } else {
        $buttons[] = Html::tag('li', $button);
      }
    }
    
    return implode("\n", $buttons);
  }

}
