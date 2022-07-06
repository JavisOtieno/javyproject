// get the mPopup
var mpopup = document.getElementById('mpopupBox');

// get the link that opens the mPopup
var mpLink = document.getElementById("mpopupLink");
var closeModal = document.getElementById("closeModal");

// get the close action element
var close = document.getElementsByClassName("close")[0];

// open the mPopup once the link is clicked
mpLink.onclick = function() {
    mpopup.style.display = "block";
}

// close the mPopup once close element is clicked
//doesn't work. had to use a div
close.onclick = function() {

    mpopup.style.display = "none";

}

closeModal.onclick= function() {
	
    mpopup.style.display = "none";
}

// close the mPopup when user clicks outside of the box
window.onclick = function(event) {
    if (event.target == mpopup) {
        mpopup.style.display = "none";
    }
}