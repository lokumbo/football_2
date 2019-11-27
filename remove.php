<!DOCTYPE html>
<html lang='pl'>
  <head>
    <meta charset='utf-8'>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel='stylesheet' href='./style/reset.css'>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp"
     crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB"
     crossorigin="anonymous">
    <link rel='stylesheet' href='style/style.css'>
    <title>Admin</title>
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
          $sql = "DELETE FROM $zawodnicy WHERE id_zaw=$id LIMIT 1";
          $result = mysqli_query($dbc, $sql);
          if ($result) {
            echo "
            <div class='container-fluid'>
               <div class='row'>
                 <div class='col-lg-6 col-md-8 col-sm-10'>
                   <br>
                   <p>Zawodnik <strong>$zawodnik</strong> został usunięty.</p>";
                   $form = false;
                   echo "
                   <a href='./index.php'>
                      <button class='btn btn-primary btn-form'>powrót</button>
                   </a>
                 </div>
               </div>
            </div>";
         } else {
            echo "
            <div class='container-fluid'>
               <div class='row'>
                 <div class='col-lg-6 col-md-8 col-sm-10'>
                    <br>
                    <p class='napis'>Nie można usunąć zawodnika <strong>$zawodnik</strong>, ponieważ rozegrał mecze i jest dodany do tabeli z wynikami.</p>
                    <a href='./index.php'>
                       <button class='btn btn-primary btn-form'>powrót</button>
                    </a>
                 </div>
               </div>
            </div>";
            $form = false;
         }
       }

       if ($form) {
       ?>
       <div class="container-fluid">
          <div class="row">
            <div class="col-lg-6 col-md-8 col-sm-10">
             <form action="<?php $_SERVER['PHP_SELF']?>" method="post">
                <?php
                echo "
                <br>
                <p>Czy na pewno usunąć zawodnika?:</p>
                <div class='form-group'>
                   <div class='input-group'>
                     <input type='number' name='number' value='$id' class='ukryj'>
                     <input type='text' name='zawodnik' value='$zawodnik' readonly>
                   </div>
                </div>";
                ?>
                <div class="form-group">
                   <input type='submit' name='submit' value='usuń' id='button' class='btn btn-danger btn-form'>
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
       echo "
       <div class='container-fluid'>
          <div class='row'>
            <div class='col-lg-6 col-md-8 col-sm-10'>
               <br>
               <p>Nie wybrano żadnego zawodnika do edycji.</p>
               <a href='./index.php'>
                  <button class='btn btn-warning btn-form'>powrót</button>
               </a>
            </div>
          </div>
       </div>";
    }

    mysqli_close($dbc);
    ?>
    <p class='hide'>hidden</p>
    <p class='hide'>hidden</p>
    <script src="http://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
     crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
     crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T"
     crossorigin="anonymous"></script>
   </body>
</html>
