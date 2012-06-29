(function ($) {
  Drupal.behaviors.apigee = {
    attach: function (context, settings) {
      // Add Classes
      $('.view-home-featured-forum-posts .views-row').addClass('row');

      // CSS
      $('.node-blog.node-teaser:first').css('padding-top','0px');
    }
  };
})(jQuery);
