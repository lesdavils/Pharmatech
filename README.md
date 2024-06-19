# Pharmatech 
## L'index.php
### Partie PHP

```php
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
```
Démarrage de la session php avec 

```php
session_start()
```

### Cette partie permet d'avoir le message de connexion refusée et de déconnexion 

Cette partie permet de verifier si il y'a un message de connexion lors de la connexion a la session : 

```php
if (isset($_SESSION['error_message'])) {
    $error_message = $_SESSION['error_message'];
    unset($_SESSION['error_message']);
} else {
    $error_message = null;
}
```
Si aucun message d'erreur est stocké dans la session la variable : 

```php
$error_message
```
Est initalisée sur null

#### Pour le logout c'est pareil 

```php
if (isset($_SESSION['logout_message'])) {
    $logout_message = $_SESSION['logout_message'];
    unset($_SESSION['logout_message']);
} else {
    $logout_message = null;
}
```
### Ensuite pour afficher le message de non connexion ou alors de déconnection il intéroge les differentes variables (error-message ou logout-message) 

#### Pour la connexion refusée : 

```php
if ($error_message) {
                echo '<p class="error-message">' . $error_message . '</p>';
    }
```

#### Pour la déconnexion : 

```php
if ($logout_message) {
                echo '<p class="logout-message">' . $logout_message . '</p>';
    }
```



### Ensuite il ya les balises HTML et les règles CSS

Comme par exemple 
```css
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
```
#### Qui définit des règles pour la partie Login

## Le login.php

#### Ce code permet de gérer les connexions utilisateur de manière simple en vérifiant les identifiants et en utilisant des redirections pour naviguer entre les pages en fonction du résultat de la vérification.

```php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    if ($email == "admin" && $password == "admin") {
        $_SESSION['username'] = "admin";
        header("Location: accueil.php");
        exit();
    } else {
        $_SESSION['error_message'] = "Le nom d'utilisateur ou le mot de passe est incorrect.";
        header("Location: index.php");
        exit();
    }
}
?>
```
Request des données envoyés via le formulaire POST pour l'email et le password.
```php
if ($_SERVER["REQUEST_METHOD"] == "POST") 
$email = $_POST['email'];
$password = $_POST['password'];
```
"La variable ``$email`` par exemple permet de stocker la valeur envoyée par l'utilisateur par le biais du formulaire." 

"``$_POST`` est un tableau qui contient differentes données envoyés par la méthode POST"

##### Cette opération est essentielle pour traiter les données entrés dans les formulaires web.

Ensuite cette partie permet de comparer les données assignés au variables ``$email`` et ``$password`` du tableau ``$_POST`` :

```php
if ($email == "admin" && $password == "admin") 
```
#### Afin de vérifier si le "l'email" et le "mot de passe" sont correct. 
 
### - Si cela est respecté alors :
```php
$_SESSION['username'] = "admin"; :
```
Alors le nom d'utilisateur est stocké afin de permettre de garder l'utilisateur connecté.    

On est alors redirigé vers l'acceuil du site 
```php
header("Location: accueil.php");
``` 
(le ``header`` envoie un en-tête HTTP de redirection)
```php
exit();
```
Qui arrête l'exécution du script




### - Sinon : "else {"

On stocke dans le message d'erreur de connexion 

``['error_message']`` est la clé utilisée pour accéder à une valeur spécifique dans le tableau $_SESSION.

On stocke alors l'erreur dans ``error-message`` qui permettera d'afficher que la connexion (mot de passe ou utilisateur incorrect) sur la page login. 

Puis l'utilisateur est dedirigé sur la page ``index.php`` qui réaffiche alors le formulaire de connexion. 


```php
header("Location: index.php");
```

```php
exit();
```
Qui arrête l'exécution du script




