<?php
include 'db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST["name"];
    $age = $_POST["age"];
    $email = $_POST["email"];
    $address = $_POST["address"];
    $salary = $_POST["salary"];
    $designation = $_POST["designation"];

    $sql = $conn->prepare("insert into emp(name, age, email, address, salary, designation) values (?,?,?,?,?,?)");
    $sql->bind_param("sissds", $name, $age, $email, $address, $salary, $designation);

    if ($sql->execute()) {
        header("Location: home.php");
        exit();
    }
}

$result = $conn->query("select * from emp");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Amazon</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Amazon</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu" aria-controls="navMenu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navMenu">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link active" href="home.php">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container my-5">
    <header class="mb-4">
        <h1 class="display-6">Welcome to Amazon</h1>
        <p class="lead">Hello, <?php echo htmlspecialchars($_SESSION['customer_name'] ?? 'Guest'); ?>!</p>
        <?php
        $customer_name = $_SESSION['customer_name'] ?? '';
        if ($customer_name !== '') {
            $stmt = $conn->prepare("SELECT email, phone_number FROM customer_auth WHERE customer_name = ?");
            $stmt->bind_param("s", $customer_name);
            $stmt->execute();
            $stmt->bind_result($email, $phone_number);
            $stmt->fetch();
            $stmt->close();
            echo "<p>Email: " . htmlspecialchars($email ?? 'Not provided') . "</p>";
            echo "<p>Phone Number: " . htmlspecialchars($phone_number ?? 'Not provided') . "</p>";
        }
        ?>
    </header>

    <h4 class="mb-3">Add Employee</h4>
    <div class="border rounded shadow-sm p-4 mb-5">
        <form action="home.php" method="POST">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="age" class="form-label">Age</label>
                <input type="number" class="form-control" id="age" name="age" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email">
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <input type="text" class="form-control" id="address" name="address">
            </div>
            <div class="mb-3">
                <label for="salary" class="form-label">Salary</label>
                <input type="number" step="0.01" class="form-control" id="salary" name="salary">
            </div>
            <div class="mb-3">
                <label for="designation" class="form-label">Designation</label>
                <input type="text" class="form-control" id="designation" name="designation">
            </div>
            <button type="submit" class="btn btn-primary">Add Employee</button>
        </form>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="table-primary">
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Age</th>
                    <th>Email</th>
                    <th>Address</th>
                    <th>Salary</th>
                    <th>Designation</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?= htmlspecialchars($row["id"]) ?></td>
                    <td><?= htmlspecialchars($row["name"]) ?></td>
                    <td><?= htmlspecialchars($row["age"]) ?></td>
                    <td><?= htmlspecialchars($row["email"]) ?></td>
                    <td><?= htmlspecialchars($row["address"]) ?></td>
                    <td><?= htmlspecialchars($row["salary"]) ?></td>
                    <td><?= htmlspecialchars($row["designation"]) ?></td>
                    <td>
                        <a href="update.php?id=<?= $row["id"] ?>" class="btn btn-primary btn-sm">Update</a>
                        <a href="delete.php?id=<?= $row["id"] ?>" class="btn btn-danger btn-sm">Delete</a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
