<?php
if(!defined('MAIN_DIR')){define('MAIN_DIR',dirname('__FILENAME__'));}
require_once(MAIN_DIR.'/../../_php/_config/session.php');
require_once(MAIN_DIR.'/../../_php/_config/connection.php');
require_once(MAIN_DIR.'/../../_php/_config/functions.php');

require_once(MAIN_DIR.'/../../_plugins/pclzip/pclzip.lib.php');
confirm_logged_in();
require_priv('priv_orders_download');

if (isset($_GET['order']) && isset($_GET['size'])) {

    $order = $_GET['order'];
    $size = $_GET['size'];

    // Initialize an array to hold image numbers
    $imagesToArchive = array();

    // Build query to find image ids associated with the current order number
    $sql = "SELECT * 
            FROM $DB_NAME.image 
            WHERE order_id = {$order} ";

    $result = db_query($mysqli, $sql);

    while ($row = $result->fetch_assoc()):
    
        // Build array of filepaths/names for images to archive
        $imagesToArchive[] = $webroot.$image_src.$size.'/'.create_six_digits($row['legacy_id']).'.jpg';

    endwhile;

    // Temporarily increase PHP memory limit
    ini_set('memory_limit', '1024M');

    // Define filepath/name of archive file
    $file = MAIN_DIR.'/temp/'.$order.'.zip';

    // Create zip acrhive
    $archive = new PclZip($file);
    $v_list = $archive->create($imagesToArchive, PCLZIP_OPT_REMOVE_ALL_PATH);

    // Error handling (supplied by pclzip documentation)
    if (($v_result_list = $archive->extract()) == 0) {
        die("Error : ".$archive->errorInfo(true));
    }

    // PHP troubleshooting error handling
    if (headers_sent()) {
        echo 'HTTP header already sent';
    } else {
        if (!is_file($file)) {
            // header($_SERVER['SERVER_PROTOCOL'].' 404 Not Found');
            // echo 'File not found';
        } elseif (!is_readable($file)) {
            // header($_SERVER['SERVER_PROTOCOL'].' 403 Forbidden');
            // echo 'File not readable';
        } else {
            // Download the archive of images
            header($_SERVER['SERVER_PROTOCOL'].' 200 OK');
            header("Content-Type: application/zip");
            header("Content-Transfer-Encoding: Binary");
            header("Content-Length: ".filesize($file));
            header("Content-Disposition: attachment; filename=\"".basename($file)."\"");
            ob_clean();
            flush();
            readfile($file);
            ini_set('memory_limit', '128M');

            foreach ($imagesToArchive as $image):
                unlink(MAIN_DIR.'/_php/_download/'.basename($image));
            endforeach;

            exit;
        }
    }
}
