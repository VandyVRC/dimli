var reSpecialChars = new RegExp(/[\.\/\s\,\!\@\#\$\%\^\&\*\(\)\'\"\;\:<>\`\~\-\_\=\+\{\}\[\]\|\']/);

  // @param  {jQueryObject}  Inputs being tracked
function ErrorTracker(inputs) {
  this.inputs = [inputs];

  this.countInputs = function() {
    return inputs.length;
  };
}

function exists() {
  return this.length > 0;
}

  // Pad numbers with leading zeros
function pad(str, max) {
  return str.toString().length < max ? pad('0' + str.toString(), max) : str.toString();
}

function highlight(str, elements, className) {
  $.each(elements, function () {
    var rgxp = new RegExp(str, 'ig');
    var repl = '<span class="' + className + '">' + str + '</span>';
    this.innerHTML = this.innerHTML.replace(rgxp, repl);
  });
}

function closeAllNavLists_prep() {

  $('html, div.nav_dropdown').unbind('click.closeNavs');

    // User clicks anywhere on the document
  $('html, div.nav_dropdown_item').bind('click.closeNavs',
    function (event) {

    if (event.target.id != 'lantern_search' &&
        event.target.id != 'lantern_gettyToggle') {

        // Hide the navigation dropdowns
      $('div.nav_dropdown').hide();
    }
  });
}

  // Toggle navigation dropdown menus
function showThisDropdown(event) {

  event.stopPropagation();
  $('html, div.nav_dropdown').unbind('click.closeNavs');
  $('div.nav_dropdown').hide();
  var dropdown = $(this).find('div.nav_dropdown');
  dropdown.show();

  closeAllNavLists_prep();
}

/**
 * Checks that an input element does not contains special
 * characters when the form is submitted
 * 
 * @param  {jQueryObject}  element 
 * Input whose value is checked for special characters
 * 
 * @return {Boolean}        
 * True if value is ok; false if special chars are present
 */
function noSpecialChars(element) {

    // The input field contains special chars
  if (element.val().search(reSpecialChars) >= 0) {

      // Display user error message
    msg(['This field may not contain special characters'], 'error');

      // Highlight input's background
    $(element).css({ backgroundColor: '#FFF0DE' });

    return false;

    // The input field does not contain special chars
  } else {

      // Remove user error message
    $('div#message_wrapper').hide();

      // Reset input's background color
    $(element).css({ backgroundColor: '#FFF' });

    return true;
  }
}

// Call this on a module to add a Close button 
// which will remove the module from the DOM
function closeModule_button(module) {

  var close_button = $('<img>');
  $(close_button)
    .attr('src', '_assets/_images/64_close.png')
    .addClass('floatRight pointer closeButton')
    .css({
      maxHeight: '16px',
      opacity: '0.3',
      verticalAlign: 'middle',
      paddingTop: '3px'
    });
  $(module).find('h1').append(close_button);
  $(close_button).click(function () {
    $(module).remove();
  });
}

function promptToConfirm() {

    // Remove remnants from previous instances
  $('button#conf_button').remove();
  $('div#confirm_wrapper_temp')
    .replaceWith($('div#confirm_wrapper_temp').contents());

  var $submit = $(this);

  $submit.css({
    marginRight: '0',
    borderRight: 'none',
    color: '#CCC'
  });

  var $submitSize = $(this).css('fontSize');
  var $confirm = $('<button>');

  $confirm.attr('type', 'button')
    .attr('id', 'conf_button')
    .text('Confirm')
    .css({marginLeft: '-70px',
      borderLeft: '1px dotted #CCC',
      opacity: '0',
      borderRadius: '0 5px 5px 0',
      fontSize: $submitSize
    });

  function restoreSubmit() {

    $($confirm).remove();

    $('div#confirm_wrapper_temp')
      .replaceWith($('div#confirm_wrapper_temp').contents());

    $($submit).css({
      borderRight: '2px solid #DDD',
      color: '#669'
    });

    $($submit).add($confirm).unbind('mouseleave');
    $($confirm).unbind('click');
  }

  $confirm.click(restoreSubmit);

  $($submit).add($confirm).wrapAll('<div id="confirm_wrapper_temp">');

  $($confirm).insertAfter($submit);
  $($confirm).animate({
    marginLeft: '0',
    opacity: '1.0'
  }, 100);

  $('div#confirm_wrapper_temp').mouseleave(restoreSubmit);
}

function load_module(module, response) {

  $(module).find('div.loading_gif').remove();

  $(module)
    .append(response)
    .wrapInner('<div class="temp_wrapper"/>');

  $(module).find('.temp_wrapper')
    .fadeIn(800, function () {
      $(this).replaceWith($(module).find('.temp_wrapper').contents());
    });
}

function open_order(orderNum) {
  $('div[id$=_module]')
    .not('div#browse_orders_module')
    .not('div#work_module')
    .not('div#image_module')
    .remove();

    // Hide control panel
  $('div#control_panel_wide').hide();

  var newModule = $('<div>', {id: 'order_module', class: 'module double'});
  var header = $('<h1>').text('Order ' + pad(orderNum, 4));
  $(newModule).append(header);
  $(newModule).append('<div class="loading_gif">');

  $('div#module_tier2').prepend(newModule);
  $(document).scrollTop($('body').offset().top);

  $.ajax({
    type: 'GET',
    data: { order: orderNum },
    url: '_php/_order/load_order.php',
    success: function (response) {
      load_module(newModule, response);
    },
    error: function () {
      console.log('ajax request failed: _php/_order/load_order.php');
    },
    complete: function () {
      recently_visited();
    }
  });
}

function order_refreshImage(imageNum) {

  var $row = $('div.imageList_imageNum:contains('+imageNum+')')
        .parent('div.orderView_imageRow');
  var $loading = $('<div class="loading_gif">');

  $($row).contents().replaceWith($loading);

  $.ajax({
    type: 'GET',
    data: 'image=' + imageNum,
    url: '_php/_order/refresh_row.php',
    success: function (response) {
      $('div.loading_gif').remove();
      $($row).append(response).fadeIn(400);
    },
    error: function () {
      console.log('AJAX ERROR: refresh_row.php');
    }
  });
}

function order_navigation() {

    // Determine number of blocks needed
  var imageCount = $('#orderView_imageList > .orderView_imageRow').length;
  var blockCount = Math.floor(imageCount / 10);
  if ((imageCount % 10) !== 0) {
    blockCount++;
  }

    // Determine height for blocks
  var navbarHeight = $('div.order_nav_bar').height();
  var blockHeight = navbarHeight / blockCount;


    // Add navigation blocks to navigation bar
  for (var i = 1; i <= blockCount; i++) {
    var block = $('<div class="order_nav_block">');
    $(block).appendTo('div.order_nav_bar')
      .css({ height: blockHeight + 'px', lineHeight: blockHeight + 'px' });
  }

  $('div.order_nav_block').first().attr('id','order_nav_current');
  
    // Define events for page-block hovering
  $('div#order_nav_current').hover(function () {
    $(this).text($(this).parent().children().index(this) + 1);

  }, function () {
    $(this).text('');

  });

  $('div.order_nav_block:not(#order_nav_current)').hover(function () {
    $(this).text($(this).parent().children().index(this) + 1);

  }, function () {
    $(this).text('');

  });


    // Add anchors to image list to enable page jumping
  $('.orderView_imageRow').first().before('<a id="imageList_page1">');

  for (var i = 1; i <= blockCount; i++) {

    var row = (i * 10);
    $('.orderView_imageRow:eq(' + row + ')')
      .before('<a id="imageList_page' + (i + 1) + '">');

  }


  // Define event when user clicks on navigation block
  $('div.order_nav_block').click(function () {

    var page = $(this).parent().children().index(this) + 1;

    $('div#orderView_imageList')
      .animate({ top: - ((page * 530) - 530) }, 500);

    $('div#order_nav_current').attr('id', '');
    $(this).attr('id','order_nav_current');

  });
}

function order_updateProgress(event, orderNum) {

    // Remove any previous ajax response's existing javascript
  $('script#updateOrderStatus_temp').remove();

  var eleId = event.target.id;
  // console.log(eleId+' clicked for order '+orderNum); // Debug

  var status, statusClass;

  if ($('div[id=' + eleId + ']').hasClass('complete')) {
    status = '0';
    statusClass = '';

  } else {
    status = '1';
    statusClass = 'complete';

  }

  $.ajax({
    type: 'POST',
    data: 'process='+eleId+'&status='+status+'&orderNum='+orderNum,
    url: '_php/_order/update_progress.php',
    success: function (response) {
      console.log('order '+orderNum+' - attempting to set '+eleId+' status to '+status+', if user has sufficient privilege');
      $('div[id='+eleId+']').replaceWith(response);
    },
    error: function () {
      console.log('AJAX ERROR: _order/update_progress.php');
    }
  });
}

function order_updateCataloger(order, uid, username) {
  $.ajax({
    type: 'POST',
    data: 'order=' + order + '&uid=' + uid + '&username=' + username,
    url: '_php/_order/update_assigned.php',
    success: function (response) {
        
        // Remove any scripts generated by previous cataloger updates from the page
      $('script#updateCataloger_script').remove();
      
        // Add script to page generate user message
      $('body').prepend(response);
      
    },
    complete: function () {
      findOrders_loadResults(1, 'date_needed', 'ASC');
    }
  });
}

function updateOrderDueDate(orderNum) {

  var newDueDate = $('input#datepicker3').val();

  $.ajax({
    type: 'POST',
    data: 'newDueDate='+newDueDate+'&orderNum='+orderNum,
    url: '_php/_order/update_due_date.php',
    success: function(response) {
      
      $('span#orderDueClickable').text('').append(response);
      $('span#orderDueClickable').show();
      $('form#edit_date_form').remove();
      $('span#orderDueClickable').show();
    },
    error: function() {
      msg(['Failed to change the due date of this order'], 'error');
    }
  });
}

function editId_form(imageView, imageNum, orderNum){

  $.ajax({
    type: 'POST',
    data: 'imageView='+imageView+'&imageNum='+imageNum+'&orderNum='+orderNum,
    url: '_php/edit_id_form.php',
    success: function(response) {     
    
      $('div#image_module h1').append(response);
      
      console.log('imageView is '+imageView+' and imageNum is '+imageNum+' and orderNum is' +orderNum);
      console.log('Form load: success')
    },
    
    error: function() {
      console.log('Form failed to load', 'error') 
    }
  });
}

function editDate_form(orderNum, dateNeeded){
  
  $.ajax({
    type: 'POST',
    data:'orderNum='+orderNum+'&dateNeeded='+dateNeeded,
    url: '_php/edit_date_form.php',
    success: function(response) {     

      $('div#date_needed').append(response);
      
      console.log('orderNum is '+orderNum+' and dateNeeded is '+dateNeeded);
      console.log('Form load: success')
    },
    
    error: function() {
      console.log('Form failed to load', 'error') 
    }
  });
}

function recently_visited() {

  $('div#recently_visited_module').remove();

  var revi_module = $('<div id="recently_visited_module" class="module">');
  var header = $('<h1>').text('Recently Visited');
  $(revi_module).append(header);
  $(revi_module).append('<div class="loading_gif">');
  $(revi_module).insertAfter('div#user_module');

  $.ajax({
    type: 'GET',
    url: '_php/_homepage/activity_log.php',
    success: function (response) {
      $(revi_module).find('div.loading_gif').remove();

      $(revi_module)
        .append(response)
        .wrapInner('<div class="temp_wrapper"/>');

      $('#recently_visited_module .temp_wrapper')
        .fadeIn(500, function()
        {
          $(this).replaceWith($('#recently_visited_module .temp_wrapper').contents());
        });
    },
    error: function () {
      console.log('ajax request failed: recently_visited');
    }
  });
}

function usersBrowse_load() {

  $('div[id$=_module]').remove();

  $('div#control_panel_wide').hide();

  var ub_mod = $('<div id="usersBrowse_module" class="module">');
  var ub_header = $('<h1>').text('Browse Users');

  $(ub_mod)
    .append(ub_header)
    .append('<div class="loading_gif">');

  $('div#module_tier1a').prepend($(ub_mod));

  $.ajax({
    type: 'GET',
    url: '_php/users_browse.php',
    success: function (response) {
      load_module(ub_mod, response);
    },
    error: function () {
      console.log('AJAX ERROR: _php/users_browse.php');
    }
  });
}

function userProfile_load(userId) {

  $('div[id$=_module]')
    .not('div#usersBrowse_module')
    .remove();

  $('div#control_panel_wide').hide();

  var up_mod = $('<div id="userProfile_module" class="module">');
  var up_header = $('<h1>').text('Edit User');

  $(up_mod)
    .append(up_header)
    .append('<div class="loading_gif">');

  $('div#usersBrowse_module').after($(up_mod));

  $.ajax({
    type: 'POST',
    data: 'userId='+userId,
    url: '_php/_user/userProfile_load.php',
    success: function (response) {
      load_module(up_mod, response);
    },
    error: function () {
      console.log('AJAX ERROR: userProfile_load.php');
    }
  });
}

function userProfile_changePassword(userId) {

  var password_data = {};
  var errors = [];

  password_data.userId = userId;

  $('input#userProf_oldPass, input#userProf_newPass').each(
    function () {

      var value = $.trim($(this).val());

      if (value === '') {
        input_error($(this));
        errors.push($(this).attr('name'));

      } else {
        password_data[$(this).attr('name')] = value;

      }
    });

  console.log('form errors: ' + errors);

  if (errors.length === 0) {
    $.ajax({
      type: 'POST',
      data: { data: password_data },
      url: '_php/_user/userProfile_changePassword.php',
      success: function (response) {
        $('body').append(response);
        console.log('ajax request complete: password change');
      },
      error: function () {
        console.log('AJAX ERROR: userProfile_changePassword.php');
      }
    });

  } else {
    msg(['A required field was left blank'], 'error');
  }
}

function userProfile_updateNames(userId) {

  var name_data = {};
  var errors = [];
  var inputs = [
    'input#userProf_firstName',
    'input#userProf_lastName',
    'input#userProf_username',
    'input#userProf_email',
    'select#userProf_department',
    'select#userProf_userType'
  ].join(', ');

  name_data.userId = userId;

  $(inputs).each(function () {

    var value = $.trim($(this).val());

    if (value === '') {
      input_error($(this));
      errors.push($(this).attr('name'));
      msg(['A required field was left blank'], 'error');

    } else {
        // If username value is LESS THAN 4 chars
      if ($(this).attr('id')=='userProf_username' && value.length < 4) {
        input_error($(this));
        errors.push($(this).attr('name'));
        msg(['Username must be at least four characters in length'], 'error');

      } else {
          // Add value to data array
        name_data[$(this).attr('name')] = value;
        
      }
    }
  });

  console.log('form errors: ' + errors);

  if (errors.length === 0) {

    $.ajax({
      type: 'POST',
      data: { data: name_data },
      url: '_php/_user/userProfile_updateNames.php',
      success: function (response) {
        $('body').append(response);
        console.log('ajax request complete: update names');
      }, error: function () {
        console.log('AJAX ERROR: userProfile_updateNames.php');
      }
    });
  }
}

function userProfile_readPriv(wrapper, userId, priv) {

  $.ajax({
    type: 'POST',
    data: 'userId=' + userId + '&priv=' + priv,
    url: '_php/_user/userProfile_readPriv.php',
    success: function (response) {

      if (response == 'true') {
        $(wrapper).find('div.priv_left').css({ backgroundColor: '#669' }).text('ON');
        $(wrapper).find('div.priv_right').css({ backgroundColor: '#EEE' }).text('');

      } else {
        $(wrapper).find('div.priv_left').css({ backgroundColor: '#EEE' }).text('');
        $(wrapper).find('div.priv_right').css({ backgroundColor: '#CCC' }).text('OFF');
      }
    }, error: function () {
      console.log('AJAX ERROR: userProfile_readPriv.php');
    }
  });
}

function userProfile_togglePriv(wrapper, userId, priv) {

  $.ajax({
    type: 'POST',
    data: 'userId=' + userId + '&priv=' + priv,
    url: '_php/_user/userProfile_togglePriv.php',
    success: function (response) {
      $('div#userProfile_module').append(response);
      console.log('user ' + userId + ' ' + priv + ' updated');
    }, error: function () {
      console.log('AJAX ERROR: userProfile_togglePriv');
    }
  });
}

function registerNewUser_submit(formId) {

  var jsonData = {};
  var formAsJQuerySelector = 'form#' + formId;

  $(formAsJQuerySelector + ' input:not([type=button], [type=submit], [type=checkbox])').each(function () {
    var name = $(this).attr('name');
    jsonData[name] = $('input[name='+name+']').val();
  });
  
  var user_type = $(formAsJQuerySelector + ' select[name=user_type]').val();
  jsonData.user_type = user_type;

  var department = $(formAsJQuerySelector + ' select[name=department]').val();
  jsonData.department = department;

  $.ajax({
    type: 'POST',
    data: { jsonData: jsonData },
    url: '_php/_user/registerNewUser_submit.php',
    success: function (response) {
      $(body).prepend(response);

        if ($('form#createOrder_form select')
          .length > 0)
        {
          createOrder_submit(); 
          $('div#registerUser_module').remove();
          $('div.suggestion_text').remove();
        }

        else  
        {
          $('div#registerUser_module').remove();
          usersBrowse_load();
          console.log('File successfully loaded: registerNewUser_submit.php');
        }
          
      }, error: function() {
        console.error("Failed to load file: registerNewUser_submit.php");
    }
  });
}

function deleteUser_submit(userId) {

  $.ajax({
    type: 'POST',
    data: 'userId=' + userId,
    url: '_php/_user/deleteUser_submit.php',
    success: function (response) {
      $(body).prepend(response);
      console.log('File successfully loaded: deleteUser_submit.php');
    }, error: function () {
      console.error('Failed to load file: deleteUser_submit.php');
    }, complete: function () {
        // Reload the Browse Users module
      usersBrowse_load();
    }
  });
}

function updateExportFlag(record, status) {

  var flag_newStatus = status == 0 ? 1 : 0;

  record = pad(record, 6);
  console.log(record + ' flag status: ' + flag_newStatus);

  $.ajax({
    type: 'POST',
    data: 'flagged_for_export=' + flag_newStatus + '&image_id=' + record,
    url: '_php/update_export_flag.php',
    success: function (response) {
      $('div.imageList_imageNum:contains(' + record + ')')
        .siblings('div.flagRecord_button.active')
        .remove();

      var nearbyDelete = $('div.imageList_imageNum:contains(' + record + ')')
        .siblings('div.deleteRecord_button');

      $(nearbyDelete)
        .siblings('div.export_flag_status')
        .text(flag_newStatus);

      $(nearbyDelete).before(response);
      $('.flagRecord_button.active').addClass('faded');

    }
  });
}

function deleteImageRecord(deadRecord) {

  deadRecord = pad(deadRecord, 6);
  var confirmed = confirm('Are you sure you wish to delete image ' + deadRecord + '?');

  if (confirmed) {
    var xmlhttp;
    if (window.XMLHttpRequest) { // Modern browsers
      xmlhttp = new XMLHttpRequest();
    } else { // IE5 & IE6
      xmlhttp = new ActiveXObject('Microsoft.XMLHTTP');
    }

    console.log('Dead record (post-padding): ' + deadRecord);

    xmlhttp.onreadystatechange = function () {
      if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
        open_order(order_num);
      }
    };

    xmlhttp.open('GET', '_php/delete_image_record.php?deadImage=' + pad(deadRecord, 6), true);
    xmlhttp.send();
  }
}

function view_work_record(record) {

  record = $.trim(record);

  if (record != 'None') {
    record = pad(record, 6);
  }

  $('div#work_module').remove();

  var work_module = $('<div>', { id: 'work_module', class: 'module' });
  var work_header = $('<h1>').text('Work');
  $(work_module).append(work_header);
  $(work_module).append('<div class="loading_gif">');

  $('div#module_tier3').prepend($(work_module));

  $.ajax({
    type: 'GET',
    data: 'imageRecord='+record,
    url: '_php/view_work_record.php',
    success: function (response) {
      load_module(work_module, response);
    }
  });
}

function view_image_record(record) {

  record = pad($.trim(record), 6);

  $('div#image_module').remove();
  $('#lanternSearch_module').remove();

  var image_module = $('<div>', { id: 'image_module', class: 'module' });
  var image_header = $('<h1>').text('Image');
  $(image_module).append(image_header);
  $(image_module).append('<div class="loading_gif">');

  $('div#module_tier3').prepend(image_module);
  $(document).scrollTop($('body').offset().top);

  $.ajax({
    type: 'GET',
    data: 'imageRecord=' + record,
    url: '_php/view_image_record.php',
    success: function (response) {
      load_module(image_module, response);
    }
  });
}

function editImage_id(imageNum) {

  var newImageId = $('input#edit_id').val();

    $.ajax({                                                       
    type: 'POST', 
    data: 'newImageId='+newImageId+'&imageNum='+imageNum,
    url: '_php/edit_image_id.php',
    success: function(response) {

      view_image_record(imageNum);
      view_work_record(imageNum);

    },
    error: function() {
      msg(['Failed to change the image id'], 'error');
    }
  });
}

function image_viewer(imageNum) {

  var xmlhttp;
  if (window.XMLHttpRequest) { // Modern browsers
    xmlhttp = new XMLHttpRequest();
  } else { // IE5 & IE6
    xmlhttp = new ActiveXObject('Microsoft.XMLHTTP');
  }

  xmlhttp.onreadystatechange = function () {
    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
      $('body').append(xmlhttp.responseText);
    }
  };

  xmlhttp.open('GET', '_php/image_viewer.php?imageNum=' + imageNum, true);
  xmlhttp.send();
  console.log('IMAGE VIEWER: ' + imageNum);
}

