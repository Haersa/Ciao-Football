<?php 
session_start();

// set lucide icons in variables
$errorIcon = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#8b0000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-triangle-alert"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3"/><path d="M12 9v4"/><path d="M12 17h.01"/></svg>';
$successIcon = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#0a5c36" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-badge-check"><path d="M3.85 8.62a4 4 0 0 1 4.78-4.77 4 4 0 0 1 6.74 0 4 4 0 0 1 4.78 4.78 4 4 0 0 1 0 6.74 4 4 0 0 1-4.77 4.78 4 4 0 0 1-6.75 0 4 4 0 0 1-4.78-4.77 4 4 0 0 1 0-6.76Z"/><path d="m9 12 2 2 4-4"/></svg>';

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0"); // these make sure the login feedback message on login is only displayed once, and isn't shown again if a user clicks the browser back arrow (found on stack overflow)
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// Display success message if exists
if (isset($_SESSION['Success']) && $_SESSION['Success']) {
    echo '<div class="success-message">' . $_SESSION['SuccessMessage'] . '</div>';
    unset($_SESSION['Success']);
    unset($_SESSION['SuccessMessage']);
}

// Display failure message if exists
if (isset($_SESSION['Failed']) && $_SESSION['Failed']) {
    echo '<div class="error-message">' . $_SESSION['FailMessage'] . '</div>';
    unset($_SESSION['Failed']);
    unset($_SESSION['FailMessage']);
}
?>


<!-- created a billing form component, as it shares the same appearance as the shipping address form -->

