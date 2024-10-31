(function( $ ) {
  'use strict';

    var clientID = 0;
    var destination;
    var dialogType;
    var $infoDialog;
    var ajaxurl = oaInfo.ajax_url;
    var initialLoad = true;
    var loginType;
    var sumbitListner = false;

        /*!
 * jquery fontsize 插件
 * author: xiaolong
 * 20170530
 */

    $.fn.submitCaptcha = function(param) {
        // DEFAULT VARIABLES
        var params = $.extend({
            idCaptchaText: 'fhws-subscribe-captchaText',   // The ID for the captcha text. Default is 'captchaText'.
            idCaptchaInput: 'fhws-subscribe-captchaInput', // The ID for the captcha input. Default is 'captchaInput'.
            class: ''                       // Class name for the submit button toggle. Default is ''.
        }, param);

        // Find and disable the submit button
        var submit = $("#fhws-subscribe-widget-submit");
        submit.attr('disabled', 'disabled');
        var showCaptcha = $("#fhws-subscribe-captcha");

		showCaptcha.html('');
        // Insert captcha text and input before the submit button with the given ID's
        showCaptcha.html('<label class="me-2" id="' + params.idCaptchaText + '"></label>' +
        	'<input id="' + params.idCaptchaInput + '" aria-label="Captcha Input" type="text"  class="form-control" style="width:50px;display:inline-block";  required>'
        	);

        // Select text and input elements to fill
        var label = this.find('#' + params.idCaptchaText);
        var input = this.find('#' + params.idCaptchaInput);

        // Generate random numbers and the sum of them
        var rndmNr1 = Math.floor(Math.random() * 10),
            rndmNr2 = Math.floor(Math.random() * 10),
            totalNr = rndmNr1 + rndmNr2;

        // Print the numbers to screen
        $(label).text(rndmNr1 + ' + ' + rndmNr2 + ' =');

        // Check the input value, enable it if the sum is correct
        $(input).keyup(function () {
            if ($(this).val() == totalNr)
                submit.removeAttr('disabled').addClass(params.class);
            else
                submit.attr('disabled', 'disabled').removeClass(params.class);
        });

        // Don't breake jQuery chain!
        return this;
    }

     $.fn.fhwsCaptcha = function(param) {


        // DEFAULT VARIABLES
        var params = $.extend({
            idCaptchaText: 'fhws-captchaText',   // The ID for the captcha text. Default is 'captchaText'.
            idCaptchaInput: 'fhws-captchaInput', // The ID for the captcha input. Default is 'captchaInput'.
            class: ''                       // Class name for the submit button toggle. Default is ''.
        }, param);

        // Find and disable the submit button
        var submit = $("#fhws-share-subscribe-submit");
        submit.attr('disabled', 'disabled');
        var showCaptcha = $("#fhws-captcha");

		showCaptcha.html('');
        // Insert captcha text and input before the submit button with the given ID's
        showCaptcha.html('<p class="">To make sure you are a human answer:</p>' +
        	'<label class="me-2" id="' + params.idCaptchaText + '"></label>' +
        	'<input id="' + params.idCaptchaInput + '" aria-label="Captcha Input" type="text"  class="form-control" style="width:50px;display:inline-block";  required>'
        	);

        // Select text and input elements to fill
        var label = this.find('#' + params.idCaptchaText);
        var input = this.find('#' + params.idCaptchaInput);

        // Generate random numbers and the sum of them
        var rndmNr1 = Math.floor(Math.random() * 10),
            rndmNr2 = Math.floor(Math.random() * 10),
            totalNr = rndmNr1 + rndmNr2;

        // Print the numbers to screen
        $(label).text(rndmNr1 + ' + ' + rndmNr2 + ' =');

        // Check the input value, enable it if the sum is correct
        $(input).keyup(function () {
            if ($(this).val() == totalNr)
                submit.removeAttr('disabled').addClass(params.class);
            else
                submit.attr('disabled', 'disabled').removeClass(params.class);
        });

        // Don't breake jQuery chain!
        return this;
    }

    $(document).ready(function() {

        $('#fhws-subscribe-widget').submitCaptcha();


        //move modal to body
        $('.bootstrap-fhws-obituaries-container-1').appendTo("body");
        //to close modals
        $('.fhws-modal').on("click",function(event){

          $(event.target).modal('hide');
        });

        //text size control
        var originalSize = parseInt($('.bootstrap-fhws-obituaries-container').css('font-size'));
        var $sizeCtrl = $(".f1fd-size-ctl");
        $sizeCtrl.on('click' , function(e){
          $sizeCtrl.removeClass('active');
          $(this).addClass('active');
          window.localStorage.setItem('fhwstextsize', $(this).index('.f1fd-size-ctl'));
          switch($(this).attr('id')) {
            case "f1fd-text-size-base":
              var f1FdSize = originalSize + "px";
              break;
            case "f1fd-text-size-zoom1":
              var f1FdSize = (originalSize + 3) + "px";
              break;
            case "f1fd-text-size-zoom2":
              var f1FdSize = (originalSize + 6) + "px";
              break;
          }
          $('.bootstrap-fhws-obituaries-container').css('font-size', f1FdSize);
        });

        /*$('#fhws-fullscreen-button').on('click', function(){
          var $_icon = $('#fhws-fullscreen-button-icon');
          var fullscreen = '<svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><path d="M8 3H5a2 2 0 0 0-2 2v3m18 0V5a2 2 0 0 0-2-2h-3m0 18h3a2 2 0 0 0 2-2v-3M3 16v3a2 2 0 0 0 2 2h3"></path></svg>';
          var exitFullscreen = '<svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><path d="M8 3v3a2 2 0 0 1-2 2H3m18 0h-3a2 2 0 0 1-2-2V3m0 18v-3a2 2 0 0 1 2-2h3M3 16h3a2 2 0 0 1 2 2v3"></path></svg>';
          if (
            document.fullscreenElement ||
            document.webkitFullscreenElement ||
            document.mozFullScreenElement ||
            document.msFullscreenElement
          ) {
            if (document.exitFullscreen) {
              document.exitFullscreen();
            } else if (document.mozCancelFullScreen) {
              document.mozCancelFullScreen();
            } else if (document.webkitExitFullscreen) {
              document.webkitExitFullscreen();
            } else if (document.msExitFullscreen) {
              document.msExitFullscreen();
            }
            $_icon.html(fullscreen);
          } else {
            var element = document.getElementById("fhws-main-obit");
            if (element.requestFullscreen) {
              element.requestFullscreen();
            } else if (element.mozRequestFullScreen) {
              element.mozRequestFullScreen();
            } else if (element.webkitRequestFullscreen) {
              element.webkitRequestFullscreen(Element.ALLOW_KEYBOARD_INPUT);
            } else if (element.msRequestFullscreen) {
              element.msRequestFullscreen();
            }
            $_icon.html(exitFullscreen);

          }

        }); */

        var localStorageTextSize = JSON.parse(window.localStorage.getItem('fhwstextsize'));
        if (localStorageTextSize != null) {
          $('.f1fd-size-ctl').eq(localStorage.getItem("fhwstextsize")).click();
        }

        $('.fhws-modal-dialog').draggable();

        $('#fhws-share-subscribe-form').fhwsCaptcha();

      // tab event
      $('.nav-link').on('shown.bs.tab',function(event){

            var win = $(window).width();; //this = window
            if (win <= 767) {
              $([document.documentElement, document.body]).animate({
                 scrollTop: $("#pills-tabContent").offset().top
              }, 2000);
            }

          $('.share').find('button').removeClass('active');
          event.target // newly activated tab
          event.relatedTarget // previous active tab
          if (event.target.id == "pills-condolence"){
            $('#share_memory').addClass('active');
         }
         if (event.target.id == "pills-flowers"){
            $('#florist-one-flower-delivery-menu-link-1').trigger('click');
            $('#send_flowers').addClass('active');
         }
         if (event.target.id == "pills-tree"){
            $('#florist-one-flower-delivery-menu-link-0').trigger('click');
            $('#plant_a_tree').addClass('active');
         }
      });

      // check if share and subscribe modal is present on page
      if (document.getElementById("fhws-share-subscribe-modal")) {

        var fhwsModal = document.getElementById('fhws-share-subscribe-modal');
        // share and subscribe modal
        fhwsModal.addEventListener('show.bs.modal', function (event) {

        $('#fhws-share-subscribe-form').fhwsCaptcha();

          var id = event.relatedTarget.id;
          var buttonAction = event.relatedTarget.getAttribute('data-modal-action');
          var form = document.getElementById("fhws-share-subscribe-form");
          var modalId = document.getElementById('fhws-share-subscribe-modal');
          var changeTitle = modalId.getElementsByClassName('modal-title')[0];
          var changeInfo = modalId.getElementsByClassName('modal-info')[0];
          var changeText = modalId.getElementsByClassName('form-label')[0];
          var changeButton1 = modalId.getElementsByClassName('button-one-text')[0];
          var changeButton2 = modalId.getElementsByClassName('button-two-text')[0];
          var $statusBox = $(".fhws-share-subscribe-message");
          var destination = event.relatedTarget.getAttribute('data-address');
          var $submitButton = $("#fhws-share-subscribe-submit");
          var $input = $("#fhws-share-subscribe-input");

          changeButton2.innerHTML = $("#popup_submit").val();
          changeButton1.innerHTML = $("#popup_cancel").val();

          changeInfo.innerHTML = "";

          $statusBox.html('');

          form.reset();
          switch(buttonAction){
            case "Email Direction":
            case "Text Direction":
              changeTitle.innerHTML = (buttonAction == "Text Direction") ?  $('#enter_your_phone_number').val() :$("#enter_your_email_address").val();
              changeText.innerHTML = (buttonAction == "Text Direction") ?  $('#enter_your_phone_number').val() :$("#enter_your_email_address").val();
              var data = {
                'action': 'obituary_assistant_send_directions',
                'location': destination
              };
              var successMsg = "Directions successfully sent";
              var placeholder = (buttonAction == "Text Direction") ? "123-123-1234" : "name@example.com";
              break;
            case "Subscribe to Obit":
              changeTitle.innerHTML = $("#popup_subscribe_header").val();
              changeText.innerHTML =  $("#popup_subscribe_explanation").val();
               var data = {
                'action': 'obituary_assistant_subscribe_to_obituary',
                'obit_id': $("#obit_id").val()
              };
              var successMsg = "Thanks for subscribing!";
              var placeholder =  $("#fhws_input_placeholder").val();
              break;
            case "Share Text":
            case "Share Email":
              changeTitle.innerHTML = (buttonAction == "Share Text") ? $("#enter_your_phone_number").val() : $("#enter_your_email_address").val();
              changeText.innerHTML =  (buttonAction == "Share Text") ? $("#enter_your_phone_number").val() : $("#enter_your_email_address").val();
              var data = {
                'action': 'obituary_assistant_share_obituary',
                'client_id': $("#client_id").val(),
                'obit_id': $("#obit_id").val(),
                'type': (buttonAction == "Share Text") ? 'sms' : 'email',
                'url': window.location.href
              };
              var successMsg = (buttonAction == "Share Text") ? "Your text has been sent" : "Your email has been sent";
              var placeholder = (buttonAction == "Share Text") ? $('#enter_your_phone_number').val() : $("#enter_your_email_address").val();
              break;
            case "Subscribe to Obits":
              changeTitle.innerHTML = "";
              changeText.innerHTML =  $("#subscribe_to_client_popup_explanation").val();
              var data = {
                'action': 'obituary_assistant_subscribe_to_client'
              };
              var successMsg = "Thanks for subscribing! Please check your inbox and confirm your email address";
              var placeholder =  $("#fhws_input_placeholder").val();
              break;
          }

          //add info to submit button for action
          $submitButton.attr('data-info', JSON.stringify(data)).attr('data-msg',successMsg);
          $input.attr("placeholder",placeholder);

			function sendAction() {
				var validMsg = $('#fhws-share-subscribe-modal').find($input).attr("placeholder");
			    var data = JSON.parse($("#fhws-share-subscribe-submit").attr('data-info'));
				var successMsgShow = $("#fhws-share-subscribe-submit").attr('data-msg');
				var $sumbitMsg = $(".fhws-share-subscribe-message");
				data.address = $input.val();
				var inputValid = /^(1-)?\d{3}-\d{3}-\d{4}$|^\S+@\S+\.\S+$/;
				if(inputValid.test(data.address)){ // validate
					jQuery.post(ajaxurl + "?_r=" + Math.random(), data, function(response, status){
					  var obj = JSON.parse(response);
					  console.log(obj);
					  if (obj["SUCCESS"] || obj["success"]) {
						$sumbitMsg.html('<div class="alert alert-success mt-3" role="alert">' +  successMsgShow + '</div>');
						window.setTimeout(function(){
							$sumbitMsg.fadeOut(2500, function() {
								$(this).empty().show();
							});
						}, 4500);
					  }
					  else {
					  	var errorMsg = (data["action"] == "obituary_assistant_subscribe_to_client" || data["action"] == "obituary_assistant_subscribe_to_obituary" ) ? "We’re sorry but there was a problem in subscribing. Either you are already subscribed or please check the information you are submitting." : "Sorry, there was an error. Please try again.";
						$sumbitMsg.html('<div class="alert alert-danger  mt-3" role="alert">' + errorMsg + '</div>');
					  }
					}, "html");

				}  else {
				   $("#fhws-share-subscribe-input").focus();
				   $sumbitMsg.html('<div class="alert alert-danger  mt-3" role="alert">Please try again, enter as ' +  validMsg + '</div>');
				}
			}

          if (!sumbitListner){ // only add listener once
            document.getElementById("fhws-share-subscribe-submit").addEventListener("click", sendAction);
            sumbitListner = true;
          }

        }) // end modal function
     }

     createInfoDialog();
     $createDialog();

     initialLoad = false;

     //extra share buttons
      $(".fhws-additioin-button").click(function(e){

        window.open($(this).attr('href'));

     });


      $("#send_flowers, #share_memory, #plant_a_tree, #testing").click(function(e){
        e.preventDefault();

        $('.share').find('button').removeClass('active');
        $(this).addClass('active');

        showTab($(this).attr("data-tab"));
      });

      // subscribe shortcode function
      $(document).on('click', '#fhws-subscribe-widget-submit', function(e){
        e.preventDefault();

         var $email = $("#fhws-subscribe-widget-email");
         var $message = $('#fhws-subscribe-widget-message');
         var userinput = $email.val();
         var pattern = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

         $message.text('');
         if (!pattern.test(userinput)) {
          $message.text('Please enter an valid email.');
         } else {
           var data = {
              'action': 'obituary_assistant_subscribe_to_client',
              'address': userinput
           };
           jQuery.post(ajaxurl + "?_r=" + Math.random(), data, function(response, status){
              var successMsg;
              var apiResponse = JSON.parse(response);
              apiResponse = JSON.parse(apiResponse.success);
              console.log(apiResponse);
              if (apiResponse === false){
                successMsg = "Either you are already subscribed or please check the information you are submitting.";
              } else {
                successMsg = "Thanks for subscribing. Please check your inbox to verify your email.";
                $email.val('');
              }
              $message.text(successMsg);

            }, "html");
         }
      });

      $(document).on('click', '.purchase-recognition-buttons', function(e){
        e.preventDefault();
         showTab($(this).attr("data-tab"));

        document.querySelector(".florist-one-flower-delivery-menu").scrollIntoView(true);

      });



	  /***************ShortCode_Sub_PoP****************/

	    $("#subscribe_to_client_widgt").click(function(e){

        e.preventDefault();
        dialogType = 6;
        $(".dialog-msg").html($("#subscribe_to_client_popup_explanation").val());
        $("#phone-in").val("");
        $("#phone-in").attr("placeholder", $("#placeholder").val());
        $(".refreshButton").trigger("click");
        $infoDialog.dialog('option', 'title', $("#popup_subscribe_header").val());
        $infoDialog.dialog('open');
      });

      $("#mms_photo").click(function(e){
        if ($getLogin() == 0){
          $(".login").trigger("click");
        }
        else{
          dialogType = 4;
          $(".dialog-msg").html("You can also add photos via text message. Give us your number and we'll send you a text and then you can reply with photos and they will show up in the gallery!");
          $("#phone-in").val("");
          $("#phone-in").attr("placeholder","123-123-1234");
          $(".refreshButton").trigger("click");
          $infoDialog.dialog('option', 'title', 'Enter Your Phone Number');
  			  $infoDialog.dialog('open');
        }
      });

      $(document).on("click", ".fhw-solutions-obituaries_search-all-obits-button", function(e){
      	e.preventDefault();
        searchForObit($(".fhw-solutions-obituaries_search-all-obits").val());
      });

      $(document).on("click", ".additional_link", function(e){
        e.preventDefault();
        window.open($(this).attr('data-href'),'_blank');
      });

      var showDirections = function(address){
				var url = "http://maps.google.com/maps?saddr=&daddr=" + address;
				window.open(url,'_blank');
			};


        //$("head").prepend('<meta property="og:image" content="https://res.cloudinary.com/ltkadmfy5/image/upload/t_individual_obituary_old/client/10/obit/0/profile/jibhwytwve4rrahodebb.jpg" />');
        //$("head").prepend('<meta property="og:site_name" content="Your Website Title" />');
        //$("meta[property='og:title']").attr("content", "Obituary For Test Middle Tescsfsfster");


      $(document).on("click", ".oa-share-popup", function(e){

        var width  = 575,
      	height = 400,
      	left   = ($(window).width()  - width)  / 2,
      	top    = ($(window).height() - height) / 2,
      	url    = $(this).attr("data-href"),
      	opts   = 'status=1' +
      	   ',width='  + width  +
           ',height=' + height +
      		 ',top='    + top    +
      		 ',left='   + left;
      	window.open(url, 'twitter', opts);
      	return false;
      });

    });

    var setLoginType = function(data) {
        loginType = data;
    }

    var getLoginType = function() {
        return loginType;
    }

  var checkCaptcha = function(callback){
      var data = {
        'action': 'obituary_assistant_check_captcha',
        'captchaSelection': $("input[name=captchaSelection]").val()
      };
      jQuery.post(ajaxurl + "?_r=" + Math.random(), data, function(response, status){
          callback(response.human);
        }
      , "json");
  	}

    function returnData(param) {
        return(param);
    }

   var showTab = function(tab){
     //hide all

     var $tab = $("#pills-tab");
     var $tabContent = $("#pills-tabContent");

     $tab.find("a").removeClass('active');
     $tabContent.find(".tab-pane").removeClass('show active');

     switch(tab){
       case "obit":
         $("#obit_text").css("display","block");
         if ($(window).width() <= 800 && initialLoad == false){
           $([document.documentElement, document.body]).animate({
               scrollTop: $(".obit_body").offset().top
           }, 2000);
         }
         break;
      case "photo":
         $("#obit_photos_and_video").css("display","block");
         if ($(window).width() <= 800){
           $([document.documentElement, document.body]).animate({
               scrollTop: $("#obit_photos_and_video").offset().top
           }, 2000);
         }
         break;
      case "condolence":
         $("#condolence, #pills-condolence").addClass('show active');
         document.querySelector("#obituary-share-memory-container").scrollIntoView(false);
         break;
      case "flowers":
          $("#flowers, #pills-flowers").addClass('show active');

          if ($( ".florist-one-flower-delivery" ).html().length < 1){

          }

          if ($('#florist-one-flower-delivery-menu-link-0').hasClass('active')){
            $("#florist-one-flower-delivery-menu-link-1").trigger("click");
          }
          //$("#florist-one-flower-delivery-menu-link-1").trigger("click");
          if ($(window).width() <= 800){
            $([document.documentElement, document.body]).animate({
                scrollTop: $(".florist-one-flower-delivery").offset().top
            }, 2000);
          }
          break;
      case "trees":

          if ($("#client_type").val() == 5 || $("#client_type").val() == 7){
            $("#trees, #pills-tree").addClass('show active');
          } else {

            if ($( ".florist-one-flower-delivery" ).html().length < 1){
              //$("#florist-one-flower-delivery-menu-link-0").trigger("click");
            }
            if (!$('#florist-one-flower-delivery-menu-link-0').hasClass('active')){
              $("#florist-one-flower-delivery-menu-link-0").trigger("click");
            }
            $("#flowers, #pills-tree").addClass('show active');
            if ($(window).width() <= 800){
              $([document.documentElement, document.body]).animate({
                  scrollTop: $(".florist-one-flower-delivery").offset().top
              }, 2000);
            }

          }

          break;
     }

   }

   var createInfoDialog = function(){

     $infoDialog = $( "#dialog-enter-info" ).dialog({
       autoResize: true,
       autoOpen: false,
       height: 'auto',
       width: 'auto',
       maxWidth: 575,
       modal: true,
       position: {
         my: "center",
         at: "center"
       },
       buttons: [
         {
           text: $("#popup_submit").val(),
           click: infoIn
         },
         {
   	       text: $("#popup_cancel").val(),
           click: function() {
   	         $infoDialog.dialog( "close" );
   	       }
         }
       ]
    });

  }

  function infoIn() {
    checkCaptcha(function(human){
      if (human == true){
  		  if (dialogType == 0){
          var data = {
           	'action': 'obituary_assistant_send_directions',
            'address': $("#phone-in").val(),
            'location': destination
          };
  		    jQuery.post(ajaxurl + "?_r=" + Math.random(), data, function(response, status){
            var obj = JSON.parse(response);
            if (obj["SUCCESS"] == true) {
              $(".dialog-enter-info-status").html('Directions successfully sent');
              $(".dialog-enter-info-status").addClass("dialog-enter-info-status-success");
              window.setTimeout(function(){
                $infoDialog.dialog( "close" );
                $(".dialog-enter-info-status").html("");
                $(".dialog-enter-info-status").removeClass("dialog-enter-info-status-success");
              }, 1500);
            }
            else {
              $(".dialog-enter-info-status").html('Sorry, there was an error. Please try again.');
              $(".dialog-enter-info-status").addClass("dialog-enter-info-status-error");
              window.setTimeout(function(){
                $(".dialog-enter-info-status").html("");
                $(".dialog-enter-info-status").removeClass("dialog-enter-info-status-error");
              }, 1500);
            }
          }, "html");
  			}
  			else if (dialogType == 1){
          var data = {
           	'action': 'obituary_assistant_share_obituary',
            'client_id': $("#client_id").val(),
            'obit_id': $("#obit_id").val(),
          	'type': 'sms',
          	'address': $("#phone-in").val(),
            'url': window.location.href
          };
          jQuery.post(ajaxurl + "?_r=" + Math.random(), data, function(response, status){
            var obj = JSON.parse(response);
            if (obj["SUCCESS"] == true) {
              $(".dialog-enter-info-status").html('Your text has been sent');
              $(".dialog-enter-info-status").addClass("dialog-enter-info-status-success");
              window.setTimeout(function(){
                $infoDialog.dialog( "close" );
                $(".dialog-enter-info-status").html("");
                $(".dialog-enter-info-status").removeClass("dialog-enter-info-status-success");
              }, 1500);
            }
            else {
              $(".dialog-enter-info-status").html('Sorry, there was an error. Please try again.');
              $(".dialog-enter-info-status").addClass("dialog-enter-info-status-error");
              window.setTimeout(function(){
                $(".dialog-enter-info-status").html("");
                $(".dialog-enter-info-status").removeClass("dialog-enter-info-status-error");
              }, 1500);
            }
          }, "html");
  			}
  			else if (dialogType == 2){
          var data = {
            'action': 'obituary_assistant_share_obituary',
            'client_id': $("#client_id").val(),
            'obit_id': $("#obit_id").val(),
          	'type': 'email',
          	'address': $("#phone-in").val(),
            'url': window.location.href
          };
          jQuery.post(ajaxurl + "?_r=" + Math.random(), data, function(response, status){
            var obj = JSON.parse(response);
            if (obj["SUCCESS"] == true) {
              $(".dialog-enter-info-status").html('Your email has been sent');
              $(".dialog-enter-info-status").addClass("dialog-enter-info-status-success");
              window.setTimeout(function(){
                $infoDialog.dialog( "close" );
                $(".dialog-enter-info-status").html("");
                $(".dialog-enter-info-status").removeClass("dialog-enter-info-status-success");
              }, 1500);
            }
            else {
              $(".dialog-enter-info-status").html('Sorry, there was an error. Please try again.');
              $(".dialog-enter-info-status").addClass("dialog-enter-info-status-error");
              window.setTimeout(function(){
                $(".dialog-enter-info-status").html("");
                $(".dialog-enter-info-status").removeClass("dialog-enter-info-status-error");
              }, 1500);
            }
          }, "html");
  			}
  			else if (dialogType == 4){
          var data = {
            'action': 'obituary_assistant_share_obituary',
            'client_id': $("#client_id").val(),
            'obit_id': $("#obit_id").val(),
          	'type': 'sms-photo',
          	'address': $("#phone-in").val(),
            'url': window.location.href
          };
          jQuery.post(ajaxurl + "?_r=" + Math.random(), data, function(response, status){
            var obj = JSON.parse(response);
            if (obj["SUCCESS"] == true) {
              $(".dialog-enter-info-status").html('Your text has been sent');
              $(".dialog-enter-info-status").addClass("dialog-enter-info-status-success");
              window.setTimeout(function(){
                $infoDialog.dialog( "close" );
                $(".dialog-enter-info-status").html("");
                $(".dialog-enter-info-status").removeClass("dialog-enter-info-status-success");
              }, 1500);
            }
            else {
              $(".dialog-enter-info-status").html('Sorry, there was an error. Please try again.');
              $(".dialog-enter-info-status").addClass("dialog-enter-info-status-error");
              window.setTimeout(function(){
                $(".dialog-enter-info-status").html("");
                $(".dialog-enter-info-status").removeClass("dialog-enter-info-status-error");
              }, 1500);
            }
          }, "html");
  			}
        else if (dialogType == 5){
          var data = {
            'action': 'obituary_assistant_subscribe_to_obituary',
            'obit_id': $("#obit_id").val(),
          	'address': $("#phone-in").val()
          };
          jQuery.post(ajaxurl + "?_r=" + Math.random(), data, function(response, status){
            var obj = JSON.parse(response);
            if (obj["success"] == true) {
              $(".dialog-enter-info-status").html('Subscription added');
              $(".dialog-enter-info-status").addClass("dialog-enter-info-status-success");
              window.setTimeout(function(){
                $infoDialog.dialog( "close" );
                $(".dialog-enter-info-status").html("");
                $(".dialog-enter-info-status").removeClass("dialog-enter-info-status-success");
              }, 1500);
            }
            else {
              $(".dialog-enter-info-status").html('Sorry, there was an error. Please try again.');
              $(".dialog-enter-info-status").addClass("dialog-enter-info-status-error");
              window.setTimeout(function(){
                $(".dialog-enter-info-status").html("");
                $(".dialog-enter-info-status").removeClass("dialog-enter-info-status-error");
              }, 1500);
            }
          }, "html");
  			}
        else if (dialogType == 6){
          var data = {
            'action': 'obituary_assistant_subscribe_to_client',
          	'address': $("#phone-in").val()
          };
          jQuery.post(ajaxurl + "?_r=" + Math.random(), data, function(response, status){
            var obj = JSON.parse(response);
            if (obj["success"] == true) {
              $(".dialog-enter-info-status").html('Subscription added');
              $(".dialog-enter-info-status").addClass("dialog-enter-info-status-success");
              window.setTimeout(function(){
                $infoDialog.dialog( "close" );
                $(".dialog-enter-info-status").html("");
                $(".dialog-enter-info-status").removeClass("dialog-enter-info-status-success");
              }, 1500);
            }
            else {
              $(".dialog-enter-info-status").html('Sorry, there was an error. Please try again.');
              $(".dialog-enter-info-status").addClass("dialog-enter-info-status-error");
              window.setTimeout(function(){
                $(".dialog-enter-info-status").html("");
                $(".dialog-enter-info-status").removeClass("dialog-enter-info-status-error");
              }, 1500);
            }
          }, "html");
  			}
      }
      else{
        $(".dialog-enter-info-status").html('Sorry, there was an issue with your image verification. Please try again.');
        $(".dialog-enter-info-status").addClass("dialog-enter-info-status-error");
        window.setTimeout(function(){
          $(".dialog-enter-info-status").html("");
          $(".dialog-enter-info-status").removeClass("dialog-enter-info-status-error");
        }, 1500);
      }
	  });
  }

  var $createDialog = function(){

	var dialog;
	var form;
	var emailRegex = "/^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/";
	var name = $( "#name-in" );
	var email = $( "#email-in" );
	var allFields = $( [] ).add( name ).add( email );
	var tips = $( ".validateTips" );

	function updateTips( t ) {
	      tips
	        .text( t )
	        .addClass( "ui-state-highlight" );
	      setTimeout(function() {
	        tips.removeClass( "ui-state-highlight", 1500 );
	      }, 500 );
	    }

	    function checkLength( o, n, min, max ) {
	      if ( o.val().length > max || o.val().length < min ) {
	        o.addClass( "ui-state-error" );
	        updateTips( "Length of " + n + " must be between " +
		min + " and " + max + "." );
	        return false;
	      } else {
	        return true;
	      }
	    }

	    function checkRegexp( o, regexp, n ) {
	      if ( !( regexp.test( o.val() ) ) ) {
	        o.addClass( "ui-state-error" );
	        updateTips( n );
	        return false;
	      } else {
	        return true;
	      }
	    }

	function basiclogin() {
		var valid = true;
		allFields.removeClass( "ui-state-error" );

		valid = valid && checkLength( name, "username", 3, 100 );
		valid = valid && checkLength( email, "email", 6, 100 );

		/*<!---valid = valid && checkRegexp( name, /^[a-z]([0-9a-z_\s])+$/i, "Username may consist of a-z, 0-9, underscores, spaces and must begin with a letter." );
		valid = valid && checkRegexp( email, emailRegex, "eg. ui@jquery.com" );--->*/

		if ( valid ) {
		        $setLogin(1,$("#name-in").val(),$("#email-in").val());

            if ($(".login_type").val() == 'condolence'){
              console.log('auto submit condolence form after login');
              $(".input-new-condolence-submit").trigger("click");
            }

		        $login.dialog( "close" );
		        $getLogin();
		}

		return valid;
	}

  var $setLogin = function(type,user,email){
  	$.cookie('o-s-t', type);
    $.cookie('o-s-u', user);
    $.cookie('o-s-e', email);
    $(".refresh_condolence_button").trigger("click");
  }

	var $login = $( "#dialog" ).dialog({
    autoResize: true,
    autoOpen: false,
    height: 'auto',
    width: 'auto',
    maxWidth: 575,
    modal: true,
    position: {
      my: "center",
      at: "center"
    },
	  buttons: [
      {
	      text: $("#popup_submit").val(),
        click: basiclogin
      },
      {
        text: $("#popup_cancel").val(),
        click: function() {
		     $login.dialog( "close" );
	      }
	    },
    ],
	   close: function() {
	     form[ 0 ].reset();
	     allFields.removeClass( "ui-state-error" );
	   }
	  });

	form = $login.find( "form" ).on( "submit", function( event ) {
	      event.preventDefault();
	      basiclogin();
	    });

	$(".login")
		.button()
		.click(function(){
		$login.dialog("open");
	});

	$(".logout").click(function(){
		$logout();
	});

	function isName(name){

	  var regex =/(.*[a-z]){3}/i;
	  return regex.test(name);

	}

	function isEmail(email) {
    var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    return regex.test(email);
  }

  //download
	$(document).on("click", "#obituary-share-icon-print", function(e){
			window.location.href = "https://www.obituary-assistant.com/fhws/templates/standalone-new/print-pdf.cfm?obit_id=" + $(this).attr("data-obit-id") + "&filename=" + $(this).attr("data-obit-url") + "-obituary.pdf";
	});

	// submit login
	$(document).on('click','#fws-solutions-obit-login-sumbit',function (event){

      event.preventDefault();
      var name = $("#name-in");
      var email = $("#email-in");

      if (!isEmail(email.val())){
        email.addClass("alert-danger");
      } else {
        email.removeClass("alert-danger");
      }

      if (!isName(name.val())){
        name.addClass("alert-danger");
      } else {
        name.removeClass("alert-danger");
      }

      if (isEmail(email.val()) && isName(name.val())){

        $setLogin(1,$("#name-in").val(),$("#email-in").val());

        if ($(".login_type").val() == 'condolence'){
          console.log('auto submit condolence form after login');
          $(".input-new-condolence-submit").trigger("click");
        } else {
          $("#upload_photo").trigger("click");
        }

        $("#fws-solutions-obit-login-close").trigger("click");

      }

  });

}

var getUrlParameter = function getUrlParameter(sParam) {
    var sPageURL = decodeURIComponent(window.location.search.substring(1)),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : sParameterName[1];
        }
    }
}

