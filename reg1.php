<?PHP
  require('app-lib.php');
  build_header();
?>
<?PHP
  $authChk = true;

  isset($_REQUEST['a'])? $action = $_REQUEST['a'] : $action = "";
  if(!$action) {
    isset($_POST['a'])? $action = $_POST['a'] : $action = "";
  }

  isset($_POST['txtUserID'])? $userID = $_POST['txtUserID'] : $userID = gen_ID();
  isset($_POST['txtUserName'])? $userName = $_POST['txtUserName'] : $userName = "";
  isset($_POST['txtUserPassword'])? $userPassword = $_POST['txtUserPassword'] : $userPassword = "";
  isset($_POST['txtUserFirstName'])? $userFirstName = $_POST['txtUserFirstName'] : $userFirstName = "";
  isset($_POST['txtUserLastname'])? $userLastname = $_POST['txtUserLastname'] : $userLastname = "";
  isset($_POST['txtUserGroup'])? $userGroup = $_POST['txtUserGroup'] : $userGroup = "user";
  isset($_POST['txtStatus'])? $userStatus = $_POST['txtStatus'] : $userStatus = "1";
  $mode = "insertRec";

  if($action == "insertRec") {
    $query =
      "INSERT INTO lpa_users (
         lpa_user_ID,
         lpa_user_username,
		 lpa_user_password,
         lpa_user_firstname,
		 lpa_user_lastname,
		 lpa_user_group,
         lpa_user_status
       ) VALUES (
         '$userID',
         '$userName',
         '$userPassword',
         '$userFirstName',
	     '$userLastname',
         '$userGroup',
		 '$userStatus'
       )
      ";
    openDB();
    $result = $db->query($query);
    if($db->error) {
      printf("Errormessage: %s\n", $db->error);
      exit;
    } else {
      header("Location: reg.php?a=recInsert&txtSearch=".$userID);
      exit;
    }
  }

  $fieldSpacer = "5px";
?>
  <?PHP build_navBlock(); ?>
  <div id="content">
    <div class="PageTitle">Register Record (<?PHP echo $action; ?>)</div>
    <form name="frmUserRec" id="frmUserRec" method="post" action="<?PHP echo $_SERVER['PHP_SELF']; ?>">
      <div>
        <input name="txtUserID" id="txtUserID" placeholder="User ID" value="<?PHP echo $userID; ?>" style="width: 100px;" title="User ID">
      </div>
	  <div style="margin-top: <?PHP echo $fieldSpacer; ?>">
        <input name="txtUserName" id="txtUserName" placeholder="User Name" value="<?PHP echo $userName; ?>" style="width: 200px;"  title="User Name">
      </div>
	  <div style="margin-top: <?PHP echo $fieldSpacer; ?>">
        <textarea name="txtUserPassword" id="txtUserPassword" placeholder="Password" style="width: 200px;height: 20px"  title="Password"><?PHP echo $userPassword; ?></textarea>
      </div>
	  <div style="margin-top: <?PHP echo $fieldSpacer; ?>">
        <input name="txtUserFirstName" id="txtUserFirstName" placeholder="First Name" value="<?PHP echo $userFirstName; ?>" style="width: 400px;text-align: left"  title="First Name">
      </div>
      <div style="margin-top: <?PHP echo $fieldSpacer; ?>">
        <input name="txtUserLastname" id="txtUserLastname" placeholder="Last Name" value="<?PHP echo $userLastname; ?>" style="width: 400px;text-align: left"  title="Last Name">
      </div>
      <input name="a" id="a" value="<?PHP echo $mode; ?>" type="hidden">
    </form>
    <div class="optBar">
      <button type="button" id="btnUserSave">Save</button>
      <button type="button" onclick="navMan('users.php')">Close</button>

    </div>
  </div>

<script>
    $("#btnUserSave").click(function(){
		if(document.getElementById("txtUserName").value == ""){
		alert ("Username is required");
		}else if(document.getElementById("txtUserPassword").value == ""){
		alert ("Password is required");
		}else if(document.getElementById("txtUserFirstName").value == ""){alert ("First name is required");
		}else if(document.getElementById("txtUserLastname").value == "")
		{alert ("Last name is required");
		}else {$("#frmUsersRec").submit();}});
    function delRec(ID) {
      navMan("reg.php?sid=" + ID + "&a=delRec");
    }
    setTimeout(function(){
      $("#txtUserName").focus();
    },1);
</script>

<?PHP
build_footer();
?>
