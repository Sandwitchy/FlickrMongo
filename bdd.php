<?php
const ADDRESS_MONGO = "mongodb://localhost:27017";
const API_KEY = "828e660b4e4c9f0a931a9adbe60ba348";

function insert(array $data, string $tag,  $date_min, $date_max){
    $manager = new MongoDB\Driver\Manager(ADDRESS_MONGO);
    $bulk = new MongoDB\Driver\BulkWrite;
    foreach($data as $item){
        $itemurl = "https://farm" . $item["farm"] . ".staticflickr.com/" . $item["server"] . "/" . $item["id"] . "_" . $item["secret"] . ".jpg";
        $bulk->insert(['itemurl' => $itemurl, 'tag' => $tag,'date_min' => $date_min,'date_max' => $date_max ]);
    }
    $manager->executeBulkWrite('flickr.images', $bulk);
}

function search(string $tag,$date_min = null,$date_max = null){
    try{
        $manager = new MongoDB\Driver\Manager(ADDRESS_MONGO);
        $array = array( 'tag' => $tag);
        if((isset($date_min)) && ($date_min !== null) && ($date_min !== "")){
            $array = array_push($array,array('date_min' => $date_min));
        }
        if((isset($date_max)) && ($date_max !== null) && ($date_max !== "")){
            $array = array_push($array,array('date_max' => $date_max));
        }
        $query = new MongoDB\Driver\Query($array);
        $cursor = $manager->executeQuery('flickr.images', $query);
    
        $result = $cursor->toArray();
        if(count($result) > 1){
            return false;
        }else{
            return $result;
        }
    }catch(Exception $e){
        print($e);
        die();
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
