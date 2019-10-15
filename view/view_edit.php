<!DOCTYPE html>
<html>
    <head>
        <title>upd User</title>
        <base href="<?= $web_root ?>"/>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="css/style_edit.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <?php ?>
        <div class="title">   
            <p><?php echo $profile->username; ?>'s Profile!</p>
        </div><br><br>
        <div class="menu">
            <a href="user/logout">Deconnection</a>
        </div>
        <div class="main">
            <form action="user/upd/<?= $postuser->id ?>" method="POST">
                <fieldset id = "autre">
                    <legend>Bien remplir les informations demandées</legend>
                    <table>
                        <tr>
                            <td>Nom(ceci est votre identifiant)(*):</td>
                            <td><input id="username" name="username" type="text" value="<?php echo $username; ?>" ></td>
                        </tr>
                        <tr>
                            <td>Prenom(*):</td>
                            <td><input id="fullname" name="fullname" type="text" value="<?php echo $fullname; ?>" ></td>
                        </tr>
                        <tr>
                            <td>Date de Naissance:</td>
                            <td><input type = "date" id = "birthdate" name = "birthdate" value ="<?php echo $birthdate; ?>" required></td>
                        </tr>
                        <tr>
                            <td>Email (ceci est votre identifiant)(*):</td>
                            <td><input type = "text" id = "email" name = "email" autocomplete = "on"  value ="<?php echo $email; ?>" ></td>
                        </tr>
                        <tr>
                            <td>Role(*):</td>
                            <td><select name="role"  <?= $profile->role === 'admin' ? '' : 'disabled' ?> id="role">
                                <option value = "admin" <?= $role === 'admin' ? 'selected' : '' ?>>Administrateur</option>
                                <option value = "manager" <?= $role === 'manager' ? 'selected' : '' ?>>Manager</option>
                                <option value = "member" <?= $role === 'member' ? 'selected' : '' ?>>Member</option>
                                </select>
                            </td>
                        </tr>
                    </table>
                    <button class = "upd"  type = "submit" name="edituser" >Enregistrer</button>
                    <button class = "ann" type = "submit" value = "Annuler" formaction="user/users">Annuler</button>
                </fieldset>
            </form>
            <?php if (count($errors) != 0): ?>
                <div class='errors'>
                    <br><br><p>Please correct the following error(s) :</p>
                    <ul>
                        <?php foreach ($profile->errors as $profile->error): ?>
                            <li><?= $error ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
        </div>
        <footer>
            <div>
		 <?php echo "<marquee scrollamount = '5'>Tous les champs doivent etre remplis.(VOUS POUVEZ EGALEMENT "
                 . "REINITIALISER VOTRE MOT DE PASSE.</marquee>"; ?>   
            </div>
        </footer>
    </body>
</html>
