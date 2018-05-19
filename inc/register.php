<?php
    include 'connect.php';

    $db = getDBConnection();

    $username = $_POST['username'];
    $password = $_POST['password'];
    $type = "USER";

    $sql = "INSERT INTO users
    (username, password, type)
    SELECT username, password, type
    FROM (SELECT :username as username, :password as password,
    :type as type) t
    WHERE NOT EXISTS (SELECT * FROM users WHERE username = :username);";

    $statement = $db->prepare($sql);
    $statement->execute(array(
        ':username' => $username,
        ':password' => sha1($password),
        ':type' => $type));

    include 'checkUser.php';
?>