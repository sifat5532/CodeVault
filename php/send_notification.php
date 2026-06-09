<?php
// send notification
function send_notification($conn, $repo_id, $type, $sender_id, $receiver_id)
{
    $query = "INSERT INTO `notification`(`who_sent`, `who_got`, `repo_id`, `is_read`, `type`) VALUES ('$sender_id','$receiver_id','$repo_id','0','$type')";
    mysqli_query($conn, $query);
}
?>