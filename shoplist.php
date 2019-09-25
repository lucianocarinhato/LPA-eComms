<!DOCTYPE html>
<?php
  $authChk = true;
  require('app-lib.php');
  build_header($displayName);

  isset($_POST['a'])? $action = $_POST['a'] : $action = "";
  if(!$action) {
      isset($_REQUEST['a'])? $action = $_REQUEST['a'] : $action = "";
  }

  isset($_POST['sid'])? $sid = $_POST['sid'] : $sid = "";
  if(!$sid) {
      isset($_REQUEST['sid'])? $sid = $_REQUEST['sid'] : $sid = "";
  }
  ?>

  <?php build_navBlock(); ?>

  <?php
  if ($action == "removeFromCar") {
      $ses = "Cart".$sid;
      unset($_SESSION[$ses]);
  }
  ?>


  <div id="content">
  	<div class="PageTitle">Shoping Basket</div>
  	<?php
  	foreach ($_SESSION as $index => $data){
  	    if($data != ""){
  	        $ok = 1;
  	    }
  	}
  	if($ok ==1){
  	?>
 <?php
    $total = 0;
	$subTotal = 0;

 foreach ($_SESSION as $index => $data)
 {
     $dsT = str_replace("Cart","",$index);
     openDB();
     $query = "SELECT
                *
                FROM
                lpa_stock
                WHERE
                lpa_stock_ID LIKE '%$dsT%'
            ";
     $result = $db->query($query);
     $row_cnt = $result->num_rows;
     while ($row = $result->fetch_assoc()){
         $sid = $row['lpa_stock_ID'];
		 if ($row['lpa_stock_image']) {
          $prodImage = $row['lpa_stock_image'];
        } else {
          $prodImage = "question.png";
        }
?>
<div class="productListItem">
          <div
            class="productListItemImageFrame"
            style="background: url('images/<?PHP echo $prodImage; ?>') no-repeat center center;">
          </div>
          <div class="prodTitle"><?PHP echo $row['lpa_stock_name']; ?></div>
          <div class="prodDesc"><?PHP echo $row['lpa_stock_desc']; ?></div>
          <div class="prodOptionsFrame">
            <div class="prodPriceQty">
              <div class="prodPrice">$<?PHP echo number_format((float)$row['lpa_stock_price'],2,'.',''); ?></div>
              <div class="prodQty">Quantity <?PHP echo $data; ?></div>
			  <div class="prodDesc"><strong> SubTotal $</strong><?PHP echo number_format((float)$subTotal = $data*$row['lpa_stock_price'],2); ?></div>
            </div>
			 <div class="prodAddToCart">
              <button
                type="button"
                onclick="removeFromCar(<?PHP echo $sid; ?>)">
                Remove From Basket
              </button>
            </div>

          </div>
          <div style="clear: left"></div>
        </div>
		<?php $total += $subTotal;?>

	<?php }?>
<?php }?>
	 <div class="prodTitle">Total $<?php echo number_format((float)$total,2); ?></div>
</div>
<?php }?>
<!--  Search Section List End -->
<?php if ($ok >=1) { ?>
<div class="prodAddToCart">
<button type="button" id="btncheckOut" class="btn" style="align:right;"
onclick="navMan('checkout.php')">Checkout</button>
<?php } ?>
</div>
<script>
	var action = "<?php echo $action; ?>";
	if(action == "removeFromCar") {
		alert("Product removed from the Shopping Basket!");
	}
	function removeFromCar(ID){
		window.location = "shoplist.php?sid=" + ID + "&a=removeFromCar";
	}
	$("#btnCatalog").click(function() {
		navMan("products.php?a=listCatalog");
	});
	setTimeout(function(){
		$("#txtSearch").select().focus();
	},1);
</script>
<?php
 build_footer();
?>
