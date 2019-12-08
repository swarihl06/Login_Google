<?php

//index.php

include('./config.php');

$facebook_output = '';

if (isset($_GET['code'])) {
    if (isset($_SESSION['access_token'])) {
        $access_token = $_SESSION['access_token'];
    } else {
        $access_token = $facebook_helper->getAccessToken();

        $_SESSION['access_token'] = $access_token;

        $facebook->setDefaultAccessToken($_SESSION['access_token']);
    }

    $_SESSION['user_id'] = '';
    $_SESSION['user_name'] = '';
    $_SESSION['user_email_address'] = '';
    $_SESSION['user_image'] = '';
    $_SESSION['user_birthday'] = '';

    $graph_response = $facebook->get("/me?fields=name,email,birthday,gender,location", $access_token);

    $userData = $graph_response->getGraphNode()->asArray();

    $_SESSION['userData'] = $userData;

    $_SESSION['access_token'] = (string) $access_token;

    //  $facebook_user_info = $graph_response->getGraphUser();

    if (!empty($_SESSION['userData']['id'])) {
        $_SESSION['user_image'] = 'http://graph.facebook.com/' . $_SESSION['userData']['id'] . '/picture';
    }

    //  if(!empty($facebook_user_info['name']))
    //  {
    //   $_SESSION['user_name'] = $facebook_user_info['name'];
    //  }

    //  if(!empty($facebook_user_info['email']))
    //  {
    //   $_SESSION['user_email_address'] = $facebook_user_info['email'];
    //  }

    //  if(!empty($facebook_node_infor['birthday']))
    //  {
    //   $_SESSION['user_birthday'] = $facebook_node_infor['birthday'];
    //  }

} else {
    // Get login url
    $facebook_permissions = ['email']; // Optional permissions

    $url = 'http://localhost:8080/php/OOP/Login_Facebook/';

    $facebook_login_url = $facebook_helper->getLoginUrl($url, $facebook_permissions);

    // Render Facebook login button
    $facebook_login_url = '<div align="center"><a href="' . $facebook_login_url . '"><img src="" />Login With FaceBook</a></div>';
}

?>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>PHP Login using Google Account</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1' name='viewport' />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" />

</head>

<body>
    <div class="container">
        <br />
        <h2 align="center">PHP Login using Google Account</h2>
        <br />
        <div class="panel panel-default">
            <?php
            if (isset($facebook_login_url)) {
                echo $facebook_login_url;
            } else {
                echo '<div class="panel-heading">Welcome User</div><div class="panel-body">';
                echo '<img src="' . $_SESSION["user_image"] . '" class="img-responsive img-circle img-thumbnail" />';
                echo '<h3><b>Name :</b> ' . $_SESSION['userData']['name'] . '</h3>';
                echo '<h3><b>Gender :</b> ' . $_SESSION['userData']['gender'] . '</h3>';
                echo '<h3><b>Location :</b> ' . $_SESSION['userData']['location']['name'] . '</h3>';
                echo '<h3><b>BirthDay :</b> ' . date_format($_SESSION['userData']['birthday'], "d/m/Y") . '</h3>';
                echo '<h3><b>Email :</b> ' . $_SESSION['userData']['email'] . '</h3>';
                echo '<h3><a href="logout.php">Logout</h3></div>';
            }
            ?>
        </div>
    </div>
</body>

</html>