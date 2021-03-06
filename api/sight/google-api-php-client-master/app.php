<?php

date_default_timezone_set('America/Sao_Paulo');

$date = (new \DateTime())->format('Y-m-d H:i:s');

require __DIR__ . '/vendor/autoload.php';

$client = new \Google_Client();

$jsonAuth = json_encode(array(
  "type"=>"service_account",
  "project_id"=>"sight-spreadsheets",
  "private_key_id"=>"229050a154609c9a27683c3da47fd7409891e68b",
  "private_key"=>"-----BEGIN PRIVATE KEY-----\nMIIEvQIBADANBgkqhkiG9w0BAQEFAASCBKcwggSjAgEAAoIBAQDJU+DT16FmT1UJ\n+EuwJGWAdElYVq40vxF6JEjqFEtmfOai/oyXwDkXERCZ08hnvlhF5fGnMo3i0HCR\n3fLgSMfSCe4on310WfZp6ClwQJSdNPdF5QLrjg3ZySPO9sJ39Q+xDsKeC+NrwfK5\nwybyjeBbZJT87L29C0cTRo6FiZ3xezHG6/IV1UGXN5hv8kUR1QzMhImmPZPD6MNo\n/wJ+T1pBOuPPvpbqccGtO53BoRzLQbpmS0QPWjMP+NNH6cC7101wLAfsiZScmDOx\nBH3KpAzNHcFgF/5r5PAnatxLCc6jnriTnkTOTMqI3trnXWSZhfASFNC3gnhLG7DG\niMDvL9y/AgMBAAECggEAKQtpraaraAFKdALj42A4NUz/2vuo/mXpuT4Gg3ppuNZD\n6vz8Sr/Mo9A90y6jD8t1kaKEdrLOzGv0VzipmGIeIssVe8CwQfVJUGQddp4j7jzr\nIJvE0aMfXcQtAbe7A9u5PD6nHLONxN1Aj/CiUxbro5ZI7ZuSPyU6c0qSKdVZlu5K\n+AjdHqz9S6jUWhlXd//a1pw+nw1hewtPSoNe2U6FfGgznxkbbu/NcD55Ck3uIhAh\nBO5nGuxzwCeHdssp7HT1+xhoDTz8zHVaCYTN3OsgaRvFc1547cu2y+J81qR1ZC9h\nqQTUf8dkvNbS/o4lP3Df6pZqjkWWFURgxskvaZJ4OQKBgQDzWy6QhjlnnRa6QxyG\nhBHr/Qp3cfBzmBELIVDcPP1/zmu+goWXGLmM7K4Q0emobxpKzNY7WxlAHdJvLJHA\ngoxKOFPUhJGGYtzi6rBPgKLl4fLamTAFGswxeSuA1xhAHufZAP0DQ3/A+ZAL/abY\nY2i3Byr2wI5xHx2qdRxnIbwPDQKBgQDTya+GePCsppF0B10GIUBmpAArUVQ5Ug1c\nsoseGV0Q5zuXljWPNrCD/377uaWgiysTJm4dz/yv8zezNpjEldHuPJHXcZsW4J1R\n+/sFWVU4iqKCFlOq/A0abXYVjcj5hBsG4cV/TZrsZLkX4xS5XF/ze2qCfCcLgT8c\ndtMkRgLH+wKBgQC5YJUpDMY/0p9Uhfj90y9fyCMn+AiF1anuA5P4IRGuQQ08U2r2\nPaRi4Ix8TZsjbnbl0gHDt1KVz+HURGxG7Gt3wk7BjbbZWwgOZ16lQUVVvnfj41t8\nF/zCFx53h+J2PdS5LpKN4OY5lyIOsEtffOJwwioNS4N2UpCjn5BiU4VRJQKBgFZr\nN9pRQzPQDA4iawzzSIoZZZBHcWyqVJV8rVOs2dLp5+ElA9naYRCbkr84s6Lc5si7\np7c2hU9umU3he1jMIYtq37/ftX8STF+FyJoYJ7QYrdMTNTTSAK7F96c34cge5cBb\nI/GcQxkuyHA80toIHYcG1yFDc9M3+/6rZeCpSL09AoGAWGeou2lzZF/jxFg7Z1z8\nuG8s0JS0se6yu2QdNCMODD+EX3ZuckoJRC5P8C60hcaJeA1kA++823B+PPSB1YUR\n/Xeivs2r0xEJ3YJqnywUn1bRfb51I0ymQEtwzeYgAhvDHDm2lDjZcQj2as63ONIv\nHaWx6LJObYbpDSIDpzFbKYE=\n-----END PRIVATE KEY-----\n",
  "client_email"=>"sight-212@sight-spreadsheets.iam.gserviceaccount.com",
  "client_id"=>"118245365803066771882",
  "auth_uri"=>"https://accounts.google.com/o/oauth2/auth",
  "token_uri"=>"https://oauth2.googleapis.com/token",
  "auth_provider_x509_cert_url"=>"https://www.googleapis.com/oauth2/v1/certs",
  "client_x509_cert_url"=>"https://www.googleapis.com/robot/v1/metadata/x509/sight-212%40sight-spreadsheets.iam.gserviceaccount.com"

));

$client->setApplicationName('Sight Spreadsheets');
$client->setScopes([\Google_Service_Sheets::SPREADSHEETS]);
$client->setAuthConfig(json_decode($jsonAuth, true));
$client->setAccessToken('229050a154609c9a27683c3da47fd7409891e68b');

$service = new Google_Service_Sheets($client);

// $sheetInfo = $service->spreadsheets->get('1GoHiQS4MRncAJNHLKviZi7GQLPmaUOVz_EJxSW4ivqE')->getProperties();

$retrieve = $service->spreadsheets_values->get('1GoHiQS4MRncAJNHLKviZi7GQLPmaUOVz_EJxSW4ivqE', 'A2:F');
$SID = $retrieve->getValues() != null ? count($retrieve->getValues()) : 0;

$body = new Google_Service_Sheets_ValueRange([
    'values' => [
    	[$SID, $_POST['nome'], $_POST['email'], $_POST['file'], explode(' ',$date)[0], explode(' ',$date)[1]]
	    // [$SID, "ABC", "email@gmail.com", "ARQUIVO 1", explode(' ',$date)[0], explode(' ',$date)[1]]
	]
]);

$params = [
    'valueInputOption' => 'RAW'
];

$insert = $service->spreadsheets_values->append('1GoHiQS4MRncAJNHLKviZi7GQLPmaUOVz_EJxSW4ivqE', 'A2:F', $body, $params);

$result = intval($insert->updates->updatedRows);

print_r(json_encode(array('success'=>($result) ? $result : 0)));
