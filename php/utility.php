<?php 
function get_avatar($string){
  $words = explode(' ', $string);
  $initials = '';
  foreach ($words as $word) {
      $initials .= strtoupper($word[0]);
  }
  return $initials;
}
?>