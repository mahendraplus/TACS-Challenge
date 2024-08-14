<?php

$MY_HIGH_SECURITY_PASSWORD = "jnvCTF{Welcome_to_TACW_Team}";
$ERROR_STR = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    $inputPassword = isset($_POST["password"]) ? $_POST["password"] : "";

    if ($inputPassword === $MY_HIGH_SECURITY_PASSWORD) {
        $ERROR_STR = "Great! Welcome to TA-CW Team";
    } else {
        $ERROR_STR = "Invalid password!";
    }
} 


if (isset($_GET["route"])) {

    $file = "./pages/" . $_GET["route"];
    // Sanitize the file path to prevent directory traversal attacks
    // $file = basename($file); //ADDING LFI VULNERABILITY

    if (file_exists($file) && is_readable($file)) {
        if(strpos($file, '.html')){
            header("Content-Type: text/html");
        }else{
            header("Content-Type: text/plain");
        }
        $content = file_get_contents($file);
        if($ERROR_STR !== ""){
            $content = str_replace("d-none", "", $content);
            $content = str_replace("{{ERROR_STR}}", $ERROR_STR, $content);
        }

        echo $content;
    } else {
        http_response_code(404);
        header("Content-Type: text/plain");
        echo "Route not found!";
    }

} else {
    header("Content-Type: text/html");
    $content =  file_get_contents("./pages/home.html");

    if($ERROR_STR !== ""){
        $content = str_replace("d-none", "", $content);
        $content = str_replace("{{ERROR_STR}}", $ERROR_STR, $content);
    }

    echo $content;

}

?>