<?php
session_start();
require_once('db_conn.php');
$db = DBconnection::getInstance();
$conn = $db->get();
$username = $_SESSION['username'];

$sql = "SELECT firstname, lastname, username, email from userlist";
$stmt = $conn->prepare($sql);
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (isset($_POST['create'])) {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $sql = "INSERT INTO userlist (firstname, lastname, username, email) VALUES ('$firstname', '$lastname', '$username', '$email')";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    echo "Record created successfully.";
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crud</title>
</head>

<body>
    <h1>Dashboard</h1>
    <h2>Welcome <?php echo $username; ?></h2>
    <form method="POST">
        <input type="text" name="firstname" placeholder="Enter First Name">
        <br>
        <br>
        <input type="text" name="lastname" placeholder="Enter Last Name">
        <br>
        <br>
        <input type="text" name="username" placeholder="Enter Username">
        <br>
        <br>
        <input type="email" name="email" placeholder="Enter Email">
        <br>
        <br>
        <input type="submit" name="create" value="Add">
    </form>
    <br>
    <br>
    <form method="POST">
        <input type="text" name="search" placeholder="Search">
        <input type="submit" name="search" value="Search">
    </form>
    <br>
    <br>
    <table>
        <thead>
            <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Username</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user) { ?>
                <tr>
                    <td><?php echo $user['firstname']; ?></td>
                    <td><?php echo $user['lastname']; ?></td>
                    <td><?php echo $user['username']; ?></td>
                    <td><?php echo $user['email']; ?></td>
                    <td>
                        <button>Edit</button>
                    </td>
                </tr>
            <?php } ?>
        </tbody>





    </table>
    <a href="index.php">Logout</a>
</body>

</html>