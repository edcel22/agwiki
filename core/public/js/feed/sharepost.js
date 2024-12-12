$(document).ready(function() {
  // Toggle dropdown when clicking on the button
  $(document).on('click', '.dropdown-toggle-share', function(event) {
      var dropdownId = $(this).attr('dropdown-target-id');
      
      // Check if the dropdown is currently visible
      var dropdown = $('#' + dropdownId);
      if (dropdown.is(':visible')) {
          dropdown.hide(); // If visible, hide the dropdown
      } else {
          $('.dropdown-content').hide(); // Hide all other dropdowns
          dropdown.show(); // Show the clicked dropdown
      }

      event.stopPropagation(); // Prevent event from bubbling to document click
  });

  // Close dropdown when clicking outside
  $(document).on('click', function(event) {
      $('.dropdown-content').each(function() {
          var dropdown = $(this);
          if (dropdown.is(':visible')) {
              // If the click is outside the dropdown and its toggle button, close it
              if (!$(event.target).closest(dropdown).length && !$(event.target).closest('.dropdown-toggle-share').length) {
                  dropdown.hide();
              }
          }
      });
  });
});
