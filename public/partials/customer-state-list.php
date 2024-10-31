<?php 

$canadian_provinces = array( 
    "BC" => "British Columbia", 
    "ON" => "Ontario", 
    "NL" => "Newfoundland and Labrador", 
    "NS" => "Nova Scotia", 
    "PE" => "Prince Edward Island", 
    "NB" => "New Brunswick", 
    "QC" => "Quebec", 
    "MB" => "Manitoba", 
    "SK" => "Saskatchewan", 
    "AB" => "Alberta", 
    "NT" => "Northwest Territories", 
    "NU" => "Nunavut",
    "YT" => "Yukon Territory"
);

ksort($canadian_provinces);

$us_states = array(

  'AP' => 'APO/FPO',
  'AL' => 'Alabama',
  'AK' => 'Alaska',
  'AZ' => 'Arizona',
  'AR' => 'Arkansas',
  'CA' => 'California',
  'CO' => 'Colorado',
  'CT' => 'Connecticut',
  'DE' => 'Delaware',
  'DC' => 'District Of Columbia',
  'FL' => 'Florida',
  'GA' => 'Georgia',
  'HI' => 'Hawaii',
  'ID' => 'Idaho',
  'IL' => 'Illinois',
  'IN' => 'Indiana',
  'IA' => 'Iowa',
  'KS' => 'Kansas',
  'KY' => 'Kentucky',
  'LA' => 'Louisiana',
  'ME' => 'Maine',
  'MD' => 'Maryland',
  'MA' => 'Massachusetts',
  'MI' => 'Michigan',
  'MN' => 'Minnesota',
  'MS' => 'Mississippi',
  'MO' => 'Missouri',
  'MT' => 'Montana',
  'NE' => 'Nebraska',
  'NV' => 'Nevada',
  'NH' => 'New Hampshire',
  'NJ' => 'New Jersey',
  'NM' => 'New Mexico',
  'NY' => 'New York',
  'NC' => 'North Carolina',
  'ND' => 'North Dakota',
  'OH' => 'Ohio',
  'OK' => 'Oklahoma',
  'OR' => 'Oregon',
  'PR' => 'Puerto Rico',
  'PA' => 'Pennsylvania',
  'RI' => 'Rhode Island',
  'SC' => 'South Carolina',
  'SD' => 'South Dakota',
  'TN' => 'Tennessee',
  'TX' => 'Texas',
  'UT' => 'Utah',
  'VT' => 'Vermont',
  'VA' => 'Virginia',
  'WA' => 'Washington',
  'WV' => 'West Virginia',
  'WI' => 'Wisconsin',
  'WY' => 'Wyoming',

);

  $country =  (isset($_SESSION['florist-one-flower-delivery-customer-country'])) ? $_SESSION['florist-one-flower-delivery-customer-country'] : "US";
  $selected = (isset($_SESSION['florist-one-flower-delivery-customer-state'])) ? $_SESSION['florist-one-flower-delivery-customer-state'] : "";
  foreach ($canadian_provinces as $key => $value) { 
      
      echo '<option class="fhws-country-ca '. ($country == "CA" ? '' : 'fhws-hide-state') . '" value="' . $key . '" ' . ($country == "CA" && $selected == $key ? 'selected="selected"' : '') . '>' . $value . '</option>';
      
  }
  
  foreach ($us_states as $key => $value) { 
      
       
      echo '<option class="fhws-country-us ' . ($country == "US" ? '' : 'fhws-hide-state')  . '" value="' . $key . '" ' . ($country == "US" && $selected == $key ? 'selected="selected"' : '') . '>' . $value . '</option>';
      
  }

?>
    




