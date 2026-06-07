<?php
$conn = mysqli_connect("localhost", "root", "", "codevault");
if($conn->connect_error){
    echo "connection error";
}
?>