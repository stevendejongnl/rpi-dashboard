<?

// Allow from any origin
//var_dump($_SERVER['HTTP_ORIGIN']);
//if (isset($_SERVER['HTTP_ORIGIN'])) {
//    // Decide if the origin in $_SERVER['HTTP_ORIGIN'] is one
//    // you want to allow, and if so:
//    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
//    header('Access-Control-Allow-Credentials: true');
//    header('Access-Control-Max-Age: 86400');    // cache for 1 day
//}

header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: content-type');
header('Content-Type: application/json');

error_reporting(E_ALL);
ini_set('display_errors', 'on');

ini_set('xdebug.var_display_max_depth', '10');
ini_set('xdebug.var_display_max_children', '256');
ini_set('xdebug.var_display_max_data', '1024');

require 'vendor/autoload.php';

$credentialsFile = file_get_contents('./credentials.json');
$credentials = json_decode($credentialsFile);

$api = new SpotifyWebAPI\SpotifyWebAPI();

// Fetch the saved access token from somewhere. A database for example.
$api->setAccessToken($credentials->accessToken);

$errors = (object)[
    'spotify' => []
];

try {
    $user = $api->me();
} catch (Exception $e) {
    if ($e->getCode() === 401) {
        header('location: ./auth.php');
        exit;
    } else {
        array_push($errors->spotify, (object)[
            'user' => $e->getCode()
        ]);
    }
}

try {
    $track = $api->getMyCurrentTrack();
} catch (Exception $e) {
    array_push($errors->spotify, (object)[
        'track' => $e->getCode()
    ]);
}

try {
    $devices = $api->getMyDevices();
} catch (Exception $e) {
    array_push($errors->spotify, (object)[
        'devices' => $e->getCode()
    ]);
}

if (!empty($errors->spotify)) {
    echo json_encode($errors);
    exit;
}

$request_body = file_get_contents('php://input');
$post_data = json_decode($request_body);

if (isset($post_data->action) && $post_data->action == 'previous')
    if (isset($devices->devices[0]->is_active) && $devices->devices[0]->is_active) $api->previous();

if (isset($post_data->action) && $post_data->action == 'next')
    if (isset($devices->devices[0]->is_active) && $devices->devices[0]->is_active) $api->next();

if (isset($post_data->action) && $post_data->action == 'togglePlay') {
    if (isset($devices->devices[0]->is_active) && $devices->devices[0]->is_active && isset($track->is_playing)) {
        $api->pause();
    } else if (isset($devices->devices[0]->is_active) && $devices->devices[0]->is_active) {
        $api->play(
//            $devices->devices[0]->id
//                    , [
//                    'uris' => [$track->item->uri],
//                ]
        );
//
//        // Without Device ID
//        $api->play(false, [
//            'uris' => [$track->item->uri],
//        ]);
    }
}

$user = [
    'user' => (object)[
        'name' => $user->display_name,
        'image' => $user->images[0]->url,
        'data' => $user
    ]
];

if (isset($track->is_playing)) {
    $track = [
        'track' => (object)[
            'is_playing' => $track->is_playing,
            'item' => (object)[
                'id' => $track->item->id,
                'name' => $track->item->name,
                'artists' => $track->item->artists,
                'images' => $track->item->album->images
            ],
            'data' => $track->item
        ]
    ];
} else {
    $track = [
        'track' => (object)[
            'is_playing' => false
        ]
    ];
}

if (!empty($devices)) {
    $devices = [
        'devices' => (object)$devices->devices
    ];
}

$data = array_merge($user, $track, $devices);
echo json_encode($data);
exit;
