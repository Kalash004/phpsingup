<?php
include 'DBC.php';
if (empty($_POST["name"]) || empty($_POST["password"])) {
    header('Location: /');
    exit();
}

if(!verifyUser($_POST["name"], $_POST["password"])) {
    insertUser($_POST["name"], $_POST["password"]);
}

// returns true if user exists
function verifyUser($username, $password){
    $connection = DBC::getConnection();
    $statement = $connection->prepare("SELECT UserName, UserPass FROM user WHERE UserName = ?");
    $statement->bind_param("s", $username);
    $statement->execute();
    $result = $statement->get_result();
    if($result->num_rows > 0 && $statement->num_rows <= 1){
        $user = $result->fetch_all()[0];
        if(password_verify($password, $user[2])){
            return true;
        }
    } else {
        return false;
    }
}

function insertUser($username, $password): bool
{
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $userid = password_hash($hashed_password,PASSWORD_DEFAULT);
    $connection = DBC::getConnection();
    $statement = $connection->prepare("INSERT INTO user (UserID ,UserName, UserPass) VALUES (?, ?, ?)");
    $statement->bind_param("iss",$userid ,$username, $hashed_password);
    return $statement->execute();
}
?>