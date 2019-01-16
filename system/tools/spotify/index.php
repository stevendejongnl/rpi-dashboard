<?

header("Access-Control-Allow-Origin: *");

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
