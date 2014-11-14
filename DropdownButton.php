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
 * Description of ButtonDropdown
 *
 * @author Nicola Tomassoni <nicola@digisin.it>
 */
class DropdownButton extends Widget {

  /**
   * @var string the button label
   */
  public $label = 'Button';

  /**
   * @var array the HTML attributes of the button.
   * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
   */
  public $options = [];

  /**
   * @var array the configuration array for [[Dropdown]].
   */
  public $dropdown = [];

  /**
   * @var boolean whether to display a group of split-styled button group.
   */
  public $split = false;

  /**
   * @var string the tag to use to render the button
   */
  public $tagName = 'button';

  /**
   * @var boolean whether the label should be HTML-encoded.
   */
  public $encodeLabel = true;

  /**
   * DOM id for the dropdown, used to link button to dropdown.
   * @todo better way to generate ID or get the id from Widget...
   * @var type 
   */
  protected $_dropdownId;
  
  /**
   * Renders the widget.
   */
  public function run() {
    $dropdownOptions = ArrayHelper::getValue($this->dropdown, 'options', []);
    $this->_dropdownId = ArrayHelper::getValue($dropdownOptions, 'id', 'dd-' . rand(1, 10));
    
    echo "\n" . $this->renderButton();
    echo "\n" . $this->renderDropdown();
    
    $this->registerPlugin('button');
  }

  /**
   * Generates the button dropdown.
   * @return string the rendering result.
   */
  protected function renderButton() {
    
    Html::addCssClass($this->options, 'button');
    $label = $this->label;
    if ($this->encodeLabel) {
      $label = Html::encode($label);
    }
    if ($this->split) {
      $this->tagName = 'a';
      Html::addCssClass($this->options, 'split');
      $options = $this->options;
      $label .= Html::tag('span', '', ['data-dropdown' => $this->_dropdownId]);
    } else {
      Html::addCssClass($this->options, 'dropdown');
      $options = $this->options;
      if (!isset($options['href'])) {
        $options['href'] = '#';
      }
      
      $options['data-dropdown'] = $this->_dropdownId;
    }

    return Button::widget([
            'tagName' => $this->tagName,
            'label' => $label,
            'options' => $options,
            'encodeLabel' => false,
        ]) . "<br />\n";
  }

  /**
   * Generates the dropdown menu.
   * @return string the rendering result.
   */
  protected function renderDropdown() {
    $config = $this->dropdown;
    $config['id'] = $this->_dropdownId;
    $config['clientOptions'] = false;
    $config['view'] = $this->getView();
    
    return Dropdown::widget($config);
  }

}
