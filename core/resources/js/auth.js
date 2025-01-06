// app.js

$(document).ready(function() {
  // Alert and Message Handlers
  handleAlerts();

  // Mention Plugin Initialization
  initMentionPlugin();

  // Event Handlers
  handleUserActions();
  handlePostActions();
  handleTopicActions();
  handleContentUpload();

  // Infinite Scrolling
  initInfiniteScroll();

  // Tooltip Initialization
  $('[data-toggle="tooltip"]').tooltip();
});

/**
* Handle alerts and auto-dismiss after 2 seconds.
*/
function handleAlerts() {
  $(".alert-large").click(function() {
      $(this).hide();
  }).fadeOut(2000);
}

/**
* Initialize Mention Plugin for User Mentions
*/
function initMentionPlugin() {
  const users = [
      @foreach(App\User::get() as $user)
      {
          name: '{{ $user->name }}',
          username: '{{ $user->username }}',
          image: '/assets/front/img/{{ $user->avatar }}'
      },
      @endforeach
  ];

  $(".post-input-field").mention({
      users: users
  });
}

/**
* Handle Like, Dislike, and Comment Actions
*/
function handleUserActions() {
  $(document).on('click', '.like, .dislike', function(e) {
      e.preventDefault();
      const postId = $(this).data('post');
      const actionUrl = $(this).hasClass('like') ? likeUrl : dislikeUrl;

      $.post(actionUrl, { post_id: postId, _token: csrfToken }, function(response) {
          // Toggle like/dislike state and update count based on response
          if (response.success) {
              toggleActionState(this);
          }
      });
  });
}

/**
* Post Actions: Sharing, Deleting
*/
function handlePostActions() {
  $(document).on('click', '.share, .delete-post', function(e) {
      e.preventDefault();
      const postId = $(this).data('post');
      const actionUrl = $(this).hasClass('share') ? shareUrl : deleteUrl;

      $.post(actionUrl, { post_id: postId, _token: csrfToken }, function(response) {
          if (response.success) {
              updatePostUI(this);
          } else {
              showAlert("Action failed. Please try again.");
          }
      });
  });
}

/**
* Topic Actions: Add or Remove Topics
*/
function handleTopicActions() {
  $(document).on('click', '.topiclist, .remtopic', function(e) {
      e.preventDefault();
      const topicId = $(this).data('post');
      const actionUrl = $(this).hasClass('topiclist') ? addTopicUrl : removeTopicUrl;

      $.post(actionUrl, { topic_id: topicId, _token: csrfToken }, function(response) {
          if (response.success) {
              updateTopicUI(this);
          }
      });
  });
}

/**
* Handle Content Upload: Image, Video, Audio, Document
*/
function handleContentUpload() {
  $(document).on('change', '#image, #video, #audio, #doc', function(e) {
      const file = this.files[0];
      const uploadType = $(this).attr('id');
      const formData = new FormData();
      formData.append("file", file);
      formData.append("_token", csrfToken);
      formData.append("type", uploadType);

      $.ajax({
          url: uploadUrl,
          type: 'POST',
          data: formData,
          contentType: false,
          processData: false,
          success: function(response) {
              if (response.success) {
                  displayUploadedContent(response);
              } else {
                  showAlert(response.error);
              }
          }
      });
  });
}

/**
* Infinite Scroll for Content Loading
*/
function initInfiniteScroll() {
  $('.infinite-scroll').jscroll({
      autoTrigger: true,
      loadingHtml: '<div class="loading"><i class="fa fa-spinner fa-spin"></i></div>',
      padding: 20,
      nextSelector: 'ul.pagination li.active + li a',
      contentSelector: 'div.infinite-scroll'
  });
}

/**
* Toggle UI Elements Based on Action (e.g., like, share)
*/
function toggleActionState(element) {
  $(element).toggleClass('actv');
  const countElem = $(element).siblings('span');
  const currentCount = parseInt(countElem.text().match(/\d+/));
  const newCount = $(element).hasClass('actv') ? currentCount + 1 : currentCount - 1;
  countElem.text(`(${newCount})`);
}

/**
* Display alert messages
*/
function showAlert(message) {
  swal({ title: message, icon: "warning" });
}

/**
* Update UI after post actions (delete/share)
*/
function updatePostUI(element) {
  // Adjust UI for share or delete actions
}

/**
* Update Topic UI
*/
function updateTopicUI(element) {
  // Adjust UI for add or remove topic actions
}
