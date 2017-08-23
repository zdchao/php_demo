<?php 
class ServerDAO extends DAO
{
	public function __construct()
	{
		parent::__construct();
		$this->_TABLE = DBPRE.'server';
		$this->MAP_ARR = array(
			'name'				=>'name',
			'passwd'				=>'passwd',
			'master'				=>'master',
			'skey'					=>'skey',
			'peer'					=>'peer',
			'serial'					=>'serial',
			'ip_count'			=>'ip_count',
			'group_view'		=>'group_view',
			'pid'						=>'pid',
			'remark'				=>'remark',
			'soa'					=>'soa',
			'allow_buy_pid'	=>'allow_buy_pid',
			'email'				=>'email'
		);
		$this->MAP_TYPE = array(
			'master'		=>FIELD_TYPE_INT,
			'serial'			=>FIELD_TYPE_BITS,
			'ip_count'	=>FIELD_TYPE_INT,
			'pid'				=>FIELD_TYPE_INT
		);
	}
	public function getList()
	{
		return $this->select(null,null,'rows');
	}
	public function getServerNameList(){
		return $this->select(array('name'),null,'rows');
	}
	public function changeEmail($name,$email)
	{
		$arr['email'] = $email;
		$where['name'] = $name;
		return $this->update($arr, $where);
	}
	public function changeAllowbuypid($name,$allow_buy_pid)
	{
		$where['name'] = $name;
		$arr['allow_buy_pid'] = $allow_buy_pid;
		return $this->update($arr, $where);
	}
	public function editPasswd($name,$passwd)
	{
		$where['name'] = $name;
		$arr['passwd'] = md5($passwd);
		return $this->update($arr, $where);
	}
	public function getByName($name)
	{
		return $this->select(null,$this->getFieldValue2('name', $name),'row');
	}
	public function editSoa($name,$soa)
	{
		$arr['soa'] = $soa;
		$where['name'] = $name;
		return $this->update($arr, $where);
	}
	public function editPid($name,$pid)
	{
		$arr['pid'] = $pid;
		$where['name'] = $name;
		return $this->update($arr, $where);
	}
	public function getInfo($name)
	{
		$where['name'] = $name;
		return $this->select(null,$where,'row');
	}
	public function remark($name,$remark)
	{
		$arr['remark'] = $remark;
		$where['name'] = $name;
		return $this->update($arr, $where);
	}
}