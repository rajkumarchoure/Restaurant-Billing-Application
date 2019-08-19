<?php
if($action != "")
{?>
<div class="widgetcontent" id="alertbox">
                        	
  <?php
  if($action == "3")
	{?>
    <div class="alert alert-error" >
      <button data-dismiss="alert" class="close" type="button">×</button>
      <strong>Reocrd Deleted !! </strong>Succesfully
    </div><!--alert-->
  <?php
	}
	else if($action == "1")
	{?>
    <div class="alert alert-success">
      <button data-dismiss="alert" class="close" type="button">×</button>
       <strong>Reocrd Inserted !! </strong>Succesfully
    </div><!--alert-->
     <?php
	}
	else if($action == "2")
	{?>
    <div class="alert alert-info" >
      <button data-dismiss="alert" class="close" type="button">×</button>
       <strong>Reocrd Updated !! </strong>Succesfully
    </div><!--alert-->
 <?php
	}?>
</div>
<?php
}?>