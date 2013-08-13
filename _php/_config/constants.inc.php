<?php
/* 
DATABASE CONSTANTS
------------------
Define the specifics of your server environment */

define("DB_SERVER", "");
define("DB_USER", "");
define("DB_PASS", "");
define("DB_NAME", "");

/* 
DEFINE IMAGE FILEPATH
---------------------
Define the filepath for the directory that stores your JPG archive 
Examples:
	"../MyImageFiles/"
	"http://hosted.image.repository.edu/images/" */

define('IMAGE_DIR', '');

/* 
DEFINE ENCRYPTION SALT
----------------------
Define a salt parameter to pass into the crypt function
	Example: "gobly76gook13" */

define('SALT', '');

/*
OTHER CONSTANTS */
define('DIR', dirname(__DIR__).'/');