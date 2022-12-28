<?php $redirectURl = site_url(); ?>

<ul id="filter_form">
    <li class="filterDetailBox" id="lookingfor">
        <div class="filterTitle">I'M LOOKING FOR A...</div>
        <div class="filterToggleBox">
            <div class="filterCheckBox col2">
                <label>
                    <input type="radio" name="lookingfor" value="engagement-rings">
                    <span><img width="40" height="40" src='<?php echo get_bloginfo( 'template_directory' ); ?>/assets/images/icon-engage-ring.svg'></span>
                    <span>Engagement Rings</span>
                </label>
                <label>
                    <input type="radio" name="lookingfor" value="wedding-bands">
                    <span><img width="40" height="40" src='<?php echo get_bloginfo( 'template_directory' ); ?>/assets/images/icon-wedding-bands.svg'></span>
                    <span>Wedding Bands</span>
                </label>
                <label>
                    <input type="radio" name="lookingfor" value="gifts">
                    <span><img width="40" height="40" src='<?php echo get_bloginfo( 'template_directory' ); ?>/assets/images/icon-gifts.svg'></span>
                    <span>Gifts</span>
                </label>
            </div>
        </div>
    </li>
    <li class="filterDetailBox" id="thatis">
        <div class="filterTitle">THAT IS...</div>
        <div class="filterToggleBox">
            <div class="filterCheckGroups">
                <div class="filterCheckBox col2">
                    <label>
                        <input type="radio" name="thatis" value="classic">
                        <span><img width="40" height="40" src='<?php echo get_bloginfo( 'template_directory' ); ?>/assets/images/icon-classic.svg'></span>
                        <span>Classic</span>
                    </label>
                    <label>
                        <input type="radio" name="thatis" value="pave">
                        <span><img width="40" height="40" src='<?php echo get_bloginfo( 'template_directory' ); ?>/assets/images/icon-pave.svg'></span>
                        <span>Pave</span>
                    </label>
                    <label>
                        <input type="radio" name="thatis" value="halo">
                        <span><img width="40" height="40" src='<?php echo get_bloginfo( 'template_directory' ); ?>/assets/images/icon_halo.svg'></span>
                        <span>Halo</span>
                    </label>
                </div>
            </div>

            <div class="filterCheckGroups dnone">
                <div class="filterCheckBox col2">
                    <label>
                        <input type="radio" name="thatis" value="for-her">
                        <span><img width="40" height="40" src='<?php echo get_bloginfo( 'template_directory' ); ?>/assets/images/icon-for-her.svg'></span>
                        <span>For Her</span>
                    </label>
                    <label>
                        <input type="radio" name="thatis" value="for-him">
                        <span><img width="40" height="40" src='<?php echo get_bloginfo( 'template_directory' ); ?>/assets/images/icon-for-him.svg'></span>
                        <span>For Him</span>
                    </label>
                </div>
            </div>

            <div class="filterCheckGroups dnone">
                <div class="filterCheckBox col2">
                    <label>
                        <input type="radio" name="thatis" value="everyday-chic">
                        <span><img width="40" height="40" src='<?php echo get_bloginfo( 'template_directory' ); ?>/assets/images/icon-everyday-chic.svg'></span>
                        <span>Everyday Chic</span>
                    </label>
                    <label>
                        <input type="radio" name="thatis" value="elegant-and-luxurious">
                        <span><img width="40" height="40" src='<?php echo get_bloginfo( 'template_directory' ); ?>/assets/images/icon-elegant.svg'></span>
                        <span>Elegant and Luxurious</span>
                    </label>
                </div>
            </div>
        </div>
    </li>
    <li class="filterDetailBox" id="myprice">
        <div class="filterTitle">MY PRICE POINT IS...</div>
        <div class="filterToggleBox">
            
            <div class="filterCheckGroups">
                <div class="filterCheckBox">
                    <label>
                        <input type="radio" name="price" value="1000-2999">
                        <span>$1000 - $2999</span>
                    </label>
                    <label>
                        <input type="radio" name="price" value="3000-4999">
                        <span>$3000 - $4999</span>
                    </label>
                    <label>
                        <input type="radio" name="price" value="5000-6999">
                        <span>$5000 - $6999</span>
                    </label>
                    <label>
                        <input type="radio" name="price" value="7000-10000">
                        <span>$7000 - $10000</span>
                    </label>
                </div>
            </div>
            
            <div class="filterCheckGroups dnone">
                <div class="filterCheckBox">
                    <label>
                        <input type="radio" name="price" value="500-999">
                        <span>$500 - $999</span>
                    </label>
                    <label>
                        <input type="radio" name="price" value="1000-1499">
                        <span>$1000 - $1499</span>
                    </label>
                    <label>
                        <input type="radio" name="price" value="1500-2500">
                        <span>$1500 - $2500</span>
                    </label>
                </div>
            </div>

            <div class="filterCheckGroups dnone">
                <div class="filterCheckBox">
                    <label>
                        <input type="radio" name="price" value="1-299">
                        <span>$1 - $299</span>
                    </label>
                    <label>
                        <input type="radio" name="price" value="300-499">
                        <span>$300 - $499</span>
                    </label>
                    <label>
                        <input type="radio" name="price" value="500-999">
                        <span>$500 - $999</span>
                    </label>
                    <label>
                        <input type="radio" name="price" value="1000-2000">
                        <span>$1000 - $2000</span>
                    </label>
                </div>
            </div>
            
            
            <div id="enterBudgetWrap">
                <label>Or tell us your budget</label>
                <div class="enterBudgetBox">
                    <input type="number" name="enter_budget" value="3000" min="1" placeholder="$3000" class="enterBudget">
                </div>
                <div class="enterBudgetBox dnone">
                    <input type="number" name="enter_budget" value="1000" min="1" placeholder="$1000" class="enterBudget">
                </div>
                <div class="enterBudgetBox dnone">
                    <input type="number" name="enter_budget" value="500" min="1" placeholder="$500" class="enterBudget">
                </div>
            </div>
            
        </div>
    </li>
</ul>

<button id="filter_submit_btn">FIND MY PRODUCT</button>

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
            url = "<?php echo $redirectURl; ?>/shop/?_looking_for="+lookingforFilter+"&_that_is="+thatisFilter+"&_enter_price="+enterBudget;
        }else if(!lookingforFilter && thatisFilter && !priceFilter && enterBudget){
            url = "<?php echo $redirectURl; ?>/shop/?_that_is="+thatisFilter+"&_enter_price="+enterBudget;
        }else if(!lookingforFilter && !thatisFilter && !priceFilter && enterBudget){
            url = "<?php echo $redirectURl; ?>/shop/?_enter_price="+enterBudget;
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




