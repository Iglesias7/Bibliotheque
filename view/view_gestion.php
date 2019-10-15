<!DOCTYPE html>
<html>
    <head>
        <title>Mon panier</title>
        <base href="<?= $web_root ?>"/>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="css/style_panie.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <div class="title">
            Gestion des livres de la Bibliothèque
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
        <div id="panier">
            <br><br>
            <div class="colonn2">
                <div class="item">
                    <form action="rental/filersBookGestion/<?php echo $profile->username; ?>" method="post">
                        <fieldset id = "autre">
                            <legend>Filters</legend>
                            <table>
                                <tr>
                                    <td>Member:</td>
                                    <td><input name="username" type="text"></td>
                                </tr>
                                <tr>
                                    <td>Book:</td>
                                    <td><input name="book" type="text" ></td>
                                </tr>
                                <tr>
                                    <td>Rental Date:</td>
                                    <td><input type = "date"  name = "rentaldate"></td>
                                </tr>
                                <tr>
                                    <td>State:</td>                            
                                    <td>
                                        <input type="radio" name="autre"><label for="Open"> Open</label>
                                        <input type="radio" name="autre"><label for="Returned"> Returned</label>
                                        <input type="radio" name="autre"><label for="All"> All</label>
                                        <input style="margin-left: 30px;" type = "submit" value = "Apply Filter">
                                    </td>
                                </tr>
                            </table>
                        </fieldset>
                    </form>
                    
                    <form action="user/users" method="POST">  
                        <table>  
                            <tr style="background-color: darkblue; color: white;">
                                <td>Rental Date/Time</td>
                                <td>Member</td>
                                <td>Book</td>
                                <td>Return Date/Time</td>
                                <td>Actions</td>   
                            </tr>
                            <?php
                            if($rentals){
                                foreach ($rentals as $rental){
                                    static $a = 0;
                            ?>
                            <tr class = 'tr' <?php $a++; if($a % 2 == 0){ echo 'style="background-color: cornflowerblue; color: black;"';}else
                                        {echo 'style="background-color: white; color: black;"';}?>>
                                <td><?php echo $rental->rentaldate; ?></td>
                                <td><?php echo $rental->getUserName(); ?></td>
                                <td><?php echo $rental->getBook(); ?></td>
                                <td><?php echo $rental->returndate; ?></td>
                                <td class="action">
                                    <?php if ($profile->role === 'admin'): ?>
                                        <button <?php  if($a % 2 == 0){ echo 'style="background-color: cornflowerblue;"';}else
                                        {echo 'style="background-color: white"';}?>  type ="submit" value="<?php echo $rental->id;?>" name ="delete" formaction = "rental/deleteRental/<?= $rental->id ?>/<?php echo $profile->username; ?>" class="del">
                                            <img src="image/trash.png" alt="bas"/>
                                        </button>
                                    <?php endif; ?>
                                    <button <?php  if($a % 2 == 0){ echo 'style="background-color: cornflowerblue;"';}else
                                        {echo 'style="background-color: white;"';}?> type ="submit" formaction="rental/returnDate/<?= $rental->id ?>/<?php echo $profile->username; ?>" name ="droite" class="droite">
                                            <img src="image/droite.jpg" alt="droite"/>
                                    </button> 
                                </td>
                            </tr>
                            <?php 
                                    }
                                } 
                            ?>
                        </table>         
                    </form><br>    
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