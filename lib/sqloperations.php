<?php
class SqlOperations
{
	//delete value from table
	function sqldelete($table,$cond)
	{
		$sql = "delete from $table where $cond";
		//echo $sql;
		mysql_query($sql);
		return(0);
	}
}
?>