<!doctype html>
<html>

<head>

<?php
if(!defined('MAIN_DIR')){define('MAIN_DIR',dirname('__FILENAME__'));}

header('Content-type: text/html; charset=utf-8'); ?>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8">


  <title><?php echo $site_title; ?></title>

<!-- Roboto font -->
<link href='http://fonts.googleapis.com/css?family=Roboto:400,300' 
  rel='stylesheet' type='text/css'>

<!-- Favicon -->
<link href="_assets/_images/favicon.png" rel="icon" type="image/png">

<!-- Stylesheets -->
<link href="_stylesheets/hobblet.css" rel="stylesheet" type="text/css">

<!-- jQuery -->
<link href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" rel="stylesheet" type="text/css">
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js"></script>

<!-- Load UI-feedback functions for immediate use -->
<script src="_javascript/ui_feedback.js"></script>

</head>

<body>

<div id="header_wide">

  <div id="header">

    <ul id="nav_list">

      <a href="index.php">

        <li class="nav_item"><?php echo $site_title; ?></li>
        
      </a>

 <?php 
 if (logged_in() && strpos($_SERVER['REQUEST_URI'], 'import') === false) 
 { 
      
      if ($_SESSION['priv_users_read']=='1') { ?>

      <!-- 
        ADMIN
       -->

      <li class="nav_item">admin
        <span class="arrow">&nbsp;&#9660;</span>

        <div class="nav_dropdown">

          <?php if ($_SESSION['priv_users_read']=='1') { ?>

          <div id="nav_browseUsers"
            class="nav_dropdown_item">browse<br>users</div>

          <?php } ?>

          <?php if ($_SESSION['priv_users_create']=='1') { ?>

          <div id="nav_registerUser"
            class="nav_dropdown_item">register<br>user</div>

          <?php } ?>

        </div>

      </li>

      <?php } ?>

      <?php if ($_SESSION['pref_user_type'] === 'cataloger') { ?>

      <!-- 
        CURATE
       -->

      <li class="nav_item">curate
        <span class="arrow">&nbsp;&#9660;</span>

        <div class="nav_dropdown">

          <?php if ($_SESSION['priv_approve']=='1') { ?>

          <!-- <div class="nav_dropdown_item faded grey">approve<br>cataloging</div> -->

          <?php } ?>

          <?php if ($_SESSION['priv_csv_export']=='1') { ?>

          <div id="nav_export"
            class="nav_dropdown_item">export<br>records</div>

          <?php } ?>

          <?php if ($_SESSION['priv_catalog']=='1') { ?>

          <div id="nav_viewOrphanedWorks" 
            class="nav_dropdown_item">unused<br>works</div>

          <?php } ?>

          <?php if ($_SESSION['priv_catalog']=='1') { ?>

          <div id="nav_viewOrphanedImages" 
            class="nav_dropdown_item">parentless<br>images</div>

          <?php } ?>

          <?php if ($_SESSION['priv_csv_import']=='1') { ?>

          <div id="nav_import"
            class="nav_dropdown_item">import<br>records</div>

          <?php } ?>

        </div>

      </li>

      <?php } ?>

      <?php if ($_SESSION['priv_orders_read']=='1' || $_SESSION['priv_orders_create']=='1') { ?>

      <!-- 
        ORDERS
       -->

      <li class="nav_item">orders
        <span class="arrow">&nbsp;&#9660;</span>

        <div class="nav_dropdown">

          <?php if ($_SESSION['priv_orders_read']=='1') { ?>

          <div id="nav_findOrder" 
            class="nav_dropdown_item">view<br>orders</div>

          <?php } ?>

          <?php if ($_SESSION['priv_orders_create']=='1') { ?>

          <div id="nav_createOrder"
            class="nav_dropdown_item">create<br>order</div>

          <?php } ?>

        </div>

      </li>

      <?php } ?>

      <?php if ($_SESSION['priv_catalog']=='1') { ?>

      <!-- 
        CATALOG
       -->

      <li class="nav_item">build
        <span class="arrow">&nbsp;&#9660;</span>

        <div class="nav_dropdown">

          <?php if ($_SESSION['priv_catalog']=='1') { ?>

          <div id="nav_createRepository" 
            class="nav_dropdown_item">create<br>repository</div>

          <?php } ?>

          <?php if ($_SESSION['priv_catalog']=='1') { ?>

          <div id="nav_createWork" 
            class="nav_dropdown_item">create<br>work</div>

          <?php } ?>

        </div>

      </li>

      <?php } ?>

      <!-- 
        LANTERN
       -->

      <li id="nav_lantern">lantern
        
        <div class="nav_dropdown defaultPointer"
          style="margin-left: -100px; padding: 15px;">

          <input type="search"
            id="lantern_search"
            placeholder="" autofocus
            style="margin: 0;"
            value="">

          <div style="margin: 20px 0 8px 0; font-size: 0.75em; color: #E6E6FA; position: relative;"
            title="Feature not yet available">

            <input type="checkbox"
              id="lantern_gettyToggle"
              style="margin: 0; vertical-align: bottom;"
              disabled class="fadedMore">

            <span class="fadedMore" style="font-size: 1.0em;">Extra kerosene! (takes much longer)</span>

            <button type="button"
              style="position: absolute; right: 0; margin: 0; padding: 2px 25px; margin-top: -7px; border-radius: 3px; font-size: 1.3em; font-weight: 400;"
              id="lantern_submit"
              name="lantern_submit">Go</button>

          </div>

        </div>

      </li>

      
      <!--
        BATCH DOWNLOAD
       -->

      <li id ="nav_cart" class="nav_item">cart
        <div class="nav_dropdown">
          <div id="cart">
            <h2>Your cart is empty</h2>
            <div class="basket">
            <input type='hidden' id="basket" 
            value ="<?php echo $_SESSION['cart']?>">
            </div>
            <div class="footer">
              <span class="selected hidden">Remove selected</span>
              <span class="all hidden">Empty cart</span>
              <p class="clear"></p>
              <div class="download hidden">
                <a href="">download zip archive</a>
              </div>
            </div>
          </div>
        </div>
      </li>     
      <script>
      
      var downloadCartLink = document.querySelector('#cart div.download a');
      downloadCartLink.addEventListener('click', function () {
        window.location = downloadCartLink.href;
      });

      </script>


  <?php 
  }
   // If logged in ?>

    </ul>

    <ul id="header_userInfo">

      <li>
        
        <?php if (logged_in()) { ?>

          <a href="logout.php">log out</a>

        <?php } else { ?>

          <a href="login.php">log in</a>

        <?php } ?>

      </li>

      <li class="defaultCursor">

        <?php if (logged_in() == true) {

          echo $_SESSION['display_name'];

        } ?>
      </li>

    </ul>

  </div> <!-- header -->

</div> <!-- header_wide -->

<div id="header_spacer"></div>

<!-- <div id="control_panel_wide"> 
<div id="control_panel"> 
    // if (logged_in()) {

      // TEMP Reactivate if we want to use the lantern-search filters
      // include('_php/_lantern/lantern_control_panel.php');

    // }
  </div>
</div> -->

<div id="body_wide">

  <div id="body">
