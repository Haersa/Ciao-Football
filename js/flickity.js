document.addEventListener("DOMContentLoaded", function () {
  // Initialize Flickity
  const carousel = document.querySelector(".carousel");
  const flkty = new Flickity(carousel, {
    cellAlign: "left",
    contain: true,
    groupCells: 3,
    pageDots: false,
    prevNextButtons: false,
    wrapAround: true,
    adaptiveHeight: true,
    autoPlay: 10000,
  });

  // Attach arrow buttons
  document.querySelector(".next-arrow").addEventListener("click", function () {
    flkty.next();
  });

  document.querySelector(".prev-arrow").addEventListener("click", function () {
    flkty.previous();
  });
});
