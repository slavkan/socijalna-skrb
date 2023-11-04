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

  <h4 class="add-new-header">Novi klijent</h4>
  <form action="clientCode.php" method="POST" class="add-new-form">
    <!-- Ime -->
		<div class="form-group">
			<label>Ime</label>
			<input type="text" name="ime" class="form-control">
		</div>
    <!-- Ime -->
		<div class="form-group">
			<label class="mt-3">Ime roditelja</label>
			<input type="text" name="ime_roditelja" class="form-control">
		</div>
    <!-- Prezime -->
    <div class="form-group">
			<label class="mt-3">Prezime</label>
			<input type="text" name="prezime" class="form-control">
		</div>
    <!-- Spol -->
    <div class="form-group">
      <label for="stanje" class="mt-3">Spol</label>
      <select class="form-select" id="stanje" name="spol">
        <option value="Muško">Muško</option>
        <option value="Žensko">Žensko</option>
      </select>
    </div>
    <!-- Zupanije i gradovi -->
    <div class="form-group">
      <label for="zupanija" class="mt-3">Županija:</label>
      <select class="form-select" id="zupanija" name="zupanija" onchange="popuniGradove()"></select>
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
			    <input type="text" id="gradInput" name="gradInput" class="form-control grad-type-input" value="">
        </div>
      </div>
    </div>
    <!-- Adresa -->
    <div class="form-group">
			<label class="mt-3">Adresa</label>
			<input type="text" name="adresa" class="form-control">
		</div>
    <!-- JMBG -->
    <div class="form-group">
			<label class="mt-3">JMBG</label>
			<input type="text" name="jmbg" class="form-control">
		</div>
    <!-- Broj mobitela -->
    <div class="form-group">
			<label class="mt-3">Broj mobitela</label>
			<input type="text" name="broj_mobitela" class="form-control">
		</div>
    <!-- Obrazlozenje -->
    <div class="form-group">
      <label for="obrazlozenje" class="mt-3">Obrazloženje</label>
      <textarea id="obrazlozenje" name="obrazlozenje" class="form-control obrazlozenje-area"></textarea>
    </div>
    <!-- Pomoci -->
    <div class="form-group mt-3">
      <div class="form-check">
        <input class="form-check-input" type="checkbox" name="nezaposlenost" value="nezaposlenost" id="flexCheckDefault">
        <label class="form-check-label" for="flexCheckDefault">Naknade za nezaposlenost</label>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="checkbox" name="mirovine" value="mirovine" id="flexCheckMirovine">
        <label class="form-check-label" for="flexCheckMirovine">Mirovine</label>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="checkbox" name="socijalnaSkrb" value="socijalnaSkrb" id="flexCheckSocijalnaSkrb">
        <label class="form-check-label" for="flexCheckSocijalnaSkrb">Socijalna skrb</label>
      </div>
    </div>
    <!-- END -->
		<div class="mb-3 mt-3">
			<button type="submit" name="save_client" class="btn btn-primary">Dodaj klijenta</button>
		</div>
	</form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="./js/placesOnChange.js"></script>
</body>
</html>

<?php }else{
	// header("Location: ../index.php");
	header("Location: " . $_SESSION['lastValidUrl']);
} ?>