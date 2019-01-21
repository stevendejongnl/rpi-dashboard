<?

$environment = 'development';
$allowOrigin = explode(',', 'development,http://localhost,http://localhost:3000,http://local.rpi3,http://86.90.190.118');
$httpOrigin  = null;
if (empty($_SERVER['HTTP_ORIGIN']) === true) {
    if ($environment === 'development') {
        $httpOrigin = 'development';
    }
} else {
    $httpOrigin = $_SERVER['HTTP_ORIGIN'];
}

if (isset($allowOrigin) === true && empty($allowOrigin) === false && in_array($httpOrigin, $allowOrigin) === true) {
    header("Access-Control-Allow-Origin: $httpOrigin");
}

error_reporting(E_ALL);
ini_set('display_errors', 'on');

require 'vendor/autoload.php';

$redirectUri = 'http://86.90.190.118/system/tools/spotify/callback.php';
if ($_SERVER['HTTP_HOST'] == 'local.rpi3') {
    $redirectUri = 'http://local.rpi3/system/tools/spotify/callback.php';
}

$session = new SpotifyWebAPI\Session(
    '20fae484af58479eb2c9ac47c3b6f64f',
    '3c4b82f863974efcb7046e1013921caf',
    $redirectUri
);

// Request a access token using the code from Spotify
$session->requestAccessToken($_GET['code']);

$credentialsFile = file_get_contents('./credentials.json');
$credentials = json_decode($credentialsFile);
$credentials->accessToken = $session->getAccessToken();
$credentials->refreshToken = $session->getRefreshToken();
$credentialsNewFile = json_encode($credentials);
file_put_contents('./credentials.json', $credentialsNewFile);

// Send the user along and fetch some data!
header('Location: index.php');
die();
