<?php
require_once('bdd.php');
?>
<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="utf-8">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="./style.css">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script
			  src="https://code.jquery.com/jquery-3.4.1.min.js"
			  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
			  crossorigin="anonymous"></script>
    <script type="text/javascript">
    // MDB Lightbox Init
      $(function () {
        $("#mdb-lightbox-ui").load("mdb-addons/mdb-lightbox-ui.html");
        $('.datepicker').datepicker();
      });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.8.1/baguetteBox.min.js"></script>
<script>
    baguetteBox.run('.tz-gallery');
</script>
    <title>Flick/Mongo</title>
  </head>
  <body>
    <nav class="navbar navbar-light bg-light">
      <form class="form-inline" action="" method="post">
        <input class="form-control mr-sm-2" type="search" placeholder="Rechercher" aria-label="Recherche" name="searchtag">
        <input type="date" name="date_min" placeholder="Date Min Upload">
        <input type="date" name="date_max" placeholder="Date Max Upload">
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Rechercher</button>
      </form>
    </nav>
    <div class="col-md-12">
      <div class="row">
        <div class="gal">
<?php

  function urlBuilder($tag,$date_min,$date_max){
    $url = "https://www.flickr.com/services/rest/?method=flickr.photos.search";

    $url .= "&tags=".$tag;
    if (isset($date_min)) {
      $url .= "&min_upload_date=".$date_min;
    }
    if (isset($date_max)) {
      $url .= "&max_upload_date=".$date_max;
    }
    $url .= "&format=json&nojsoncallback=1";
    if (! is_null(API_KEY)) {
      $url .= "&api_key=".API_KEY;
    }
    return $url;
  }






if (isset($_REQUEST["searchtag"])) {
  $tag = $_REQUEST["searchtag"];
  
  if(search($tag)){
    foreach(search($tag) as $item){
      ?>
      <img class="img-fluid" src="<?php echo $item['itemurl']; ?>" alt="Image">
  <?php
    }
  
  }else{
    $url = urlBuilder($tag,$_REQUEST['date_min'],$_REQUEST['date_max']);
    $result = json_decode(file_get_contents($url), true);
    insert($result["photos"]["photo"],$tag);
    foreach ($result["photos"]["photo"] as $img) {
      $imgurl = "https://farm" . $img["farm"] . ".staticflickr.com/" . $img["server"] . "/" . $img["id"] . "_" . $img["secret"] . ".jpg";
      ?>
          <img class="img-fluid" src="<?php echo $imgurl; ?>" alt="Image">
      <?php
    }

  }
}

?>
</div>
</div>
</div>
</body>
</html>