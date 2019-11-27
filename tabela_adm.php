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

     // nazwa sezonu na stronie i w menu:
     $miejsce_1 = "Hala";
     $miejsce_2 = "Kortowo";
     $rok = "2019-2020";
     // ------------------------------------------------------------------------
     // ------------------------------------------------------------------------
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
                       <a href="./" class="nav-link">Składy i gracze</a>
                    </li>
                    <li class="nav-item mx-2">
                       <a href="./tabela_adm.php" class="nav-link active">Tabela <?php echo $miejsce_2;?></a>
                    </li>
                  </ul>
               </div>
             </div>
          </nav>
          </div>
        </div>
     </div>

     <?php
     $sql = "SELECT
     $zawodnicy.zawodnik,
     COUNT($wyniki.id_daty) AS ile_mecz_zaw,
     SUM($wyniki.punkty) AS sum_point,
     SUM($wyniki.bramki) AS sum_goal,
     AVG($wyniki.punkty) AS avg_point,
     -- SUM($wyniki.punkty)*100/( COUNT($wyniki.id_daty)*3),
     SUM($wyniki.punkty)*100/
     (SELECT 3*COUNT(id_daty)+
     (SELECT 1*COUNT(id_daty) FROM $wyniki WHERE $wyniki.id_zaw=$zawodnicy.id_zaw AND punkty=4)+
     (SELECT 2*COUNT(id_daty) FROM $wyniki WHERE $wyniki.id_zaw=$zawodnicy.id_zaw AND punkty=5)+
     (SELECT 3*COUNT(id_daty) FROM $wyniki WHERE $wyniki.id_zaw=$zawodnicy.id_zaw AND punkty=6)
     FROM $wyniki WHERE $wyniki.id_zaw=$zawodnicy.id_zaw),
     AVG($wyniki.bramki) AS avg_goal,
     COUNT($wyniki.id_daty)*100/(SELECT COUNT(DISTINCT($wyniki.id_daty)) FROM $wyniki) AS ile_mecz_zaw_proc,
     (SELECT COUNT($wyniki.punkty) FROM $wyniki WHERE $wyniki.id_zaw = $zawodnicy.id_zaw AND $wyniki.punkty > 2) AS zwycięstwa,
     (SELECT COUNT($wyniki.punkty) FROM $wyniki WHERE $wyniki.id_zaw = $zawodnicy.id_zaw AND $wyniki.punkty = 1) AS remisy,
     (SELECT COUNT($wyniki.punkty) FROM $wyniki WHERE $wyniki.id_zaw = $zawodnicy.id_zaw AND $wyniki.punkty = 0) AS porażki

     FROM $wyniki
     JOIN $zawodnicy
     ON $wyniki.id_zaw = $zawodnicy.id_zaw
     GROUP BY $wyniki.id_zaw
     ORDER BY sum_point DESC, sum_goal DESC, $zawodnicy.zawodnik";

     $result = mysqli_query($dbc, $sql);
     $licznik = 1;
     if (mysqli_num_rows($result) > 0) {
       $sql_dat_dod = "SELECT DATE_FORMAT(data_dod, '%Y-%m-%d-%W') FROM $wyniki ORDER BY data_dod DESC LIMIT 1";
       $result_dat_dod = mysqli_query($dbc, $sql_dat_dod);
       $row_dat_dod = mysqli_fetch_array($result_dat_dod);

       $tbl_date = explode('-', $row_dat_dod[0]);
       switch ($tbl_date[1]) {
          case '01': $tbl_date[1] = 'styczeń';
            break;
          case '02': $tbl_date[1] = 'luty';
            break;
          case '03': $tbl_date[1] = 'marzec';
            break;
          case '04': $tbl_date[1] = 'kwiecień';
            break;
          case '05': $tbl_date[1] = 'maj';
            break;
          case '06': $tbl_date[1] = 'czerwiec';
            break;
          case '07': $tbl_date[1] = 'lipiec';
            break;
          case '08': $tbl_date[1] = 'sierpień';
            break;
          case '09': $tbl_date[1] = 'wrzesień';
            break;
          case '10': $tbl_date[1] = 'październik';
            break;
          case '11': $tbl_date[1] = 'listopad';
            break;
          case '12': $tbl_date[1] = 'grudzień';
            break;
       }

       switch ($tbl_date[3]) {
          case 'Monday': $tbl_date[3] = 'poniedziałek';
            break;
          case 'Tuesday': $tbl_date[3] = 'wtorek';
            break;
          case 'Wednesday': $tbl_date[3] = 'środa';
            break;
          case 'Thursday': $tbl_date[3] = 'czwartek';
            break;
          case 'Friday': $tbl_date[3] = 'piątek';
            break;
          case 'Saturday': $tbl_date[3] = 'sobota';
            break;
          case 'Sunday': $tbl_date[3] = 'niedziela';
            break;
       }
       ?>

       <div class="container-fluid">
          <div class="row">
            <div class="col text-center">
              <br>
              <h2>Sezon: <span style='text-shadow: 2px 1px 2px gray; '><?php echo $miejsce_1 . ' ' .  $miejsce_2 . ' ' . $rok;?></span></h2>
            </div>
          </div>
       </div>

       <?php
       $sql_ile_mecz = "SELECT COUNT(DISTINCT(id_daty)) FROM $wyniki";
       $result_ile_mecz = mysqli_query($dbc, $sql_ile_mecz);
       $row_ile_mecz = mysqli_fetch_array($result_ile_mecz);
       ?>

       <div class="container-fluid">
          <div class="row">
            <div class="col">
               <?php
                 echo "<p id='aktual'>Data aktualizacji tabeli:<br> <strong>$tbl_date[3], $tbl_date[2] $tbl_date[1] $tbl_date[0]</strong></p>";
                ?>

       <div class="table-responsive">
       <table id='wyniki_4' class='table table-bordered table-striped table-hover table-sm'>
        <thead>
         <tr class='bg-dark text-white font-weight-bold text-center'>
           <th class='lp'>l.p.</th>
           <th>zawodnik</th>
           <th class='pbm'>punkty</th>
           <th class='pbm'>bramki</th>
           <th class='stat_dod'>punkty %</th>
           <th class='stat_dod'>pkt. / mecz</th>
           <th class='stat_dod'>br. / mecz</th>
           <th class='stat_dod'>mecze %</th>
           <th class='pbm'>mecze</th>
           <th class='zrp'>z</th>
           <th class='zrp'>r</th>
           <th class='zrp'>p</th>
         </tr>
      </thead>
       <?php
       while ($row = mysqli_fetch_array($result)) {
     ?>
          <tr class='on_hover'>
            <td
               <?php if ($licznik==1) echo "style='background-color: gold;'"; elseif ($licznik==2) echo "style='background-color: silver;'"; elseif($licznik==3) echo "style='background-color: sandybrown;'";?> ><?php echo $licznik; ?>.
            </td>
            <?php
            echo "<td><strong>$row[0]</strong></td>";
            echo "<td class='text-center'><strong>$row[2]</strong></td>";
            echo "<td class='text-center'>$row[3]</td>";
            printf ("<td class='text-center'>%.0f</td>", $row[5]);
            printf ("<td class='text-center'>%.1f</td>", $row[4]);
            printf ("<td class='text-center'>%.1f</td>", $row[6]);
            printf ("<td class='text-center'>%.0f</td>", $row[7]);
            echo "<td class='text-center'>$row[1]</td>";
            echo "<td class='zrp text-center'>$row[8]</td>";
            echo "<td class='zrp text-center'>$row[9]</td>";
            echo "<td class='zrp text-center'>$row[10]</td>";
          echo "</tr>";

          $licznik++;
       }
       echo "</table>
       </div>";
       ?>
             <p>Liczba rozegranych meczów: <strong><?php echo $row_ile_mecz[0]; ?></strong></p>
           </div>
         </div>
       </div>

       <?php
       echo "<br>";

       $sql_data = "SELECT DISTINCT(DATE_FORMAT($daty.data, '%d.%m.%Y')) FROM $wyniki JOIN $daty
       ON $wyniki.id_daty = $daty.id_daty ORDER BY $daty.data";

       $result_data = mysqli_query($dbc, $sql_data);

       if (!empty($_GET['data_back'])) {
          $data_back = $_GET['data_back'];
       } else {
          $data_back = '';
       }


       if (mysqli_num_rows($result_data) > 0) {
          ?>
          <div class="container-fluid">
             <div class="row">
               <div class="col-lg-7 col-md-9 mx-auto">
                  <div class='form-group text-center'>
                     <label for="data_sel">Skład z danego dnia:</label>
                       <select id='data_sel' class='form-control d-inline-block' style='width:130px;'>
          <?php
          $licznik_2 = 1;
          $ile_dat = mysqli_num_rows($result_data);
          while ($row_data = mysqli_fetch_array($result_data)) {
             ?>
             <option value='<?php echo $row_data[0]; ?>'<?php if($row_data[0]==$data_back){echo 'selected';}else if(!$data_back && $licznik_2==$ile_dat){echo 'selected';} ?>><?php echo $row_data[0]; ?></option>

             <?php
             $licznik_2++;
          }
       ?>
          </select>
          <a id='link'><button id='button' class='btn btn-primary'>wybierz</button></a></p>
       </div>

          <script>
            var link = document.getElementById('link');
            link.onclick = fun;

            function fun() {
               var data_sel = document.getElementById('data_sel');
               var opt = data_sel.options [data_sel.selectedIndex].value;
               document.getElementById('link').setAttribute('href', 'tabela_adm.php?data_back=' + opt);
            }

          </script>

       <?php
       }

       if ($_SERVER['REQUEST_METHOD'] == 'POST') { // Po submitowaniu formularza.
          $data_del = $_POST['data_del'];

          $sql_del_1= "DELETE $wyniki FROM $wyniki
          JOIN $daty
          ON $wyniki.id_daty = $daty.id_daty
          WHERE $daty.data='$data_del'";

          $sql_del_2= "DELETE FROM $daty
          WHERE data='$data_del'";

          $result_del_1 = mysqli_query($dbc, $sql_del_1);
          $result_del_2 = mysqli_query($dbc, $sql_del_2);

          echo "<p style='color:red;'>Mecz został usunięty z tabeli.</p>";
          echo "<meta http-equiv='refresh' content='0'>"; // Odświeża stronę po submitowaniu, żeby usunąć skasowaną datę z <select>.
       }

       if ($data_back) {
          $sql_druz_1 = "SELECT $zawodnicy.zawodnik, $wyniki.punkty, $wyniki.bramki
          FROM $zawodnicy
          JOIN $wyniki
          ON $zawodnicy.id_zaw = $wyniki.id_zaw
          WHERE $wyniki.nr_druz = 1 && $wyniki.id_daty = (SELECT id_daty FROM $daty WHERE DATE_FORMAT(data, '%d.%m.%Y')='$data_back')";
          $result_druz_1 = mysqli_query($dbc, $sql_druz_1);
          $x = 0;
          while($row_druz_1 = mysqli_fetch_array($result_druz_1)) {
             $druzyna_1[$x] = $row_druz_1[0];
             $punkty_1[$x] = $row_druz_1[1];
             $bramki_1[$x] = $row_druz_1[2];
             $x++;
          }
          $nr_1 = count($druzyna_1);

          $sql_druz_2 = "SELECT $zawodnicy.zawodnik, $wyniki.punkty, $wyniki.bramki
          FROM $zawodnicy
          JOIN $wyniki
          ON $zawodnicy.id_zaw = $wyniki.id_zaw
          WHERE $wyniki.nr_druz = 2 && $wyniki.id_daty = (SELECT id_daty FROM $daty WHERE DATE_FORMAT(data, '%d.%m.%Y')='$data_back')";
          $result_druz_2 = mysqli_query($dbc, $sql_druz_2);
          $y = 0;
          while($row_druz_2 = mysqli_fetch_array($result_druz_2)) {
             $druzyna_2[$y] = $row_druz_2[0];
             $punkty_2[$y] = $row_druz_2[1];
             $bramki_2[$y] = $row_druz_2[2];
          $y++;
          }
          $nr_2 = count($druzyna_2);

          $sql_druz_3 = "SELECT $zawodnicy.zawodnik, $wyniki.punkty, $wyniki.bramki
          FROM $zawodnicy
          JOIN $wyniki
          ON $zawodnicy.id_zaw = $wyniki.id_zaw
          WHERE $wyniki.nr_druz = 3 && $wyniki.id_daty = (SELECT id_daty FROM $daty WHERE DATE_FORMAT(data, '%d.%m.%Y')='$data_back')";
          $result_druz_3 = mysqli_query($dbc, $sql_druz_3);
          if (mysqli_num_rows($result_druz_3) > 0) {
             $y = 0;
             while($row_druz_3 = mysqli_fetch_array($result_druz_3)) {
               $druzyna_3[$y] = $row_druz_3[0];
               $punkty_3[$y] = $row_druz_3[1];
               $bramki_3[$y] = $row_druz_3[2];
             $y++;
             }
             $nr_3 = count($druzyna_3);
          } else {
             $nr_3 = 0;
             // $druzyna_3[0] = '';
          }
          $nr = [$nr_1, $nr_2, $nr_3];
          sort($nr);

          for($i=0; $i<$nr[2]; $i++) {
             if ($i >= $nr_1) {
                $druzyna_1[$i] = '';
             }
             if ($i >= $nr_2) {
                $druzyna_2[$i] = '';
             }
             if ($i >= $nr_3) {
                $druzyna_3[$i] = '';
             }
          }

          $sql_ilu_gracz = "SELECT COUNT(id_zaw)
          FROM $wyniki
          JOIN $daty
          ON $wyniki.id_daty=$daty.id_daty
          WHERE DATE_FORMAT(data, '%d.%m.%Y')='$data_back'";

          $data_normal = explode('.', $data_back); // Przywracamy datę do postaci, w jakiej będzie mogła być wstawiona do formularza z datą.
          $data_del = $data_normal[2] . '-' . $data_normal[1] . '-' . $data_normal[0];
          ?>
          <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method='post'>
             <input type='date' name='data_del' value='<?php echo $data_del; ?>' style='display:none;'>
          <?php

          $result_ilu_gracz = mysqli_query($dbc, $sql_ilu_gracz);
          $row_ilu_gracz = mysqli_fetch_array($result_ilu_gracz);
          ?>
          <br>
          <p>Ilość zawodników: <strong><?php echo $row_ilu_gracz[0]; ?></strong></p>
          <table id='sklad' class='table table-bordered table-striped table-sm'>
            <tr class='bg-secondary text-white font-weight-bold text-center'>
              <th class='lp'>l.p.</th>
              <th class='sklady'>Skład 1</th>
              <th class='sklady'>Skład 2</th>
              <th <?php if($nr_3==0) echo "style='display:none'"; ?> class='sklady'>Skład 3</th>
          <?php
          echo "</tr>";

          sort($druzyna_1);
          sort($druzyna_2);
          sort($druzyna_3);

          for ($i=0; $i<$nr[2]; $i++) { // Usunie elementy o pustych łańcuchach.
             if ($druzyna_1[$i] == '') {
                $druzyna_1[] = $druzyna_1[$i];
                unset($druzyna_1[$i]);
             }

             if ($druzyna_2[$i] == '') {
                $druzyna_2[] = $druzyna_2[$i];
                unset($druzyna_2[$i]);
             }

             if ($druzyna_3[$i] == '') {
                $druzyna_3[] = $druzyna_3[$i];
                unset($druzyna_3[$i]);
             }
          }

          $druzyna_1 = array_values($druzyna_1); // Nada nową numerację po usunięciu elementów z pustymi łańcuchami.
          $druzyna_2 = array_values($druzyna_2);
          $druzyna_3 = array_values($druzyna_3);

          for ($i=0; $i<$nr[2]; $i++) {
             ?>
             <tr>
                <td class='on_hover'><?php echo $i+1 . '.'; ?></td>
                <td class='on_hover'><strong><?php echo $druzyna_1[$i]; ?></strong></td>
                <td class='on_hover'><strong><?php echo $druzyna_2[$i]; ?></strong></td>
                <td class='on_hover' <?php if($nr_3==0) echo "style='display:none'"; ?> ><strong><?php echo $druzyna_3[$i]; ?></strong></td>
             </tr>
             <?php
          }
          ?>
          <tr class='bg-secondary'>
             <td></td>
             <td></td>
             <td></td>
             <td <?php if($nr_3==0) echo "style='display:none'"; ?>></td>
          </tr>
          <tr class='pkt_bra'>
             <td></td>
             <td class='on_hover'>Punkty: <strong><?php echo $punkty_1[0]; ?></strong></td>
             <td class='on_hover'>Punkty: <strong><?php echo $punkty_2[0]; ?></strong></td>
             <td class='on_hover' <?php if($nr_3==0) echo "style='display:none'"; ?> >Punkty: <strong><?php echo $punkty_3[0]; ?></strong></td>
          </tr>
          <tr class='pkt_bra'>
             <td></td>
             <td class='on_hover'>Bramki: <strong><?php echo $bramki_1[0]; ?></strong></td>
             <td class='on_hover'>Bramki: <strong><?php echo $bramki_2[0]; ?></strong></td>
             <td class='on_hover' <?php if($nr_3==0) echo "style='display:none'"; ?> >Bramki: <strong><?php echo $bramki_3[0]; ?></strong></td>
          </tr>
          </table>
          <div class='form-group'>
            <input type='button' name='button' value='Usuń mecz' id='button_1' class='btn btn-danger'>
            <span style='display:none;' id='sub_span'>&nbsp; Czy na pewno usunąć?
                  <input type='submit' name='submit' value='tak' id='submit' class='btn btn-primary'>
                  <input type='button' name='button' value='nie' id='button_2' class='btn btn-warning'>
            </span>
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
           <div class="col">
             <br>
             <p>W tabeli nie ma jeszcze żadnych wyników.</p>
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
        var button_1 = document.getElementById('button_1');
        var button_2 = document.getElementById('button_2');
        var sub_span = document.getElementById('sub_span');

        button_1.onclick = show;
        function show() {
           sub_span.style.display = 'inline';
        }

        button_2.onclick = hide;
        function hide() {
           sub_span.style.display = 'none';
        }

     </script>
     <script src="http://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
       crossorigin="anonymous"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
       crossorigin="anonymous"></script>
     <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T"
       crossorigin="anonymous"></script>
       <script src="https://unpkg.com/floatthead"></script>
       <script>
        // $('table').floatThead(); // Na małych ekranach nie skroluje nagłówka w poziomie.
        $('table').floatThead({
          responsiveContainer: function($table){
            return $table.closest(".table-responsive");
          }
        });

       </script>
  </body>
</html>
