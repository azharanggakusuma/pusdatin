<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include '../config/conn.php';
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $password_enkripsi = sha1($password);
    $recaptcha_token = $_POST['recaptcha_token'];

    if (!empty($recaptcha_token)) {
        $url = 'https://www.google.com/recaptcha/api/siteverify';
        $data = [
            'secret' => '6LfUfaUqAAAAAA_6RPB8APiOKw_ovLr3yR8QeyTT',  // Replace with your secret key
            'response' => $recaptcha_token
        ];

        $options = [
            'http' => [
                'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                'method' => 'POST',
                'content' => http_build_query($data)
            ]
        ];

        $context = stream_context_create($options);
        $response = file_get_contents($url, false, $context);
        $result = json_decode($response);

        if (!$result->success) {
            header("Location: login.php?error=captcha");
            exit;
        }
    }

    $sql = "SELECT * FROM users WHERE username='$username' AND password='$password_enkripsi'";
    $query = mysqli_query($conn, $sql);
    if (mysqli_num_rows($query) > 0) {
        $data = mysqli_fetch_array($query);
        session_start();
        $_SESSION['username'] = $username;
        $_SESSION['idsesi'] = session_id();
        $_SESSION['level'] = $data['level'];
        $_SESSION['name'] = $data['name'];
        header("Location: login.php?success=true");
        exit();
    } else {
        header("Location: login.php?error=true");
        exit();
    }
}
?>