<section class="shipping-details-container"><!-- start of shipping details container -->
    <div class="shipping-details-card"><!-- start of shipping details card-->
        <div class="shipping-details-header"><!-- start of shipping details header -->
            <h2 class="details-title">
                <span class="shipping-details-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#050505" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-receipt-text-icon lucide-receipt-text"><path d="M4 2v20l2-1 2 1 2-1 2 1 2-1 2 1 2-1 2 1V2l-2 1-2-1-2 1-2-1-2 1-2-1-2 1Z"/><path d="M14 8H8"/><path d="M16 12H8"/><path d="M13 16H8"/></svg>
                </span>
                Billing Address
            </h2>
        </div><!-- end of shipping details header -->

        <form class="shipping-details-form" method="POST" action="../backend/processbilling.php"><!-- start of shipping details form -->
            <div class="shipping-form-top-row"><!-- start of shipping form top row -->
                <div class="shipping-form-group"><!-- start of form group -->
                    <label class="shipping-label" for="billing_name">First Name: 
                        <span class="field-required">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#8b0000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-asterisk-icon lucide-asterisk">
                                <path d="M12 6v12" />
                                <path d="M17.196 9 6.804 15" />
                                <path d="m6.804 9 10.392 6" />
                            </svg>
                        </span>
                    </label>
                    <input class="shipping-input" type="text" name="billing_name" placeholder="First Name:" required minlength="2" maxlength="50">
                </div><!-- end of form group -->

                <div class="shipping-form-group"><!-- start of form group -->
                    <label class="shipping-label" for="billing_surname">Surname: 
                        <span class="field-required">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#8b0000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-asterisk-icon lucide-asterisk">
                                <path d="M12 6v12" />
                                <path d="M17.196 9 6.804 15" />
                                <path d="m6.804 9 10.392 6" />
                            </svg>
                        </span>
                    </label>
                    <input class="shipping-input" type="text" name="billing_surname" placeholder="Surname:" required minlength="2" maxlength="50">
                </div><!-- end of form group -->
            </div><!-- end of shipping form top row -->

            <div class="shipping-form-second-row"><!-- start of shipping form second row -->
                <div class="shipping-form-group"><!-- start of form group -->
                    <label class="shipping-label" for="billing_email">Email: 
                        <span class="field-required">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#8b0000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-asterisk-icon lucide-asterisk">
                                <path d="M12 6v12" />
                                <path d="M17.196 9 6.804 15" />
                                <path d="m6.804 9 10.392 6" />
                            </svg>
                        </span>
                    </label>
                    <input class="shipping-input" type="email" name="billing_email" placeholder="example@domain.com:" minlength="4" maxlength ="50" required>
                </div><!-- end of form group -->

                <div class="shipping-form-group"><!-- start of form group -->
                    <label class="shipping-label" for="billing_phone">Phone Number: 
                        <span class="field-required">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#8b0000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-asterisk-icon lucide-asterisk">
                                <path d="M12 6v12" />
                                <path d="M17.196 9 6.804 15" />
                                <path d="m6.804 9 10.392 6" />
                            </svg>
                        </span>
                    </label>
                    <input class="shipping-input" type="tel" name="billing_phone" placeholder="+44 XXXX XXXXXX:" minlength="10" maxlength="50" required>
                </div><!-- end of form group -->
            </div><!-- end of shipping form second row -->

            <div class="shipping-form-address-row"><!-- start of shipping form address row -->
                <div class="shipping-form-group"><!-- start of form group -->
                    <label class="shipping-label" for="billing_addressLine1">Address Line 1: 
                        <span class="field-required">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#8b0000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-asterisk-icon lucide-asterisk">
                                <path d="M12 6v12" />
                                <path d="M17.196 9 6.804 15" />
                                <path d="m6.804 9 10.392 6" />
                            </svg>
                        </span>
                    </label>
                    <input class="shipping-input" type="text" name="billing_addressLine1" placeholder="House/Flat/Apartment Number:" required minlength="1" maxlength="25">
                </div><!-- end of form group -->
            </div><!-- end of shipping form address row -->

            <div class="shipping-form-address-row">
                <div class="shipping-form-group"><!-- start of form group -->
                    <label class="shipping-label" for="billing_addressLine2">Address Line 2: 
                        <span class="field-required">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#8b0000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-asterisk-icon lucide-asterisk">
                                <path d="M12 6v12" />
                                <path d="M17.196 9 6.804 15" />
                                <path d="m6.804 9 10.392 6" />
                            </svg>
                        </span>
                    </label>
                    <input class="shipping-input" type="text" name="billing_addressLine2" placeholder="Street Name:" required minlength="1" maxlength="25">
                </div><!-- end of form group -->
            </div><!-- end of shipping form address row -->

            <div class="shipping-form-address-row">
                <div class="shipping-form-group"><!-- start of form group -->
                    <label class="shipping-label" for="billing_addressLine3">Address Line 3:</label>
                    <input class="shipping-input" type="text" name="billing_addressLine3" placeholder="Additional address information (optional):" minlength="1" maxlength="25">
                </div><!-- end of form group -->
            </div><!-- end of shipping form address row -->

            <div class="shipping-form-address-row">
                <div class="shipping-form-group"><!-- start of form group -->
                    <label class="shipping-label" for="billing_addressLine4">Address Line 4:</label>
                    <input class="shipping-input" type="text" name="billing_addressLine4" placeholder="Additional address information (optional):" minlength="1" maxlength="25">
                </div><!-- end of form group -->
            </div><!-- end of shipping form address row -->

            <div class="shipping-form-bottom-row"><!-- start of shipping form bottom row -->
                <div class="shipping-form-group"><!-- start of form group -->
                    <label class="shipping-label" for="billing_city">Town/City: 
                        <span class="field-required">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#8b0000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-asterisk-icon lucide-asterisk">
                                <path d="M12 6v12" />
                                <path d="M17.196 9 6.804 15" />
                                <path d="m6.804 9 10.392 6" />
                            </svg>
                        </span>
                    </label>
                    <input class="shipping-input" type="text" name="billing_city" placeholder="Town/City:" required minlength="3" maxlength="50">
                </div><!-- end of form group -->

                <div class="shipping-form-group"><!-- start of form group -->
                    <label class="shipping-label" for="billing_postcode">Post/Zip code: 
                        <span class="field-required">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#8b0000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-asterisk-icon lucide-asterisk">
                                <path d="M12 6v12" />
                                <path d="M17.196 9 6.804 15" />
                                <path d="m6.804 9 10.392 6" />
                            </svg>
                        </span>
                    </label>
                    <input class="shipping-input" type="text" name="billing_postcode" placeholder="e.g., AB12 3CD:" required minlength="4" maxlength="50">
                </div><!-- end of form group -->
            </div><!-- end of shipping form bottom row -->

            <div class="shipping-form-group country-group">
              <label class="shipping-label country-label" for="billing_countries">Select Country: 
                <span class="field-required">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#8b0000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-asterisk-icon lucide-asterisk">
                     <path d="M12 6v12" />
                      <path d="M17.196 9 6.804 15" />
                      <path d="m6.804 9 10.392 6" />
                  </svg>
                </span>
              </label>
              <select name="billing_countries" id="billing_countries" class="shipping-country-select" required>
                <optgroup label="Select your Country">
                    <option value="" disabled selected>Please Select a Country</option>
                    <option value="Argentina">Argentina</option>
                    <option value="Australia">Australia</option>
                    <option value="Austria">Austria</option>
                    <option value="Belgium">Belgium</option>
                    <option value="Botswana">Botswana</option>
                    <option value="Brazil">Brazil</option>
                    <option value="Canada">Canada</option>
                    <option value="Chile">Chile</option>
                    <option value="China">China</option>
                    <option value="Colombia">Colombia</option>
                    <option value="Croatia">Croatia</option>
                    <option value="Czech Republic">Czech Republic</option>
                    <option value="Denmark">Denmark</option>
                    <option value="Egypt">Egypt</option>
                    <option value="Finland">Finland</option>
                    <option value="France">France</option>
                    <option value="Germany">Germany</option>
                    <option value="Greece">Greece</option>
                    <option value="Hungary">Hungary</option>
                    <option value="India">India</option>
                    <option value="Indonesia">Indonesia</option>
                    <option value="Italy">Italy</option>
                    <option value="Japan">Japan</option>
                    <option value="Cambodia">Cambodia</option>
                    <option value="Laos">Laos</option>
                    <option value="Malaysia">Malaysia</option>
                    <option value="Morocco">Morocco</option>
                    <option value="Mexico">Mexico</option>
                    <option value="Namibia">Namibia</option>
                    <option value="Netherlands">Netherlands</option>
                    <option value="New Zealand">New Zealand</option>
                    <option value="Norway">Norway</option>
                    <option value="Oman">Oman</option>
                    <option value="Peru">Peru</option>
                    <option value="Philippines">Philippines</option>
                    <option value="Poland">Poland</option>
                    <option value="Portugal">Portugal</option>
                    <option value="Qatar">Qatar</option>
                    <option value="Romania">Romania</option>
                    <option value="Saudi Arabia">Saudi Arabia</option>
                    <option value="Singapore">Singapore</option>
                    <option value="Slovakia">Slovakia</option>
                    <option value="Slovenia">Slovenia</option>
                    <option value="South Africa">South Africa</option>
                    <option value="South Korea">South Korea</option>
                    <option value="Spain">Spain</option>
                    <option value="Sweden">Sweden</option>
                    <option value="Switzerland">Switzerland</option>
                    <option value="Thailand">Thailand</option>
                    <option value="Tunisia">Tunisia</option>
                    <option value="Turkey">Turkey</option>
                    <option value="United Arab Emirates">United Arab Emirates</option>
                    <option value="United Kingdom">United Kingdom</option>
                    <option value="United States">United States</option>
                    <option value="Uruguay">Uruguay</option>
                    <option value="Vietnam">Vietnam</option>
                </optgroup>
            </select>

            <!-- Save address checkbox for logged-in users -->
            <div class="shipping-form-group">
                <?php if(isset($_SESSION['logged_in']) && $_SESSION['logged_in']): ?> <!-- only show this to logged in users -->
                <div class="checkbox-container">
                    <label class="remember-checkbox" for="save-billing-address">Save Billing Address for Future Orders</label>
                    <input class="shipping-save-details" type="checkbox" id="save-billing-address" name="save-billing-address">
                </div>
                <?php endif; ?>
            </div>

            <!-- Use same address for shipping checkbox -->
            <div class="shipping-form-group">
                <div class="checkbox-container">
                    <label class="remember-checkbox" for="same-shipping-address">Use Billing Address for Shipping</label>
                    <input class="shipping-save-details" type="checkbox" id="same-shipping-address" name="same-shipping-address">
                </div>
            </div>
        </div><!-- end of shipping form group country-group -->

        <section class="shipping-action-container"><!-- start of shipping action container -->
            <div class="shipping-action">
                <a href="revieworder.php" class="shipping-review-button"><span class="shipping-back-icon"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-move-left-icon"><path d="M6 8L2 12L6 16"/><path d="M2 12H22"/></svg></span>Back to Order Review</a>
                <button type="submit" class="shipping-payment-button">Continue to Shipping</button>
            </div>
        </section><!-- end of shipping action container -->
        </form><!-- end of shipping details form -->
    </div><!-- end of shipping details card -->
</section><!-- end of shipping details container -->