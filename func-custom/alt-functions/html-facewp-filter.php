<div class="altm-filter-nav">
    <div class="altm-filter-nav-col">
        <label><span>FILTER BY</span></label>

        <div class="altm-filter-nav-first altm-filter-panel">
            <div class="altm-filter-panel-container">
                <div class="altm-filter-panel-heading">
                    <h4>Filter</h4>
                    <span class="altm-filter-panel-close"><i class="fa fa-times" aria-hidden="true"></i></span>
                </div>


                <div class="altm-facewp">
                    <?php echo $this->get_item('product_categories');?>
                    <?php echo $this->get_item('designer_collections');?>
                    <?php echo $this->get_item('material');?>
                    <?php if( ! empty(alt_get_count_tax('colour')) ) {
                        echo $this->get_item('colour');
                    }?>
                    <?php echo $this->get_item('occasions');?>
                    <?php echo $this->get_item('ring_size');?>
                    <?php if( ! empty(alt_get_count_tax('pa_carat-weight')) ) {
                        echo $this->get_item('carat_weight');
                    }?>

                    <div class="altm-facewp-box facewp-custom" data-label="Price">
                        <div class="fs-wrap">
                            <div class="filterBy_label">Price</div>
                            <div class="altm-facewp-dropdown alt-hidden">
                                <?php echo do_shortcode( '[facetwp facet="product_price"]' ); ?>
                            </div>
                        </div>
                    </div>
                </div>

                <button class="button altm-apply-filter">Apply Filters</button>
                <div class="filterByBoxes filterByBoxes_resetBtn clearfilter-mobile">
              <button onclick="FWP.reset()"><span class="clear-filter"><svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 25 25" fill="none"><path d="M2.37106 0.406738L0.407089 2.37071L10.5362 12.4998L0.407089 22.629L2.37106 24.5929L12.5002 14.4638L22.6293 24.5929L24.5933 22.629L14.4642 12.4998L24.5933 2.37071L22.6293 0.406738L12.5002 10.5359L2.37106 0.406738Z" fill="red"></path></svg></span>Clear Filters</button>
            </div>
            </div>
        </div>
    </div>

    <div class="altm-filter-nav-col">
        <label><span>SORT BY</span></label>

        <div class="altm-filter-nav-last altm-filter-panel">
            <div class="altm-filter-panel-container">
                <div class="altm-filter-panel-heading">
                    <h4>Sort</h4>
                    <span class="altm-filter-panel-close"><i class="fa fa-times" aria-hidden="true"></i></span>
                </div>

                <div class="altm-filter-sort">
                    sodium_crypto_pwhash_scryptsalsa208sha256_st
                </div>
            </div>
        </div>
    </div>
</div>