DIMLI
=====

Digital Media Management Library

Created by Matthew Isner, Vanderbilt University

Project Description
-------------------

A web-based application for the cataloging of cultural objects, developed specifically for use by Visual Resources professionals, which manages workflow and facilitates a singularly rich cataloging experience and powerful data exports.

DIMLI is currently used by the Visual Resources Center and the Department of History of Art at Vanderbilt University to process and deliver new digitization orders, and also to perform a recataloging of thousands of old image records in order to conform with the Visual Resources Association's Core 4 standards for the cataloging of cultural objects.

DIMLI has facilitated our massive recataloging endeavor by allowing us to establish Work and Image record relationships where before we had none, and by introducing an order management system that enables us to more easily assign and track workflow tasks.

To-Do List
----------

The following features need to be completed in order for DIMLI to function as intended:

#### User regristration
This must currently be done using SQL commands or a GUI for MySQL such as phpMyAdmin. New users should also be prompted to supply an email address that can in turn be used to auto-fill the email field during order creation. This email address would be integral to the creation of an automated email notification system that would alert users when orders have been completed.

#### Data imports

#### Printer-friendly Order paper-trail

#### Activity statistics for Administrators

#### Ability to download images from Lantern serach results

Installation Instructions
-------------------------

Theoretically, DIMLI can be installed on your server environment as is. In order to do so, however, you will need to take a couple of important steps:

+ Modify the _php/_config/constants.inc.php file to define the constants that are appropriate for your server/file-storage environment. The file itself contains some brief commented instructions for each constant that must be defined.

+ Whichever directory you chose to be your main image repository should be divided into three folders named as follows: "full/, medium/ and thumb/".

+ As you complete/deliver orders, manually add a PowerPoint file for each order to the _ppts folder, which should be named with a four-digit number matching the order number (e.g., 2363.pptx). This file will then be available for end-users to download when they visit their homepage.

For More Information
--------------------

The [YouTube channel] [1] for this project contains a short [introductory video] [2] as well as several feature highlights that delve deeper into individual aspects of the application.

[1]: http://www.youtube.com/channel/UCNavkQ4OuUO2idBjNfaq2zg
[2]: http://www.youtube.com/watch?v=k34agI23-jg
