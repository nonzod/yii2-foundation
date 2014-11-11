<?php

/**
 *  @copyright Copyright &copy; Digisin soc. coop, digisin.it 2014
 *  @package nonzod/yii2-foundation
 *  @version 0.0.1
 */

namespace nonzod\foundation;

/**
 * Description of ActiveField
 *
 * @author Nicola Tomassoni <nicola@digisin.it>
 */
class ActiveField extends \yii\widgets\ActiveField {

  /**
   * @var bool whether to render [[checkboxList()]] and [[radioList()]] inline.
   */
  public $inline = false;

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
   * @inheritdoc
   */
  public function __construct($config = []) {
    $layoutConfig = $this->createLayoutConfig($config);
    $config = ArrayHelper::merge($layoutConfig, $config);
    return parent::__construct($config);
  }

  /**
   * @inheritdoc
   */
  public function render($content = null) {
    if ($content === null) {
      if (!isset($this->parts['{beginWrapper}'])) {
        $options = $this->wrapperOptions;
        $tag = ArrayHelper::remove($options, 'tag', 'div');
        $this->parts['{beginWrapper}'] = Html::beginTag($tag, $options);
        $this->parts['{endWrapper}'] = Html::endTag($tag);
      }
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
        ],
        'errorOptions' => [
            'tag' => 'small',
            'class' => 'error',
        ],
        'inputOptions' => [],
    ];

    $layout = $instanceConfig['form']->layout;

    if ($layout === 'default') {
      $config['template'] = "{beginWrapper}\n{label}\n{input}\n{error}\n{endWrapper}\n{hint}";
      $cssClasses = [
          'offset' => 'small-3',
          'label' => 'small-3',
          'wrapper' => 'small-6 columns',
          'error' => '',
          'hint' => 'small-3',
      ];
      if (isset($instanceConfig['horizontalCssClasses'])) {
        $cssClasses = ArrayHelper::merge($cssClasses, $instanceConfig['horizontalCssClasses']);
      }
      $config['horizontalCssClasses'] = $cssClasses;
      $config['wrapperOptions'] = ['class' => $cssClasses['wrapper']];
      $config['labelOptions'] = ['class' => $cssClasses['label']];
      $config['errorOptions'] = ['class' => 'error ' . $cssClasses['error']];
      $config['hintOptions'] = ['id' => 'help-block ', 'class' => $cssClasses['hint']];
    } elseif ($layout === 'inline') {
      $config['labelOptions'] = ['class' => 'sr-only'];
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
