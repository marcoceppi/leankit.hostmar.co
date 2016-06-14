<?php

abstract class Redirect {
  public $host;

  abstract public function parse($url);

  public function __construct() {}

  public function redirect($address) {
    if($this->host) {
      $url = $this->host . '/' . $address;
    } else {
      $url = $address;
    }

    header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
    header('Last-Modified: ' . gmdate( 'D, d M Y H:i:s' ) . ' GMT');
    header('Cache-Control: no-store, no-cache, must-revalidate');
    header('Cache-Control: post-check=0, pre-check=0', false);
    header('Pragma: no-cache');

    header('Location: ' . $url);
  }
}

class Github extends Redirect {
  public $host = 'https://github.com';

  public function parse($url) {
    if (substr_count($url, '/') > 2) {
        # support e.g., gh:user/repo/tree/branch or gh:user/repo/pull/10
        $this->redirect($url);
    } else {
        list($user, $repo, $bug) = explode('/', $url, 3);
        $this->redirect($user . '/' . $repo . '/issues/' . $bug);
    }
  }
}

class OpenStackReview extends Redirect {
  public $host = 'https://review.openstack.org/#/c';

  public function parse($url) {
    $this->redirect($url);
  }
}

class OpenStackTopic extends Redirect {
  public $host = 'https://review.openstack.org/#/q';

  public function parse($url) {
    $this->redirect('topic:' . $url);
  }
}

class LaunchPad extends Redirect {
  public $host = 'http://pad.lv';

  public function parse($url) {
    if(is_numeric($url)) {
      return $this->redirect($url);
    }

    $this->host = NULL;

    $distro = '';
    switch(substr_count($url, '/')) {
      case 2:
        list($distro, $url) = explode('/', $url, 2);
      case 1:
        list($project, $merge_id) = explode('/', $url);
      break;
      default:
        die($url . ' is not a valid LP shortcut');
      break;
    }

    $cmd = "./lp-merge.py $distro $project $merge_id";
    exec(escapeshellcmd($cmd), $output, $exit_code);
    if($exit_code > 0) {
      die($url . ' was not found on lp<br>' . implode('<br>', $output));
    }

    $this->redirect($output[0]);
  }
}

class CodeReview extends Redirect {
  public $host = 'https://codereview.appspot.com';

  public function parse($url) {
    $this->redirect($url);
  }
}

class Asana extends Redirect {
  public $host = 'https://app.asana.com/0';

  public function parse($url) {
    $this->redirect($url);
  }
}

class ApacheJira extends Redirect {
  public $host = 'https://issues.apache.org/jira/browse';

  public function parse($url) {
    $this->redirect($url);
  }
}

$protocols = array(
  'lp' => new LaunchPad(),
  'gh' => new Github(),
  'cr' => new CodeReview(),
  'ass' => new Asana(),
  'or' => new OpenStackReview(),
  'ot' => new OpenStackTopic(),
  'apache' => new ApacheJira()
);
