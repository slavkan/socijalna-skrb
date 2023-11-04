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
  <link rel="stylesheet" href="./css/addNewForm.css">
  <link rel="stylesheet" href="./css/navStyle.css">
  <title>Social Care</title>
</head>
<body>
<?php include('navbar.php'); ?>

<div class="create-container">
  <?php if (isset($_GET['error'])) { ?>
      <div class="alert alert-danger col-md-12 mx-auto text-center alert-dismissible d-flex justify-content-between" role="alert">
          <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
          <?=$_GET['error']?>
      </div>
  <?php } ?>

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


  <h4 class="add-new-header">Uredi informacije klijenta</h4>
  <form action="clientCode.php" method="POST" class="add-new-form">
    <!-- Hidden ID -->
    <input type="text" name="client_id" value="<?=$client['client_id'];?>" hidden>
    <!-- Ime -->
		<div class="form-group">
			<label>Ime</label>
			<input type="text" name="ime" class="form-control" value="<?=$client['ime'];?>">
		</div>
    <!-- Ime roditelja -->
		<div class="form-group">
			<label class="mt-3">Ime roditelja</label>
			<input type="text" name="ime_roditelja" class="form-control" value="<?=$client['ime_roditelja'];?>">
		</div>
    <!-- Prezime -->
    <div class="form-group">
			<label class="mt-3">Prezime</label>
			<input type="text" name="prezime" class="form-control" value="<?=$client['prezime'];?>">
		</div>
    <!-- Spol -->
    <div class="form-group">
      <label for="spol" class="mt-3">Spol</label>
      <select class="form-select" id="spol" name="spol">
        <?php
          $defaultSpol = $client['spol'];
          $options = ["Muško", "Žensko"];
          foreach ($options as $option) {
            $selected = ($option == $defaultSpol) ? 'selected' : '';
            echo '<option value="' . $option . '" ' . $selected . '>' . $option . '</option>';
          }
        ?>
      </select>
    </div>
    <!-- Zupanije i gradovi -->
    <div class="form-group">
      <label for="zupanija" class="mt-3">Županija</label>
      <select class="form-select" id="zupanija" name="zupanija" onchange="popuniGradove()">
      </select>
    </div>
    <div class="form-group">
      <div class="grad-input-flex">
        <div class="grad-select me-3">
          <label for="grad" class="mt-3">Odaberite grad</label>
          <select class="form-select" id="grad" name="grad" default="Upišite grad">
            <option value="Upišite grad" selected>Upišite grad</option>
          </select>
        </div>
        <div class="grad-input ms-3">
          <label class="mt-3">Upišite grad</label>
			    <input type="text" id="gradInput" name="gradInput" class="form-control grad-type-input" value="<?=$client['grad'];?>">
        </div>
      </div>
    </div>
    <!-- Adresa -->
    <div class="form-group">
			<label class="mt-3">Adresa</label>
			<input type="text" name="adresa" class="form-control" value="<?=$client['adresa'];?>">
		</div>
    <!-- JMBG -->
    <div class="form-group">
			<label class="mt-3">JMBG</label>
			<input type="text" name="jmbg" class="form-control" value="<?=$client['jmbg'];?>">
		</div>
    <!-- Broj mobitela -->
    <div class="form-group">
			<label class="mt-3">Broj mobitela</label>
			<input type="text" name="broj_mobitela" class="form-control" value="<?=$client['broj_mobitela'];?>">
		</div>
    <!-- Obrazlozenje -->
    <div class="form-group">
      <label for="obrazlozenje" class="mt-3">Obrazloženje</label>
      <textarea lang="hr" id="obrazlozenje" name="obrazlozenje" class="form-control obrazlozenje-area"><?=$client['obrazlozenje'];?></textarea>
    </div>
    <!-- Pomoci -->
    <div class="form-group mt-3">
      <div class="form-check">
      <input class="form-check-input" type="checkbox" name="nezaposlenost" value="nezaposlenost" id="flexCheckDefault" <?php if ($nezaposlenost == 1) echo 'checked'; ?>>
        <label class="form-check-label" for="flexCheckDefault">Naknade za nezaposlenost</label>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="checkbox" name="mirovine" value="mirovine" id="flexCheckMirovine" <?php if ($mirovine == 1) echo 'checked'; ?>>
        <label class="form-check-label" for="flexCheckMirovine">Mirovine</label>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="checkbox" name="socijalnaSkrb" value="socijalnaSkrb" id="flexCheckSocijalnaSkrb" <?php if ($socijalnaSkrb == 1) echo 'checked'; ?>>
        <label class="form-check-label" for="flexCheckSocijalnaSkrb">Socijalna skrb</label>
      </div>
    </div>
    <!-- END -->
		<div class="mb-3 mt-3">
			<button type="submit" name="update_client" class="btn btn-primary">Uredi klijenta</button>
		</div>
	</form>
</div>


<input type="hidden" value="<?=$client['zupanija'];?>" id="tempZupanija" name="tempZupanija">
<input type="hidden" value="<?=$client['grad'];?>" id="tempGrad" name="tempGrad">
<input type="hidden" value="<?=$client['spol'];?>" id="tempSpol" name="tempSpol">

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="./js/placesForEdit.js"></script>
</body>
</html>

<?php }else{
	// header("Location: ../index.php");
	header("Location: " . $_SESSION['lastValidUrl']);
} ?>