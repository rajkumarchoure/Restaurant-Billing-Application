<?php
include("../adminsession.php");
$billid = trim(addslashes($_REQUEST['billid']));
$table_id = trim(addslashes($_REQUEST['table_id']));

$count_kot_product = $cmn->getvalfield("bill_details","count(*)","table_id='$table_id' and billid='$billid' and kotid=0");
echo $count_kot_product;

?>

                               
                        
            