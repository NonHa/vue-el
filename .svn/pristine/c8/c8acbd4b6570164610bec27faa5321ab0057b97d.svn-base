<?php

	$mysql = new SaeMysql();
	$sql = "SELECT
				*
			FROM
				`hr_uservip`
			WHERE
				`start_date` <".(time()-(60*60*24*365*2))."
				 AND `vip_id` = 3 AND `uservip_status` = 1";
	$dat = $mysql->getData( $sql );

	if( $mysql->errno() != 0 )
	{
		die( "Error:" . $mysql->errmsg() );
	}else{
		for($i=0;$i<count($dat);$i++){
			$sql2="UPDATE `hr_uservip` SET `uservip_status` = '0' WHERE `hr_uservip`.`openid` = '".$dat[$i]["openid"]."'";
			$res2 = $mysql->runSql( $sql2 );
			if( $mysql->errno() != 0 )
			{
				die( "Error:" . $mysql->errmsg() );
			}else{
				$sql3="UPDATE `hr_user` SET `isvip` = '0' WHERE `hr_user`.`openid` = '".$dat[$i]["openid"]."'";
				$res3 = $mysql->runSql( $sql3 );
				if( $mysql->errno() != 0 ){die( "Error:" . $mysql->errmsg() );}
			}
		}
		
		print_r("SUCCESS!");
	}
	$mysql->closeDb();

?>