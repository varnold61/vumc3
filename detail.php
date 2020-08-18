<?php
include "gitHubRepo.php";
include "dbHandler.php";
$repo_id = 0;
if(isset($_REQUEST['repo_id'])) {
    $repo_id = $_REQUEST['repo_id'];
    $pdo = new dbHandler();
    $rec = gitHubRepo::getItem($pdo->getDbh(), $repo_id);
    if($rec) {
        $rec= (object) $rec; //i prefer workig with objects
    }
}
// if we are here, we received repo data

?>
<html>
<head>
    <title>Virginia's PHP Demo Project - Detail View</title>
    <!-- jquery includes -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css"></link>

    <!-- my  includes -->
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

</head>
<body>
<div class="container">
<h1>Detail for repo  <?php echo $rec->name ?></h1>
    <br>
<?php
    foreach ($rec as $key=>$val) {
  ?>
        <div class="row"><div class="col"><?php echo strtoupper($key)  . ': ' . $val?></div></div>
        <div class="row">&nbsp;</div>

 <?php   } ?>

</div>
</body>
</html>


