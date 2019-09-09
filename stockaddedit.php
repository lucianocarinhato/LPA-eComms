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
      "UPDATE lpa_stock SET
         lpa_stock_status = 'D'
       WHERE
         lpa_stock_ID = '$sid' LIMIT 1
      ";
    openDB();
    $result = $db->query($query);
    if($db->error) {
      printf("Errormessage: %s\n", $db->error);
      exit;
    } else {
      header("Location: stock.php?a=recDel&txtSearch=$txtSearch");
      exit;
    }
  }
  isset($_POST['txtStockID'])? $stockID = $_POST['txtStockID'] : $stockID = gen_ID();
  isset($_POST['txtStockName'])? $stockName = $_POST['txtStockName'] : $stockName = "";
  isset($_POST['txtStockDesc'])? $stockDesc = $_POST['txtStockDesc'] : $stockDesc = "";
  isset($_POST['txtStockOnHand'])? $stockOnHand = $_POST['txtStockOnHand'] : $stockOnHand = "0";
  isset($_POST['txtStockImage'])? $stockImage = $_POST['txtStockImage'] : $stockImage = "";
  isset($_POST['txtStockPrice'])? $stockPrice = $_POST['txtStockPrice'] : $stockPrice = "0.00";
  isset($_POST['txtStatus'])? $stockStatus = $_POST['txtStatus'] : $stockStatus = "";
  $mode = "insertRec";
  if($action == "updateRec") {
    $query =
      "UPDATE lpa_stock SET
         lpa_stock_ID = '$stockID',
         lpa_stock_name = '$stockName',
         lpa_stock_desc = '$stockDesc',
         lpa_stock_onhand = '$stockOnHand',
         lpa_stock_image = '$stockImage',
         lpa_stock_price = '$stockPrice',
         lpa_stock_status = '$stockStatus'
       WHERE
         lpa_stock_ID = '$sid' LIMIT 1
      ";
     openDB();
     $result = $db->query($query);
     if($db->error) {
       printf("Errormessage: %s\n", $db->error);
       exit;
     } else {
         header("Location: stock.php?a=recUpdate&txtSearch=$txtSearch");
       exit;
     }
  }
  if($action == "insertRec") {
    $query =
      "INSERT INTO lpa_stock (
         lpa_stock_ID,
         lpa_stock_name,
         lpa_stock_desc,
         lpa_stock_onhand,
         lpa_stock_image,
         lpa_stock_price,
         lpa_stock_status
       ) VALUES (
         '$stockID',
         '$stockName',
         '$stockDesc',
         '$stockOnHand',
         '$stockImage',
         '$stockPrice',
         '$stockStatus'
       )
      ";
    openDB();
    $result = $db->query($query);
    if($db->error) {
      printf("Errormessage: %s\n", $db->error);
      exit;
    } else {
      header("Location: stock.php?a=recInsert&txtSearch=".$stockID);
      exit;
    }
  }
  if($action == "Edit") {
    $query = "SELECT * FROM lpa_stock WHERE lpa_stock_ID = '$sid' LIMIT 1";
    $result = $db->query($query);
    $row_cnt = $result->num_rows;
    $row = $result->fetch_assoc();
    $stockID     = $row['lpa_stock_ID'];
    $stockName   = $row['lpa_stock_name'];
    $stockDesc   = $row['lpa_stock_desc'];
    $stockOnHand = $row['lpa_stock_onhand'];
    $stockImage  = $row['lpa_stock_image'];
    $stockPrice  = $row['lpa_stock_price'];
    $stockStatus = $row['lpa_stock_status'];
    $mode = "updateRec";
  }
  build_header($displayName);
  build_navBlock();
  $fieldSpacer = "5px";
