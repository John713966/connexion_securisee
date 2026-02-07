<?php
session_start();
require "connexion.php";

if (isset($_POST['btnconnect'])) {
    $username = ($_POST['username']);
    $password = ($_POST['password']);

    try {
        $stmt = $pdo->prepare("select *from users where username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $user = $stmt->fetch();
        if ($user && password_verify($password, $user['password'])) {
            session_regenerate_id(true);
            $_SESSION['id_user'] = $user['id_users'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['logged']= true;

            // Redirection vers la page d'accueil sécurisée
            header("Location: ../main.php");
            exit();
        } else {
            echo " username or password incorrect";
        }
    } catch (PDOException $e) {
        //throw $th;
        echo "ERROR" . $e->getMessage();
    }
}
