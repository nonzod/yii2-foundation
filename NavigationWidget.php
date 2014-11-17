<?php

/**
 *  @copyright Copyright &copy; Digisin soc. coop, digisin.it 2014
 *  @package nonzod/yii2-foundation
 *  @version 1.0.0
 */

namespace nonzod\foundation;

use Yii;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

/**
 * Description of NavigationWidget
 *
 * @author Nicola Tomassoni <nicola@digisin.it>
 */
class NavigationWidget extends Widget {

  public $items = [];
  public $encodeLabels = true;
  public $activateItems = true;
  public $activateParents = false;

  /**
   * @var string the route used to determine if a menu item is active or not.
   * If not set, it will use the route of the current request.
   * @see params
   * @see isItemActive
   */
  public $route;

  /**
   * @var array the parameters used to determine if a menu item is active or not.
   * If not set, it will use `$_GET`.
   * @see route
   * @see isItemActive
   */
  public $params;
  
  /**
   * 
   */
  public function init() {
    parent::init();
    
    if ($this->route === null && Yii::$app->controller !== null) {
      $this->route = Yii::$app->controller->getRoute();
    }
    if ($this->params === null) {
      $this->params = Yii::$app->request->getQueryParams();
    }
  }

  /**
   * 
   * @param type $item
   * @return boolean
   */
  protected function isItemActive($item) {
    if (isset($item['url']) && is_array($item['url']) && isset($item['url'][0])) {
      $route = $item['url'][0];
      if ($route[0] !== '/' && Yii::$app->controller) {
        $route = Yii::$app->controller->module->getUniqueId() . '/' . $route;
      }
      if (ltrim($route, '/') !== $this->route) {
        return false;
      }
      unset($item['url']['#']);
      if (count($item['url']) > 1) {
        foreach (array_splice($item['url'], 1) as $name => $value) {
          if ($value !== null && (!isset($this->params[$name]) || $this->params[$name] != $value)) {
            return false;
          }
        }
      }
      return true;
    }
    return false;
  }

  /**
   * 
   * @param type $items
   * @param boolean $active
   * @return type
   */
  protected function isChildActive($items, &$active) {
    foreach ($items as $i => $child) {
      if (ArrayHelper::remove($items[$i], 'active', false) || $this->isItemActive($child)) {
        Html::addCssClass($items[$i]['options'], 'active');
        if ($this->activateParents) {
          $active = true;
        }
      }
    }
    return $items;
  }

}
