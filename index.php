<?php

require_once('classes.php');

$protocols = array('lp' => LaunchPad, 'gh' => Github, 'cr' => CodeReview);

function backflip($raw) {
  list($s, $d) = explode(':', $raw, 2);
  if(!array_key_exists($s, $protocols)) {
    header('Not a protocol', true, 404);
    die();
  }

  $c = $protocols[$s]();
  $c->parse($d);
}

backflip($_GET['r']);
