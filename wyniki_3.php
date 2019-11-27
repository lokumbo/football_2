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
     $daty = "daty";
     $zawodnicy ="zawodnicy";
     $wyniki = "wyniki_2019_20_hala_kortowo";
     // ------------------------------------------------------------------------
     // ------------------------------------------------------------------------

     if (!empty($_GET['date_forward'])) {
      $data = $_GET['date_forward'];
      $punkty_1 = $_GET['pkt_forward_1'];
      $punkty_2 = $_GET['pkt_forward_2'];
      $punkty_3 = '';
      $bramki_1 = $_GET['bram_forward_1'];
      $bramki_2 = $_GET['bram_forward_2'];
      $bramki_3 = '';
      $nr_1 = $_GET['nr_1'];
      $nr_2 = $_GET['nr_2'];
      $nr_3 = 0;

      for ($i=0; $i<$nr_1; $i++) {
          $napis_1[$i] = 'druzyna_1' . $i;
          $druzyna_1[$i] = $_GET["$napis_1[$i]"];
      }

      for ($i=0; $i<$nr_2; $i++) {
          $napis_2[$i] = 'druzyna_2' . $i;
          $druzyna_2[$i] = $_GET["$napis_2[$i]"];
      }

      if (!empty($_GET['druzyna_30'])) {
          $punkty_3 = $_GET['pkt_forward_3'];
          $bramki_3 = $_GET['bram_forward_3'];
          $nr_3 = $_GET['nr_3'];

          for ($i=0; $i<$nr_3; $i++) {
             $napis_3[$i] = 'druzyna_3' . $i;
             $druzyna_3[$i] = $_GET["$napis_3[$i]"];
          }
      }

      $sql_dat = "SELECT data FROM $daty";
      $result_dat = mysqli_query($dbc, $sql_dat);

      if (mysqli_num_rows($result_dat) > 0) {
         $licznik = 1;
         while ($row_dat = mysqli_fetch_array($result_dat)) {
            if ($row_dat[0] == $data) {
               $result = false;
               echo "
               <div class='container-fluid'>
                  <div class='row'>
                    <div class='col-lg-6 col-md-8 col-sm-10'>
                        <br>
                        <p>Dodawanie wyników do tabeli nie powiodło się, ponieważ te wyniki już są w tabeli.</p>
                    </div>
                  </div>
               </div>";
               break;
            } else {
               echo "<p></p>";
               if ($licznik == mysqli_num_rows($result_dat)) {
                  $sql = "INSERT INTO $daty VALUES(null, '$data')";
                  $result = mysqli_query($dbc, $sql);

                  for ($i=0; $i<$nr_1; $i++) {
                     $sql_1 = "INSERT INTO $wyniki
                     VALUES(null, (SELECT id_zaw FROM $zawodnicy WHERE zawodnik='$druzyna_1[$i]'), (SELECT id_daty FROM $daty WHERE data='$data'), $punkty_1, $bramki_1, 1, NOW())";
                     $result_1 = mysqli_query($dbc, $sql_1);
                  }

                  for ($i=0; $i<$nr_2; $i++) {
                     $sql_2 = "INSERT INTO $wyniki
                     VALUES(null, (SELECT id_zaw FROM $zawodnicy WHERE zawodnik='$druzyna_2[$i]'), (SELECT id_daty FROM $daty WHERE data='$data'), $punkty_2, $bramki_2, 2, NOW())";
                     $result_2 = mysqli_query($dbc, $sql_2);
                  }

                  if ($nr_3 != 0) {
                     for ($i=0; $i<$nr_3; $i++) {
                        $sql_3 = "INSERT INTO $wyniki
                        VALUES(null, (SELECT id_zaw FROM $zawodnicy WHERE zawodnik='$druzyna_3[$i]'), (SELECT id_daty FROM $daty WHERE data='$data'), $punkty_3, $bramki_3, 3, NOW())";
                        $result_3 = mysqli_query($dbc, $sql_3);
                     }
                  }

                  if ($result) {
                     echo "
                     <div class='container-fluid'>
                        <div class='row'>
                          <div class='col-lg-6 col-md-8 col-sm-10'>
                              <br>
                              <p>Wyniki dodano do tabeli.</p>
                          </div>
                        </div>
                     </div>";
                  } else {
                     echo "
                     <div class='container-fluid'>
                        <div class='row'>
                          <div class='col-lg-6 col-md-8 col-sm-10'>
                              <br>
                              <p>Dodawanie wyników do tabeli nie powiodło się.</p>
                          </div>
                        </div>
                     </div>";
                  }
               }
            }
            $licznik++;
         }
      } else { // Dodawanie wyniku do tabeli w przypadku, gdy w tabeli nie ma jeszcze żadnej daty.
         $sql = "INSERT INTO $daty
         VALUES(null, '$data')";
         $result = mysqli_query($dbc, $sql);

         for ($i=0; $i<$nr_1; $i++) {
            $sql_1 = "INSERT INTO $wyniki
            VALUES(null, (SELECT id_zaw FROM $zawodnicy WHERE zawodnik='$druzyna_1[$i]'), (SELECT id_daty FROM $daty WHERE data='$data'), $punkty_1, $bramki_1, 1, NOW())";
            $result_1 = mysqli_query($dbc, $sql_1);
         }

         for ($i=0; $i<$nr_2; $i++) {
            $sql_2 = "INSERT INTO $wyniki
            VALUES(null, (SELECT id_zaw FROM $zawodnicy WHERE zawodnik='$druzyna_2[$i]'), (SELECT id_daty FROM $daty WHERE data='$data'), $punkty_2, $bramki_2, 2, NOW())";
            $result_2 = mysqli_query($dbc, $sql_2);
         }

         if ($nr_3 != 0) {
            for ($i=0; $i<$nr_3; $i++) {
               $sql_3 = "INSERT INTO $wyniki
               VALUES(null, (SELECT id_zaw FROM $zawodnicy WHERE zawodnik='$druzyna_3[$i]'), (SELECT id_daty FROM $daty WHERE data='$data'), $punkty_3, $bramki_3, 3, NOW())";
               $result_3 = mysqli_query($dbc, $sql_3);
            }
         }

         if ($result) {
            echo "
            <div class='container-fluid'>
               <div class='row'>
                 <div class='col-lg-6 col-md-8 col-sm-10'>
                     <br>
                     <p>Wyniki dodano do tabeli.</p>
                 </div>
               </div>
            </div>";
         } else {
            echo "
            <div class='container-fluid'>
               <div class='row'>
                 <div class='col-lg-6 col-md-8 col-sm-10'>
                     <br>
                     <p>Dodawanie wyników do tabeli nie powiodło się.</p>
                 </div>
               </div>
            </div>";
         }
      }
   } else {
      echo "
      <div class='container-fluid'>
         <div class='row'>
           <div class='col-lg-6 col-md-8 col-sm-10'>
               <br>
               <p>Nie wybrano składów.</p>
           </div>
         </div>
      </div>";
   }
   mysqli_close($dbc);
   ?>
   <div class="container-fluid">
      <div class="row">
        <div class="col-lg-6 col-md-8 col-sm-10">
           <div class="form-group buttons_3">
             <a href='./index.php'>
               <button class='btn btn-warning'>powrót</button>
            </a>
            <a href='./tabela_adm.php'>
               <button class='btn btn-primary'>tabela</button>
            </a>
         </div>
       </div>
     </div>
   </div>
   <p class='hide'>hidden</p>
   <p class='hide'>hidden</p>


   </body>
</html>
