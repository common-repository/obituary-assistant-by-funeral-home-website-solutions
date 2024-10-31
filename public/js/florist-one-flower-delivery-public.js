(function( $ ) {
	'use strict';

var ajaxurl = oaInfo.ajax_url;
var historyBool = false;
//window.localStorage.clear();


$(window).ready(function() {

   if ($('#client_type').val() == 5 || $("#client_type").val() == 7){

      $('#florist-one-flower-delivery-menu-nav').remove();
      $('.florist-one-flower-delivery-menu').html('<li style="display:none" class="nav-item m-1 border"><a href="#" id="florist-one-flower-delivery-menu-link-0" class="nav-link florist-one-flower-delivery-menu-plant-a-tree-link" data-category="pt" data-bs-toggle="collapse" data-bs-target=".navbar-collapse.show" >Plant Trees</a></li>');
      

   } else {

      $('#florist-one-flower-delivery-menu-nav').removeClass('d-none');

   }

	// set session variables for prepopulations
  var dataStored = {
		'action': 'setFlowerSessionData',
		'name': $("#florist-one-flower-delivery-recipient-name").val(),
		'tree-name-of-loved-one': $("#florist-one-flower-delivery-tree-certificate-name-of-loved-one").val(),
		'institution': $("#florist-one-flower-delivery-recipient-institution").val(),
		'address1': $("#florist-one-flower-delivery-recipient-address-1").val(),
		'address2': $("#florist-one-flower-delivery-recipient-address-2").val(),
		'city': $("#florist-one-flower-delivery-recipient-city").val(),
		'state': $("#florist-one-flower-delivery-recipient-state").val(),
		'zip': $("#florist-one-flower-delivery-recipient-postal-code").val(),
		'country': $("#florist-one-flower-delivery-recipient-country").val(),
		'phone': $("#florist-one-flower-delivery-recipient-phone").val(),
		'facility_id': $("#florist-one-flower-delivery-facility-id").val(),
		'obit_id' : $("#obit_id").val(),
		'random' : Math.random()
	};

	 var localStorageData = JSON.parse(window.localStorage.getItem('chekoutInfo'));
	 if (localStorageData != null) {

     jQuery.each(localStorageData, function( key, value ) {

        dataStored[key] = value;

     });

   }

  //display checkout stored values
	jQuery.post(ajaxurl + "?_r=" + Math.random(),dataStored);

	//get cart count and display
	jQuery.post(ajaxurl + "?_r=" + Math.random(), {'action' : 'getCartCount', 'random' : Math.random()}, function(response, status){ jQuery('#florist-one-cart-count').html(response); }, "html");

	//modal

	$('#florist-one-flower-delivery-view-modal').on('shown.bs.modal', function (event) {
      var $modal = $('#florist-one-flower-delivery-view-modal');

      $modal.find('.modal-header-text').html('').text(event.relatedTarget.text);

      if($(event.relatedTarget).hasClass('florist-one-flower-delivery-menu-cart-button') || $(event.relatedTarget).hasClass('florist-one-flower-delivery-add-to-cart')){
        $('.modal-header-text').html(jQuery('.florist-one-flower-delivery-menu-cart-button p').text());
      }

      if (event.relatedTarget.id == "florist-one-flower-delivery-menu-link-99"){
        $('#florist-one-flower-delivery-view-modal').find('.modal-footer').hide();
      } else {
       $('#florist-one-flower-delivery-view-modal').find('.modal-footer').show();
      }
      if ( $('.checkout-form').is(':visible')){
        $('#florist-one-flower-delivery-view-modal-close').hide();
      } else {
        $('#florist-one-flower-delivery-view-modal-close').show();
      }
  });

  $('#florist-one-flower-delivery-view-modal').on('hide.bs.modal', function (event) {

    if($('.checkout-form').is(':visible')){
      getCheckout();
    }
      jQuery.post(ajaxurl + "?_r=" + Math.random(), {'action' : 'getCartCount', 'random' : Math.random()}, function(response, status){ jQuery('#florist-one-cart-count').html(response); }, "html");
      var $modal = $('#florist-one-flower-delivery-view-modal');
      $modal.find('.modal-body').html("");
  });


	if($(".florist-one-flower-delivery-menu").get(0)){

	  if($('#client_type').val() !=5){
	    $('.florist-one-flower-delivery-ssl-warning').css('display','block');
	  }

		var pagetitle = $(document).find("title").text();
		if (getUrlParameter('viewitem')){
			var data = {
		    'action' : 'getProduct',
		    'code' : getUrlParameter('viewitem'),
				'random' : Math.random()
		  };
		}
		else if (getUrlParameter('buyitem')){
			var data = {
		    'action' : 'addToCart',
		    'code' : getUrlParameter('buyitem'),
				'random' : Math.random()
			};
		}
		else if ($(".florist-one-flower-delivery-container").attr("data-def_cat")){
			if ($(".florist-one-flower-delivery-container").attr("data-def_cat") != 'cart'){
				var data = {
					'action' : 'getProducts',
					'category' : $(".florist-one-flower-delivery-container").attr("data-def_cat"),
					'page' : 1,
					'random' : Math.random()
				};
			}
			else{
				var data = {
					'action' : 'getCart',
					'random' : Math.random()
				};
			}
		}
		else if (getUrlParameter('revieworder')){

			historyBool = true;
			var data = {
				'action' : 'checkout',
				'page' : 4,
				'formdata': dataStored,
				'obituary': ($('#fhws-main-obit').is(':visible')) ? 1 : 0,
				'validated'  : null,
				'random' : Math.random()
			};
		}
		else if (getUrlParameter('orderno')){

			var purchaseData = {
        "order_id": getUrlParameter('orderno'),
      }

      checkout(5, purchaseData );

		}
		else if (getUrlParameter('show_trees') == 1 || $('#client_type').val() == 5 || $("#client_type").val() == 7){
			var data = {
              'action' : 'getTree',
                'code' : 'TREES',
              'random' : Math.random()
                };
		}else{
       var data = {
          'action' : 'getProducts',
          'category' : ( ( $(".florist-one-flower-delivery-container").attr("data-def_cat") ) ? $(".florist-one-flower-delivery-container").attr("data-def_cat") : 'default' ),
          'page' : 1,
          'random' : Math.random()
        };
		}
		History.pushState(data, pagetitle, "");
	}

});

$(document).on("click", "a.florist-one-flower-delivery-menu-link", function(e){

	e.preventDefault();
  var data = {
    'action' : 'getProducts',
    'category' : $(this).attr("data-category"),
    'page' : $(this).attr("data-page")
  };
  History.pushState(data, "", "");
});

// trees
function selectYourOwnTreeCalc(amount, number, calc , minTrees){

    var totalPrice = (amount !=null)? (Math.round(amount * 100) / 100).toFixed(2) : '';
    var getPrice = $('.florist-one-flower-delivery-plant-a-tree-select-your-own-price').text();
    var pricePresent = isNaN(getPrice);
    var $container =  $('#fws-trees-calculate-msg');
    var $addToCart = '<svg viewBox="0 0 24 24" width="18" height="18" stroke="currentColor" stroke-width="2" fill="currentColor" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>';
    var min = '<div class="alert alert-danger lh-base" role="alert">We’re sorry but the minimum number of trees that can be planted is ' +  minTrees + '</div>';
    var useModal = ($('#florist-one-flower-delivery-view-modal').hasClass('show')) ? "" : 'data-bs-toggle="modal"';
    var price =' <p class="fs-5 florist-one-flower-delivery-plant-a-tree-select-your-own-price">$' + totalPrice + '</p>' +
                '<button type="button" data-checkout="show" href="#" class="f1fd_primary florist-one-flower-delivery-add-to-cart btn mt-3" ' + useModal +' data-bs-target="#florist-one-flower-delivery-view-modal" id="plant-a-tree-add-to-cart2">Add To Cart ' + $addToCart +'</button>'
    var msg = (number < parseInt(minTrees)) ? min : (calc)? price: (pricePresent)? getPrice : '';
    $container.html(msg);

    if (calc){

        $('#plant-a-tree-add-to-cart2').attr('data-number',number)
            .attr('data-price', amount)
            .attr('data-name',  'Plant ' + number + " Trees")
            .attr('data-code',  'Plant ' + number + " Trees");

    }

}

function calculateTreePrice(minTrees, trees, element, radio){

	var each = 0;
	if (trees > 4 && trees < 12){
		each = 10;
	} else if (trees > 11 && trees < 30){
		each = 8.33;
	} else if (trees > 29){
		each = 8;
	}

	if (isNaN(trees) || trees < minTrees){
			element.focus();
	} else {
		var data = {
			'action': 'getTreesTotal',
			'code': "TREES",
			'number': trees,
			'price': (trees * each).toFixed(2),
			'client_id':$("#client_id").val(),
		};

		if (!radio){
			jQuery.post(ajaxurl + "?_r=" + Math.random(), data, function(response, status){
				selectYourOwnTreeCalc(response, trees, true, minTrees);
			}, "html");
		}

		else {
			jQuery.post(ajaxurl + "?_r=" + Math.random(), data, function(response, status){
				element.attr("data-price", response);
				element.attr("data-number", trees);
				element.attr("data-code", "Plant-" + trees + '-Trees');
				element.attr("data-name", "Plant " + trees + ' Trees');
			});
		}

	}

}

$(document).on("input", "#florist-one-flower-delivery-plant-a-tree-select-your-own", function(e){

    selectYourOwnTreeCalc(null,this.value,false,$(this).attr('min'));

});


$(document).on("change","#florist-one-flower-delivery-recipient-country", function(e) {

  var d = '#florist-one-flower-delivery-recipient-state';
  var pc = '#florist-one-flower-delivery-recipient-postal-code';
  function _rx(e,s,d){
    var c = 'fhws-hide-state';
    var t = $("." + e);
    t.removeClass(c);
    if (s == "hide"){t.addClass(c)}
    $(d).val(''); $(pc).val('');
  }
  switch(this.value) {
    case "CA":
      _rx("fhws-country-rec-ca","show",d);_rx("fhws-country-rec-us","hide",d);
      $(d).prop("disabled", false); $(pc).prop("disabled", false);
      $(d).prev().text('Province*')
      $(pc).attr("placeholder", "Postal Code*").prev().text('Postal Code*');

      break;
    case "US":
      _rx("fhws-country-rec-ca","hide",d);_rx("fhws-country-rec-us","show",d);
      $(d).prop("disabled", false); $(pc).prop("disabled", false);
      $(d).prev().text('State*')
      $(pc).attr("placeholder", "Zip Code*").prev().text('Zip Code*');
      break;
    default:

  }


});

$(document).on("change","#florist-one-flower-delivery-customer-country", function(e) {

  var d = '#florist-one-flower-delivery-customer-state';
  var pc = '#florist-one-flower-delivery-customer-postal-code';
  function _x(e,s,d){
    var c = 'fhws-hide-state';
    var t = $("." + e);
    t.removeClass(c);
    if (s == "hide"){t.addClass(c)}
    $(d).val(''); $(pc).val('');
  }
  switch(this.value) {
    case "CA":
      _x("fhws-country-ca","show",d);_x("fhws-country-us","hide",d);
      $(d).prop("disabled", false); $(pc).prop("disabled", false);
      $(d).prev().text('Province*')
      $(pc).attr("placeholder", "Postal Code*").prev().text('Postal Code*');
      $(d + ' option:first').html('&#8212; Select &#8212;');

      break;
    case "US":
      _x("fhws-country-ca","hide",d);_x("fhws-country-us","show",d);
      $(d).prop("disabled", false); $(pc).prop("disabled", false);
      $(d).prev().text('State*')
      $(pc).attr("placeholder", "Zip Code*").prev().text('Zip Code*');
      $(d + ' option:first').html('&#8212; Select &#8212;');
      break;
    default:
      _x("fhws-country-ca","hide");_x("fhws-country-us","hide");
      $(d).prop("disabled", true);
      $(d).val('');
      if ($(d).next().hasClass('alert-danger')){
        $(d).next().remove();
      }
      if ($(pc).next().hasClass('alert-danger')){
        $(pc).next().remove();
      }
      $(pc).prop("disabled", false);
      $(d).prev().text('State');
      $(pc).attr("placeholder", "Postal Code").prev().text('Postal Code');
      $(d + ' option:first').html('&#8212; Not Required &#8212;');
  }

});

$(document).on("click",".country-trigger", function(e) {


  if($('#' + $(this).children(":first").next().attr('id')).is(':disabled')){
    $("#florist-one-flower-delivery-customer-country").focus();
  }

});

$(document).on("keydown","#florist-one-flower-delivery-tree-certificate-sender-display-name, #florist-one-flower-delivery-tree-certificate-name-of-loved-one", function(e) {

  if($(this).length < 59){
    $(this).val($(this).val().substring(0,59));
  }

});


$(document).on("click", ".florist-one-flower-delivery-plant-a-tree-select-your-own-calculate", function(e){

    e.preventDefault();

		calculateTreePrice(
			$('#florist-one-flower-delivery-plant-a-tree-select-your-own').attr('min'),
			parseInt($('#florist-one-flower-delivery-plant-a-tree-select-your-own').val().trim()),
			$('#florist-one-flower-delivery-plant-a-tree-select-your-own')
		);

});

$(document).on("click", "#florist-one-flower-delivery-tree-certificate-wrapper .trees-checkout", function(e){

    // switch radio button on input
    if (e.target.nodeName == "INPUT" || e.target.nodeName == "TEXTAREA"){

          jQuery("input:radio").eq($(".trees-checkout").index(this)).attr("checked", true).trigger("click");

    }

});

// end trees

$(document).on("click", "a.florist-one-flower-delivery-menu-plant-a-tree-link", function(e){

	if ( $(this).attr("href") == '#' ){
		e.preventDefault();
		$('#checkout-tree-button').remove(); // used if account type is 5 or 7 trees only
	  var data = {
	    'action' : 'getTree',
	    'code' : "TREES"
	  };
	  History.pushState(data, "", "");
	}
});

$(document).on("click", ".florist-one-flower-delivery-menu-link-more", function(e){

	e.preventDefault();

  var data = {
      'action' : 'getProductsMore',
      'category' : $(this).attr("data-category"),
      'page' : $(this).attr("data-current-page"),
      'random' : Math.random()
  };


  if(parseInt($(this).attr("data-current-page")) == parseInt($(this).attr("data-pages"))){

    $(this).remove();
  }
   $(this).attr("data-current-page", parseInt($(this).attr("data-current-page")) + 1);
  History.pushState(data, "", "");

});


$(document).on("click", ".florist-one-flower-delivery-many-products-single-product", function(e){

	if ( $(this).attr("href") == '#' && $(this).attr("data-code") != 'TREES'){

	  var thisCode = $(this).attr("data-code");
	  $("#checkout-tree-button").remove();

		e.preventDefault();
	  var data = {
	    'action' : (thisCode == "TREES")? 'getTree' : 'getProduct',
	    'code' : thisCode,
	    'random' : Math.random()
	  };
	  History.pushState(data, "", "");
	}

	else if ($(this).attr("data-code") == 'TREES') {

		$("a[data-category=pt]").trigger("click");

	}

});

$(document).on("change", "input[type=radio][name=number_of_trees]", function(e){

	e.preventDefault();

	var trees = $("input[type=radio][name=number_of_trees]:checked").val();

	calculateTreePrice(
		0,
		trees,
		$("#plant-a-tree-add-to-cart1"),
		true
	);

	$("#fws-trees-calculate-msg-choose-number").html('');

});

$(document).on("click", ".florist-one-flower-delivery-add-to-cart", function(e){

	// if tree added and no radio option selected
	if ($(this).attr("id") == "plant-a-tree-add-to-cart1" && (!($("input[type=radio][name=number_of_trees]").length && $("input[type=radio][name=number_of_trees]:checked").val()))){
		e.preventDefault();
		$("input[type=radio][name=number_of_trees]").focus();
		$('#florist-one-flower-delivery-view-modal').hide()
		$("#fws-trees-calculate-msg-choose-number").html('<div class="alert alert-danger">Please choose an option above.</div>');
		return;
	}

	if ( $(this).attr("href") == '#' ){
		historyBool = true;
		e.preventDefault();
		var data = {
        'action' : 'addToCart',
        'code' :  $(this).attr("data-code"),
        'num' : ($('#fws-add-to-cart-amount').is(":visible")) ?  $('#fws-add-to-cart-amount').val() : 1,
        'random' : Math.random()

	  	};

		History.pushState(data, "", "");
	}
	jQuery.post(ajaxurl + "?_r=" + Math.random(), {'action' : 'getCartCount', 'random' : Math.random()}, function(response, status){ jQuery('#florist-one-cart-count').html(response); }, "html");

});

$(document).on("click", ".florist-one-flower-delivery-menu-cart-button", function(e){
	e.preventDefault();
	//checkout
  var data = {
    'action' : 'getCart',
    'code' : null,
    'random' : Math.random()
  };
  History.pushState(data, "", "");
  	//get cart count and display
	jQuery.post(ajaxurl + "?_r=" + Math.random(), {'action' : 'getCartCount', 'random' : Math.random()}, function(response, status){ jQuery('#florist-one-cart-count').html(response); }, "html");

});

$(document).on("click", "a.florist-one-flower-delivery-cart-remove-item", function(e){
	e.preventDefault();
	removeFromCart($(this).attr("data-code"));
	jQuery.post(ajaxurl + "?_r=" + Math.random(), {'action' : 'getCartCount', 'random' : Math.random()}, function(response, status){ jQuery('#florist-one-cart-count').html(response); }, "html");

});

$(document).on("click", "a.florist-one-flower-delivery-menu-customer-service-link", function(e){
	e.preventDefault();
  var data = {
    'action' : 'getCustomerService'
  };
  History.pushState(data, "", "");
});

$(document).on("focusout", ".checkout-form" , function(e){

  var key = e.target.name;
  var value = e.target.value;

  if(e.target.name == "florist-one-flower-delivery-tree-certificate"){

      //store checkout in local storage
      var checkoutInput = (JSON.parse(window.localStorage.getItem('chekoutInfo')) == null)? {} : JSON.parse(window.localStorage.getItem('chekoutInfo'));
      checkoutInput[key] = value;
      window.localStorage.setItem('chekoutInfo', JSON.stringify(checkoutInput));

  } else if (e.target.name != "florist-one-flower-delivery-purchase-recognition-check"){
    // validate and store value in local storage
    var validator = $( ".checkout-form" ).validate();
    validator.element( "#" + key );

    var validator = $(".checkout-form").data('validator');
    if(validator.check("#" + key)){

      //store checkout in local storage
      var checkoutInput = (JSON.parse(window.localStorage.getItem('chekoutInfo')) == null)? {} : JSON.parse(window.localStorage.getItem('chekoutInfo'));
      checkoutInput[key] = value;
      window.localStorage.setItem('chekoutInfo', JSON.stringify(checkoutInput));

    }
  }

});

$(document).on('change', 'input[Id="florist-one-flower-delivery-purchase-recognition-check"]', function (e) {

    //store checkout in local storage
    var checkoutInput = (JSON.parse(window.localStorage.getItem('chekoutInfo')) == null)? {} : JSON.parse(window.localStorage.getItem('chekoutInfo'));
    checkoutInput["florist-one-flower-delivery-purchase-recognition-check"] = ($(this).prop('checked')) ? "on" : "";
    window.localStorage.setItem('chekoutInfo', JSON.stringify(checkoutInput));

});

$(document).on('change', 'input[Id="florist-one-flower-delivery-allow-substitutions-check"]', function (e) {

    //store checkout in local storage
    var checkoutInput = (JSON.parse(window.localStorage.getItem('chekoutInfo')) == null)? {} : JSON.parse(window.localStorage.getItem('chekoutInfo'));
    checkoutInput["florist-one-flower-delivery-allow-substitutions-check"] = ($(this).prop('checked')) ? "on" : "";
		window.localStorage.setItem('chekoutInfo', JSON.stringify(checkoutInput));

});

$(document).on("click", ".checkout-form-continue-next-step" , function(e){
  e.preventDefault();
	$(".checkout-form").submit();

})


$(document).on("click", ".florist-one-flower-delivery-checkout", function(e){
		historyBool = true;
		e.preventDefault();
		document.querySelector(".florist-one-flower-delivery-menu").scrollIntoView(true);

		var dataCheckout = {
      'action': 'setFlowerSessionData',
      'name': $("#florist-one-flower-delivery-recipient-name").val(),
      'tree-name-of-loved-one': $("#florist-one-flower-delivery-tree-certificate-name-of-loved-one").val(),
      'institution': $("#florist-one-flower-delivery-recipient-institution").val(),
      'address1': $("#florist-one-flower-delivery-recipient-address-1").val(),
      'address2': $("#florist-one-flower-delivery-recipient-address-2").val(),
      'city': $("#florist-one-flower-delivery-recipient-city").val(),
      'state': $("#florist-one-flower-delivery-recipient-state").val(),
      'zip': $("#florist-one-flower-delivery-recipient-postal-code").val(),
      'country': $("#florist-one-flower-delivery-recipient-country").val(),
      'phone': $("#florist-one-flower-delivery-recipient-phone").val(),
      'facility_id': $("#florist-one-flower-delivery-facility-id").val(),
      'obit_id' : $("#obit_id").val(),
      'random' : Math.random()
		};

    var localStorageData = JSON.parse(window.localStorage.getItem('chekoutInfo'));
    if (localStorageData != null) {

      jQuery.each(localStorageData, function( key, value ) {
        dataCheckout[key] = value;

      });

    }

    var data = {
      'action' : 'checkout',
      'page' : 4,
      'formdata':jQuery.post(ajaxurl + "?_r=" + Math.random(),dataCheckout),
      'obituary':($('#fhws-main-obit').is(':visible')) ? 1 : 0,
      'validated'  : null,
      'random' : Math.random()
    };
    History.pushState(data, "", "");
});


History.Adapter.bind(window, "statechange", function() {

  var state = History.getState();

  if (state.data.action == 'getProducts'){
		$("#florist-one-flower-delivery-menu-nav").find('a').removeClass("active");
		if(state.data.category != "default"){
			$("a.florist-one-flower-delivery-menu-link[data-category='" + state.data.category + "']").addClass("active");
		}
		else{
			$("#florist-one-flower-delivery-menu-link-1").addClass("active");
		}
    getProducts(state.data.category, state.data.page);
  }
  else if (state.data.action == 'getProductsMore'){
	    getProductsMore(state.data.category, state.data.page);
	}
  else if (state.data.action == 'getProduct'){
    getProduct(state.data.code);

  }
  else if (state.data.action == 'getTree'){
    $("#florist-one-flower-delivery-menu-nav").find('a').removeClass("active");
		$("a.florist-one-flower-delivery-menu-plant-a-tree-link").addClass("active");
    getTree(state.data.code);
  }
  else if (state.data.action == 'addToCart'){
    //$("#florist-one-flower-delivery-menu-nav").find('a').removeClass("active");
		if(historyBool){
      addToCart(state.data.code, state.data.num);
		}
		else{
			getCart(state.data.code);
		}
		historyBool = false;
  }
  else if (state.data.action == 'getCart'){
		//$("#florist-one-flower-delivery-menu-nav").find('a').removeClass("active");
    getCart(state.data.code);
  }
  else if (state.data.action == 'getCustomerService'){
		$("#florist-one-flower-delivery-menu-nav").find('a').removeClass("active");
		$("a.florist-one-flower-delivery-menu-customer-service-link").addClass("active");
    showCustomerService();
  }
  else if (state.data.action == 'checkout'){
		$("a.florist-one-flower-delivery-menu-link").removeClass("active");
    checkout(state.data.page, state.data.formdata, state.data.obituary, state.data.validated);
  }

});

var getProducts = function(category, page){

		var data = {
			'action': 'getProducts',
			'category': category,
			'page': page,
			'facility_id': $('#facility_id').val()
		};

		jQuery.post(ajaxurl + "?_r=" + Math.random(), data, function(response, status){ make_page(response, status); }, "html");

}

var getProductsMore = function(category, page){

		var data = {
			'action': 'getProductsMore',
			'category': category,
			'page': page,
			'facility_id': $('#facility_id').val()
		};

		jQuery.post(ajaxurl + "?_r=" + Math.random(), data, function(response, status){

		  jQuery('#florist-one-flower-delivery-many-products-display').append(response);
		  var itemsPage = (page == $('.florist-one-flower-delivery-menu-link-more').attr('data-pages'))? $('.florist-one-flower-delivery-menu-link-more').attr('data-items-count') :$('.florist-one-flower-delivery-menu-link-more').attr('data-count')*page;
		  jQuery('#florist-one-pagnation').text(itemsPage);

		}, "html");

}


var getProduct = function(code){

		var data = {
			'action': 'getProduct',
			'code': code,
			'facility_id': $('#facility_id').val()
		};

		//jQuery.post(ajaxurl + "?_r=" + Math.random(), data, function(response, status){ make_page(response, status); }, "html");


		jQuery.post(ajaxurl + "?_r=" + Math.random(), data, function(response, status){ jQuery('#florist-one-flower-delivery-view-modal').find('.modal-body').html(response); }, "html");
		jQuery('#florist-one-flower-delivery-view-modal').find('.modal-body').html("");


}

var getTree = function(code){

		var data = {
			'action': 'getTree',
			'code': code,
			'facility_id': $('#facility_id').val()
		};

		if (jQuery('#florist-one-flower-delivery-view-modal').hasClass('show') && !jQuery('#fws-trees-container').is(':visible')){
		  jQuery.post(ajaxurl + "?_r=" + Math.random(), data, function(response, status){
		    jQuery('#florist-one-flower-delivery-view-modal').find('.modal-body').html(response);
		    jQuery('#florist-one-flower-delivery-view-modal').find('#plant-a-tree-add-to-cart1').removeAttr('data-bs-toggle');
		  }, "html");

		} else {


		  if (jQuery('#florist-one-flower-delivery-view-modal').hasClass('show')){
		    $('#florist-one-flower-delivery-view-modal').modal('hide');
		  }

			jQuery.post(ajaxurl + "?_r=" + Math.random(), data, function(response, status){ make_page(response, status); }, "html");
    }

		//jQuery.post(ajaxurl + "?_r=" + Math.random(), data, function(response, status){ jQuery('#florist-one-flower-delivery-view-modal').find('.modal-body').html(response); }, "html");
		//jQuery('#florist-one-flower-delivery-view-modal').find('.modal-body').html("");

}

var addToCart = function(code,num){

		var data = {
			'action': 'addToCart',
			'code': code,
			'num' : num
		};

		//jQuery.post(ajaxurl + "?_r=" + Math.random(), data, function(response, status){ make_page(response, status); }, "html");

		if (jQuery('#florist-one-flower-delivery-view-modal').hasClass('show')){
		  jQuery.post(ajaxurl + "?_r=" + Math.random(), data, function(response, status){ jQuery('#florist-one-flower-delivery-view-modal').find('.modal-body').html(response); }, "html");
		} else {
			jQuery.post(ajaxurl + "?_r=" + Math.random(), data, function(response, status){ jQuery('#florist-one-flower-delivery-view-modal').find('.modal-body').html(response); }, "html");
    }



}

var removeFromCart = function(code){

		var data = {
			'action': 'removeFromCart',
			'code': code
		};

		//jQuery.post(ajaxurl + "?_r=" + Math.random(), data, function(response, status){ make_page(response, status); }, "html");
		if (jQuery('#florist-one-flower-delivery-view-modal').hasClass('show')){
		  jQuery.post(ajaxurl + "?_r=" + Math.random(), data, function(response, status){ jQuery('#florist-one-flower-delivery-view-modal').find('.modal-body').html(response); }, "html");
		} else {
			//jQuery.post(ajaxurl + "?_r=" + Math.random(), data, function(response, status){ make_page(response, status); }, "html");
		}

}

var getCart = function(code){

		var data = {
			'action': 'getCart',
			'code': code
		};

		//jQuery.post(ajaxurl + "?_r=" + Math.random(), data, function(response, status){ make_page(response, status); }, "html");
		jQuery.post(ajaxurl + "?_r=" + Math.random(), data, function(response, status){ jQuery('#florist-one-flower-delivery-view-modal').find('.modal-body').html(response); }, "html");
		jQuery('#florist-one-flower-delivery-view-modal').find('.modal-body').html("");

}

var showCustomerService = function(code){

		var data = {
			'action': 'getCustomerService'
		};

		jQuery.post(ajaxurl + "?_r=" + Math.random(), data, function(response, status){ make_page(response, status); }, "html");

}

var placeOrder = function(formdata, flowers, total, token){

	var data = {
		'action': 'placeOrder',
		'formdata': formdata,
		'flowers': flowers,
		'ordertotal': total,
		'token': token
	};

	jQuery.post(ajaxurl + "?_r=" + Math.random(), data, function(response, status){

		// if return is json there are validation errors
		if (isJSON(response)){
			var errorList = JSON.parse(response);
			$(".floristone-checkout-errors").remove();
				var summary = "<p>There are some issues with your order:</p>";
				summary += "<ul>";
				$.each(errorList, function() {
				 	summary += "<li>" + this + "</li>";
				});
				summary += "</ul>";
				$(".checkout-form-continue-next-step").before('<div class="my-2 alert alert-danger floristone-checkout-errors">' + summary + '</div>');
		}

		// if return is html, it is the thank you page, just display it
		else {
			make_page(response, status);
		}

	});

};

var isJSON = function (something) {
    if (typeof something != 'string')
        something = JSON.stringify(something);

    try {
        JSON.parse(something);
        return true;
    } catch (e) {
        return false;
    }
}

var createPaymentLink = function(){

	var data = {
		'action': 'createPaymentLink'
	};

	jQuery.post(ajaxurl + "?_r=" + Math.random(), data, function(response, status){
		console.log(response);
		if (typeof response["PAYMENT_LINK"] !== "undefined"){
			window.location.href = response["PAYMENT_LINK"];
		}
	}, "json");

};

var checkout = function(page, formdata, obituary, validated){

		var data = {
			'action': 'checkout',
			'page': page,
			'formdata': formdata,
			'obituary': ($('#fhws-main-obit').is(':visible')) ? 1 : 0,
			'validated': validated
		};


		jQuery.post(ajaxurl + "?_r=" + Math.random(), data, function(response, status){


	    $('#florist-one-flower-delivery-view-modal').modal('hide');
	    make_page(response, status, page);
		  jQuery('#florist-one-flower-delivery-purchase-recognition-label').text( jQuery("#f1_purchase_recognition").val());
		}, "html");

		if (jQuery('#client_type').val() == 5 || $("#client_type").val() == 7){

		  jQuery("#checkout-tree-button").remove();
     	  jQuery('.florist-one-flower-delivery').before('<a href="#" id="checkout-tree-button" class="btn-fws mb-3 btn-dark florist-one-flower-delivery-menu-plant-a-tree-link active" data-category="pt" data-bs-toggle="collapse" data-bs-target=".navbar-collapse.show" >Back to Plant Trees</a>');

		}
}

var getCheckout = function (){

    var dataCheckout = {
      'action': 'setFlowerSessionData',
      'name': $("#florist-one-flower-delivery-recipient-name").val(),
      'tree-name-of-loved-one': $("#florist-one-flower-delivery-tree-certificate-name-of-loved-one").val(),
      'institution': $("#florist-one-flower-delivery-recipient-institution").val(),
      'address1': $("#florist-one-flower-delivery-recipient-address-1").val(),
      'address2': $("#florist-one-flower-delivery-recipient-address-2").val(),
      'city': $("#florist-one-flower-delivery-recipient-city").val(),
      'state': $("#florist-one-flower-delivery-recipient-state").val(),
      'zip': $("#florist-one-flower-delivery-recipient-postal-code").val(),
      'country': $("#florist-one-flower-delivery-recipient-country").val(),
      'phone': $("#florist-one-flower-delivery-recipient-phone").val(),
      'facility_id': $("#florist-one-flower-delivery-facility-id").val(),
      'obit_id' : $("#obit_id").val(),
      'random' : Math.random()
		};

    var localStorageData = JSON.parse(window.localStorage.getItem('chekoutInfo'));
    if (localStorageData != null) {

      jQuery.each(localStorageData, function( key, value ) {

        dataCheckout[key] = value;

      });

    }

    var data = {
      'action' : 'checkout',
      'page' : 4,
      'formdata' : jQuery.post(ajaxurl + "?_r=" + Math.random(),dataCheckout),
      'obituary': ($('#fhws-main-obit').is(':visible')) ? 1 : 0,
      'validated'  : null,
      'random' : Math.random()
    };
    History.pushState(data, "", "");

}

var make_page = function(response, status, page){

  $(".florist-one-flower-delivery").html(response);

  if (page !== undefined) {
    initCheckoutFormValidation();
  }

}

var scroll_to_top = function(){

	window.scrollTo(0, $('.florist-one-flower-delivery-menu').offset().top - 60);

}

var initCheckoutFormValidation = function(){

var submitted;
  $(document).ready(function(){
  	var $form = $(".checkout-form");
  	$form.validate({
  		rules: {
  			"florist-one-flower-delivery-delivery-date": {
  				required: true
  			},
  			"florist-one-flower-delivery-tree-certificate": {
  			    required :true
  			},
  			"florist-one-flower-delivery-tree-certificate-email-behalf-recipient-name": {
  			  required: {
            depends:function(){
              $(this).val($(this).val().trim());
                if ($("#florist-one-flower-delivery-tree-certificate-email-behalf").is(":checked")) {
                  return true;
              } else {
                  return false;
              }
            }
          },
          maxlength: 100
  			},
  			"florist-one-flower-delivery-tree-certificate-email-behalf-recipient-email": {
  			  required: {
            depends:function(){
              $(this).val($(this).val().trim());
                if ($("#florist-one-flower-delivery-tree-certificate-email-behalf").is(":checked")) {
                  return true;
              } else {
                  return false;
              }
            }
          },
          emailVer: true,
          maxlength: 100
  			},
  			"florist-one-flower-delivery-tree-certificate-email-behalf-message-to-recipient": {
  				required: {
              depends:function(){
                  $(this).val($(this).val().trim());
                  return false;
              }
          },
          maxlength: 500
  			},
  			"florist-one-flower-delivery-tree-certificate-name-of-loved-one": {
  			    required: {
              depends:function(){
                  $(this).val($(this).val().trim());
                  if($(this).length < 59){
                    $(this).val($(this).val().substring(0,59));
                  }
                  return true;
              }
          },
  			},
  			"florist-one-flower-delivery-tree-certificate-sender-display-name": {
  			    required: {
              depends:function(){
                  $(this).val($(this).val().trim());
                  if($(this).length < 59){
                    $(this).val($(this).val().substring(0,59));
                  }
                  return true;
              }
          },
  			},
  			"florist-one-flower-delivery-special-card-message": {
  				required: {
              depends:function(){
                  $(this).val($(this).val().trim());
                  return true;
              }
          },
  				maxlength: 200
  			},
  			"florist-one-flower-delivery-special-special-instructions": {
  				required: {
              depends:function(){
                  $(this).val($(this).val().trim());
                  return false;
              }
          },
  				maxlength: 100
  			},
  			"florist-one-flower-delivery-recipient-name": {
  				required: {
              depends:function(){
                  $(this).val($(this).val().trim());
                  return true;
              }
          },
  				maxlength: 100
  			},
  			"florist-one-flower-delivery-recipient-institution": {
  				required: {
              depends:function(){
                  $(this).val($(this).val().trim());
                  return false;
              }
          },
  				maxlength: 100
  			},
  			"florist-one-flower-delivery-recipient-address-1": {
  				required: {
              depends:function(){
                  $(this).val($(this).val().trim());
                  return true;
              }
          },
  				maxlength: 100
  			},
  			"florist-one-flower-delivery-recipient-address-2": {
  				required: {
              depends:function(){
                  $(this).val($(this).val().trim());
                  return false;
              }
          },
  				maxlength: 100
  			},
  			"florist-one-flower-delivery-recipient-city": {
  				required: {
              depends:function(){
                  $(this).val($(this).val().trim());
                  return true;
              }
          },
  				maxlength: 100
  			},
  			"florist-one-flower-delivery-recipient-state": {
  				required: true,
  				maxlength: 2
  			},
  			"florist-one-flower-delivery-recipient-country": {
  				required: true,
  				maxlength: 2
  			},
  			"florist-one-flower-delivery-recipient-postal-code": {
  				required: {
              depends:function(){
                  $(this).val($(this).val().trim().toUpperCase());
                  return true;
              }
          },
  				maxlength: 7,
					recipientZip: true
  			},
  			"florist-one-flower-delivery-recipient-phone": {
  				required: {
              depends:function(){
                  $(this).val($(this).val().trim());
                  return true;
              }
          },
  				maxlength: 20,
					phoneNumber: true
  			},
  			"florist-one-flower-delivery-customer-name": {
  				required: {
              depends:function(){
                  $(this).val($(this).val().trim());
                  return true;
              }
          },
  				maxlength: 100
  			},
  			"florist-one-flower-delivery-customer-address-1": {
  				required: {
              depends:function(){
                  $(this).val($(this).val().trim());
                  return true;
              }
          },
  				maxlength: 100
  			},
  			"florist-one-flower-delivery-customer-address-2": {
  				rrequired: {
              depends:function(){
                  $(this).val($(this).val().trim());
                  return false;
              }
          },
  				maxlength: 100
  			},
  			"florist-one-flower-delivery-customer-city": {
  				required: {
              depends:function(){
                  $(this).val($(this).val().trim());
                  return true;
              }
          },
  				maxlength: 100
  			},
  			"florist-one-flower-delivery-customer-state": {
  				required: true,
  				maxlength: 2
  			},
  			"florist-one-flower-delivery-customer-country": {
  				required: true,
  				maxlength: 2
  			},
  			"florist-one-flower-delivery-customer-phone": {
  				required: {
              depends:function(){
                  $(this).val($(this).val().trim());
                  return true;
              }
          },
  				maxlength: 20,
  				phoneNumber: true
  			},
  			"florist-one-flower-delivery-customer-email": {
  				required: {
              depends:function(){
                  $(this).val($(this).val().trim());
                  return true;
              }
          },
  				maxlength: 100,
					emailVer: true
  			},
  			"florist-one-flower-delivery-customer-postal-code": {
  				required: {
              depends:function(){

                var $cVal = $("#florist-one-flower-delivery-customer-country").val();

                if($cVal == "CA" || $cVal == "US" ){
                  $(this).val($(this).val().trim().toUpperCase());
                  return true;
                } else {
                  $(this).val($(this).val().trim());
                  return false;
                }

              }
          },
          maxlength: 15,
					customerZip: true
  			},
  			"florist-one-flower-delivery-payment-credit-card-number": {
  				required: true,
  				maxlength: 16,
					creditCardNumber: true
  			},
  			"florist-one-flower-delivery-payment-expiration-month": {
  				required: true,
  				maxlength: 2,
					CCExp: {
						month: '#florist-one-flower-delivery-payment-expiration-month',
						year: '#florist-one-flower-delivery-payment-expiration-year'
					}
  			},
  			"florist-one-flower-delivery-payment-security-code": {
  				required: true,
  				maxlength: 4
  			},
				"": {

				}
  		},
  		onkeyup: false,
      onfocusout: function(element) {
          if ($(element).hasClass('ofo')) {
              this.element(element);
          }
      },
  		onchange: false,
  		focusInvalid: false,
  		errorClass: "alert alert-danger w-100",
  		invalidHandler: function(event, validator) {
        submitted = true;
  		},
  		showErrors: function(errorMap, errorList) {

  		 if (submitted) {
  		    $(".floristone-checkout-errors").remove();
            var summary = "Please ensure you have entered the following: <br/><br/>";
            $.each(errorList, function() {

            var inputName = $("label[for='" + this.element.id + "']").text();
            var inputName = inputName.split('*');
            var sectionLabel = "";

            var section = this.element.id.split("-")
            if (section.indexOf("customer") !== -1){

              sectionLabel = "Bill To ";

            }
            if (section.indexOf("recipient") !== -1){

              sectionLabel = "Deliver To ";

            }

            summary +=  sectionLabel + inputName[0] + "<br/>";

            });
            $(".checkout-form-continue-next-step").before('<div class="my-2 alert alert-danger floristone-checkout-errors">' + summary + '</div>');
            submitted = false;
        }


        this.defaultShowErrors();
      },
  		submitHandler: function(){

				// tokenized payment
				if ($("#florist-one-flower-delivery-payment-credit-card-number").length) {
					var data = $form.serializeArray();
					sendPaymentDataToAnet(data);
				}

				// hosted forms (authnet or stripe)
				else {
					var checkValue = (jQuery("#florist-one-flower-delivery-purchase-recognition-check").prop('checked'))? "on" : "";
					var data = $form.serializeArray().concat({
						name: "florist-one-flower-delivery-purchase-recognition-check", value: checkValue
					});

					var checkValue2 = (jQuery("#florist-one-flower-delivery-allow-substitutions-check").prop('checked'))? "on" : "";
					data = $form.serializeArray().concat({
						name: "florist-one-flower-delivery-allow-substitutions-check", value: checkValue2
					});

					checkout(4, data, ($('#fhws-main-obit').is(':visible')) ? 1 : 0, true);

					// switch payment module based on client country
					if ($("#international_tree").length){
						// international tree
						createPaymentLink();
					}
					else {
						// us or ca client country
						$(document).ajaxStop(function(){
							$('#fws-checkout-form-payment').trigger("click");
						});
					}
				}

  		},
  		errorPlacement: function(error, element)
       {
            if ( element.is(":radio") )
            {
              error.insertBefore( element.parents('#florist-one-flower-delivery-tree-certificate-info') );
            }
            else
            { // This is the default behavior
                error.insertAfter( element );
            }
        },
        messages:
        {
          "florist-one-flower-delivery-tree-certificate":
          {
            required:"Please select a delivery method."
          }
        },
  	});
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
};

function sendPaymentDataToAnet(data) {

	console.log(data);

      var authData = {
        // plug in dynamic authorizenet credentials from getauthorizenetkey
        clientKey: $("#florist-one-flower-delivery-payment-client-key").val(),
        apiLoginID: $("#florist-one-flower-delivery-payment-username").val()
      };

      var cardData = {};
      cardData.cardNumber = $("#florist-one-flower-delivery-payment-credit-card-number").val();
      cardData.month = $("#florist-one-flower-delivery-payment-expiration-month").val();
      cardData.year = $("#florist-one-flower-delivery-payment-expiration-year").val();
      cardData.cardCode = $("#florist-one-flower-delivery-payment-security-code").val();

			// remove card info from form scope so not stored in browser
			data = $.grep(data, function(value) {
				return value.name != "florist-one-flower-delivery-payment-credit-card-number"
					&& value.name != "florist-one-flower-delivery-payment-expiration-month"
					&& value.name != "florist-one-flower-delivery-payment-expiration-year"
					&& value.name != "florist-one-flower-delivery-payment-security-code"
					&& value.name != "florist-one-flower-delivery-payment-username"
					&& value.name != "florist-one-flower-delivery-payment-client-key";
			});
			console.log(data);

      var secureData = {};
      secureData.authData = authData;
      secureData.cardData = cardData;

      Accept.dispatchData(secureData, function(response){

	      if (response.messages.resultCode == 'Ok'){
	        $("#florist-one-flower-delivery-payment-token").val(response.opaqueData.dataValue);
					var flowers = $("#florist-one-flower-delivery-product-product-type").val() != 'TREES';
					placeOrder(data, flowers, $("#florist-one-flower-delivery-payment-order-total").val(), $("#florist-one-flower-delivery-payment-token").val());
	      }
	      else {
					var errorList = response.messages.message;
					$(".floristone-checkout-errors").remove();
					var summary = "<p>Please check your credit card information</p>";
					summary += "<ul>";
					$.each(errorList, function() {
						summary += "<li>" + this.text + "</li>";
					});
					summary += "</ul>";
					$(".checkout-form-continue-next-step").before('<div class="my-2 alert alert-danger floristone-checkout-errors">' + summary + '</div>');
	      }

			});

    }


$(document)
	.ready(function(){

    jQuery.validator.addMethod("phoneNumber", function(phone_number, element) {
			phone_number = phone_number.replace(/\s+/g, "");
			return this.optional(element) ||
				phone_number.match(/(.*?\d){10}/gm);
		}, "Please specify a valid phone number");


		jQuery.validator.addMethod("customerZip", function(value, element) {

		  var $cVal = jQuery('#florist-one-flower-delivery-customer-country').val();
        if($cVal == "CA"){
          return this.optional(element) || /(^[A-Za-z]{1}\d{1}[A-Za-z]{1} *\d{1}[A-Za-z]{1}\d{1}$)/.test(value);
        }
        if ($cVal == "US"){
          return this.optional(element) || /(^\d{5}$)/.test(value);
        }

        if ($cVal != "US" && $cVal != "CA" ){
          return this.optional(element) || /(.*?)/.test(value);
        }

      }, function () {

        var $cVal = jQuery('#florist-one-flower-delivery-customer-country').val();

        var msg;
        if ($cVal == "CA"){
          msg="Please enter a valid Canadian postal code.";
          return msg;
        }

        if ($cVal == "US"){
          msg="Please enter a valid 5 digit zip code." ;
          return msg;
        }
		});

		jQuery.validator.addMethod("recipientZip", function(value, element) {
      var $cVal = jQuery('#florist-one-flower-delivery-recipient-country').val();
		  if($cVal == "CA"){
		    return this.optional(element) || /(^[A-Za-z]{1}\d{1}[A-Za-z]{1} *\d{1}[A-Za-z]{1}\d{1}$)/.test(value);
		  }
		  if ($cVal == "US"){
		    return this.optional(element) || /(^\d{5}$)/.test(value);
		  }
		}, function () {

		  var $cVal = jQuery('#florist-one-flower-delivery-recipient-country').val();
		  var msg;
		  if ($cVal == "CA"){
          msg="Please enter a valid Canadian postal code.";
		  }
		  if ($cVal == "US"){
          msg="Please enter a valid 5 digit zip code." ;
		  }

		  return msg;

		});

		jQuery.validator.addMethod("emailVer", function(value, element) {
			return this.optional(element) || /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(value)
		}, "Please enter a valid email address");

		jQuery.validator.addMethod("CCExp", function(value, element, params) {
			var minMonth = new Date().getMonth() + 1;
			var minYear = new Date().getFullYear();
			minYear = (minYear + '').substring(2, 4);
			var month = parseInt($(params.month).val(), 10);
			var year = parseInt($(params.year).val(), 10);
			return this.optional(element) || (year > minYear || (year == minYear && month >= minMonth));
		}, "Your Credit Card Expiration date is invalid.");

		jQuery.validator.addMethod("CCCVV2", function(value, element, params) {
			var cc_type = $(params.cc_type).val();
			var cc_cvv2 = $(params.cc_cvv2).val();
			return this.optional(element) || ((cc_type == 'AX' && cc_cvv2.length == 4) || (cc_type != 'AX' && cc_cvv2.length == 3));
		}, "Your CVV2 is invalid.");

		jQuery.validator.addMethod("creditCardNumber", function(value, element) {
			var strippedValue = value.replace(/[^0-9]+/g,'');
			return this.optional(element) ||  /^.{15,16}$/.test(strippedValue)
		}, "Please enter a valid credit card number.");

	})
  .ajaxStart(function () {

   jQuery('#florist-one-flower-delivery-loader').removeClass("d-none");

  })

  .ajaxStop(function () {

    jQuery('#florist-one-flower-delivery-loader').addClass("d-none");


  });

})( jQuery );