function findOrders_loadForm() {

    // Remove existing modules
  $('div[id$=_module]').remove();

    // Hide control panel
  $('div#control_panel_wide').hide();

    // Create new module
  var newModule = $('<div>', { id: 'browse_orders_module', class: 'module double' });
  var newHeader = $('<h1 style="font-size: 1.7em;">').text('Orders');
  $(newModule).prepend(newHeader);

    // Add new module to the DOM
  $('div#module_tier1a').prepend(newModule);

  $.ajax({
    type: 'GET',
    url: '_php/_order/vieworders_form.php',
    success: function (response) {
      $('div.loading_gif').remove();
      $(newModule).append(response);
      $(document).scrollTop($('body').offset().top);
    }
  });

}

function order_range() {
  if ($('input[name=orderNum_range]').is(':checked')) {
    $('input[name=orderNum_end]').show();
  } else {
    $('input[name=orderNum_end]').hide();
  }
}

function unique_array(array) {
  return array.filter(function(el, index, arr) {
    return index == arr.indexOf(el);
  });
}

function suggest_input(inputName, minLen, searchArray, suggestionAreaId) {

    // If user has typed at least 2 characters
    // AND input value is NOT the same as the input's name
  if ($('input[name=' + inputName + ']').val().length >= minLen && $('input[name=' + inputName + ']').val() != inputName) {

    var typed = $('input[name=' + inputName + ']').val().toLowerCase();
    var suggestions = [];

    $.each(searchArray, function (index, val) {

      if (val.toLowerCase().indexOf(typed) >= 0) {

          // Add this match to suggestions
        suggestions.push(val);
        $('div#' + suggestionAreaId).text('');

        $.each(suggestions, function(index, val) {

          if ($('div#'+suggestionAreaId).text().indexOf(val) == -1) {

            $('div#' + suggestionAreaId).append('<div class="suggestion_text">'+val+'</div>');
          }
        });
      }
    });

  } else {
    $('div#' + suggestionAreaId).text('');

  }

  $('div.suggestion_text').click(function () {
    var selectedSuggestion = $(this).text();
    var thisSuggestionDiv = $(this).parents('div#' + suggestionAreaId);

    $(thisSuggestionDiv)
      .prev('input[name='+inputName+']')
      .val(selectedSuggestion);

    $(thisSuggestionDiv)
      .children()
      .remove();
  });
}

