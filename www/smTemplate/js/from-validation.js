<!-- FORM VALIDATION JAVASCRIPT  -->

jQuery(document).ready(function() {
    jQuery('form#contact_form').submit(function() {
        jQuery('form#contact_form .error').remove();
        var hasError = false;
        jQuery('.requiredField').each(function() {
            if(jQuery.trim(jQuery(this).val()) == '') {
                var labelText = jQuery(this).prev('label').text();
                jQuery(this).parent().append('<span class="error">Please complete the required fields.</span>');
                jQuery(this).addClass('inputError');
                hasError = true;
            } else if(jQuery(this).hasClass('email')) {
                var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
                if(!emailReg.test(jQuery.trim(jQuery(this).val()))) {
                    var labelText = jQuery(this).prev('label').text();
                    jQuery(this).parent().append('<span class="error">You entered an invalid email</span>');
                    jQuery(this).addClass('inputError');
                    hasError = true;
                }
            }
        });
        if(!hasError) {
            jQuery('form#contact_form input.submit').fadeOut('normal', function() {
                jQuery(this).parent().append('');
            });
            var formInput = jQuery(this).serialize();
            jQuery.post(jQuery(this).attr('action'),formInput, function(data){
                jQuery('form#contact_form').slideUp("fast", function() {
                    jQuery(this).before('<p class="success">Thanks! Your email was successfully sent. We will contact you as soon as possible.</p>');
                });
            });
        }

        return false;

    });
});