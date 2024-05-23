<h1>About</h1>
<p>We are leaders in courses publications.</p>
<?php

if (isset($resulter)) {
  echo $myData."<br>";
  foreach ($resulter as $key => $value) {
    echo $value->registration.'<br>';
  }
}
?>
