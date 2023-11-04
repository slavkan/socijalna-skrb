<?php
session_start();
include "./db_conn.php";

if(isset($_POST['username']) && isset($_POST['password'])){
    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
      }
  
      $username = test_input($_POST['username']);
      $password = test_input($_POST['password']);
      $role = "admin";


      if(empty($username)){
        header("Location: ../index.php?error=Potrebno je korisničko ime");
      }else if(empty($password)){
        header("Location: ../index.php?error=Potrebna je šifra");
      }else{
        $password = md5($password);
        $sql = "SELECT * FROM user WHERE username='$username' AND pass='$password'";
        $result = mysqli_query($conn, $sql);

        if(mysqli_num_rows($result) === 1){
            $row = mysqli_fetch_assoc($result);
            if ($row['pass'] === $password){
                $_SESSION['user_id'] = $row['user_id'];
                $_SESSION['username'] = $row['username'];
                $_SESSION['userrole'] = $role;
                $_SESSION['lastValidUrl'] = $_SERVER['REQUEST_URI'];


                if($_SESSION['userrole'] == "admin") header("Location: ../admin/clientTable.php");
            } else header("Location: ../index.php?error=Incorect User name or password");
        } else header("Location: ../index.php?error=Incorect User name or password");
    }

}else{
    header("Location: ../index.php");
}

?>