/* 
 *  @copyright Copyright &copy; Nicola Tomassoni, digisin.it 2014
 *  @package nonzod/yii2-foundation
 *  @version dev
 */

(function ($) {
  $('form').on('afterValidateAttribute', function (event, attribute, messages) {
            var container = attribute.container;
            var error = attribute.error;
            var selectors = container + ' label,' + container + ' input,' + container + ' ' + error;
            
            if (messages.length > 0) {
              $(selectors).addClass('error');
            } else {
              $(selectors).removeClass('error');
            }
          });
})(jQuery);
