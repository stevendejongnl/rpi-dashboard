<?

// Allow from any origin
//if (isset($_SERVER['HTTP_ORIGIN'])) {
    // Decide if the origin in $_SERVER['HTTP_ORIGIN'] is one
    // you want to allow, and if so:
//    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
//    header('Access-Control-Allow-Credentials: true');
//    header('Access-Control-Max-Age: 86400');    // cache for 1 day
//}

error_reporting(E_ALL);
ini_set('display_errors', 'on');

require 'vendor/autoload.php';

session_start();

$api = new SpotifyWebAPI\SpotifyWebAPI();

// Fetch the saved access token from somewhere. A database for example.
$api->setAccessToken($_SESSION['accessToken']);

$data = null;
if (isset($api)) {
    if (isset($_GET['next'])) $api->next();
    if (isset($_GET['previous'])) $api->previous();

    $data = (object) [
        'user' => (object) [
            'name' => $api->me()->display_name,
            'image' => $api->me()->images[0]->url
        ],
        'current' => (object) [
            'is_playing' => $api->getMyCurrentTrack()->is_playing,
            'item' => (object) [
                'name' => $api->getMyCurrentTrack()->album->name,
                'artists' => $api->getMyCurrentTrack()->album->artists,
                'images' => $api->getMyCurrentTrack()->album->images
            ]
        ]
    ];
}

return json_encode($data);
