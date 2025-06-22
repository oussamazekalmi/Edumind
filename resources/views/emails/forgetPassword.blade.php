
<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Activation de compte</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;1,200..1000&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="{{ asset('img/phase_two.png') }}" type="image/x-icon">
    <style>
    /* Ajouter des styles personnalisés */
    .container {
        font-family: Nunito, 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        font-size: 16px;
        max-width: 50%;
        margin: auto;
        color: #333;
        padding: 20px 16px;
        background-color: #fff;
        cursor: default;
    }
    a.btn {
        display: block;
        width: fit-content;
        margin: 30px auto;
        cursor: pointer;
        background-color: #6F8FAF;
        color: #fff;
        padding: 12px 12px;
        border-radius: 3px;
        text-decoration: none;
    }
    a.btn:hover {
        background-color: #7D99B3;
    }
    h2 {
        color: #6F8FAF;
        font-weight: 500;
        margin: 25px auto;
    }
    hr {
        border: 0.0.1cm solid #6F8FAF;
    }
    .support {
        color: #333;
        cursor: pointer;
        text-decoration: none;
    }
    .support:hover {
        color: #8FA9C0;
    }
    img {
        width: 26%;
        position: relative;
    }
    .hr {
        width: 100%;
        height: 3px;
        background-color: #6F8FAF;
    }
</style>

</head>
<body>
    <div class="container text-center pt-3 pb-1">
        <header class="d-flex justify-content-start p-0">
            <img src="https://i.pinimg.com/736x/3c/80/44/3c80446b2a263cf9b3e222b529f7ef48.jpg" alt="Logo">
        </header>
        <div class="hr"></div>
        <h2>Réinitialisation de votre mot de passe</h2>
        <p>Nous avons reçu une demande de réinitialisation de votre mot de passe pour votre compte</p>
        <p>Pour réinitialiser votre mot de passe, veuillez cliquer sur le bouton ci-dessous :</p>
        <a href="{{ $forgetPassword }}" class="btn">Réinitialiser votre mot de passe</a>
        <p>Si vous n'avez pas demandé de réinitialisation de mot de passe, vous pouvez ignorer cet email en toute sécurité.</p>
        <span>Nous vous remercions,<br> L'équipe de l'École Rihab Al Marjan.</span>
        <footer>
            <hr  />
            <p>Pour toute assistance, veuillez nous contacter à <a class="support" href="mailto:oussama.zekalmi.ma@gmail.com">oussama.zekalmi.ma@gmail.com</a></p>
        </footer>
    </div>
</body>
</html>
