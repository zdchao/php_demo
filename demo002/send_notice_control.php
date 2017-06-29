<?php
class SendNoticeControl{
	private $dbh = NULL;
	private $db_type = "sqlite";
	private $host = "localhost";
	private $dbname = "";
	private $user = "";
	private $pass = "";
	
	private $table_struct = array(
			"notice_send_control"=>array(
					"CREATE TABLE [notice_send_control] ([key] VARCHAR(255)  NOT NULL PRIMARY KEY,[max_count] INTEGER  NULL);"
			)
	);
	
	public function __construct(){
		global $sqlite_cfg;
		if(!isset($sqlite_cfg)){
			echo "===>没有检查到sqlite数据库配置参数，请先配置.\n";
			echo "===>格式如下";
			echo '$sqlite_cfg = array(
			"type"=>"sqlite",
			"dbname"=>"C:/zhdc/zhdcmm.db"
			);\n';
			echo "===>type:数据库类型\n";
			echo "===>dbname:数据库磁盘位置\n";
			die();
		}
		
		try {
			
			//不存在将会自动创建数据库
			//'sqlite:C:/zhdc/zhdcmm.db'
			$pdo_col = $sqlite_cfg["type"].":".$sqlite_cfg["dbname"];
			$this->dbh = new PDO($pdo_col,$this->user,$this->pass);
		}catch (PDOException $e){
			echo $e->getMessage()."\n";
			die();
		}
	}
	
	public function check($key,$count=50){
		try {
			$ret = null;
			$sql = "SELECT max_count FROM notice_send_control WHERE key = '".$key."';";
			$query = $this->dbh->query($sql);
			$ret = $query->fetch(PDO::FETCH_ASSOC);
			if($ret === false){
				$this->repaceKey($key,$count);
				return true;
			}
			
			if(intval($ret["max_count"]) > 0){
				$count = --$ret["max_count"];
				$this->repaceKey($key,$count);
				return true;
			}else {
				return false;
			}
			
		}catch (PDOException $e){
			echo $e->getMessage();
		}
		
		return false;
	}
	
	private function repaceKey($key,$count){
		$sql = "REPLACE INTO notice_send_control(key,max_count) values('".$key."',".$count.")";
		$ret = $this->dbh->exec($sql);
	}
	
	public function flush() {
		$sql = "DELETE FROM notice_send_control";
		$ret = $this->dbh->exec($sql);
		if($ret === false || $ret == 0){
			foreach ($this->table_struct["notice_send_control"] as $key=>$value){
				$ret = $this->createTable($value);
				if ($ret){
					echo "===>notice_send_control 表删除并创建成功\n";
				}
			}
		}
	}
	
	//初始化表
	private function createTable($table_sql){
		$ret = $this->dbh->exec($table_sql);
		if ($ret === 0){
			return true;
		}
		return false;
	}
}






