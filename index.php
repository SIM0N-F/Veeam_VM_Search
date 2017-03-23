<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Veeam Backup Search</title>
  <style>
    body {
      font-size: 1.3em;
      text-align: center;
      line-height: 20px;
    }

    #row {
      display: flex;
      width: 50%;
      margin-left: auto;
      margin-right: auto;
    }

    #col0 {
      width: 60%;
      text-align: left;
    }

    #col1 {
      width: 20%;
      text-align: center;
    }

    #col2 {
      width: 20%;
      text-align: right;
    }

	  form {
	    min-height: 200px;
	  }
  </style>
</head>

<body>
  <center>
  <form action="index.php" method="POST">
    <input style="width:600px; height:60px; font-size: 2em; vertical-align:middle;" type="text" name="mot" value=""/><input style="vertical-align:middle; height:60px;" border=0 src="./search.png" type=image name="valider"/>
  </form>
  </center>
  <br>

  <div id=row><div id=col0>Machine Virtuelle</div><div id="col1">Serveur VEEAM</div><div id="col2">Status</div></div>
  <hr width='100%' size='2' color=#27ae60><br>

<?php
  $filename = "vm.txt";

  if($_POST['mot'] == NULL) {
    $_POST['mot'] = "SRV";
  }

  $resultats = array();

  $fp = @fopen($filename, 'r');

  if ($fp) {
    while (($buffer = fgetss($fp, 4096)) !== false) {
      if (preg_match('|' . $_POST['mot'] . '|i', $buffer)) {
	    $resultats[] = $buffer;
      }
	}
    if (!feof($fp)) {
      echo "Erreur: fgets() a échoué\n";
	  }
  }

  fclose($fp);

  $nb = count($resultats);

  if ($nb > 0) {
    foreach ($resultats as $v) {
      $array = explode(" ", $v);
      echo '<div id="row"><div id="col0">' .$array[0]. '</div><div id="col1">' .$array[1]. '</div><div id="col2">' .$array[2]. '</div></div><hr width="50%" size="1" color=#27ae60>';
  }
    echo $nb. 'Machine virtuelles';
  }
  else {
    die("Cherchez encore !");
  }

  if (file_exists($filename)) {
    echo "<br> Last update: " . date ("m d Y", filemtime($filename)) . "<br>";
  }

  ?>
</body>
</html>
