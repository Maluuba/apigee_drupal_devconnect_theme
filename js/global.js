(function ($) {
  Drupal.behaviors.apigee = {
    attach: function (context, settings) {
      if ($('body').hasClass('page-user-me-edit')) {
        $('body').addClass('page-user-edit');
      };
      // Add Classes
      $('.view-home-featured-forum-posts .views-row').addClass('row');
      $('table').addClass('table table-condensed');
      $('.comment-delete a, .comment-edit a, .comment-reply a').addClass('btn');
      $('.faq-question-answer').addClass('accordion-group');
      $('#devconnect-developer-apps-edit-form').addClass('well');
      $('.page-user-register .page-content .container, .page-user-edit .page-content .container').addClass('well');
      $('#user-register-form input.form-submit').wrap('<div class="form-actions" />');

      // CSS
      $('.node-blog.node-teaser:first').css('padding-top','0px');
      $(".collapse").collapse();
      $('.page-comment-reply article.comment ul.links.inline').hide();

      $('#reportrange').daterangepicker(
        {
          ranges: {
            'Today': ['today', 'today'],
            'Yesterday': ['yesterday', 'yesterday'],
            'Last 7 Days': [Date.today().add({ days: -6 }), 'today'],
            'Last 30 Days': [Date.today().add({ days: -29 }), 'today'],
            'This Month': [Date.today().moveToFirstDayOfMonth(), Date.today().moveToLastDayOfMonth()],
            'Last Month': [Date.today().moveToFirstDayOfMonth().add({ months: -1 }), Date.today().moveToFirstDayOfMonth().add({ days: -1 })]
          }
        },
        function(start, end) {
          $('#reportrange span').html(start.toString('MMMM d, yyyy') + ' - ' + end.toString('MMMM d, yyyy'));
        }
      );
    }
  };
})(jQuery);
