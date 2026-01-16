<?php
// counter.php — compteur simple par page
$file = __DIR__ . '/views-contact.txt';
$count = 0;
if (file_exists($file)) {
  $count = (int)trim((string)file_get_contents($file));
}
$count++;
file_put_contents($file, (string)$count, LOCK_EX);
echo $count;
?>