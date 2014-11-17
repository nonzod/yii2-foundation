<?php

/**
 *  @copyright Copyright &copy; Digisin soc. coop, digisin.it 2014
 *  @package nonzod/yii2-foundation
 *  @version dev
 */

namespace nonzod\foundation;

use yii\helpers\Html;
use yii\helpers\ArrayHelper;

/**
 * Description of ActiveField
 *
 * @author Nicola Tomassoni <nicola@digisin.it>
 */
class ActiveField extends \yii\widgets\ActiveField {

  public $template = "{beginLabel}{labelTitle}\n{input}{endLabel}\n{error}\n{hint}\n";
  public $inlineTemplate = "<div class=\"row\"><div class=\"small-3 columns\">{label}</div><div class=\"small-9 columns\">{input}\n{error}\n{hint}</div></div>\n";
  public $checkboxTemplate = "{label}\n{input}\n{error}\n{hint}\n";
  public $checkboxListTemplate = "{label}\n{input}\n{error}\n{hint}\n";
  public $radioTemplate = "{label}\n{input}\n{error}\n{hint}\n";
  public $radioListTemplate = "{label}\n{input}\n{error}\n{hint}\n";

  /**
   * @var string|null optional template to render the `{input}` placeholder content
   */
  public $inputTemplate;

  /**
   * @var array options for the wrapper tag, used in the `{beginWrapper}` placeholder
   */
  public $wrapperOptions = [];

  /**
   * @var bool whether to render the error. Default is `true` except for layout `inline`.
   */
  public $enableError = true;

  /**
   * @var bool whether to render the label. Default is `true`.
   */
  public $enableLabel = true;

  /**
   *
   * @var type 
   */
  public $inputOptions = [];

  /**
   *
   * @var type 
   */
  public $inlineCssClasses = [];

  /**
   * @inheritdoc
   */
  public function __construct($config = []) {
    $layoutConfig = $this->createLayoutConfig($config);
    $config = ArrayHelper::merge($layoutConfig, $config);
    return parent::__construct($config);
  }

  /**
   * Renders the hint tag.
   * @param string $content the hint content. It will NOT be HTML-encoded.
   * @param array $options the tag options in terms of name-value pairs. These will be rendered as
   * the attributes of the hint tag. The values will be HTML-encoded using [[Html::encode()]].
   *
   * The following options are specially handled:
   *
   * - tag: this specifies the tag name. If not set, "div" will be used.
   *
   * @return static the field object itself
   */
  public function hint($content, $options = []) {

    $options = array_merge($this->hintOptions, $options, [
        'id' => 'hint-' . Html::getInputId($this->model, $this->attribute)
    ]);

    $tag = ArrayHelper::remove($options, 'tag', 'p');
    $this->parts['{hint}'] = Html::tag($tag, $content, $options);

    return $this;
  }

  /**
   * Renders an input tag.
   * @param string $type the input type (e.g. 'text', 'password')
   * @param array $options the tag options in terms of name-value pairs. These will be rendered as
   * the attributes of the resulting tag. The values will be HTML-encoded using [[Html::encode()]].
   * @return static the field object itself
   */
  public function input($type, $options = []) {
    $options = array_merge($this->inputOptions, [
        'class' => 'hint-' . Html::getInputId($this->model, $this->attribute)
    ]);
    $this->adjustLabelFor($options);
    $this->parts['{input}'] = Html::activeInput($type, $this->model, $this->attribute, $options);

    return $this;
  }

  /**
   * Renders a text input.
   * This method will generate the "name" and "value" tag attributes automatically for the model attribute
   * unless they are explicitly specified in `$options`.
   * @param array $options the tag options in terms of name-value pairs. These will be rendered as
   * the attributes of the resulting tag. The values will be HTML-encoded using [[Html::encode()]].
   * @return static the field object itself
   */
  public function textInput($options = []) {
    $options = array_merge($this->inputOptions, $options, [
        'aria-describedby' => 'hint-' . Html::getInputId($this->model, $this->attribute)
    ]);
    $this->adjustLabelFor($options);
    $this->parts['{input}'] = Html::activeTextInput($this->model, $this->attribute, $options);

    return $this;
  }

