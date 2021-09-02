<?php
/**
 * Kualitee Selenium Plugin Checklist
 *
 * Kualitee Selenium Plugin will copy the associated file from Kualitee Server Executed its automation scripts and return results of testcase i.e Pass, or Fail
 *
 * PHP version 7.0
 * @category   Kualitee
 * @package    PackageName
 * @author     Kualitee Team <support@kualitee.com>
 * @copyright  2001-2018 Kualitee Inc
 * @version    1.0.0
 * @link       https://www.kualitee.com/
 */
//-----------------------------------------------------------------------------------------------------------------------------------------
/**
 *
 * Create a Directory for usability to Execute Automation Script
 *
 * @param    object  $object The object to convert
 * @return   array
 *
 */
/*Check if Plugin is found on remote server*/
$serverURL = $_GET['seleniumserver'];
$type = $_GET['type'];
if($type == 'server_check'){ 
	checkSeleniumConfiguration($serverURL,"Server Found");
	echo "Server Found";exit;
 } ?>	

<?php
/*Check if Plugin is found on remote server*/
if($type == 'plugin_check'){ 
	checkSeleniumConfiguration($serverURL,"Plugin Found");
	echo "Plugin Found";exit;
} ?>	

<?php
if($type == 'folder_check'){
	$filename = 'scripts/readme.md';
	if (file_exists($filename)) {
		checkSeleniumConfiguration($serverURL,"FolderPermsion");
		echo "FolderPermsion";exit;
	} else {
		echo "Please check folder permission or user rights to create / upload files to Scripts folder!";
	}
}
?> 
<?php
	if($type == 'filesize_limit'){
		$filesizes = ini_get("upload_max_filesize");		
 	    checkSeleniumConfiguration($serverURL,"FileSize");
		echo "FileSize";exit;
 } ?>	

<?php
	if($type == 'execution_time'){
		$execution_time = ini_get('max_execution_time'); 
		checkSeleniumConfiguration($serverURL,"ExecutionTime");
		echo "ExecutionTime";exit;
  } ?>	

<?php
	if($type == 'python_check'){
		$cmd = shell_exec("python -V");
		checkSeleniumConfiguration($serverURL,"Python");
		echo  "Your pthon verison is '".$cmd."'";exit;
} ?>	

<?php
if($type == 'selenium_runing'){
	$selenium_running = false;
	$fp = @fsockopen('localhost', 4444);
	if ($fp !== false) {
		$selenium_running = true;
		fclose($fp);
	}
	$server_test = $selenium_running;
	if($server_test == true){
	}else{
		echo "selenium server is not running";
	}
	checkSeleniumConfiguration($serverURL,"Selenium");
}
?>
   

<?php
/*Check if Plugin is found on remote server*/
	if($type == 'curl_installed'){ 
		function _is_curl_installed() {
		    if  (in_array  ('curl', get_loaded_extensions())) {
        		return true;
		    }else {
        return false;
    	}
	}
		if (_is_curl_installed()) {
		  echo "cURL is <span style=\"color:blue\">installed</span> on this server";
		} else {
	  		echo "cURL is NOT <span style=\"color:red\">installed</span> on this server";
		}
		checkSeleniumConfiguration($serverURL,"Curl");

	}
	?>
	

<?php
/*Check if Plugin is found on remote server*/
	if($type == 'popup_blocker'){ 
		checkSeleniumConfiguration($serverURL,"Popup");
		echo "Popup is enabled";exit;
	} ?>	

<?php
/*Check if Plugin is found on remote server*/
	if($type == 'webhook_test'){ 
			$url = 'https://apiss.kualiteestaging.com/get-webhook'; ;
		//create a new cURL resource
		$ch = curl_init($url);
		//setup request to send json via POST
		$data = array(
	    'message' => 'webhook-success',
    	'domain' => $_GET['domain']
	);
	$payload = json_encode(array("user" => $data));
	//attach encoded JSON string to the POST fields
	curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

	//set the content type to application/json
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
	//return response instead of outputting
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	//execute the POST request
	$result = curl_exec($ch);
	$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	//close cURL resource
	curl_close($ch);
	if($httpcode == 200){
		echo 'Webhook working: ' . $httpcode;	
	}else{
		echo 'Webhook not working: ' . $httpcode;	
	}
	checkSeleniumConfiguration($serverURL,"Webhook");
 }
 function checkSeleniumConfiguration($serverLink,$type){
 	$url='https://apiss.kualiteestaging.com/api/v2/integration/selenium_configuration';
	$data = array(
    	"automationUrl" => $serverLink,
		"response" => $type,
	);
	$ch = curl_init( $url );
	# Setup request to send json via POST.
	$payload = json_encode($data);
	curl_setopt( $ch, CURLOPT_POSTFIELDS, $payload );
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
	curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
	$result = curl_exec($ch);
	curl_close($ch);
	//echo curl_errno($ch) . '<br/>';
	/*echo "<pre>";
	var_dump($result);
	echo "</pre>";*/
	}

 ?>	