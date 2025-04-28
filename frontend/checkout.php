<?php
$pageTitle = "Checkout"; // This will be used in the title tag
$pageDescription = "Checkout and complete your purchase."; // This is used as the page desciption meta tag
$pageKeywords = "Ciao, Football, Ciao Football, Soccer, replica, shirt, football shirts, equipment, store, premium, checkjut, purchase, pay"; // This is used as the keywords meta tag

// Include the header file
include('../components/header.php');

// set lucide icons in variables
$errorIcon = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#8b0000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-triangle-alert"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3"/><path d="M12 9v4"/><path d="M12 17h.01"/></svg>';
$successIcon = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#0a5c36" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-badge-check"><path d="M3.85 8.62a4 4 0 0 1 4.78-4.77 4 4 0 0 1 6.74 0 4 4 0 0 1 4.78 4.78 4 4 0 0 1 0 6.74 4 4 0 0 1-4.77 4.78 4 4 0 0 1-6.75 0 4 4 0 0 1-4.78-4.77 4 4 0 0 1 0-6.76Z"/><path d="m9 12 2 2 4-4"/></svg>';

// Initialize variables
$totalAmount = 0;
$hasItems = false;
$shippingCost = 5.99;
$totalItems = 0;

// Check if basket exists and has items
if (isset($_SESSION['basket']) && count($_SESSION['basket']) > 0) {
    $hasItems = true;
    
    // Calculate the total amount and count total items
    foreach ($_SESSION['basket'] as $key => $item) {
        $itemTotal = $item['price'] * $item['quantity'];
        $totalAmount += $itemTotal;
        $totalItems += $item['quantity'];
    }
}

// Calculate final total with shipping
$finalTotal = $totalAmount + $shippingCost;

// Redirect if no items in basket
if (!$hasItems) {
    header("Location: ../frontend/index.php");
    exit();
}
?>

<?php 
// include the back to top button file
include('../components/backtotopbutton.php');
?>

<main><!-- start of main content -->
    <section class = "checkout-header"> <!-- checkout page header -->
        <h1>Checkout</h1>
    </section><!-- end of checkout page header -->
    <section class="checkout-container">
    <!-- start of checkout container -->
    <div class="review-purchase-card">
        <div class="review-purchase-heading">
            <h2>
                <span class="review-purchase-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#050505" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-shopping-cart-icon lucide-shopping-cart">
                        <circle cx="8" cy="21" r="1" />
                        <circle cx="19" cy="21" r="1" />
                        <path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12" />
                    </svg>
                </span>Review Purchase
            </h2>
            <div class="total-items">
                <?php echo $totalItems; ?> item(s)
            </div>
        </div>
        <!-- end of review purchase heading -->
        <div class="review-purchase-body">
            <!-- start of review purchase body -->
            <?php foreach ($_SESSION['basket'] as $key => $item) : 
                $itemTotal = $item['price'] * $item['quantity'];
                
                // Check if it is a shirt or equipment item
                $isEquipment = isset($item['product_type']) ? 
                    $item['product_type'] === 'equipment' : 
                    (strpos($key, 'e') === 0);
                ?>
                <div class="checkout-item">
                    <!-- start of checkout item -->
                    <div class="checkout-item-image">
                        <img src="../<?php echo $item['image']; ?>" alt="Product image" class="checkout-item-image">
                    </div>
                    <div class="checkout-item-details">
                        <?php if ($isEquipment): ?>
                            <div class="checkout-review-order-top-row">
                                <!-- start of top row -->
                                <div class="checkout-item-name"><?php echo $item['name']; ?></div>
                                <!-- product name -->
                                <div class="checkout-item-quantity"> Qty: <?php echo $item['quantity']; ?></div>
                                <!-- product quantity -->
                            </div>
                            <!-- end of top row -->
                            <div class="checkout-review-order-info">
                                <!-- start of product info -->
                                <div class="checkout-item-info"><p class="product-info-bold">Brand: </p> <?php echo $item['brand']; ?></div>
                                <div class="checkout-item-info"><p class="product-info-bold">Category: </p> <?php echo $item['category']; ?></div>
                                <div class="checkout-item-price"> £<?php echo number_format($item['price'], 2); ?> </div>
                            </div>
                            <!-- end of product info -->
                        <?php else: ?>
                            <div class="checkout-review-order-top-row">
                                <!-- start of top row -->
                                <div class="checkout-item-name"><?php echo $item['team'] . ' ' . $item['year'] . ' ' . $item['type'] . ' Kit'; ?></div>
                                <!-- kit name -->
                                <div class="checkout-item-quantity"> Qty: <?php echo $item['quantity']; ?></div>
                                <!-- product quantity -->
                            </div>
                            <!-- end of top row -->
                            <div class="checkout-review-order-info">
                                <!-- start of product info -->
                                <div class="checkout-item-info"><p class="product-info-bold">Size: </p> <?php echo $item['size']; ?></div>
                                <div class="checkout-item-info"><p class="product-info-bold">Year: </p><?php echo $item['year']; ?></div>
                                <div class="checkout-item-info"><p class="product-info-bold">Category: </p> <?php echo $item['category']; ?></div>
                                <div class="checkout-item-price"> £<?php echo number_format($item['price'], 2); ?> </div>
                            </div>
                            <!-- end of product info -->
                        <?php endif; ?>
                    </div>
                </div>
                <!-- end of checkout item -->
            <?php endforeach; ?>
            <div class="review-purchase-footer">
                <!-- start of review purchase footer -->
                <div class="review-purchase-subtotal">
                    <p class="review-purchase-info-text">Subtotal:</p> 
                    <p class="review-purchase-money-info">£<?php echo number_format($totalAmount, 2); ?></p>
                </div>
                <div class="review-purchase-shipping">
                    <p class="review-purchase-info-text">Shipping:</p> 
                    <p class="review-purchase-money-info">£<?php echo number_format($shippingCost, 2); ?></p>
                </div>
                <div class="total-divider"></div>
                <div class="review-purchase-total">
                    <p class="review-purchase-info-text">Total:</p> 
                    <p class="review-purchase-money-info">£<?php echo number_format($finalTotal, 2); ?></p>
                </div>
            </div>
            <!-- end of review purchase footer -->
        </div>
        <!-- end of review purchase body -->
    </div>
    <!-- end of review purchase card -->
