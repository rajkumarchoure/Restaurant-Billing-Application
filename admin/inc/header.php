	<div class="headerpanel">
        	<a href="#" class="showmenu"></a>
            
            <div class="headerright">
            	<div class="dropdown notification">
                    <a class="dropdown-toggle" data-toggle="dropdown" data-target="#" href="http://themetrace.com/page.html">
                    	<span class="iconsweets-globe iconsweets-white"></span>
                    </a>
                    <ul class="dropdown-menu">
                    	<li class="nav-header"><img src="../img/ts.png" width="250"/></li>
                        <li>
                        	<a href="#">	
                        	<strong>For any technical queries related to  <br/> your Trinity product, please contact us<br/> 
                  
                      Call:<br/>
                       +91-9770131555<br/>
                       +91-9039630604
                       
                       <br/>
                       Email:<br/>
                       	nipeshp@gmail.com<br/>
                        admin@trinitysolutions.pw
                      </strong><br />
                            
                            </a>
                        </li>
                        
                        
                        
                        <li class="viewmore"><a href="http://trinitysolutions.in/" target="">www.trinitysolutions.in</a></li>
                    </ul>
                </div><!--dropdown-->
                
    			<div class="dropdown userinfo">
                    <a class="dropdown-toggle" data-toggle="dropdown" data-target="#" href="">Hi, <?php echo $cmn->getvalfield("user","username ","userid = '$loginid' "); ?>! <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                       <!-- <li><a href="profile_setting.php"><span class="icon-edit"></span> Edit Profile</a></li>-->
                        
                        <!--<li class="divider"></li>-->
                        <li><a href="logout.php"><span class="icon-off"></span> Sign Out</a></li>
                    </ul>
                </div><!--dropdown-->
    		
            </div><!--headerright-->
            
    	</div><!--headerpanel-->
        <div class="breadcrumbwidget">
        	<ul class="skins">
              <!--  <li><a href="default.html" class="skin-color default"></a></li>
                <li><a href="orange.html" class="skin-color orange"></a></li>
                <li><a href="dark.html" class="skin-color dark"></a></li>
                <li>&nbsp;</li>-->
                <li class="fixed"><a href="#" class="skin-layout fixed"></a></li>
                <li class="wide"><a href="#" class="skin-layout wide"></a></li>
            </ul><!--skins-->
        	<ul class="breadcrumb">
                <li><a href="">Home</a> <span class="divider">/</span></li>
                <li class="active"><?php echo $module; ?></li>
            </ul>
        </div><!--breadcrumbwidget-->
      	<div class="pagetitle">
        
        
        	<h1><?php echo $submodule; ?>
                      
             </h1>
             <?php
			 $curr_date=date('Y-m-d');
			 $total_sell = $cmn->getvalfield("bills","sum(net_bill_amt)","billdate='$curr_date'");	
			 if($pagename=='in-entry.php')
			 {
			 ?>
              
             <div style="float:right;font-size:18px;font-weight:bold;color:#FF1717">
             
             	  <strong>Today's Sale : <?php echo number_format($total_sell,2); ?></strong>
             </div>
             
             <?php } ?>
        </div><!--pagetitle-->
        
    