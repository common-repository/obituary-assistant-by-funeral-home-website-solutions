<?php
/**
 * @link       https://www.floristone.com
 * @since      1.0.0
 *
 * @package    Florist_One_Flower_Delivery
 * @subpackage Florist_One_Flower_Delivery/public/partials
 */
?>

<?php

  $config_options_aff = get_option('fhw-solutions-obituaries_1');
  $config_options = get_option('fhw-solutions-obituaries_3');

  $navStyle = (isset($config_options['navigation_style'])) ? $config_options['navigation_style'] : "";

  $nav_color_1 = ($navStyle != "custom") ? '#000000' : $config_options['navigation_color'];
  $nav_color_2 = ($navStyle != "custom") ? '#000000' : $config_options['navigation_hover_color'];
  $nav_text = ($navStyle != "custom") ? '#ffffff' : $config_options['navigation_text_color'];
  $nav_hover = ($navStyle != "custom") ? '#000000' :$config_options['navigation_hover_text_color'];
  $btn_1 = ($navStyle != "custom") ? '#ffffff' : $config_options['button_color'];
  $btn_2 = ($navStyle != "custom") ? '#ffffff' : $config_options['button_hover_color'];
  $btn_hover = ($navStyle != "custom") ? '#000000' : $config_options['button_hover_text_color'];
  $btn_text = ($navStyle != "custom") ? 'rgba(0,0,0,.75)' : $config_options['button_text_color'];
  $link_text = ($navStyle != "custom") ? '#000000' : $config_options['link_color'];
  $header_color = ($navStyle != "custom") ? '#000000' : $config_options['heading_color'];
  $body_text = ($navStyle != "custom") ? '#444444' : $config_options['text_color'];
  $show_text_size = ($obit == "obit") ? 'false' : 'true';
?>


