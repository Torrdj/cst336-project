<?php
    session_start();

    if (!isset($db))
    {
        include 'connect.php';
        $connect = getDBConnection();
    }
    else
        $connect = $db;

    //Checking credentials in database
    $sql = "SELECT * FROM users
            WHERE username = :username
            AND password = :password";
    $stmt = $connect->prepare($sql);
    $data = array(":username" => $_POST['username'], ":password" => sha1($_POST['password']));
    $stmt->execute($data);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if(isset($user['username']))
    {
        $_SESSION['username'] = $user['username'];
        $_SESSION['type'] = $user['type'];
        $_SESSION['new_connection'] = true;
        header('Location: ../profile.php');
    }
    else
    {
        header('Location: ../login.php');
    }
?>