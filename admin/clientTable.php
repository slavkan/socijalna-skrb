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
  <link rel="stylesheet" href="./css/tableView.css">
  <link rel="stylesheet" href="./css/navStyle.css">
  <title>Social Care</title>
</head>
<body>
<?php include('navbar.php'); ?>

<div class="new-btn-container">
  <?php if (isset($_GET['success'])) { ?>
    <div class="alert alert-success col-md-12 mx-auto text-center alert-dismissible d-flex justify-content-between" role="alert">
        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
        <?=$_GET['success']?>
    </div>
  <?php } ?>
  <?php if (isset($_GET['error'])) { ?>
      <div class="alert alert-danger col-md-12 mx-auto text-center alert-dismissible d-flex justify-content-between" role="alert">
          <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
          <?=$_GET['error']?>
      </div>
  <?php } ?>
</div>


<div class="new-btn-container">
  <a href="./clientCreate.php" class="btn btn-primary add-new-btn-height">Dodaj novoga klijenta</a>

    <form action="./clientTable.php" method="POST" class="filter-flex">
      <div class="form-group">
				<label>Ime</label>
				<input type="text" name="ime" class="form-control">
			</div>
      <div class="form-group mx-3 mx-1200-none my-1200">
				<label>Prezime</label>
				<input type="text" name="prezime" class="form-control">
			</div>
      <div class="form-group me-3 mx-1200-none">
				<label>JMBG</label>
				<input type="text" name="jmbg" class="form-control">
			</div>
      <button type="submit" name="filter_client" class="btn btn-primary my-filter-btn-1200">Filtriraj klijente</button>
    </form>

</div>
<div class="table-flex">
  <div class="table-header">
    <div class="table-header-cell">Ime</div>
    <div class="table-header-cell">Prezime</div>
    <div class="table-header-cell hide-cell-1600-screen">Spol</div>
    <div class="table-header-cell hide-cell-1200-screen">Županija</div>
    <div class="table-header-cell hide-cell-800-screen">Grad</div>
    <div class="table-header-cell hide-cell-1600-screen">Adresa</div>
    <div class="table-header-cell">JMBG</div>
    <div class="table-header-cell hide-cell-1200-screen">Broj Mobitela</div>
    <div class="table-header-cell"></div>
  </div>


  <?php
    $NUMBER_PER_PAGE = 10;
    $query = "SELECT client_id, ime, prezime, spol, zupanija, grad, adresa, jmbg, broj_mobitela FROM client";

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
      $ime = $_POST["ime"];
      $prezime = $_POST["prezime"];
      $jmbg = $_POST["jmbg"];
      $page = 1;
      if (isset($_POST["page"])) {
        $page = $_POST["page"];
      }
      // WHERE
      $filterQuery = " WHERE ";
      $firstAndDone = 0;

      if(!empty($ime)){
        $filterQuery .= "ime LIKE '%" . $ime . "%'";
        $firstAndDone = 1;
      }
      if(!empty($prezime)){
        if($firstAndDone == 1){
          $filterQuery .= ' AND ';
        }
        $filterQuery .= "prezime LIKE '%" . $prezime . "%' ";
      }
      if(!empty($jmbg)){
        if($firstAndDone == 1){
          $filterQuery .= ' AND ';
        }
        $filterQuery .= "jmbg LIKE '%" . $jmbg . "%' ";
      }
      if(!empty($ime) || !empty($prezime) || !empty($jmbg)){
        $query .= $filterQuery;
      }
      // LIMIT
      $query .= " LIMIT $NUMBER_PER_PAGE";
      if($page > 1){
        $offsetAmmount = $NUMBER_PER_PAGE*($page-1);
        $query .= " OFFSET " . $offsetAmmount;
      }
    } else{
      $query .= " LIMIT $NUMBER_PER_PAGE";
      $page = 1;
    }


    $query_run = mysqli_query($conn, $query);
    if(mysqli_num_rows($query_run) > 0){
      foreach($query_run as $user_info){
        ?>
        <div class="table-row">
          <div class="table-row-cell"><?= $user_info['ime']; ?></div>
          <div class="table-row-cell"><?= $user_info['prezime']; ?></div>
          <div class="table-row-cell hide-cell-1600-screen"><?= $user_info['spol']; ?></div>
          <div class="table-row-cell hide-cell-1200-screen"><?= $user_info['zupanija']; ?></div>
          <div class="table-row-cell hide-cell-800-screen"><?= $user_info['grad']; ?></div>
          <div class="table-row-cell hide-cell-1600-screen"><?= $user_info['adresa']; ?></div>
          <div class="table-row-cell hide-cell-600-screen"><?= $user_info['jmbg']; ?></div>
          <div class="table-row-cell show-cell-600-screen">
            <div class="table-row-cell"><?= substr($user_info['jmbg'], 0, 6); ?></div>
            <div class="table-row-cell"><?= substr($user_info['jmbg'], 6); ?></div>
          </div>
          <div class="table-row-cell hide-cell-1200-screen"><?= $user_info['broj_mobitela']; ?></div>
          <div class="table-row-cell buttons-flex">
            <a href="clientView.php?id=<?= $user_info['client_id']; ?>" class="btn btn-sm btn-outline-primary btn-hover">
              <img src="./icons/print-solid.svg" alt="Print" class="icon icon-print">
            </a>
            <a href="clientEdit.php?id=<?= $user_info['client_id']; ?>" class="btn btn-sm btn-outline-success btn-hover">
              <img src="./icons/pen-to-square-solid.svg" alt="Print" class="icon icon-edit">
            </a>
            <form action="clientCode.php" method="POST" class="d-inline" onsubmit="return confirmDelete('<?=$user_info['ime']?>', '<?=$user_info['prezime']?>');">
              <button type="submit" name="delete_client" value="<?=$user_info['client_id'];?>" class="btn btn-sm btn-outline-danger btn-hover">
                <img src="./icons/trash-can-solid.svg" alt="Delete" class="icon icon-delete">
              </button>
            </form>
          </div>
        </div>
      <?php
      }
    }
    else{
      echo "<h5>Nema klijenata u bazi!</h5>";
    }
  ?>