<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<style>

  .florist-one-flower-delivery-ssl-warning {
    display:none;
  }
  .florist-one-flower-delivery{
    color: <?php echo $body_text ?>
  }
  .florist-one-flower-delivery a, .florist-one-flower-delivery a:link, .florist-one-flower-delivery a:hover, .florist-one-flower-delivery a:active, .florist-one-flower-delivery a:visited{
    color: <?php echo $link_text ?>

  }
  .bootstrap-fhws-obituaries-container .page-item.active .page-link {
    color: <?php echo $link_text ?>;
    border-bottom: <?php echo $link_text ?> 2px solid !important;
    opacity:1;
  }

  .bootstrap-fhws-obituaries-container .page-item .page-link {
    color: <?php echo $link_text ?> !important;
    opacity:.85;
  }
  .bootstrap-fhws-obituaries-container .page-item .page-link:hover {
    color: <?php echo $link_text ?> !important;
    border-bottom: <?php echo $link_text ?> 1px solid;
    opacity:1;

  }

   #florist-one-flower-delivery-menu-nav .nav-link, #florist-one-flower-delivery-menu-cart-button {

     background: none;
     color: <?php echo $body_text ?>;

  }

  .bootstrap-fhws-obituaries-container .nav-pills .nav-link.active  {
    position:relative;
  }

  .bootstrap-fhws-obituaries-container .nav-pills .nav-link.active:after {

    content:'';
    position:absolute;
    left:25%;
    background:#222222;
    width:50%;
    height:1px;
    bottom:5px;
  }

  @media (max-width: 767.98px) {
    .bootstrap-fhws-obituaries-container .nav-pills .nav-link.active:after {
      bottom:2px;
    }
  }

  #florist-one-flower-delivery-menu-nav .nav-link:hover, #florist-one-flower-delivery-menu-cart-button:hover {

    color: <?php echo $nav_hover ?>;

  }

  #florist-one-flower-delivery-menu-nav .nav-link.active   {
    background: <?php echo $nav_color_1 ?>;
    background: -moz-linear-gradient(top, <?php echo $nav_color_1 ?> 0%, <?php echo $nav_color_2 ?> 40%, <?php echo $nav_color_2 ?> 60%, <?php echo $nav_color_1 ?> 100%);
    background: -webkit-linear-gradient(top, <?php echo $nav_color_1 ?> 0%, <?php echo $nav_color_2 ?> 40%, <?php echo $nav_color_2 ?> 60%, <?php echo $nav_color_1 ?> 100%);
    background: linear-gradient(to bottom, <?php echo $nav_color_1 ?> 0%, <?php echo $nav_color_2 ?> 40%, <?php echo $nav_color_2 ?> 60%, <?php echo $nav_color_1 ?> 100%);
    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='<?php echo $nav_color_1 ?>', endColorstr='<?php echo $nav_color_2 ?>',GradientType=0 );
    color: <?php echo $nav_text ?>;
    text-decoration: none;
  }

  #florist-one-flower-delivery-view-modal .btn,
  .florist-one-flower-delivery-button .btn,
  a.large-button,
  a.large-button:link,
  a.large-button:visited,
  a.large-button:active,
  input.large-button,
  .florist-one-flower-delivery .btn,
  a.florist-one-flower-delivery-button:link,
  a.florist-one-flower-delivery-button:visited,
  a.florist-one-flower-delivery-button:active {
    background: <?php echo $btn_1 ?>;
    background: -moz-linear-gradient(top,  <?php echo $btn_1 ?> 0%, <?php echo $btn_2 ?> 40%, <?php echo $btn_2 ?> 60%, <?php echo $btn_1 ?> 100%);
    background: -webkit-linear-gradient(top,  <?php echo $btn_1 ?> 0%, <?php echo $btn_2 ?> 40%, <?php echo $btn_2 ?> 60%, <?php echo $btn_1 ?> 100%);
    background: linear-gradient(to bottom,  <?php echo $btn_1 ?> 0%, <?php echo $btn_2 ?> 40%, <?php echo $btn_2 ?> 60%, <?php echo $btn_1 ?> 100%);
    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='<?php echo $btn_1 ?>', endColorstr='<?php echo $btn_2 ?>',GradientType=0 );
    color: <?php echo $btn_text ?>;
    text-decoration: none;
  }


  ul.florist-one-flower-delivery-menu-desktop-menu a:hover,
  div.florist-one-flower-delivery-menu-mobile-menu .slicknav_menu .slicknav_nav a:hover,
  div.florist-one-flower-delivery-menu-cart:hover {
    background: <?php echo $nav_color_2 ?>;
    background: -moz-linear-gradient(top, <?php echo $nav_color_2 ?> 0%, <?php echo $nav_color_1 ?> 40%, <?php echo $nav_color_1 ?> 60%, <?php echo $nav_color_2 ?> 100%);
    background: -webkit-linear-gradient(top, <?php echo $nav_color_2 ?> 0%, <?php echo $nav_color_1 ?> 40%, <?php echo $nav_color_1 ?> 60%, <?php echo $nav_color_2 ?> 100%);
    background: linear-gradient(to bottom, <?php echo $nav_color_2 ?> 0%, <?php echo $nav_color_1 ?> 40%, <?php echo $nav_color_1 ?> 60%, <?php echo $nav_color_2 ?> 100%);
    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='<?php echo $nav_color_2 ?>', endColorstr='<?php echo $nav_color_1 ?>',GradientType=0 );
    color: <?php echo $nav_hover ?>;
  }

  #florist-one-flower-delivery-view-modal .btn:hover,
  .florist-one-flower-delivery .btn:hover,
  a.florist-one-flower-delivery-button:hover,
  a.large-button:hover,
  input.large-button:hover,
  a.florist-one-flower-delivery-button:hover  {
    background: <?php echo $btn_2 ?>;
    background: -moz-linear-gradient(top,  <?php echo $btn_2 ?> 0%, <?php echo $btn_1 ?> 40%, <?php echo $btn_1 ?> 60%, <?php echo $btn_2 ?> 100%);
    background: -webkit-linear-gradient(top,  <?php echo $btn_2 ?> 0%, <?php echo $btn_1 ?> 40%, <?php echo $btn_1 ?> 60%, <?php echo $btn_2 ?> 100%);
    background: linear-gradient(to bottom,  <?php echo $btn_2 ?> 0%, <?php echo $btn_1 ?> 40%, <?php echo $btn_1 ?> 60%, <?php echo $btn_2 ?> 100%);
    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='<?php echo $btn_2 ?>', endColorstr='<?php echo $btn_1 ?>',GradientType=0 );
    color: <?php echo $btn_hover ?>;
    text-decoration: none;
  }

  ul.florist-one-flower-delivery-menu-desktop-menu a:link, ul.florist-one-flower-delivery-menu-desktop-menu a:visited, ul.florist-one-flower-delivery-menu-desktop-menu a:active, div.florist-one-flower-delivery-menu-cart a{
    text-decoration: none;
    color: <?php echo $nav_text ?>;
  }
  ul.florist-one-flower-delivery-menu-desktop-menu a:hover, div.florist-one-flower-delivery-menu-cart a:hover{
    text-decoration: none;
    color: <?php echo $nav_hover ?>;
  }
  .florist-one-flower-delivery-loading:not(:required):after {
   -webkit-box-shadow: <?php echo $nav_color_1 ?> 1.5em 0 0 0, <?php echo $nav_color_1 ?> 1.1em 1.1em 0 0, <?php echo $nav_color_1 ?> 0 1.5em 0 0, <?php echo $nav_color_1 ?> -1.1em 1.1em 0 0, <?php echo $nav_color_1 ?> -1.5em 0 0 0, <?php echo $nav_color_1 ?> -1.1em -1.1em 0 0, <?php echo $nav_color_1 ?> 0 -1.5em 0 0, <?php echo $nav_color_1 ?> 1.1em -1.1em 0 0;
   box-shadow: <?php echo $nav_color_1 ?> 1.5em 0 0 0, <?php echo $nav_color_1 ?> 1.1em 1.1em 0 0, <?php echo $nav_color_1 ?> 0 1.5em 0 0, <?php echo $nav_color_1 ?> -1.1em 1.1em 0 0, <?php echo $nav_color_1 ?> -1.5em 0 0 0, <?php echo $nav_color_1 ?> -1.1em -1.1em 0 0, <?php echo $nav_color_1 ?> 0 -1.5em 0 0, <?php echo $nav_color_1 ?> 1.1em -1.1em 0 0;
  }
  .florist-one-flower-delivery h1, .florist-one-flower-delivery h2, .florist-one-flower-delivery h3, .florist-one-flower-delivery h4{
    color: <?php echo $header_color ?>;
  }
  #florist-one-flower-delivery-loader {
   color: <?php echo $header_color ?>;
  }

 <?php if ($config_options['navigation_style'] != "custom") {  ?>

  .f1fd_primary {
      background:#000000 !important;
      color:#ffffff !important;
    }
    .f1fd_secondary {
      background:#ffffff !important;
      color:#000000 !important;
    }
    .f1fd_secondary:hover {
      border:1px #222222 solid !important;
    }
    .florist-one-flower-delivery-menu-link-more {
      border:1px #222222 solid !important;
    }
    .bootstrap-fhws-obituaries-container .nav-link:focus, .f1fd-size-ctl:focus,
    .bootstrap-fhws-obituaries-container a:focus,
    .bootstrap-fhws-obituaries-container button:focus,
    .bootstrap-fhws-obituaries-container input:focus,
    .bootstrap-fhws-obituaries-container textarea:focus {
      outline:none !important;
      -moz-box-shadow:    inset 0 0 2px rgba(0,0,0,.55) !important;
      -webkit-box-shadow: inset 0 0 2px rgba(0,0,0,.55) !important;
      box-shadow:        inset 0 0 2px rgba(0,0,0,.55) !important;
      color:#000000;
    }
    /* active styling */
    #florist-one-flower-delivery-menu-nav .nav-link.active, .f1fd-size-ctl.active {
      position:relative !important;
      color:#000000;
      background:none;
    }

    #florist-one-flower-delivery-menu-nav .nav-link.active:after, .f1fd-size-ctl.active:after {
      content:'';
      position:absolute;
      width:calc(100% - 14px);
      height:1px;
      background:#000;
      left:7px;
      bottom:6px;
    }

    .f1fd-size-ctl.active:after {
      width:calc(100% - 6px);
      bottom:0;
      left:3px;
    }

  <?php } ?>

  <?php if ($obit == "obit"){ ?>
    .f1fd-product-image {
      flex:0 1 350px;
    }
    .f1fd-product-discription {
      flex:1 1 300px;
    }
    .florist-one-flower-delivery-many-products-display img {
      width:150px !important;
    }
    .florist-one-flower-delivery-many-products-display  {
      flex:1 1 180px !important;
    }
    .florist-one-flower-delivery-many-products-display-button {
      max-width:160px;
    }
  <?php } else { ?>
    .f1fd-product-image {
      flex:0 1 400px;
    }
    .f1fd-product-discription {
      flex:0 1 500px;
    }
    .florist-one-flower-delivery-many-products-display  {
      flex:1 1 200px;
    }
    .florist-one-flower-delivery-many-products-display img {
      width:180px !important;
    }
    .florist-one-flower-delivery-many-products-display-button {
      max-width:200px;
    }
  <?php } ?>

