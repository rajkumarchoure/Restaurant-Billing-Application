<div class="leftpanel">
    	
        <div class="logopanel">
        	<h1><a href="index.php"><?php echo $cmn->getvalfield("company_setting","comp_name","1=1"); ?></a></h1>
        </div><!--logopanel-->
        
        <div class="datewidget">Today is <?php echo date('l M d, Y h:ia'); ?> </div>
    
    	<div class="searchwidget">
        	<form action="" method="post">
            	<div class="input-append">
                    <input type="text" class="span2 search-query" placeholder="Search here...">
                    <button type="submit" class="btn"><span class="icon-search"></span></button>
                </div>
            </form>
        </div><!--searchwidget-->
        
        <!--<div class="plainwidget">
        	<small>Using 16.8 GB of your 51.7 GB </small>
        	<div class="progress progress-info">
                <div class="bar" style="width: 20%"></div>
            </div>
            <small><strong>38% full</strong></small>
        </div>--><!--plainwidget-->
<?php 
$sqlgettable1=mysql_query("select * from m_table order by table_id");
$rowgettable1=mysql_fetch_assoc($sqlgettable1);
$tableno1=$rowgettable1['table_id'];
 ?>
        
        <div class="leftmenu">        
            <ul class="nav nav-tabs nav-stacked" id="mymenu">
            	
              <li <?php if($pagename == "index.php") { ?>class="active" <?php } ?>><a href="index.php"><span class="icon-align-justify"></span>Dashboard</a></li>
                <li <?php if($pagename == "master_unit.php") { ?>class="active" <?php } ?>><a href="master_unit.php"><i class="icon-user"></i>
                  &nbsp;&nbsp;&nbsp;
                 Add Unit</a></li> 
                 
                 <li <?php if($pagename == "master_add_table.php") { ?>class="active" <?php } ?>><a href="master_add_table.php"><i class="icon-user"></i>
                  &nbsp;&nbsp;&nbsp;
                 Add Table</a></li> 
                              
                 <li <?php if($pagename == "master_pcat.php") { ?>class="active" <?php } ?>><a href="master_pcat.php"><i class="icon-user"></i>&nbsp;&nbsp;&nbsp;
                 Menu Heading </a></li>
                  <li <?php if($pagename == "master_product.php") { ?>class="active" <?php } ?>><a href="master_product.php"><i class="icon-user"></i>
                  &nbsp;&nbsp;&nbsp;
                Menu Item </a></li>
                <li <?php if($pagename == "in-entry.php") { ?>class="active" <?php } ?>><a href="in-entry.php?table_id=<?php echo $tableno1; ?>"><i class="icon-user"></i>&nbsp;&nbsp;&nbsp;
                Bill Entry</a></li>
                <li <?php if($pagename == "bill_report_list.php") { ?>class="active" <?php } ?>><a href="bill_report_list.php"><i class="icon-user"></i>&nbsp;&nbsp;&nbsp;
                Bill List</a></li>
                
                <li class="dropdown  <?php if($pagename == "master_expanse_group.php" || $pagename == "expanse.php") { ?>active <?php } ?>"><a href="#"><span class="icon-pencil"></span> Expenses</a>
                	<ul <?php if($pagename == "master_expanse_group.php" || $pagename == "expanse.php") { ?>style="display: block"  <?php } ?>>
                    	<li><a href="master_expanse_group.php">Expense Head</a></li>
                        <li><a href="expanse.php">Expense Entry</a></li>
                    </ul>
                </li>
               <li <?php if($pagename == "company_setting.php") { ?>class="active" <?php } ?>><a href="company_setting.php"><i class="icon-home"></i>
                  &nbsp;&nbsp;&nbsp;
                 Company Setting </a></li> 
                 
                  <li <?php if($pagename == "tax_setting.php") { ?>class="active" <?php } ?>><a href="tax_setting.php"><i class="icon-home"></i>
                  &nbsp;&nbsp;&nbsp;
                 Tax Setting</a></li> 
                 
                <li <?php if($pagename == "master_user.php") { ?>class="active" <?php } ?>><a href="master_user.php"><i class="icon-home"></i>
                  &nbsp;&nbsp;&nbsp;
                Add User	</a></li>
               
                <li class="dropdown  <?php if($pagename == "bill_report_list.php" || $pagename == "payment_receiving.php" || $pagename == "expanse_report.php") { ?>active <?php } ?>"><a href="#"><span class="icon-pencil"></span> Report</a>
                	<ul <?php if($pagename == "bill_report_list.php" || $pagename == "expanse_report.php") { ?>style="display: block"  <?php } ?>>
                    	<li><a href="bill_report_list.php">Bill Wise Sale Report</a></li>
                         <li><a href="payment_receiving.php">Daywise Payment Receiving Report</a></li>
                        <li><a href="product_wise_report.php">Product Wise Sale Report</a></li>
                        <!-- <li><a href="daywise_sale_report.php">Day Wise Sale Report</a></li>-->
                        <li><a href="expanse_report.php">Expanse Report</a></li>
                        <!--   <li><a href="daywise_expanse_report.php">Day Wise Expanse Report</a></li>-->
                        <!--  <li><a href="wizards.html">Change Password</a></li>-->
                    </ul>
                </li>
                
                 
                <li <?php if($pagename == "changepassword.php" ) { ?>class="active" <?php } ?>><a href="changepassword.php"><i class="icon-user"></i>
                &nbsp;&nbsp;&nbsp;	
                 Change Password</a></li>
                 
                 
               
      
                  
            </ul>
            
        </div><!--leftmenu-->
        
    </div>