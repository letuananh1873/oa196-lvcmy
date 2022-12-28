<?php
/**
 * Template Name: Register Page
 */
get_header();

?>
<script src="<?php echo get_template_directory_uri() .'/assets/js/register-datepicker.min.js'; ?>" type="text/javascript"></script>
<style>
    
</style>
<div class="container">
    <?php get_country_mobile_code(); ?>
    <form id="register-form" method="post">
        <h3 class="form__title">Create An Account</h3>

        <div class="form__group">
            <label for="gender">Gender</label>
            <input type="hidden" name="gender" id="gender">
            <div class="gender__box">
                <button>Male</button>
                <button>Female</button>
            </div>
        </div>
        <div class="form__group form__group--50">
            <label for="firstname">First Name</label>
            <input type="text" name="firstname" id="firstname" class="form__input">
        </div>
        <div class="form__group form__group--50">
            <label for="lastname">Last Name</label>
            <input type="text" name="lastname" id="lastname" class="form__input">
        </div>
        <div class="form__group">
            <label for="contact">Mobile Number</label>
            <input type="text" name="contact" id="contact" class="form__input">
        </div>
        <div class="form__group">
            <label for="dob">Date of Birth</label>
            <input type="text" name="dob" id="dob" class="form__input" placeHolder="01/01/1990" autocomplete="off">
        </div>
        <div class="form__group">
            <label for="email">Email Address (Username)</label>
            <input type="text" name="email" id="email" class="form__input">
        </div>
        <div class="form__group">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" class="form__input">
        </div>
        <div class="form__group">
            <label for="confirmpassword">Confirm Password</label>
            <input type="password" name="confirmpassword" id="confirmpassword" class="form__input">
        </div>
        <div class="form__group form__submit">
            <label for="accept-policy">
                <input type="checkbox" name="accept-policy" id="accept-policy">
                I have read and accepted the <a href="<?php echo home_url('/terms-of-use'); ?>" target="_blank">Terms & Conditions</a> and <a href="<?php echo home_url('/privacy');?>" target="_blank">Privacy Policy</a>
            </label>
        </div>
        <div class="form__group form__submit">
            <input type="submit" value="Register" name="register-submit" id="register-submit" class="form__disable">
            <img class="registering" src="<?php echo get_template_directory_uri(); ?>/assets/images/Spinner-1s-200px.svg" alt="Loading">
        </div>

        <div class="register-notice"></div>
    </form>
</div>
<?php
get_footer();
?>