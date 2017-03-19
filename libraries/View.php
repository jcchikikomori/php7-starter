<?php

class View
{
  public static function getFeedback() {
      // show potential errors / feedback (from login object)
      $obj = Session::get('response');
      if (isset($obj)) {
          if (!empty($obj['messages'])) {
              echo '<div class="alert bg-success alert-dismissible" role="alert"><button class="close" aria-label="close" data-dismiss="alert" type="button"><span aria-hidden="true">x</span></button>';
                  echo '<ul class="list-unstyled"><strong>MESSAGE FROM SERVER</strong><br /><br />';
                      foreach ($obj['messages'] as $message) {echo '<li>' . $message . '</li>';}
                  echo '</ul>';
              echo '</div>';
          }
      } else {echo 'Session error';}
  }
}
