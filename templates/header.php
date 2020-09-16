<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://simplename.pp.ua/mvcgame/www/css/styles.css">
    <link rel="stylesheet" href="https://simplename.pp.ua/mvcgame/www/css/signUp.css">
    <link rel="stylesheet" href="https://simplename.pp.ua/mvcgame/www/css/main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<!--                ЭТО ДЛЯ ИКОНОК ТЕЛЕФОНА И PWA (manifest)-->
    <link rel="manifest" href="../../manifest.json">
    <link rel="apple-touch-icon" sizes="180x180" href="https://simplename.pp.ua/mvcgame/www/images/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="https://simplename.pp.ua/mvcgame/www/images/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="https://simplename.pp.ua/mvcgame/www/images/favicon-16x16.png">
<!--    <link rel="manifest" href="/www/images/site.webmanifest">-->
    <link rel="mask-icon" href="https://simplename.pp.ua/mvcgame/www/images/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#fe5378">
    <meta name="theme-color" content="#ffffff">
</head>
<body>
<script>
    if ('serviceWorker' in navigator) {
        console.log('Navigator');
        window.addEventListener('load', function() {
            navigator.serviceWorker.register('../../service-worker.js').then(function(registration) {
                // Registration was successful
                console.log('ServiceWorker registration successful with scope: ', registration.scope);
            }, function(err) {
                // registration failed :(
                console.log('ServiceWorker registration failed: ', err);
            }).catch(function(err) {
                console.log(err)
            });
        });
    } else {
        console.log('service worker is not supported');
    }
</script>