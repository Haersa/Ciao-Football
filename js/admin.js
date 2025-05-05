document.addEventListener("DOMContentLoaded", function () {
  const burgerButton = document.querySelector(".burger-button"); // get the burger button
  const adminMenu = document.querySelector(".admin-menu"); // get the admin menu
  const closeButton = document.querySelector(".close-menu-button"); // get the close button (added . for class)

  if (burgerButton && adminMenu) {
    burgerButton.addEventListener("click", () => {
      adminMenu.classList.toggle("active"); // toggle active class
    });
  }

  if (closeButton && adminMenu) {
    closeButton.addEventListener("click", () => {
      adminMenu.classList.remove("active"); // remove the active class
    });
  }
});
