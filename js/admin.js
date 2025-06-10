function ConfirmUserDeleteAlert(userId) {
    event.preventDefault();
    var ConfirmText = confirm("Are you sure you want to remove this user?");
    if (ConfirmText == true) {
        window.location.href = "delete.php?user_id=" + userId;
    }
}

function ConfirmTopicDeleteAlert(topicId) {
    event.preventDefault();
    var ConfirmText = confirm("Are you sure you want to remove this topic?");
    if (ConfirmText == true) {
        window.location.href = "delete.php?topic_id=" + topicId;
    }
}

function ConfirmExerciseDeleteAlert(exerciseId) {
    event.preventDefault();
    var ConfirmText = confirm("Are you sure you want to remove this topic?");
    if (ConfirmText == true) {
        window.location.href = "delete.php?exercise_Id=" + exerciseId;
    }
}