<?php
//echo "Automation";exit;
/**
 * Kualitee Selenium Plugin
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
 global $executed_output;
 global $count_output;
function createDirectory(){
	global $executed_output;
	global $count_output;
	$base_url =  $_SERVER['DOCUMENT_ROOT']."/KualiteeSelenium-master/scripts/";
#webhook.php
	//$filepath = 'http://www.kualiteestaging.com//files/htester/automation/testpython_2018-02-19_1519023129.py';
	//$filename = 'testpython_2018-02-19_1519023129.py';
	
	$filename 	= @$_GET['File'];
	$automation = base64_decode(@$_GET['Link']);
	//echo $automation;exit;
	if(!empty($filename)){

	$file_to_run = 'scripts/'.$filename;
	if (file_exists($file_to_run)) {
	  // unlink('scripts/'.$filename);
	}
	if(!empty($filename)){
	
	//sleep(5);
		ini_set('display_errors', 1);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $automation);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		$file123 = curl_exec($ch);
		curl_close($ch);
		file_put_contents('scripts/'.$filename, $file123);	
		//echo $base_url.$filename;exit;
		/*Execute scripts*/
			if(@$_GET['Lang']=='c_sharp'){
				$outFileName = $filename; //"scriptedOutput"; //generate the file name dynamically to avoid collisions
				//$output = exec("cd ./Scripts && csc /r:WebDriver.dll;WebDriver.Support.dll;Newtonsoft.Json.dll /out:".$outFileName.".exe ".$outFileName." && " . $outFileName .".exe && del " . $outFileName . ".exe");
					$output1 = exec("cd ./Scripts && csc /r:WebDriver.dll;WebDriver.Support.dll;Newtonsoft.Json.dll /out:".$outFileName.".exe ".$outFileName." && " . $outFileName .".exe && del " . $outFileName . ".exe  2>&1", $output, $return_var);
					//print_r($output);exit;
					$executed_output = json_encode($output);
					 $count_output = count($output);					 
			}elseif(@$_GET['Lang']=='python'){
				if (file_exists($file_to_run)) {
					//$cmd = shell_exec("python ".$base_url.$filename);
                    $cmd = exec("python ".$base_url.$filename." 2>&1", $output, $return_var);
                	// $cmd = exec("python C:\\xampp\\htdocs\\KualiteeSelenium\\scripts\\headless_20190306_1551878308.py 2>&1", $output, $return_var);
					 
					 $executed_output = json_encode($output);
					 $count_output = count($output);
//echo $executed_output."count".	$count_output;exit;				 
				}
			}
		}
	}
}	
$data = createDirectory();
?>
<script type="text/javascript">
var pass_data = {
 'fileName':'<?php echo @$_GET['File'];?>',
 'execOutput':'<?php echo @$executed_output;?>',
 'countOutput':'<?php echo @$count_output;?>', 
};
window.opener.postMessage(JSON.stringify(pass_data), "*");
</script>




