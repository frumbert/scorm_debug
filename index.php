<?php

function delTree($dir) {
    $files = array_diff(scandir($dir), array('.','..'));
        foreach ($files as $file) {
            if (is_dir("$dir/$file")) {
                delTree("$dir/$file");
            } else {
                unlink("$dir/$file");
            }
        }
    return rmdir($dir);
}

if (isset($_GET["delink"])) {
    $unlink = $_GET["delink"];
    delTree( __DIR__ . "/$unlink" );
    $path = getcwd();
    $zip = $path . '/' . $unlink . '.zip';
    if (file_exists($zip)) {
        unlink($zip);
    }
    header("location: index.php");
    die();
}

if (isset($_GET["unlink"])) {
    $unlink = $_GET["unlink"];
    delTree( __DIR__ . "/$unlink" );
    header("location: index.php");
    die();
} ?><!doctype html>
<html>
    <head>
        <style>
        * {
            font-family: sans-serif;
        }

        th {
            text-align: left;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid #eee;
            padding: 10px;
        }

        tbody tr:nth-of-type(odd) td {
            background-color: #eee;
        }

        th:first-of-type {
            width: 50%;
        }
        </style>
    </head>
    <body>
        <h1>Course Scorm Debug</h1>
        <table>
            <thead><tr><th>Folder</th><th>Scorm 1.2</th><th>Scorm 2004</th><th>Remove?</th></tr></thead>
            <tbody>
<?php
$target = '.';

// extract all zip files
$path = getcwd();
$filelist = glob("$path/*.zip");
foreach($filelist as $file) {
    $fold = $path . "/" . basename($file, ".zip");
    if (!file_exists($fold)) {
      $zipArchive = new ZipArchive();
      $result = $zipArchive->open($file);
      if ($result === TRUE) {
          $zipArchive->extractTo($path . "/" . basename($file, ".zip"));
          $zipArchive->close();
          // unlink($file);
      }
    }
}

// list all packages that have scorm
//TODO: fix - read manifest to get start page
$directories = array_diff(scandir($target), array('..', '.', '.git','2012','2013','2014','2015','2016','2017','2018','2019','2020')); // cheaty but works
natcasesort($directories);
foreach ($directories as $value) {
    if (is_dir($target . '/' . $value)) {
        $t = preg_replace("/[^a-zA-Z]/", "", $value);

        if (file_exists("$value/imsmanifest.xml")) {

            $manifest = file_get_contents("$value/imsmanifest.xml");
            $manifest = str_replace("adlcp:", "", $manifest); // imscp packages may have un-namespaced prefixes
            $xmlDoc = simplexml_load_string ($manifest);
            $i = $value . "/" . $xmlDoc->resources[0]->resource[0]->attributes()->href;

            // $xmlDoc = new SimpleXmlElement($manifest);
            // foreach($xmlDoc->getDocNamespaces() as $strPrefix => $strNamespace) {
            //    if(strlen($strPrefix)==0) {
            //        $strPrefix="a"; //Assign an arbitrary namespace prefix.
            //    }
            //    $xmlDoc->registerXPathNamespace($strPrefix,$strNamespace);
            // }

        } else {

            if (file_exists($value . "/SCO1/index.html")) {
                $i = $value . "/SCO1/index.html";
            } else if (file_exists($value . "/SCO1/en-us/Content.html")) {
                $i = $value . "/SCO1/en-us/Content.html";
            } else if (file_exists($value . "/index.html")) {
                $i = $value . "/index.html";
            } else if (file_exists($value . "/launch.html")) {
                $i = $value . "/launch.html";
            } else {
                $i = $value . "/";
            }

        }
        echo "<tr><td>$value</td>";
        echo "<td><a href='12.php?$i' target='sco12$t'>Launch</a></td>";
        echo "<td><a href='2004.html?&sco=$i' target='sco2004$t'>Launch</a></td>";
        echo "<td><a href='index.php?unlink=" . urlencode($value) . "'>Delete</a> (<a href='index.php?delink=" . urlencode($value) . "'>+ Zip</a>)</td>";
        echo "</tr>";
    }
}
?>
        </tbody></table>
    </body></html>
