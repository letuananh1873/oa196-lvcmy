jQuery(document).ready(function($) {

    // New Register Page
    // $("#register-form #dob").flatpickr({
    //     dateFormat: 'm/d/Y'
    // });

    if( $("#register-form #dob").length > 0) {
        $("#register-form #dob").datepicker({
            maxDate: "-16y",
            yearRange: "-150:+0",
            changeYear: true,
            changeMonth: true,
            // onSelect: function(dateText) {
            //     $(".birthday-err").removeClass("active");
            // }
        });
    }


    function registerValidate(value, type = 'text') {

        if(value === '') return {stt: false, err: 'This Field is required!'};

        var stt = true;
        var err = '';

        switch(type) {
            case 'text': 

                if(value === '') {
                    err = 'This Field is required!';
                }

            break;
            case 'email': 

                const format = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;

                if(!format.test(value)) {
                    stt =  false;
                    err = 'Enter valid Email!';
                }

            break;
            case 'password':


            break;
            case 'confirm_password': 
                const pw = document.getElementById('password');
                
                if(pw.value !== value) {
                    stt = false;
                    err = 'The specified password do not match!';
                }

                if(!pw.value) {
                    stt = false;
                    err = 'This Field is required!';
                }
                
            break;
            case 'checkbox': 
                if(!value) {
                    stt = false;
                    err = 'This Field is required!'; 
                }
            break;
            default: 
            break;
        }

        return {
            stt: stt,
            err: err
        }

    };

    function createErrBox(el, err) {
        const wrap = document.createElement('span'),
              content = document.createElement('span');

        const errBoxs = el.parentNode.querySelectorAll('.form__message');

        for(var i = 0; i < errBoxs.length; ++i) {
            errBoxs[i].remove();
        }

        wrap.classList.add('form__message');
        content.classList.add('form__error');

        content.textContent = err;
        wrap.appendChild(content);
        
        return wrap;
    }

    $(document).on('submit', '#register-form', function() {
        const email = document.getElementById('email'),
              gender = document.getElementById('gender'),
              fname = document.getElementById('firstname'),
              lname = document.getElementById('lastname'),
              mbPhone = document.getElementById('contact'),
              dob = document.getElementById('dob'),
              pw = document.getElementById('password'),
              cfPw = document.getElementById('confirmpassword'),
              phoneCode = document.querySelector('input[name="contact_customcode"'),
              policy = document.getElementById('accept-policy');
        
        const emaiValid = registerValidate(email.value, 'email'),
              genderValid = registerValidate(gender.value, 'text'),
              fnameValid = registerValidate(fname.value, 'text'),
              lnameValid = registerValidate(lname.value, 'text'),
              dobValid = registerValidate(dob.value, 'text'),
              mbPhoneValid = registerValidate(mbPhone.value, 'phone'),
              pwValid = registerValidate(pw.value, 'password'),
              cfPwValid = registerValidate(cfPw.value, 'confirm_password'),
              policyValid = registerValidate(policy.checked, 'checkbox');

        var hasError = false;
        const errBoxs = document.querySelectorAll('.form__message');
        
        for(var i = 0; i < errBoxs.length; ++i) {
            errBoxs[i].remove();
        }

        // Check Email
        if(!(emaiValid.stt)) {
            email.parentNode.appendChild(createErrBox(email, emaiValid.err));
            hasError = true;
        }

        // Check Gender
        if(!genderValid.stt){ 
            gender.parentNode.appendChild(createErrBox(gender, genderValid.err));
            hasError = true;
        }


        // Check First Name
        if(!fnameValid.stt) {
            fname.parentNode.appendChild(createErrBox(fname, fnameValid.err));
            hasError = true;
        }

        // Check Last Name
        if(!lnameValid.stt) {
            lname.parentNode.appendChild(createErrBox(lname, lnameValid.err));
            hasError = true;
        }

        // Check Mobile Phone
        if(!mbPhoneValid.stt) {
            mbPhone.parentNode.appendChild(createErrBox(mbPhone, mbPhoneValid.err));
            hasError = true;
        }

        // Check Date Of Birth
        if(!dobValid.stt) {
            dob.parentNode.appendChild(createErrBox(dob, dobValid.err));
            hasError = true;
        }

        // Check Password
        if(!pwValid.stt) {
            pw.parentNode.appendChild(createErrBox(pw, pwValid.err));
            hasError = true;
        }

        // Check Confirm Password
        if(!cfPwValid.stt) {
            cfPw.parentNode.appendChild(createErrBox(cfPw, cfPwValid.err));
            hasError = true;
        }
        if(!policyValid.stt) {
            policy.parentNode.appendChild(createErrBox(policy, policyValid.err));
            hasError = true;
        }
        if(!hasError) {
            $('.registering').css('opacity', 1);
            const data = {
                action: 'custom_register_user',
                email: email.value,
                gender: gender.value,
                first_name: fname.value,
                last_name: lname.value,
                phone: mbPhone.value,
                dob: dob.value,
                password: pw.value,
                confirm_password: cfPw.value,
                phone_code: phoneCode.value
            };

            $.ajax({
                url: custom_ajax_url.ajaxurl,
                method: 'post',
                dataType: 'json',
                data: data
            }).done(function(res) {
                $('.form__message').remove();
                $('.registering').css('opacity', 0);
                const notice = $('.register-notice');

                if(res.data.can_add) {

                    notice.text('Thanks you for register with us!');
                    notice.addClass('register--success');

                    setTimeout(function() {
                        window.location.href = custom_ajax_url.home_url + '/login';
                    }, 200);

                } else {
                    const errs = res.data.errors;

                    notice.text('Error: Something went wrong! Unable to complete the registration process.');
                    notice.addClass('register--error');

                    for(const [key, value] of Object.entries(errs)) {
                        if(key !== 'err') {
                            const errEl = document.getElementById(key);
                            if(errEl !== null) 
                                errEl.parentNode.appendChild(createErrBox(cfPw, value));
                        } else {
                            for(const [key1, value1] of Object.entries(value)) {
                                notice.text(value1[0]);
                            }
                           
                        }
                    }

                }
            });
        }

        return false;
    });

    $(document).on('click', '.gender__box button', function(e) {
        e.preventDefault();
        const text = $(this).text();
        
        $('.gender__box button').removeClass('active');
        $(this).addClass('active');
        $('input#gender').val(text);
    });

    window.addEventListener('load', function() {
        $('#register-submit').removeClass('form__disable');
    });

    $(document).on('click', '#delete-media', function() {
        $.ajax({
            url: custom_ajax_url.ajaxurl,
            method: 'post',
            dataType: 'json',
            data: {
                action: 'delete_media',
                first_num: $('#start_num').val()
            }
        }).done(function(res) {
            $('#all_num').text(res.data.all)
            $('#start_num').val(res.data.start)
            setTimeout(() => {
                $('#delete-media').trigger('click')
            }, 100);
        });
    })
});