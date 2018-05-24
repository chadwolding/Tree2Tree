var fullPageMenu = document.getElementById('fullPageMenu');

/* Modal Image on gallery Page*/
var modal = document.getElementById("myModal");
var modalImg = document.getElementById("modalImage");
var captionText = document.getElementById("caption");


function toggleNavPage() {

  var width = document.getElementById('fullPageMenu').style.width;
  if (width == "" || width == "0%") {
    document.getElementById('fullPageMenu').style.width = "215px";
  } else {
    document.getElementById('fullPageMenu').style.width = "0%";
  }
}

function closeNavPage() {
  document.getElementById('fullPageMenu').style.width = "0%";
}

window.onclick = function(event) {
  if (event.target == fullPageMenu) {
    closeNavPage();
  }
}

window.onresize = function() {
  if (window.innerWidth >= 815) {
    document.getElementById('fullPageMenu').style.width = "0%";
  }
}

/* Modal Image on gallery Page*/
function fullScreen(id) {
    "use strict";
    modal.style.display = "block";
    modalImg.src = "images/gallery/" + id + ".jpeg";
}

function pleaseClose() {
    "use strict";
    modal.style.display = "none";
}
