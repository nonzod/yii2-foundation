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

}
