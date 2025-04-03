
<div id="categories">
        
        <?php foreach($categories as $categoria) {?>
            <div id = "categoria">
            <a href="javascript:void(0);" onclick="fetchllistaProductes(<?php echo $categoria['id']?>)" >
                <div id=nomCat>    
                    <?php echo $categoria['nom']?>
                </div>
                <img src="<?php echo $categoria['imgpath']?>">
                <?php echo $categoria['descripcioc']?>
            </div>
            </a>

        <?php } ?>
    </div>
