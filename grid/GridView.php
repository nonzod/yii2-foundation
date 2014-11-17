<?php

/**
 *  @copyright Copyright &copy; Digisin soc. coop, digisin.it 2014
 *  @package nonzod/yii2-foundation
 *  @version 0.0.1
 */

namespace nonzod\foundation\grid;

use nonzod\foundation\FoundationIconAsset;

/**
 * Description of GridView
 *
 * @author Nicola Tomassoni <nicola@digisin.it>
 */
class GridView extends \yii\grid\GridView {
  /**
     * @var array the HTML attributes for the grid table element.
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $tableOptions = ['class' => 'table', 'role' => 'grid']; 
    
    /**
     * @var array 
     * @see [[\yii\widgets\BaseListView::pager]]
     */
    public $pager = ['class' => 'nonzod\foundation\LinkPager'];
    
    /**
     * @inheritdoc
     */
    public function init() {
      parent::init();
      
      FoundationIconAsset::register($this->getView());
    }
}
