function copyToClipboard(element) {
  jQuery(function($) {
    $('#dem').remove();
    var $temp = $("<input>");
    $("body").append($temp);
    $temp.val($(element).text()).select();
    document.execCommand("copy");
    $temp.remove();
    $(element).next().after('<span id="dem" style="padding:5px;display:inline-block">Shortcode copied</span>');
    $("#dem").fadeOut(3000, function() {
        $(this).remove();
    });
    
  });
}

(function( $ ) {
	'use strict';

	$(function(){

    var colorPickerInputs = $( '.fhw-solutions-obituaries_3-color-picker' );
  	$( '.fhw-solutions-obituaries_3-color-picker' ).wpColorPicker();

		$(document).ready(function(){

			$("#SubScription_Widget").click(function(){
				$(".Recent_Obituaries").hide();
				$(".SubScription_Widget").show();
			});
			$("#Recent_Obituaries").click(function(){
				$(".SubScription_Widget").hide();
				$(".Recent_Obituaries").show();
			});

			$('input[name="fhw-solutions-obituaries_3[products]"]').trigger("change");

			$( "#fhw-solutions-obituaries-admin-accordion" ).accordion({
	      collapsible: true,
				heightStyle: "content",
				create: function(event, ui){
					send_any_messages();
				}
	    });
	    
	    $("select[name='recent-obit-shortcode'").on('change', function(){
	      var count = $('#recent-obit-count').val();
	      var position = $('#recent-obit-pos').val();
	      var orientation = $('#recent-obit-ori').val();
	      $('#p1').text('[obituary-assistant-show-recent-obituaries position="' + position + '" orientation="' + orientation +'" count="' +  count +'"]');
	    });
	    
	    
			$(".options_1").validate({
				rules: {
					"fhw-solutions-obituaries_1[first_name]": {
						required: true,
						maxlength: 100
					},
					"fhw-solutions-obituaries_1[last_name]": {
						required: true,
						maxlength: 100
					},
					"fhw-solutions-obituaries_1[funeral_home_name]": {
						required: true,
						maxlength: 100
					},
					"fhw-solutions-obituaries_1[funeral_home_city]": {
						required: true,
						maxlength: 100
					},
					"fhw-solutions-obituaries_1[funeral_home_state]": {
						required: {
							param: true,
							depends: function(element) {
								if ($('select[name="fhw-solutions-obituaries_1[funeral_home_country]"]').val() == 'US' || $('select[name="fhw-solutions-obituaries_1[funeral_home_country]"]').val() == 'CA'){
									return true;
								}
								return false;
							}
						},
						maxlength: {
							param: 2,
							depends: function(element) {
								if ($('select[name="fhw-solutions-obituaries_1[funeral_home_country]"]').val() == 'US' || $('select[name="fhw-solutions-obituaries_1[funeral_home_country]"]').val() == 'CA'){
									return true;
								}
								return false;
							}
						},
					},
					"fhw-solutions-obituaries_1[funeral_home_country]": {
						required: true,
						maxlength: 2
					},
					"fhw-solutions-obituaries_1[funeral_home_zip]": {
						required: {
							param: true,
							depends: function(element) {
								if ($('select[name="fhw-solutions-obituaries_1[funeral_home_country]"]').val() == 'US' || $('select[name="fhw-solutions-obituaries_1[funeral_home_country]"]').val() == 'CA'){
									return true;
								}
								return false;
							}
						},
						maxlength: {
							param: 7,
							depends: function(element) {
								if ($('select[name="fhw-solutions-obituaries_1[funeral_home_country]"]').val() == 'US' || $('select[name="fhw-solutions-obituaries_1[funeral_home_country]"]').val() == 'CA'){
									return true;
								}
								return false;
							}
						},
					},
					"fhw-solutions-obituaries_1[funeral_home_website]": {
						required: true,
						maxlength: 100
					},
					"fhw-solutions-obituaries_1[funeral_home_email]": {
						required: true,
						maxlength: 100,
						email: true
					},
					"fhw-solutions-obituaries_1[funeral_home_description]": {
						required: true,
						minlength: 25,
						maxlength: 1000
					}
				},
				onkeyup: false,
				onblur: false,
				onchange: false,
				errorClass: "fhw-solutions-error",
				invalidHandler: function(event, validator) {
				},
				showErrors: function(errorMap, errorList) {
			    this.defaultShowErrors();
			  },
				submitHandler: function(form){
					$("button").attr('disabled', 'disabled');
					form.submit();
				}
			});

			$(".options_5").validate({
				rules: {
					"fhw-solutions-obituaries_1[username]": {
						required: true,
						maxlength: 32
					},
					"fhw-solutions-obituaries_1[password]": {
						required: true,
						maxlength: 32
					}
				},
				onkeyup: false,
				onblur: false,
				onchange: false,
				errorClass: "fhw-solutions-error",
				invalidHandler: function(event, validator) {
				},
				showErrors: function(errorMap, errorList) {
			    this.defaultShowErrors();
			  },
				submitHandler: function(form){
					$("button").attr('disabled', 'disabled');
					form.submit();
				}
			});

		});

		$(".sign-in").click(function(){
			$(".sign-in-form").css("display","block");
			$(".sign-up-form").css("display","none");
			$(".sign-in").css("display","none");
			$(".sign-up").css("display","block");
		});

		$(".sign-up").click(function(){
			$(".sign-in-form").css("display","none");
			$(".sign-up-form").css("display","block");
			$(".sign-in").css("display","block");
			$(".sign-up").css("display","none");
		});

		var send_any_messages = function(){
			if ( $("#fhw-solutions-obituaries_1-errors").val().length > 0 ){
				var errors = JSON.parse($("#fhw-solutions-obituaries_1-errors").val());
				for(var i=0;i<errors.length;i++){
					alert( errors[i] );
				}
			}
			var success_message = JSON.parse( $("#fhw-solutions-obituaries_1-success_message").val() );
			if ( success_message ){
				alert( success_message );
			}
		};

		$('select[name="fhw-solutions-obituaries_1[funeral_home_country]"]').on(
			"change",
			function(){
				if ($(this).val() != 'US' && $(this).val() != 'CA'){
					$('select[name="fhw-solutions-obituaries_1[funeral_home_state]"]').val("0");
					$('input[name="fhw-solutions-obituaries_1[funeral_home_zip]"]').val("No Zip / Postal Code");
				}
				else {
					if ($(this).val() == 'US'){
						$('select[name="fhw-solutions-obituaries_1[funeral_home_state]"]').val("AL");
					} 
					else{
						$('select[name="fhw-solutions-obituaries_1[funeral_home_state]"]').val("AB");
					}
					$('input[name="fhw-solutions-obituaries_1[funeral_home_zip]"]').val("");
				}
			}
		);


});
})( jQuery );
