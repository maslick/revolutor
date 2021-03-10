<?php

require_once('vendor/autoload.php');

$ROOT_PATH = getcwd();
$path2token = $ROOT_PATH.'/token/revolut_token.json';
$path2refresh_token = $ROOT_PATH.'/token/revolut_refresh.json';

function aToken(): array
{
    global $path2token;
    $contents = @file_get_contents($path2token);
    if ($contents === false) {
        return [
            'token'=> '',
            'expires' => ''
        ];
    }
    $token = json_decode($contents);
    return [
        'token'=> $token->access_token,
        'expires' => $token->expires
    ];
}

function rToken(): array
{
    global $path2refresh_token;
    $contents = @file_get_contents($path2refresh_token);
    if ($contents === false) {
        return [
            'token'=> '',
            'expires' => ''
        ];
    }
    $token = json_decode($contents);
    return [
        'token'=> $token->refresh_token,
        'expires' => $token->expires
    ];
}

$access_token  = aToken();
$refresh_token = rToken();

$fetchToken        = function () use ($access_token) { return $access_token['token']; };
$fetchTokenExpires = function () use ($access_token) { return $access_token['expires']; };

$fetchRefreshToken        = function () use ($refresh_token) { return $refresh_token['token']; };
$fetchRefreshTokenExpires = function () use ($refresh_token) { return $refresh_token['expires']; };

$saveAccessTokenCb = function ($access_token, $expires) use ($path2token) {
    file_put_contents($path2token, json_encode(['access_token' => $access_token, 'expires' => $expires]));
};

$saveRefreshTokenCb = function ($refresh_token, $expires) use ($path2refresh_token) {
    file_put_contents($path2refresh_token, json_encode(['refresh_token' => $refresh_token, 'expires' => $expires]));
};


$params = [
	'apiUrl' => getenv("API_URL"),
	'clientId' => getenv("REVOLUT_CLIENT_ID"),
	'privateKey' => getenv("REVOLUT_PRIVATE_KEY"),
    'redirectUri' => getenv("REDIRECT_URL"),
    'accessToken' => $fetchToken(),
    'accessTokenExpires' => $fetchTokenExpires(),
    'refreshToken' => $fetchRefreshToken(),
    'refreshTokenExpires' => $fetchRefreshTokenExpires(),
    'saveAccessTokenCb' => $saveAccessTokenCb,
    'saveRefreshTokenCb' => $saveRefreshTokenCb,
	'logError' => function ($error){mail('pavel.masloff@gmail.com', 'Revolut API Error', $error);}
];

$revolut = new \ITSOFT\Revolut\Revolut($params);