function suggest_inputFill(inputName, minLen, searchArray, suggestionAreaId, fillArray)
{

  if (
    $('input[name='+inputName+']').val().length >= minLen
    && 
    $('input[name='+inputName+']').val() != inputName
    )
  // User has typed at least 2 characters
  // AND input value is NOT the same as the input's name
  {
    
    console.log('function called: suggest_inputFill('+inputName+', '+searchArray+', '+suggestionAreaId+')');

    var typed = $('input[name='+inputName+']').val().toLowerCase();
    console.log('User typed: "'+typed+'"');
    var suggestions = [];

    $.each(searchArray, function(index, val)
    {
      console.log('Array contains: "'+val+'"');
      if (val.toLowerCase().indexOf(typed) >= 0)
      {
      console.log('"'+typed+'" matched "'+val+'" at position '+index);
        suggestions.push(val); // Add this match to suggestions
        $('div#'+suggestionAreaId).text('');
        $.each(suggestions, function(index, val)
        {
          if ($('div#'+suggestionAreaId).text().indexOf(val) == -1)
          {
            $('div#'+suggestionAreaId).append('<div class="suggestion_text">'+val+'</div>');
          }
        })
      }
    })
  }

  else
  {
    // console.log('function called, but not completed');
    $('div#'+suggestionAreaId).text('');
  }
  
  $('div.suggestion_text').click(function()
  {
  
    var selectedSuggestion = $(this).text();
    var thisSuggestionDiv = $(this)
    .parents('div#'+suggestionAreaId);

    $(thisSuggestionDiv)
      .prev('input[name='+inputName+']')
      .val(selectedSuggestion);

    $(thisSuggestionDiv)
      .children()
      .remove();  


    $.each(fillArray, function(index, val)
    {
      if ((selectedSuggestion) == (index))
      {
        $.each(val, function (k, v)
        {
    
      $('input[name='+k+']').val(v);  
      console.log(''+k+' is '+v+'');
      $('select[name= '+k+']').find('option:contains('+v+')').attr('selected', true);
        })
      }
    })
  });       
} 

function findOrders_loadResults(pageNum, orderBy, order) {
  $('div#findOrders_resultsTable').children().remove();
  $('div#findOrders_resultsTable').append('<div class="loading_gif">');

  var orderNum_start = $('input[name=orderNum_start]').val();
  var orderNum_end = $('input[name=orderNum_end]').val();
  var patron = $('input[name=patron]').val();
  var department = $('select[name=department]').val();
  var created_by = $('input[name=created_by]').val();
  var created_start = $('input[name=created_start]').val();
  var created_end = $('input[name=created_end]').val();
  var updated_by = $('input[name=updated_by]').val();

  var rangeChecked = $('input[name=orderNum_range]').is(':checked');
  var orderNum_range = rangeChecked ? 'yes' : 'no';

  var showIncChecked = $('input[name=show_incomplete]').is(':checked');
  var show_incomplete = showIncChecked ? 'yes' : 'no';
  
  showCompChecked = $('input[name=show_complete]').is(':checked');
  var show_complete = showCompChecked ? 'yes' :'no';

  var dataStr = [
    'orderNum_start=' + orderNum_start,
    '&orderNum_end=' + orderNum_end,
    '&orderNum_range=' + orderNum_range,
    '&patron='+patron,
    '&department=' + department,
    '&show_incomplete=' + show_incomplete,
    '&show_complete=' + show_complete,
    '&created_by=' + created_by,
    '&created_start=' + created_start,
    '&created_end=' + created_end,
    '&updated_by=' + updated_by,
    '&pageNum=' + pageNum,
    '&orderBy=' + orderBy,
    '&order=' + order
  ].join('');

  $.ajax({
    type: 'GET',
    data: dataStr,
    url: '_php/_order/vieworders_results.php',
    success: function (response) {
      $('div#findOrders_resultsTable div.loading_gif').remove();
      $('div#findOrders_resultsTable').append(response);
    }
  });

}

function findOrders_reset() {

    // Reset all inputs to their default states
  $('input[name=orderNum_start]').val('');
  $('input[name=orderNum_end]').val('').hide();
  $('input[name=orderNum_range]').prop('checked', false);
  $('input[name=show_incomplete]').prop('checked', true);
  $('input[name=show_complete]').prop('checked', false);
  $('input[name=patron]').val('');
  $('select[name=department]').val('');
  $('input[name=created_by]').val('');
  $('input[name=created_start]').val('');
  $('input[name=created_end]').val('');
  $('input[name=updated_by]').val('');

    // Remove any lingering term suggestions below the text input fields
  $('div.suggestion_text').remove();
}

function catalog_work() {
  var xmlhttp;
  if (window.XMLHttpRequest) { // Modern browsers
    xmlhttp = new XMLHttpRequest();
  } else { // IE5 & IE6
    xmlhttp = new ActiveXObject('Microsoft.XMLHTTP');
  }

  $('div#work_module div.content_line')
    .add('div#work_module div.cataloguingPane')
    .add('p#noAssocWork')
    .add('div#work_module div.module_footer')
    .remove();

  xmlhttp.onreadystatechange = function () {
    if (xmlhttp.readyState == 1) {
      $('div#work_module').append('<div class="loading_gif">');
    }
    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
      $('div#work_module div.loading_gif').remove();
      load_module('div#work_module', xmlhttp.responseText);
    }
  };

  xmlhttp.open('GET', '_php/catalog_work.php', true);
  xmlhttp.send();
}

function work_assign_preview(image, work) {

  var lengthsOk = image.length == 6 && work.length == 6;
  var typesOk = $.isNumeric(image) && $.isNumeric(work);
  var allOk = lengthsOk && typesOk;

  if (!allOk) {
    return;
  }

  $.ajax({
    type: 'POST',
    data: 'image=' + image + '&work=' + work,
    url: '_php/work_assign_preview.php',
    success: function (response) {
      $('div.workRecord_thumb').replaceWith(response);
      console.log('successful ajax post: _php/work_assign_preview.php');
      console.log('preferred image, ' + image + ', assigned to work '+work);
    }, error: function () {
      console.log('AJAX ERROR: _php/work_assign_preview.php');
    }
  });
}

function catalog_image() {

  var xmlhttp;
  if (window.XMLHttpRequest) { // Modern browsers
    xmlhttp = new XMLHttpRequest();
  } else { // IE5 & IE6
    xmlhttp = new ActiveXObject('Microsoft.XMLHTTP');
  }

  $('div#image_module div.content_line')
    .add('div#image_module div.cataloguingPane')
    .remove();

  xmlhttp.onreadystatechange = function () {
    if (xmlhttp.readyState == 1) {
      $('div#image_module').append('<div class="loading_gif">');
    }
    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
      $('div.loading_gif').remove();
      load_module('div#image_module', xmlhttp.responseText);
    }
  };

  xmlhttp.open('GET', '_php/catalog_image.php', true);
  xmlhttp.send();
}

// TODO: Resume formatting cleanup from here