</div>
<!-- Pagination -->
<?php
$ime = "";
$prezime = "";
$jmbg = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $ime = $_POST["ime"];
  $prezime = $_POST["prezime"];
  $jmbg = $_POST["jmbg"];
  $page = 1;
  if (isset($_POST["page"])) {
    $page = $_POST["page"];
  }
}



$query = "SELECT COUNT(*) AS count FROM client";
// WHERE
$filterQuery = " WHERE ";
$firstAndDone = 0;

if(!empty($ime)){
  $filterQuery .= "ime LIKE '%" . $ime . "%'";
  $firstAndDone = 1;
}
if(!empty($prezime)){
  if($firstAndDone == 1){
    $filterQuery .= ' AND ';
  }
  $filterQuery .= "prezime LIKE '%" . $prezime . "%' ";
}
if(!empty($jmbg)){
  if($firstAndDone == 1){
    $filterQuery .= ' AND ';
  }
  $filterQuery .= "jmbg LIKE '%" . $jmbg . "%' ";
}
if(!empty($ime) || !empty($prezime) || !empty($jmbg)){
  $query .= $filterQuery;
}
// END WHERE

$query_run = mysqli_query($conn, $query);
$numOfClients = 0;
$isNumOfPagesMoreThenFive = 0;
if(mysqli_num_rows($query_run) > 0){
  foreach($query_run as $count_info){
    $numOfClients = $count_info['count'];
    $numOfTotalPages = ceil($numOfClients / $NUMBER_PER_PAGE);
    if($numOfTotalPages > 5) $isNumOfPagesMoreThenFive = 1;

  }
}