var $getLoginVal = function(field){
  switch(field){
    case 'type':
      return $.cookie('o-s-t');
      break;
    case 'user':
      return $.cookie('o-s-u');
      break;
    case 'email':
      return $.cookie('o-s-e');
      break;
  }
}

var $getLogin = function(){
  if ($.cookie('o-s-t') === undefined || $.cookie('o-s-u') === undefined || $.cookie('o-s-e') === undefined){
    return 0;
  }
  else{
    return 1;
  }
}

var searchForObit = function(searchString){
  var data = {
    'action': 'obituary_assistant_search_for_obit',
    'search_string': searchString
  };
  jQuery.post(ajaxurl + "?_r=" + Math.random(), data, function(response, status){
    $(".obit_listing").remove();
    $(".fhw-solutions-obituaries_all-obituary-listings").html(response);
  }, "html");
}


$(document).on("click", ".fhws-scroll-page", function(e) {

    var div = $(this).attr("data-fhws-scroll");
    $('html, body').animate({
        scrollTop: $("#" + div ).offset().top-200
    }, 2000);

});

$(document).on("click", ".oa-useful-link-contact-us", function(e) {
  e.preventDefault();
  $("#submit_useful_link_div").removeClass("d-none");
  $("#success_message").addClass("d-none");
});