function displayMeasurements() {
  var selectedMeasureType = $(this).find('option:selected').val();
  var thisRow = $(this).parents('div.catRowWrapper');

  if (
       selectedMeasureType == "Circumference"
    || selectedMeasureType == "Depth"
    || selectedMeasureType == "Diameter"
    || selectedMeasureType == "Distance between"
    || selectedMeasureType == "Height"
    || selectedMeasureType == "Length"
    || selectedMeasureType == "Width"
  ) {
  
    $(thisRow).find('[id*=measurementFieldDiv1_]').show();
    $(thisRow).find('[id*=measurementFieldDiv2_]').hide();
    $(thisRow).find('[id*=bitMeasurement]').hide();
    $(thisRow).find('[id*=commonMeasurement1_]').show();
    $(thisRow).find('[id*=commonMeasurementList1_]').show();
    $(thisRow).find('[id*=commonMeasurement2_]').hide();
    $(thisRow).find('[id*=commonMeasurementList2_]').hide();
    $(thisRow).find('[id*=areaMeasurement]').hide();
    $(thisRow).find('[id*=countMeasurement]').hide();
    $(thisRow).find('[id*=timeMeasurement]').hide();
    $(thisRow).find('[id*=fileMeasurement]').hide();
    $(thisRow).find('[id*=resolutionMeasurement]').hide();
    $(thisRow).find('[id*=weightMeasurement]').hide();
    $(thisRow).find('[id*=otherMeasurement]').hide();
    $(thisRow).find('[id*=inchesMeasurement]').hide();
    
    // Cause inches field to remain if moving from one measurement type to another with 'ft' selected as unit
    
    var selectedUnit = $(thisRow).find('[id*=commonMeasurementList] option:selected').attr('id');
  
    if (selectedUnit == "ft") {
    
      $(thisRow).find('[id*=inchesMeasurement]').show();
    }
    
    if (selectedUnit != "ft") {
    
      $(thisRow).find('[id*=inchesMeasurement]').hide();
    }
  }
  
  if (selectedMeasureType == "Area") {
    $(thisRow).find('[id*=measurementFieldDiv1_]').show();
    $(thisRow).find('[id*=measurementFieldDiv2_]').hide();
    $(thisRow).find('[id*=bitMeasurement]').hide();
    $(thisRow).find('[id*=commonMeasurement1_]').hide();
    $(thisRow).find('[id*=commonMeasurementList1_]').hide();
    $(thisRow).find('[id*=commonMeasurement2_]').hide();
    $(thisRow).find('[id*=commonMeasurementList2_]').hide();
    $(thisRow).find('[id*=areaMeasurement]').show();
    $(thisRow).find('[id*=countMeasurement]').hide();
    $(thisRow).find('[id*=timeMeasurement]').hide();
    $(thisRow).find('[id*=fileMeasurement]').hide();
    $(thisRow).find('[id*=resolutionMeasurement]').hide();
    $(thisRow).find('[id*=weightMeasurement]').hide();
    $(thisRow).find('[id*=otherMeasurement]').hide();
    $(thisRow).find('[id*=inchesMeasurement]').hide();
  }
  
  if (selectedMeasureType == "Bit depth") {
    $(thisRow).find('[id*=measurementFieldDiv1_]').show();
    $(thisRow).find('[id*=measurementFieldDiv2_]').hide();
    $(thisRow).find('[id*=bitMeasurement]').show();
    $(thisRow).find('[id*=commonMeasurement1_]').hide();
    $(thisRow).find('[id*=commonMeasurementList1_]').hide();
    $(thisRow).find('[id*=commonMeasurement2_]').hide();
    $(thisRow).find('[id*=commonMeasurementList2_]').hide();
    $(thisRow).find('[id*=areaMeasurement]').hide();
    $(thisRow).find('[id*=countMeasurement]').hide();
    $(thisRow).find('[id*=timeMeasurement]').hide();
    $(thisRow).find('[id*=fileMeasurement]').hide();
    $(thisRow).find('[id*=resolutionMeasurement]').hide();
    $(thisRow).find('[id*=weightMeasurement]').hide();
    $(thisRow).find('[id*=otherMeasurement]').hide();
  }
  
  if (selectedMeasureType == "Count") {
    $(thisRow).find('[id*=measurementFieldDiv1_]').show();
    $(thisRow).find('[id*=measurementFieldDiv2_]').hide();
    $(thisRow).find('[id*=bitMeasurement]').hide();
    $(thisRow).find('[id*=commonMeasurement1_]').hide();
    $(thisRow).find('[id*=commonMeasurementList1_]').hide();
    $(thisRow).find('[id*=commonMeasurement2_]').hide();
    $(thisRow).find('[id*=commonMeasurementList2_]').hide();
    $(thisRow).find('[id*=areaMeasurement]').hide();
    $(thisRow).find('[id*=countMeasurement]').show();
    $(thisRow).find('[id*=timeMeasurement]').hide();
    $(thisRow).find('[id*=fileMeasurement]').hide();
    $(thisRow).find('[id*=resolutionMeasurement]').hide();
    $(thisRow).find('[id*=weightMeasurement]').hide();
    $(thisRow).find('[id*=otherMeasurement]').hide();
    $(thisRow).find('[id*=inchesMeasurement]').hide();
  }
  
  if (selectedMeasureType == "Duration" || selectedMeasureType == "Running time") {
    $(thisRow).find('[id*=measurementFieldDiv1_]').hide();
    $(thisRow).find('[id*=measurementFieldDiv2_]').hide();
    $(thisRow).find('[id*=bitMeasurement]').hide();
    $(thisRow).find('[id*=commonMeasurement1_]').hide();
    $(thisRow).find('[id*=commonMeasurementList1_]').hide();
    $(thisRow).find('[id*=commonMeasurement2_]').hide();
    $(thisRow).find('[id*=commonMeasurementList2_]').hide();
    $(thisRow).find('[id*=areaMeasurement]').hide();
    $(thisRow).find('[id*=countMeasurement]').hide();
    $(thisRow).find('[id*=timeMeasurement]').show();
    $(thisRow).find('[id*=fileMeasurement]').hide();
    $(thisRow).find('[id*=resolutionMeasurement]').hide();
    $(thisRow).find('[id*=weightMeasurement]').hide();
    $(thisRow).find('[id*=otherMeasurement]').hide();
    $(thisRow).find('[id*=inchesMeasurement]').hide();
  }
  
  if (selectedMeasureType == "File size") {
    $(thisRow).find('[id*=measurementFieldDiv1_]').show();
    $(thisRow).find('[id*=measurementFieldDiv2_]').hide();
    $(thisRow).find('[id*=bitMeasurement]').hide();
    $(thisRow).find('[id*=commonMeasurement1_]').hide();
    $(thisRow).find('[id*=commonMeasurementList1_]').hide();
    $(thisRow).find('[id*=commonMeasurement2_]').hide();
    $(thisRow).find('[id*=commonMeasurementList2_]').hide();
    $(thisRow).find('[id*=areaMeasurement]').hide();
    $(thisRow).find('[id*=countMeasurement]').hide();
    $(thisRow).find('[id*=timeMeasurement]').hide();
    $(thisRow).find('[id*=fileMeasurement]').show();
    $(thisRow).find('[id*=resolutionMeasurement]').hide();
    $(thisRow).find('[id*=weightMeasurement]').hide();
    $(thisRow).find('[id*=otherMeasurement]').hide();
    $(thisRow).find('[id*=inchesMeasurement]').hide();
  }
  
  if (selectedMeasureType == "Resolution") {
    $(thisRow).find('[id*=measurementFieldDiv1_]').hide();
    $(thisRow).find('[id*=measurementFieldDiv2_]').hide();
    $(thisRow).find('[id*=bitMeasurement]').hide();
    $(thisRow).find('[id*=commonMeasurement1_]').hide();
    $(thisRow).find('[id*=commonMeasurementList1_]').hide();
    $(thisRow).find('[id*=commonMeasurement2_]').hide();
    $(thisRow).find('[id*=commonMeasurementList2_]').hide();
    $(thisRow).find('[id*=areaMeasurement]').hide();
    $(thisRow).find('[id*=countMeasurement]').hide();
    $(thisRow).find('[id*=timeMeasurement]').hide();
    $(thisRow).find('[id*=fileMeasurement]').hide();
    $(thisRow).find('[id*=resolutionMeasurement]').show();
    $(thisRow).find('[id*=weightMeasurement]').hide();
    $(thisRow).find('[id*=otherMeasurement]').hide();
    $(thisRow).find('[id*=inchesMeasurement]').hide();
  }
  
  if (selectedMeasureType == "Scale") {
    $(thisRow).find('[id*=measurementFieldDiv1_]').show();
    $(thisRow).find('[id*=measurementFieldDiv2_]').show();
    $(thisRow).find('[id*=bitMeasurement]').hide();
    $(thisRow).find('[id*=commonMeasurement1_]').show();
    $(thisRow).find('[id*=commonMeasurementList1_]').show();
    $(thisRow).find('[id*=commonMeasurement2_]').show();
    $(thisRow).find('[id*=commonMeasurementList2_]').show();
    $(thisRow).find('[id*=areaMeasurement]').hide();
    $(thisRow).find('[id*=countMeasurement]').hide();
    $(thisRow).find('[id*=timeMeasurement]').hide();
    $(thisRow).find('[id*=fileMeasurement]').hide();
    $(thisRow).find('[id*=resolutionMeasurement]').hide();
    $(thisRow).find('[id*=weightMeasurement]').hide();
    $(thisRow).find('[id*=otherMeasurement]').hide();
    $(thisRow).find('[id*=inchesMeasurement]').hide();
  }
  
  if (selectedMeasureType == "Size") {
    $(thisRow).find('[id*=measurementFieldDiv1_]').show();
    $(thisRow).find('[id*=measurementFieldDiv2_]').hide();
    $(thisRow).find('[id*=bitMeasurement]').hide();
    $(thisRow).find('[id*=commonMeasurement1_]').hide();
    $(thisRow).find('[id*=commonMeasurementList1_]').hide();
    $(thisRow).find('[id*=commonMeasurement2_]').hide();
    $(thisRow).find('[id*=commonMeasurementList2_]').hide();
    $(thisRow).find('[id*=areaMeasurement]').hide();
    $(thisRow).find('[id*=countMeasurement]').hide();
    $(thisRow).find('[id*=timeMeasurement]').hide();
    $(thisRow).find('[id*=fileMeasurement]').hide();
    $(thisRow).find('[id*=resolutionMeasurement]').hide();
    $(thisRow).find('[id*=weightMeasurement]').hide();
    $(thisRow).find('[id*=otherMeasurement]').hide();
    $(thisRow).find('[id*=inchesMeasurement]').hide();
  }
  
  if (selectedMeasureType == "Weight") {
    $(thisRow).find('[id*=measurementFieldDiv1_]').show();
    $(thisRow).find('[id*=measurementFieldDiv2_]').hide();
    $(thisRow).find('[id*=bitMeasurement]').hide();
    $(thisRow).find('[id*=commonMeasurement1_]').hide();
    $(thisRow).find('[id*=commonMeasurementList1_]').hide();
    $(thisRow).find('[id*=commonMeasurement2_]').hide();
    $(thisRow).find('[id*=commonMeasurementList2_]').hide();
    $(thisRow).find('[id*=areaMeasurement]').hide();
    $(thisRow).find('[id*=countMeasurement]').hide();
    $(thisRow).find('[id*=timeMeasurement]').hide();
    $(thisRow).find('[id*=fileMeasurement]').hide();
    $(thisRow).find('[id*=resolutionMeasurement]').hide();
    $(thisRow).find('[id*=weightMeasurement]').show();
    $(thisRow).find('[id*=otherMeasurement]').hide();
    $(thisRow).find('[id*=inchesMeasurement]').hide();
  }
  
  if (selectedMeasureType == "Other") {
    $(thisRow).find('[id*=measurementFieldDiv1_]').show();
    $(thisRow).find('[id*=measurementFieldDiv2_]').hide();
    $(thisRow).find('[id*=bitmeasurement]').hide();
    $(thisRow).find('[id*=commonmeasurement1_]').hide();
    $(thisRow).find('[id*=commonmeasurementList1_]').hide();
    $(thisRow).find('[id*=commonmeasurement2_]').hide();
    $(thisRow).find('[id*=commonmeasurementList2_]').hide();
    $(thisRow).find('[id*=areameasurement]').hide();
    $(thisRow).find('[id*=countMeasurement]').hide();
    $(thisRow).find('[id*=timeMeasurement]').hide();
    $(thisRow).find('[id*=fileMeasurement]').hide();
    $(thisRow).find('[id*=resolutionMeasurement]').hide();
    $(thisRow).find('[id*=weightMeasurement]').hide();
    $(thisRow).find('[id*=otherMeasurement]').show();
    $(thisRow).find('[id*=inchesMeasurement]').hide();
  }

  // Show "inches" field when appropriate

  $('[id*=commonMeasurementList]').change(function()
  {
    var selectedType = $(this).parents('div.catRowWrapper').find('select[id*=measurementType] option:selected').val();
    var selectedUnit = $(this).find('option:selected').val();
    
    if (selectedType != 'Scale')
    {
    
      if (selectedUnit == "ft") {
        $(this).parents('div.catRowWrapper').find('[id*=inchesMeasurement]').show();
      }
      
    }
      
    if (selectedUnit != "ft")
    {
      $(this).parents('div.catRowWrapper').find('[id*=inchesMeasurement]').hide();
    }
    
  });
}

