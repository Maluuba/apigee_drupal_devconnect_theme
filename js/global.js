(function ($) {
  Drupal.behaviors.apigee = {
    attach: function (context, settings) {
      // Add Classes
      $('.view-home-featured-forum-posts .views-row').addClass('row');
      $('table').addClass('table table-condensed');
      $('.comment-delete a, .comment-edit a, .comment-reply a').addClass('btn');
      $('.page-comment-reply article.comment ul.links.inline').hide();

      // CSS
      $('.node-blog.node-teaser:first').css('padding-top','0px');
      $(".collapse").collapse();

    }
  };
})(jQuery);
