<!DOCTYPE html>
<html>
    <head>
        <title>delete</title>
        <base href="<?= $web_root ?>"/>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="css/style_delete.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <div class="title">Suppression d'un Membre dans le systeme.
            <p><?php echo $profile->username ; ?>'s Profile!
                <?php 
                if($profile->role == 'admin')    
                    echo '(admin)'; 
                else if($profile->role == 'manager')    
                    echo '(manager)';
                if($profile->role == 'membre')    
                    echo '(membre)';
                ?>
            </p>
        </div><br><br>
        <div class="menu">
            <a href="user/Logout">Deconnexion</a>
        </div>
        <div class="main">
            <p class = "texte">Voulez vous vraiment supprimer  
            <?php
                  echo $postuser->fullname." ".$postuser->username." ?"; 
            ?>
            
            <form action="user/delete/<?php echo $postuser->id;?>" method="POST">
                <button class="oui"  type = "submit" name="delet" value="<?php echo $postuser->id;?>">Oui</button>
                <button class="non"  type = "submit" formaction ="user/users">Non</button>
            </form>
            </p>
        </div> 
    </body>
</html>
