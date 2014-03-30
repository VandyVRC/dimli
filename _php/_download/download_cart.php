<?php
if(!defined('MAIN_DIR')){define('MAIN_DIR',dirname('__FILENAME__'));}
require_once(MAIN_DIR.'/../../_php/_config/session.php');
require_once(MAIN_DIR.'/../../_php/_config/connection.php');
require_once(MAIN_DIR.'/../../_php/_config/functions.php');
require_once(MAIN_DIR.'/../../_plugins/pclzip/pclzip.lib.php');
confirm_logged_in();
require_priv('priv_orders_download');

// Temporarily increase PHP memory limit
ini_set('memory_limit', '1024M');

// If download is triggered from the cart, save a record.
// If download is triggered from the welcome page, don't save a record.
$saveDownload = $_GET['new'] === 'true';

// Construct an array of filepaths to be added to the zip archive
$images = explode(',', $_GET['images']);
$files = array(); 
chdir(MAIN_DIR.'/../../temp');

if (preg_match('/http:/i', $image_dir)){    
  foreach ($images as $image){
    $url = IMAGE_DIR.'full/'.$image.'.jpg';
    $ch = curl_init();
    $fh = fopen($image.".jpg", 'wb');
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_FILE, $fh);
    $result = curl_exec($ch);
    fclose($fh);
    curl_close($ch); 
    $file = $image.'.jpg'; 
    $files[] = $file;
  }  
}
else {
 foreach ($images as $image){ 
  $file = IMAGE_DIR.'full/'.$image.'.jpg'; 
  $files[] = $file; 
  }
}

// Create the zip archive file
$filename = 'download_' . $_SESSION['user_id'] . Time() . '.zip';
$result = create_zip($files, $filename);

// If the zip file was successfully created,
// write the download to the database
if ($result && $saveDownload) {

  $time = Time();
  $sql = "INSERT INTO $DB_NAME.download
          SET user_id = '{$_SESSION['user_id']}',
              images = '{$_GET['images']}',
              UnixTime = '{$time}'
          ";
  $result = db_query($mysqli, $sql);

}

if (headers_sent()) {
  echo 'HTTP header already sent';

} else {
  if (!is_file($filename)) {
    header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
    echo 'File not found: ' . $filename;

  } elseif (!is_readable($filename)) {
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Forbidden');
    echo 'File not readable';

  } else {
    // Download the archive of images
    header($_SERVER['SERVER_PROTOCOL'].' 200 OK');
    header("Content-Type: application/zip");
    header("Content-Transfer-Encoding: Binary");
    header("Content-Length: ".filesize($filename));
    header("Content-Disposition: attachment; filename=\"".basename($filename)."\"");
    ob_clean();
    flush();
    readfile($filename);
    ini_set('memory_limit', '128M');

    foreach ($images as $image) {
      unlink(MAIN_DIR.'/../../_php/_download/'.basename($image));
    }

    foreach ($files as $file) {
      unlink($file);
    }

    exit;
  }
}

/**
 * Creates a zip archive of a given array of filepaths
 * @param {Array}  $files       - the filepaths to be included in the archive
 * @param {String} $destination - the filepath destination of the resulting archive
 */
function create_zip($files = array(), $destination ='') {

  // Create zip acrhive
  $archive = new PclZip($destination);
  $v_list = $archive->create($files, PCLZIP_OPT_REMOVE_ALL_PATH);

  // Error handling (supplied by pclzip documentation)
  if (($v_result_list = $archive->extract()) == 0) {
    die("Error : ".$archive->errorInfo(true));
  }

  return $archive;
}



