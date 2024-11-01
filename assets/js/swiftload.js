document.addEventListener("DOMContentLoaded", function () {
  var counterElement = document.getElementById("swiftload-counter");
  var progressBar = document.getElementById("swiftload-bar");
  var counter = 0;
  var intervalCounter = setInterval(function () {
    counter++;
    counterElement.textContent = counter + "%";
    if (counter === 100) {
      clearInterval(intervalCounter);
      hidePreloader();
    }
  }, 55);

  var intervalProgressBar = setInterval(function () {
    progressBar.style.width = counter + "%";
  }, 55);

  function hidePreloader() {
    var preloader = document.getElementById("swiftload-preloader");
    preloader.classList.add("fade-out");
    setTimeout(function () {
      preloader.remove();
    }, 300);
  }

  setTimeout(function () {
    hidePreloader();
  }, 6000);
});
