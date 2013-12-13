<?php
$urlpatch = (strpos($_SERVER['DOCUMENT_ROOT'], 'xampp') == true)?'/dimli':'';
if(!defined('MAIN_DIR')){define('MAIN_DIR',$_SERVER['DOCUMENT_ROOT'].$urlpatch);}
require_once(MAIN_DIR.'/_php/_config/session.php');
require_once(MAIN_DIR.'/_php/_config/connection.php');
require_once(MAIN_DIR.'/_php/_config/functions.php'); ?>

<!-- jQuery JS and CSS -->
<link href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" rel="stylesheet" type="text/css">
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>

<script src="_plugins/JavaScript-Load-Image-master/js/load-image.min.js"></script>

<style>

	html {
		background-color: #000;
	}

	body {
		margin: 0;
		padding: 0;
		overflow: hidden;
	}

</style>

<div id="slideshow_wrap"></div>

<script>

var urlBase = 'http://.library.vanderbilt.edu/mdidimages/HoAC/';
var portY = window.innerHeight;
var portX = window.innerWidth;
var wrapper = document.getElementById('slideshow_wrap');

function UrlExists(url) {
	var http = new XMLHttpRequest();
	http.open('HEAD', url, false);
	http.send();
	return http.status != 404;
}

function queueSlide(hopperArray) {

	if (hopperArray.length < 10) {
		imgNum = Math.floor((Math.random() * 80000) + 1).toString();
		while (imgNum.length < 6) {
			imgNum = '0' + imgNum;
		}
		if (UrlExists(urlBase+'thumb/'+imgNum+'.jpg') === true) {
			hopperArray.push(imgNum);
			console.log("Added "+imgNum+" to the hopper: "+hopperArray);
		} else {
			console.log("Image "+imgNum+" does not exist");
		}
		return hopperArray;
	} else {
		console.log("Hopper is full");
	}
}

function nextSlidePlease(hopperArray) {

	if (hopperArray.length > 0) {

		try {
			$('img.slide_image').remove();
		} catch (error) {
			console.log("No existing image to be removed");
		}

		var nextImgNum = hopperArray.splice(0, 1);
		var imageFilepath = urlBase+'full/'+nextImgNum+'.jpg';

		loadImage(
			imageFilepath,
			function(img) {
				img.setAttribute('class', 'slide_image');
				wrapper.appendChild(img);
				wrapper.style.marginTop = ((portY / 2) - (img.height / 2)) + 'px';
				wrapper.style.marginLeft = ((portX / 2) - (img.width / 2)) + 'px';
				console.log("Now displaying "+imageFilepath);
			},
			{ maxWidth: portX * 1.0, maxHeight: portY * 1.0 }
		);
	}
}

window.onload = function() {

	var hopperArray = [];

	var slideQueueHandle = window.setInterval(function() {
		// Each cycle, attempt to add a slide to the hopper

		queueSlide(hopperArray);

	}, 2000);

	var slideAdvanceHandle = window.setInterval(function() {
		// Each cycle, display the next available slide in the hopper

		nextSlidePlease(hopperArray);

	}, 12000);

}

</script>