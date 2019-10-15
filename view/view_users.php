<!DOCTYPE html>
<html>
    <head>
        <title>Users</title>
        <base href="<?= $web_root ?>"/>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="css/style_user.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <div class="title">
            Membres de la Bibliothèque
            <p><?php echo $profile->username; ?>'s Profile!
                <?php 
                if($profile->role === 'admin')    
                    echo '(admin)'; 
                else if($profile->role === 'manager')    
                    echo '(manager)';
                if($profile->role === 'member')    
                    echo '(membre)';
                ?>
            </p>
        </div><br><br>
        <div class="menu">
            <a href="user/profile">Mon profile</a>
            <a href="user/logout">Deconnection</a>
        </div>
        <div id="user">
            <div class="column1">

<!--             ********** ADD ********** 
                 ********** ADD ********** 
                 ********** ADD ********** -->
                <a class="plis" href="user/add">
                    <div class="add" >
                        <div ><p id="plus">+</p><p class="text">Ajouter un user</p></div>
                    </div><br><br>
                </a>

            </div>
        
            <div class="colonn2">
                <div class="h3"><p style="font-size: 20px;">Liste des membres enregistrer dans le systeme</p></div>
                <div class="item">
                    <form action="user/users" method="POST">  
                        <table>  
                            <tr style="background-color: darkblue; color: white;">
                                <td>Noms</td>
                                <td>Prenoms</td>
                                <td>Email</td>
                                <td>Birthdate</td>
                                <td>Role</td>
                                <td>Actions</td>   
                            </tr>
                            <?php
                                foreach ($users as $value){
                                    static $a = 0;
                            ?>
                            <tr class = 'tr' <?php $a++; if($a % 2 == 0){ echo 'style="background-color: cornflowerblue; color: black;"';}else
                                        {echo 'style="background-color: white; color: black;"';}?>>
                                <td><?php echo $value->username; ?></td>
                                <td><?php echo $value->fullname; ?></td>
                                <td><?php echo $value->email; ?></td>
                                <td><?php if($value->birthdate != NULL){date_default_timezone_set('UTC'); $tsp = strtotime($value->birthdate); $date = date('d/m/Y',$tsp); echo $date;}else{echo $value->birthdate;} ?></td>
                                <td><?php echo $value->role; ?></td>
                                <td class="action">
                                    <button <?php  if($a % 2 == 0){ echo 'style="background-color: cornflowerblue;"';}else
                                        {echo 'style="background-color: white;"';}?> type ="submit" formaction="user/upd/<?= $value->id ?>" name="edit" value="<?= $value->id ?>" class="edit">
                                        <img src="image/edit2.png" alt="edit"/>
                                    </button> 
                                    <?php if ($profile->role === 'admin' && $value->id !== $profile->id): ?>
                                        <button <?php  if($a % 2 == 0){ echo 'style="background-color: cornflowerblue;"';}else
                                        {echo 'style="background-color: white"';}?>  type ="submit" value="<?php echo $value->id;?>" name ="delete" formaction = "user/delete/<?= $value->id ?>" class="del">
                                            <img src="image/trash.png" alt="remove"/>
                                        </button>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php 
                                }
                            ?>
                        </table>         
                    </form>
                </div>
            </div>
        </div>

        
        <?php 
            if(isset($errors)){
                echo "<div class='errors'>
                      <br><br><p>Veuillez corriger les erreurs suivantes :</p>
                      <ul>";
                foreach($errors as $error){
                    echo "<li>".$error."</li>";
                }
                echo '</ul></div>';
            } 
        ?>    
        <footer>
            <div>
		 <?php echo "<marquee scrollamount = '5'>Vous devez etre Administrateur où Manager pour pouvoir effectuer une action dans cette page.</marquee>"; ?>   
            </div>
        </footer>
    </body>
</html>