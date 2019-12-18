jQuery( function ( $ ) {
  $(document).ready(function() {
    var tagOwl = $('#tag-carousel');
    tagOwl.owlCarousel({
      autoWidth:true,
      loop: false,
      margin: 30,
      items: 27,
      nav: false,
      dots: false
    });
    // Go to the next item
    $('#next-tag').click(function() {
        tagOwl.trigger('next.owl.carousel');
    });
    // Go to the previous item
    $('#previous-tag').click(function() {
        // With optional speed parameter
        // Parameters has to be in square bracket '[]'
        tagOwl.trigger('prev.owl.carousel');
    });
  });
});
