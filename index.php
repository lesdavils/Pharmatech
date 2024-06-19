<?php
session_start();

if (isset($_SESSION['error_message'])) {
    $error_message = $_SESSION['error_message'];
    unset($_SESSION['error_message']);
} else {
    $error_message = null;
}

if (isset($_SESSION['logout_message'])) {
    $logout_message = $_SESSION['logout_message'];
    unset($_SESSION['logout_message']);
} else {
    $logout_message = null;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>PharmaTech</title>
    <link rel="stylesheet" type="text/css" href="slide navbar style.css">
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@500&display=swap" rel="stylesheet">
</head>
<body>
<div class="container">
    <div class="main">
        <input type="checkbox" id="chk" aria-hidden="true">

        <div class="signup">
            <form>
                <label for="chk" aria-hidden="true">Créer votre espace</label>
                <input type="text" name="txt" placeholder="Nom prénom" required="">
                <input type="email" name="email" placeholder="Email" required="">
                <input type="password" name="pswd" placeholder="Mot de passe" required="">
                <button>S'inscrire</button>
            </form>
        </div>

        <div class="login">
            <form method="post" action="login.php">
                <label for="chk" aria-hidden="true">Connexion</label>
                <input type="text" name="email" placeholder="Email" required="">
                <input type="password" name="password" placeholder="Mot de passe" required="">
                <button type="submit">Connectez-vous</button>
            </form>
            <?php
            if ($error_message) {
                echo '<p class="error-message">' . $error_message . '</p>';
            }
            if ($logout_message) {
                echo '<p class="logout-message">' . $logout_message . '</p>';
            }
            ?>
        </div>
    </div>
</div>
</body>
</html>
<style>
    body {
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        font-family: 'Jost', sans-serif;
        background: linear-gradient(to bottom, #84FB44, #5ea63f, #4CAF50);
    }

    .container {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .main {
        width: 350px;
        height: 550px;
        background: green;
        overflow: hidden;
        
        border-radius: 10px;
        box-shadow: 5px 20px 50px #000;
    }

    #chk {
        display: none;
    }

    .signup {
        position: relative;
        width: 100%;
        height: 100%;
    }

    label {
        color: #fff;
        font-size: 2.3em;
        justify-content: center;
        display: flex;
        margin: 50px;
        font-weight: bold;
        cursor: pointer;
        transition: .5s ease-in-out;
    }

    input {
        width: 60%;
        height: 10px;
        background: #e0dede;
        justify-content: center;
        display: flex;
        margin: 20px auto;
        padding: 12px;
        border: none;
        outline: none;
        border-radius: 5px;
    }

    button {
        width: 60%;
        height: 40px;
        margin: 10px auto;
        justify-content: center;
        display: block;
        color: #fff;
        background: #2F8900;
        font-size: 1em;
        font-weight: bold;
        margin-top: 30px;
        outline: none;
        border: none;
        border-radius: 5px;
        transition: .2s ease-in;
        cursor: pointer;
    }

    button:hover {
        background: #6d44b8;
    }

    .login {
        height: 460px;
        background: #eee;
        border-radius: 60% / 10%;
        transform: translateY(-180px);
        transition: .8s ease-in-out;
    }

    .login label {
        color: #573b8a;
        transform: scale(.6);
    }

    #chk:checked ~ .login {
        transform: translateY(-500px);
    }

    #chk:checked ~ .login label {
        transform: scale(1);
    }

    #chk:checked ~ .signup label {
        transform: scale(.6);
    }

    .error-message {
        color: red;
        text-align: center;
        margin-top: 20px;
    }

    .logout-message {
        color: green;
        text-align: center;
        margin-top: 20px;
    }
</style>
