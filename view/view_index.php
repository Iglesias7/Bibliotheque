
<!DOCTYPE html>
<html>
    <head>
        <title>Bienvenue Dans la BIBLIOPRALINE</title>
        <base href="<?= $web_root ?>"/>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="css/style.css" rel="stylesheet" type="text/css"/>
    </head>
    <body> 
        <img src = "image/ispral.jpg" width="120" height="120" style="padding-top: 15px;margin-left: 40px;">
        <div class="title">BIBLIOPRALINE</div>
        <div class="main">
            <form action="main/index" method="post">
                <table>
                    <tr>
                        <td><input id="username"  name = "username" type="text" value="<?php echo $username; ?>" placeholder = "Identifiant"></td>
                    </tr>
                    <tr> 
                        <td><input id="password" name="password" type="password" value="<?php echo $password; ?>" placeholder = "Mot de passe"></td>
                    </tr>
                    </tr>
                </table>
                <input type="submit" value="Connexion" style="background: navy; margin-left: 40px;">
        </form>
        <div class="menu">
            <a href="main/signup" style="color: navy;">Creer un nouveau Compte</a>
        </div>
        <?php if (count($errors) != 0): ?>
            <div class='errors'>
                <p>Please correct the following error(s) :</p>
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?= $error ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
    </body>
</html>
