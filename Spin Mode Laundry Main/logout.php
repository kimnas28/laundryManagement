<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);


if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    
    include('sql.php');
    
    if ($conn) {
        $username = mysqli_real_escape_string($conn, $username);
        $log_sql = "INSERT INTO user_logs (username, action) VALUES ('$username', 'logout')";
        mysqli_query($conn, $log_sql);
    }
}


$_SESSION = array();

if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(), 
        '', 
        time() - 42000,
        $params["path"], 
        $params["domain"], 
        $params["secure"], 
        $params["httponly"]
    );
}

session_destroy();


header('Content-Type: application/json');
echo json_encode(['status' => 'success', 'message' => 'logged out']);
exit();
?>