<?PHP
  $authChk = true;
  require('app-lib.php');
  isset($_REQUEST['sid'])? $sid = $_REQUEST['sid'] : $sid = "";
  if(!$sid) {
    isset($_POST['sid'])? $sid = $_POST['sid'] : $sid = "";
  }
  isset($_REQUEST['a'])? $action = $_REQUEST['a'] : $action = "";
  if(!$action) {
    isset($_POST['a'])? $action = $_POST['a'] : $action = "";
  }
  isset($_POST['txtSearch'])? $txtSearch = $_POST['txtSearch'] : $txtSearch = "";
  if(!$txtSearch) {
    isset($_REQUEST['txtSearch'])? $txtSearch = $_REQUEST['txtSearch'] : $txtSearch = "";
  }
  if($action == "delRec") {
    $query =
      "UPDATE lpa_invoices SET
         lpa_inv_status = 'D'
       WHERE
         lpa_inv_no = '$sid' LIMIT 1
      ";
    openDB();
    $result = $db->query($query);
    if($db->error) {
      printf("Errormessage: %s\n", $db->error);
      exit;
    } else {
      header("Location: sales.php?a=recDel&txtSearch=$txtSearch");
      exit;
    }
  }
  // lpa_inv_no	lpa_inv_date	lpa_inv_client_ID	lpa_inv_client_name	lpa_inv_client_address	lpa_inv_amount	lpa_inv_status
  isset($_POST['txtInvNo'])? $salesNO = $_POST['txtInvNo'] : $salesNO = gen_ID();
  isset($_POST['txtInvDate'])? $salesDate = $_POST['txtInvDate'] : $salesDate = "";
  isset($_POST['txtInvClientID'])? $salesClientID = $_POST['txtInvClientID'] : $salesClientID = "";
  isset($_POST['txtInvClientName'])? $salesClientName = $_POST['txtInvClientName'] : $salesClientName = "";
  isset($_POST['txtInvClientAddress'])? $salesClientAddress = $_POST['txtInvClientAddress'] : $salesClientAddress = "";
  isset($_POST['txtInvAmount'])? $salesAmount = $_POST['txtInvAmount'] : $salesAmount = "0.00";
  isset($_POST['txtStatus'])? $salesStatus = $_POST['txtStatus'] : $salesStatus = "";
  $mode = "insertRec";
  if($action == "updateRec") {
    $query =
      "UPDATE lpa_invoices SET
         lpa_inv_no = '$salesNO',
         lpa_inv_date = '$salesDate',
         lpa_inv_client_ID = '$salesClientID',
         lpa_inv_client_name = '$salesClientName',
         lpa_inv_client_address = '$salesClientAddress',
         lpa_inv_amount = '$salesAmount',
         lpa_inv_status = '$salesStatus'
       WHERE
         lpa_inv_no = '$sid' LIMIT 1
      ";
     openDB();
     $result = $db->query($query);
     if($db->error) {
       printf("Errormessage: %s\n", $db->error);
       exit;
     } else {
         header("Location: sales.php?a=recUpdate&txtSearch=$txtSearch");
       exit;
     }
  }
  if($action == "insertRec") {
    $query =
      "INSERT INTO lpa_invoices (
         lpa_inv_no,
         lpa_inv_date,
         lpa_inv_client_ID,
         lpa_inv_client_name,
         lpa_inv_client_address,
         lpa_inv_amount,
         lpa_inv_status
       ) VALUES (
         '$salesNO',
         '$salesDate',
         '$salesClientID',
         '$salesClientName',
         '$salesClientAddress',
         '$salesAmount',
         '$salesStatus'
       )
      ";
    openDB();
    $result = $db->query($query);
    if($db->error) {
      printf("Errormessage: %s\n", $db->error);
      exit;
    } else {
      header("Location: sales.php?a=recInsert&txtSearch=".$stockID);
      exit;
    }
  }
  if($action == "Edit") {
    $query = "SELECT * FROM lpa_invoices WHERE lpa_inv_no = '$sid' LIMIT 1";
    $result = $db->query($query);
    $row_cnt = $result->num_rows;
    $row = $result->fetch_assoc();
    $salesNO     = $row['lpa_inv_no'];
    $salesDate   = $row['lpa_inv_date'];
    $salesClientID   = $row['lpa_inv_client_ID'];
    $salesClientName = $row['lpa_inv_client_name'];
    $salesClientAddress  = $row['lpa_inv_client_address'];
    $salesAmount  = $row['lpa_inv_amount'];
    $salesStatus = $row['lpa_inv_status'];
    $mode = "updateRec";
  }
  build_header($displayName);
  build_navBlock();
  $fieldSpacer = "5px";
