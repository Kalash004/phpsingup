
<?php
session_start();
if (empty($_POST["name"]) || empty($_POST["password"])) {
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
}

$name = $_POST["name"];
$password = $_POST["password"];

$credentials = loadCredentials("credentials.txt");
if ($credentials["name"] === $name && $credentials["password"] === $password) {
    $_SESSION["user"] = $name;
}
header('Location: welcome.php');


function loadCredentials($file)
{
    $handle = fopen($file, "r");
    if ($handle) {
        while (($line = fgets($handle)) !== false) {
            $data = explode(":", $line);
            if ($data[0] === "name") {
                $name = trim($data[1]);
            }
            elseif ($data[0] === "pass") {
                $pass = trim($data[1]);
            }
        }
        fclose($handle);
    }
    return [
        "name" => $name ?? null,
        "password" => $pass ?? null,
    ];
}
?>