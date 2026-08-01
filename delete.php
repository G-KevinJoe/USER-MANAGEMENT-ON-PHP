<?php
include 'db.php';

if (isset($_GET["id"])) {
    $id = $_GET["id"];
    $sql = $conn->prepare("delete from emp where id=?");
    $sql->bind_param("i", $id);
    if ($sql->execute()) {
        header("Location: home.php");
        exit();
    }
}
?>
