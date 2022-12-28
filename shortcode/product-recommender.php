<?php $redirectURl = site_url(); ?>

<div id="product-recommender-wrap">

    <div id="chooseLookingFor" class="reco-section-box">
        <h3><?php the_field('looking_for_title'); ?></h3>
        <ul class="reco-icons-wrap reco-title-tabs">
            <li>
                <label>
                    <input type="radio" name="lookingfor" value="<?php the_field('slug-engagement-rings'); ?>">
                    <span class="reco-icon">
                        <img src="<?php the_field('icon-engagement-rings'); ?>" class="img-normal">
                        <img src="<?php the_field('hover-icon-engagement-rings'); ?>" class="img-change">
                    </span>
                    <span class="reco-icon-text">Engagement Rings</span>
                </label>
            </li>
            <li>
                <label>
                    <input type="radio" name="lookingfor" value="<?php the_field('slug_wedding_bands'); ?>">
                    <span class="reco-icon">
                        <img src="<?php the_field('icon_wedding_bands'); ?>" class="img-normal">
                        <img src="<?php the_field('hover-icon_wedding_bands'); ?>" class="img-change">
                    </span>
                    <span class="reco-icon-text">Wedding Bands</span>
                </label>
            </li>
            <li>
                <label>
                    <input type="radio" name="lookingfor" value="<?php the_field('slug_gifts'); ?>">
                    <span class="reco-icon">
                        <img src="<?php the_field('icon_gifts'); ?>" class="img-normal">
                        <img src="<?php the_field('hover_icon_gifts'); ?>" class="img-change">
                    </span>
                    <span class="reco-icon-text">Gifts</span>
                </label>
            </li>
        </ul>
    </div>

    <div class="next_step_arrow"><img src="<?php the_field('next_arrow_icon'); ?>"></div>

    <div id="chooseDesignOptions" class="reco-section-box">
        <h3 class="choose_design_title"><?php the_field('design_option_title'); ?></h3>
        <div class="checkGroups">
            <ul class="reco-icons-wrap reco-option-wrap reco-check-boxes">
                <?php if(get_field('design_options_engagemet_rings')): ?>
                    <?php while(has_sub_field('design_options_engagemet_rings')): ?>
                        <li>
                            <label>
                                <input type="radio" name="thatis" value="<?php the_sub_field('slug_name_design_options_engagemet_rings'); ?>">
                                <span class="reco-icon">
                                    <img src="<?php the_sub_field('icon_design_options_engagemet_rings'); ?>" class="img-normal">
                                    <img src="<?php the_sub_field('hover_icon_design_options_engagemet_rings'); ?>" class="img-change">
                                </span>
                                <span class="reco-icon-text"><?php the_sub_field('text_design_options_engagemet_rings'); ?></span>
                            </label>
                        </li>
                    <?php endwhile; ?>
                <?php endif; ?>
            </ul>
        </div>
        <div class="checkGroups dnone">
            <ul class="reco-icons-wrap reco-option-wrap reco-check-boxes">
                <?php if(get_field('design_options_wedding_bands')): ?>
                    <?php while(has_sub_field('design_options_wedding_bands')): ?>
                        <li>
                            <label>
                                <input type="radio" name="thatis" value="<?php the_sub_field('slug_name_design_options_wedding_bands'); ?>">
                                <span class="reco-icon">
                                    <img src="<?php the_sub_field('icon_design_options_wedding_bands'); ?>" class="img-normal">
                                    <img src="<?php the_sub_field('hover_icon_design_options_wedding_bands'); ?>" class="img-change">
                                </span>
                                <span class="reco-icon-text"><?php the_sub_field('text_design_options_wedding_bands'); ?></span>
                            </label>
                        </li>
                    <?php endwhile; ?>
                <?php endif; ?>
            </ul>
        </div>
        <div class="checkGroups dnone">
            <ul class="reco-icons-wrap reco-option-wrap reco-check-boxes">
                <?php if(get_field('design_options_gifts')): ?>
                    <?php while(has_sub_field('design_options_gifts')): ?>
                        <li>
                            <label>
                                <input type="radio" name="thatis" value="<?php the_sub_field('slug_name_design_options_gifts'); ?>">
                                <span class="reco-icon">
                                    <img src="<?php the_sub_field('icon_design_options_gifts'); ?>" class="img-normal">
                                    <img src="<?php the_sub_field('hover_icon_design_options_gifts'); ?>" class="img-change">
                                </span>
                                <span class="reco-icon-text"><?php the_sub_field('text_design_options_gifts'); ?></span>
                            </label>
                        </li>
                    <?php endwhile; ?>
                <?php endif; ?>
            </ul>
        </div>
    </div>

    <div class="next_step_arrow"><img src="<?php the_field('next_arrow_icon'); ?>"></div>

    <div id="chooseBudget" class="reco-section-box">
        <h3 class="budget_title"><?php the_field('budget_title'); ?></h3>
        <div class="checkGroups">
            <ul class="reco-budget-wrap reco-check-boxes">
                <?php if(get_field('budget_engagement_rings')): ?>
                    <?php while(has_sub_field('budget_engagement_rings')): ?>
                        <li>
                            <label>
                                <input type="radio" name="price" value="<?php the_sub_field('min_budget_engagement_rings'); ?>-<?php the_sub_field('max_budget_engagement_rings'); ?>">
                                <span><?php the_sub_field('budget_text_engagement_rings'); ?></span>
                            </label>
                        </li>
                    <?php endwhile; ?>
                <?php endif; ?>
            </ul>
        </div>

        <div class="checkGroups dnone">
            <ul class="reco-budget-wrap reco-check-boxes">
                <?php if(get_field('budget_wedding_bands')): ?>
                    <?php while(has_sub_field('budget_wedding_bands')): ?>
                        <li>
                            <label>
                                <input type="radio" name="price" value="<?php the_sub_field('min_budget_wedding_bands'); ?>-<?php the_sub_field('max_budget_wedding_bands'); ?>">
                                <span><?php the_sub_field('budget_text_wedding_bands'); ?></span>
                            </label>
                        </li>
                    <?php endwhile; ?>
                <?php endif; ?>
            </ul>
        </div>

        <div class="checkGroups dnone">
            <ul class="reco-budget-wrap reco-check-boxes">
                <?php if(get_field('budget_gifts')): ?>
                    <?php while(has_sub_field('budget_gifts')): ?>
                        <li>
                            <label>
                                <input type="radio" name="price" value="<?php the_sub_field('min_budget_gifts'); ?>-<?php the_sub_field('max_budget_gifts'); ?>">
                                <span><?php the_sub_field('budget_text_gifts'); ?></span>
                            </label>
                        </li>
                    <?php endwhile; ?>
                <?php endif; ?>
            </ul>
        </div>
    </div>

    <!-- <div id="enterBudgetWrap">
        <h3><?php the_field('enter_budget_title'); ?></h3>
        <div class="enterBudgetBox">
            $<input type="number" name="enter_budget" value="3000" min="1" placeholder="$3000" class="enterBudget">
        </div>
        <div class="enterBudgetBox dnone">
            $<input type="number" name="enter_budget" value="1000" min="1" placeholder="$1000" class="enterBudget">
        </div>
        <div class="enterBudgetBox dnone">
            $<input type="number" name="enter_budget" value="500" min="1" placeholder="$500" class="enterBudget">
        </div>
    </div> -->
    

    <button id="find-mydiamond-btn"><?php the_field('recommender_button_text'); ?></button>

