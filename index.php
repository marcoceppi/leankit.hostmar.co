<?php


require_once('parsers.php');

function backflip($raw, $proto) {
  list($s, $d) = explode(':', $raw, 2);
  if(!array_key_exists($s, $proto)) {
    header('Not a protocol', true, 404);
    die();
  }

  $proto[$s]->parse($d);
}

if(!isset($_GET['r'])) {
  die("<h1>Go away</h1><br><br>
       https://github.com/marcoceppi/leankit.hostmar.co");
}

backflip($_GET['r'], $protocols);
