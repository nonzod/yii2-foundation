<?php

/**
 *  @copyright Copyright &copy; Digisin soc. coop, digisin.it 2014
 *  @package nonzod/yii2-foundation
 *  @version 1.0.0
 */

namespace nonzod\foundation;

use yii\web\AssetBundle;

/**
 * Asset bundle for the foundation css and js files.
 *
 * @author Nicola Tomassoni <nicola@digisin.it>
 * @since 0.0.1
 * @see
 */
class FoundationAsset extends AssetBundle {

  public $sourcePath = '@bower/foundation';
  public $css = [
      'css/normalize.css',
      'css/foundation.css',
  ];
  public $js = [
      'js/foundation.min.js'
  ];
  public $depends = [
      'nonzod\foundation\ModernizrAsset',
      'nonzod\foundation\WidgetAsset',
  ];

}
