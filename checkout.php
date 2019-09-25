<!DOCTYPE html>
<?PHP
	$authChk = true;
	require ('app-lib.php');

	isset($_POST['a'])? $action = $_POST['a'] : $action = "";
	if(!$action) {
		isset($_REQUEST['a'])? $action = $_REQUEST['a'] : $action = "";
	}
	isset($_POST['txtSearch'])? $txtSearch = $_POST['txtSearch'] : $txtSearch = "";
	if(!$txtSearch) {
		isset($_REQUEST['txtSearch'])? $txtSearch = $_REQUEST['txtSearch'] : $txtSearch = "";
	}
	isset($_POST['sid'])? $sid = $_POST['sid'] : $sid = "";
	if(!$sid) {
	isset($_REQUEST['sid'])? $sid = $_REQUEST['sid'] : $sid = "";
    }



  build_header ($displayName);
 ?>

 <?PHP build_navBlock (); ?>

	<div id="content">
	<div class="PageTitle">Check out</div>
	<form name="frmSearchSales" method="post"
			id="frmSearchSales"
			action="<?PHP echo $_SERVER['PHP_SELF']; ?>">
	</form>
		<div class="displayPaneCaption"></div>
		<div>
			<input name="PaymentMeth" id="PaymentMeth" placeholder="Payment Method" style="text-align:center; width: calc(100%-1px)">
		</div>
	<table style="width: calc(100%-1px);border: #cccccc solid 1px">
		<tr style="background: #eeeeee">
		<td onclick="ChkOut(<?PHP echo $sid; ?>)" >
		<img id="btnAddCar" src="images/amex.png" style="height: 100px; width:150px; cursor:pointer; text-align:center;">
		<td onclick="ChkOut(<?PHP echo $sid; ?>)" >
		<img id="btnAddCar" src="images/master.png" style="height:100px; width:150px; cursor:pointer; text-align:center;">
		<td onclick="ChkOut(<?PHP echo $sid; ?>)" >
		<img id="btnAddCar" src="images/ppcom.png" style="height:100px; width:150px; cursor:pointer; text-align:center;">
		<td onclick="ChkOut(<?PHP echo $sid; ?>)" >
		<img id="btnAddCar" src="images/visa.png" style="height:100px; width:150px; cursor:pointer; text-align:center;">
		<td onclick="ChkOut(<?PHP echo $sid; ?>)" >
		<img id="btnAddCar" src="images/discover.jpg" style="height:100px; width:150px; cursor:pointer; text-align:center;">
		<td onclick="ChkOut(<?PHP echo $sid; ?>)" >
		<img id="btnAddCar" src="images/anz.png" style="height:100px; width:150px; cursor:pointer; text-align:center;">

		</tr>
		</table>

<script>
var action = "<?PHP echo $action; ?>";
var search = "<?PHP echo $txtSearch; ?>";
function ChkOut(ID) {
	alert("Product paid with success. Invoice sent to your email");
	navMan("login.php?killses=true")
}
setTimeout(function() {
	$("txtSearch").select().focus();
},1);
</script>

<?PHP
build_footer ();
?>