</style>

<?php
  if ($config_options_aff['affiliate_id'] == 0 && $config_options_aff['account_type'] != 7) {
      echo '<div class="florist-one-flower-delivery-ssl-warning">&#9888; A valid Florist One AffiliateID is required for the Florist One Flower Delivery plugin to work!</div>';
  }
?>

<div class="florist-one-flower-delivery-menu">

  <?php

    $categories = array();

    array_push($categories, array('short' => 'fbs', 'long' => 'Best Sellers'));
    array_push($categories, array('short' => 'fa', 'long' => 'Table Arrangements'));
    array_push($categories, array('short' => 'fb', 'long' => 'Baskets'));
    array_push($categories, array('short' => 'fs', 'long' => 'Sprays'));
    array_push($categories, array('short' => 'fp', 'long' => 'Plants'));
    array_push($categories, array('short' => 'fl', 'long' => 'Inside Casket'));
    array_push($categories, array('short' => 'fw', 'long' => 'Wreaths'));
    array_push($categories, array('short' => 'fh', 'long' => 'Hearts'));
    array_push($categories, array('short' => 'fx', 'long' => 'Crosses'));
    array_push($categories, array('short' => 'fc', 'long' => 'Casket Sprays'));
    array_push($categories, array('short' => 'fu', 'long' => 'Urn Arrangements'));

    $show_flowers = "";
    $show_trees = "";

    if (isset($_GET['show_flowers'])) {
      $show_flowers = $_GET['show_flowers'];
    }

     if (isset($_GET['show_trees'])) {
      $show_trees = $_GET['show_trees'];
    }

    $tree_active = ($show_trees == 1 )? "active" : "";

    $cart_count = 0;

  ?>

