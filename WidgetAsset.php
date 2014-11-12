<?php

/**
 *  @copyright Copyright &copy; Nicola Tomassoni, digisin.it 2014
 *  @package nonzod/yii2-foundation
 *  @version dev
 */

namespace nonzod\foundation;

use yii\web\AssetBundle;

/**
 * Asset bundle for the Widget js files.
 *
 * @author Nicola Tomassoni <nicola@digisin.it>
 * @since 0.0.1
 * @see
 */
class WidgetAsset extends AssetBundle {

  public $sourcePath = '@vendor/nonzod/yii2-foundation';
  public $js = [
      'js/foundation.activeForm.js'
  ];
}
