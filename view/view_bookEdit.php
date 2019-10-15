<!DOCTYPE html>
<html>
    <head>
        <title>Update Book</title>
        <base href="<?= $web_root ?>"/>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="css/style_editbook.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <?php ?>
        <div class="title"> 
            <h2>Modifier les données du livre <?php echo " '".$postuser->title."'"; ?></h2>
            <p><?php echo $profile->username; ?>'s Profile!</p>
        </div><br><br>
        <div class="menu">
            <a href="user/logout">Deconnection</a>
        </div>
        <div class="main">
            <form action="book/updBook/<?php echo $postuser->id; ?>/<?php echo $profile->username; ?>" method="POST" enctype='multipart/form-data'>
                <fieldset id = "autre">
                    <legend>Bien remplir les informations demandées</legend>
                    <table>
                        <tr>
                            <td>ISBN(*):</td>
                            <td><input id="isbn" name="isbn" type="text" value="<?php echo $postuser->isbn; ?>" required></td>
                        </tr>
                        <tr>
                            <td>Title(*):</td>
                            <td><input id="title" name="title" type="text" value="<?php echo $postuser->title; ?>" required></td>
                        </tr>
                        <tr>
                            <td>Author(*):</td>
                            <td><input type = "text" id = "author" name = "author" value ="<?php echo $postuser->author; ?>" required></td>
                        </tr>
                        <tr>
                            <td>Editor(*):</td>
                            <td><input type = "text" id = "editor" name = "editor" value ="<?php echo $postuser->editor; ?>" required></td>
                        </tr>
                        <tr>
                            <td>nbCopies(*):</td>
                            <td><input type = "number" id = "nbCopies" min="1" name = "nbCopies" value ="<?php echo $postuser->nbCopies; ?>" ></td>
                        </tr>
                        <tr>
                            <td>picture :</td>
                            <td>
                                <label for="image" class="label-file">Choisir une Photo de couverture</label>
                                <input id="image" class="input-file" type="file" value ="<?php echo $postuser->picture; ?>" name='image' accept="image/x-png, image/gif, image/jpeg">
                                <label for="clear" class="label-clear">Clear photo</label>
                                <button class="input-clear" type = "submit" id="clear" name='clear'>Clear</button>
                            </td>
                        </tr>
                    </table>
                    <p><img <?php if($postuser->picture == null) echo 'src="upload/book.jpg"'; ?> src='upload/<?php echo $postuser->picture ; ?>' width="300" height="200" style="margin-left: 200px;" alt="Profile image"></p>
                    
                    <button class = "upd"  type = "submit" name="save" value="Save">Enregistrer</button>
                    <button class = "ann" type = "submit" value = "Annuler" formaction="rental/addBookPanier/<?= $profile->username; ?>">Annuler</button>
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
		 <?php echo "<marquee scrollamount = '5'>Modification d'un livre. Vous pouvez également supprimé où modifier la première de couverturre de ce livre."
                 . "Cliquer sur 'Annuler' si vous vouler revenir en arrière.</marquee>"; ?>   
            </div>
        </footer>
    </body>
</html>
