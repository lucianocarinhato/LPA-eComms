<?PHP
/**
 * Set the global time zone
 *   - for Brisbane Australia (GMT +10)
 */
date_default_timezone_set('Australia/Queensland');
/**
 * Global variables
 */

// Database instance variable
$db = null;
$displayName = "";
$displayGroup = "";

// Start the session
session_name("lpaecomms");
session_start();

isset($_SESSION["authUser"])?
  $authUser = $_SESSION["authUser"] :
  $authUser = "";
isset($_SESSION["isAdmin"])?
    $authUser = $_SESSION["isAdmin"] :
    $authUser = "";

if(isset($authChk) == true) {
  if($authUser) {
    openDB();
    $query = "SELECT * FROM lpa_users WHERE lpa_user_ID = '$authUser' LIMIT 1";
    $result = $db->query($query);
    $row = $result->fetch_assoc();
    $displayName = $row['lpa_user_firstname']." ".$row['lpa_user_lastname'];
    $displayGroup = $row['lpa_user_group'];
  } else {
    header("location: login.php");
  }
}

if(isset($adminChk) == true) {
  if(!$isAdmin)
{

  header("location: login.php");
}
}

/**
 * Connect to database Function
 * - Connect to the local MySQL database and create an instance
 */
function openDB() {
  global $db;
  if(!is_resource($db)) {
    /* Conection String eg.: mysqli("localhost", "lpaecomms", "letmein", "lpaecomms")
     *   - Replace the connection string tags below with your MySQL parameters
     */
    $db = new mysqli(
      "localhost",
      "lpa_ecomms",
      "5XmvHX4djjzQRMRS",
      "lpa_ecomms"
    );
    if ($db->connect_errno) {
      echo "Failed to connect to MySQL: (" .
        $db->connect_errno . ") " .
        $db->connect_error;
    }
  }
}
/**
 * Close connection to database Function
 * - Close a connection to the local MySQL database instance
 * @throws Exception
 */
function closeDB() {
  global $db;
  try {
    if(is_resource($db)) {
      $db->close();
    }
  } catch (Exception $e)
  {
    throw new Exception( 'Error closing database', 0, $e);
  }
}
/**
 * System Logout check
 *
 *  - Check if the logout button has been clicked, if so kill session.
 */
if(isset($_REQUEST['killses']) == "true") {
  $_SESSION = array();
  if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
      $params["path"], $params["domain"],
      $params["secure"], $params["httponly"]
    );
  }
  session_destroy();
  header("location: login.php");
}
/**
 *  Build the page header function
 */
function build_header() {
  global $displayName;
  global $displayGroup;
  include 'header.php';
}
function build_headermashup() {
  global $displayName;
  global $displayGroup;
  include 'headermashup.php';
}
//Begining of the function Build the Navigation block with an administrator check
function build_navBlock() {
  global $displayGroup;

  if ($displayGroup == "administrator") { //Condiction to build the navBlock with the admin tab 'register'
    ?>
    <div id="navBlock">
      <div id="navHeader">MAIN MENU</div>
      <div id="navHome"class="navItem" onclick="navMan('index.php')">HOME</div>
      <div id="navStock"class="navItem" onclick="navMan('stock.php')">STOCK</div>
      <div id="navSales" class="navItem" onclick="navMan('sales.php')">SALES</div>
      <div id="navShoplist" class="navItem" onclick="navMan('shoplist.php')">BASKET</div>
      <div id="navReg" class="navItem" onclick="navMan('reg.php')">REGISTER</div>
      <div id="navMashup" class="navItem" onclick="navMan('mashup.php')">MASHUP</div>
      <div id="navProducts" class="navItem" onclick="navMan('products.php')">PRODUCTS</div>
      <div class="menuSep"></div>
      <div id="navLog" class="navItem" onclick="navMan('login.php?killses=true')">LOGOUT</div>

    </div>
    <?PHP
  }else {      //If it does not fall under the admin condiction it builds the navBlock without the admin tab 'register'
      ?>
        <div id="navBlock">
          <div id="navHeader">MAIN MENU</div>
          <div id="navHome"class="navItem" onclick="navMan('index.php')">HOME</div>
          <div id="navStock"class="navItem" onclick="navMan('stock.php')">STOCK</div>
          <div id="navSales" class="navItem" onclick="navMan('sales.php')">SALES</div>
          <div class="menuSep"></div>
          <div id="navLog" onclick="navMan('login.php?killses=true')">LOGOUT</div>
        </div>
      <?PHP
  }
}
//End of the Navigation Block function
/**
 * Create an ID
 * - Create a unique id.
 *
 * @param string $prefix
 * @param int $length
 * @param int $strength
 * @return string
 */
function gen_ID($prefix='',$length=2, $strength=0) {
  $final_id='';
  for($i=0;$i< $length;$i++)
  {
    $final_id .= mt_rand(0,9);
  }
  if($strength == 1) {
    $final_id = mt_rand(100,999).$final_id;
  }
  if($strength == 2) {
    $final_id = mt_rand(10000,99999).$final_id;
  }
  if($strength == 4) {
    $final_id = mt_rand(1000000,9999999).$final_id;
  }
  return $prefix.$final_id;
}




/**
 *  Build the page footer function
 */
function build_footer() {
  include 'footer.php';
}

// Log and register errors




function gen_log(){


 $iplogfile = 'logs/ip-address-mainsite.html';
 $ipaddress = $_SERVER['REMOTE_ADDR'];
 $webpage = $_SERVER['SCRIPT_NAME'];
 $timestamp = date('d/m/Y h:i:s');
 $file = __FILE__;
 $level = "warning";
 $message = "[{$timestamp}] [{$ipaddress}] [{$webpage}] [{$file}] [{$level}]  Error!".PHP_EOL;
 error_log($message, 3, 'C:\wamp64\www\luciano\log\lpalog.log');
 }

// End log and register errors





?>
