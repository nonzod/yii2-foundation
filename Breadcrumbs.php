<?php

/**
 *  @copyright Copyright &copy; Digisin soc. coop, digisin.it 2014
 *  @package nonzod/yii2-foundation
 *  @version 1.0.0
 */

namespace nonzod\foundation;

/**
 * Description of Breadcrumbs
 *
 * @author Nicola Tomassoni <nicola@digisin.it>
 */
class Breadcrumbs extends \yii\widgets\Breadcrumbs {

  public $options = ['class' => 'breadcrumbs'];
  
  public $activeItemTemplate = "<li class=\"current\">{link}</li>\n";

}
