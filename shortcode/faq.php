<script>

jQuery(document).ready(function($) {

/*fAQ Scroll Fixed Menu*/
$(function(){
    var device_min_width = 768;
        if(device_min_width < $(this).width()){
            $(window).load(function() {
                var target = $("#fixed-faq-menu");
                var scrollStop = $(".elementor-location-footer")
                var targetHeight = target.outerHeight(true);
                var headerH = $(".elementor-location-header").height();
                //var headerMainH = $(".headerMain").height();
                var targetTop = target.offset().top - headerH ;

                $(window).scroll(function(){
                    var scrollTop = $(this).scrollTop();
                    if(scrollTop > targetTop){
                        var scrollStopTop = scrollStop.offset().top ;

                        if(scrollTop + targetHeight > scrollStopTop){
                            customTopPosition = scrollStopTop - (scrollTop + targetHeight)
                            target.css({position: "fixed", top:  customTopPosition + "px"});
                        }else{
                            target.css({position: "fixed", top: headerH });
                        }
                    }else{
                        target.css({position: "static", top: "auto"});
                    }
                });
            }); 
        }
});


});

</script>