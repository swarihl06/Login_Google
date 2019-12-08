<?php

    use Facebook\Facebook;

    require_once './vendor/autoload.php';

    if (!session_id())
    {
        session_start();
    }

    $facebook = new Facebook([
        'app_id' => '579476679453495',
        'app_secret' => '69f6cbe57975ad667d37e2c965b11294',
        'default_graph_version'  => 'v2.10'
    ]);

    $facebook_helper = $facebook->getRedirectLoginHelper();

?>