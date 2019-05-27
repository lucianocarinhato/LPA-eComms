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
    <div class="PageTitle">New Customer Registration</div>
    <div>
      <b>First Name: </b>
      <input name="fldfirstName" id="fldfirstName" style="width: 200px">
    </div>
    <div>
      <b>Last Name: </b>
      <input name="fldlastName" id="fldlastName" style="width: 200px">
    </div>
  </div>
<?PHP
build_footer();
?>