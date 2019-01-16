<?

error_reporting(E_ALL);
ini_set('display_errors', 'on');

require 'vendor/autoload.php';

$session = new SpotifyWebAPI\Session(
    '20fae484af58479eb2c9ac47c3b6f64f',
    '3c4b82f863974efcb7046e1013921caf',
    'http://86.90.190.118/system/tools/spotify/callback.php'
);

$api = new SpotifyWebAPI\SpotifyWebAPI();

if (isset($_GET['code'])) {
    $session->requestAccessToken($_GET['code']);
    $api->setAccessToken($session->getAccessToken());

    var_dump($api->me());
} else {
    $options = [
        'scope' => [
            'playlist-read-private', // Read access to user's private playlists.
			'user-modify-playback-state', // Write access to a user’s playback state
			'user-top-read', // Read access to a user's top artists and tracks.
			'user-read-recently-played', // Read access to a user’s recently played tracks.
			'user-read-currently-playing', // Read access to a user’s currently playing track
			'playlist-modify-private', // Write access to a user's private playlists.
			'app-remote-control', // Remote control playback of Spotify. This scope is currently available to Spotify iOS and Android App Remote SDKs.
			'playlist-modify-public', // Write access to a user's public playlists.
			'user-read-birthdate', // Read access to the user's birthdate.
			'user-read-playback-state', // Read access to a user’s player state.
			'user-follow-read', // 	Read access to the list of artists and other users that the user follows.
			'user-read-email', // Read access to user’s email address.
			'streaming', // Control playback of a Spotify track. This scope is currently available to Spotify Playback SDKs, including the iOS SDK, Android SDK and Web Playback SDK. The user must have a Spotify Premium account.
			'playlist-read-collaborative', // Include collaborative playlists when requesting a user's playlists.
			'user-library-modify', // Write/delete access to a user's "Your Music" library.
			'user-read-private', // Read access to user’s subscription details (type of user account).
			'user-follow-modify', // Write/delete access to the list of artists and other users that the user follows.
			'user-library-read' // Read access to a user's "Your Music" library.
        ],
    ];

    header('Location: ' . $session->getAuthorizeUrl($options));
    die();
}
