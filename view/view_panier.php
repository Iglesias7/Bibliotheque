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
            Mon Panier
            <p><?php echo $profileConnect->username; ?>'s Profile!
                <?php 
                if($profileConnect->role === 'admin')    
                    echo '(admin)'; 
                else if($profileConnect->role === 'manager')    
                    echo '(manager)';
                if($profileConnect->role === 'member')    
                    echo '(membre)';
                ?>
            </p>
        </div><br><br>
        <div class="menu">
            <a href="user/profile">Mon profile</a>
            <a href="user/logout">Deconnection</a>
        </div>
        <div id = "panier">
            <br><br><form class="form" action="rental/filersBooks/<?php echo $profile->username; ?>" method="POST">
                <fieldset id = "autre">
                    <legend>Filter</legend>
                    <table>
                        <tr>
                            <td>Text filter:</td>
                            <td><input type="text" placeholder="Tapez votre recherche" name="book" />
                                <button class = "upd"  type = "submit">Apply filter</button>
                            </td>
                        </tr>
                    </table> 
                </fieldset>
            </form>
        
            <div class="colonn2">
                <div class="item">
                    <form action="user/users" method="POST">  
                        <table>  
                            <tr style="background-color: darkblue; color: white;">
                                <td>ISBN</td>
                                <td>Title</td>
                                <td>Author</td>
                                <td>Editor</td>
                                <td>nbCopies</td>
                                <td>Actions</td>   
                            </tr>
                            <?php
                                foreach ($books as $value){
//                                    foreach ($val as $key =>$value){
                                    static $a = 0;
                            ?>
                            <tr class = 'tr' <?php $a++; if($a % 2 == 0){ echo 'style="background-color: cornflowerblue; color: black;"';}else
                                        {echo 'style="background-color: white; color: black;"';}?>>
                                <td><?php echo $value->isbn; ?></td>
                                <td><?php echo $value->title; ?></td>
                                <td><?php echo $value->author; ?></td>
                                <td><?php echo $value->editor; ?></td>
                                <td><?php echo $value->nbCopies; ?></td>
                                <td class="action">
                                    <?php if ($profileConnect->role === 'admin'): ?>
                                        <button <?php  if($a % 2 == 0){ echo 'style="background-color: cornflowerblue;"';}else
                                        {echo 'style="background-color: white"';}?>  type ="submit" value="<?php echo $value->id;?>" name ="edit" formaction = "book/updBook/<?= $value->id ?>/<?php echo $profile->username; ?>" class="edit">
                                            <img src="image/edit2.png" alt="bas"/>
                                        </button>
                                        <button <?php  if($a % 2 == 0){ echo 'style="background-color: cornflowerblue;"';}else
                                        {echo 'style="background-color: white"';}?>  type ="submit" value="<?php echo $value->id;?>" name ="delete" formaction = "book/deleteBook/<?= $value->id ?>/<?php echo $profile->username; ?>" class="del">
                                            <img src="image/trash.png" alt="bas"/>
                                        </button>
                                    <?php endif; ?>
                                    <?php if ($profileConnect->role !== 'admin'): ?>
                                    <button <?php  if($a % 2 == 0){ echo 'style="background-color: cornflowerblue;"';}else
                                        {echo 'style="background-color: white;"';}?> type ="submit" formaction="book/showBook/<?= $value->id ?>"  name ="show" class="show">
                                        <img src="image/show.png" alt="show"/>
                                    </button> 
                                    <?php endif; ?>
                                    <button <?php  if($a % 2 == 0){ echo 'style="background-color: cornflowerblue;"';}else
                                    {echo 'style="background-color: white"';}?>  type ="submit" value="<?php echo $value->id;?>" name ="bas" formaction = "rental/addBookPanier/<?php echo $profile->username; ?>/<?= $value->id ?>" class="bas">
                                        <img src="image/ba.jpg" alt="bas"/>
                                    </button>
                                </td>
                            </tr>
                            <?php 
//                                    }
                                } 
                            ?>
                        </table>         
                    </form><br>
                    <?php if ($profileConnect->role === 'admin'): ?>
                   <!--  ********** ADD ********** 
                         ********** ADD ********** 
                         ********** ADD ********** -->
                   <form>
                        <div class="ajouter">
                            <button class="upd" formaction="book/addBook/<?php echo $profile->username; ?>" type = "submit">Ajouter un livre</button>
                        </div>
                    </form>
                    <?php endif; ?><br><br>
                    <h3 style="color: navy; font-style: italic; font-size: 30px">Basket of Books to rent</h3>
                    <form action="user/users" method="POST">  
                        <table>  
                            <tr style="background-color: darkblue; color: white;">
                                <td>ISBN</td>
                                <td>Title</td>
                                <td>Author</td>
                                <td>Editor</td>
                                <td>nbCopies</td>
                                <td>Actions</td>   
                            </tr>
                            <?php
                                foreach ($booksPanier as $value){
                                    static $a = 0;
                            ?>
                            <tr class = 'tr' <?php $a++; if($a % 2 == 0){ echo 'style="background-color: cornflowerblue; color: black;"';}else
                                        {echo 'style="background-color: white; color: black;"';}?>>
                                <td><?php echo $value->isbn; ?></td>
                                <td><?php echo $value->title; ?></td>
                                <td><?php echo $value->author; ?></td>
                                <td><?php echo $value->editor; ?></td>
                                <td><?php echo $value->nbCopies; ?></td>
                                <td class="action">
                                    <?php if ($profileConnect->role == 'admin'): ?>
                                        <button <?php  if($a % 2 == 0){ echo 'style="background-color: cornflowerblue;"';}else
                                        {echo 'style="background-color: white"';}?>  type ="submit" value="<?php echo $value->id;?>" name ="edit" formaction = "book/updBook/<?= $value->id ?>/<?php echo $profile->username; ?>" class="edit">
                                            <img src="image/edit2.png" alt="bas"/>
                                        </button>
                                        <button <?php  if($a % 2 === 0){ echo 'style="background-color: cornflowerblue;"';}else
                                        {echo 'style="background-color: white"';}?> type ="submit" value="<?php echo $value->id;?>" name ="delete" formaction = "book/deleteBook/<?= $value->id ?>/<?php echo $profile->username; ?>" class="del">
                                            <img src="image/trash.png" alt="bas"/>
                                        </button>
                                    <?php endif; ?>
                                    <?php if ($profileConnect->role !== 'admin'): ?>
                                    <button <?php  if($a % 2 == 0){ echo 'style="background-color: cornflowerblue;"';}else
                                        {echo 'style="background-color: white;"';}?> type ="submit" formaction="book/showBook/<?= $value->id ?>"  name ="show" class="show">
                                        <img src="image/show.png" alt="show"/>
                                    </button> 
                                    <?php endif; ?>
                                    <button <?php  if($a % 2 == 0){ echo 'style="background-color: cornflowerblue;"';}else
                                    {echo 'style="background-color: white"';}?>  type ="submit" value="<?php echo $value->id;?>" name ="top" formaction = "rental/removeBooksPanier/<?php echo $profile->username; ?>/<?= $value->id ?>" class="haut">
                                        <img src="image/hau.jpg" alt="bas"/>
                                    </button>
                                </td>
                            </tr>
                            <?php 
                                } 
                            ?>
                        </table>         
                    </form><br><br>
                    
        <!--             ********** confirm ********** 
                         ********** confirm ********** 
                         ********** confirm ********** -->
                    
                        <div class="confirm">
                            <form method="post" >
                                <?php if ($profileConnect->role !== 'member'): ?>
                                This Basket is for:
                                <select name="user">
                                <?php
                                foreach ($users as $value){
                                ?>
                                    <option value = "<?= $value->id ?>"  <?= $profile->id === $value->id  ? 'selected' : '' ?>>
                                    <?php echo $value->username."#".$value->id; ?>
                                    </option>
                                <?php 
                                    } 
                                ?>
                                </select>
                                <button class = "upd" formaction="rental/addBookPanier/<?php echo $profile->username; ?>" type = "submit" >Valider</button>
                                <?php endif; ?>
<!--                            </form>
                            <form method="post" >-->
                                <button class = "upd" formaction="rental/confirmPanier/<?php echo $profile->id; ?>" type = "submit" >Confirm Basket</button>
                                <button class="upd" formaction="rental/clear/<?php echo $profile->id; ?>" type = "submit"  >Clear Basket</button>
                            </form>
                        </div>
                    
                    
                </div>
            </div>
        </div>  
        <footer>
            <div>
		 <?php echo "<marquee scrollamount = '5'>Vous povez si vous voulez annuler votre .</marquee>"; ?>   
            </div>
        </footer>
        <?php 
            if(isset($errors)){
                foreach($errors as $error){
                    echo "<div class='errors'><ul><li>".$error."</li></ul></div>";
                }
            } 
        ?> 
    </body>
</html>
