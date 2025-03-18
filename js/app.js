// Wait for the document to be fully loaded
document.addEventListener("DOMContentLoaded", function () {
  // navbar functionality ///////////////////////////////////////////////////////////////////////////////
  const searchIcon = document.getElementById("search-icon");
  const searchDropdown = document.querySelector(".search-dropdown");
  const closeSearchIcon = document.getElementById("close-search-icon");
  const BurgerButton = document.getElementById("burger-button");
  const MobileMenu = document.getElementById("Mobile-Menu");
  const CloseBurger = document.getElementById("close-burger");

  // event listener to show search dropdown on click of the icon
  searchIcon.addEventListener("click", () => {
    searchDropdown.classList.toggle("active");
  });

  // Add event listener to close dropdown on clicjk of the icon
  closeSearchIcon.addEventListener("click", () => {
    searchDropdown.classList.remove("active");
  });

  // Add event listener to open mobile menu on click of Burger Icon
  // BurgerButton.addEventListener("click", () => {
  //   MobileMenu.classList.toggle("active");
  // });

  // Add event listener to close mobile menu on click of close icon
  // CloseBurger.addEventListener("click", () => {
  //   MobileMenu.classList.remove("active");
  // });
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