?>

  <div id="content">
    <div class="PageTitle">Invoice and Sales Record Management (<?PHP echo $action; ?>)</div>
    <form name="frmSalesRec" id="frmSalesRec" method="post" action="<?PHP echo $_SERVER['PHP_SELF']; ?>">
      <div>
        <div><b>Invoice Number </b></div>
        <input name="txtInvNo" id="txtInvNo" placeholder="Invoice Number" value="<?PHP echo $salesNO; ?>"
        style="width: 80px;" title="Invoice Number">
      </div>
      <div style="margin-top: <?PHP echo $fieldSpacer; ?>">
        <div><b>Date</b></div>
        <input name="txtInvDate" id="txtInvDate" placeholder="Date" value="<?PHP echo date("d/m/Y") . "\n"; ?>"
        style="width: 200px;"  title="Date">
      </div>
      <div style="margin-top: <?PHP echo $fieldSpacer; ?>">
        <div><b>Client ID </b></div>
        <input name="txtInvClientID" id="txtInvClientID" placeholder="Client ID"
        title="Client ID" value="<?PHP echo $salesClientID; ?>" style="width: 200px;"  title="Client ID">
      </div>
      <div style="margin-top: <?PHP echo $fieldSpacer; ?>">
        <div><b>Client Name </b></div>
        <input name="txtInvClientName" id="txtInvClientName" placeholder="Client Name" value="<?PHP echo $salesClientName; ?>"
        style="width: 200px"  title="Client Name">
      </div>
      <div style="margin-top: <?PHP echo $fieldSpacer; ?>">
        <div><b>Address </b></div>
        <input name="txtInvClientAddress" id="txtInvClientAddress" placeholder="Address" value="<?PHP echo $salesClientAddress; ?>"
        style="width: 200px"  title="Address">
      </div>
      <div style="margin-top: <?PHP echo $fieldSpacer; ?>">
        <div><b>Amount </b></div>
        <input name="txtInvAmount" id="txtInvAmount" placeholder="Amount" value="<?PHP echo $salesAmount; ?>"
        style="width: 200px"  title="Amount">
      </div>
      <div style="margin-top: <?PHP echo $fieldSpacer; ?>">
        <div><b>Sale Status:</b></div>
        <input name="txtStatus" id="txtSaleStatusPaid" type="radio" value="p">
          <label for="txtSaleStatusPaid">Paid</label>
        <input name="txtStatus" id="txtSalesStatusUnpaid" type="radio" value="u">
          <label for="txtSalesStatusUnpaid">Unpaid</label>
      </div>
      <input name="a" id="a" value="<?PHP echo $mode; ?>" type="hidden">
      <input name="sid" id="sid" value="<?PHP echo $sid; ?>" type="hidden">
      <input name="txtSearch" id="txtSearch" value="<?PHP echo $txtSearch; ?>" type="hidden">
    </form>
    <div class="optBar">
      <button type="button" id="btnSalesSave">Save</button>
      <button type="button" onclick="navMan('sales.php')">Close</button>
      <?PHP if($action == "Edit") { ?>
      <button type="button" onclick="delRec('<?PHP echo $sid; ?>')" style="color: darkred; margin-left: 20px">DELETE</button>
      <?PHP } ?>
    </div>
  </div>
  <script>
    var salesRecStatus = "<?PHP echo $salesStatus; ?>";
    if(salesRecStatus == "p") {
      $('#txtSaleStatusPaid').prop('checked', true);
    } else {
      $('#txtSalesStatusUnpaid').prop('checked', true);
    }
    $("#btnSalesSave").click(function(){
        $("#frmSalesRec").submit();
    });
    function delRec(ID) {
      navMan("salesaddedit.php?sid=" + ID + "&a=delRec");
    }
    setTimeout(function(){
      $("#txtInvClientName").focus();
    },1);
  </script>
<?PHP
build_footer();
?>