<?php 
    // session start 
    session_start();

    // check if the user has submitted the form 
    if (isset($_POST['submit'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $_SESSION['username'] = $username;

        // include the database connection file
        require_once 'db_conn.php';

        $db = DBconnection::getInstance();
        $conn = $db->get();

        // retrieve the user data from the database
        $query = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $user = $stmt->rowCount();

        // check if the user exists in the database
        if (($user) == 1) {
            // store the username in the session
            $_SESSION['username'] = $username;
      
            // redirect to the dashboard
            header('location: dashboard.php');
          } else {
            // show an error message
            echo '<div style="color: red;">Incorrect username or or password</div>';
          }     
  }
  ?>

<form action="" method="post">
  <input type="text" name="username" placeholder="Username">
  </br>
  </br>
  <input type="password" name="password" placeholder="Password">
  <br>
  <br>
  <input type="submit" name="submit" value="Login">
  </br>
  </br>
  <a href="register.php">don't have an account, register here</a>
</form>