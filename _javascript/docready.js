// jshint jquery: true

$(document).ready(function () {

    // Hover Lantern nav item
  $('li#nav_lantern')
    .hover(
      function (event) {
        event.stopPropagation();
        $(this).css({ cursor: 'pointer' });
      }, function (event) {
        event.stopPropagation();
        $(this).css({ cursor: 'default' });
      })
    .children().hover(
      function () {
        return false;
      });

  
    // Hover dropdown list item
  $('div.nav_dropdown_item')
    .hover(
      function () {
        $(this).css({ backgroundColor: '#444466' });
        return false;
      }, function () {
        $(this).css({ backgroundColor: '#669' });
        return false;
      });

  
    // Click nav item
  $('li.nav_item').click(showThisDropdown).children()
    .click(
      function () {
        return false; // Prevent children from triggering the event
      });


    // Click Lantern nav item
  $('li#nav_lantern').bind('click.focus', function (event) {
    event.stopPropagation();

    $('div.nav_dropdown').hide();

    var msgs = ['aim for', 'be after', 'beat the bushes', 'bird-dog',
      'bob for', 'cast about', 'chase', 'comb', 'delve', 'delve for',
      'dig for', 'dragnet', 'explore', 'fan', 'ferret out', 'fish',
      'fish for', 'follow', 'go after', 'gun for', 'hunt', 'inquire',
      'investigate', 'leave no stone unturned', 'look about',
      'look around', 'look high and low', 'mouse', 'nose', 'prowl',
      'pursue', 'quest', 'ransack', 'root', 'run after', 'scout',
      'scratch', 'search for', 'search out', 'seek', 'sniff out',
      'track down'];
      
      var msg = msgs[Math.floor(Math.random() * msgs.length)];

        // Show random synonym as input placeholder
      $('input#lantern_search').attr('placeholder', msg);

      $(this).find('div.nav_dropdown').show();

      $('input#lantern_search').select().focus();

      closeAllNavLists_prep();

    });

  $('li#nav_lantern div.nav_dropdown').click(
    function (event) {
      event.stopPropagation();
    });

  $('input#lantern_gettyToggle').click(
    function () {
      $('input#lantern_search').focus();
    });


    // Submit Lantern search
  function lanternSearch_submit() {
    var text = $('input#lantern_search').val();
    var gToggle = $('input#lantern_gettyToggle').prop('checked');
    // console.log('lantern-search submitted');
    // console.log('lantern-search string: "' + text + '"');
    // console.log('lantern-search authority toggle: ' + gToggle);
    lantern_search(text, gToggle, 1);
  }

  $('button#lantern_submit').click(lanternSearch_submit);
  
  $('input#lantern_search').keypress(function (event) {
    var enterWhich = event.which && event.which == 13;
    var enterKeycode = event.keyCode && event.keyCode == 13;

    if (enterWhich || enterKeycode) {
      lanternSearch_submit();
    }

  });
      


  //---------------------------------------------
  //  Define events for navigation menu buttons
  //---------------------------------------------

  $('div#nav_browseUsers').click(usersBrowse_load);

  $('div#nav_registerUser').click(registerNewUser_load);

  $('div#nav_export').click(export_load);

  $('div#nav_findOrder').click(function () {
    findOrders_loadForm(1, 'date_needed', 'ASC');
  });

  $('div#nav_createOrder').click(createOrder_load_form);

  $('div#nav_createWork').click(createWork);

  $('div#nav_createRepository').click(createRepository);

  $('div#nav_viewOrphanedWorks').click(view_orphaned_works);

  $('div#nav_viewOrphanedImages').click(view_orphaned_images);

  $('div#nav_import').click(function() {
    window.location = 'import.php';
  });

  //----------------------------
  //  Legacy Reader Navigation
  //----------------------------

  $(function () {
    $('form[id=legacyReader-form] input').keypress(function (event) {
      var enterWhich = event.which && event.which == 13;
      var enterKeycode = event.keyCode && event.keyCode == 13;

      if (enterWhich || enterKeycode) {
        $(this).parents('form')
          .find('input[id=legacyReader-jumpToRecord]')
          .click();
        return false;

      } else {
        return true;

      }
    });
  });
  
});