<?php

}

function search(string $tag){
    $manager = new MongoDB\Driver\Manager('mongodb://localhost:27017');
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