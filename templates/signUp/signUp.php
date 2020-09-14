<?php include __DIR__ . '/../header.php'; ?>

<?php if (!empty($error)): ?>   <!--ERROR EXCEPTION-->
    <div class="dialogWindow"><?= $error ?></div>
<?php endif; ?>

<div class="container">
    <div class="card"></div>
    <div class="card">
        <h1 class="title">Login</h1>
        <form action="/mvcgame/www/users/login" method="post">
            <div class="input-container">
                <input type="text" id="email" name="email" value="<?= $_POST['email'] ?? '' ?>" required="required"/>
                <label for="email">Email</label>
                <div class="bar"></div>
            </div>
            <div class="input-container">
                <input type="password" id="Password" name="password" value="<?= $_POST['password'] ?? '' ?>" required="required"/>
                <label for="Password">Password</label>
                <div class="bar"></div>
            </div>
            <div class="button-container"><button><span>Go</span></button></div>
            <div class="footer"><a href="#">Forgot your password?</a></div>
        </form>
    </div>
    <div class="card alt">
        <div class="toggle fa fa-pencil"></div>
        <h1 class="title">Register
            <div class="close"></div>
        </h1>
        <form action="/mvcgame/www/users/register" method="post">
            <div class="input-container">
                <input type="text" id="login" name="login" value="<?= $_POST['login'] ?>" required="required" />
                <label for="login">Login</label>
                <div class="bar"></div>
            </div>
            <div class="input-container">
                <input type="email" id="email" name="email" value="<?= $_POST['email'] ?? '' ?>" required="required" />
                <label for="email">Email</label>
                <div class="bar"></div>
            </div>
            <div class="input-container">
                <input type="password" id="Password2" name="password" value="<?= $_POST['password'] ?>" required="required" />
                <label for="Password">Password</label>
                <div class="bar"></div>
            </div>
            <div class="input-container">
                <input type="password" id="RepeatPassword" name="passwordRepeat" value="<?= $_POST['RepeatPassword'] ?>" required="required" />
                <label for="RepeatPassword">Confirm password</label>
                <div class="bar"></div>
                <a href="#" class="password-control"></a>
            </div>

            <div class="button-container"><button class="registerBtn"><span>Next</span></button></div>
        </form>
    </div>
</div>

<script>
    $('.toggle').on('click', function() {
        $('.container').stop().addClass('active');
    });

    $('.close').on('click', function() {
        $('.container').stop().removeClass('active');
    });

            //SHOW/HIDE Password
    $('body').on('click', '.password-control', function(){
        console.log(this);
        if ($('#Password2').attr('type') == 'password'){
            $(this).addClass('view');
            $('#Password2').attr('type', 'text');
            $('#RepeatPassword').attr('type', 'text');
        } else {
            $(this).removeClass('view');
            $('#Password2').attr('type', 'password');
            $('#RepeatPassword').attr('type', 'password');
        }
        return false;
    });


        //Проверка паролей на совпадение form2 registration
    let registerBtn = document.getElementsByClassName('registerBtn')[0];
    let pass = document.getElementById('Password2');
    let passRepeat = document.getElementById('RepeatPassword');
    var dialogCheck; //One time append div

    registerBtn.addEventListener('click', function(){
        if(pass.value !== passRepeat.value){
            event.preventDefault();
                    //DIALOG WINDOW PASSWORD MISMATCH
            if(typeof(dialogCheck) == "undefined") {
                let div = document.createElement('div');
                div.innerHTML = "Password mismatch";
                // div.setAttribute('style', "background-color: red;padding: 5px; margin-top: 15px; margin-bottom: 15px;margin-left: auto;margin-right: auto;width: 75%; font-size: 20px; color: white; text-align: center;");
                div.classList.add("dialogWindow");
                document.body.prepend(div);
                dialogCheck = true; //One time append div
            }
        }
    });

</script>

<?php include __DIR__ . '/../footer.php'; ?>
