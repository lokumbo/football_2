<!-- mysqli_connect(host, user, password, database) -->
<?php
  $dbc = mysqli_connect('localhost', 'kris', 'bazokris', 'football') or die('Nie można połączyć z bazą.');
  mysqli_set_charset($dbc, 'utf8');
?>
