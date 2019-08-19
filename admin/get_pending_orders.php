<?php
include("../adminsession.php");


$sqlgetorders=mysql_query("select * from bills where is_completed = 0 order by billid");
while($rowgetorders=mysql_fetch_assoc($sqlgetorders))
				{
					
					//echo $count_product;
					$billnumber = $rowgetorders['billnumber'];
					$is_completed = $rowgetorders['is_completed'];
					//href="?billnumber=<?php echo $billnumber; 
					
				?>
                	<a onClick="changestatus('<?php echo $rowgetorders['billid']; ?>','<?php echo $rowgetorders['is_completed']; ?>')" class="btn <?php if($is_completed == 1) {?> 
                    btn-success <?php } else { ?> btn-warning <?php } ?>" /> <?php echo ucwords($billnumber); ?> </a>
                   <?php } ?>
                   
                   
                   
                   <?php
				   $currdate = date('Y-m-d');
				   $count_product = $cmn->getvalfield("bills","count(*)","is_completed='1' and billdate='$currdate'");
                   ?>
               <span style="float:right;"><code>Total Completed Orders: <?php echo $count_product; ?></code></span>   
               