</section>
<!-- end of checkout container -->

<section class = "shipping-details-container"><!-- start of shipping details container -->
    <div class = "shipping-details-card"><!-- start of shipping details card-->
        <div class = "shipping-details-header"><!-- start of shipping details header -->
            <h2 class = "details-title"><span class = "shipping-details-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#050505" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-package-icon lucide-package"><path d="M11 21.73a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73z"/><path d="M12 22V12"/><polyline points="3.29 7 12 12 20.71 7"/><path d="m7.5 4.27 9 5.15"/></svg></span>Shipping Details</h2>
        </div><!-- end of shipping details header -->
        <form class="shipping-details-form" method="POST" action="/"><!-- start of shipping details form -->
    <div class="shipping-form-top-row"><!-- start of shipping form top row -->
        <div class="shipping-form-group"><!-- start of form group -->
            <label class="shipping-label" for="name">First Name: <span class = "field-required"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#8b0000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-asterisk-icon lucide-asterisk"><path d="M12 6v12"/><path d="M17.196 9 6.804 15"/><path d="m6.804 9 10.392 6"/></svg></span></label>
            <input class="shipping-input" type="text" name="name" placeholder="First Name:" required min="2" max="50">
        </div><!-- end of form group -->

        <div class="shipping-form-group"><!-- start of form group -->
            <label class="shipping-label" for="surname">Surname: <span class = "field-required"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#8b0000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-asterisk-icon lucide-asterisk"><path d="M12 6v12"/><path d="M17.196 9 6.804 15"/><path d="m6.804 9 10.392 6"/></svg></span></label>
            <input class="shipping-input" type="text" name="surname" placeholder="Surname:" required min="2" max="50">
        </div><!-- end of form group -->

        </div><!-- end of shipping form top row -->

        <div class = "shipping-form-second-row"><!-- start of shipping form second row -->
            <div class="shipping-form-group"><!-- start of form group -->
                <label class="shipping-label" for="email">Email: <span class = "field-required"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#8b0000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-asterisk-icon lucide-asterisk"><path d="M12 6v12"/><path d="M17.196 9 6.804 15"/><path d="m6.804 9 10.392 6"/></svg></span></label>
                <input class="shipping-input" type="email" name="email" placeholder="example@domain.com:" required>
            </div><!-- end of form group -->
            <div class="shipping-form-group"><!-- start of form group -->
            <label class="shipping-label" for="phone">Phone Number: <span class = "field-required"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#8b0000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-asterisk-icon lucide-asterisk"><path d="M12 6v12"/><path d="M17.196 9 6.804 15"/><path d="m6.804 9 10.392 6"/></svg></span></label>
            <input class="shipping-input" type="tel" name="phone" placeholder="+44 XXXX XXXXXX:" required>
        </div><!-- end of form group -->
        </div><!-- end of shipping form second row -->
    

    <!-- start of shipping form address row -->
    <div class="shipping-form-address-row">
        <div class="shipping-form-group"><!-- start of form group -->
            <label class="shipping-label" for="addressLine1">Address Line 1: <span class = "field-required"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#8b0000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-asterisk-icon lucide-asterisk"><path d="M12 6v12"/><path d="M17.196 9 6.804 15"/><path d="m6.804 9 10.392 6"/></svg></span></label>
            <input class="shipping-input"  type="text" name="addressLine1" placeholder="House/Flat/Apartment Number:" required min="1" max="10">
        </div><!-- end of form group -->
    </div><!-- end of shipping form address row -->

    <div class="shipping-form-address-row">
        <div class="shipping-form-group"><!-- start of form group -->
            <label class="shipping-label" for="addressLine2">Address Line 2: <span class = "field-required"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#8b0000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-asterisk-icon lucide-asterisk"><path d="M12 6v12"/><path d="M17.196 9 6.804 15"/><path d="m6.804 9 10.392 6"/></svg></span></label>
            <input class="shipping-input"  type="text" name="addressLine2" placeholder="Street Name:" required min="1" max="10">
        </div><!-- end of form group -->
    </div><!-- end of shipping form address row -->

    <div class="shipping-form-address-row">
        <div class="shipping-form-group"><!-- start of form group -->
            <label class="shipping-label" for="addressLine3">Address Line 3:</label>
            <input class="shipping-input"  type="text" name="addressLine3" placeholder="Additional address information (optional):" min="1" max="10">
        </div><!-- end of form group -->
    </div><!-- end of shipping form address row -->

    <div class="shipping-form-address-row">
        <div class="shipping-form-group"><!-- start of form group -->
            <label class="shipping-label" for="addressLine4">Address Line 4:</label>
            <input class="shipping-input"  type="text" name="addressLine4" placeholder="Additional address information (optional):" min="1" max="10">
        </div><!-- end of form group -->
    </div><!-- end of shipping form address row -->

    <!-- start of shipping form bottom row -->
    <div class="shipping-form-bottom-row">
        <div class="shipping-form-group"><!-- start of form group -->
            <label class="shipping-label" for="city">Town/City: <span class = "field-required"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#8b0000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-asterisk-icon lucide-asterisk"><path d="M12 6v12"/><path d="M17.196 9 6.804 15"/><path d="m6.804 9 10.392 6"/></svg></span></label>
            <input class="shipping-input" type="text" name="city" placeholder="Town/City:" required min="4" max="50">
        </div><!-- end of form group -->

        <div class="shipping-form-group"><!-- start of form group -->
            <label class="shipping-label" for="postcode">Post/Zip code: <span class = "field-required"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#8b0000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-asterisk-icon lucide-asterisk"><path d="M12 6v12"/><path d="M17.196 9 6.804 15"/><path d="m6.804 9 10.392 6"/></svg></span></label>
            <input class="shipping-input" type="text" name="postcode" placeholder="e.g., AB12 3CD:" required min="4" max="50">
        </div><!-- end of form group -->
    </div><!-- end of shipping form bottom row -->
