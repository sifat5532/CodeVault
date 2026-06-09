<?php 
function get_avatar($string){
  if($string == null) return "null";
  $words = explode(' ', $string);
  $initials = '';
  foreach ($words as $word) {
      $initials .= strtoupper($word[0]);
  }
  return $initials;
}

function timeAgo($datetime){
    date_default_timezone_set("Asia/Dhaka");
    $time=new DateTime($datetime);
    $now=new DateTime();
    $diff=$time->diff($now);
    if($diff->y) return $diff->y.'y ago';
    if($diff->m) return $diff->m.'mon ago';
    if($diff->d) return $diff->d.'d ago';
    if($diff->h) return $diff->h.'h ago';
    if($diff->i) return $diff->i.'min ago';
    return 'Just now';

  }
?>