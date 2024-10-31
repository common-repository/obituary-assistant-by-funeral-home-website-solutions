<div class="bootstrap-fhws-obituaries-container bootstrap-fhws-obituaries-container-1"><!--modal container-->
  <div class="modal fhws-modal fade" id="fhw-solutions-obituries-modal" data-bs-backdrop="false" aria-labelledby="fhw-solutions-obituries-modal-label" aria-hidden="true" style="background-color: rgba(0, 0, 0, 0.3);">
    <div class="modal-dialog fhws-modal-dialog modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header bg-light">
          <h5 class="modal-title"><?php echo $jsonString["CLIENT_ELEMENTS"]["PHOTO_POPUP_HEADING"]; ?></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body"><p><?php echo $jsonString["CLIENT_ELEMENTS"]["PHOTO_POPUP_EXPLANATION"]; ?></p>
          <form id="fws-solutions-obit-login">
            <div class="mb-3">
              <label for="name-in" class="form-label"><?php echo $jsonString["CLIENT_ELEMENTS"]["NAME"];?></label>
              <input type="text" name="name-in" class="form-control" id="name-in" aria-describedby="nameInput" >
            </div>
            <div class="mb-3">
              <label for="email-in" class="form-label"><?php echo $jsonString["CLIENT_ELEMENTS"]["EMAIL"];?></label>
              <input type="email" class="form-control" id="email-in" aria-describedby="emailInput">
            </div>
            <div class="alert alert-info" role="alert">
              <?php echo $jsonString["CLIENT_ELEMENTS"]["PRIVACY_MESSAGE"]; ?>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" id="fws-solutions-obit-login-close" class="btn btn-outline-dark" data-bs-dismiss="modal"><?php echo $jsonString["CLIENT_ELEMENTS"]["PHOTO_BUTTON_2"]; ?></button>
          <button type="button" id="fws-solutions-obit-login-sumbit" class="btn btn-dark"><?php echo $jsonString["CLIENT_ELEMENTS"]["PHOTO_BUTTON_1"]; ?></button>
        </div>
      </div>
    </div>
  </div>
</div><!-- end container -->  