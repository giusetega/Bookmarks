window.onload = function() {
    var error = document.querySelector("#error");
    const errorLength = error.innerHTML.trim().length;
    // Visualize the error div only if there's something inside otherwise it remains "none"
    if (errorLength != 0){
        error.style.display = "block";
    }
}