<?php

/**
 *  @copyright Copyright &copy; Digisin soc. coop, digisin.it 2014
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
class ActiveFormAsset extends AssetBundle {

  public $sourcePath = '@vendor/nonzod/yii2-foundation/js';
  public $js = [
      'foundation.activeForm.js'
  ];
}
