<?php

$p1 = '{"alg":"HS256","typ":"JWT"}';
$p1_64 = base64_encode($p1);
$p2 = '{"iss":"fhf"}';
$p2_64 = base64_encode($p2);
//$p3 = base64_encode($p1).".".base64_encode($p2);
$p3 = $p1_64 . "." . $p2_64;

$body = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJmaGYifQ";
$body = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJmaGYiLCJhcGwiOiJqd3QtdGVzdCIsInVzciI6InNjcm9tYmllIiwibmJmIjoxNDcyOTU1ODEyNDE4LCJleHAiOjE0NzI5NTY0MTI0MTgsInVybCI6Imh0dHA6Ly9zY3JvbWJpZS5zeXRlcy5uZXQvand0LXRlc3QvZ2V0Qm9va3MiLCJkYXRhIjpudWxsLCJmb3JtZGF0YSI6bnVsbCwidGVzdCI6InRlc3QgdGVzdCB0ZXN0In0=";

//$p3 = hash_hmac('sha256',$body,'12345');
//$p3_64 = base64_encode($p3);

$p3 = base64_encode(hash_hmac('sha256', $body, "12345", true));

//echo "p1: ".$p1_64;
//echo "<br />";
//echo "p2: ".$p2_64;
//echo "<br />";
echo "p3: ".$p3;
echo "<br />";
echo "p3_64: ".$p3_64;