?>
<div class="pagination-flex">
  <form action="./clientTable.php" method="POST" class="page-form-height">
    <input type="text" name="ime" hidden value="<?php echo $ime ?>">
    <input type="text" name="prezime" hidden value="<?php echo $prezime ?>">
    <input type="text" name="jmbg" hidden value="<?php echo $jmbg ?>">
    <?php $pageMinusOne = $page - 1; if($pageMinusOne < 1) $pageMinusOne = 1 ?>
    <input type="text" name="page" hidden value="<?php echo $pageMinusOne ?>">
    <button type="submit" name="filter_client" class="btn btn-outline-primary"><</button>
  </form>
  <?php
    if ($numOfTotalPages <= 5) {
      for ($i = 1; $i <= $numOfTotalPages; $i++) {
        if($i != $page){
          echo '<form action="./clientTable.php" method="POST" class="page-form-height">
          <input type="text" name="ime" hidden value="' . $ime . '">
          <input type="text" name="prezime" hidden value="' . $prezime . '">
          <input type="text" name="jmbg" hidden value="' . $jmbg . '">
          <input type="text" name="page" hidden value="' . $i . '">
          <button type="submit" name="filter_client" class="btn btn-outline-primary">' . $i . '</button>
          </form>';
        } else {
          echo '<button type="button" name="filter_client" class="btn btn-primary" class="page-form-height">' . $i . '</button>';
        }
      }
    } else {
      $minPage = $page - 2;
      if($minPage < 1) $minPage = 1;
      $maxPage = $page + 2;
      if($maxPage > $numOfTotalPages) $maxPage = $numOfTotalPages;
      for ($i = $minPage; $i <= $maxPage; $i++) {
        if($page >= 4 && ($i == $minPage)) echo '<form action="./clientTable.php" method="POST" class="page-form-height">
        <input type="text" name="ime" hidden value="' . $ime . '">
        <input type="text" name="prezime" hidden value="' . $prezime . '">
        <input type="text" name="jmbg" hidden value="' . $jmbg . '">
        <input type="text" name="page" hidden value="' . 1 . '">
        <button type="submit" name="filter_client" class="btn btn-outline-primary">' . 1 . '</button>
        </form> <span class="dots">...</span>';
        
        if($i != $page){
          echo '<form action="./clientTable.php" method="POST" class="page-form-height">
          <input type="text" name="ime" hidden value="' . $ime . '">
          <input type="text" name="prezime" hidden value="' . $prezime . '">
          <input type="text" name="jmbg" hidden value="' . $jmbg . '">
          <input type="text" name="page" hidden value="' . $i . '">
          <button type="submit" name="filter_client" class="btn btn-outline-primary">' . $i . '</button>
          </form>';
        } else {
          echo '<button type="button" name="filter_client" class="btn btn-primary" class="page-form-height">' . $i . '</button>';
        }
        if($page <= $numOfTotalPages-3 && ($i == $maxPage)) echo '<span class="dots">...</span><form action="./clientTable.php" method="POST" class="page-form-height">
        <input type="text" name="ime" hidden value="' . $ime . '">
        <input type="text" name="prezime" hidden value="' . $prezime . '">
        <input type="text" name="jmbg" hidden value="' . $jmbg . '">
        <input type="text" name="page" hidden value="' . $numOfTotalPages . '">
        <button type="submit" name="filter_client" class="btn btn-outline-primary">' . $numOfTotalPages . '</button>
        </form>';
      }
    }
  ?>
  <form action="./clientTable.php" method="POST" class="page-form-height">
    <input type="text" name="ime" hidden value="<?php echo $ime ?>">
    <input type="text" name="prezime" hidden value="<?php echo $prezime ?>">
    <input type="text" name="jmbg" hidden value="<?php echo $jmbg ?>">
    <?php $pagePlusOne = $page + 1; if($pagePlusOne > $numOfTotalPages) $pagePlusOne = $numOfTotalPages ?>
    <input type="text" name="page" hidden value="<?php echo $pagePlusOne ?>">
    <button type="submit" name="filter_client" class="btn btn-outline-primary">></button>
  </form>
</div>






<script>
  function confirmDelete(ime, prezime) {
    var confirmation = confirm("Da li ste sigurni da želite obrisati korisnika:\n" + ime + " " + prezime);
    return confirmation;
  }
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>

<?php }else{
	// header("Location: ../index.php");
	header("Location: " . $_SESSION['lastValidUrl']);
} ?>