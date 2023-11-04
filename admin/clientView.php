<?php 
  session_start();
  include "../php/db_conn.php";
  if (isset($_SESSION['username']) && isset($_SESSION['user_id']) && isset($_SESSION['userrole'])) { $_SESSION['lastValidUrl'] = $_SERVER['REQUEST_URI'];  ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" media="all" href="./css/clientPrint.css">
  <link rel="stylesheet" href="./css/navStyle.css">
  <title>Social Care</title>
</head>
<body>
<?php include('navbar.php'); ?>

  <?php
    if(isset($_GET['id'])){
      $client_id = mysqli_real_escape_string($conn, $_GET['id']);
      $query = "SELECT client_id, ime, ime_roditelja, prezime, spol, zupanija, grad, adresa, jmbg, broj_mobitela, obrazlozenje, pomoc1, pomoc2, pomoc3
      FROM client
      WHERE client_id = '$client_id'";
      $query_run = mysqli_query($conn, $query);
      if(mysqli_num_rows($query_run) > 0){
        $client = mysqli_fetch_array($query_run);
      }

      $nezaposlenost = 0;
      $mirovine = 0;
      $socijalnaSkrb = 0;
      if($client['pomoc1'] == 1) $nezaposlenost = 1;
      if($client['pomoc2'] == 1) $mirovine = 1;
      if($client['pomoc3'] == 1) $socijalnaSkrb = 1;
    }
  ?>

  <div class="page-and-info-flex">
    <button class="btn btn-primary print-btn" id="print">Printaj</button>
    <div class="print-container">
      <div class="text-user-info"><?=$client['ime'];?> (<?=$client['ime_roditelja'];?>) <?=$client['prezime'];?></div>
      <div class="text-info-description border-t">(Ime, ime jednog roditelja i prezime podnositelja zahtjeva)</div>
      <div class="jmbg-tel-flex">
        <div class="jmbg-cell">
          <div class="text-user-info center-text"><?=$client['jmbg'];?></div>
          <div class="text-info-description jmbg-tel-description-cells center-text border-t">JMBG</div>
        </div>
        <div class="tel-cell">
          <div class="text-user-info center-text"><?=$client['broj_mobitela'];?></div>
          <div class="text-info-description jmbg-tel-description-cells center-text border-t">Broj telefona</div>
        </div>
      </div>
      <div class="text-user-info adresa-mt center-text"><?=$client['adresa'];?></div>
      <div class="text-info-description adresa-description center-text border-t">(Adresa prebivališta)</div>
      <div class="org-name-flex">
        <div class="org-name">CENTAR ZA SOCIJALNI RAD LJUBUŠKI</div>
      </div>
      <div class="text-user-info">Na temelju članka 41. Zakona o socijalnoj zaštiti , zaštiti civilnih žrtava rata i žaštiti obitelji s djecom / Sl. novine ŽZH broj: 16/01 / podnosim</div>
      <div class="zahtjev-header center-text">ZAHTJEV</div>
      <div class="under-zahtjev-header">ZA PRIZNAVANJE PRAVA NE JEDNOKRATNU NOVČANU POTPORU</div>
      <div class="text-user-info">Podnosim zahtjev kojim predlažem da mi odobrite novčanu pomoć iz sljedećih razloga:</div>
      <div class="text-user-info obrazlozenje"><?=$client['obrazlozenje'];?></div>
      <div class="text-user-info text-bold">Stranka je suglasna i upoznata da će se njezini osobni podaci koristiti samo u svrhu rješavanja podnesenog zahtjeva.</div>
      <div class="bottom-info-datum">
        <div class="text-bold text-italics">Datum</div>
        <div id="date" class="text-bold text-italics"></div>
      </div>
      <div class="bottom-info-potpis">
        <div class="center-text text-bold text-italics">Potpis podnositelja zahtjeva</div>
        <div class="center-text text-bold">_________________________</div>
      </div>
    </div>
    <div class="user-info-box">
      <div class="user-info-table-flex">
        <div class="user-info-row">
          <div class="user-info-first-column text-bold">Ime</div>
          <div class="user-info-second-column"><?=$client['ime'];?></div>
        </div>
        <div class="user-info-row">
          <div class="user-info-first-column text-bold">Ime oca</div>
          <div class="user-info-second-column"><?=$client['ime_roditelja'];?></div>
        </div>
        <div class="user-info-row">
          <div class="user-info-first-column text-bold">Prezime</div>
          <div class="user-info-second-column"><?=$client['prezime'];?></div>
        </div>
        <div class="user-info-row">
          <div class="user-info-first-column text-bold">JMBG</div>
          <div class="user-info-second-column"><?=$client['jmbg'];?></div>
        </div>
        <div class="user-info-row">
          <div class="user-info-first-column text-bold">Broj telefona</div>
          <div class="user-info-second-column"><?=$client['broj_mobitela'];?></div>
        </div>
        <div class="user-info-row">
          <div class="user-info-first-column text-bold">Adresa prebivališta</div>
          <div class="user-info-second-column"><?=$client['adresa'];?></div>
        </div>
        <div class="user-info-row user-info-row-obrazlozenje">
          <div class="user-info-obrazlozenje-header text-bold">Obrazloženje</div>
          <div><?=$client['obrazlozenje'];?></div>
        </div>
      </div>
    </div>

    </div>
  </div>
  









<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="./js/print.js"></script>
<script src="./js/currentDate.js"></script>
</body>
</html>

<?php }else{
	// header("Location: ../index.php");
	header("Location: " . $_SESSION['lastValidUrl']);
} ?>