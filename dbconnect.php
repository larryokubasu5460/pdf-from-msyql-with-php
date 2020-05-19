<?php
$conn=new mysqli("localhost", "root","","medical") or die (mysqli_error());

$query=mysqli_query($conn, "SELECT * FROM registration");

 ?>