?>

  <div id="content">
    <div class="PageTitle">Stock Record Management (<?PHP echo $action; ?>)</div>
    <form name="frmStockRec" id="frmStockRec" method="post" action="<?PHP echo $_SERVER['PHP_SELF']; ?>">
      <div>
        <div><b>Stock ID </b></div>
        <input name="txtStockID" id="txtStockID" placeholder="Stock ID" value="<?PHP echo $stockID; ?>"
        style="width: 100px;" title="Stock ID">
      </div>
      <div style="margin-top: <?PHP echo $fieldSpacer; ?>">
        <div><b>Product Name </b></div>
        <input name="txtStockName" id="txtStockName" placeholder="Stock Name" value="<?PHP echo $stockName; ?>"
        style="width: 400px;"  title="Stock Name">
      </div>
      <div style="margin-top: <?PHP echo $fieldSpacer; ?>">
        <div><b>Product Description </b></div>
        <textarea name="txtStockDesc" id="txtStockDesc" placeholder="Stock Description" style="width: 400px;height: 80px"
        title="Stock Description"><?PHP echo $stockDesc; ?></textarea>
      </div>
      <div style="margin-top: <?PHP echo $fieldSpacer; ?>">
        <div><b>In Stock </b></div>
        <input name="txtStockOnHand" id="txtStockOnHand" placeholder="Stock On-Hand" value="<?PHP echo $stockOnHand; ?>"
        style="width: 90px;text-align: right"  title="Stock On-Hand">
      </div>
      <div style="margin-top: <?PHP echo $fieldSpacer; ?>">
        <div><b>Price </b></div>
        <input name="txtStockPrice" id="txtStockPrice" placeholder="Stock Price" value="<?PHP echo $stockPrice; ?>"
        style="width: 90px;text-align: right"  title="Stock Price">
      </div>
      <div style="margin-top: <?PHP echo $fieldSpacer; ?>">
        <div><b>Stock Status:</b></div>
        <input name="txtStatus" id="txtStockStatusActive" type="radio" value="a">
          <label for="txtStockStatusActive">Active</label>
        <input name="txtStatus" id="txtStockStatusInactive" type="radio" value="i">
          <label for="txtStockStatusInactive">Inactive</label>
      </div>
      <div style="margin-top: <?PHP echo $fieldSpacer; ?>">


<!-- Save image button -->
        <div><b>Stock Image </b></div>
        <button type="button" name="txtStockImage" id="txtStockImage" placeholder="Stock Image" value="<?PHP echo $stockOnHand; ?>"
        style="width: 90px;text-align: center"  title="Stock Image">Chose File</button>
      </div>
<!-- End save image button -->

      <input name="a" id="a" value="<?PHP echo $mode; ?>" type="hidden">
      <input name="sid" id="sid" value="<?PHP echo $sid; ?>" type="hidden">
      <input name="txtSearch" id="txtSearch" value="<?PHP echo $txtSearch; ?>" type="hidden">
    </form>
    <div class="optBar">
      <button type="button" id="btnStockSave">Save</button>
      <button type="button" onclick="navMan('stock.php')">Close</button>
      <?PHP if($action == "Edit") { ?>
      <button type="button" onclick="delRec('<?PHP echo $sid; ?>')" style="color: darkred; margin-left: 20px">DELETE</button>
      <?PHP } ?>
    </div>
  </div>
  <?PHP
  if($action == "txtStockImage") {



 // Save image function





    function saveImage(){
          $currentDir = getcwd();
          $uploadDirectory = "/uploads/";

          $errors = []; // Store all foreseen and unforseen errors here

          $fileExtensions = ['jpeg','jpg','png']; // Get all the file extensions

          $fileName = $_FILES['myfile']['name'];
          $fileSize = $_FILES['myfile']['size'];
          $fileTmpName  = $_FILES['myfile']['tmp_name'];
          $fileType = $_FILES['myfile']['type'];
          $fileExtension = strtolower(end(explode('.',$fileName)));

          $uploadPath = $currentDir . $uploadDirectory . basename($fileName);

          if (isset($_POST['submit'])) {

              if (! in_array($fileExtension,$fileExtensions)) {
                  $errors[] = "This file extension is not allowed. Please upload a JPEG or PNG file";
              }

              if ($fileSize > 2000000) {
                  $errors[] = "This file is more than 2MB. Sorry, it has to be less than or equal to 2MB";
              }

              if (empty($errors)) {
                  $didUpload = move_uploaded_file($fileTmpName, $uploadPath);

                  if ($didUpload) {
                      echo "The file " . basename($fileName) . " has been uploaded";
                  } else {
                      echo "An error occurred somewhere. Try again or contact the admin";
                  }
              } else {
                  foreach ($errors as $error) {
                      echo $error . "These are the errors" . "\n";
                  }
              }
          }
      }
    }

     // End save image function

    ?>
  <script>
    var stockRecStatus = "<?PHP echo $stockStatus; ?>";
    if(stockRecStatus == "a") {
      $('#txtStockStatusActive').prop('checked', true);
    } else {
      $('#txtStockStatusInactive').prop('checked', true);
    }
    $("#btnStockSave").click(function(){
        $("#frmStockRec").submit();
    });
    function delRec(ID) {
      navMan("stockaddedit.php?sid=" + ID + "&a=delRec");
    }
    setTimeout(function(){
      $("#txtStockName").focus();
    },1);
  </script>
<?PHP
build_footer();
?>
