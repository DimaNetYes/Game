<?php
setcookie("TestCookie", 123, time()+3600);
//setcookie("TestCookie", 123, time()-300);
print_r($_COOKIE);


?>
<!DOCTYPE html>
<html>
<style>
    table,th,td {
        border : 1px solid black;
        border-collapse: collapse;
    }
    th,td {
        padding: 5px;
    }
</style>
<body>

<h1>The XMLHttpRequest Object</h1>

<button type="button" onclick="loadDoc()">Get my CD collection</button>
<br><br>
<table id="demo"></table>



</body>
</html>

