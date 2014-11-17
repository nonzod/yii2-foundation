<?php

/**
 *  @copyright Copyright &copy; Digisin soc. coop, digisin.it 2014
 *  @package nonzod/yii2-foundation
 *  @version 1.0.0
 */

namespace nonzod\foundation;

use yii\web\AssetBundle;

/**
 * Asset bundle for the foundation icons css.
 *
 * @author Nicola Tomassoni <nicola@digisin.it>
 */
class FoundationIconAsset extends AssetBundle {

  public $sourcePath = '@bower/foundation-icons-font';
  public $css = [
      '/foundation-icons.css'
  ];

}
