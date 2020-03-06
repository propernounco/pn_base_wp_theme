<?php    

    require_once 'Google/autoload.php';
    session_start(); 

    // ********************************************************  //
    // Get these values from https://console.developers.google.com
    // Be sure to enable the Analytics API
    // ********************************************************    //
    $client_id = '[Your Client Id]';
    $client_secret = '[Your client Secret]';
    $redirect_uri = '[Your Redirect URI]';


    $client = new Google_Client();
    $client->setApplicationName("Client_Library_Examples");
    $client->setClientId($client_id);
    $client->setClientSecret($client_secret);
    $client->setRedirectUri($redirect_uri);
    $client->setScopes(array('https://www.googleapis.com/auth/analytics.readonly'));
    $client->setAccessType('offline');   // Gets us our refreshtoken


    //For loging out.
    if ($_GET['logout'] == "1") {
	   unset($_SESSION['token']);
    }
    

    // Step 2: The user accepted your access now you need to exchange it.
    if (isset($_GET['code'])) {
        
    	$client->authenticate($_GET['code']);  
    	$_SESSION['token'] = $client->getAccessToken();
    	$redirect = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
    	header('Location: ' . filter_var($redirect, FILTER_SANITIZE_URL));
    }

    // Step 1:  The user has not authenticated we give them a link to login    
    if (!$client->getAccessToken() && !isset($_SESSION['token'])) {

    	$authUrl = $client->createAuthUrl();

    	print "<a class='login' href='$authUrl'>Connect Me!</a>";
    }    
    

    // Step 3: We have access we can now create our service
    if (isset($_SESSION['token'])) {
        print "<a class='logout' href='".$_SERVER['PHP_SELF']."?logout=1'>LogOut</a><br>";


        print "Access from google: " . $_SESSION['token']."<br>"; 
        
    	$client->setAccessToken($_SESSION['token']);
    	$service = new Google_Service_Analytics($client);    

        // request user accounts
        $accounts = $service->management_accountSummaries->listManagementAccountSummaries();


        foreach ($accounts->getItems() as $item) {

		echo "<b>Account:</b> ",$item['name'], "  " , $item['id'], "<br /> \n";
		
		foreach($item->getWebProperties() as $wp) {
			echo '-----<b>WebProperty:</b> ' ,$wp['name'], "  " , $wp['id'], "<br /> \n";    
			$views = $wp->getProfiles();
			if (!is_null($views)) {
                                // note sometimes a web property does not have a profile / view

				foreach($wp->getProfiles() as $view) {

					echo '----------<b>View:</b> ' ,$view['name'], "  " , $view['id'], "<br /> \n";    
				}  // closes profile
			}
		} // Closes web property
		
	} // closes account summaries
    }


?>

