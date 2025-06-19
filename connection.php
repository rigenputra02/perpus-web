<?php 

session_start();
date_default_timezone_set('Asia/Jakarta');

$conn        = mysqli_connect('localhost', 'root', '', 'perpustakaan');
$base_url    = 'http://localhost/perpustakaan-main';
$uri_segment = explode('/', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

function uuid() {
   return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
      mt_rand(0, 0xffff), mt_rand(0, 0xffff),
      mt_rand(0, 0xffff),
      mt_rand(0, 0x0fff) | 0x4000,
      mt_rand(0, 0x3fff) | 0x8000,
      mt_rand(0, 0xffff), mt_rand(0, 0xffff ), mt_rand(0, 0xffff)
   );
}

function randomString($length = 10) {
   $character   = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
   $char_length = strlen($character);
   $rand_str    = '';

   for ($i = 0; $i < $length; $i++) {
      $rand_str .= $character[rand(0, $char_length - 1)];
   }

   return $rand_str;
}

function generateCode() {
   global $conn;
   
   return date('dmyHis');
}