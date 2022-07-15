<h1 align="center">:trophy: EScore.gg API</h1>
<h3 align="center">Unofficial API for <a href="https://www.escore.gg" target="_blank">escore.gg</a> written on PHP</h3>
<p align="center">
    <img alt="Made with PHP" src="https://img.shields.io/badge/Made%20with-PHP-%23FFD242?logo=php&logoColor=white">
    <img alt="Repo size" src="https://img.shields.io/github/repo-size/destyk/escore-api-php">
    <img alt="issues" src="https://img.shields.io/github/issues/destyk/escore-api-php">
    <img alt="Downloads" src="https://img.shields.io/packagist/dt/destyk/escore-api-php?label=downloads&logo=Packagist&logoColor=white">
    <img alt="Downloads" src="https://img.shields.io/github/downloads/destyk/escore-api-php/total?color=orange&label=downloads&logo=GitHub">
</p>

## :key: Library installation
You can install this library using composer: 

   ```sh
   composer require destyk/escore-api-php
   ```

## :memo: Using this library
```php
require('vendor/autoload.php');

use DestyK\EScore\Signature;
use DestyK\EScore\API;
use DestyK\EScore\RequestException;

try {
    $signature = new Signature();
    $api = new API($signature);
    
    // There will be an array with data about ALL UPCOMING matches
    $response = $api->getUpcoming();
    
    ...
    
    // There will be an array with data about CSGO UPCOMING matches
    $response = $api->getUpcoming([
        'gameType' => 3
    ]);
} catch(RequestException $e) {
    echo $e->getMessage();
}
```
## :open_file_folder: Available Methods

#### :pushpin: Method ```$api->getUpcoming(array $body, array $query)```

Returns a list of upcoming matches:<br>
```php
...
// There will be an array with data about ALL UPCOMING matches
$response = $api->getUpcoming();

// There will be an array with data about CSGO UPCOMING matches
$response = $api->getUpcoming([
    'gameType' => 3
]);

```
Returns an object of class `\DestyK\EScore\RequestException` on error.

#### :pushpin: Method ```$api->getLive(array $body, array $query)```

Returns a list of matches that have already started:<br>
```php
...
// There will be an array with data about ALL LIVE matches
$response = $api->getLive();

// There will be an array with data about DOTA 2 LIVE matches
$response = $api->getLive([
    'gameType' => 4
]);

```
Returns an object of class `\DestyK\EScore\RequestException` on error.

#### :pushpin: Method ```$api->getFinished(array $body, array $query)```

Returns a list of matches that have already started:<br>
```php
...
// There will be an array with data about ALL FINISHED matches
$response = $api->getFinished();

// There will be an array with data about LOL FINISHED matches
$response = $api->getFinished([
    'gameType' => 1
]);

```
Returns an object of class `\DestyK\EScore\RequestException` on error.

## :open_file_folder: Games id's
ALL - `0`<br>
CS:GO - `3`<br>
Dota 2 - `4`<br>
LOL - `1`
