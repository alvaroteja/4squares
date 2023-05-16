<form action="./controller/productInfoController.php" method="post">
    <textarea name="review" id="" cols="30" rows="10" maxlength="1000"></textarea>
    <input class="button1" type="submit" value="Enviar" />
    <input type="hidden" name="id_product" value="<?php echo $productId ?>">
    <input type="hidden" name="id_user" value="<?php echo $_SESSION['user']->getId_user() ?>">
    <input type="hidden" name="writeComment" value="true">
</form>