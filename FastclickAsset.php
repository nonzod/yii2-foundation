<?php

/**
 *  @copyright Copyright &copy; Digisin soc. coop, digisin.it 2014
 *  @package nonzod/yii2-foundation
 *  @version 1.0.0
 */

namespace nonzod\foundation;

use yii\web\AssetBundle;

/**
 * Description of FastclickAsset
 *
 * @author Nicola Tomassoni <nicola@digisin.it>
 */
class FastclickAsset extends AssetBundle {
  public $sourcePath = '@bower/fastclick';

  public $js = [
      'lib/fastclick.js'
  ];
}
