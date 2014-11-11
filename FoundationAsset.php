<?php

/**
 *  @copyright Copyright &copy; Nicola Tomassoni, digisin.it 2014
 *  @package nonzod/yii2-foundation
 *  @version 0.0.1
 */

namespace nonzod\foundation;

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

}
