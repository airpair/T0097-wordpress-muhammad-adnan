<?php
// View of Browser Statistics
function pa_include_browser( $current, $browser_stats ) {
?>
<div class="data_boxes">
  <div class="data_boxes_title"><?php echo _e('BROWSERS STATS', 'wp-analytify');?><div class="arrow_btn"></div></div>
  <div class="data_container">
    <?php
    if (!empty($browser_stats["rows"])){ ?>
       <div class="names_grids">
                <?php foreach ($browser_stats["rows"] as $c_stats){ ?>
                        <div class="stats">
                            <div class="row-visits">
                                <span class="large-count"><?php echo $c_stats[2];?></span>
                            Visits
                            </div>
                            <div class="visits-count">
                                <i><?php  echo $c_stats[0];?> (<?php  echo $c_stats[1];?>)</i>
                            </div>
                        </div>
                <?php } ?>
            </div>
    <?php } ?>
  </div>
  <div class="data_boxes_footer">
      <span class="blk"> 
        <span class="dot"></span> 
        <span class="line"></span> 
      </span> 
      <span class="information-txt"><?php echo _e('listing statistics of top five browsers.', 'wp-analytify');?></span>
  </div>
</div>
<?php } ?>