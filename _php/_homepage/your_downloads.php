<?php 
$urlpatch = (strpos($_SERVER['DOCUMENT_ROOT'], 'xampp') == true)?'/dimli':'';
if(!defined('MAIN_DIR')){define('MAIN_DIR',$_SERVER['DOCUMENT_ROOT'].$urlpatch);}
require_once(MAIN_DIR.'/_php/_config/session.php');
require_once(MAIN_DIR.'/_php/_config/connection.php');
require_once(MAIN_DIR.'/_php/_config/functions.php');
confirm_logged_in();

// Path for thumbnail images
$thumb_path = 'http://dimli.library.vanderbilt.edu/_plugins/timthumb/timthumb.php?src=mdidimages/HoAC/thumb/';

// Grab download history for the current user
$sql = "SELECT * 
        FROM $DB_NAME.download 
        WHERE user_id = '{$_SESSION['user_id']}' ";
$downloads = db_query($mysqli, $sql);

/**
 * Generates thumbnail html for each filename in {$images}
 */
function generate_thumbnails($images, $path) {
for ($i = 0; $i < count($images); $i++) { 
  if ($i > 4) continue; // Display maximum 5 thumbnails ?>
  <img src="<?php echo $path . $images[$i]; ?>.jpg&amp;h=28&amp;w=35&amp;q=80">
<?php }
}
?>

<div id="yourDownloads">
  <h3>Your Downloads</h3>
  <div id="orderDelivery_list" class="defaultCursor">

    <?php
    // Current user has not downloaded any archives
    if ($downloads->num_rows <= 0) {
    ?>

      <div class="row message">
        <span>You have not yet downloaded any images</span>
      </div>

    <?php
    } else {

      while ($row = $downloads->fetch_assoc()) {
      $images = explode(',', $row['Images']);
      $count = count($images);
      ?>

        <div class="row">
          <div class="floatLeft inner_row thumbnail_previews">
            <?php generate_thumbnails($images, $thumb_path); ?>
            <span class="grey eightEm"><?php
              echo $count . ' '; ?>image<?php echo $count > 1 ? 's' : '';
            ?></span>
          </div>
          <div class="download_options floatRight">
            <a href="_php/_download/download_cart.php?new=false&amp;images=<?php echo implode(',', $images); ?>">
              <img src="_assets/_images/zip.png">
              <span class="label">Full ZIP</span>
            </a>
          </div>
          <p class="clear"></p>
          <div class="grey eightEm"><?php
            echo ' ' . date('l, F j \a\t g:i a', $row['UnixTime']);
          ?></div>
        </div>

      <?php
      }
    }
    ?>

  </div>

  <script id="yourDownloads_script"></script>

</div> 
