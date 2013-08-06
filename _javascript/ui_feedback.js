function msg(msg_arr, type)
{
	var msg_str = '';
	$.each(msg_arr, function(index, value)
		{
			console.log('displayed message -- "'+value+'"');
			msg_str += value+'<br>';
		});

	$('div#message_text')
		.attr('class','')
		.addClass(type)
		.html(msg_str);

	$('div#message_wrapper').fadeIn(400)
		.click(
			function()
			{
				$(this).hide();
			});

	setTimeout(
		function()
		{
			$('div#message_wrapper').fadeOut(400);
		},
		3200);
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