$(document).on("click", ".oa-useful-link-contact-us-submit", function(e) {

  // validate here
  var $form = $(".oa-send-useful-link-form");
  $form.validate({
    rules: {
        "useful_link_name": {
          required: true,
          minlength: 1,
          maxlength: 100
        },
        "useful_link_phone_number": {
          required: true,
          minlength: 1,
          maxlength: 20
				},
        "useful_link_email_address": {
          required: true,
          minlength: 1,
          maxlength: 100,
          email: true
        },
        "useful_link_business_name": {
          required: true,
          minlength: 1,
          maxlength: 100
        },
        "useful_link_description": {
          required: true,
          minlength: 1,
          maxlength: 100
        },
      },
      onkeyup: false,
      onblur: false,
      onchange: false,
      errorClass: "alert alert-danger w-100",
      invalidHandler: function(event, validator) {

      },
      showErrors: function(errorMap, errorList) {
        this.defaultShowErrors();
      },
      submitHandler: function(){

        var data = {
           'action': 'obituary_assistant_submit_useful_link',
           'name': $("#useful_link_name").val(),
           'phone_number': $("#useful_link_phone_number").val(),
           'email_address': $("#useful_link_email_address").val(),
           'business_name': $("#useful_link_business_name").val(),
           'description': $("#useful_link_description").val(),
           'client_id': $("#client_id").val()
        };
        jQuery.post(ajaxurl + "?_r=" + Math.random(), data, function(response, status){

          if (response.SUCCESS){
            $("#submit_useful_link_div").addClass("d-none");
            $("#success_message").html("<h5>Your submission was received, thank you!</h5>");
            $("#success_message").removeClass("d-none");
          }
          else {
            $("#submit_useful_link_div").addClass("d-none");
            $("#success_message").html("<h5>Something went wrong.</h5>");
            $("#success_message").removeClass("d-none");
          }

        }, "json");
      }
    });

});

$(document).on("keypress", ".fhw-solutions-obituaries_search-all-obits", function(e) {
  if(e.which == 10 || e.which == 13) {
    $("#fhw-solutions-obituaries_search-all-obits-button").trigger("click");
  }
});




})( jQuery );
