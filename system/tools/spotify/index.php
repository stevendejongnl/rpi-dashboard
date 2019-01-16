<?

// Allow from any origin
//if (isset($_SERVER['HTTP_ORIGIN'])) {
    // Decide if the origin in $_SERVER['HTTP_ORIGIN'] is one
    // you want to allow, and if so:
//    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
//    header('Access-Control-Allow-Credentials: true');
//    header('Access-Control-Max-Age: 86400');    // cache for 1 day
//}

header('Access-Control-Allow-Origin: *');

header('Access-Control-Allow-Methods: GET, POST');

header("Access-Control-Allow-Headers: X-Requested-With");

error_reporting(E_ALL);
ini_set('display_errors', 'on');

require 'vendor/autoload.php';

session_start();

$api = new SpotifyWebAPI\SpotifyWebAPI();

// Fetch the saved access token from somewhere. A database for example.
$api->setAccessToken($_SESSION['accessToken']);

// It's now possible to request data about the currently authenticated user
var_dump(
    $api->me()
);

// Getting Spotify catalog data is of course also possible
var_dump(
    $api->getMyCurrentTrack()
);

if (isset($_GET['next'])) $api->next();
if (isset($_GET['previous'])) $api->previous();
