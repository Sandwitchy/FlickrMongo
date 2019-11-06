<?php

/***************************************
------------------------------------------------
ADDRESSE DE CONNECTION AU SERVEUR MONGO
------------------------------------------------
*******************************************/
$ADDRESS_MONGO = "mongodb://localhost:27017";


function insert(array $data, string $tag){
    $manager = new MongoDB\Driver\Manager($ADDRESS_MONGO);
    $bulk = new MongoDB\Driver\BulkWrite;
    foreach($data as $item){
        $itemurl = "https://farm" . $item["farm"] . ".staticflickr.com/" . $item["server"] . "/" . $item["id"] . "_" . $item["secret"] . ".jpg";
        $bulk->insert(['itemurl' => $itemurl, 'tag' => $tag]);
    }
    $manager->executeBulkWrite('flickr.images', $bulk);

}

function search(string $tag){
    $manager = new MongoDB\Driver\Manager($ADDRESS_MONGO);
    $query = new MongoDB\Driver\Query( [
        'tag' => $tag
    ] );
    $cursor = $manager->executeCommand('flickr  ', $command);


    return $cursor->toArray()[0]?$cursor->toArray()[0]:null;
}
/*
$command = new MongoDB\Driver\Command([
    'aggregate' => 'collection',
    'pipeline' => [
        ['$group' => ['_id' => '$y', 'sum' => ['$sum' => '$x']]],
    ],
    'cursor' => new stdClass,
]);
$cursor = $manager->executeCommand('db', $command);

/* The aggregate command can optionally return its results in a cursor instead
 * of a single result document. In this case, we can iterate on the cursor
 * directly to access those results. 
foreach ($cursor as $document) {
    var_dump($document);
}
*/
?>