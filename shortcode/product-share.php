<div class="shareIconBox">
  <span class="shareBtn"><img src='<?php echo get_bloginfo( 'template_directory' ); ?>/assets/images/icon-share.svg'>SHARE</span>
  <div class="shareIcons"><?php echo do_shortcode( '[elementor-template id="2333"]' ); ?></div>
</div>

<script>
jQuery(document).ready(function($) { 
  $(".shareIconBox").hover(function () {
    $(this).children(".shareIcons").stop(true,true).fadeIn("fast");
  },function(){
    $(this).children(".shareIcons").fadeOut("fast");
  });
});
</script>