function displaySpecificLocation(){

  var selectedSpecificLocationType = $(this).find('option:selected').val();
  var thisRow = $(this).parents('div.catRowWrapper');
  var newRow = $(thisRow).next('.catRowWrapper');
  var noteRow = $(newRow).next('.catRowWrapper');

  if (selectedSpecificLocationType == "Address"){
    $(noteRow).slideUp('fast');
    $(newRow).slideDown('fast');
    $(newRow).find('[id*=specificLocationAddress]').show();
    $(newRow).find('[id*=specificLocationZip]').show();
    $(noteRow).find('[id*=specificLocationNote]').hide();
    $(newRow).find('[id*=specificLocationLat]').hide();
    $(newRow).find('[id*=specificLocationLong]').hide();
  } 
  
  if (selectedSpecificLocationType == "LatLng"){
    $(noteRow).slideUp('fast');
    $(newRow).slideDown('fast');
    $(newRow).find('[id*=specificLocationLat]').show();
    $(newRow).find('[id*=specificLocationLong]').show();
    $(noteRow).find('[id*=specificLocationNote]').hide();
    $(newRow).find('[id*=specificLocationAddress]').hide();
    $(newRow).find('[id*=specificLocationZip]').hide();
  }


  if (selectedSpecificLocationType == "Note"){
    $(newRow).slideUp('fast');
    $(noteRow).slideDown('fast');
    $(noteRow).find('[id*=specificLocationNote]').show();
    $(newRow).find('[id*=specificLocationLat]').hide();
    $(newRow).find('[id*=specificLocationLong]').hide();
    $(newRow).find('[id*=specificLocationAddress]').hide();
    $(newRow).find('[id*=specificLocationZip]').hide();
  }

  if (selectedSpecificLocationType == "Type"){
    $(newRow).find('[id*=specificLocationAddress]').hide();
    $(newRow).find('[id*=specificLocationZip]').hide();
    $(newRow).find('[id*=specificLocationLat]').hide();
    $(newRow).find('[id*=specificLocationLong]').hide();
    $(noteRow).find('[id*=specificLocationNote]').hide();
    $(newRow).slideUp('fast');
    $(noteRow).slideUp('fast');
  }
}

function displayRelatedWorksSearch(){

  var selectedRelatedWorksType = $(this).find('option:selected').val();
  var thisRow = $(this).parents('div.catRowWrapper');
  var newRow = $(thisRow).next('.catRowWrapper');

  if (selectedRelatedWorksType == "Type"){
  $(newRow).slideUp('fast');
  } 

  else{
  $(newRow).slideDown('fast');
  }
}

function resetMeasurementsRow($row) {
  $row.find('[id*=measurementFieldDiv]').hide();
  $row.find('[id*=measurementFieldDiv1]').show();
  $row.find('[id*=measurementType]').show();
  $row.find('[id*=bitMeasurement]').hide();
  $row.find('[id*=commonMeasurement]').hide();
  $row.find('[id*=commonMeasurement2]').hide();
  $row.find('[id*=areaMeasurement]').hide();
  $row.find('[id*=countMeasurement]').hide();
  $row.find('[id*=timeMeasurement]').hide();
  $row.find('[id*=fileMeasurement]').hide();
  $row.find('[id*=resolutionMeasurement]').hide();
  $row.find('[id*=weightMeasurement]').hide();
  $row.find('[id*=otherMeasurement]').hide();
  $row.find('[id*=inchesMeasurement]').hide();
}

function resetDateRow($row) {
  $row.find('div[id*=dateRangeSpan]').hide();
  $row.find('input:checkbox[id*=dateRange]').prop('checked', false);
  $row.find('input:checkbox[id*=circaDate]').prop('checked', false);
}

function resetSpecificRow($row){
$row.find('[id*=specificLocationAddress]').hide();
$row.find('[id*=specificLocationZip]').hide();
$row.find('[id*=specificLocationLat]').hide();
$row.find('[id*=specificLocationLong]').hide();
$row.find('[id*=specificLocationNote]').hide()
$row.find('[id*=specificLocationRow]').hide();
}

function reincrementSectionRows($section) {

  var i = 0;
  // For each div.clone_wrap
  $section.find('div.clone_wrap').each(function() {

    // For each select list and input element
    $(this).find('select, input').each(function() {

      // Update input ids
      var idRoot = $(this).attr('id').slice(0, -1);
      var newId = idRoot+String(i);
      $(this).attr('id', newId);

      // Update input names
      var nameRoot = $(this).attr('name').slice(0, -1);
      var newName = nameRoot+String(i);
      $(this).attr('name', newName);

    });
    i ++;
  });
}

// Define an array of cataloging rows than consist of two lines
var rowsWithTwoLines = ['Agent','Location','Inscription','Rights','Source','Date'];

function addRow_v2() {

  var $thisRow = $(this).parents('div.clone_wrap');
  var thisRowTitle = $thisRow.find('.titleText').text();
  var $thisSection = $thisRow.parent('div.catSectionWrapper');
  var numRows = $thisRow.parents('div.module').find('.titleText:contains('+thisRowTitle+')').length;

  // If there are less than ten existing rows of this type
  if (numRows < 10) {

    // Clone the selected row
    var $newRow = $thisRow.clone(true);

    // If selected row was 'Measure', reset the hidden fields
    if (thisRowTitle == 'Measure') {
      resetMeasurementsRow($newRow);
    }

    // If selected row was 'Date', reset the hidden fields
    if (thisRowTitle == 'Date') {
      resetDateRow($newRow);
    }

    //If selected row was 'Specific Location', reset the hidden fields
    if (thisRowTitle == 'Specific Location') {
      resetSpecificRow($newRow);
    }

    // Clear the values of the new row's input fields
    $newRow.find('input[type=text], input[type=hidden]').val('');
    $newRow.find('select option:first').attr('selected', 'selected');

    // Hide the new row's add/remove buttons
    $newRow.find('.addButton img, .removeButton img').hide();

    // Insert new row into the DOM
    $newRow.insertAfter($thisRow).hide().slideDown('fast');

    // Reset preferred status and appearance of new row's title text
    $newRow.find('input.cat_display').val('1');
    $newRow.find('div.titleText').removeClass('ital lightGrey');

    // Re-increment the ids and names of all inputs within this data type section
    reincrementSectionRows($thisSection);

    // Remove any lingering authority results
    $('div.resultsWrapper').remove();

  // If there are already ten rows of this type, do not allow another to be added
  } else {
    msg(['You may only create a maximum of 10 '+thisRowTitle+' rows'], 'error');
  }
}

function removeRow_v2() {

  var $thisRow = $(this).parents('div.clone_wrap');
  var thisRowTitle = $thisRow.find('.titleText').text();
  var $thisSection = $thisRow.parent('div.catSectionWrapper');
  var numRows = $thisRow.parents('div.module').find('.titleText:contains('+thisRowTitle+')').length;

  // Remove any lingering authority results
  $('div.resultsWrapper').remove();

  // If there are at least two rows of this type remaining, 
  // allow the removal of one row
  if (numRows > 1) {

    // Kill the red shirt
    $thisRow.slideUp('fast', function() {
      $thisRow.remove().promise().done(function() {
        // Re-increment the ids and names of all inputs within this data type section
        reincrementSectionRows($thisSection);
      });
    });

  // If user is attempting to remove the last remaining row of this data type,
  // clear the row's values instead
  } else {

    // Reset all select and input values
    $thisRow.find('input[type=text], input[type=hidden]').val('');
    $thisRow.find('input[type=text]:not("input[id*=agentRole]"), input[type=hidden]').css({ backgroundColor: '#FFF' });
    $thisRow.find(':checked').removeAttr('checked');
    $thisRow.find('select option').removeAttr('selected');
    $thisRow.find('select option:first').attr('selected', 'selected');

    if (thisRowTitle == 'Date') {
      $thisRow.find('div[id^=dateRangeSpan]').hide();
    }

    // Reset preferred status and appearance of the row's title text
    $thisRow.find('input.cat_display').val('1');
    $thisRow.find('div.titleText').removeClass('ital lightGrey');
  }
}

function catalogUI_prepAddRemove() {

  $('div.addButton img').add('div.removeButton img').hide();
  $('div.clone_wrap').unbind('hover').hover(function() {
    $(this).find('div.addButton img, div.removeButton img').show();
  }, function() {
    $(this).find('div.addButton img, div.removeButton img').hide();
  });
}

function catalogUI_dateRange_onLoad() {
  var status = $(this).prop('checked');
  if (status == true) 
  {
    $(this).parents('div.catRowWrapper')
      .next('div.catRowWrapper')
      .find('div[id*=dateRangeSpan]').css({ display: 'inline-block' });
      console.log('date range shown');
  }
  else
  {
    $(this).parents('div.catRowWrapper')
      .next('div.catRowWrapper')
      .find('div[id*=dateRangeSpan]').hide();
  }
}

function catalogUI_constrainEnterPress(event) {
  if ((event.which && event.which == 13) || (event.keyCode && event.keyCode == 13))
  {
    $(this).parents('.catRowWrapper').find('input[type=submit]').click();
    return false;
  }
  else
  {
    return true;
  }
}

function catalogUI_prepFields() {
  $('[id*=measurementFieldDiv]').hide();
  $('[id*=measurementFieldDiv1]').show();
  $('[id*=measurementType]').show();
  $('[id*=bitMeasurement]').hide();
  $('[id*=commonMeasurement1_]').show();
  $('[id*=commonMeasurementList1_]').show();
  $('[id*=commonMeasurement2_]').hide();
  $('[id*=commonMeasurementList2_]').hide();
  $('[id*=areaMeasurement]').hide();
  $('[id*=countMeasurement]').hide();
  $('[id*=timeMeasurement]').hide();
  $('[id*=fileMeasurement]').hide();
  $('[id*=resolutionMeasurement]').hide();
  $('[id*=weightMeasurement]').hide();
  $('[id*=otherMeasurement]').hide();
  $('[id*=inchesMeasurement]').hide();
}

function catalogUI_searchAuthority(fieldName, nearbyAuthorityFieldName) {
  // console.log('function called'); // Debug

  // var json = {};
  // json['fieldName'] = fieldName;
  var fieldName = fieldName;

  // console.log(JSON.stringify(json));

  var field = $('input[name='+fieldName+']');
  // json['fieldVal'] = $(field).val();
  var fieldVal = $(field).val();
  var fieldRow = $(field).parents('div.catRowWrapper');
  var nearbyAuthorityField = $('input[name='+nearbyAuthorityFieldName+']');
  var resultsWrapper = $('<div class="catRowWrapper resultsWrapper" style="height: auto;">');

  // Remove old results wrapper
  $(field).parents('div.catRowWrapper')
    .next('div.catRowWrapper.resultsWrapper')
    .remove();

  // Add new results wrapper
  $(fieldRow).after(resultsWrapper);
  $(field).addClass('authorityLoading');

  $.ajax({
    type: 'POST',
    // data: { json: json },
    data: 'fieldName='+fieldName+'&fieldVal='+fieldVal,
    url: '_php/_authority_search/perform_search.php',
    success: function(response)
    {
      console.log('ajax request succeeded. fieldName: '+fieldName);
      $(field).removeClass('authorityLoading');
      $(resultsWrapper).prepend(response);
    },
    error: function()
    {
      console.error('AJAX error - failed to load: perform_search.php');
    }
  });
}

function catalogUI_incrementPopularity(authorityId, table) {
  console.log('updated popularity of '+authorityId+' in '+table);

  $.ajax({
    type: 'POST',
    data: 'authorityId='+authorityId+'&table='+table,
    url: '_php/_authority_search/increment_popularity.php',
    success: function(response)
    {

    },
    error: function()
    {
      console.log('AJAX ERROR: _php/_authority_search/increment_popularity.php');
    }
  });
}

function catalogUI_clearFields(recordType) {

  var thisPanel = $('div#'+recordType+'_module').find('.cataloguingPane');

  $(thisPanel).find('input:text').val('');
  $(thisPanel).find('select').val('1');
  $(thisPanel).find('textarea').val('');
  $(thisPanel).find('input:hidden').val('');
  $(thisPanel).find('input.cat_display').val(1);
  $(thisPanel).find('input:checkbox').prop('checked', false);
  $(thisPanel).find('div[id*=dateRangeSpan]').hide();

  console.log(recordType+' record fields cleared'); // Debugging
}

