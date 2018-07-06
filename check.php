<?php
/*Check if Plugin is found on remote server*/
if($_GET['param'] == 'server_check'){ ?> 
	<script>
        window.opener.postMessage("Server Found","*");
    </script>
<?php echo "Server Found";exit; } ?>	

<?php
/*Check if Plugin is found on remote server*/
if($_GET['param'] == 'plugin_check'){ ?> 
	<script>
		window.opener.postMessage("Plugin Found","*");
	</script>
<?php echo "Plugin Found";exit; } ?>	

<?php
if($_GET['param'] == 'folder_check'){
	$filename = 'scripts/readme.md';
	if (file_exists($filename)) {
		echo "Exists";
	} else {
		echo "Please check folder permission or user rights to create / upload files to Scripts folder!";
	}
?> 
	<script>
		window.opener.postMessage("FolderPermsion","*");
	</script>
<?php } ?>	

<?php
	if($_GET['param'] == 'filesize_limit'){
		$filesizes = ini_get("upload_max_filesize");		
 ?> 
	<script>
	    window.opener.postMessage("FileSize","*");
    </script>
<?php echo "FileSize";exit; } ?>	

<?php
	if($_GET['param'] == 'execution_time'){
		$execution_time = ini_get('max_execution_time'); 
?> 
		<script>
            window.opener.postMessage("ExecutionTime","*");
        </script>
<?php echo "ExecutionTime";exit; } ?>	

<?php
	if($_GET['param'] == 'python_check'){
		$cmd = shell_exec("python -V");
		echo  "Your pthon verison is '".$cmd."'";
 ?> 
    <script>
    	window.opener.postMessage("Python","*");
	</script>
<?php } ?>	

<?php
if($_GET['param'] == 'selenium_runing'){
	$selenium_running = false;
	$fp = @fsockopen('localhost', 4444);
	if ($fp !== false) {
		$selenium_running = true;
		fclose($fp);
	}
	$server_test = $selenium_running;
	if($server_test == true){
		echo "selenium server is running";
	}else{
		echo "selenium server is not running";
	}
 ?> 
    <script>
    	window.opener.postMessage("Selenium","*");
	</script>
<?php } ?>	

<?php
/*Check if Plugin is found on remote server*/
	if($_GET['param'] == 'curl_installed'){ 
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
	?>
	<script>
    	window.opener.postMessage("Curl","*");
	</script>
<?php	} ?>	

<?php
/*Check if Plugin is found on remote server*/
	if($_GET['param'] == 'popup_blocker'){ 
		echo "Popup is enabled";
	?>
	<script>
    	window.opener.postMessage("Popup","*");
	</script>
<?php	} ?>	

<?php
/*Check if Plugin is found on remote server*/
	if($_GET['param'] == 'webhook_test'){ 
			$url = urldecode($_GET['server']);
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

	?>
	<script>
    	window.opener.postMessage("Webhook","*");
	</script>
<?php	} ?>	