<?php
session_start();
require_once('db_conn.php');
$db = DBconnection::getInstance();
$conn = $db->get();
$username = $_SESSION['username'];

// table display
$sql = "SELECT id, firstname, lastname, username, email from userslist";
$stmt = $conn->prepare($sql);
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

// add crud
if (isset($_POST['create'])) {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $sql = "INSERT INTO userslist (firstname, lastname, username, email) VALUES ('$firstname', '$lastname', '$username', '$email')";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    header("Location: dashboard.php");
    echo "Record created successfully.";

    exit;
}

// delete crud
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];

    // Prepare and execute the DELETE statement
    $stmt = $conn->prepare("DELETE FROM userslist WHERE id = :delete_id");
    $stmt->bindParam(':delete_id', $delete_id);
    $stmt->execute();

    header("Location: dashboard.php");
    exit;
}

// search with php
if (isset($_POST['search_query'])) {
    $search_query = $_POST['search_query'];

    $sql = "SELECT id, firstname, lastname, username, email from userslist WHERE firstname LIKE '%$search_query%' OR lastname LIKE '%$search_query%' OR username LIKE '%$search_query%' OR email LIKE '%$search_query%'";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
    <form method="post">
        <input type="text" name="search_query" placeholder="Search">
        <input type="submit" name="search" value="Search">
    </form method="post">
    <br>
    <table>
        <thead>
            <tr>
                <th>#</th>
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
                    <td><?php echo $user['id']; ?></td>
                    <td><?php echo $user['firstname']; ?></td>
                    <td><?php echo $user['lastname']; ?></td>
                    <td><?php echo $user['username']; ?></td>
                    <td><?php echo $user['email']; ?></td>
                    <td>
                        <a href="dashboard.php?delete_id=<?php echo $user['id']; ?>">Delete</a>
                        <a href="edit.php">Edit</a>
                    </td>

                </tr>
            <?php } ?>
        </tbody>
    </table>
    <a href="index.php">Logout</a>
</body>

</html>