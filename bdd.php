<?php
const ADDRESS_MONGO = "mongodb://localhost:27017";
const API_KEY = "828e660b4e4c9f0a931a9adbe60ba348";

function insert(array $data, string $tag){
    $manager = new MongoDB\Driver\Manager(ADDRESS_MONGO);
    $bulk = new MongoDB\Driver\BulkWrite;
    foreach($data as $item){
        $itemurl = "https://farm" . $item["farm"] . ".staticflickr.com/" . $item["server"] . "/" . $item["id"] . "_" . $item["secret"] . ".jpg";
        $bulk->insert(['itemurl' => $itemurl, 'tag' => $tag]);
    }
    $manager->executeBulkWrite('flickr.images', $bulk);

}

function search(string $tag){
    $manager = new MongoDB\Driver\Manager(ADDRESS_MONGO);
    $query = new MongoDB\Driver\Query( [
        'tag' => $tag
    ] );
    $cursor = $manager->executeQuery('flickr.images', $query);

    $result = $cursor->toArray();
    if(count($result) > 1){
        return false;
    }else{
        return $result;
    }
}

/* The aggregate command can optionally return its results in a cursor instead
 * of a single result document. In this case, we can iterate on the cursor
 * directly to access those results. 
foreach ($cursor as $document) {
    var_dump($document);
}
*/
?>
