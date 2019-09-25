<!DOCTYPE html>
<?PHP
  require('app-lib.php');

  build_header($displayName);

  isset($_POST['a'])? $action = $_POST['a'] : $action = "";
  if(!$action){
      isset($_REQUEST['a'])? $action = $_REQUEST['a'] : $action = "";
  }
  isset($_POST['txtSearch'])? $txtSearch = $_POST['txtSearch'] : $txtSearch = "";
  if (!$txtSearch) {
      isset($_REQUEST['txtSearch'])? $txtSearch = $_REQUEST['txtSearch']:$txtSearch = "";
  }
  isset($_REQUEST['sid'])? $sid = $_REQUEST['sid'] : $sid = "";
  if(!$sid) {
      isset($_POST['sid'])? $sid = $_POST['sid'] : $sid = "";
  }
  isset($_REQUEST['name'])? $name = $_REQUEST['name'] : $name = "";
  if(!$name) {
      isset($_POST['name'])? $name = $_POST['name'] : $name = "";
  }
  isset($_REQUEST['description'])? $description = $_REQUEST['description'] : $description = "";
  if(!$description) {
      isset($_POST['description'])? $description = $_POST['description'] : $description = "";
  }
  isset($_REQUEST['price'])? $price = $_REQUEST['price'] : $price = "";
  if(!$price) {
      isset($_POST['price'])? $price = $_POST['price'] : $price = "";
  }
  isset($_REQUEST['quantity'])? $quantity = $_REQUEST['quantity'] : $quantity = "";
  if(!$quantity) {
      isset($_POST['quantity'])? $quantity = $_POST['quantity'] : $quantity = "";
  }
?>
<?php
    if ($action == "addToCar") {
        $ses = "Cart".$sid;
        $_SESSION[$ses] = $quantity;
    }
?>
<html>
<body>
<?php
//print_t(array_values('$item_array'));
//session_destroy();
?>
<?php build_navBlock(); ?>
<html lang="en">
<div id="content">
 <div class="PageTitle">Catalog Management Search</div>

 <!-- Search Section Start -->
 	<form name="frmSearchCatalog" method="post"
 		id="frmSearchCatalog"
 		action="<?php echo $_SERVER['PHP_SELF']; ?>">
	<DIV class="displayPane">

<div>
	<input name="txtSearch" id="txtSearch" placeholder="Search Product" style="width: calc(100% - 70px)"
	value="<?PHP echo $txtSearch; ?>">
	<button type="button" id="btnSearch">Search</button>
	</div>
</div>
	<input type="hidden" name="a" value="listProduct">
</form>
<!--Search Section End -->
<!--Search Section List Start -->

<div>
	<table style="width: calc(100% - 15px);border: #cccccc solid 1px">
	<tr style="background: #eeeeee">
	<td style="text-align:center;border-left: #cccccc solid 1px"><b>Product Name</b></td>
	<td style="text-align:center;border-left: #cccccc solid 1px"><b>Product Desc</b></td>
	<td style="text-align:center;border-left: #cccccc solid 1px"><b>Product Price</b></td>
	<td style="text-align:center;border-left: #cccccc solid 1px"><b>Quantity</b></td>
	<td style="width: 100px;text-align:center;border-left: #cccccc solid 1px"><b>Add to Cart</b></td>
</tr>
<?PHP
openDB();
$query =
"SELECT
	*
FROM
	lpa_stock
WHERE
	lpa_stock_ID LIKE '%$txtSearch%' AND lpa_stock_status <> 'D'
OR
	lpa_stock_name LIKE '%$txtSearch%' AND lpa_stock_status <> 'D'
";

$result = $db->query($query);
$row_cnt = $result->num_rows;
if($row_cnt >= 1) {
	while ($row = $result->fetch_assoc()) {
		$sid = $row ['lpa_stock_ID'];
		?>
		<tr class="hl">
			<td style="cursor: pointer;border-left: #cccccc solid 1px">
			<input type="hidden" name="idProduct" value=<?PHP echo $sid; ?>">
				<?PHP $name = $row['lpa_stock_name']; ?>
			<input type="hidden" name="name" value="<?PHP echo $name; ?>">
				<?PHP echo $name; ?>
			</td>
			<td style="text-align: right">
			<input type="hidden" name="description" value="<?PHP echo $description; ?>">
				<?PHP $description = $row['lpa_stock_desc']; ?>
				<?PHP echo $description; ?>
			</td>
			<td style="text-align: right">
			<input type="hidden" name="price" value="<?PHP echo $price; ?>">
				<?PHP $price = $row['lpa_stock_price']; ?>
				<?PHP echo $price; ?>
			</td>
			<td style="text-align: right">
				<input name="txtQuantity" id="txtQuantity<?PHP echo $sid; ?>"placeholder="">
			</td>
			<td onclick="addToCar(<?PHP echo $sid; ?>)">
				<img id="btnAddCar" src="images/add-button.jpg" style="height: 40px; width:40px; cursor:pointer; text-align:center;" >
				</tr>

<?php }
} else { ?>
<tr>
	<td colspan="3" style="text-align: center">
	 No Records Found for: <b><?php echo $txtSearch; ?></b>
	 </td>
	 </tr>
	 <?php } ?>
	 </table>
	 </DIV>
	 <!-- Search Section List End -->

</div>
<script>
	var action = "<?php echo $action; ?>";
	var search = "<?php echo $txtSearch; ?>";
	if(action == "addToCar") {
		alert("Item Added to the Shopping Cart!");
		navMan("Catalog.php?a=listProduct&txtSearch=" + search);
	}
	function addToCar(ID) {
		var Quantity=$("#txtQuantity" + ID).val();
		window.location = "Catalog.php?a=addToCar&sid=" +
		ID + "&quantity=" + Quantity;
	}
	$("#btnSearch").click(function() {
		$("#frmSearchCatalog").submit();
	});
	setTimeout(function(){
		$("#txtSearch").select().focus();
	},1);
</script>
<?php
// build_footer();
?>
