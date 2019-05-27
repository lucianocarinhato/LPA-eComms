<?PHP
  $authChk = true;
  require('app-lib.php');
  isset($_POST['a'])? $action = $_POST['a'] : $action = "";
  if(!$action) {
    isset($_REQUEST['a'])? $action = $_REQUEST['a'] : $action = "";
  }
  isset($_POST['txtSearch'])? $txtSearch = $_POST['txtSearch'] : $txtSearch = "";
  if(!$txtSearch) {
    isset($_REQUEST['txtSearch'])? $txtSearch = $_REQUEST['txtSearch'] : $txtSearch = "";
  }
  build_header($displayName);
?>
  <?PHP build_navBlock(); ?>
  <div id="content">
    <div class="PageTitle">Sales and Invoicing Management Search</div>

  <!-- Search Section Start -->
    <form name="frmSearchInvoices" method="post"
          id="frmSearchInvoices"
          action="<?PHP echo $_SERVER['PHP_SELF']; ?>">
      <div class="displayPane">
        <div class="displayPaneCaption">Search:</div>
        <div>
          <input name="txtSearch" id="txtSearch" placeholder="Search Invoices"
          value="<?PHP echo $txtSearch; ?>">
          <?php if ($displayGroup == "administrator"): ?>       <!--Condiction to use the administrator function 'add' -->
            <button type="button" id="btnSearch">Search</button>
            <button type="button" id="btnAddRec">Add</button>
          <?php else: ?>                                        <!--If not an administrator, the function 'add' is hidden -->
            <button type="button" id="btnSearch">Search</button>
          <?php endif; ?>
        </div>
      </div>
      <input type="hidden" name="a" value="listInvoices">
    </form>
    <!-- Search Section End -->
    <!-- Search Section List Start -->
    <?PHP
      if($action == "listInvoices") {
    ?>
    <div>
      <table style="width: calc(100% - 15px);border: #cccccc solid 1px; margin-top: 5px">
        <tr style="background: #eeeeee">
          <td style="width: 80px;border-left: #cccccc solid 1px; padding-left: 10px"><b>Client Number</b></td>
          <td style="border-left: #cccccc solid 1px; border-right: #cccccc solid 1px; padding-left: 10px">
            <b>Client Name</b></td>
          <td style="border-right: #cccccc solid 1px; text-align: center"><b>Date</b></td>
          <td style="width: 80px;text-align: right; padding-right: 10px"><b>Price</b></td>
        </tr>
    <?PHP
      openDB();
      $query =
        "SELECT
            *
         FROM
            lpa_invoices
         WHERE
            lpa_inv_client_ID LIKE '%$txtSearch%'
         OR
            lpa_inv_client_name LIKE '%$txtSearch%'
         OR
            lpa_inv_date LIKE '%$txtSearch%'
			
         ";
      $result = $db->query($query);
      $row_cnt = $result->num_rows;
      $sum = 0; //variable that saves the sum sales value
      if($row_cnt >= 1) {
        while ($row = $result->fetch_assoc()) {
          $sid = $row['lpa_inv_no'];
          $sum += $row['lpa_inv_amount']; // sums all sales values from the search
          global $displayGroup;
          if ($displayGroup == "administrator") {   //Condiction to allow only admins to edit
          ?>
            <tr class="hl">
              <td onclick="loadClientName(<?PHP echo $sid; ?>,'Edit')"
                style="cursor: pointer;border-left: #cccccc solid 1px; padding-left: 10px">
                <?PHP echo $sid; ?>
              </td>
              <td onclick="loadClientName(<?PHP echo $sid; ?>,'Edit')"
                style="cursor: pointer;border-left: #cccccc solid 1px; border-right: #cccccc solid 1px;
                padding-left: 10px">
                <?PHP echo $row['lpa_inv_client_name']; ?>
              </td>
              <td onclick="loadClientName(<?PHP echo $sid; ?>,'Edit')"
                style="cursor: pointer;border-right: #cccccc solid 1px; text-align: center">
                <?PHP echo $row['lpa_inv_date']; ?>
              </td>
                <td style="text-align: right; padding-right: 10px">
                <?PHP echo $row['lpa_inv_amount']; ?>
                </td>
              </tr>
          <?PHP
        }else{    //If not an admin, only builds the search list without editing options
          ?>
          <tr class="hl">
            <td style="cursor: pointer;border-left: #cccccc solid 1px; padding-left: 10px">
              <?PHP echo $sid; ?>
            </td>
            <td style="cursor: pointer;border-left: #cccccc solid 1px; border-right: #cccccc solid 1px;
              padding-left: 10px">
              <?PHP echo $row['lpa_inv_client_name']; ?>
            </td>
            <td style="cursor: pointer;border-right: #cccccc solid 1px; text-align: center">
              <?PHP echo $row['lpa_inv_date']; ?>
            </td>
              <td style="text-align: right; padding-right: 10px">
              <?PHP echo $row['lpa_inv_amount']; ?>
              </td>
            </tr>
      <?PHP
      }
      }
      } else { ?>
        <tr>
          <td colspan="3" style="text-align: center">
            No Records Found for: <b><?PHP echo $txtSearch; ?></b>
          </td>
        </tr>
      <?PHP } ?>
      </table>
      <!-- Begin Table printing sales values -->
      <table style="width: calc(100% - 15px)">
          <tr>
            <td style="border-right: #cccccc solid 1px; border-left: #cccccc solid 1px;
            border-bottom: #cccccc solid 1px; text-align: right; padding-right: 10px">
              <b>Total: </b><?php echo floatval($sum) ?>
            </td>
          </tr>
      </table>
      <!-- End Table printing sales values -->
    </div>
    <?PHP } ?>
    <!-- Search Section List End -->
  </div>
  <script>
    var action = "<?PHP echo $action; ?>";
    var search = "<?PHP echo $txtSearch; ?>";
    if(action == "recUpdate") {
      alert("Record Updated!");
      navMan("sales.php?a=listInvoices&txtSearch=" + search);
    }
    if(action == "recInsert") {
      alert("Record Added!");
      navMan("sales.php?a=listInvoices&txtSearch=" + search);
    }
    if(action == "recDel") {
      alert("Record Deleted!");
      navMan("sales.php?a=listInvoices&txtSearch=" + search);
    }
    function loadClientName(ID,MODE) {
      window.location = "invoiceedit.php?sid=" + //Need to create the invoice edit file
      ID + "&a=" + MODE + "&txtSearch=" + search;
    }
    $("#btnSearch").click(function() {
      $("#frmSearchInvoices").submit();
    });
    $("#btnAddRec").click(function() {
      loadClientName("","Add");
    });
    setTimeout(function(){
      $("#txtSearch").select().focus();
    },1);
	gen_log();
  </script>
<?PHP
build_footer();
?>