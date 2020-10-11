<?php
    require_once "db.php";
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://simplename.pp.ua/mvcgame/www/css/newGame.css">
    <script src="https://simplename.pp.ua/mvcgame/www/js/newGame.js"></script>
    <script src="https://simplename.pp.ua/mvcgame/www/js/styleClasses__NewGame.js"></script>
    <script src="https://simplename.pp.ua/mvcgame/www/js/secundomer.js"></script>

<!--    ЭТО ДЛЯ ИКОНОК ТЕЛЕФОНА И PWA (manifest)-->
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

<div class="content">
    <a href="https://simplename.pp.ua/mvcgame/www/users/main" id="BackMain"></a>
    <div id="secundomer">
        <span id="s_minutes">00 : </span>
        <span id="s_seconds">00 : </span>
        <span id="s_ms">000</span>
    </div>

<!--            Зарегестрированный пользователь-->
    <?php if ($user): ?>
    <div id="info">
        <div class="nickname"><?php echo "<span class='signature'>Nickname: " . "<p> {$user->getLogin()} </p></span>" ?></div>
        <div class="time">
            <?php
                $DataTime = new \Controllers\FastDigitController();
                $UserTimeGame = ($DataTime->findTime($user->getId())) ?? $user;
            ?>
        </div>
        <div class="position"></div>
        <button id="repeat">Repeat</button>
        <form action="/mvcgame/www/users/main" method="post" > <!-- onsubmit="return positionSend()" -->
            <input type="hidden" name="position" value="">
            <input type=submit id="ok" value="ok">
        </form>
    </div>

<!--                Незарегестрированный подльзователь-->
    <?php
        else:
    ?>
            <div id="info">
                <div class="nickname"><?php echo "<span class='signature'>Nickname: " . "<p> {$_GET['nickname']} </p></span>" ?></div>
                <div class="time">
                    <?php
                        $DataTime = new \Controllers\FastDigitController();
//                        $UserTimeGame = ($DataTime->findTime($user->getId())) ?? $user;
                    ?>
                </div>
                <div class="position"></div>
                <button id="repeat">Repeat</button>
                <form action="/mvcgame/www/users/main" method="post" > <!-- onsubmit="return positionSend()" -->
                    <input type="hidden" name="position" value="">
                    <input type=submit id="ok" value="ok">
                </form>
            </div>

    <?php endif; ?>

</div>


<form action="" method="post">
    <input type="hidden" name="test">
</form>

<?php
        //Рабочая запись времени в time
if(isset($_POST['time']) && !empty($_POST['time'])){
    $time = explode(" ,",$_POST['time']);
    $time = implode(':', $time);
            //Процедурный стиль
//    $stm = $dbh->prepare('INSERT INTO time (`time`) VALUES (:time)');
//    $stm->bindValue('time', $time);
//    $stm->execute();
            //Обьектный стиль записи времени
    $DataTime = new \Controllers\FastDigitController();
    $DataTime->saveTime($time, substr($_COOKIE['token'], 0, strpos($_COOKIE['token'], ':')));
            //Записываю всё время для нахождения места
    foreach ($DataTime->findAllTime() as $key => $value){
        if(isset($UserTimeGame)){
            if($value->id != $UserTimeGame->getId()) { //Не считая прошлое время
                $timeAll[$key] = $value->time_id;
            }
        }else{
            $timeAll[$key] = $value->time_id;
        }
    }
    array_push($timeAll, $time); //Добавил текущее время
    sort($timeAll);
    $pos = array_search($time, $timeAll) + 1;
    echo "{'position' : $pos}"; //используется для AJAX
}
?>

<script>
    let cntGame = 6; //Количество цифр
    newGame(cntGame);
    styleClasses(cntGame);
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

</body>
</html>