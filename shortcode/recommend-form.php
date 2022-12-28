<?php 
    $redirectURl = site_url(); 
    $post_id = 3623;
?>

<ul id="filter_form">
    <li class="filterDetailBox" id="lookingfor">
        <div class="filterTitle"><?php the_field('looking_for_title' , $post_id); ?></div>
        <div class="filterToggleBox">
            <div class="filterCheckBox col2">
                <label>
                    <input type="radio" name="lookingfor" value="<?php the_field('slug-engagement-rings' , $post_id); ?>">
                    <span class="reco-icon">
                        <img width="40" height="40" src="<?php the_field('icon-engagement-rings', $post_id); ?>" class="img-normal">
                        <img width="40" height="40" src="<?php the_field('hover-icon-engagement-rings', $post_id); ?>" class="img-change">
                    </span>
                    <span>Engagement Rings</span>
                </label>
                <label>
                    <input type="radio" name="lookingfor" value="<?php the_field('slug_wedding_bands', $post_id); ?>">
                    <span class="reco-icon">
                        <img width="40" height="40" src="<?php the_field('icon_wedding_bands', $post_id); ?>" class="img-normal">
                        <img width="40" height="40" src="<?php the_field('hover-icon_wedding_bands', $post_id); ?>" class="img-change">
                    </span>
                    <span>Wedding Bands</span>
                </label>
                <label>
                    <input type="radio" name="lookingfor" value="<?php the_field('slug_gifts', $post_id); ?>">
                    <span class="reco-icon">
                        <img width="40" height="40" src="<?php the_field('icon_gifts', $post_id); ?>" class="img-normal">
                        <img width="40" height="40" src="<?php the_field('hover_icon_gifts', $post_id); ?>" class="img-change">
                    </span>
                    <span>Gifts</span>
                </label>
            </div>
        </div>
    </li>
    <li class="filterDetailBox" id="thatis">
        <div class="filterTitle"><?php the_field('design_option_title' , $post_id); ?></div>
        <div class="filterToggleBox">
            <div class="filterCheckGroups">
                <div class="filterCheckBox col2">
                    <?php if(get_field('design_options_engagemet_rings', $post_id)): ?>
                        <?php while(has_sub_field('design_options_engagemet_rings', $post_id)): ?>
                        <label>
                            <input type="radio" name="thatis" value="<?php the_sub_field('slug_name_design_options_engagemet_rings'); ?>">
                            <span class="reco-icon">
                                <img width="40" height="40" src="<?php the_sub_field('icon_design_options_engagemet_rings'); ?>" class="img-normal">
                                <img width="40" height="40" src="<?php the_sub_field('hover_icon_design_options_engagemet_rings'); ?>" class="img-change">
                            </span>
                            <span><?php the_sub_field('text_design_options_engagemet_rings'); ?></span>
                        </label>
                        <?php endwhile; ?>
                    <?php endif; ?>
                </div>
            </div>

            <div class="filterCheckGroups dnone">
                <div class="filterCheckBox col2">
                    <?php if(get_field('design_options_wedding_bands', $post_id)): ?>
                        <?php while(has_sub_field('design_options_wedding_bands', $post_id)): ?>
                        <label>
                            <input type="radio" name="thatis" value="<?php the_sub_field('slug_name_design_options_wedding_bands'); ?>">
                            <span class="reco-icon">
                                <img width="40" height="40" src="<?php the_sub_field('icon_design_options_wedding_bands'); ?>" class="img-normal">
                                <img width="40" height="40" src="<?php the_sub_field('hover_icon_design_options_wedding_bands'); ?>" class="img-change">
                            </span>
                            <span><?php the_sub_field('text_design_options_wedding_bands'); ?></span>
                        </label>
                        <?php endwhile; ?>
                    <?php endif; ?>
                </div>
            </div>

            <div class="filterCheckGroups dnone">
                <div class="filterCheckBox col2">
                    <?php if(get_field('design_options_gifts', $post_id)): ?>
                        <?php while(has_sub_field('design_options_gifts', $post_id)): ?>
                        <label>
                            <input type="radio" name="thatis" value="<?php the_sub_field('slug_name_design_options_gifts'); ?>">
                            <span class="reco-icon">
                                <img width="40" height="40" src="<?php the_sub_field('icon_design_options_gifts'); ?>" class="img-normal">
                                <img width="40" height="40" src="<?php the_sub_field('hover_icon_design_options_gifts'); ?>" class="img-change">
                            </span>
                            <span><?php the_sub_field('text_design_options_gifts'); ?></span>
                        </label>
                        <?php endwhile; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </li>
    <li class="filterDetailBox" id="myprice">
        <div class="filterTitle"><?php the_field('budget_title' , $post_id); ?></div>
        <div class="filterToggleBox">
            
            <div class="filterCheckGroups">
                <div class="filterCheckBox">
                    <?php if(get_field('budget_engagement_rings', $post_id)): ?>
                        <?php while(has_sub_field('budget_engagement_rings', $post_id)): ?>
                            <label>
                                <input type="radio" name="price" value="<?php the_sub_field('min_budget_engagement_rings'); ?>-<?php the_sub_field('max_budget_engagement_rings'); ?>">
                                <span><?php the_sub_field('budget_title_engagement_rings'); ?></span>
                            </label>
                        <?php endwhile; ?>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="filterCheckGroups dnone">
                <div class="filterCheckBox">
                    <?php if(get_field('budget_wedding_bands', $post_id)): ?>
                        <?php while(has_sub_field('budget_wedding_bands', $post_id)): ?>
                            <label>
                                <input type="radio" name="price" value="<?php the_sub_field('min_budget_wedding_bands'); ?>-<?php the_sub_field('max_budget_wedding_bands'); ?>">
                                <span><?php the_sub_field('budget_title_wedding_bands'); ?></span>
                            </label>
                        <?php endwhile; ?>
                    <?php endif; ?>
                </div>
            </div>

            <div class="filterCheckGroups dnone">
                <div class="filterCheckBox">
                    <?php if(get_field('budget_gifts', $post_id)): ?>
                        <?php while(has_sub_field('budget_gifts', $post_id)): ?>
                            <label>
                                <input type="radio" name="price" value="<?php the_sub_field('min_budget_gifts'); ?>-<?php the_sub_field('max_budget_gifts'); ?>">
                                <span><?php the_sub_field('budget_title_gifts'); ?></span>
                            </label>
                        <?php endwhile; ?>
                    <?php endif; ?>
                </div>
            </div>
            
            
            <!-- <div id="enterBudgetWrap">
                <label><?php the_field('enter_budget_title' , $post_id); ?></label>
                <div class="enterBudgetBox">
                    $<input type="number" name="enter_budget" value="3000" min="1" placeholder="$3000" class="enterBudget">
                    <span class="apply_enter_budget">Apply</span>
                </div>
                <div class="enterBudgetBox dnone">
                    $<input type="number" name="enter_budget" value="1000" min="1" placeholder="$1000" class="enterBudget">
                    <span class="apply_enter_budget">Apply</span>
                </div>
                <div class="enterBudgetBox dnone">
                    $<input type="number" name="enter_budget" value="500" min="1" placeholder="$500" class="enterBudget">
                    <span class="apply_enter_budget">Apply</span>
                </div>
            </div> -->
            
        </div>
    </li>
