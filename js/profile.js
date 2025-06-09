document.addEventListener("DOMContentLoaded", function () {
    const overlay = document.querySelectorAll(".edit-details-overlay");
    const openBtn = document.querySelectorAll(".open-overlay");
    const closeBtn = document.querySelectorAll(".close-overlay");

    openBtn.forEach((btn, index) => {
        btn.addEventListener("click", () => {
            overlay[index].classList.add('visible');
        });
    });

    closeBtn.forEach((btn, index) => {
        btn.addEventListener("click", () => {
            overlay[index].classList.remove('visible');
        });
    });
});

const passwordField = document.querySelector("#input-password");
const show = document.querySelector(".show");
const hide = document.querySelector(".hide");

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