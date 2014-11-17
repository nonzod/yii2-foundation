<?php

/**
 *  @copyright Copyright &copy; Digisin soc. coop, digisin.it 2014
 *  @package nonzod/yii2-foundation
 *  @version 1.0.0
 */

namespace nonzod\foundation\helpers;

/**
 * Description of Html
 *
 * @author Nicola Tomassoni <nicola@digisin.it>
 */
class Html extends \yii\helpers\Html {

  const FLOAT_LEFT = 'left';
  const FLOAT_RIGHT = 'right';
  const CLEAR_FLOAT = 'clearfix';
  const HIDDEN = 'hide';
  const BORDER_RADIUS = 'radius';
  const BORDER_ROUND = 'round';
  const TYPE_SECONDARY = 'secondary';
  const TYPE_SUCCESS = 'success';
  const TYPE_WARNING = 'warning';
  const TYPE_ALERT = 'alert';

  /**
   * Generates an icon.
   *
   * @param string $icon the foundation icon name without prefix (e.g. 'plus', 'refresh', 'trash')
   * @param array $options html options for the icon container
   * @param string $prefix the css class prefix - defaults to 'fi-'
   * @param string $tag the icon container tag - defaults to 'i'
   *
   * @see http://zurb.com/playground/foundation-icon-fonts-3
   */
  public static function icon($icon, $options = [], $prefix = 'fi-', $tag = 'i') {
    $class = isset($options['class']) ? ' ' . $options['class'] : '';
    $options['class'] = $prefix . $icon . $class;
    return static::tag($tag, '', $options);
  }

  /**
   * Generates a label.
   *
   * @param string $content the label content
   * @param string $type the label type - default is empty
   *  - is one of [[self::TYPE_SECONDARY]], [[self::TYPE_SUCCESS]], [[self::TYPE_WARNING]], [[self::TYPE_ALERT]]
   * @param string $border the border type - defaults is empty
   *  - is one of [[self::BORDER_RADIUS]], [[self::BORDER_ROUND]]
   * @param array $options html options for the label container
   * @param string $tag the label container tag - defaults to 'span'
   *
   * Example(s):
   * ~~~
   * echo Html::fLabel('Regular');
   * echo Html::fLabel('Primary', Html::TYPE_PRIMARY);
   * echo Html::fLabel('Success round', Html::TYPE_SUCCESS, Html::BORDER_ROUND);
   * ~~~
   *
   * @see http://getbootstrap.com/components/#labels
   */
  public static function fLabel($content, $type = '', $border = '', $options = [], $tag = 'span') {
    Html::addCssClass($options, 'label');
    Html::addCssClass($options, $type);
    Html::addCssClass($options, $border);

    return static::tag($tag, $content, $options);
  }

}
