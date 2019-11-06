<?php
require_once('bdd.php');
?>
<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="utf-8">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="/style .css">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script type="text/javascript">
    // MDB Lightbox Init
      $(function () {
      $("#mdb-lightbox-ui").load("mdb-addons/mdb-lightbox-ui.html");
      });
    </script>
    <title>Flick/Mongo</title>
  </head>
  <body>
    <nav class="navbar navbar-light bg-light">
      <form class="form-inline" action="" method="post">
        <input class="form-control mr-sm-2" type="search" placeholder="Rechercher" aria-label="Recherche" name="searchtag">
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Rechercher</button>
      </form>
    </nav>
    <div class="gallery" id="gallery">
<?php
if (isset($_REQUEST["searchtag"])) {
  $tag = $_REQUEST["searchtag"];
  $url = "https://www.flickr.com/services/rest/?method=flickr.photos.search&api_key=28984d098e9946c2c42b87eac57a678b&tags=". $tag ."&min_upload_date=&max_upload_date=&safe_search=&format=json&nojsoncallback=1";
 /* if(search($tag)){
    print('fdsfjksdfs');
  }else{
    print('hello');
  }*/
  $result = json_decode(file_get_contents($url), true);
  insert($result["photos"]["photo"],$tag);
  foreach ($result["photos"]["photo"] as $img) {
    $imgurl = "https://farm" . $img["farm"] . ".staticflickr.com/" . $img["server"] . "/" . $img["id"] . "_" . $img["secret"] . ".jpg";
    ?>
      <div class="col-md-4">
        <img class="img-fluid" src="<?php echo $imgurl; ?>" alt="Card image cap">
      </div>
    <?php
  }
}

?>
</div>
</body>
</html>