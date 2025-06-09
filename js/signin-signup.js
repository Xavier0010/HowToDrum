var passwordField = document.querySelector(".password");
var show = document.querySelector(".show");
var hide = document.querySelector(".hide");

show.onclick = function() {
    passwordField.setAttribute("type","text");
    show.style.display = "none";
    hide.style.display = "block";
}

hide.onclick = function() {
    passwordField.setAttribute("type","password");
    hide.style.display = "none";
    show.style.display = "block";
}