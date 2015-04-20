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

define("IMAGE_DIR", "http://yourdomain.org/dimli/images/");
$image_dir = IMAGE_DIR;

define('IMAGE_SRC', 'images/');
$image_src = IMAGE_SRC;

/* 
DEFINE ENCRYPTION SALT
----------------------
Define a salt parameter to pass into the crypt function
	Example: "gobly76gook13" */

define("SALT", "19ReXiNSuLaRuM23");

/*
OTHER CONSTANTS */
define("DIR", dirname(__DIR__)."/");



define('webroot','http://yourdomain.org');
$webroot = webroot;

define('site_title', 'dimli');
$site_title = site_title;