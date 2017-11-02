<?php

require 'vendor/autoload.php';
require 'creds.inc';

date_default_timezone_set('UTC');

use Aws\DynamoDb\DynamoDbClient;

$client = DynamoDbClient::factory(array(
    'key' => DYNKEY,
	'secret' => DYNSECRET,
    'region'  => 'us-west-2',
	'version' => '2012-08-10',
  'endpoint' => 'http://localhost:8000'
));
$client->deleteTable(array(
  'TableName' => 'Songs'
));
$client->createTable(array(
  'TableName' => 'Songs',
  'AttributeDefinitions' => array(
    array(
      'AttributeName' => 'SongID',
      'AttributeType' => 'N'
    ),
    array(
      'AttributeName' => 'Title',
      'AttributeType' => 'S'
    )
  ),
  'KeySchema' => array(
    array(
      'AttributeName' => 'SongID',
      'KeyType' => 'HASH'
    ),
    array(
      'AttributeName' => 'Title',
      'KeyType' => 'RANGE'
    )
  ),
  'ProvisionedThroughput' => array(
    'ReadCapacityUnits' => 5,
    'WriteCapacityUnits' => 5
  )
));
$result = $client->putItem(array(
  'TableName' => 'Songs',
  'Item' => array(
    'SongID' => array('N' => '1'),
    'Title' => array('S' => 'Microphone Singer'),
    'Artist' => array('S' => 'Jakob'),
    'Album' => array('S' => 'My Best')
  )
));
$result = $client->putItem(array(
  'TableName' => 'Songs',
  'Item' => array(
    'SongID' => array('N' => '2'),
    'Title' => array('S' => 'Favorite Song'),
    'Artist' => array('S' => 'Jakob'),
    'Album' => array('S' => 'My Best')
  )
));
/*
//Query is a way to retrieve an individual item
$result = $client->getItem(array(
  'ConsistenRead' => false,
  'TableName' => 'Songs',
  'Key' => array(
    'SongID' => array('N' => '1'),
    'Title' => array('S' => 'Microphone Singer')
  )
));
print $result['Item']['Artist']['S'] . "\n";
*/

//Scan is a way to retrieve multiple items
$iterator = $client->getIterator('Scan', array(
  'TableName' => 'Songs',
  'KeyConditions' => array(
    'SongID' => array(
      'AttributeValueList' => array(
        array('N' => '0'),
      ),
      'ComparisonOperator' => 'GT'
    )
  )
));

//Assumes that "Album" has been set for each item
foreach ($iterator as $item) {
  print $item['Album']['S'] . ": " . $item['Title']['S'] . "\n";
}


?>