</div>

<style>
.dnone {
    display: none;
}
</style>

<script>
    jQuery(document).ready(function($) {

        $(".reco-check-boxes li input[type='radio']").change(function(){
            $("input[type='radio'][name='"+ $(this).attr("name")+ "']").each(function(){
                if($(this).is(":checked")){
                    $(this).parents("li").addClass("selected");
                }else{
                    $(this).parents("li").removeClass("selected");
                }
            });

            $('input.enterBudget').focus(function() {
                $(".reco-budget-wrap li input[type=radio]:checked").attr("checked", false);
                $(".reco-budget-wrap li input[type=radio]").parents("li").removeClass("selected");
            });
        });
            
        $('.enterBudgetBox.active input[name="enter_budget"]').on('change paste keyup', function() {
        var newValue = $('input[name="enter_budget"]').val();
            $(this).attr("value", newValue);
            // var enterBudget = $('input[name="enter_budget"]').val();
            // console.log(enterBudget);
        });

        //add comma to numbers for every 3 digits
        $.fn.digits = function(){ 
            return this.each(function(){ 
                $(this).text( $(this).text().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") ); 
            })
        }
        $("span.min_price, span.max_price").digits();

        
        $("#find-mydiamond-btn").on('click', function(e){
            //e.preventDefault();

            var lookingforFilter  = $('#product-recommender-wrap input[name="lookingfor"]:checked').val();
            var thatisFilter      = $('#product-recommender-wrap input[name="thatis"]:checked').val();
            var priceFilter       = $('#product-recommender-wrap input[name="price"]:checked').val();
            var enterBudget = $('.enterBudgetBox.active input[name="enter_budget"]').val();

            
            if(lookingforFilter && thatisFilter && priceFilter){
                url = "<?php echo $redirectURl; ?>/shop/?_looking_for="+lookingforFilter+"&_that_is="+thatisFilter+"&_my_price_point_is="+priceFilter;
            }else if(lookingforFilter && !thatisFilter && !priceFilter && !enterBudget){
                url = "<?php echo $redirectURl; ?>/shop/?_looking_for="+lookingforFilter;
            }else if(!lookingforFilter && thatisFilter && !priceFilter && !enterBudget){
                url = "<?php echo $redirectURl; ?>/shop/?_that_is="+thatisFilter;
            }else if(!lookingforFilter && !thatisFilter && priceFilter){
                url = "<?php echo $redirectURl; ?>/shop/?_my_price_point_is="+priceFilter;
            }else if(lookingforFilter && thatisFilter && !priceFilter && !enterBudget){
                url = "<?php echo $redirectURl; ?>/shop/?_looking_for="+lookingforFilter+"&_that_is="+thatisFilter;
            }else if(lookingforFilter && !thatisFilter && priceFilter){
                url = "<?php echo $redirectURl; ?>/shop/?_looking_for="+lookingforFilter+"&_my_price_point_is="+priceFilter;
            }else if(!lookingforFilter && thatisFilter && priceFilter){
                url = "<?php echo $redirectURl; ?>/shop/?_that_is="+thatisFilter+"&_my_price_point_is="+priceFilter;
            }else if(lookingforFilter && thatisFilter && !priceFilter && enterBudget){
                url = "<?php echo $redirectURl; ?>/shop/?_looking_for="+lookingforFilter+"&_that_is="+thatisFilter+"&_enter_price=%2C"+enterBudget;
            }else if(!lookingforFilter && thatisFilter && !priceFilter && enterBudget){
                url = "<?php echo $redirectURl; ?>/shop/?_that_is="+thatisFilter+"&_enter_price=%2C"+enterBudget;
            }else if(!lookingforFilter && !thatisFilter && !priceFilter && enterBudget){
                url = "<?php echo $redirectURl; ?>/shop/?_enter_price=%2C"+enterBudget;
            }

            window.location.href = url; 
            
        });

        $("#chooseLookingFor .reco-title-tabs li").click(function() {
            if(!$(this).hasClass('active')){
                $(this).parents(".reco-title-tabs").find("li").removeClass('active');
                $(this).addClass('active');

                var num = $(this).index();
                console.log(num);
                $(this).parents("#product-recommender-wrap").children("#chooseDesignOptions").find(".checkGroups").hide();
                $(this).parents("#product-recommender-wrap").children("#chooseDesignOptions").find(".checkGroups").eq(num).fadeIn("500");

                $(this).parents("#product-recommender-wrap").children("#chooseBudget").find(".checkGroups").hide();
                $(this).parents("#product-recommender-wrap").children("#chooseBudget").find(".checkGroups").eq(num).fadeIn("500");

                $(this).parents("#product-recommender-wrap").children("#enterBudgetWrap").find(".enterBudgetBox").hide().removeClass("active");
                $(this).parents("#product-recommender-wrap").children("#enterBudgetWrap").find(".enterBudgetBox").eq(num).fadeIn("500").addClass("active");

            }
        });


        //add scrolling
        $("#chooseLookingFor .reco-title-tabs li").click(function (){
            $('html, body').animate({
                scrollTop: $("#chooseDesignOptions").offset().top - 170
            }, 200);
        });
        $("#chooseDesignOptions label").click(function (){
            var target = $(this).parents("#product-recommender-wrap").find("#chooseBudget");
            $('html, body').animate({
                scrollTop: target.offset().top - 60
            }, 200);
        });

    });
</script>
