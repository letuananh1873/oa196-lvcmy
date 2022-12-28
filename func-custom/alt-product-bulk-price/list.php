<div class="wrap">
    <div id="icon-tools" class="icon32"></div>
    <h2>Bulk Price
        <a href="<?php echo admin_url('admin.php?page=bulk-price-page&act=new');?>" class="page-title-action">Add New</a>
        <button class="page-title-action btn-bulk-import">Import</button>
        <button class="page-title-action btn-bulk-export">Export</button>

        <div class="bulk_price_import_wrapper" style="display: none;">
            <input type="file" name="import_file" id="bulk-import_file_input" value="" />
            <button type="submit" class="button button-primary button-bulk-start-import">Start</button>
        </div>

        <div id="bulk_price_import_message"></div>
    </h2>
    <div class="table-wrapper">
        <table id="table-bulk-price" class="display" style="width:100%">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>SKU</th>
                    <th>Fixed Price</th>
                    <?php foreach( bulk_price_attributes() as $key => $attribute ) {
                        printf('<th><div>%s</div></th>', implode(',', $attribute) );   
                    }?>
                    <th></th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>

<div id="result-bulk-price">
    <div class="result-bulk-price-content"></div>
</div>

<?php if( isset($_GET['show']) ) { ?>
<script>
    var isDebug = true;
</script>
<?php }?>