<?php 
// View of Country wise Statistics
function pa_include_country( $current, $country_stats ) {
?>
<div class="data_boxes">
    <div class="data_boxes_title">TOP COUNTRIES <div class="arrow_btn"></div></div>
        <div class="data_container">
            <?php
            if (! empty( $country_stats["rows"] ) ) { ?>
            
            <div class="names_grids">
                <?php foreach ($country_stats["rows"] as $c_stats){ ?>
                        <div class="stats">
                            <div class="row-visits">
                                <span class="large-count"><?php echo $c_stats[1];?></span>
                            Visits
                            </div>
                            <div class="visits-count">
                                <i><?php  echo $c_stats[0];?></i>
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
        <span class="information-txt">Listing statistics of top five countries.</span>
    </div>
</div> 
<?php } ?>