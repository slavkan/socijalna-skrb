<?php
session_start();
include "../php/db_conn.php";

if(isset($_POST['save_client'])){
  $ime = $_POST["ime"];
  $ime_roditelja = $_POST["ime_roditelja"];
  $prezime = $_POST["prezime"];
  $spol = $_POST["spol"];
  $zupanija = $_POST["zupanija"];
  $grad = $_POST["grad"];
  if (isset($_POST["gradInput"])) {
    $gradInput = $_POST["gradInput"];
    $grad = $gradInput;
  } else{
    $gradInput = "";
  }
  $adresa = $_POST["adresa"];
  $jmbg = $_POST["jmbg"];
  $broj_mobitela = $_POST["broj_mobitela"];
  $obrazlozenje = $_POST["obrazlozenje"];
  $nezaposlenost = 0;
  $mirovine = 0;
  $socijalnaSkrb = 0;
  if(isset($_POST['nezaposlenost'])) {
    $nezaposlenost = 1;
  }
  if(isset($_POST['mirovine'])) {
    $mirovine = 1;
  }
  if(isset($_POST['socijalnaSkrb'])) {
    $socijalnaSkrb = 1;
  }

  if(empty($ime) || empty($ime_roditelja) || empty($prezime) || empty($adresa) || empty($jmbg) || empty($obrazlozenje)){
    header("Location: ./clientCreate.php?error=Morate popuniti sva polja");
    exit;
  }
  else if($zupanija === "Odaberite županiju" || ($grad === "Upišite grad" && $gradInput === "") || $grad === ""){
    header("Location: ./clientCreate.php?error=Morate odabrati županiju i grad");
    exit;
  }

  $query = "INSERT INTO client (ime, ime_roditelja, prezime, spol, zupanija, grad, adresa, jmbg, broj_mobitela, obrazlozenje, pomoc1, pomoc2, pomoc3)
  VALUES ('$ime', '$ime_roditelja', '$prezime', '$spol', '$zupanija', '$grad', '$adresa', '$jmbg', '$broj_mobitela', '$obrazlozenje', '$nezaposlenost', '$mirovine', '$socijalnaSkrb')";

  echo $query;

  $query_run = mysqli_query($conn, $query);

  if($query_run){
    header("Location: clientTable.php?success=Klijent uspiješno dodan");
    exit(0);
  }
  else{
    header("Location: ./clientTable.php?error=Došlo je do greške prilikom kreiranja klijenta. Probajte drugi put.");
    exit(0);
  }
}


if(isset($_POST['update_client'])){
  var_dump($_POST);
  $client_id = $_POST["client_id"]; 
  $ime = $_POST["ime"];
  $ime_roditelja = $_POST["ime_roditelja"];
  $prezime = $_POST["prezime"];
  $spol = $_POST["spol"];
  $zupanija = $_POST["zupanija"];
  $grad = $_POST["grad"];
  if (isset($_POST["gradInput"])) {
    $gradInput = $_POST["gradInput"];
    $grad = $gradInput;
  } else{
    $gradInput = "";
  }
  $adresa = $_POST["adresa"];
  $jmbg = $_POST["jmbg"];
  $broj_mobitela = $_POST["broj_mobitela"];
  $obrazlozenje = $_POST["obrazlozenje"];
  $nezaposlenost = 0;
  $mirovine = 0;
  $socijalnaSkrb = 0;
  if(isset($_POST['nezaposlenost'])) {
    $nezaposlenost = 1;
  }
  if(isset($_POST['mirovine'])) {
    $mirovine = 1;
  }
  if(isset($_POST['socijalnaSkrb'])) {
    $socijalnaSkrb = 1;
  }
  
  if(empty($ime) || empty($ime_roditelja) || empty($prezime) || empty($adresa) || empty($jmbg) || empty($obrazlozenje)){
    header("Location: ./clientTable.php?error=Morate popuniti sva polja");
    exit;
  }
  else if($zupanija === "Odaberite županiju" || ($grad === "Upišite grad" && $gradInput === "") || $grad === ""){
    header("Location: ./clientTable.php?error=Morate odabrati županiju i grad");
    exit;
  }

  $query = $query = "UPDATE client
  SET ime = '$ime', ime_roditelja = '$ime_roditelja', prezime = '$prezime', spol = '$spol', zupanija = '$zupanija',
  grad = '$grad', adresa = '$adresa', jmbg = '$jmbg', broj_mobitela = '$broj_mobitela',
  obrazlozenje = '$obrazlozenje', pomoc1 = '$nezaposlenost', pomoc2 = '$mirovine', pomoc3 = '$socijalnaSkrb'
  WHERE client_id = '$client_id'";

  echo $query;

  $query_run = mysqli_query($conn, $query);

  if($query_run){
    header("Location: clientTable.php?success=Klijent uspiješno uređen");
    exit(0);
  }
  else{
    header("Location: ./clientTable.php?error=Došlo je do greške prilikom uređivanja klijenta. Probajte drugi put.");
    exit(0);
  }
}

if(isset($_POST['delete_client'])){
  $client_id = $_POST["delete_client"];

  $query = "DELETE FROM client WHERE client_id='$client_id' ";
  $query_run = mysqli_query($conn, $query);

  if($query_run){
    header("Location: clientTable.php?success=Klijent obrisan");
    exit(0);
  }
  else{
    header("Location: clientTable.php?error=Klijent nije obrisan");
    exit(0);
  }
}

?>