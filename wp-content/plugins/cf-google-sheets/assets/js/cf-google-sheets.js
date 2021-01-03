jQuery(document).ready(function () {
     
     /**
    * verify the api code
    * @since 1.0
    */
    jQuery(document).on('click', '#save-gs-code', function () {
        if (jQuery("#gs-code").val() == "") {
            jQuery("#gs-validation-message").empty();
            jQuery("<span class='error-message'>Access Code can't be blank</span>").appendTo('#gs-validation-message');
            return;
        }
        jQuery(".loading-sign").addClass("loading");
        var data = {
            action: 'verify_gs_integation',
            client: jQuery('#gs-client').val(),
            secret: jQuery('#gs-secret').val(),
            code: jQuery('#gs-code').val(),
            security: jQuery('#gs-ajax-nonce').val()
        };
        jQuery.post(ajaxurl, data, function (response ) {
            jQuery(".loading-sign").removeClass("loading");
            jQuery("#gs-validation-message").empty();
            jQuery("#gs-code").val(""); 
            if( ! response.success ) { 
                jQuery("<span class='error-message'>Failed to connect plugin to Google Sheets</span>").appendTo('#gs-validation-message');
                jQuery("#gs-connection-status").text("NOT CONNECTED");
            } else {
                jQuery("<span class='gs-valid-message'>Plugin was successfully connected to Google Sheets</span>").appendTo('#gs-validation-message');
                jQuery("#gs-connection-status").text("CONNECTED"); 
            }
      });
      
    });   
         
});
