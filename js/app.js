// Wait for the document to be fully loaded
document.addEventListener("DOMContentLoaded", () => {
  // navbar functionality ///////////////////////////////////////////////////////////////////////////////
  const searchIcon = document.getElementById("search-icon"); // get the search icon
  const searchDropdown = document.querySelector(".search-dropdown"); // get the search dropdown
  const closeSearchIcon = document.getElementById("close-search-icon"); // get the close search bar icon
  const BurgerButton = document.getElementById("burger-button"); // get the burger menu icon
  const MobileMenu = document.getElementById("Mobile-Menu"); // get the mobile menu
  const CloseBurger = document.getElementById("close-burger"); // get the close icon
  const tabletMenu = document.getElementById("tablet-menu"); // get the tablet shop by menu
  const tabletBurger = document.getElementById("tablet-burger-button"); // get the tablet shop by burger button
  const closeTabletMenu = document.getElementById("close-tablet-menu"); // get the close tablet button
  const backToTopButton = document.querySelector(".back-to-top-container"); // get the back to top button

  // Initially hide the back to top button
  if (backToTopButton) {
    backToTopButton.style.display = "none";
  }

  // event listener to show search dropdown on click of the icon
  if (searchIcon) {
    searchIcon.addEventListener("click", () => {
      searchDropdown.classList.toggle("active");
    });
  }

  // Add event listener to close dropdown on clicjk of the icon
  if (closeSearchIcon) {
    closeSearchIcon.addEventListener("click", () => {
      searchDropdown.classList.remove("active");
    });
  }

  // Add event listener to open mobile menu on click of Burger Icon
  if (BurgerButton) {
    BurgerButton.addEventListener("click", () => {
      MobileMenu.classList.toggle("active");
      document.body.style.overflow = "hidden";
    });
  }

  // Add event listener to close mobile menu on click of close icon
  if (CloseBurger) {
    CloseBurger.addEventListener("click", () => {
      MobileMenu.classList.remove("active");
      document.body.style.overflow = "auto";
    });
  }
  // end of navbar functionality /////////////////////////////////////////////////////////////////////////

  // for megabox opening
  const ShopByLink = document.getElementById("shopby");
  const MegaBox = document.getElementById("megabox");

  // add active class to megabox dropdown menu on hover
  if (ShopByLink) {
    ShopByLink.addEventListener("mouseover", () => {
      MegaBox.classList.toggle("active");
    });
  }

  //add active class to megabox dropdown menu on focus with tab key
  if (ShopByLink) {
    ShopByLink.addEventListener("focusin", () => {
      MegaBox.classList.toggle("active");
    });
  }

  // Remove active class when mouse leaves the megabox
  if (MegaBox) {
    MegaBox.addEventListener("mouseleave", () => {
      MegaBox.classList.remove("active");
    });
  }

  // Remove active class to megabox dropdown menu on focus with tab key
  if (MegaBox) {
    MegaBox.addEventListener("focusout", () => {
      MegaBox.classList.remove("active");
    });
  }

  // open tablet shop by menu on click of burger button
  if (tabletBurger) {
    tabletBurger.addEventListener("click", () => {
      tabletMenu.classList.toggle("active");
      document.body.style.overflow = "hidden";
    });
  }

  // remove the actibe class if user clicks the close icon
  if (closeTabletMenu) {
    closeTabletMenu.addEventListener("click", () => {
      tabletMenu.classList.remove("active");
      document.body.style.overflow = "auto";
    });
  }

  // Back to top button functionality ////////////////////////////////////////////////////////////////////
  // Show or hide the button based on scroll position
  window.addEventListener("scroll", () => {
    if (backToTopButton) {
      // If mobile menu is active, hide the back to top button
      if (MobileMenu && MobileMenu.classList.contains("active")) {
        // if the mobile menu is active and open
        backToTopButton.style.display = "none"; // hide the back to top button so it doesnt overlap any menu options
      } else {
        // Otherwise show/hide based on scroll position
        if (window.scrollY > 300) {
          // if user scrolls more than 300px down
          backToTopButton.style.display = "block"; // show the button
        } else {
          backToTopButton.style.display = "none"; // hide the button
        }
      }
    }
  });
});
