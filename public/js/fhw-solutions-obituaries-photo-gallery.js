var videoNotLoaded = 0;
var imgError;
var reloadVideoInterval;

(function( $ ) {
  'use strict';

  var ajaxurl = oaInfo.ajax_url;
  var partials = oaInfo.partials;
  var i = 0;

  // inialize uppy.io uploader
  const AwsS3 = Uppy.AwsS3;
  const uppy = new Uppy.Uppy({
    id: 'uppyUpload',
    autoProceed: true,
    restrictions: {
      maxFileSize: 100000000,
      maxNumberOfFiles: 20,
      minNumberOfFiles: null,
      allowedFileTypes: ['image/*', 'video/*']
    },
  })
  .use(Uppy.Dashboard, {
    target: 'body',
    inline: false,
    trigger: '.edit_img',
    proudlyDisplayPoweredByUppy: false,
    closeAfterFinish: true,
    closeModalOnClickOutside: true
  })
  .use(AwsS3, {
    fields: [],
    getUploadParameters(file) {
      return fetch('https://api.obituary-assistant.com/' + environment + '/s3-signature', {
        method: 'POST',
        headers: {
          'content-type': 'application/x-www-form-urlencoded',
        },
        body: JSON.stringify({
          filename: (file.name.replace(/[^a-zA-Z0-9_.]+/g,'').length > 4 ? file.name.replace(/[^a-zA-Z0-9_.]+/g,'') : makeid(16) + file.name.match(/\.[0-9a-z]+$/i)),
          contentType: file.type,
          metadata: {
            'name': (file.name.replace(/[^a-zA-Z0-9_.]+/g,'').length > 4 ? file.name.replace(/[^a-zA-Z0-9_.]+/g,'') : makeid(16) + file.name.match(/\.[0-9a-z]+$/i)),
            'caption': '',
            'clientId': $("#client_id").val(),
            'obitId': $("#obit_id").val()
          }
        })
      }).then((response) => {
        return response.json();
      }).then((data) => {
        console.log('>>>', data);
        return {
          method: data.method,
          url: data.url,
          fields: data.fields,
          headers: data.headers,
        };
      });
    },
  });

  var environment = (window.location.hostname.search("dev.obituary-assistant.com") >= 0 ? 'dev' : 'prod');

  var getCdnUrl = function(s3Url, filter){
  	if (filter){
  		return s3Url.replace('https://obituary-assistant.s3.us-west-2.amazonaws.com', 'https://cdn.obituary-assistant.com' + filter);
  	}
  	else {
  		return s3Url.replace('https://obituary-assistant.s3.us-west-2.amazonaws.com', 'https://cdn.obituary-assistant.com');
  	}
  }

  imgError = function(image) {

    videoNotLoaded++;

    image.onerror = "";
    image.src = "https://cdn.obituary-assistant.com/filters:strip_exif()/fit-in/150x150/filters:fill(white)/global/please_wait.png";

    if (videoNotLoaded > 0){
      clearInterval(reloadVideoInterval);
      reloadVideoInterval = setInterval(
        function(){
          var data = {
            'action': 'refresh_photos_and_videos',
            'obit_id': $("#obit_id").val()
          };

          jQuery.post(ajaxurl + "?_r=" + Math.random(), data, function(response, status){
            videoNotLoaded = 0;
            $("#fws-gallery-container").html(response);
            var counter = jQuery('#florist-one-gallery-indicators').find('a').length;
            $('#photo_counter').html(' (' + counter + ')' );
          }, "html");

        },
        60000
      );
    }

    return true;
  }

  var $galleryInit = function(){
  var fwsGalleryModal = document.getElementById('fws-gallery-modal')
  var fwsGallery = document.getElementById('fwsPhotosVideosCarousel')

  if (document.getElementById("fwsPhotosVideosCarousel")) {

    fwsGalleryModal.addEventListener('show.bs.modal', function (event) {
      $('#fws-gallery-modal').find('.modal-body').html('');
      var videoNum = event.relatedTarget.getAttribute("data-video-num");
      var slideNumber = event.relatedTarget.parentElement.getAttribute("data-image-number");
      var thumbNailType = event.relatedTarget.parentElement.getAttribute("data-thumbnail-type");


      if (thumbNailType == "photo"){
        $('#fws-gallery-modal').find('.modal-body').html($("#fwsPhotosVideosCarousel").find('img').eq(parseInt(slideNumber))[0].outerHTML);
      } else {
        $('#fws-gallery-modal').find('.modal-body').html(
        '<div class="row">' +
        $("#fwsPhotosVideosCarousel").find('video').eq(parseInt(videoNum)).parent()[0].outerHTML +
        '</div>'
        );
      }

    });

    fwsGalleryModal.addEventListener('hide.bs.modal', function (event) {

      $('video').each(function() {
        $(this).get(0).pause();
      });

    });


    fwsGallery.addEventListener('slide.bs.carousel', function (event) {

      $('video').each(function() {
        $(this).get(0).pause();
      });

      $('#florist-one-gallery-indicators').find('a').parent().removeClass('active-img');
      $('#florist-one-gallery-indicators').find('a').eq(event.to).parent().addClass('active-img');

    })


  }

    $("div.obituary-photo-thumbnails")
      .on("click", "img",(function(){
          if ($(this).attr("data-type") == 'video'){
              displayFullVideo($(this).attr("data-url"),$(this).attr("data-name"),$(this).attr("data-description"));
          }
          else{
              displayFullImage($(this).attr("data-url"),$(this).attr("data-name"),$(this).attr("data-description"));
          }

          $(".obituary-photo-display-button").css("visibility","visible");

      }));

    var displayFullImage = 	function(url,name,description){

        var htmlString = "<p align='center'><img id='main-gallery-display' src='" +
            url + "' data-imageID='" + url + "'></p>";
        $(".obituary-photo-display").html(htmlString);

        displayGalleryNavigation();

    };

    var displayFullVideo = 	function(url,name,description){

        var htmlString = "<p align='center'>" +
                         "<video controls controlsList='nodownload' poster='" + url + "-p-00002.png'>" +
                         "<source src='" + url + ".mp4' type='video/mp4'>" +
                         "<source src='" + url + ".ts' type='video/ts'>" +
                         "<source src='" + url + ".webm' type='video/webm'>" +
                         "Your browser does not support the video tag." +
                         "</video>"

        $(".obituary-photo-display").html(htmlString);

        hideGalleryNavigation();

    };

    var jsonData = {};

    $("#upload_photo").click(function(){
      if ($getLogin() == 0){
        //$(".login").trigger("click");
      }
      else {
        uppy.getPlugin('Dashboard').openModal();
      }
    });

    uppy.on('file-added', (file) => {
      const data = file.data; // is a Blob instance
      const url = URL.createObjectURL(data);
      const image = new Image();
      image.src = url;
      image.onload = () => {
        uppy.setFileMeta(file.id, { width: image.width, height: image.height });
        URL.revokeObjectURL(url);
      }
    });

    uppy.on('complete', (result) => {
      // todo
      // upload files here
      if (result.successful.length){

        for (i=0; i<result.successful.length; i++){
          jsonData[$.trim(result.successful[i]['id'])] = {
            obit_id: $("#obit_id").val(),
            photo_name: $.trim($("#create-gallery-name").val()),
            photo_url: getCdnUrl($.trim(result.successful[i]['uploadURL'])),
            photo_description: $.trim($("#create-gallery-desc").val()),
            photo_creator: $getLoginVal("user"),
            resource_type: $.trim(result.successful[i]['type']),
            format: $.trim(result.successful[i]['type'])
          }
        }

        console.log(jsonData);

        var data = {
          'action': 'obituary_assistant_add_photo',
          'photos_data': JSON.stringify(jsonData),
          'obit_id': $("#obit_id").val()
        };

        jQuery.post(ajaxurl + "?_r=" + Math.random(), data, function(response, status){
          $("#fws-gallery-container").html(response);
          //$(".fws-main-gallery").removeClass('d-none');
          alert('Photo uploaded');
            var counter = jQuery('#florist-one-gallery-indicators').find('a').length;
            $('#photo_counter').html(' (' + counter + ')' );
          }, "html");

          jsonData = {};

        }

      });

      var displayGalleryNavigation = function(){
    		var prevImg = $("div[class='obituary-photo-thumbnails'] img[data-url='" + $("#main-gallery-display").attr("data-imageID") + "']").prev();
    		var nextImg = $("div[class='obituary-photo-thumbnails'] img[data-url='" + $("#main-gallery-display").attr("data-imageID") + "']").next();

    		$(".obituary-photo-display-button.previous").css("display","block");
    		$(".obituary-photo-display-button.next").css("display","block");

    		if (typeof prevImg.attr("data-url") === "undefined"){
    			$(".obituary-photo-display-button.previous").addClass("placeholder");
    		}
    		else{
    			$(".obituary-photo-display-button.previous").removeClass("placeholder");
    		}
    		if (typeof nextImg.attr("data-url") === "undefined"){
    			$(".obituary-photo-display-button.next").addClass("placeholder");
    		}
    		else{
    			$(".obituary-photo-display-button.next").removeClass("placeholder");
    		}
    	};

      var hideGalleryNavigation = function(){
        $(".obituary-photo-display-button.previous").css("display","none");
    		$(".obituary-photo-display-button.next").css("display","none");
      };

      $(".obituary-photo-display-button.previous").click(function(){
        if (!($(this).hasClass("placeholder"))){
          var prevImg = $("div[class='obituary-photo-thumbnails'] img[data-url='" + $("#main-gallery-display").attr("data-imageID") + "']").prev();
          displayFullImage(prevImg.attr("data-url"),prevImg.attr("data-name"),prevImg.attr("data-description"));
        }
      });

      $(".obituary-photo-display-button.next").click(function(){
        if (!($(this).hasClass("placeholder"))){
          var nextImg = $("div[class='obituary-photo-thumbnails'] img[data-url='" + $("#main-gallery-display").attr("data-imageID") + "']").next();
          displayFullImage(nextImg.attr("data-url"),nextImg.attr("data-name"),nextImg.attr("data-description"));
        }

      });

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

  $(document).ready(function() {

     	$galleryInit();

  });


})( jQuery );
