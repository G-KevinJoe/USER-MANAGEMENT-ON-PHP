<?php
include 'db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $customer_name = $_POST['customer_name'];
    $password1 = $_POST['password'];

    $sql = $conn->prepare("SELECT password FROM customer_auth WHERE customer_name = ?");
    $sql->bind_param("s", $customer_name);
    $sql->execute();
    $sql->bind_result($password);
    $sql->fetch();
    $sql->close();

    if (password_verify($password1, $password)) {
        $_SESSION['customer_name'] = $customer_name;
        header("Location: home.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container d-flex align-items-center justify-content-center min-vh-100">
        <div class="card shadow-sm w-100" style="max-width: 420px;">
            <div class="card-body">
                <h2 class="card-title text-center mb-4">Login</h2>
                <form action="login.php" method="post">
                    <div class="mb-3">
                        <label for="customer_name" class="form-label">Customer Name</label>
                        <input type="text" class="form-control" id="customer_name" name="customer_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Submit</button>
                    <a href="register.php" class="btn btn-secondary w-100 mt-2">Register</a>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
