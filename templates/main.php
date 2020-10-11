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
    <link rel="manifest" href="https://simplename.pp.ua/mvcgame/manifest.json">
    <link rel="apple-touch-icon" sizes="180x180" href="https://simplename.pp.ua/mvcgame/www/images/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="https://simplename.pp.ua/mvcgame/www/images/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="https://simplename.pp.ua/mvcgame/www/images/favicon-16x16.png">
    <!--    <link rel="manifest" href="/www/images/site.webmanifest">-->
    <link rel="mask-icon" href="https://simplename.pp.ua/mvcgame/www/images/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#fe5378">
    <meta name="theme-color" content="#ffffff">
    <meta name="enot" content="9051602162097C_arWnejLNBQy98JyTxwkQLt6umj0fMy" />
</head>
<body>

<?php if (!empty($error)): ?>
    <div style="background-color: red;padding: 5px;margin: 15px"><?= $error ?></div>
<?php endif; ?>

<?php if(!empty($user)): //Это контроль не зарегестрированных пользователей

$DataTime = new \Controllers\FastDigitController();

//Записываю всё время для нахождения места
foreach ($DataTime->findAllTime() as $key => $value){
    if($value->id != $user->getId()) { //Не считая прошлое время
        $timeAll[$key] = $value->time_id;
    }
}
//array_push($timeAll, $time); //Добавил текущее время
sort($timeAll);
$time = $DataTime->findTime($user->getId())->time_id;
if($time) {
    $pos = array_search($time, $timeAll) + 1;
}
?>
    <div class="content">
        <form action="/mvcgame/www/users/out" method="post">
            <input type="submit" class='out' value="Out">
        </form>
        <div class="info">
            <div class="place"><span>Place: #</span><?php echo $pos; ?></div>
            <div class="nickname"><?php echo $user->getLogin(); ?></div>
            <button class="play__button">Play</button>
            <div class="leaderbord">Leader Bord</div>
        </div>
    </div>
<?php
    else:
?>
    <div class="content">
<!--        <div class="login"></div>-->
<!--        <div class="regis"></div>-->
        <a href="/mvcgame/www/users/register">Login</a>
        <input type="text" placeholder="nickname" id="nickname"> <!-- Временный ник -->
        <button class="play__button">Play</button>
    </div>

<?php
    $MERCHANT_ID   = 5891;                 // ID магазина
    $SECRET_WORD   = 'Секретный ключ';   // Секретный ключ
    $ORDER_AMOUNT  = 10;                 // Сумма заказа
    $PAYMENT_ID    = time();             // ID заказа (мы используем time(), чтобы был всегда уникальный ID)

    $sign = md5($MERCHANT_ID.':'.$ORDER_AMOUNT.':'.$SECRET_WORD.':'.$PAYMENT_ID);  //Генерация ключа
?>

<form method='get' action='https://enot.io/pay' id="enot">
    <input type='hidden' name='m' value='<?=$MERCHANT_ID?>'>
    <input type='hidden' name='oa' value='<?=$ORDER_AMOUNT?>'>
    <input type='hidden' name='o' value='<?=$PAYMENT_ID?>'>
    <input type='hidden' name='s' value='<?=$sign?>'>
    <input type="submit" value="">
</form>

<?php
    endif;
?>

    <script>
        let btnPlay = document.getElementsByClassName("play__button")[0];
        btnPlay.addEventListener('click', function(){
            if(document.getElementById('nickname')) {
                let nickname = document.getElementById('nickname').value;
                location.href = "https://simplename.pp.ua/mvcgame/www/games/fastDigit?nickname=" + nickname;
            }else{
                location.href = "https://simplename.pp.ua/mvcgame/www/games/fastDigit";
            }

            // if(nickname){
            //     location.href = "http://mvcgame/www/games/fastDigit?nickname=" + nickname;
            // }else {
            //     location.href = "http://mvcgame/www/games/fastDigit";
            // }
        });
    </script>

<!--                        SERVICE WORKER-->
    <script>
    if ('serviceWorker' in navigator) {
        console.log('Navigator');
        window.addEventListener('load', function() {
            navigator.serviceWorker.register('https://simplename.pp.ua/mvcgame/service-worker.js').then(function(registration) {
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
<?php include __DIR__ . '/footer.php'; ?>