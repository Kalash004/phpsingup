<?php

include 'DBC.php';

if (empty($_POST["name"]) || empty($_POST["password"])) {
    header('Location: /');
    exit();
}

verifyUser($_POST["name"], $_POST["password"]);


function verifyUser($username, $password){
    $connection = DBC::getConnection();
    $statement = $connection->prepare("SELECT id, username, UserPass FROM users WHERE UserName = ?");
    $statement->bind_param("s", $username);
    $statement->execute();
    $result = $statement->get_result();
    if($result->num_rows > 0 && $statement->num_rows <= 1){
        $user = $result->fetch_all()[0];
        if(password_verify($password, $user[2])){
            $_SESSION["user_id"] = $user[0];
            $_SESSION["user_name"] = $user[1];
            header("Location: /");
            return;
        }
    }
    $_SESSION["error"] = "Invalid login";
    header("Location: /spatne");
}

function insertUser(): bool
{
    $username = "karel";
    $password = password_hash("ahoj123", PASSWORD_DEFAULT);

    $connection = DBC::getConnection();
    $statement = $connection->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    $statement->bind_param("ss", $username, $password);
    return $statement->execute();
}