function autoWidth() {
  var input = $(this);
  var wrapper = $(input).parents('div.catRowWrapper');
  var wrapper_width = $(wrapper).width();
  var otherElements_width = 0;
  var otherElements_count = 0;

  $(wrapper).find('div.catCell:not(*>:has(.autoWidth, input[type=hidden]))')
    .each(function()
  {
    otherElements_width += $(this).width();
    otherElements_count ++;
  });

  // if ($(window).width() > 1185)
  // {
  //  $(this).css({ width: (wrapper_width - otherElements_width) - (otherElements_count * 3) - 101 - 65 + 'px' });
  // }
  // else
  // {
    $(this).css({ width: (wrapper_width - otherElements_width) - (otherElements_count * 3) - 150 + 'px' });
  // }  
}

function save_catalog_changes(workNum, imageNum) {
  var json = {};

  var blankVals = ['- Type -','- Measurement -','- Name type -','Title',"Agent role (e.g. 'artist; painter')", 'Agent','Date','Material','Technique','Work Type','Cultural Context','Style Period','Location','Description','State/Edition','Subject','Inscription text','Inscription author','Inscription location','Rights holder','Rights text','Source name','Source text'];

  $('form#catalog_form input:not([type=button], [type=submit], [type=checkbox]), form#catalog_form select, form#catalog_form textarea').each(function()
  {
    var key = $(this).attr('name');

    if ($.inArray($(this).val(), blankVals) > -1)
    {
      var val = '';
    }
    else
    {
      var val = $(this).val();
    }

    json[key] = val;
  });

  $('form#catalog_form input[type=checkbox]').each(function()
  {
    var key = $(this).attr('name');

    if ($(this).is(':checked'))
    {
      var val = $(this).val();
      json[key] = val;
    }
    
  });

  // alert(JSON.stringify(json)); // Debug

  $.ajax({
    type: 'POST',
    data: { json: json },
    url: '_php/save_catalog_changes.php',
    success: function(response)
    {
      console.log('ajax request succeeded');
      $('body').prepend(response); // Debug
    },
    error: function()
    {
      $(image_module).prepend('AJAX request error');
      alert('AJAX error: submission failed');
    },
    complete: function()
    {
      order_refreshImage(imageNum);
      view_image_record(imageNum);
      view_work_record(imageNum);
    }
  });

  return false;
}

function debounce(fn, delay) {
  var timer = null;
  return function()
  {
    var context = this
    var args = arguments;
    clearTimeout(timer);
    timer = setTimeout(function()
    {
      fn.apply(context, args);
    }, delay);
  }
}

function remove_work_assoc(orderNum, workNum, imageNum) {
  var json = {};
  json['workNum'] = workNum;
  json['imageNum'] = imageNum;

  $.ajax({
    type: 'GET',
    data: { json: json },
    url: '_php/workAssoc_remove.php',
    success: function(response)
    {
      console.log('work association removed');
      $('body').prepend(response);
    },
    error: function()
    {
      console.log('ajax request failed: remove_work_assoc')
    },
    complete: function()
    {
      if (orderNum != 'None') { open_order(orderNum); }
      view_image_record(imageNum);
      view_work_record(imageNum);
    }
  });
}

function delete_work_record(workNum) {
  $.ajax({
    type: 'POST',
    data: 'workNum='+workNum,
    url: '_php/delete_work_record.php',
    success: function(response)
    {
      $('body').prepend(response);
    },
    error: function()
    {
      console.log('AJAX error: delete_work_record');
    },
    complete: function()
    {
      $('#delWorRec_script').delay(1000).remove();
      view_orphaned_works();
    }
  });
}

function workAssoc_search(title, agent) {
  $('div#workAssoc_results').remove();
  var results_div = $('<div>', { id: 'workAssoc_results' });
  $('div#workAssoc_wrapper').after(results_div);

  title = $.trim(title);
  agent = $.trim(agent);

  console.log(title+' '+agent);

  $.ajax({
    type: 'POST',
    data: 'title='+title+'&agent='+agent,
    url: '_php/workAssoc_search.php',
    success: function(response)
    {
      $(results_div).append(response);
    },
    error: function()
    {
      console.log('ajax request failed: workAssoc_search');
    }
  });
}

function workAssoc_assoc(orderNum, workNum, imageNum) {
  var json = {};
  json['orderNum'] = $.trim(orderNum);
  json['workNum'] = $.trim(workNum);
  json['imageNum'] = $.trim(imageNum);

  $.ajax({
    type: 'GET',
    data: { json: json },
    url: '_php/workAssoc_assoc.php',
    success: function(response)
    {
      console.log('ASSOCIATED Work-'+workNum+' & Image-'+imageNum);
    },
    error: function()
    {
      console.log('ajax request failed: workAssoc_assoc');
    },
    complete: function()
    {
      open_order(orderNum);
      view_image_record(imageNum);
      view_work_record(imageNum);
    }
  });
}

function relatedWorkAssoc_search(title, agent, module) {
  
  $('div#workAssoc_results').remove();
  var results_div = $('<div>', { id: 'workAssoc_results' });
  $(+module+' div[id=workAssoc_wrapper]').after(results_div);

  title = $.trim(title);
  agent = $.trim(agent);

  console.log(title+' '+agent);

  $.ajax({
    type: 'POST',
    data: 'title='+title+'&agent='+agent,
    url: '_php/workAssoc_search.php',
    success: function(response)
    { 
      $(results_div).append(response);
    },
    error: function()
    {
      console.log('ajax request failed: workAssoc_search');
    }
  });
}

function relatedworkAssoc_assoc(orderNum, workNum, imageNum) {
  var json = {};
  json['orderNum'] = $.trim(orderNum);
  json['workNum'] = $.trim(workNum);
  json['imageNum'] = $.trim(imageNum);

  $.ajax({
    type: 'GET',
    data: { json: json },
    url: '_php/workAssoc_assoc.php',
    success: function(response)
    {
      console.log('ASSOCIATED Work-'+workNum+' & Image-'+imageNum);
    },
    error: function()
    {
      console.log('ajax request failed: workAssoc_assoc');
    },
    complete: function()
    {
      open_order(orderNum);
      view_image_record(imageNum);
      view_work_record(imageNum);
    }
  });
}

function authorityIndicators() {
  $('input[type=text].authoritySearch').each(function()
  {
    var termId = 
      $(this)
      .parents('div.catRowWrapper')
      .find('input[type=hidden]:not(.cat_display)')
      .val();

    if (termId != '')
    {
      $(this).removeClass('idMissing');
      $(this).addClass('idPresent');
    }
    
    if (termId == '')
    {
      $(this).removeClass('idPresent');
      $(this).addClass('idMissing');
    }
  });
}

function registerNewUser_load() {

  // Remove existing modules
  $('div[id$=_module]').remove();

  // Hide control panel
  $('div#control_panel_wide').hide();

  // Construct the module
  var $newUserModule = $('<div id="registerUser_module" class="module">');
  var $newUserHeader = $('<h1>').text("Register New User");
  $newUserModule.prepend($newUserHeader);
  $newUserModule.append('<div class="loading_gif">');

  // Insert the module into the DOM
  $('div#module_tier4 p.clear_module').before($newUserModule);

  // Add a close button the module's header
  closeModule_button($('div#registerUser_module'));

  $.ajax({
    type: 'GET',
    url: '_php/_user/registerNewUser_load.php',
    success: function(response) {
      load_module($newUserModule, response);
      $(document).scrollTop($('body').offset().top);
      console.log("AJAX success: registerNewUser_load.php");
    },
    error: function() {
      console.error("AJAX error: registerNewUser_load.php");
    }
  });
}

function createRepository() {
  var xmlhttp;
  if (window.XMLHttpRequest) { // Modern browsers
    xmlhttp = new XMLHttpRequest; 
  } else { // IE5 & IE6
    xmlhttp = new ActiveXObject('Microsoft.XMLHTTP');
  }

  $('div[id$=_module]')
    .not('div#browse_orders_module')
    .not('div#order_module')
    .not('div#work_module')
    .not('div#image_module')
    .remove();

  // Hide control panel
  $('div#control_panel_wide').hide();

  var createRep_module = 
    $('<div>', { id: 'createRepository_module', class: 'module' });
  var createRep_header = $('<h1>').text('New Repository');
  $(createRep_module).append(createRep_header);

  $('div#module_tier4 p.clear_module').before(createRep_module);

  xmlhttp.onreadystatechange = function()
  {
    if (xmlhttp.readyState == 1)
    {
      $(document).scrollTop($('body').offset().top);
      $(createRep_module).append('<div class="loading_gif">');
    }
    if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
    {
      $('div.loading_gif').remove();
      $(createRep_module).append(xmlhttp.responseText);
    }
  }

  xmlhttp.open('GET', '_php/create_repository_form.php', true);
    xmlhttp.send();
}

function createRepository_submit() {
  console.log('Submit function called');

  var data = {};

  $('form#createRepository_form input[type=text]').each(
    function()
    {
      var val = $(this).val();
      data[$(this).attr('name')] = val;
    });

  data['images'] = $('input[type=radio]:checked').val();

  $.each(['museum','country','city'], function(index, value)
    {
      if ($('input[name='+value+']').val() == '')
      {
        input_error($('input[name='+value+']'));
        msg(['Please supply required information'], 'error');
      }
    });

  if (
    $('input[name=museum]').val() == '' ||
    $('input[name=city]').val() == '' ||
    $('input[name=country]').val() == ''
    )
  {
    // Required fields are missing. Do nothing
  }
  else
  {
    $.ajax({
      type: 'POST',
      cache: false,
      data: { data: data },
      url: '_php/create_repository_script.php',
      success: function(response)
      {
        $('body').append(response);
        $('div#createRepository_module').remove();
        console.log('Repository submitted');
        // $('body').prepend(response); // Debug
      },
      error: function()
      {

      }
    });
  }
}

function createBuiltWork() {
  var xmlhttp;
  if (window.XMLHttpRequest) { // Modern browsers
    xmlhttp = new XMLHttpRequest; 
  } else { // IE5 & IE6
    xmlhttp = new ActiveXObject('Microsoft.XMLHTTP');
  }

  $('div[id$=_module]')
    .not('div#browse_orders_module')
    .not('div#order_module')
    .not('div#work_module')
    .not('div#image_module')
    .remove();

  // Hide control panel
  $('div#control_panel_wide').hide();

  var createBuiltWork_module = 
    $('<div>', { id: 'createBuiltWork_module', class: 'module' });
  var createBW_header = $('<h1>').text('New Work');
  $(createBuiltWork_module).append(createBW_header);

  $('div#module_tier4').prepend(createBuiltWork_module);

  xmlhttp.onreadystatechange = function()
  {
    if (xmlhttp.readyState == 1)
    {
      $(document).scrollTop($('body').offset().top);
      $(createBuiltWork_module).append('<div class="loading_gif">');
    }
    if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
    {
      $('div.loading_gif').remove();
      // $(createBuiltWork_module).append(xmlhttp.responseText);
      load_module(createBuiltWork_module, xmlhttp.responseText);
    }
  }

  xmlhttp.open('GET', '_php/create_work_form.php', true);
  xmlhttp.send();
}

