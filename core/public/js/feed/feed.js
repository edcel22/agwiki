(function($) {
  $(document).ready(function() {
      const players = Array.from(document.querySelectorAll('.player')).map(p => new Plyr(p));
      $(document).on('click', '.mail-share', function(e) {
          e.preventDefault();
          var post_id = $(this).data('id');
          console.log(post_id)
      })
  })
})(jQuery);

(function($) {
  $(document).ready(function() {
      $(document).on('click', '#get_search-form', function(e) {
          e.preventDefault();
          $('.search-area-mobile').css('display', 'block');
          $(this).attr('id', 'get_search_clicked')
      })
      $(document).on('click', '#get_search_clicked', function(e) {
          e.preventDefault();
          $('.search-area-mobile').css('display', 'none');
          $(this).attr('id', 'get_search-form')
      })
      toastr.success("Post Published Successfully.")
  });
  $(document).on('click', '.imgclickcls', function() {
      var image = $(this).attr('src');
      var theImage = new Image();
      $(theImage).load(function() {
          if (this.width >= 1000) {
              $('#imgmodalwidth').css('width', '1050')
          } else {
              $('#imgmodalwidth').css('width', this.width + 50)
          }
      });
      theImage.src = image;
      $("#imagesrc").attr("src", image)
  }) 
})(jQuery);

$(document).ready(function() {		

  function registerPopup()
  {

      const el = document.createElement('div')
      el.innerHTML = "<a href='/login'>Please use this link to sign up</a>"

      swal({
          title: "This feature is only for members of AgWiki", 
          content: el,
  
  });
  }
})