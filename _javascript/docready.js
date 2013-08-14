//
//	Defines events and functions to be run immediately on page load
//
$(document).ready(function()
{

	// HOVER NAV ITEM

	$('li.nav_item, li#nav_lantern').hover(
		function(event)
		{
			if ($(event.target).attr('class') != 'nav_dropdown')
			{
				event.stopPropagation();
				$(this).css({ color: '#BFBFE3' });
			}
		}, function(event)
		{
			event.stopPropagation();
			$(this).css({ color: '#E6E6FA' });
		})
	.children().hover(
		function()
		{
			return false;
		});


	// HOVER LANTERN NAV ITEM

	$('li#nav_lantern').hover(
		function(event)
		{
			event.stopPropagation();
			$(this).css({ cursor: 'pointer' });
		},
		function(event)
		{
			event.stopPropagation();
			$(this).css({ cursor: 'default' });
		})
	.children().hover(
		function()
		{
			return false;
		});

	
	// HOVER DROPDOWN LIST ITEM

	$('div.nav_dropdown_item').hover(
		function(event)
		{
			$(this).css({ backgroundColor: '#444466' });
			return false;
		}, function()
		{
			$(this).css({ backgroundColor: '#669' });
			return false;
		});

	
	// CLICK NAV ITEM

	$('li.nav_item').click(showThisDropdown).children().click(
		function(event)
		{
			return false;
			// Prevent children from triggering the event
		});


	// CLICK LANTERN NAV ITEM

	$('li#nav_lantern').bind('click.focus', 
		function(event)
		{
			event.stopPropagation();

			$('div.nav_dropdown').hide();

			var msgs = ['aim for','be after','beat the bushes','bird-dog','bob for','cast about','chase','comb','delve','delve for','dig for','dragnet','explore','fan','ferret out','fish','fish for','follow','go after','gun for','hunt','inquire','investigate','leave no stone unturned','look about','look around','look high and low','mouse','nose','prowl','pursue','quest','ransack','root','run after','scout','scratch','search for','search out','seek','sniff out','track down'];
			var msg = msgs[Math.floor(Math.random() * msgs.length)];

			$('input#lantern_search').attr('placeholder', msg);
			// Show random synonym as input placeholder

			$(this).find('div.nav_dropdown').show();

			$('input#lantern_search').select().focus();

			closeAllNavLists_prep();

		});

	$('li#nav_lantern div.nav_dropdown').click(
		function(event)
		{
			event.stopPropagation();
		});

	$('input#lantern_gettyToggle').click(
		function()
		{
			$('input#lantern_search').focus();
		});


	// SUBMIT LANTERN SEARCH

	function lanternSearch_submit(event)
	{
		var text = $('input#lantern_search').val();
		var gToggle = $('input#lantern_gettyToggle').prop('checked');
		console.log('lantern-search submitted');
		console.log('lantern-search string -- "'+text+'"');
		console.log('lantern-search authority toggle -- '+gToggle);
		lantern_search(text, gToggle, 1);
	}

	$('button#lantern_submit').click(lanternSearch_submit);
	$('input#lantern_search').keypress(
		function(event)
		{
			if (
				(event.which && event.which == 13) || 
				(event.keyCode && event.keyCode == 13)
				)
			{
				lanternSearch_submit();
			}
		});
			


	//---------------------------------------------
	//	Define events for navigation menu buttons
	//---------------------------------------------

	$('div#nav_browseUsers')
		.click(usersBrowse_load);

	$('div#nav_registerUser')
		.click(usersRegister_load);

	$('div#nav_export')
		.click(export_load);

	$('div#nav_findOrder')
		.click(function(){ findOrders_loadForm(1, 'date_needed', 'ASC'); });

	$('div#nav_createOrder')
		.click(function(){ createOrder_load_form(); });

	$('div#nav_createWork')
		.click(createBuiltWork);

	$('div#nav_createRepository')
		.click(createRepository);

	$('div#nav_viewOrphanedWorks')
		.click(view_orphaned_works);

	$('div#nav_viewOrphanedImages')
		.click(view_orphaned_images);

	//----------------------------
	//	Legacy Reader Navigation
	//----------------------------

	$(function() {
		$('form[id=legacyReader-form] input').keypress(function(e) {
			if ((e.which && e.which == 13) || (e.keyCode && e.keyCode == 13))
			{
				$(this).parents('form')
					.find('input[id=legacyReader-jumpToRecord]')
					.click();

				return false;
			}
			else
			{
				return true;
			}
		});
	});
});