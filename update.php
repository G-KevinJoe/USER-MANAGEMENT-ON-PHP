<?php
include 'db.php';

$id = $_GET["id"];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST["name"];
    $age = $_POST["age"];
    $email = $_POST["email"];
    $address = $_POST["address"];
    $salary = $_POST["salary"];
    $designation = $_POST["designation"];

    $sql = $conn->prepare("update emp set name=?, age=?, email=?, address=?, salary=?, designation=? where id=?");
    $sql->bind_param("sissdsi", $name, $age, $email, $address, $salary, $designation, $id);

    if ($sql->execute()) {
        header("Location: home.php");
        exit();
    }
}

$sql = $conn->prepare("select * from emp where id=?");
$sql->bind_param("i", $id);
$sql->execute();
$user = $sql->get_result()->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Employee</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container my-5">
    <h4 class="text-center mb-4">Update Employee</h4>
    <div class="container col-5 border rounded shadow p-4">
        <form action="" method="POST">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($user['name']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="age" class="form-label">Age</label>
                <input type="number" class="form-control" id="age" name="age" value="<?= htmlspecialchars($user['age']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>">
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <input type="text" class="form-control" id="address" name="address" value="<?= htmlspecialchars($user['address']) ?>">
            </div>
            <div class="mb-3">
                <label for="salary" class="form-label">Salary</label>
                <input type="number" step="0.01" class="form-control" id="salary" name="salary" value="<?= htmlspecialchars($user['salary']) ?>">
            </div>
            <div class="mb-3">
                <label for="designation" class="form-label">Designation</label>
                <input type="text" class="form-control" id="designation" name="designation" value="<?= htmlspecialchars($user['designation']) ?>">
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="home.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
</body>
</html>
