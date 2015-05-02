<?php

$lib = "/var/www/stem/google-api-php-client/src/Google/";

require_once "config.php";
require_once $lib . "Client.php";
require_once $lib . "Service/Drive.php";
require_once $lib . "Service/Oauth2.php";
require_once $lib . "Auth/AssertionCredentials.php";

/**
 * Build and returns a Drive service object authorized with the service accounts
 * that acts on behalf of the given user.
 *
 * @param userEmail The email of the user.
 * @return Google_DriveService service object.
 */
function getDriveService() {
	global $SERVICE_ACCOUNT_PKCS12_FILE_PATH, $SERVICE_ACCOUNT_EMAIL, $DRIVE_SCOPE;
  $key = file_get_contents($SERVICE_ACCOUNT_PKCS12_FILE_PATH);
  $auth = new Google_Auth_AssertionCredentials(
      $SERVICE_ACCOUNT_EMAIL,
      array($DRIVE_SCOPE),
      $key);
  //$auth->sub = $userEmail;
  $client = new Google_Client();
  //$client->setUseObjects(true);
  $client->setAssertionCredentials($auth);
  return new Google_Service_Drive($client);
}

function retrieveAllFiles($service) {
  $result = array();
  $pageToken = NULL;

  do {
    try {
      $parameters = array();
      if ($pageToken) {
        $parameters['pageToken'] = $pageToken;
      }
      $files = $service->files->listFiles($parameters);

      $result = array_merge($result, $files->getItems());
      $pageToken = $files->getNextPageToken();
    } catch (Exception $e) {
      print "An error occurred: " . $e->getMessage();
      $pageToken = NULL;
    }
  } while ($pageToken);
  return $result;
}

function printFilesInFolder($service, $folderId) {
  $pageToken = NULL;

  do {
    try {
      $parameters = array();
      if ($pageToken) {
        $parameters['pageToken'] = $pageToken;
      }
      $children = $service->children->listChildren($folderId, $parameters);

      foreach ($children->getItems() as $child) {
        echo 'File Id: ' . $child->getId();
		echo ' | Kind: ' . $child->getKind();
		echo ' | Link: ' . $child->getSelfLink();
		echo '<br>';
      }
      $pageToken = $children->getNextPageToken();
    } catch (Exception $e) {
      print "An error occurred: " . $e->getMessage();
      $pageToken = NULL;
    }
  } while ($pageToken);
}

function listFileIdInFolder($service,$folderId){
  $pageToken = NULL;
	$result = array();
  do {
    try {
      $parameters = array();
      if ($pageToken) {
        $parameters['pageToken'] = $pageToken;
      }
      $children = $service->children->listChildren($folderId, $parameters);

      foreach ($children->getItems() as $child) {
        $result[] = $child->getId();
      }
      $pageToken = $children->getNextPageToken();
    } catch (Exception $e) {
      print "An error occurred: " . $e->getMessage();
      $pageToken = NULL;
    }
  } while ($pageToken);
  return $result;

}
?>