</ul>

<button id="filter_submit_btn"><?php the_field('recommender_button_text', $post_id); ?></button>

<style>
.dnone {
    display:none;
}
</style>

<script>
jQuery(document).ready(function($) {
    $(".filterTitle").click(function(){
        $(this).toggleClass("active");
        $(this).next(".filterToggleBox").slideToggle();
    });

    $(".filterCheckBox label").click(function(){
        var html = $(this).html();
        console.log(html);
        $(this).parents(".filterDetailBox").children(".filterTitle").html(html);

        $(this).parents(".filterDetailBox").children(".filterToggleBox").slideUp();
    });



    $(".apply_enter_budget").click(function(){
        var enterBudgetValue = $(this).parents(".enterBudgetBox").children("input.enterBudget").val();
        $(this).parents(".filterDetailBox").children(".filterTitle").html( "$" + enterBudgetValue);

        $(this).parents(".filterDetailBox").children(".filterToggleBox").slideUp();
    });



    $("button#filter_submit_btn").click(function(){
        $(".filterToggleBox").slideUp();
    });

    $("#filter_form input[type='radio']").change(function(){
        $("input[type='radio'][name='"+ $(this).attr("name")+ "']").each(function(){
            if($(this).is(":checked")){
                $(this).parents("label").addClass("selected");
            }else{
                $(this).parents("label").removeClass("selected");
            }
        });

        $('input.enterBudget').focus(function() {
            $("#myprice input[type=radio]:checked").attr("checked", false);
            $("#myprice input[type=radio]").parents("label").removeClass("selected");
        });
    });

    $('.enterBudgetBox.active input[name="enter_budget"]').on('change paste keyup', function() {
    var newValue = $('input[name="enter_budget"]').val();
        $(this).attr("value", newValue);
        // var enterBudget = $('input[name="enter_budget"]').val();
        // console.log(enterBudget);

        $(this).parents(".filterDetailBox").children(".filterTitle").html("$"+newValue);
    });

	$("#filter_submit_btn").on('click', function(e){
        //e.preventDefault();

        $(".filterCheckBox input:checked").parent().toggleClass("active");
        
        var lookingforFilter  = $('#filter_form input[name="lookingfor"]:checked').val();
        var thatisFilter      = $('#filter_form input[name="thatis"]:checked').val();
        var priceFilter       = $('#filter_form input[name="price"]:checked').val();
        var enterBudget       = $('#filter_form .enterBudgetBox.active input[name="enter_budget"]').val();


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

    $("#lookingfor .filterCheckBox label").click(function() {
        if(!$(this).hasClass('active')){
            $(this).parents(".filterCheckBox").find("label").removeClass('active');
            $(this).addClass('active');

            var num = $(this).index();
            $(this).parents("#filter_form").children("#thatis").find(".filterCheckGroups").hide();
            $(this).parents("#filter_form").children("#thatis").find(".filterCheckGroups").eq(num).fadeIn("500");

            $(this).parents("#filter_form").children("#myprice").find(".filterCheckGroups").hide();
            $(this).parents("#filter_form").children("#myprice").find(".filterCheckGroups").eq(num).fadeIn("500");

            $(this).parents("#filter_form").children("#myprice").find(".enterBudgetBox").hide().removeClass("active");
            $(this).parents("#filter_form").children("#myprice").find(".enterBudgetBox").eq(num).fadeIn("500").addClass("active");

            $(this).parents("#filter_form").children("#thatis").children(".filterTitle").html("THAT IS...");
            $(this).parents("#filter_form").children("#myprice").children(".filterTitle").html("MY PRICE POINT IS...");
        }
    });


});
</script>




