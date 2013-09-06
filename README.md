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

#### "Must-Have" Features:

+ Data imports

#### "Would Be Nice" Features:

+ Printer-friendly Order paper-trail

+ Activity statistics for Administrators

Installation Instructions
-------------------------

In order to install DIMLI, you will need a server running MySQL on which to create a database, and a server running PHP on which to host the application itself. These two functions can, of course, be fulfilled by the same server, though local practices might dictate a seperation of these aspects of the system.

#### Import Database Schema

DIMLI's database schema is provided by the following dump file, which is included in this repository:

    _sql/dimli_schema.sql

Use a command line prompt (or graphical user interface for the administration of SQL databases, such as phpMyAdmin) to create a new SQL database on your server. I suggest calling the database "dimli", but you may call the database whatever you wish. Then import/run the schema file to create the many tables that comprise DIMLI's relational structure.

All data created by, and imported into, DIMLI will reside within these tables and the within the SQL database you just created.

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

Export CSV Fields Explained
---------------------------

When using DIMLI's Export feature, a user will generate a CSV file that consists of twenty-seven individual fields which descibe each image record. These fields are explained below.

The CSV's schema was developed in order to remain consistent with an existing installation of Madison Digital Image Database (MDID) at Vanderbilt University and adopts the field names which correspond with those which were used for past imports into that system (a new installation of DIMLI could rename these fields by modifying _php/_export/export_records.php lines 1183-1209 to reflect the field names you would prefer to use). The names of the fields are relatively unimportant provided that the Digital Asset Management (DAM) system into which you are importing the cataloging data allows you to manually map each of the fields in DIMLI's export CSV to the appropriate location in the DAM.

    Identifier

The six-digit record id number associated with this particular image record.

    resource

Same as identifier, but with ".jpg" appended to the six-digit record id. This field can be used to instruct the Digital Asset Manager where to find image files.

    vra.title

A semi-colon-seperated list of titles. This is a comprehenisve list of the titles of the work record which is related to the image at hand.

    vra.imagetitle

A semi-colon-seperated list of titles. This is a comprehenisve list of the titles of the image record itself.

    vra.agent

A semi-colon-seperated list of agent names. Each agent name is formatted 'Lastname, Firstname' and followed by a parenthetical comma-seperated list of roles which this particular agent filled in the making of this image, or its related work record. No distinction is made between image-record agents and work-record agents - they are simply strung together.

    agentALT

A semi-colon-seperated list of agent names. These are drawn from the Getty Union List of Artist Names and represent every documented alternative spelling of the agent names found in the 'vra.agent' field above.

    vra.date

A semi-colon-seperated list of dates. Rough dates begin with 'ca.' and the start and end dates of time spans are seperated by a hyphen. Each date is followed by a parethetical type description, denoting the event that the preceeding date describes.

     

More Information
----------------

The [YouTube channel] [1] for this project contains a short [introductory video] [2] as well as several feature highlights that delve deeper into individual aspects of the application.

[1]: http://www.youtube.com/channel/UCNavkQ4OuUO2idBjNfaq2zg
[2]: http://www.youtube.com/watch?v=k34agI23-jg
