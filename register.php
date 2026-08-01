<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $customer_name = trim($_POST['customer_name'] ?? '');
    $password = $_POST['password'] ?? '';
    $email = trim($_POST['email'] ?? '');
    $phone_number = trim($_POST['phone_number'] ?? '');

    if ($customer_name !== '' && $password !== '') {
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO customer_auth (customer_name, password, email, phone_number) VALUES (?, ?, ?, ?)");

        if ($stmt) {
            $stmt->bind_param("ssss", $customer_name, $passwordHash, $email, $phone_number);
            $stmt->execute();
            header("Location: login.php");
            $stmt->close();
            exit();
            
        }
    }
}
?>
<!doctype html>
<html lang="en" data-bs-theme="light">
    <head>
        <title>Register</title>
        <!-- Required meta tags -->
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />

        <!-- Bootstrap CSS v5.3.8 -->
        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB"
            crossorigin="anonymous"
        />
    </head>
    <body>
        <header class="container py-4">
            <h1>Register</h1>
        </header>
        <main class="container">
            <form action="register.php" method="post">
                <div class="mb-3">
                    <label for="customer_name" class="form-label">Name</label>
                    <input id="customer_name" type="text" name="customer_name" class="form-control" value="<?php echo htmlspecialchars($_POST['customer_name'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input id="password" type="password" name="password" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input id="email" type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($_POST['email'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                </div>
                <div class="mb-3">
                    <label for="phone_number" class="form-label">Phone Number</label>
                    <input id="phone_number" type="text" name="phone_number" class="form-control" value="<?php echo htmlspecialchars($_POST['phone_number'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                </div>
                <button type="submit" href="login.php" class="btn btn-secondary">Login</button>
            </form>
        </main>
        <footer class="container py-4">
            <!-- place footer here -->
        </footer>
        <!-- Bootstrap JavaScript Bundle (includes Popper) -->
        <script
            src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
            crossorigin="anonymous"
        ></script>
    </body>
</html>
