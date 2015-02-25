<?php
/* 

DATABASE CONSTANTS
------------------
Define the specifics of your server environment */

define("DB_SERVER", "localhost");
define("DB_USER", "root");
define("DB_PASS", "");
define("DB_NAME", "dimli");

$DB_NAME = DB_NAME;

/* 
DEFINE IMAGE FILEPATH
---------------------
Define the filepath for the directory that stores your JPG archive 
Examples:
	"../MyImageFiles/"
	"http://hosted.image.repository.edu/images/" */

define("IMAGE_DIR", "http://dimli.library.vanderbilt.edu/mdidimages/HoAC/full/");
$image_dir = IMAGE_DIR;

define("IMAGE_SRC', 'http://dimli.library.vanderbilt.edu/mdidimages/HoAC/thumb/");
$image_src = IMAGE_SRC;

/* 
DEFINE ENCRYPTION SALT
----------------------
Define a salt parameter to pass into the crypt function
	Example: "gobly76gook13" */

define("SALT", "316fish");

/*
OTHER CONSTANTS */
define("DIR", dirname(__DIR__)."/");



define('webroot','http://129.59.153.15/dimli');
$webroot = webroot;

define('site_title', 'dimli');
$site_title = site_title;
?>