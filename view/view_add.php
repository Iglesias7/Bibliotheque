<!DOCTYPE html>
<html>
    <head>
        <title>Add User</title>
        <base href="<?= $web_root ?>"/>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="css/style_edit.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <?php ?>
        <div class="title"> 
            <h2>Ajouter un utilisateur</h2>
            <p><?php echo $profile->username; ?>'s Profile!</p>
        </div><br><br>
        <div class="menu">
            <a href="user/logout">Deconnection</a>
        </div>
        <div class="main">
            <form action="user/add" method="POST">
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
                            <td><select name="role"  <?= $profile->role === 'admin' ? '' : 'disabled  required' ?> id="role">
                                <option value = "admin" >Administrateur</option>
                                <option value = "manager" >Manager</option>
                                <option value = "member" >Member</option>
                                </select>
                            </td>
                        </tr>
                    </table>
                    <button class = "upd"  type = "submit" name="edituser" value="Save">Enregistrer</button>
                    <button class = "ann" type = "submit" value = "Annuler" formaction="user/users">Annuler</button>
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
