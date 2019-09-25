<!DOCTYPE html>
<?PHP
  $authChk = true;
  require('app-lib.php');
  build_header($displayName);
?>
  <?PHP build_navBlock(); ?>

<?PHP
  $msg = null;
  $userID = gen_ID();
  $userName = "";
  $userPassword = "";
  $userFirstName = "";
  $userLastname = "";
  $userAddress = "";
  $userPhone = "";
  $userGroup = "user";
  $userStatus = "a";
  $mode = "";

  isset($_REQUEST['a'])? $action = $_REQUEST['a'] : $action = "";
  if(!$action) {
    isset($_POST['a'])? $action = $_POST['a'] : $action = "";
  }
   isset($_POST['txtUserConfirmPassword'])? $userConfirmPassword = $_POST['txtUserConfirmPassword'] : $userConfirmPassword = "";
 if ($_SERVER['REQUEST_METHOD'] == "POST") {
   isset($_POST['txtUserID'])? $userID = $_POST['txtUserID'] : $userID = gen_ID();
   if(empty($_POST['txtUserName']))
		{$msg = "Username is required";
		}else if(empty($_POST['txtUserPassword']))
			{$msg = "Password is required";
			}else if(empty($_POST['txtUserFirstName']))
				{$msg = "First name is required";
				}else if(empty($_POST['txtUserLastname']))
					{$msg = "Last name is required";
					}else if(empty($_POST["txtUserConfirmPassword"]))
						{ $msg = "Different password";
						}else{
					        $userID = $_POST['txtUserID'];
							$userName = $_POST['txtUserName'];
							$userPassword = $_POST['txtUserPassword'];
							$userFirstName = $_POST['txtUserFirstName'];
							$userLastname = $_POST['txtUserLastname'];
							$userAddress = $_POST['txtUserAddress'];
							$userPhone = $_POST['txtUserPhone'];
							$mode = "insertRec";
							$action = "insertRec";
							}
 }
 $hashedPassword = hash("md5",$userPassword);
  if($action == "insertRec") {
	$query =
      "INSERT INTO lpa_users (
         lpa_user_ID,
         lpa_user_username,
		 lpa_user_password,
         lpa_user_firstname,
		 lpa_user_lastname,
		 lpa_user_address,
		 lpa_user_phone,
		 lpa_user_group,
         lpa_user_status
       ) VALUES (
         '$userID',
         '$userName',
         '$hashedPassword',
         '$userFirstName',
	     '$userLastname',
		 '$userAddress',
		 '$userPhone',
         '$userGroup',
		 '$userStatus'
       )
      ";
    openDB();
    $result = $db->query($query);
    if($db->error) {
	  gen_log($userName,"error to register");
      printf("Errormessage: %s\n", $db->error);
      exit;
    } else {
	  gen_log($userName,"success to register");
      header("Location: login.php?a=$userName Insert&txtSearch=".$userID);
      exit;
    }
  }

  $fieldSpacer = "5px";
?>

  <div id="content">
    <div class="PageTitle">Register Record</div>
    <form name="frmUserRec" id="frmUserRec" method="post" action="<?PHP echo $_SERVER['PHP_SELF']; ?>">
      <div>
        <input name="txtUserID" id="txtUserID" placeholder="User ID" value="<?PHP echo $userID; ?>" style="width: 100px;" title="User ID">
      </div>
	  <div style="margin-top: <?PHP echo $fieldSpacer; ?>">
        <input name="txtUserName" id="txtUserName" placeholder="User Name" value="<?PHP echo $userName; ?>" style="width: 200px;"  title="User Name">
      </div>
	  <div style="margin-top: <?PHP echo $fieldSpacer; ?>">
       <input type="password" name="txtUserPassword" id="txtUserPassword" placeholder="Password" style="width: 200px;height: 20px"  title="Password" onkeyup='check();'><br><br>
	   <input name="txtUserConfirmPassword" id="txtUserConfirmPassword" placeholder="User Confirm Password" value="<?PHP echo $userConfirmPassword; ?>" type="password" style="width: 200px;height: 20px" title="User Confirm Password" onkeyup='check();' > <span id='message'></span> <br>
	   <input type="checkbox" onclick="visibility()">Show password
      </div>
	  <div style="margin-top: <?PHP echo $fieldSpacer; ?>">
        <input name="txtUserFirstName" id="txtUserFirstName" placeholder="First Name" value="<?PHP echo $userFirstName; ?>" style="width: 400px;text-align: left"  title="First Name">
      </div>
      <div style="margin-top: <?PHP echo $fieldSpacer; ?>">
        <input name="txtUserLastname" id="txtUserLastname" placeholder="Last Name" value="<?PHP echo $userLastname; ?>" style="width: 400px;text-align: left"  title="Last Name">
      </div>
	  <div style="margin-top: <?PHP echo $fieldSpacer; ?>">
        <textarea name="txtUserAddress" id="txtUserAddress" placeholder="Address" style="width: 400px;height: 80px"  title="Address"><?PHP echo $userAddress; ?></textarea>
      </div>

	  <div style="margin-top: <?PHP echo $fieldSpacer; ?>">
        <input name="txtUserPhone" id="txtUserPhone" placeholder="Phone" value="<?PHP echo $userPhone; ?>" style="width: 400px;text-align: left"  title="Phone">
      </div>

      <input name="a" id="a" value="<?PHP echo $mode; ?>" type="hidden">

    </form>
    <div class="optBar">
      <button type="button" id="btnUserSave">Save</button>
      <button type="button" onclick="navMan('users.php')">Close</button>

    </div>
  </div>

<script>
	var msg = "<?PHP echo $msg; ?>";
	if(msg) {
    alert(msg);
	}
	function visibility() {
	 var x =document.getElementById("txtUserPassword");
	 if (x.type === "password") {
		 x.type = "text";
	 } else {
		 x.type = "password";
	 }
	}
	var check = function() {
		if (document.getElementById('txtUserPassword').value ==
			document.getElementById('txtUserConfirmPassword').value) {
			document.getElementById('message').style.color = 'green';
			document.getElementById('message').innerHTML = 'matching';
		} else {
			document.getElementById('message').style.color = 'red';
			document.getElementById('message').innerHTML = 'not matching';
		}
	}
    $("#btnUserSave").click(function(){
        $("#frmUserRec").submit();
    });
    setTimeout(function(){
      $("#txtUserName").focus();
    },1);
</script>

<?PHP
build_footer();
?>
