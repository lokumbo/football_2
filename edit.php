<!DOCTYPE html>
<html lang='pl'>
  <head>
    <meta charset='utf-8'>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp"
     crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB"
     crossorigin="anonymous">
    <link rel='stylesheet' href='style/style.css'>
    <title>Edit</title>
  </head>
  <body>
     <?php
     require_once('authorize.php');
     require_once('mysqli_connect.php');
     $zawodnicy ="zawodnicy";
     // ------------------------------------------------------------------------
     // ------------------------------------------------------------------------

     if (!empty($_GET['id']) && !empty($_GET['zawodnik'])) {
      $id = mysqli_real_escape_string($dbc, trim($_GET['id'])); // Zmienne pobrane za pomocą metody GET oraz linka <a>.
      $zawodnik = mysqli_real_escape_string($dbc, trim($_GET['zawodnik']));
      $form = true;

      if (isset($_POST['submit'])) { // Najpierw sprawdza, czy formularz został wysłany.
          $nazwisko_2 = mysqli_real_escape_string($dbc, ucfirst(strtolower(trim($_POST['nazwisko_2']))));
          $imie_2 = mysqli_real_escape_string($dbc, ucfirst(strtolower(trim($_POST['imie_2']))));
          $zawodnik_2 = $nazwisko_2 . ' ' . $imie_2;

          if ($zawodnik_2) {
            $sql_list = "SELECT zawodnik FROM $zawodnicy ORDER BY zawodnik";
            $result_list = mysqli_query($dbc, $sql_list);
            $list = [];
            $licznik = 1;
            if (mysqli_num_rows($result_list) > 0) {
               while ($row = mysqli_fetch_array($result_list)) {
                  $list[$licznik] = $row[0];
                  if ($list[$licznik] == $zawodnik_2) {
                     echo "
                     <div class='container-fluid'>
                        <div class='row'>
                          <div class='col-lg-6 col-md-8 col-sm-10'>
                            <br>
                            <p class='napis'>Zawodnik <strong>$zawodnik_2</strong> jest już w tabeli. Wprowadź innego.</p>
                          </div>
                        </div>
                     </div>";
                     break;
                  } else if ($licznik == mysqli_num_rows($result_list)) {
                     $sql = "UPDATE $zawodnicy SET zawodnik='$zawodnik_2' WHERE id_zaw=$id LIMIT 1";
                     $result = mysqli_query($dbc, $sql);
                     echo "
                     <div class='container-fluid'>
                        <div class='row'>
                          <div class='col-lg-6 col-md-8 col-sm-10'>
                             <br>
                             <p>Dane zawodnika zostały zmienione na: <strong>$zawodnik_2</strong></p>";
                     $form = false;
                     ?>
                              <a href='./index.php'>
                                 <button class='btn btn-primary btn-form'>powrót</button>
                              </a>
                          </div>
                        </div>
                     </div>
                  <?php
                  }
                  $licznik++;
               }
            }
         } else {
            echo "
            <div class='container-fluid'>
               <div class='row'>
                 <div class='col-lg-6 col-md-8 col-sm-10'>
                   <br>
                   <p>Pole nie może być puste.</p>
                 </div>
               </div>
            </div>";
         }
      }

      if ($form) {
      ?>
      <div class="container-fluid">
         <div class="row">
            <div class="col-lg-6 col-md-8 col-sm-10">
               <br>
               <p>Edytuj zawodnika <strong><?php echo $zawodnik; ?></strong>.</p>
               <p>Wprowadź nowe dane:</p>
               <form action="<?php $_SERVER['PHP_SELF']?>" method="post">
                  <input type='number' name='number' value='<?php echo $id; ?>' class='ukryj'> <!-- ukryty -->
                  <div class="form-group">
                     <div class="input-group">
                           <span class="input-group-text">
                              Nazwisko
                           </span>
                           <input type='text' name='nazwisko_2' id='nazwisko_2'>
                     </div>
                  </div>
                  <div class="form-group">
                     <div class="input-group">
                           <span class="input-group-text">
                              Imię
                           </span>
                           <input type='text' name='imie_2'>
                     </div>
                  </div>
                  <div class="form-group">
                     <input type='submit' name='submit' value='zmień' id='button' class='btn btn-primary btn-form' disabled>
                     <a href='./index.php'>
                        <input type='button' name='cancel' value='anuluj' id='cancel' class='btn btn-warning btn-form'>
                     </a>
                  </div>
               </form>
            </div>
         </div>
      </div>

      <?php
      }
   } else {
      ?>
      <div class="container-fluid">
         <div class="row">
           <div class="col-lg-6 col-md-8 col-sm-10">
             <br>
             <p>Nie wybrano żadnego zawodnika do edycji.</p>
             <a href='./index.php'>
                <button class='btn btn-warning btn-form'>powrót</button>
             </a>
           </div>
         </div>
      </div>
   <?php
   }

   mysqli_close($dbc);
   ?>
   <p class='hide'>hidden</p>
   <p class='hide'>hidden</p>

   <script>
      var button = document.getElementById('button');
      var nazwisko_2 = document.getElementById('nazwisko_2');
      var imie_2 = document.getElementById('imie_2');
      nazwisko_2.oninput = activate;
      imie_2.oninput = activate;

      function activate() {
         if (nazwisko_2.value != '' || imie_2.value != '') {
            button.disabled = false;
         }
      }

   </script>
   <script src="http://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
     crossorigin="anonymous"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
     crossorigin="anonymous"></script>
   <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T"
     crossorigin="anonymous"></script>
  </body>
</html>
