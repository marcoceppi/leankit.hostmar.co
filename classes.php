<?php

abstract class Redirect {
  public $host = NULL;
  public function redirect($address) {
    $url = $this->host . '/' . $address;
    header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
    header('Last-Modified: ' . gmdate( 'D, d M Y H:i:s' ) . ' GMT');
    header('Cache-Control: no-store, no-cache, must-revalidate');
    header('Cache-Control: post-check=0, pre-check=0', false);
    header('Pragma: no-cache');

    header('Location: ' . $url);
  }

  abstract public function parse($url);
}

class Github extends Redirect {
  public $host = 'https://github.com';

  public function parse($url) {
    list($user, $repo, $bug) = explode('/', $url, 3);
    $this->redirect($user . '/' . $repo . '/issues/' . $bug);
  }
}

class LaunchPad extends Redirect {
  public $host = 'http://pad.lv';

  public function parse($url) {
    if(is_numeric($url)) {
      return $this->redirect($url);
    }

    $this->host = 'https://launchpad.net/';
    $this->redirect($url);
  }
}

class CodeReview extends Redirect {
  public $host = 'https://github.com';

  public function parse($url) {
    $this->redirect($url);
  }
}
