(function ($) {
  Drupal.behaviors.apigee = {
    attach: function (context, settings) {
      // Add Classes
      $('.view-home-featured-forum-posts .views-row').addClass('row');
      
      // Add Wrappers
      // $('.block').wrapInner('<div class="block-inner" />');
    }
  };
})(jQuery);