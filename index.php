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

     // nazwa sezonu na stronie i w menu:
     $miejsce_1 = "Hala";
     $miejsce_2 = "Kortowo";
     $rok = "2019-2020";
     // ------------------------------------------------------------------------
     // ------------------------------------------------------------------------
     $napis = null;
   ?>
   <div class='container-fluid whole_nav'>
      <div class='row'>
        <div class='col'>
        <nav class="navbar navbar-expand-md bg-light navbar-light w-100">
          <div class="container-fluid">
             <button class="navbar-toggler" data-toggle="collapse"data-target="#navbarNav">
             <span class="navbar-toggler-icon"></span>
             </button>
             <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                  <li class="nav-item mx-2">
                     <a href="./" class="nav-link active">Składy i gracze</a>
                  </li>
                  <li class="nav-item mx-2">
                     <a href="./tabela_adm.php" class="nav-link">Tabela <?php echo $miejsce_2;?></a>
                  </li>
                </ul>
             </div>
          </div>
        </nav>
        </div>
     </div>
   </div>
   <?php
   if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_REQUEST['button']=='submit_2') { // Po submitowaniu formularza dodającego zawodnika.
     $nazwisko = mysqli_real_escape_string($dbc, ucfirst(strtolower(trim($_REQUEST['nazwisko']))));
     $imie = mysqli_real_escape_string($dbc, ucfirst(strtolower(trim($_REQUEST['imie']))));
     // $login = mysqli_real_escape_string($dbc, trim($_REQUEST['login']));
     // $pass = mysqli_real_escape_string($dbc, trim($_REQUEST['pass']));
     // $pass_2 = mysqli_real_escape_string($dbc, trim($_REQUEST['pass_2']));


     // if ((!empty($_REQUEST['nazwisko']) || !empty($_REQUEST['imie'])) && !empty($_REQUEST['login']) && !empty($_REQUEST['pass']) && !empty($_REQUEST['pass_2'])) {
     //    // Warunek I: co najmniej 1 pole musi być wypełnione.
     //    if ($_REQUEST['pass'] === $_REQUEST['pass_2']) {
     //      $zawodnik = $nazwisko . ' ' . $imie;
     //      $sql_3 = "SELECT zawodnik FROM $zawodnicy WHERE zawodnik='$zawodnik'";
     //      $result_3 = mysqli_query($dbc, $sql_3);
     //      $sql_4 = "SELECT zawodnik FROM $zawodnicy WHERE username='$login'";
     //      $result_4 = mysqli_query($dbc, $sql_4);
     //      if (mysqli_num_rows($result_3) > 0) {
     //       $napis = "<p class='napis'>Taki użytkownik już istnieje. Proszę wprowadzić inne dane.</p>";
     //      } elseif (mysqli_num_rows($result_4) > 0) {
     //       $napis = "<p class='napis'>Taki login już istnieje. Proszę wybrać inny.</p>";
     //      } else {
     //         $sql_2 = "INSERT INTO $zawodnicy (zawodnik, username, password) VALUES ('$zawodnik', '$login', sha2('$pass', 512))";
     //         mysqli_query($dbc, $sql_2);
     //         $napis = "<p class='dodany'>Zawodnik został dodany.</p>";
     //         $nazwisko = '';
     //         $imie = '';
     //         $login = '';
     //         $pass = '';
     //         $pass2 = '';
     //      }
     //   } else {
     //      $napis = "<p class='napis'>Hasło i potwierdzenie hasła nie zgadzają się.</p>";
     //   }
     // } else {
     //  $napis = "<p class='napis'>Wpisz imię lub nazwisko oraz login, hasło i potwierdzenie hasła.</p>";
     // }

     if ((!empty($_REQUEST['nazwisko']) || !empty($_REQUEST['imie']))) {
        // Warunek I: co najmniej 1 pole musi być wypełnione.
          $zawodnik = $nazwisko . ' ' . $imie;
          $sql_3 = "SELECT zawodnik FROM $zawodnicy WHERE zawodnik='$zawodnik'";
          $result_3 = mysqli_query($dbc, $sql_3);
          if (mysqli_num_rows($result_3) > 0) {
           $napis = "<p class='napis'>Taki użytkownik już istnieje. Proszę wprowadzić inne dane.</p>";
          } else {
             $sql_2 = "INSERT INTO $zawodnicy (zawodnik) VALUES ('$zawodnik')";
             mysqli_query($dbc, $sql_2);
             $napis = "<p class='dodany'>Zawodnik został dodany.</p>";
             $nazwisko = '';
             $imie = '';
          }
     } else {
      $napis = "<p class='napis'>Wpisz imię lub nazwisko</p>";
     }
   }

     ?>
     <br>
     <div class="container-fluid">
        <div class="row">
          <div class="col-lg-6 col-md-8 col-sm-10">
             <div class="form-group">
                <p><strong>Wybierz składy:</strong></p>
                <label for="ile_druz">Liczba drużyn:</label>
                <select name='ile_druz' id='ile_druz' class='form-control d-inline-block' style='width:60px;'>
                 <option value='2'>2</option>
                 <option value='3'>3</option>
               </select>
               <span>&nbsp;</span>
               <button type='button' name='button' id='but_ile_druz' class='btn btn-primary btn-btn-form d-inline-block'>wybierz</button>
             </div>
          </div>
        </div>
     </div>
     <div class="container-fluid">
        <div class="row">
          <div class="col-lg-6 col-md-8 col-sm-10">
            <div id='teams'>
     <?php
     $sql = "SELECT id_zaw, zawodnik FROM $zawodnicy ORDER BY zawodnik";
     $result = mysqli_query($dbc, $sql);
     $x = 1;

     if (mysqli_num_rows($result) > 0) {
       ?>
                 <form action='wyniki_2.php' method='POST'>
                 <table id='wyniki' class='table table-bordered table-striped table-hover table-sm'>
                 <tr class='bg-dark text-white text-center font-weight-bold'>
                    <th class='lp'>l.p.</th><th>zawodnik</th><th>edytuj</th><th>usuń</th><th>skład 1</th><th>skład 2</th><th class='checkbox_3'>skład 3</th>
                 </tr>
               <?php

               if (!empty($_GET['date_back'])) {
                 $zmienna_pom = 2;
                 $date_back = $_GET['date_back'];
                 $pkt_back_1 = $_GET['pkt_back_1'];
                 $pkt_back_2 = $_GET['pkt_back_2'];
                 $bram_back_1 = $_GET['bram_back_1'];
                 $bram_back_2 = $_GET['bram_back_2'];
                 $nr_1 = $_GET['nr_1'];
                 $nr_2 = $_GET['nr_2'];

                 for ($i=0; $i<$nr_1; $i++) {
                    $napis_1[$i] = 'druzyna_1' . $i;
                    $druzyna1[$i] = $_GET["$napis_1[$i]"];
                 }
                 for ($i=0; $i<$nr_2; $i++) {
                    $napis_2[$i] = 'druzyna_2' . $i;
                    $druzyna2[$i] = $_GET["$napis_2[$i]"];
                 }

                 if (!empty($_GET['nr_3'])) {
                    $zmienna_pom = 3;
                    $pkt_back_3 = $_GET['pkt_back_3'];
                    $bram_back_3 = $_GET['bram_back_3'];
                    $nr_3 = $_GET['nr_3'];

                    for ($i=0; $i<$nr_3; $i++) {
                       $napis_3[$i] = 'druzyna_3' . $i;
                       $druzyna3[$i] = $_GET["$napis_3[$i]"];
                    }
                 } else {
                    $pkt_back_3 = '';
                    $bram_back_3 = '';
                    $nr_3 = mysqli_num_rows($result);
                    for ($i=0 ;$i< $nr_3 ;$i++) {
                       $druzyna3[$i] = '';
                    }
                 }
               } else {
                 $zmienna_pom = 1;
                 $date_back = '';
                 $pkt_back_1 = '';
                 $pkt_back_2 = '';
                 $pkt_back_3 = '';
                 $bram_back_1 = '';
                 $bram_back_2 = '';
                 $bram_back_3 = '';

                 $nr_1 = $nr_2 = $nr_3 = mysqli_num_rows($result);
                 for ($i=0 ;$i< $nr_1 ;$i++) {
                    $druzyna1[$i] = '';
                    $druzyna2[$i] = '';
                    $druzyna3[$i] = '';
                 }
               }

               while ($row = mysqli_fetch_array($result))
               {

               ?>
                 <tr class='on_hover'>
                    <td><?php echo $x . '.'; ?></td>
                    <td class='sklady'><strong><?php echo $row[1]; ?></strong></td>
                    <?php
                    echo "
                    <td class='link text-center'>
                       <a href='edit.php?id=$row[0]&amp;zawodnik=$row[1]' class='edit'>
                          edytuj
                       </a>
                    </td>
                    <td class='link text-center'>
                       <a href='remove.php?id=$row[0]&amp;zawodnik=$row[1]' class='del'>
                          usuń
                       </a>
                    </td>";
                    ?>
                    <td class='checkbox checkbox_1 text-center form-group'>
                       <input class='inp_check_1 form-control' type='checkbox' name='druzyna_1[]' value='<?php echo $row[1]; ?>'
                       <?php
                          for ($j=0; $j<$nr_1; $j++){
                            if($druzyna1[$j]===$row[1]) { echo 'checked'; }}
                       ?>>
                    </td>
                    <td class='checkbox checkbox_2 text-center form-group'>
                       <input class='inp_check_2 form-control' type='checkbox' name='druzyna_2[]' value='<?php echo $row[1]; ?>'
                       <?php
                          for ($j=0; $j<$nr_2; $j++){
                            if($druzyna2[$j]===$row[1]) { echo 'checked'; }}
                       ?>>
                    </td>
                    <td class='checkbox checkbox_3 text-center form-group' disabled>
                       <input class='inp_check_3 form-control' type='checkbox' name='druzyna_3[]' value='<?php echo $row[1]; ?>'
                       <?php
                          for ($j=0; $j<$nr_3; $j++){
                            if($druzyna3[$j]===$row[1]) { echo 'checked'; }}
                       ?>>
                    </td>
                 </tr>
               <?php
                 $x++;
               }
               ?>
                   <tr id='oddzielacz' class='bg-dark text-white'>
                     <td></td><td></td><td></td><td></td><td></td><td></td><td class='checkbox_3'></td>
                   </tr>
                   <tr class='dat_pkt_bra on_hover'>
                     <td class='normal'>

                     </td>
                     <td class='normal'>

                     </td>
                     <td class='normal'>

                     </td>
                     <td class='left text-right pr-3'>
                        <strong>data</strong>
                     </td>
                     <td colspan='3' id='date' class='form-group'>
                        <input class='input_date form-control mx-auto' type='date' name='date' value='<?php echo $date_back; ?>'>
                     </td>
                   </tr>
                   <tr class='dat_pkt_bra on_hover'>
                     <td class='normal'>

                     </td>
                     <td class='normal'>

                     </td>
                     <td class='normal'>

                     </td>
                     <td class='left text-right pr-3'>
                        <strong>punkty</strong>
                     </td>
                     <td class='checkbox text-center form-group'>
                        <input class='input_punkty form-control mx-auto' type='number' name='punkty_1' value='<?php echo $pkt_back_1; ?>'>
                     </td>
                     <td class='checkbox text-center'>
                        <input class='input_punkty form-control mx-auto' type='number' name='punkty_2' value='<?php echo $pkt_back_2; ?>'>
                     </td>
                     <td class='checkbox checkbox_3 text-center'>
                        <input class='input_punkty form-control mx-auto' type='number' name='punkty_3' value='<?php echo $pkt_back_3; ?>'>
                     </td>
                  </tr>
                  <tr class='dat_pkt_bra on_hover'>
                     <td class='normal'>

                     </td>
                     <td class='normal'>

                     </td>
                     <td class='normal'>

                     </td>
                     <td class='left text-right pr-3'>
                        <strong>bramki</strong>
                     </td>
                     <td class='checkbox'>
                        <input class='input_bramki form-control mx-auto' type='number' name='bramki_1' value='<?php echo $bram_back_1; ?>'>
                     </td>
                     <td class='checkbox'>
                        <input class='input_bramki form-control mx-auto' type='number' name='bramki_2' value='<?php echo $bram_back_2; ?>'>
                     </td>
                     <td class='checkbox checkbox_3'>
                        <input class='input_bramki form-control mx-auto' type='number' name='bramki_3' value='<?php echo $bram_back_3; ?>'>
                     </td>
                  </tr>
              </table>
              <p><small><strong>Uwaga!</strong><br>
              - Punkty nie mogą być ujemne.<br>
              - Dany zawodnik może być tylko w jednej drużynie.
           </small></p>
              <!-- <input type='submit' name='submit' value='dodaj' id='submit_1' class='add_res'> -->
              <button type='submit' name='button' value='submit_1' id='submit_1' class='add_res btn btn-primary btn-form'>dodaj</button>
              <!-- <input type='reset' name='reset' value='Wyczyść' id=''> -->
              <button type="button" name="button" id='reset_1' class='add_res btn btn-warning btn-form'>wyczyść</button> <!--Przycisk typu input nie działa przy sticky forms. -->
              </form>




       <?php
     } else {
        echo "Nie dodano jeszcze żadnych zawodników w tabeli.";
     }
   ?>
         </div>
       </div>
     </div>
   </div>
   <?php
      mysqli_close($dbc);
   ?>
   <div class="container-fluid mt-5">
      <div class="row">
         <div class="col-lg-6 col-md-8 col-sm-10">
               <p><strong>Dodaj zawodnika:</strong></p>
               <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id='form_1'>
                  <div class="form-group">
                     <div class="input-group">
                           <span class="input-group-text">
                              Nazwisko
                           </span>
                           <input type='text' name='nazwisko' id='nazwisko' value='<?php if (!empty($nazwisko)) echo $nazwisko; ?>'>
                     </div>
                  </div>
                  <div class="form-group">
                     <div class="input-group">
                           <span class="input-group-text">
                              Imię
                           </span>
                           <input type='text' name='imie' id='imie' value='<?php if (!empty($imie)) echo $imie; ?>'>
                     </div>
                  </div>
                  <!-- <div class="form-group">
                     <div class="input-group">
                           <span class="input-group-text">
                              Login
                           </span>
                           <input type='text' name='login' id='login' value='<?php if (!empty($login)) echo $login; ?>'>
                     </div>
                  </div> -->
                  <!-- <div class="form-group">
                     <div class="input-group">
                           <span class="input-group-text">
                              Hasło
                           </span>
                           <input type='password' name='pass' id='pass' value='<?php if (!empty($pass)) echo $pass; ?>'>
                     </div>
                  </div> -->
                  <!-- <div class="form-group">
                     <div class="input-group">
                           <span class="input-group-text">
                              Potwierdź hasło
                           </span>
                           <input type='password' name='pass_2' id='pass_2' value='<?php if (!empty($pass_2)) echo $pass_2; ?>'>
                     </div>
                  </div> -->

                  <?php echo $napis; ?>

                  <div class="form-group buttons">
                     <!-- <input type='submit' name='submit' value='dodaj' class='btn btn-primary btn-form' id='submit'> -->
                     <button type="submit" name='button' value='submit_2' id='submit_2' class='btn btn-primary btn-form' >dodaj</button>
                     <!-- <input type='reset' name='reset' value='Wyczyść' class='button' id='reset'> -->
                     <button type="button" name="button" id='reset_2' class='btn btn-warning btn-form' >wyczyść</button>
                     <!-- Przycisk typu input nie działa przy sticky forms. -->
                     <!-- Dodatkowo przy resecie musi być użyte type="button" -->
                  </div>
               </form>
         </div>
      </div>
   </div>
   <p class='hide'>hidden</p>
   <p class='hide'>hidden</p>

      <script>
         // ---------------------------- ile drużyn -------------------------------------------
         var teams = document.getElementById('teams');

         var dat = document.getElementById('date');
         var data_meczu = document.getElementsByClassName('input_date');
         var punkty = document.getElementsByClassName('input_punkty');
         var bramki = document.getElementsByClassName('input_bramki');
         var checkbox_1 = document.getElementsByClassName('checkbox_1');
         var checkbox_2 = document.getElementsByClassName('checkbox_2');
         var checkbox_3 = document.getElementsByClassName('checkbox_3');

         var druzyna_1 = document.getElementsByClassName('inp_check_1');
         var druzyna_2 = document.getElementsByClassName('inp_check_2');
         var druzyna_3 = document.getElementsByClassName('inp_check_3');

         var submit_1 = document.getElementById('submit_1');
         // submit_1.disabled = true;
         var reset_1 = document.getElementById('reset_1');
         reset_1.onclick = deactive_but;
         var but_ile_druz = document.getElementById('but_ile_druz');
         but_ile_druz.onclick = choose;

         if (data_meczu[0].value) {
            data_meczu[0].style.backgroundColor = 'transparent';
         }
         for (var i=0; i<punkty.length; i++) {
            if (punkty[i].value) {
               punkty[i].style.backgroundColor = 'transparent';
            }
            if (bramki[i].value) {
              bramki[i].style.backgroundColor = 'transparent';
            }
         }

         for (var i=0; i<druzyna_1.length; i++) {
            druzyna_1[i].oninput = fun;
            druzyna_2[i].oninput = fun;
            druzyna_3[i].oninput = fun;
         }

         data_meczu[0].oninput = fun;

         for (var i=0; i<punkty.length; i++) {
            punkty[i].oninput = fun;
            bramki[i].oninput = fun;
         }

         // ---------------------------------------------- funkcje ---------------------------------------------
         function choose() {
            var ile_druz = document.getElementById('ile_druz').value;

            if (ile_druz == 2) {
               teams.style.display = 'block';
               dat.setAttribute('colspan', 2);
               for (var i=0; i<checkbox_3.length; i++) {
                  checkbox_3[i].style.display = 'none';
               }
               if (<?php echo $zmienna_pom; ?> == 1 || <?php echo $zmienna_pom; ?> == 3) {      // Żeby po odświeżeniu czyścił pola wypełnionego formularza lub formularza z GET przy przejściu z 3 na 2 drużyny.
                  deactive_but();
               }
            } else {
               teams.style.display = 'block';
               for (var i=0; i<checkbox_3.length; i++) {
                  checkbox_3[i].style.display = 'table-cell';
               }
               dat.setAttribute('colspan', 3);
               if (<?php echo $zmienna_pom; ?> == 1 || <?php echo $zmienna_pom; ?> == 2) {      // Żeby po odświeżeniu czyścił pola wypełnionego formularza lub formularza z GET przy przejściu z 2 na 3 drużyny.
                  deactive_but();
               }
            }
         }

         function deactive_but() {
            submit_1.disabled = true;
            for (var i=0; i<druzyna_1.length; i++) {
               checkbox_1[i].style.backgroundColor = 'transparent'; // Czyści tło, po resecie.
               checkbox_2[i].style.backgroundColor = 'transparent';
               checkbox_3[i+1].style.backgroundColor = 'transparent';

            }
            data_meczu[0].value = '<?php if (!empty($_GET['date_back'])) echo ''; ?>';
            data_meczu[0].style.backgroundColor = 'tomato';
            for (var i=0; i<punkty.length; i++) {
               punkty[i].value = '<?php if (!empty($_GET['date_back'])) echo ''; ?>';
               bramki[i].value = '<?php if (!empty($_GET['date_back'])) echo ''; ?>';
               punkty[i].style.backgroundColor = 'tomato';
               bramki[i].style.backgroundColor = 'tomato';
            }
            for (var i=0; i<druzyna_1.length; i++) {
               druzyna_1[i].checked = false;
               druzyna_2[i].checked = false;
               druzyna_3[i].checked = false;
            }
         }

         function fun() { // Funkcja do wywoływania 3 funkcji za pomocą 1 eventu.
            active_but();
            change_color_1();
            change_color_2();
         }

         function active_but() {
           for (var i=0; i<druzyna_1.length; i++) {
             if (druzyna_1[i].checked) {
               for(var j=0; j<druzyna_2.length; j++) {
                  if (druzyna_2[j].checked) {
                     var ile_druzyn = document.getElementById('ile_druz').value;
                     if (ile_druzyn == 2 && data_meczu[0].value && punkty[0].value>=0 && punkty[1].value>=0 && bramki[0].value && bramki[1].value) {
                        for (var l=0; l<druzyna_1.length; l++) {
                           if (druzyna_1[l].checked && druzyna_2[l].checked) {
                              submit_1.disabled = true;
                              break;
                           } else {
                              submit_1.disabled = false;
                           }
                        }
                     } else {
                        for (var k=0; k<druzyna_3.length; k++) {
                           if (druzyna_3[k].checked && data_meczu[0].value && punkty[0].value>=0 && punkty[1].value>=0 && punkty[2].value>=0 && bramki[0].value && bramki[1].value && bramki[2].value && !druzyna_1[k].checked && !druzyna_2[k].checked) {
                              submit_1.disabled = false;
                              break;  // Zatrzymuje pętlę 'k'.
                           } else {
                           submit_1.disabled = true;
                           }
                        }
                     }
                     break; // Zatrzymuje pętlę 'j'.
                  } else {
                     submit_1.disabled = true;
                  }
               }
               break; // Zatrzymuje pętlę 'i'.
            } else {
               submit_1.disabled = true;
            }
          }
         }

         function change_color_1() {
           for (var i=0; i<druzyna_1.length; i++) {
             if (druzyna_1[i].checked && druzyna_2[i].checked && druzyna_3[i].checked) {
                checkbox_1[i].style.backgroundColor = 'tomato';
                checkbox_2[i].style.backgroundColor = 'tomato';
                checkbox_3[i+1].style.backgroundColor = 'tomato';
             } else if (druzyna_1[i].checked && druzyna_2[i].checked) {
                checkbox_1[i].style.backgroundColor = 'tomato';
                checkbox_2[i].style.backgroundColor = 'tomato';
                checkbox_3[i+1].style.backgroundColor = 'transparent';
             } else if (druzyna_1[i].checked && druzyna_3[i].checked) {
                checkbox_1[i].style.backgroundColor = 'tomato';
                checkbox_2[i].style.backgroundColor = 'transparent';
                checkbox_3[i+1].style.backgroundColor = 'tomato';
             } else if (druzyna_2[i].checked && druzyna_3[i].checked) {
                checkbox_1[i].style.backgroundColor = 'transparent';
                checkbox_2[i].style.backgroundColor = 'tomato';
                checkbox_3[i+1].style.backgroundColor = 'tomato';
             } else if (druzyna_1[i].checked || druzyna_2[i].checked || druzyna_3[i].checked) {
                checkbox_1[i].style.backgroundColor = 'transparent';
                checkbox_2[i].style.backgroundColor = 'transparent';
                checkbox_3[i+1].style.backgroundColor = 'transparent';
             }
          }
         }

         function change_color_2() {
            if (data_meczu[0].value != '') {
               data_meczu[0].style.backgroundColor = 'transparent';
            } else {
               data_meczu[0].style.backgroundColor = 'tomato';
            }

            for (var i=0; i<punkty.length; i++) {
               if (punkty[i].value != '') {
                  punkty[i].style.backgroundColor = 'transparent';
               } else {
                  punkty[i].style.backgroundColor = 'tomato';
               }
            }

            for (var i=0; i<punkty.length; i++) {
               if (bramki[i].value != '') {
                  bramki[i].style.backgroundColor = 'transparent';
               } else {
                  bramki[i].style.backgroundColor = 'tomato';
               }
            }
         }
         // Dodawanie zawodnika
         var reset_2 = document.getElementById('reset_2');
         var nazwisko = document.getElementById('nazwisko');
         var imie = document.getElementById('imie');
         // var login = document.getElementById('login');
         // var pass = document.getElementById('pass');
         // var pass_2 = document.getElementById('pass_2');
         reset_2.onclick = clear;

         function clear() {
            nazwisko.value = '<?php echo ''; ?>';
            imie.value = '<?php echo ''; ?>';
            // login.value = '<?php echo ''; ?>';
            // pass.value = '<?php echo ''; ?>';
            // pass_2.value = '<?php echo ''; ?>';
         }



         //------------------------------------------- test -----------------------------
         var but = document.getElementById('but');
         but.onclick = test;
         function test() {

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
