<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Logowania </title>
</head>
<style>
*{
    box-sizing: border-box;
    margin:0;
}
html{
    height:100%;
}
body{
    min-height:100%;
    height:100%;
}
header{
    width:100%;
    background-color: lightblue;
    vertical-align:middle; 
    
}
.hedLew{
    width:60%;
    display:inline-block;
    padding:5px;
}
.hedPraw{
    width:40%;
    display:inline-block;
    vertical-align:top;
    text-align:right;
    padding-right:10px;
    padding-top:10px;
}
.hedPraw p{
    font-size:17px;
    font-weight:bold;
}
.log{
    font-weight:bold;
    background-color:white;
    border:2px solid darkgrey;
    font-family:georgia;
}
nav{
    background-color:rgb(0, 102, 255);
}
.navButon{
    height:35px;
    background:rgba(95, 3, 175, 0.562);
    color:rgb(255, 255, 255);
    border: 2px solid rgba(0, 0, 0, .0);
    border-radius:10px;
    margin:5px 0px 3px 5px;
    font-size:15px;
    font-family:verdana;
}
.navButon:hover{
    border:2px solid Yellow;
    box-shadow:2px 2px 5px silver;
}
main{
    display: table;
    width:100%;
}
main div{
    display:table-cell;
    height:100%;
}
.lewy{
    width:60%;
    background-color:rgba(179, 255, 164, 0.788);
}
.lewy p{
    font-size:20px;
    margin-left:15px;
}
.lewy input, select{
    width:170px;
    margin-left:20px;
    margin-bottom:5px;
}
.lewy input[type='button']{
    width: 120px;
    text-align:center;
}
.prawy{
    width:40%;
    background-color: rgba(240, 164, 255, 0.767);
    padding:30px 5px 10px 5px;
    vertical-align:middle;
}
fieldset{
    border:none;
    width:400px;
    margin:auto;
    margin-top:10px;
    text-align:right;
}

footer{
    position:absolute;
    bottom:0px;
    height:30px;
    width:100%;
    background-color:rgba(93, 149, 223, 0.836);
    text-align:center;
    font-weight: bold;
    font-size:20px;
}
ul{
    margin-bottom:20px;
}
.OK{
    border:1px solid green;
    BOX-shadow: 1px 1px 5px GREEN;
}
.ERROR{
    border:1px solid red;
    BOX-shadow: 1px 1px 5px rgba(179, 255, 164, 0.788);
}
.visib{
    display: block;
}
.tabError, .ukryj{
    display: none;
}
.czysty_link{
    text-decoration: none;
    color:black;
}
</style>
<body>
<main>
<?php
define('serwer', 'localhost');
    define('user', "root");
    define('pass', '');
    $conn=mysqli_connect(serwer, user, pass);
    if(mysqli_connect_errno())
    {
    echo "Nie nawiązano połączenia";
    }
    else{
        echo "<header><div class='hedLew'><h1>Współdzielnia mieszkaniowa ''<span>Nasze Bloki</span>''</h1></div><div class='logOn hedPraw'></header><main><div class='lewy'>";
        mysqli_select_db($conn, 'wspoldzielnia');
    }
if(isset($_POST['log-in']))
{   $login=$_POST['log-in'];
    $kwerenda2="select login from konto where login='$login'";
    $wynik2=mysqli_query($conn, $kwerenda2);
    $wiersz2=mysqli_fetch_array($wynik2);
    if($wiersz2[0]==null)
    {
        echo "
        Podane konto nie istnieje!
        </div>";
    }
    else 
    {
        $kwerenda="select haslo from konto where login='$login'";
    $wynik=mysqli_query($conn, $kwerenda);
    $wiersz=mysqli_fetch_array($wynik);
    if($wiersz[0]==null)
    {
           echo "<meta http-equiv='refresh' content='0;url=zmiana_hasla.php?login=$login'>";
    }
    else{
        echo '<form method="POST" action="loguj.php" id="logForm" autocomplete="off">
					<fieldset>
						<legend><h3>LOGOWANIE</h3></legend>
						Login: <input type="text" size="10" id="log-in" name="log-in" required value="'.$login.'" class="OK"><br>
						Hasło:<input type="password" size="32" id="pass-in" name="pass-in" placeholder="Hasło">
						<input type="submit" id="btn2" value="Zaloguj">
					</fieldset>
				</form>
                <div id="tabError" class="tabError">
        <p id="errors"></p>
        </div></div>';
    }
}
}
else
{
   echo'<form method="POST" action="logowanie.php" id="logForm" autocomplete="off">
					<fieldset>
						<legend><h3>LOGOWANIE</h3></legend>
						Login: <input type="text" size="10" id="log-in" name="log-in" required placeholder="Login"><br>
						<input type="button" id="btn2" value="Zaloguj">
					</fieldset>
				</form>
                <div id="tabError" class="tabError">
        <p id="errors"></p>
        </div></div>';
}
mysqli_free_result($wynik);
mysqli_free_result($wynik2);
    mysqli_close($conn);
    ?>
    <div class='prawy'>
    <h3>Masz tutaj możliwosć:</h3><br>
    <ul><h3>
        <li>Zalogować się do swojego konta</li></h3>
</ul>
<h3> Podaj login, a następnie hasło.<br><br>Jeśli nie masz hasła, po wpisaniu loginu zostaniesz przekierowany do strony gdzie je ustawisz.</h3>
</div>
    </main>
    <footer>Kontakt z administracją, telefonicznie: 687 786 565 lub mailowo: administracja@NaszeBloki.pl</footer>
</body>
</html><script>
    function logValid()
    {
        let log=document.getElementById('log-in').value;
        let RegLog= new RegExp("^[A-ZŁŚĆŹŻŃĄĘ]{1}[a-złśźńćżąę]{2}[A-ZŁŚĆŹŻŃĄĘ]{1}[a-złśźńćżąę]{2}[0-9]{1,3}[ABC]{1}$");
        let wynikLog=RegLog.test(log);
        if(log=="admin"||wynikLog)
        {
            document.getElementById('tabError').classList.remove('pokaz');
            document.getElementById('tabError').classList.add('tabError');
            document.getElementById('log-in').classList.remove('ERROR');
            document.getElementById('log-in').classList.add('OK');
            let logForm=document.getElementById('logForm');
            logForm.submit();
        }
        else{
            document.getElementById('log-in').classList.remove('OK');
            document.getElementById('log-in').classList.add('ERROR');
            document.getElementById('tabError').classList.remove('tabError');
            document.getElementById('tabError').classList.add('pokaz');
            let errors=document.getElementById('errors');
            errors.innerHTML=("Niepoprawny login!<br>");
        } 
    }
    var log=document.getElementById('log-in');
    log.addEventListener('blur', logValid);
</script>