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
            <h2>INFORMATIONS DU LIVRE</h2>
            <p><?php echo $profile->username; ?>'s Profile!</p>
        </div><br><br>
        <div class="menu">
            <a href="rental/addBookPanier/<?= $profile->username ?>">Mon panier</a>
            <a href="user/logout">Deconnection</a>
        </div>
        <div class="main">
            <form action="book/updBook/<?php echo $postuser->id; ?>/<?php echo $profile->username; ?>" method="POST" enctype='multipart/form-data'>
                <fieldset id = "autre">
                    <legend>Données du livre<?php echo " '".$postuser->title."'"; ?></legend>
                    <table>
                        <tr>
                            <td>ISBN(*):</td>
                            <td><input id="isbn" name="isbn" type="text" value="<?php echo $isbn; ?>" disabled></td>
                        </tr>
                        <tr>
                            <td>Title(*):</td>
                            <td><input id="title" name="title" type="text" value="<?php echo $title; ?>" disabled></td>
                        </tr>
                        <tr>
                            <td>Author(*):</td>
                            <td><input type = "text" id = "author" name = "author" value ="<?php echo $author; ?>" disabled></td>
                        </tr>
                        <tr>
                            <td>Editor(*):</td>
                            <td><input type = "text" id = "editor" name = "editor" value ="<?php echo $editor; ?>" disabled></td>
                        </tr>
                        <tr>
                            <td>nbCopies(*):</td>
                            <td><input type = "number" id = "nbCopies" min="1" name = "nbCopies" value ="<?php echo $nbCopies; ?>" disabled></td>
                        </tr>
                        <tr>
                            <td>picture :</td>
                        </tr>
                    </table>
                    <img <?php if($postuser->picture == null) echo 'src="upload/book.jpg"'; ?> src="upload/<?php echo $picture; ?>" style="margin-left: 200px;" alt="" height="200" width="300">
                </fieldset>
            </form>

        </div>
        <footer>
            <div>
		 <?php echo "<marquee scrollamount = '5'>DONNEES DU LIVRE EN LECTURE SEULE</marquee>"; ?>   
            </div>
        </footer>
    </body>
</html>