<div class="row mb-4">
  <?php if($show_text_size == "true") { ?>
    <div class="flex-row d-flex justify-content-end text-dark mt-1 mb-1" style="font-size:22px"><!-- start of text size options-->
      <span class="d-flex align-items-center me-2">Text:</span>
      <a class="active px-1 d-flex f1fd-size-ctl" id="f1fd-text-size-base" tabindex="0" role="button" >
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-type" viewBox="0 0 16 16">
          <path d="m2.244 13.081.943-2.803H6.66l.944 2.803H8.86L5.54 3.75H4.322L1 13.081h1.244zm2.7-7.923L6.34 9.314H3.51l1.4-4.156h.034zm9.146 7.027h.035v.896h1.128V8.125c0-1.51-1.114-2.345-2.646-2.345-1.736 0-2.59.916-2.666 2.174h1.108c.068-.718.595-1.19 1.517-1.19.971 0 1.518.52 1.518 1.464v.731H12.19c-1.647.007-2.522.8-2.522 2.058 0 1.319.957 2.18 2.345 2.18 1.06 0 1.716-.43 2.078-1.011zm-1.763.035c-.752 0-1.456-.397-1.456-1.244 0-.65.424-1.115 1.408-1.115h1.805v.834c0 .896-.752 1.525-1.757 1.525z"/>
        </svg>
      </a>
      <a class="px-1 d-flex align-items-center f1fd-size-ctl justify-content-center" id="f1fd-text-size-zoom1" tabindex="0" role="button">
        <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" fill="currentColor" class="bi bi-type" viewBox="0 0 16 16">
          <path d="m2.244 13.081.943-2.803H6.66l.944 2.803H8.86L5.54 3.75H4.322L1 13.081h1.244zm2.7-7.923L6.34 9.314H3.51l1.4-4.156h.034zm9.146 7.027h.035v.896h1.128V8.125c0-1.51-1.114-2.345-2.646-2.345-1.736 0-2.59.916-2.666 2.174h1.108c.068-.718.595-1.19 1.517-1.19.971 0 1.518.52 1.518 1.464v.731H12.19c-1.647.007-2.522.8-2.522 2.058 0 1.319.957 2.18 2.345 2.18 1.06 0 1.716-.43 2.078-1.011zm-1.763.035c-.752 0-1.456-.397-1.456-1.244 0-.65.424-1.115 1.408-1.115h1.805v.834c0 .896-.752 1.525-1.757 1.525z"/>
        </svg>
      </a>
      <a class="px-1 d-flex align-items-center f1fd-size-ctl justify-content-center" id="f1fd-text-size-zoom2" tabindex="0" role="button">
        <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" class="bi bi-type" viewBox="0 0 16 16">
          <path d="m2.244 13.081.943-2.803H6.66l.944 2.803H8.86L5.54 3.75H4.322L1 13.081h1.244zm2.7-7.923L6.34 9.314H3.51l1.4-4.156h.034zm9.146 7.027h.035v.896h1.128V8.125c0-1.51-1.114-2.345-2.646-2.345-1.736 0-2.59.916-2.666 2.174h1.108c.068-.718.595-1.19 1.517-1.19.971 0 1.518.52 1.518 1.464v.731H12.19c-1.647.007-2.522.8-2.522 2.058 0 1.319.957 2.18 2.345 2.18 1.06 0 1.716-.43 2.078-1.011zm-1.763.035c-.752 0-1.456-.397-1.456-1.244 0-.65.424-1.115 1.408-1.115h1.805v.834c0 .896-.752 1.525-1.757 1.525z"/>
        </svg>
      </a>
    </div><!-- end of text size options-->
  <?php } ?>
  <div class="col-12">
    <nav id="florist-one-flower-delivery-menu-nav" class="navbar navbar-expand-md p-1 navbar-light md-bg-light d-none">
      <p class="d-sm-block d-md-none mx-auto fs-4 mb-1">Flower Menu</p>
      <div class="d-md-flex justify-content-center w-100 p-0">
        <button class="navbar-toggler h-25 w-100 me-auto" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav ms-0 flex-wrap justify-content-left text-center">
            <?php
              if (get_option('fhw-solutions-obituaries_1')['account_type'] != 6){
                echo '<li class="nav-item m-1 border"><a href="#" id="florist-one-flower-delivery-menu-link-0" class="nav-link florist-one-flower-delivery-menu-plant-a-tree-link ' . $tree_active .'" data-category="pt" data-bs-toggle="collapse" data-bs-target=".navbar-collapse.show">Plant Trees</a></li>';
              }

              for ($i=0;$i<count($categories);$i++) {
                $active_flowers = ($show_flowers == 1 && $i==0) ? "active":"";
                echo '<li class="nav-item m-1 border"><a href="#" id="florist-one-flower-delivery-menu-link-'. ($i+1) .'" data-bs-toggle="collapse" data-bs-target=".navbar-collapse.show" class="nav-link florist-one-flower-delivery-menu-link ' . $active_flowers .'" data-page="1" data-category="'.$categories[$i]['short'].'">'.$categories[$i]['long'].'</a></li>';
              }
            ?>
            <li class="nav-item m-1 border"><a href="#" id="florist-one-flower-delivery-menu-link-99" data-bs-toggle="collapse" data-bs-target=".navbar-collapse.show" class="nav-link florist-one-flower-delivery-menu-customer-service-link" data-category="">Customer Service</a></li>
          </ul>
            </div>
            <button type="button" id="florist-one-flower-delivery-menu-cart-button" data-bs-toggle="modal" data-bs-target="#florist-one-flower-delivery-view-modal" href="#" class="florist-one-flower-delivery-menu-cart-button btn mx-auto border-0 p-1  nav-link  mt-1 p-2  h-100 mb-auto ">
              <span id="florist-one-cart-count" class="rounded-circle badge bg-dark"><?php echo $cart_count;?><span class="visually-hidden">Items in Cart</span></span>
                <svg viewBox="0 0 24 24" width="36" height="36" stroke="currentColor" stroke-width="2" fill="currentColor" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                <p class="lh-1 text-muted">My Cart</p>
            </button>
        </div>
      </nav>
    </div>
  </div>
</div>

<div class="bootstrap-fhws-obituaries-container bootstrap-fhws-obituaries-container-1"><!--modal container-->
  <div class="modal fhws-modal fade" id="florist-one-flower-delivery-view-modal" tabindex="-1" aria-labelledby="florist-one-flower-delivery-view-modal-label" aria-hidden="true" data-bs-backdrop="false" style="background-color: rgba(0, 0, 0, 0.3);">
    <div class="modal-dialog fhws-modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header py-1 border-0">
          <div class="modal-header-text"></div>
          <button type="button" class="ms-auto f1fd_secondary border-0" data-bs-dismiss="modal" aria-label="Close">
            <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
          </button>
        </div>
        <div class="modal-body px-4 py-4">
        </div>
      </div>
    </div>
  </div>
</div><!-- end container -->
