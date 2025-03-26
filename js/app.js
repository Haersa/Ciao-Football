// Wait for the document to be fully loaded
document.addEventListener("DOMContentLoaded", function () {
  // navbar functionality ///////////////////////////////////////////////////////////////////////////////
  const searchIcon = document.getElementById("search-icon"); // get the search icon
  const searchDropdown = document.querySelector(".search-dropdown"); // get the search dropdown
  const closeSearchIcon = document.getElementById("close-search-icon"); // get the close search bar icon
  const BurgerButton = document.getElementById("burger-button"); // get the burger menu icon
  const MobileMenu = document.getElementById("Mobile-Menu"); // get the mobile menu
  const CloseBurger = document.getElementById("close-burger"); // get the close icon

  // event listener to show search dropdown on click of the icon
  searchIcon.addEventListener("click", () => {
    searchDropdown.classList.toggle("active");
  });

  // Add event listener to close dropdown on clicjk of the icon
  closeSearchIcon.addEventListener("click", () => {
    searchDropdown.classList.remove("active");
  });

  // Add event listener to open mobile menu on click of Burger Icon
  BurgerButton.addEventListener("click", () => {
    MobileMenu.classList.toggle("active");
    document.body.style.overflow = "hidden";
  });

  // Add event listener to close mobile menu on click of close icon
  CloseBurger.addEventListener("click", () => {
    MobileMenu.classList.remove("active");
    document.body.style.overflow = "auto";
  });
  // end of navbar functionality /////////////////////////////////////////////////////////////////////////

  // for megabox opening
  const ShopByLink = document.getElementById("shopby");
  const MegaBox = document.getElementById("megabox");

  // add active class to megabox dropdown menu on hover
  ShopByLink.addEventListener("mouseover", () => {
    MegaBox.classList.toggle("active");
  });

  // Remove active class when mouse leaves the megabox
  MegaBox.addEventListener("mouseleave", () => {
    MegaBox.classList.remove("active");
  });
});

// Back to top button functionality ////////////////////////////////////////////////////////////////////

const backToTopButton = document.querySelector(".back-to-top-container"); // get the back to top button
// Initially hide the button
backToTopButton.style.display = "none";

// Show or hide the button based on scroll position
window.addEventListener("scroll", function () {
  if (window.scrollY > 300) {
    // if user scrolls more than 300px down
    backToTopButton.style.display = "block"; // show the button
  } else {
    backToTopButton.style.display = "none"; // hide the button
  }
});
