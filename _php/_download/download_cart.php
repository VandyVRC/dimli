<?php
$urlpatch = (strpos($_SERVER['DOCUMENT_ROOT'], 'xampp') == true)?'/dimli':'';
if(!defined('MAIN_DIR')){define('MAIN_DIR',$_SERVER['DOCUMENT_ROOT'].$urlpatch);}
require_once(MAIN_DIR.'/_php/_config/session.php');
require_once(MAIN_DIR.'/_php/_config/connection.php');
require_once(MAIN_DIR.'/_php/_config/functions.php');
require_once(MAIN_DIR.'/_plugins/pclzip/pclzip.lib.php');
confirm_logged_in();
require_priv('priv_orders_download');

// Temporarily increase PHP memory limit
ini_set('memory_limit', '1024M');

$images = explode(',', $_GET['images']);
$images = array_map('convertToFilepath', $images);
$downloadId = 001;

$filename = MAIN_DIR . '/temp/download_' . $downloadId . '.zip';
create_zip($images, $filename, true);


if (headers_sent()) {
  echo 'HTTP header already sent';

} else {
  if (!is_file($filename)) {
    header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
    echo 'File not found';

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
      unlink(MAIN_DIR.'/_php/_download/'.basename($image));
    }

    exit;
  }
}

/**
 * Create a zip archive of given files,
 * and return whether the resulting archive file exists or not
 */
function create_zip($files = array(), $destination = '', $overwrite = false) {

  // File already exists, and not overwriting
  if (file_exists($destination) && !$overwrite) {
    return false;
  }

  $valid_files = array();

  if (is_array($files)) {
    foreach ($files as $file) {
      if (file_exists($file)) {
        $valid_files[] = $file;
      }
    }
  }

  // Files are valid
  if (count($valid_files)) {
    // Create archive
    $zip = new ZipArchive();
    if ($zip->open($destination, $overwrite ? ZIPARCHIVE::OVERWRITE : ZIPARCHIVE::CREATE) !== true) {
      return false;
    }

    foreach($valid_files as $file) {
      $zip->addFile($file,$file);
    }

    // Debugging
    // echo 'The zip archive contains ', $zip->numFiles, ' files. Status of ', $zip->status;

    $zip->close();
    return file_exists($destination);

  } else {
    return false;

  }
}

/**
 * Converts an image filename into a filepath
 * to be passed in to create_zip()
 *
 * Used above with array_map()
 */
function convertToFilepath($value) {
  return MAIN_DIR . '/mdidimages/HoAC/full/' . $value . '.jpg';
}