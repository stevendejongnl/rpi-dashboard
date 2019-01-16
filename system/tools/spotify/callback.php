<?

header("Access-Control-Allow-Origin: *");

error_reporting(E_ALL);
ini_set('display_errors', 'on');

require 'vendor/autoload.php';

$session = new SpotifyWebAPI\Session(
    '20fae484af58479eb2c9ac47c3b6f64f',
    '3c4b82f863974efcb7046e1013921caf',
    'http://86.90.190.118/system/tools/spotify/callback.php'
);

// Request a access token using the code from Spotify
$session->requestAccessToken($_GET['code']);

session_start();
$_SESSION['accessToken'] = $session->getAccessToken();
$_SESSION['refreshToken'] = $session->getRefreshToken();

// Store the access and refresh tokens somewhere. In a database for example.

// Send the user along and fetch some data!
header('Location: index.php');
die();
