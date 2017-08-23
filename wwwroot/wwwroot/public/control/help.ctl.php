<?php
class HelpControl extends  Control
{
	public function __construct()
	{
		setTitle('专业DNS智能解析提供商');
		parent::__construct();
	}
	public function __destruct()
	{
		parent::__destruct();
	}

	public function help()
	{
		$this->_tpl->assign('action','help');
		$this->_tpl->assign('user',getRole('user'));
				$seo = array(
			'title'=>'帮助中心，免费DNS_高防DNS_智能DNS_DNS解析_免费智能DNS解析服务商_高防CDN_智能CDN',
			'keywords'=>'DNS,DNS解析,免费DNS,智能DNS,免费智能DNS,高防DNS,抗攻击DNS,防劫持,域名解析,免费CDN,高防CDN,防CC攻击,网站CDN加速',
			'description'=>'自主研发智能DNS解析系统,技术领先,抗攻击力强,支持负载均衡,宕机自动切换,隐藏IP,支持SSL,支持批量解析。'
		);
		$this->_tpl->assign('seo',$seo);
		$this->_tpl->assign('help_active','active');
		return $this->_tpl->fetch('help/help.html');
	}
	public function faquse()
	{
		return $this->_tpl->fetch('help/faquse.html');
	}
	public function resolve()
	{
		return $this->_tpl->fetch('help/resolve.html');
	}
	public function whydns()
	{
		return $this->_tpl->fetch('help/whydns.html');
	}
	public function zhineng()
	{
		return $this->_tpl->fetch('help/zhineng.html');
	}
	public function url()
	{
		return $this->_tpl->fetch('help/url.html');
	}
	public function line()
	{
		return $this->_tpl->fetch('help/line.html');
	}
	public function foot()
	{
		return $this->_tpl->fetch('help/foot.html');
	}
	public function head()
	{
		$menus[] = 	array('首页','/');
		$menus[] = array('会员中心','?c=user&a=index');
		$this->_tpl->assign("menus",$menus);
		$this->_tpl->assign('role',getRoles());
		if (strcasecmp($_SERVER['HTTPS'],"ON")==0) {
			$www_head = 'https://';
		} else {
			$www_head = 'http://';
		}
		$www_head.=$_SERVER["HTTP_HOST"].'/';
		$this->_tpl->assign('www_head',$www_head);
		if (getRole('user')) {
			$this->_tpl->assign('user',getRole('user'));
		}
		return $this->_tpl->fetch("public/head.html");
	}
	public function left()
	{
		return $this->fetch('public/left.html');
	}
}
