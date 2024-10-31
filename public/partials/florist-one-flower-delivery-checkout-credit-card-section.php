<tr>
  <td><h5>Credit Card*</h5></td>
  <td>
    <select class="florist-one-flower-delivery-billing-credit-card full" id="florist-one-flower-delivery-billing-credit-card" name="florist-one-flower-delivery-billing-credit-card">
      <option value="AX" <?php echo ($_SESSION['florist-one-flower-delivery-billing-credit-card']=='AX'? 'selected="selected"' : '' ) ?>>American Express</option>
      <option value="VI" <?php echo ($_SESSION['florist-one-flower-delivery-billing-credit-card']=='VI'? 'selected="selected"' : '' ) ?>>Visa</option>
      <option value="MC" <?php echo ($_SESSION['florist-one-flower-delivery-billing-credit-card']=='MC'? 'selected="selected"' : '' ) ?>>MasterCard</option>
      <option value="DI" <?php echo ($_SESSION['florist-one-flower-delivery-billing-credit-card']=='DI'? 'selected="selected"' : '' ) ?>>Discover</option>
    </select>
  </td>
</tr>
<tr>
  <td><h5>Card Number*</h5></td>
  <td><input type="text" class="florist-one-flower-delivery-billing-credit-card-no" id="florist-one-flower-delivery-billing-credit-card-no" name="florist-one-flower-delivery-billing-credit-card-no" value="<?php echo $_SESSION["florist-one-flower-delivery-billing-credit-card-no"] ?>"></td>
</tr>
<tr>
  <td><h5>Expiration Date*</h5></td>
  <td>
    <select class="florist-one-flower-delivery-billing-exp-month half" id="florist-one-flower-delivery-billing-exp-month" name="florist-one-flower-delivery-billing-exp-month">
      <?php
        $billingExpMonth = $_SESSION['florist-one-flower-delivery-billing-exp-month'];
        for($month=1; $month<=12; $month++){
          $monthFormatted = sprintf("%02d", $month);
          echo '<option value="' . $monthFormatted . '" ' . ($billingExpMonth == $monthFormatted ? 'selected="selected"' : ""). '>' . $monthFormatted . '</option>';
        }
      ?>
    </select>
    <select class="florist-one-flower-delivery-billing-exp-year half" id="florist-one-flower-delivery-billing-exp-year" name="florist-one-flower-delivery-billing-exp-year">
      <?php
        $billingExpYear = $_SESSION['florist-one-flower-delivery-billing-exp-year'];
        $currentYear = date('Y');
        $years = range($currentYear, $currentYear + 20);
           foreach($years as $year){
            echo '<option value="'. substr($year, -2) . '"' . ($billingExpYear == substr($year, -2) ? ' selected="selected"' : "" ). '>'. $year . '</option>';
           }
      ?>
    </select>
  </td>
</tr>
<tr>
  <td><h5>Security Code*</h5></td>
  <td><input type="text" class="florist-one-flower-delivery-billing-security-code" id="florist-one-flower-delivery-billing-security-code" name="florist-one-flower-delivery-billing-security-code" value="<?php echo $_SESSION["florist-one-flower-delivery-billing-security-code"] ?>"></td>
</tr>
<tr>
  <td colspan="2">Secure Transaction: For your protection, this website is secured with the highest level of Secure Sockets Layer (SSL) Certificate encryption, so your personal information, including your credit card number, cannot be read as it travels over the internet.</td>
</tr>
