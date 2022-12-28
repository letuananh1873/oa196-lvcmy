<div class="location_select_box">
  <span class="current_location">
    <img width="18" height="18" class="icon_globe" src='<?php echo get_bloginfo( 'template_directory' ); ?>/assets/images/icon-globe.svg'>
    <span class="current_location_text">MALAYSIA</span>
  </span>
  <?php if(get_field('other_location', 58)): ?>
    <div class="other_location_dropdown">
      <ul class="other_location_links">
        <?php while(has_sub_field('other_location', 58)): ?>
          <li><a href="<?php the_sub_field('website_url'); ?>" target="_blank"><?php the_sub_field('country_name'); ?></a></li>
        <?php endwhile; ?>
      </ul>
    </div>
  <?php endif; ?>
  </div>


<script>
jQuery(document).ready(function($) { 
 $(".location_select_box").hover( function () {
    $(this).find(".other_location_dropdown").fadeIn("fast");
  },function(){
    $(this).find(".other_location_dropdown").fadeOut("fast");
  });
});
</script>