function msg(msg_arr, type)
{
	var msg_str = '';

	// Use the msg_arr parameter to build the message string and console message
	$.each(msg_arr, function(index, value) {
		console.info('user message: "'+value+'"');
		msg_str += value+'<br>';
	});

	// Give the message its style and content
	$('div#message_text').attr('class','').addClass(type).html(msg_str);

	// Show the message, and bind an event to hide it if the user clicks it
	$('div#message_wrapper').fadeIn(400).click(function() {
		$(this).hide();
	});

	// Bind handle to hide message after a delay
	var msgTimeoutHandle = window.setTimeout(function() {
		$('div#message_wrapper').fadeOut(400);
		window.clearTimeout(msgTimeoutHandle);
	}, 3200);
}

function input_error(input)
{
	var defaultBorder = $(input).css('borderColor');
	var defaultBg = $(input).css('backgroundColor');

	$(input).addClass('input_error');

	function reset_field(input)
	{
		$(input).removeClass('input_error');
		$(input).unbind('focus', reset_field);
	}

	$(input).focus(function()
	{
		reset_field($(input));
	});
}