<?php
session_start();
require_once '';
if (isset($_POST['btnconnexion'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    try {
        //code...
        $stmt = $pdo->prepare("select *from users where username= :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id_user'];
            $_SESSION['username'] = $user['username'];

            header("location: main.html");
        }
    } catch (\Throwable $th) {
        //throw $th;
    }

    # code...
}