function createBuiltWork_submit() {
  console.log('submit function called');
  var json = {};

  var blankVals = ['- Type -','- Measurement -','- Name type -','Title',"Agent role (e.g. 'artist; painter')", 'Agent','Date','Material','Technique','Work Type','Cultural Context','Style Period','Location','Description','State/Edition','Subject','Inscription text','Inscription author','Inscription location','Rights holder','Rights text','Source name','Source text'];

  $('div#createBuiltWork_module input:not([type=submit], [type=button], [type=checkbox]), div#createBuiltWork_module select, div#createBuiltWork_module textarea').each(function()
  {
    var key = $(this).attr('name');

    if ($.inArray($(this).val(), blankVals) > -1)
    {
      var val = '';
    }
    else
    {
      var val = $(this).val();
    }

    json[key] = val;
  });

  $('div#createBuiltWork_module input[type=checkbox]').each(function()
  {
    var key = $(this).attr('name');

    if ($(this).is(':checked'))
    {
      var val = $(this).val();
      json[key] = val;
    }
    
  });

  json['newWork'] = true;

  // alert(JSON.stringify(json)); // Debug

  $.ajax({
    type: 'POST',
    cache: false,
    data: { json: json },
    url: '_php/save_catalog_changes.php',
    success: function(response)
    {
      console.log('ajax request succeeded');
      $('div#createBuiltWork_module').remove();
      // $('body').prepend(response); // Debug
    },
    error: function(response)
    {
      $('input#createNewWork_submit').after('AJAX request error');
      $('body').prepend(response); // Debug
    }
  });
}

function createOrder_load_form() {

  // Remove existing modules
  $('div[id$=_module]').remove();

  // Hide control panel
  $('div#control_panel_wide').hide();

  var co_mod = $('<div id="createOrder_module" class="module">');
  var co_header = $('<h1>').text('New Order');
  $(co_mod).prepend(co_header);
  $(co_mod).append('<div class="loading_gif">');

  $('div#module_tier4 p.clear_module').before(co_mod);

  $.ajax({
    type: 'GET',
    url: '_php/_order/_create/load_form.php',
    success: function(response)
    {
      load_module(co_mod, response);
      $(document).scrollTop($('body').offset().top);

      console.log('AJAX request success: _php/_order/_create/load_form.php');
    },
    error: function()
    {
      $(co_mod).append('AJAX request error: _php/_order/_create/load_form.php');
    }
    });
}

function createOrder_continue() {
  var newOrder_data = {};
  var errors = [];
  var requiresCount = ['Corpus','Donor','Electronic','Vendor','Other'];

    // Validate text inputs
  $('form#createOrder_form input[type=text]').each(function () {
    var value = $.trim($(this).val());

    if (value == '') {

      var isImgCount = $(this).attr('name') === 'imageCount';
      var optRequiresCount = $.inArray($('select[name=sourceNameType] option:selected')
        .val(), requiresCount) >= 0

      if (!isImgCount) {
        input_error($(this));
        errors.push($(this).attr('name'));
      }

      if (isImgCount && optRequiresCount) {
        input_error($(this));
        errors.push($(this).attr('name'));
      }

    } else {
      newOrder_data[$(this).attr('name')] = value;
    }

  });

    // Validate select list inputs
  $('form#createOrder_form select').each(function() {
    var value = $(this).find('option:selected').val();

    if (value == '') {

      input_error($(this));
      errors.push($(this).attr('name'));
      
    } else {
      newOrder_data[$(this).attr('name')] = value;
    }

  });

  var legacyIds = $('form#createOrder_form input[name="legacyIds"]')[0].checked;
  newOrder_data['legacyIds'] = legacyIds;

  //console.log('form errors: '+errors); // Debugging

  if (errors.length === 0)
  {
    $('.input_error').removeClass('input_error');
    createOrder_load_pages(newOrder_data);
    $('span#createOrder_errors').text('');
    $('button#createOrder_continue_button').hide();
    $('form#createOrder_form').find('input[type=text], input[type=checkbox], select')
        .attr('disabled', true);
      $('button#createOrder_continue_button').unbind('click');
  }
  else
  {
    $('span#createOrder_errors').text(errors.length+' error');
    if (errors.length > 1) { $('span#createOrder_errors').append('s'); }
  }
}

function createOrder_newUser() {

  var typed = $('input[name="patron"]').val();
  console.log('User selected: "'+typed+'"');
  var userMatch = true;     
  
  $.each(user_a, (function (index, val)
  {
    console.log('Array contains: "'+val+'"');
    if ((typed) === (val)){

    //Continue to page and figure assignment and break
      
      userMatch = true; 
      createOrder_submit();
      return false;
    }

    else{
      console.log("no match")
      userMatch = false;
    }
  }));  
  
  if (userMatch == false) {

    // Construct the new user module
    var $newUserModule = $('<div id="registerUser_module" class="module_right">');
    var $newUserHeader = $('<h1>').text("Register New User");
    $newUserModule.prepend($newUserHeader);
    $newUserModule.append('<div class="loading_gif">')
    

    // Insert the module into the DOM
    $('div#module_tier4 p.clear_module').before($newUserModule);

    // Add a close button the module's header
    closeModule_button($('div#registerUser_module'));

    $.ajax({
    type: 'GET',
    url: '_php/_user/registerNewUser_load.php',
    success: function(response) {
      load_module($newUserModule, response);
      console.log("AJAX success: registerNewUser_load.php");
      $(document).scrollTop($('#registerNewUser_submit').offset().top);
      createOrder_newUser_fillForm();
      },
      error: function() {
        console.error("AJAX error: registerNewUser_load.php");
      }
      });

  }
  //Suggested user is selected after New User module has loaded
  $('div.suggestion_text').click (function()
  { 
    $('div#registerUser_module').remove()
  });

  //  User clicks "Back" to return to first step
  $('button#createOrder_back_button').click(
    function()
    {
      $('div#registerUser_module').remove()
      });
}

function createOrder_newUser_fillForm() 
{
//Fill the New User module        
  var emailVal = $('div#createOrder_module input[name=email]').val();
            
  var selectVal = $('div#createOrder_module select[name=department]').find('option:selected').val();
          
  $('div#registerUser_module input[name=email]').val(emailVal);

  $('div#registerUser_module select[name=department]').find('option:contains('+selectVal+')').attr('selected', true);         

  // console.log('form errors: ' + errors); // Debugging
}

function createOrder_load_pages(data) {
  
  $('div#createOrderFigs_module').remove();

  var cof_mod = $('<div id="createOrderFigs_module" class="module">');
  var cof_header = $('<h1>').text('New Order - Step 2');
  $(cof_mod).prepend(cof_header);
  $(cof_mod).append('<div class="loading_gif">');

  $('div#module_tier4 p.clear_module').before(cof_mod);

  $.ajax({
    type: 'POST',
    data: data,
    url: '_php/_order/_create/assign_pages.php',
    success: function(response)
    {
      load_module(cof_mod, response);
      $(document).scrollTop($('body').offset().top);

      console.log('AJAX request success: _php/_order/_create/assign_pages.php');
    },
    error: function()
    {
      $(cof_mod).append('AJAX request error: _php/_order/_create/assign_pages.php');
    }
  });
}

function createOrder_submit() {

  var newOrder_data = {};

  $('form#createOrder_form input[type=text]').each(function()
  // Perform on each TEXT INPUT and SELECT in the form
  {
    var value = $.trim($(this).val());
    newOrder_data[$(this).attr('name')] = value;
  });

  $('form#createOrder_form select').each(function()
  // Perform on each TEXT INPUT and SELECT in the form
  {
    var value = $(this).find('option:selected').val();
    newOrder_data[$(this).attr('name')] = value;
  });

  var legacyIds = $('#legacyIds:checked').length > 0;
  newOrder_data['legacyIds'] = legacyIds;

  var i = 1;
  
  $('form#createOrderFigs_form div.pageFig_row').each(function()
  {

    var image_data = {};

    if ($('#legacyIds:checked').length > 0) {
        
      newOrder_data['image'+i] = { 
      
        legacyId: $(this).find('input:eq(0)').val(),
        page: '', 
        fig: '',
        fileFormat: $(this).find('select').val()
      
      };

    console.log('image_data is'+image_data);  
    }

    else{
      
      newOrder_data['image'+i] = { 
        legacyId: '',
        page: $(this).find('input:eq(0)').val(), 
        fig: $(this).find('input:eq(1)').val(),
        fileFormat: '.jpg'
      };
    } 

    i++;

  });

  $('div#createOrder_module')
    .add('div#createOrderFigs_module')
    .remove();

  console.log('newOrder_data: '+JSON.stringify(newOrder_data));

  $.ajax({
    type: 'POST',
    data: newOrder_data,
    url: '_php/_order/_create/submit.php',
    success: function(response)
    {
      $('body').append(response);
      console.log('AJAX request success: _php/_order/_create/submit.php');
    },
    error: function()
    {
      console.log('AJAX request error: _php/_order/_create/submit.php');
    }
  });
r
}

function export_load() {

  $('div[id$=_module]').remove();

  // Hide control panel
  $('div#control_panel_wide').hide();

  var ef_mod = $('<div id="exportForm_module" class="module">');
  var ef_header = $('<h1>').text('Export Records');
  $(ef_mod).prepend(ef_header);
  $(ef_mod).append('<div class="loading_gif">');

  $('div#module_tier5 p.clear_module').before(ef_mod);

  $.ajax({
    type: 'GET',
    url: '_php/_export/export_load.php',
    success: function(response)
    {
      load_module(ef_mod, response);
      $(document).scrollTop($('body').offset().top);

      console.log('AJAX success: export_load.php');
    },
    error: function()
    {
      $(ef_mod).append('AJAX error: export_load.php');
    }
  });
}

function query_export(){
  
  data = {};
  errors = [];

  $('div#exportRange_form input[type=text]').each(function()
    {
      var value = $.trim($(this).val());

      if (value == '')
      {
        input_error($(this));
        errors.push($(this).attr('name'));
      }
      else{
        data[($(this).attr('name'))] = value;
      }
    }); 
  
  var first = data['firstExportRecord'];
  var last = data['lastExportRecord'];

  if (errors.length === 0){

  // Insert hidden module for script supporting query
    $('div#control_panel_wide').hide();
    var ef_mod = $('<div id="exportForm_module" class="module">');
    $('div#module_tier5 p.clear_module').before(ef_mod);
    $(ef_mod).hide();

    $.ajax({
      type: 'GET',
      url: '_php/_export/query_export_range.php',
      data: 'firstExportRecord='+first+'&lastExportRecord='+last,
      success: function(response)
      {
        $('button#exportCsv, button#exportCsv_allFlagged')
        .replaceWith('<span class="mediumWeight purple">&nbsp;&nbsp;Preparing csv</span>');

        load_module(ef_mod, response);
        console.log('AJAX success: query_export_range.php');
      },
      error: function()
      {
        console.log('AJAX error: query_export_range.php');
      } 
    });
  }
}

function export_range(first, last){

  console.log('export function called. validation in progress.');
  
  $('button#exportCsv, button#exportCsv_allFlagged')
      .replaceWith('<span class="mediumWeight purple">&nbsp;&nbsp;Preparing csv</span>');

  var type = 'range';
      
  window.location.href = '_php/_export/export_records.php?type='+type+'&first='+first+'&last='+last;  
}