  /**
   * @inheritdoc
   */
  public function checkbox($options = [], $enclosedByLabel = false) {
    if ($enclosedByLabel) {
      $this->template = $this->form->layout === 'inline' ?
          $this->inlineTemplate : $this->checkboxTemplate;
    }

    return parent::checkbox($options, $enclosedByLabel);
  }

  /**
   * @inheritdoc
   */
  public function checkboxList($items, $options = []) {
    $this->template = $this->form->layout === 'inline' ?
        $this->inlineTemplate : $this->checkboxListTemplate;

    if (!isset($options['item'])) {
      $options['item'] = function ($index, $label, $name, $checked, $value) {
        return Html::checkbox($name, $checked, ['label' => $label, 'value' => $value]);
      };
    }
    parent::checkboxList($items, $options);
    return $this;
  }

  /**
   * @inheritdoc
   */
  public function radio($options = [], $enclosedByLabel = false) {
      $this->template = $this->form->layout === 'inline' ?
          $this->inlineTemplate : $this->radioTemplate;

    return parent::radio($options, $enclosedByLabel);
  }

  /**
   * @inheritdoc
   */
  public function radioList($items, $options = []) {
    $this->template = $this->form->layout === 'inline' ?
        $this->inlineTemplate : $this->radioListTemplate;

    if (!isset($options['item'])) {
      $options['item'] = function ($index, $label, $name, $checked, $value) {
        return Html::radio($name, $checked, ['label' => $label, 'value' => $value]);
      };
    }
    parent::radioList($items, $options);
    return $this;
  }

  /**
   * @inheritdoc
   */
  public function render($content = null) {
    if ($content === null) {
      if ($this->enableLabel === false) {
        $this->parts['{label}'] = '';
        $this->parts['{beginLabel}'] = '';
        $this->parts['{labelTitle}'] = '';
        $this->parts['{endLabel}'] = '';
      } elseif (!isset($this->parts['{beginLabel}'])) {
        $this->renderLabelParts();
      }

      if ($this->enableError === false) {
        $this->parts['{error}'] = '';
      }

      if ($this->inputTemplate) {
        $input = isset($this->parts['{input}']) ?
            $this->parts['{input}'] : Html::activeTextInput($this->model, $this->attribute, $this->inputOptions);
        $this->parts['{input}'] = strtr($this->inputTemplate, ['{input}' => $input]);
      }
    }
    return parent::render($content);
  }

  /**
   * @param array $instanceConfig the configuration passed to this instance's constructor
   * @return array the layout specific default configuration for this instance
   */
  protected function createLayoutConfig($instanceConfig) {
    $config = [
        'hintOptions' => [
            'tag' => 'p',
            'class' => 'hint-box'
        ],
        'errorOptions' => [
            'tag' => 'small',
            'class' => 'error-box'
        ]
    ];

    $layout = $instanceConfig['form']->layout;

    if ($layout === 'default') {
      $config['template'] = $this->template;
    } elseif ($layout === 'inline') {
      $config['template'] = $this->inlineTemplate;
      $config['labelOptions'] = ['class' => 'right inline'];
      $config['enableError'] = false;
    }

    return $config;
  }

  /**
   * @param string|null $label the label or null to use model label
   * @param array $options the tag options
   */
  protected function renderLabelParts($label = null, $options = []) {
    $options = array_merge($this->labelOptions, $options);
    if ($label === null) {
      if (isset($options['label'])) {
        $label = $options['label'];
        unset($options['label']);
      } else {
        $attribute = Html::getAttributeName($this->attribute);
        $label = Html::encode($this->model->getAttributeLabel($attribute));
      }
    }
    $this->parts['{beginLabel}'] = Html::beginTag('label', $options);
    $this->parts['{endLabel}'] = Html::endTag('label');
    $this->parts['{labelTitle}'] = $label;
  }

}
