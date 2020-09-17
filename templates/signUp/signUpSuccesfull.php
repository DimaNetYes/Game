<?php include __DIR__ . '/../header.php'; ?>

<div style="text-align: center;">
    <h1 style="font-size:24px;">Регистрация прошла успешно!</h1>
    Ссылка для активации вашей учетной записи отправлена вам на email.
</div>

<?php
//var_dump($user); //DELETE THIS
    echo '<script>setTimeout(\'location="https://simplename.pp.ua/mvcgame/www/users/main"\', 3000)</script>';
?>
<?php include __DIR__ . '/../footer.php'; ?>