function export_flagged() {
  
  console.log('export function called. validation in progress.');

  var type = 'flagged';
  console.log('valid export request - processing csv...');

  $('button#exportCsv, button#exportCsv_allFlagged').replaceWith('<span class="mediumWeight purple">&nbsp;&nbsp;Preparing csv</span>');

  // REVISIT
  window.location.href ='_php/_export/export_records.php?type='+type;
}

function lantern_search(text, gToggle, page) {

  if (text.length >= 3) { // Validate string length

    $('div[id$=_module]').remove();

    $('li#nav_lantern div.nav_dropdown').hide();

    var $module = $('<div id="lanternSearch_module" class="module double">');
    $module.append('<div class="loading_gif">')
      .prepend('<div id="filter_toggle">');

    $('div#module_tier2a').prepend($module);

    $(document).scrollTop($('body').offset().top);

    var toggle = gToggle == true ? 1 : 0;

    $.ajax({
      type: 'POST',
      data: 'text=' + text + '&toggle=' + toggle + '&page=' + page,
      url: '_php/_lantern/lantern_search.php',
      success: function (response) {
        $('script#lantern_list_script').remove();
        $('script#lantern_grid_script').remove();
        // load_module($module, response);
        $module.find('div.loading_gif').remove();
        $module.append(response);
      },
      error: function () {
        console.log('AJAX error: lantern_search');
      },
      complete: function () {
        $('#filter_toggle').append($('<span>View:</span>'));
        $('#filter_toggle').append($('<span id="go-list">List</span>'));
        $('#filter_toggle').append($('<span id="go-grid">Grid</span>'));

        // On click, switch to list view
        $('#go-list').unbind('click').click(function () {
          $('span[id^="go-"]').removeClass('current');
          $(this).addClass('current');
          lantern_list_view();
        });

        // On click, switch to grid view
        $('#go-grid').unbind('click').click(function () {
          $('span[id^="go-"]').removeClass('current');
          $(this).addClass('current');
          lantern_grid_view();
        });
      }
    });

  } else { // Search string too short
    msg(['Lantern searches must be at least three characters in length'], 'error');

  }
}

function lantern_wrap_imgRows() {

  $('div[id*=gridRow]').each(
    function()
    {
      $(this).replaceWith($(this).contents());
    });

  var outer_wrapper = $('div#lantern_results_list');
  var imgs = $('div#lantern_results_list div.gridThumb_wrapper');

  var imgSize = imgs.first().outerWidth(true);
  var w = outer_wrapper.width(),
    breakat = Math.floor(w/imgSize); // Number of imgs per row

  for (var i = 0; i <= imgs.length; i = i + breakat) {
    $(imgs)
      .slice(i, (i + breakat))
      .wrapAll('<div id="gridRow' + ((i/breakat) + 1) + '" class="gridRow">');
  }
}

function lantern_dropdown_load(dd, row, workNum, imageNum, legId) {

  $('div.grid_dropdown').addClass('doomed');
  var old_dd = $('div.grid_dropdown.doomed');
  var old_row_id = old_dd.prev('div.gridRow').attr('id');

  $.ajax({
    type: 'POST',
    data: 'workNum=' + workNum + '&imageNum=' + imageNum + '&legId=' + legId,
    url: '_php/_lantern/lantern_dropdown_load.php',
    success: function (response) {
      // Add new dropdown to the DOM
      $(dd).append(response)
        .hide()
        .insertAfter(row);
    },
    error: function () {
      console.log('AJAX error: lantern_dropdown_load');
    },
    complete: function () {
      // If clicked thumb is in the same row as the last
      if (old_row_id == row.attr('id')) {
        $(old_dd).remove();
        $(dd).delay(3).show();

      // Else clicked thumb is in a different row than the last
      } else {
        $(old_dd).slideUp(200, 
          function() {
            $(old_dd).remove();
          });
        $(dd).slideDown(200);
      }

      // Adjust offset for auto-scroll based on height of dropdown,
      // and whether new row is above or below old row
      if (old_row_id) {

        if (old_row_id.substr(old_row_id.length-1) < row.attr('id').substr(row.attr('id').length-1)) {
          dd_height = 350;

        } else {
          dd_height = 0;
        }

      } else {
        dd_height = 0;
      }

      // Move select row near the top of the window
      var header_height = $('div#header_wide').outerHeight() + $('div#control_panel_wide').outerHeight();
      $('html, body').animate({ scrollTop: row.offset().top-header_height-75-dd_height }, 400);
    }
  });
}

function lantern_grid_loadThumbBanner(thumb, banner, work, image) {
  console.log('hover over grid thumbnail - work:'+work+', image:'+image); // Debug

  $.ajax({
    type: 'POST',
    data: 'work='+work+'&image='+image,
    url: '_php/_lantern/lantern_grid_loadThumbBanner.php',
    success: function(response)
    {
      $('div.gridThumb_banner').remove();
      $(thumb).before(banner);
      $(banner).addClass('pointer').text(response);
    },
    error: function()
    {
      console.log('AJAX ERROR: lantern_grid_loadThumbBanner');
    }
  });
}

function lantern_list_view() {
  $('div#lantern_results_list').remove();
  $('script#lantern_search_script').remove();
  $('div#lanternSearch_module').append('<div class="loading_gif">');

  $.ajax({
    type: 'POST',
    data: 'pref_lantern_view=list&page=1',
    url: '_php/_lantern/lantern_search.php',
    success: function(response)
    {
      // load_module($('div#lanternSearch_module'), response);
      $('div#lanternSearch_module').find('div.loading_gif').remove();
      $('div#lanternSearch_module').append(response);
      console.log('AJAX success: lantern_list_view');
    },
    error: function()
    {
      $(body).prepend('AJAX error: lantern_list_view');
    }
  });

  $.ajax({
    type: 'POST',
    data: 'pref_lantern_view=list',
    url: '_php/_lantern/lantern_control_panel.php',
    success: function(response)
    {
      $('div#control_panel')
        .empty()
        .append(response);
    },
    error: function()
    {
      $(body).prepend('AJAX error: lantern_lcontrol_panel');
    }
  });
}

function lantern_grid_view() {
  $('div#lantern_results_list').remove();
  $('script#lantern_search_script').remove();
  $('div#lanternSearch_module').append('<div class="loading_gif">');

  $.ajax({
    type: 'POST',
    data: 'pref_lantern_view=grid&page=1',
    url: '_php/_lantern/lantern_search.php',
    success: function(response)
    {
      // load_module($('div#lanternSearch_module'), response);
      $('div#lanternSearch_module').find('div.loading_gif').remove();
      $('div#lanternSearch_module').append(response);
      console.log('AJAX success: lantern_grid_view');
    },
    error: function()
    {
      $(body).prepend('AJAX error: lantern_grid_view');
    }
  });

  $.ajax({
    type: 'POST',
    data: 'pref_lantern_view=grid',
    url: '_php/_lantern/lantern_control_panel.php',
    success: function(response)
    {
      $('div#control_panel')
        .empty()
        .append(response);
    },
    error: function()
    {
      $(body).prepend('AJAX error: lantern_lcontrol_panel');
    }
  });
}

function scroll_to_load($ele, view, nextPage) {
  // console.log('"scroll_to_load" fired. view: '+view+', nextPage: '+nextPage); // Debug

  $(window)
    .unbind('scroll.lantern')
    .bind('scroll.lantern', function()
      {
        // console.log($(window).scrollTop()+' + '+$(window).innerHeight()+' - '+$ele.offset().top+' >= '+$ele.innerHeight()); // Debug

        if ($(window).scrollTop() + $(window).innerHeight() - $ele.offset().top >= $ele.innerHeight())
        {
          $('script#lantern_list_script')
            .add('script#lantern_grid_script')
            .add('script#lantern_search_script')
            .remove();
          lantern_loadMore(view, nextPage);
          $(window).unbind('scroll.lantern');
        }
      });
}

function lantern_loadMore(view, nextPage) {
  // console.log('"lantern_loadMore" fired. view: '+view+', nextPage: '+nextPage);

  var $moreResults = $('<div style="height: 200px; position: relative;">');
  $moreResults.append('<div class="loading_gif">');
  $('div#lantern_results_list').append($moreResults);

  $.ajax({
    type: 'POST',
    data: 'pref_lantern_view='+view+'&nextPage='+nextPage,
    url: '_php/_lantern/lantern_search.php',
    success: function(response)
    {
      $('div.loading_gif').remove();
      $moreResults.append(response).replaceWith($moreResults.contents());
      console.log('AJAX success: lantern_loadMore');
    },
    error: function()
    {
      $(body).prepend('AJAX error: lantern_loadMore');
    }
  });
}

function lantern_download(imageNum) {

  // $.ajax({
  //  type: 'POST',
  //  data: 'imageNum='+imageNum,
  //  url: '_php/_lantern/lantern_download_image.php',
  //  success: function(response) {
  //    $('body').prepend(response);
  //  },
  //  error: msg(['Failed to load file:', 'lantern_download.php'], 'error')
  // });

  window.location.href = '/_php/_lantern/lantern_download_image.php?imageNum='+imageNum;
}

function view_orphaned_works() {
  $('div[id$=_module]').remove();

  var $module = $('<div id="viewOrphanedWorks_module" class="module double">');
  $($module).prepend('<h1>Unused Work Records</h1>');
  $($module).append('<div class="loading_gif">');

  $('div#module_tier4').prepend($module);
  $(document).scrollTop($('body').offset().top);

  $.ajax({
    type: 'POST',
    url: '_php/view_orphaned_works.php',
    success: function(response)
    {
      load_module($module, response);
    },
    error: function()
    {
      console.log('AJAX error: viewOrphanedWorks');
    }
  });
}

function view_orphaned_images() {
  $('div[id$=_module]').remove();

  var $module = $('<div id="viewOrphanedImages_module" class="module double">');
  $($module).prepend('<h1>Parentless Image Records</h1>');
  $($module).append('<div class="loading_gif">');

  $('div#module_tier4').prepend($module);
  $(document).scrollTop($('body').offset().top);

  $.ajax({
    type: 'POST',
    url: '_php/view_orphaned_images.php',
    success: function(response)
    {
      load_module($module, response);
    },
    error: function()
    {
      console.log('AJAX error: viewOrphanedImages');
    }
  });
}

function import_load() {

  $('div[id$=_module]').remove();

  // Hide control panel
  $('div#control_panel_wide').hide();

  var new_module = $('<div id="import_module" class="module double">');
  var new_header = $('<h1>').text('Import Records');
  $(new_module).prepend(new_header);
  $(new_module).append('<div class="loading_gif>');

  $('div#module_tier5 p.clear_module').before(new_module);

  $.ajax({
    type: 'GET',
    url: '_php/_import/import_load.php',
    success: function(response) {
      load_module(new_module, response);
      $(document).scrollTop($('body').offset().top);
      console.log("Successfully loaded file: import_load.php");
    },
    error: function() {
      console.error("Falied to load file: import_load.php");
    }
  });
}

function import_upload() {

  // In progress.
}

function createNewPopup(event) {
  var newPopup = document.createElement('div');
  newPopup.className += ' popup';
  newPopup.style.top = event.clientY+'px';
  newPopup.style.left = event.clientX+'px';
  newPopup.log(event.clientX+' '+event.clientY);
  newPopup.onmouseout = function(event) {
    this.setTimeout
  }
  return newPopup;
}