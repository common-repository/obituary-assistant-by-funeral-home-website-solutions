(function( $ ) {
  'use strict';

  var ajaxurl = oaInfo.ajax_url;
  var partials = oaInfo.partials;
  var i = 0;


  var $postWallInit = function(){

      $('#fhw-solutions-obituries-modal').on('show.bs.modal', function (e) {

          if ($getLogin() != 0){//logged on already
             return e.preventDefault();
          }

      });

    $(".input-new-condolence-submit").click(function(e){

      if ($getLogin() == 0){
        $(".login_type").val('condolence');
      }
      else {
        var data = {
          'action': 'obituary_assistant_add_condolence',
          'obit_id': $("#obit_id").val(),
          'type': $getLoginVal('type'),
          'sender': $getLoginVal('user'),
          'message': $(".input-new-condolence").val(),
          'email': $getLoginVal('email'),
          'celebration_type': $("input[name=obituary-candle-choice]").val(),
          'o-s-t': $.cookie("o-s-t"),
          'o-s-u': $.cookie("o-s-u"),
          'o-s-e': $.cookie("o-s-e")
        };
        jQuery.post(ajaxurl + "?_r=" + Math.random(), data, function(response, status){
            console.log(response);
            $(".obituary-condolences-display").html(response);
            $("h4.condolence_honor").html($("input[name=condolence_honor]").val());
            $(".condolence_counter").html( $('.list-group-item').length > 0 ? ' (' +  $('.list-group-item').length + ')' : '');
            alert($("#allow_condolences_message").val());
          }
        , "html");
        cleanUpPostWall();
        resetCandles();
        $(".input-new-condolence-cancel-candle").trigger("click");
      }
    });

    $(".input-new-condolence").on("click keyup keydown keypress", function(){
      if ($(".input-new-condolence").val().length > 0 || $(".obituary-candle.selected").length){
        $(".input-new-condolence-submit").removeClass("d-none");
      }
      else {
        $(".input-new-condolence-submit").addClass("d-none");
      }

    });

    $("div.obituary-condolences-display")
      .on("click", ".obituary-delete-condolence",(function(e){

      e.preventDefault();

      var data = {
        'action': 'obituary_assistant_delete_condolence',
        'obit_id': $("#obit_id").val(),
        'post_id': $(this).attr("data-p-i"),
        'o-s-t': $.cookie("o-s-t"),
        'o-s-u': $.cookie("o-s-u"),
        'o-s-e': $.cookie("o-s-e")
      };

      jQuery.post(ajaxurl + "?_r=" + Math.random(), data, function(response, status){
          $(".obituary-condolences-display").html(response);
          $("h4.condolence_honor").html($("input[name=condolence_honor]").val());
          $(".condolence_counter").html( $('.list-group-item').length > 0 ? ' (' +  $('.list-group-item').length + ')' : '');
        }
      , "html");

    }));

    var cleanUpPostWall = function(){
  		$(".input-new-condolence").val("");
  		$(".input-new-condolence-submit").addClass('d-none');
      $("#captcha-wrapper").css("display","none");
      $(".refreshButton").trigger("click");
  	}

    $("div#obit_condolences")
      .on("click", ".refresh_condolence_button",(function(e){

      e.preventDefault();

      refreshCondolences();

    }));

    var refreshCondolences = function(){
      var data = {
        'action': 'obituary_assistant_refresh_condolences',
        'obit_id': $("#obit_id").val(),
        'o-s-t': $.cookie("o-s-t"),
        'o-s-u': $.cookie("o-s-u"),
        'o-s-e': $.cookie("o-s-e")
      };

      jQuery.post(ajaxurl + "?_r=" + Math.random(), data, function(response, status){
          $(".obituary-condolences-display").html(response);
          $("h4.condolence_honor").html($("input[name=condolence_honor]").val());
          $(".condolence_counter").html( $('.list-group-item').length > 0 ? ' (' +  $('.list-group-item').length + ')' : '');
        }
      , "html");

  	}

    $("h4.condolence_honor").html($("input[name=condolence_honor]").val());

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

  var resetCandles = function() {
    $('.obituary-candle').each(function(i, obj) {
      $(this).removeClass("selected");
      $(this).attr("src", $(this).attr("data-image-1"));
    });
    $("input[name=obituary-candle-choice]").val("");
  };

  $(document).on('click', ".input-new-condolence-add-candle", function(){
    $(".obituary-candles").css("display", "block");
    $(".input-new-condolence-add-candle").css("display", "none");
    $(".input-new-condolence-cancel-candle").css("display", "block");
  });

  $(document).on('click', ".obituary-candle", function(){
    if ($(this).hasClass('selected')){
      resetCandles();
      if ($(".input-new-condolence").val().length == 0){
        $(".input-new-condolence-submit").addClass("d-none");
      }
    }
    else{
      resetCandles();
      $(this).attr("src", $(this).attr("data-image-2"));
      $(this).addClass("selected");
      $("input[name=obituary-candle-choice]").val($(this).attr("data-candle-id"));
      $(".input-new-condolence-submit").removeClass("d-none");
    }
  });

  $(document).ready(function() {
     $postWallInit();

     $("img.obituary-candle").bind("dragstart",function(e){
       e.preventDefault();
     });

     $("textarea.input-new-condolence").bind("dragenter",function(e){
       e.preventDefault();
     });

     $("textarea.input-new-condolence").bind("dragover",function(e){
       e.preventDefault();
     });

     $("textarea.input-new-condolence").bind("dragdrop",function(e){
       e.preventDefault();
     });

  });


})( jQuery );
