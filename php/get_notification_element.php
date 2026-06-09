<?php 

function get_notification_element($notification_id, $username, $user_id, $type, $repo_id, $repo_title, $repo_version, $avatar, $time, $is_read){
    $txt = "";
    $icon = "";
    $url = "#";

    if($is_read == 1){
        $read_class = "";
    } else {
        $read_class = "unread";
    }

    if($username == null){ $username = "Someone";}

    if($repo_id == null){  $repo_title = "{deleted repository}"; }else{ $url = "view_repo.php?repo_id=$repo_id"; }

    if($type == "follow"){
        if($username == null){ $username = "Someone"; $url = "#"; }else{ $url = "user_profile.php?id=$user_id"; }
        $txt = "<strong>$username</strong> started following you";
        $icon = "👤";
    } else if($type == "star"){
        $txt = "<strong>$username</strong> starred your repository <span class='repo-link'>$repo_title</span>";
        $icon = "⭐";
    } else if($type == "removed_as_cont"){
        $txt = "<strong>$username</strong> removed you as a contributor from <span class='repo-link'>$repo_title</span>";
        $icon = "🚫";
    } else if($type == "added_as_contri"){
        $txt = "<strong>$username</strong> added you as a contributor to <span class='repo-link'>$repo_title</span>";
        $icon = "➕";
    } else if($type == "new_version"){
        if($repo_id == null){  $repo_title = "{deleted repository}"; $repo_version = "{unknown}"; }else{ $url = "view_repo.php?repo_id=$repo_id"; }
        $txt = "<strong>$username</strong> released a new version of <span class='repo-link'>$repo_title</span>";
        $icon = "📦";
    } else if($type == "new_repo"){
        $txt = "<strong>$username</strong> created a new repository <span class='repo-link'>$repo_title</span>";
        $icon = "📁";
    }

    return  "
    <div onclick='mark_read($notification_id)'>
        <a href='$url'>
            <div class='notif-item $read_class anim-fadeup' style='animation-delay: 0.05s' id='clicked_card_$notification_id'>
                <div class='avatar'>$avatar</div>
                <div class='notif-content'>
                <p class='notif-text'>$txt</p>
                <span class='notif-time'>$time</span>
                </div>
                <div class='notif-action-icon'>$icon</div>
            </div>
        </a>
    </div>
    ";

}

?>