</form><!-- end of shipping details form -->


             <label class = "shipping-label" for="countries">Select Country: <span class = "field-required"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#8b0000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-asterisk-icon lucide-asterisk"><path d="M12 6v12"/><path d="M17.196 9 6.804 15"/><path d="m6.804 9 10.392 6"/></svg></span></label>
<select name="countries" id="countries" required>
  <optgroup label="Select your Country">
    <option value="" disabled selected>Please Select a Country</option>
  </optgroup>
  <optgroup label="Europe">
    <option value="unitedKingdom">United Kingdom</option>
    <option value="albania">Albania</option>
    <option value="andorra">Andorra</option>
    <option value="armenia">Armenia</option>
    <option value="austria">Austria</option>
    <option value="azerbaijan">Azerbaijan</option>
    <option value="belarus">Belarus</option>
    <option value="belgium">Belgium</option>
    <option value="bosniaHerzegovina">Bosnia and Herzegovina</option>
    <option value="bulgaria">Bulgaria</option>
    <option value="croatia">Croatia</option>
    <option value="cyprus">Cyprus</option>
    <option value="czechRepublic">Czech Republic</option>
    <option value="denmark">Denmark</option>
    <option value="estonia">Estonia</option>
    <option value="finland">Finland</option>
    <option value="france">France</option>
    <option value="georgia">Georgia</option>
    <option value="germany">Germany</option>
    <option value="greece">Greece</option>
    <option value="hungary">Hungary</option>
    <option value="iceland">Iceland</option>
    <option value="ireland">Ireland</option>
    <option value="italy">Italy</option>
    <option value="kazakhstan">Kazakhstan</option>
    <option value="kosovo">Kosovo</option>
    <option value="latvia">Latvia</option>
    <option value="liechtenstein">Liechtenstein</option>
    <option value="lithuania">Lithuania</option>
    <option value="luxembourg">Luxembourg</option>
    <option value="malta">Malta</option>
    <option value="moldova">Moldova</option>
    <option value="monaco">Monaco</option>
    <option value="montenegro">Montenegro</option>
    <option value="netherlands">Netherlands</option>
    <option value="northMacedonia">North Macedonia</option>
    <option value="norway">Norway</option>
    <option value="poland">Poland</option>
    <option value="portugal">Portugal</option>
    <option value="romania">Romania</option>
    <option value="russia">Russia</option>
    <option value="sanMarino">San Marino</option>
    <option value="serbia">Serbia</option>
    <option value="slovakia">Slovakia</option>
    <option value="slovenia">Slovenia</option>
    <option value="spain">Spain</option>
    <option value="sweden">Sweden</option>
    <option value="switzerland">Switzerland</option>
    <option value="turkey">Turkey</option>
    <option value="ukraine">Ukraine</option>
  </optgroup>
  <optgroup label="North America">
    <option value="unitedStates">United States</option>
    <option value="canada">Canada</option>
    <option value="mexico">Mexico</option>
    <option value="antiguaBarbuda">Antigua and Barbuda</option>
    <option value="bahamas">Bahamas</option>
    <option value="barbados">Barbados</option>
    <option value="belize">Belize</option>
    <option value="costaRica">Costa Rica</option>
    <option value="cuba">Cuba</option>
    <option value="dominica">Dominica</option>
    <option value="dominicanRepublic">Dominican Republic</option>
    <option value="elSalvador">El Salvador</option>
    <option value="grenada">Grenada</option>
    <option value="guatemala">Guatemala</option>
    <option value="haiti">Haiti</option>
    <option value="honduras">Honduras</option>
    <option value="jamaica">Jamaica</option>
    <option value="nicaragua">Nicaragua</option>
    <option value="panama">Panama</option>
    <option value="saintKittsNevis">Saint Kitts and Nevis</option>
    <option value="saintLucia">Saint Lucia</option>
    <option value="saintVincentGrenadines">Saint Vincent and the Grenadines</option>
    <option value="trinidadTobago">Trinidad and Tobago</option>
  </optgroup>
  <optgroup label="Asia">
    <option value="afghanistan">Afghanistan</option>
    <option value="armenia">Armenia</option>
    <option value="azerbaijan">Azerbaijan</option>
    <option value="bahrain">Bahrain</option>
    <option value="bangladesh">Bangladesh</option>
    <option value="bhutan">Bhutan</option>
    <option value="brunei">Brunei</option>
    <option value="burma">Burma (Myanmar)</option>
    <option value="cambodia">Cambodia</option>
    <option value="china">China</option>
    <option value="cyprus">Cyprus</option>
    <option value="georgia">Georgia</option>
    <option value="india">India</option>
    <option value="indonesia">Indonesia</option>
    <option value="iran">Iran</option>
    <option value="iraq">Iraq</option>
    <option value="israel">Israel</option>
    <option value="japan">Japan</option>
    <option value="jordan">Jordan</option>
    <option value="kazakhstan">Kazakhstan</option>
    <option value="koreaNorth">North Korea</option>
    <option value="koreaSouth">South Korea</option>
    <option value="kuwait">Kuwait</option>
    <option value="kyrgyzstan">Kyrgyzstan</option>
    <option value="laos">Laos</option>
    <option value="lebanon">Lebanon</option>
    <option value="malaysia">Malaysia</option>
    <option value="maldives">Maldives</option>
    <option value="mongolia">Mongolia</option>
    <option value="nepal">Nepal</option>
    <option value="oman">Oman</option>
    <option value="pakistan">Pakistan</option>
    <option value="palestine">Palestine</option>
    <option value="philippines">Philippines</option>
    <option value="qatar">Qatar</option>
    <option value="saudiArabia">Saudi Arabia</option>
    <option value="singapore">Singapore</option>
    <option value="sriLanka">Sri Lanka</option>
    <option value="syria">Syria</option>
    <option value="taiwan">Taiwan</option>
    <option value="tajikistan">Tajikistan</option>
    <option value="thailand">Thailand</option>
    <option value="timorLeste">Timor-Leste</option>
    <option value="turkmenistan">Turkmenistan</option>
    <option value="unitedArabEmirates">United Arab Emirates</option>
    <option value="uzbekistan">Uzbekistan</option>
    <option value="vietnam">Vietnam</option>
    <option value="yemen">Yemen</option>
  </optgroup>
  <optgroup label="South America">
    <option value="argentina">Argentina</option>
    <option value="bolivia">Bolivia</option>
    <option value="brazil">Brazil</option>
    <option value="chile">Chile</option>
    <option value="colombia">Colombia</option>
    <option value="ecuador">Ecuador</option>
    <option value="guyana">Guyana</option>
    <option value="paraguay">Paraguay</option>
    <option value="peru">Peru</option>
    <option value="suriname">Suriname</option>
    <option value="uruguay">Uruguay</option>
    <option value="venezuela">Venezuela</option>
  </optgroup>
  <optgroup label="Africa">
    <option value="algeria">Algeria</option>
    <option value="angola">Angola</option>
    <option value="benin">Benin</option>
    <option value="botswana">Botswana</option>
    <option value="burkinaFaso">Burkina Faso</option>
    <option value="burundi">Burundi</option>
    <option value="capeVerde">Cape Verde</option>
    <option value="cameroon">Cameroon</option>
    <option value="centralAfricanRepublic">Central African Republic</option>
    <option value="chad">Chad</option>
    <option value="comoros">Comoros</option>
    <option value="congoBrazzaville">Congo (Brazzaville)</option>
    <option value="congoKinshasa">Congo (Kinshasa)</option>
    <option value="djibouti">Djibouti</option>
    <option value="egypt">Egypt</option>
    <option value="equatorialGuinea">Equatorial Guinea</option>
    <option value="eritrea">Eritrea</option>
    <option value="eswatini">Eswatini</option>
    <option value="ethiopia">Ethiopia</option>
    <option value="gabon">Gabon</option>
    <option value="gambia">Gambia</option>
    <option value="ghana">Ghana</option>
    <option value="guinea">Guinea</option>
    <option value="guineaBissau">Guinea-Bissau</option>
    <option value="ivoryCoast">Ivory Coast</option>
    <option value="kenya">Kenya</option>
    <option value="lesotho">Lesotho</option>
    <option value="liberia">Liberia</option>
    <option value="libya">Libya</option>
    <option value="madagascar">Madagascar</option>
    <option value="malawi">Malawi</option>
    <option value="mali">Mali</option>
    <option value="mauritania">Mauritania</option>
    <option value="mauritius">Mauritius</option>
    <option value="morocco">Morocco</option>
    <option value="mozambique">Mozambique</option>
    <option value="namibia">Namibia</option>
    <option value="niger">Niger</option>
    <option value="nigeria">Nigeria</option>
    <option value="rwanda">Rwanda</option>
    <option value="senegal">Senegal</option>
    <option value="seychelles">Seychelles</option>
    <option value="sierraLeone">Sierra Leone</option>
    <option value="somalia">Somalia</option>
    <option value="southAfrica">South Africa</option>
    <option value="southSudan">South Sudan</option>
    <option value="sudan">Sudan</option>
    <option value="tanzania">Tanzania</option>
    <option value="togo">Togo</option>
    <option value="tunisia">Tunisia</option>
    <option value="uganda">Uganda</option>
    <option value="zambia">Zambia</option>
    <option value="zimbabwe">Zimbabwe</option>
  </optgroup>
  <optgroup label="Oceania">
    <option value="australia">Australia</option>
    <option value="fiji">Fiji</option>
    <option value="kiribati">Kiribati</option>
    <option value="marshallIslands">Marshall Islands</option>
    <option value="micronesia">Micronesia</option>
    <option value="nauru">Nauru</option>
    <option value="newZealand">New Zealand</option>
    <option value="palau">Palau</option>
    <option value="papuaNewGuinea">Papua New Guinea</option>
    <option value="samoa">Samoa</option>
    <option value="solomonIslands">Solomon Islands</option>
    <option value="timorLeste">Timor-Leste</option>
    <option value="tonga">Tonga</option>
    <option value="tuvalu">Tuvalu</option>
    <option value="vanuatu">Vanuatu</option>
  </optgroup>
</select>




                        </div><!-- end of shipping form bottom row -->


        </form><!-- end of shipping details form -->




    </div><!-- end of shipping details card-->


</section><!-- end of shipping details container -->

</main>

<?php
// Include the footer file
include('../components/footer.php');
?>

<script src="../js/app.js"></script>
<!-- <script src="../js/flickity.js"></script> -->
<script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/flickity/2.3.0/flickity.pkgd.min.js"></script>
</body>
</html>