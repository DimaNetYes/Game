<?php include __DIR__ . '/header.php'; ?>

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
    endif;
?>

    <script>
        let btnPlay = document.getElementsByClassName("play__button")[0];
        btnPlay.addEventListener('click', function(){
            if(document.getElementById('nickname')) {
                let nickname = document.getElementById('nickname').value;
                location.href = "http://simplename.pp.ua/mvcgame/www/games/fastDigit?nickname=" + nickname;
            }else{
                location.href = "http://simplename.pp.ua/mvcgame/www/games/fastDigit";
            }

            // if(nickname){
            //     location.href = "http://mvcgame/www/games/fastDigit?nickname=" + nickname;
            // }else {
            //     location.href = "http://mvcgame/www/games/fastDigit";
            // }
        });
    </script>

<?php include __DIR__ . '/footer.php'; ?>