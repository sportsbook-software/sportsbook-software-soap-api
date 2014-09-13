<?php
    
    /*
    DISCLAIMER
    * - The following code is provided AS IS as a learning start point for your Fungaming API integration. This code may or may not be suited for a production environment, decision which belongs solely to you.
    * - Fungaming does not offer any warranty towards this code compatibility with your production environment nor direct integration services with your platform.
    * Please contact your account manager for our API information. Please note that pre-authorization of your client IP address is required along with an active account and API key. 
    * By using this code you implicitly agree with the above as well as the General Terms of Service an the Operating Agreement previously sent to you.
    * - Please note the API is throttled and tracked. We measure and benchmark access times, IP addresses, and some information in your queries. 
    * Unusual and unjustified extensive API usage (such as polling) may suspend your API access, in such case we do not make any warranties as to if and when API access will be re-instated.
    
    * About the NuSOAP library: NuSOAP is a 3rd party library which is not maintained by us. For further information about NuSOAP please visit http://sourceforge.net/projects/nusoap/
    */
    
    // REQUIREMENTS: php-json, php-xml, libxml, libxml2, remote file_get_contents, PHP memory limit minimum 32Mb, DOM-document support
    
    require_once('lib/nusoap.php');
    
    define("XML","xml");
    define("JSON","json");
    
    date_default_timezone_set("UTC");
    
    // change to HTTPS for production environment
    $schema = "http://";
    
    // configure the account base URL
    $base_url = $schema."www.domain.ext";
    
    // SOAP API endpoint and WSDL file
    $endpoint = $base_url."/tools/api/v1/";
    $wsdl = $endpoint."?wsdl"; // TODO: cache this locally to prevent exhausting your API query limits
    
    // DOWNLOAD API base URL
    $dl_url = $base_url."/api/";
    
    $api_key = "XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX";     // get this from your affiliate account panel -> API Access section
    $debug = true; // false
    /////////////////////////////////// CODE BELOW


    // EXAMPLE SOAP CALL: get last 3 users signed up
    //$c = remote_action('getUsers',array('apikey' => $api_key,'limit' => '3'));
    //print_r($c);


    // EXAMPLE SOAP CALL: get user info
    //$c = remote_action('getUser',array('apikey' => $api_key,'id' => 12345));
    //print_r($c);

    
    // EXAMPLE SOAP CALL: get last 10 transactions
    //$c = remote_action('getTransactions',array('apikey' => $api_key,'limit' => '10'));
    //print_r($c);


    // EXAMPLE DL CALL: get user information in JSON for user # 8429
    //$c = download("users/8429",JSON);
    //print_r(json_decode($c));


    // EXAMPLE DL CALL: get users
    //$c = download("users",JSON);
    //print_r(json_decode($c));


    // EXAMPLE DL CALL: get transactions
    //$c = download("transactions",JSON);
    //print_r(json_decode($c));
    






    


    /////////////////////////////////// FUNCTIONS BELOW
    // generic SOAP call
    function remote_action($method, $parameters){
	global $endpoint;	// specify the SOAP endpoint
	global $wsdl; 		// WSDL file if required
	global $debug;		// enable debug dump
	
	$client = new nusoap_client($wsdl, true);
	
	$result = $client->call($method,$parameters);

	/*
	// TODO error handling
	// Check for a fault - this works with the PHP SoapClient
	if ($client->fault) {
	    echo '<p><b>Fault: ';
	    print_r($result);
	    echo '</b></p>';
	} else {
	    // Check for errors
	     $err = $client->getError();
	    if ($err) {
    		// Display the error
    		echo '<p><b>Error: ' . $err . '</b></p>';
	    } else {
    		// Display the result
    		print_r($result);
	    }
	}
	*/
	return $result;
    }
    
    
    // Generic DOWNLOAD call. Please use this for large quantities of data. 
    // DO NOT append random values to force non-caching of results, every call still counts as an API query on HTTP server level, however additional parameters may trash output
    
    // EXAMPLES:
    /// download("users",JSON);
    /// download("user/1",XML);
    /// download("transactions",JSON);
    
    function download($what,$format){
	global $dl_url;		// access the download API url as specified in the headers
	global $api_key;	// access to the API key is required
	
	// TODO: error handling - if output is !xml and !json - use error handler
	
	return file_get_contents($dl_url.$what.".".$format."?api_key=".$api_key);
    }

?>
