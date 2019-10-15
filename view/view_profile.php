<!DOCTYPE html>
<html>
    <head>
        <title>Mon Profile</title>
        <base href="<?= $web_root ?>"/>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="css/style_profilee.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
       
        <div class="title">
            MERCI DE VISITER NOTRE BIBLIOTHEQUE
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
        </div><br><br><br>
        <div class="menu"> 
            <?php if($profile->role !== 'member'){
                       echo '<a href="user/users">Membres</a>'.' ';
                       echo '<a href="rental/gestionBook/'.$profile->username.'">Gestion</a>';
                    } 
            ?>
            <a href="rental/addBookPanier/<?= $profile->username ?>">Mon panier</a> 
            <a href="user/Logout">Deconnexion</a>
        </div>
        
        <div class="main">
            <p class = "texte"> Bienvenue 
            <?php  
                echo $profile->fullname." ".$profile->username." !";   
            ?>
            </p>
        </div>	
        
        <?php if(count($currently) !== 0){
            
        ?>
        <div class="colonn2">
            <h3>These are your currently rented books. Don't forget to return them in time !</h3>
            <table>  
                <tr style="background-color: darkblue; color: white;">
                    <td>Rentaldate</td>
                    <td>Book</td>
                    <td>To be returned on</td> 
                </tr>
                <?php
                if($currently){
                    foreach ($currently as $rental){
                        static $a = 0;
                ?>
                <tr class = 'tr' <?php $a++; if($a % 2 == 0){ echo 'style="background-color: cornflowerblue; color: black;"';}else
                            {echo 'style="background-color: white; color: black;"';}?>>
                    <td><?php echo $rental->rentaldate; ?></td>
                    <td><?php echo $rental->getBook(); ?></td>
                    <!--!== NULL && date('Y/m/d')-->
                    <td <?php if($rental->rentaldate !== NULL && date('Y-m-d',strtotime('1 month',strtotime($rental->rentaldate))) < date('Y-m-d')) echo "style = 'color: red;'"; ?>><?php echo date('Y-m-d H:i:s',strtotime('1 month',strtotime($rental->rentaldate))); ?></td>
                </tr>
                <?php 
                    }
                    } 
                ?>
            </table>         
        </div>
        <?php         
                            }   
        ?>
    </body>
</html>