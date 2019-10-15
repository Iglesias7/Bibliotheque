<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Sign Up</title>
        <base href="<?= $web_root ?>"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="css/style_signup.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <div class="title">Enregistrer  vous Dans notre Base de données</div><br><br>
        <div class="menu">
            <a href="main/index">Login</a>
        </div>
        <div class="main">
            <form action="main/signup" method="post">
                <fieldset id = "autre">
                    <legend>Bien remplir les informations demandées</legend>
                    <table>
                        <tr>
                            <td>Nom(ceci est votre identifiant)(*):</td>
                            <td><input id="username" name="username" type="text" value="<?php echo $username; ?>"  ></td>
                        </tr>
                        <tr>
                            <td>Prenom(*):</td>
                            <td><input id="fullname" name="fullname" type="text" value="<?php echo $fullname; ?>" ></td>
                        </tr>
                        <tr>
                            <td>Date de Naissance:</td>
                            <td><input type = "date" id = "birthdate" name = "birthdate" value ="<?php echo $birthdate;  ?>" required></td>
                        </tr>
                        <tr>
                            <td>Email (ceci est votre identifiant)(*):</td>
                            <td><input type = "email" id = "email" name = "email" autocomplete = "on"  value ="<?php echo $email; ?>"  ></td>
                        </tr>
                        <tr>
                            <td>Password(*):</td>
                            <td><input id="password" name="password" type="password" value="<?php echo $password; ?>"  ></td>
                        </tr>
                        <tr>
                            <td>Confirm Password(*):</td>
                            <td><input id="password_confirm" name="password_confirm" type="password" value="<?php echo $password_confirm; ?>"  ></td>
                        </tr>
                    </table>
                    <input type = "submit" value = "Enregistrer">
                    <input type = "reset" value = "Annuler">
                </fieldset>
            </form>
            <?php if (count($errors) != 0): ?>
                <div class='errors'>
                    <br><br><p>Please correct the following error(s) :</p>
                    <ul>
                        <?php foreach ($errors as $error): ?>
                            <li><?= $error ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
        </div>
        <footer>
            <div>
		 <?php echo "<marquee scrollamount = '5'>Tous les champs doivent etre remplis.</marquee>"; ?>   
            </div>
        </footer>
    </body>
</html>