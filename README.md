DIMLI
=====

Digital Media Management Library

Created by Matthew Isner

Project Description
-------------------

A web-based application for the cataloging of cultural objects, developed specifically for use by Visual Resources professionals, which manages workflow and facilitates a singularly rich cataloging experience and powerful data exports.

DIMLI is currently used by the Visual Resources Center and the Department of History of Art at Vanderbilt University to process and deliver new digitization orders, and also to perform a recataloging of thousands of old image records in order to conform with the Visual Resources Association's Core 4 standards for the cataloging of cultural objects.

DIMLI has facilitated our massive recataloging endeavor by allowing us to establish Work and Image record relationships where before we had none, and by introducing an order management system that enables us to more easily assign and track workflow tasks.

To-Do List
----------

##### "Must-Have" Features:

+ Data imports

##### "Would Be Nice" Features:

+ Printer-friendly Order paper-trail

+ Activity statistics for Administrators

+ Ability to download images from Lantern serach results

Installation Instructions
-------------------------

Theoretically, DIMLI can be installed on your server environment as is. In order to do so, however, you will need to take a couple of important steps:

#### Define Unique Constants

1) Create a new file, named and located according to the following filepath:

    _php/_config/constants.inc.php

2) Insert the following contents into constants.inc.php:

    <?php
    /* 
    DATABASE CONSTANTS
    ------------------
    Define the specifics of your server environment */

    define('DB_SERVER', '<your.server.url.here>');
    define('DB_USER', '<yourDatabaseUsername>');
    define('DB_PASS', '<yourDatabasePassword>');
    define('DB_NAME', '<yourDatabaseName>');

    /* 
    DEFINE IMAGE FILEPATH
    ---------------------
    Define the filepath for the directory that stores your JPG archive 
    Examples:
       "../MyImageFiles/"
       "http://hosted.image.repository.edu/images/" */

    define('IMAGE_DIR', '<filepathOfYourImageDirectory>');
    
    /*
    DEFINE ENCRYPTION SALT
    ----------------------
    Define a salt parameter to pass into the crypt function
    Example: "gobly76gook13" */

    define('SALT', '<saltStringOfYourChoice>');
    
    /*
    OTHER CONSTANTS
    ---------------

    define('DIR', dirname(__DIR__).'/');

3) Replace each of the sections in the above code that are wrapped in "<" and ">" with the appropriate values for your server environment.

4) Save and allow _php/_config/constants.inc.php to remain at its current directory location. It will be required by several files in the application at large.

#### Prepare Image Directory

Whichever directory you chose to be your main image repository should be divided into three folders named as follows: full/, medium/ and thumb/. The size of the JPG files placed in the 'thumb/' directory should be exactly 96 pixels wide x 72 pixels high at 72 ppi. You may choose the dimensions for the 'medium/' and 'full/' JPG files as you wish. DIMLI will look in these directory locations for image files used throughout the application.

#### Making PowerPoints Available to End-Users

As you complete/deliver orders, manually add a PowerPoint file for each order to the _ppts folder. Each PowerPoint file should be named with a four-digit number matching the order number (e.g., 2363.pptx). This file will then be available for end-users to download when they visit their homepage.

More Information
----------------

The [YouTube channel] [1] for this project contains a short [introductory video] [2] as well as several feature highlights that delve deeper into individual aspects of the application.

[1]: http://www.youtube.com/channel/UCNavkQ4OuUO2idBjNfaq2zg
[2]: http://www.youtube.com/watch?v=k34agI23-jg
