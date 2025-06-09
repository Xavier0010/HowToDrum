function ConfirmAlert(userId) {
    event.preventDefault();
    var ConfirmText = confirm("Are you sure you want to remove this user?");
    if (ConfirmText == true) {
        window.location.href = "delete.php?user_id=" + userId;
    }
}