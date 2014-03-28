<?php
$results = new ArrayIterator($results_arr);
$rpp = 30; // "Results per page"

if (($page*$rpp)-$rpp <= count($results)) {

  $i = 0;
  foreach (new LimitIterator($results, (($page * $rpp) - $rpp), $rpp) as $resid=>$arr) {
    if ($i == $rpp) break;

    // Trim 'work' or 'image' from beginning of id string
    $id = substr($resid, -6);

    // Define array of search types that yielded results for this record
    // by combining search arrays for all terms together
    $searches_arr = array();
    foreach ($arr['search'] as $term_arr) {
      $searches_arr = array_merge($searches_arr, $term_arr);
    }
    $searches_arr = array_unique($searches_arr);

    // Determine the preferred thumbnail image for this record
    // And assign a parent Work, if available
    if ($arr['type']=='work'){

      $short_id = ltrim($id, '0');

      $sql = "SELECT preferred_image 
            FROM $DB_NAME.work 
            WHERE id = {$short_id} ";

      $res = db_query($mysqli, $sql);

      while ($work = $res->fetch_assoc()) { 

        $prefImage = $work['preferred_image'];
        
        $sql = "SELECT legacy_id 
              FROM $DB_NAME.image 
              WHERE id = '{$prefImage}' ";

        $result = db_query($mysqli, $sql);

          while ($row = $result->fetch_assoc()) {      
       
            $img_id = $row['legacy_id'];
          }
        $parent = 'none';
        }
    
     }          

    elseif ($arr['type']=='image'){
      
      $sql = "SELECT legacy_id, related_works 
              FROM $DB_NAME.image 
              WHERE id = {$id} ";   

      $result = db_query($mysqli, $sql);

      while ($row = $result->fetch_assoc()) {
        
        $img_id = $row['legacy_id'];

        // Find this Image's parent Work
        $parent = (trim($row['related_works'] != '')) 
              ? $row['related_works'] 
              : 'none';
      }
    }

    // If the image id of the preferred thumbnail is NOT blank, display a result row
    if (!empty($prefImage)) {

      $src = $webroot."/_plugins/timthumb/timthumb.php?src=".$image_src."medium/".$img_id.".jpg&amp;h=80&amp;w=80&amp;q=90";
    ?>

      <div class="lanternResults_list_row defaultCursor">

        <div class="thumb_panel">

          <img src="<?php echo $src; ?>"
            class="list_thumb"
            title="Click to preview"
            data="<?php echo ($arr['type'] == 'work') ? $prefImage : create_six_digits($id); ?>"
            data-image="<?php echo $img_id; ?>">

          <?php if ($_SESSION['priv_orders_read']=='1') { ?>

          <span class="view_catalog pointer"
            title="Jump to catalog record">view catalog</span>

          <span class="add_image_to_cart pointer"
            data-type="<?php echo ($arr['type'] == 'work') ? 'work' : 'image'; ?>"
            data-num="<?php echo ($arr['type'] == 'work')
              ? create_six_digits($id)
              : create_six_digits($img_id); ?>"
            title="Add image to cart">add to cart</span>

          <?php } ?>

        </div>

        <!-- Catalog data for this result -->

        <div class="text_panel">

          <!-- Title -->

          <div class="highlightable"
            style="margin-bottom: 2px; font-size: 1.1em; line-height: 1.1em;">

            <?php
            $sql = "SELECT * 
                  FROM $DB_NAME.title 
                  WHERE related_{$arr['type']}s = {$id} ";

            $res = db_query($mysqli, $sql);

            $title_arr = array();

            while ($row = $res->fetch_assoc()) {
              $title_arr[] = $row['title_text'];
            }

            // Assign a default value if title array is empty
            $title_arr = (empty($title_arr)) 
              ? array('Uncataloged') 
              : $title_arr;

            // Display appropriate titles
            lantern_list_display_titles($mysqli, $title_arr, $searches_arr, $DB_NAME); ?>

          </div>

          <!-- Agent -->

          <div class="highlightable"
            style="margin-bottom: 1px; font-size: 0.9em;">

            <?php
            lantern_list_display_agents($mysqli, $arr['type'], create_six_digits($id), $searches_arr, $parent, $DB_NAME);
            ?>

          </div>

          <!-- Record number -->

          <div style="font-size: 0.8em; color: #999; margin-bottom: 5px;">

            <?php echo ucfirst($arr['type']).' '; ?>

            <span class="highlightable">

              <?php echo create_six_digits($id); ?>

            </span>

          </div>

          <!-- Date -->

          <div class="data_row">

            <span class="mediumWeight" style="display: inline-block;">Date:&nbsp;</span>

            <span class="highlightable">

              <?php
              lantern_list_display_date($mysqli, $arr['type'], $id, $parent, $DB_NAME);
                // eg. func('work', '062261', 'none/000261')
              ?>

            </span>

          </div>

          <!-- Other matched data -->

          <?php
          // For each type of search that successfully returned this record
          foreach ($searches_arr as $search) {

            if (!in_array($search, array('work_id','image_id','title','agent','work_description','image_description','getty_att','getty_tgn','getty_ulan'))) {

              // Define name of function to display the record's data
              $func = 'lantern_list_display_'.$search; ?>

              <div class="data_row">

                <span class="mediumWeight" style="display: inline-block;">

                  <?php
                  echo str_replace('_',' ',ucfirst($search));
                  ?>:&nbsp;

                </span>

                <span class="highlightable"><?php

                  // Call appropriate function to display this field
                  $func($mysqli, $arr['type'], $id, $DB_NAME); 
                    // eg. func(mysqli connection, 'work', '000261')
              
                ?></span>

              </div>

            <?php
            }

            // Search term found in DESCRIPTION
            if (in_array($search, array('work_description','image_description'))) {

              $sql = "SELECT description 
                    FROM $DB_NAME.{$arr['type']} 
                    WHERE lpad(id, 6, '0') = {$id} ";

              $res = db_query($mysqli, $sql);

              while ($row = $res->fetch_assoc()) {
                $desc = $row['description'];
              } ?>

              <div class="highlightable lantern_desc collapsed data_row" style="overflow: hidden;">

                <span class="mediumWeight" style="display: inline-block;">Description:&nbsp;</span>

                <?php echo $desc; ?>

              </div><?php
            }
          }
          ?>

        <!-- end text_panel -->
        </div>

        <!-- Related images frame -->

        <div class="related_panel">

          <div></div>

          <?php
          if ($arr['type']=='work') {
            get_related_images($mysqli, $id, $DB_NAME, $webroot, $image_src);
          } ?>

        </div>

      <?php
      // echo '<pre>';
      // print_r($results[$resid]);
      // echo '</pre>';
      ?>

      <p class="clear"></p>

      <!-- end row -->
      </div>

    <?php
    }
  $i++;
  }
  ?>

  <script id="lantern_list_script">

    /*
    TOGGLE FILTER VISIBILITY
    */
    // TEMP: Commented out while filters are not being used
    // 
    // $('#filter_toggle').unbind('click').click(
    //  function()
    //  {
    //    if (!$('#control_panel_wide').is(':visible'))
    //    {
    //      $('#control_panel_wide').slideDown(600);
    //      $('#filter_toggle span').text('Hide Filters');
    //      $(document).scrollTop($('body').offset().top);
    //    }
    //    else
    //    {
    //      $('#control_panel_wide').slideUp(600);
    //      $('#filter_toggle span').text('Show Filters');
    //    }
    //  });


    // DEFINE TERMS FOR HIGHLIGHT SEARCH

    var terms = <?php echo json_encode($searchText_arr); ?>;
    // console.log(JSON.stringify(terms)); // Debug


    // HIGHLIGHT SEARCH TERMS ON MOUSEENTER

    $('div.lanternResults_list_row').hover(
      function (event) {
        event.stopPropagation();
        var $row = $(this);
        $.each(terms, function (index, val, row) {
          $row.find('.highlightable').highlight(val);
        });
      },
      function (event) {
        event.stopPropagation();
        $.each($(this).find('.highlightable span.glowBG'), function () {
          var $text = $(this).text();
          $(this).replaceWith($text);
        });
      });


    // GLOW ON THUMBNAIL HOVER

    $('div.thumb_panel img.list_thumb, div.related_panel img').hover(
      function () {
        $(this).addClass('glowPurple');
      }, 
      function () {
        $(this).removeClass('glowPurple');
      });


    // JUMP TO CATALOG

    $('span.view_catalog').click(
      function () {
        var imageNum = $(this).siblings('img.list_thumb').attr('data');
        view_image_record(imageNum);
        view_work_record(imageNum);
      });

    // ADD IMAGE TO CART

    $('span.add_image_to_cart').click(
      function () {

        var images = [];
        var $related = $(this).parents('div.lanternResults_list_row').find('div.related_panel');

        $.each($related.find('img.related_thumb'), function () {
          images.push($(this).attr('data-image'));
        }); 
        add_to_cart(images);
      });


    // CLICK THUMBNAIL TO PREVIEW

    $('img.list_thumb, img.related_thumb').click(
      function () {
        var img = $(this).attr('data-image');
        image_viewer(img);
      });


    // EXPAND/COLLAPSE RECORD DESCRIPTION

    $('.lantern_desc').click(
      function () {
        $(this).toggleClass('collapsed expanded');
      });


    // LOAD MORE RESULTS WHEN USER SCROLLS TO END OF LIST

    var newPage = <?php echo $page + 1; ?>;
    scroll_to_load($('div#lantern_results_list'), 'list', newPage);

  </script>
<?php
}
?>