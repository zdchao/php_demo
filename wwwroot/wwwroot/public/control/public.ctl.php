<?php
class PublicControl extends  Control
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
	public function contact()
	{ 
		$this->_tpl->assign('action','contact');
		$this->_tpl->assign('user',getRole('user'));
		return $this->_tpl->fetch('public/contact.html');
	}
	public function index()
	{
		$blogs = daocall('blog','getList',array());
		rsort($blogs);
		$this->_tpl->assign('blogs',$blogs);
		$this->_tpl->assign('action','index');
		$this->_tpl->assign('user',getRole('user'));
		$seo = array(
			'title'=>'高防DNS_智能DNS_DNS解析_免费智能DNS解析服务商_免费CDN_高防CDN',
			'keywords'=>'DNS,DNS解析,免费DNS,智能DNS,免费智能DNS,高防DNS,抗攻击DNS,防劫持,域名解析,免费CDN,高防CDN,防CC攻击，CDN网站加速',
			'description'=>'自主研发智能DNS解析系统,技术领先,抗攻击力强,支持负载均衡,宕机自动切换,支持SSL,隐藏ip,批量解析。'
		);
		$this->_tpl->assign('seo',$seo);
		$this->_tpl->assign('index_active','active');
		return $this->_tpl->fetch('public/index.html');
	}
	public function products()
	{
		$this->_tpl->assign('action','func');
		$this->_tpl->assign('user',getRole('user'));
		$seo = array(
			'title'=>'产品介绍，免费DNS_高防DNS_智能DNS_DNS解析_免费智能DNS解析服务商_免费CDN提供商_高防CDN',
			'keywords'=>'DNS,DNS解析,免费DNS,智能DNS,免费智能DNS,高防DNS,抗攻击DNS,防劫持,域名解析,免费CDN,高防CDN,防CC攻击,CDN网站加速',
			'description'=>'自主研发智能DNS解析系统,技术领先,抗攻击力强,支持负载均衡,宕机自动切换，支持SSL,隐藏ip,批量解析。'
		);
		$this->_tpl->assign('seo',$seo);
		$this->_tpl->assign('product_active','active');
		return $this->_tpl->fetch('public/products.html');
	}
	public function containerproduct()
	{
		$this->_tpl->assign('action','func');
		$this->_tpl->assign('user',getRole('user'));
		$seo = array(
				'title'=>'产品介绍，免费DNS_高防DNS_智能DNS_DNS解析_免费智能DNS解析服务商_免费CDN提供商_高防CDN',
				'keywords'=>'DNS,DNS解析,免费DNS,智能DNS,免费智能DNS,高防DNS,抗攻击DNS,防劫持,域名解析,免费CDN,高防CDN,防CC攻击,CDN网站加速',
				'description'=>'自主研发智能DNS解析系统,技术领先,抗攻击力强,支持负载均衡,宕机自动切换，支持SSL,隐藏ip,批量解析。'
		);
		$this->_tpl->assign('seo',$seo);
		$this->_tpl->assign('container_active','active');
		$rows = D("containerproduct")->getList();
		$this->_tpl->assign('rows',$rows);
		$this->_tpl->assign('newrows',json_encode($rows));
		return $this->_tpl->fetch('public/containerproducts.html');
	}
	public function buy()
	{
		$this->_tpl->assign('action','product');
		$this->_tpl->assign('user',getRole('user'));
		$seo = array(
			'title'=>'购买套餐，免费DNS_高防DNS_智能DNS_DNS解析_免费智能DNS解析服务商_免费CDN提供商_高防CDN',
			'keywords'=>'DNS,DNS解析,免费DNS,智能DNS,免费智能DNS,高防DNS,抗攻击DNS,防劫持,域名解析,免费CDN,高防CDN,防CC攻击,CDN网站加速',
			'description'=>'自主研发智能DNS解析系统,技术领先,抗攻击力强,支持负载均衡,宕机自动切换,支持SSL,隐藏服务器ip,批量解析。'
		);
		$this->_tpl->assign('seo',$seo);
		$this->_tpl->assign('priceper_active','active');
		return $this->_tpl->fetch('public/buy.html');
	}
	public function host()
	{

		$seo = array(
			'title'=>'购买套餐，免费DNS_高防DNS_智能DNS_DNS解析_免费智能DNS解析服务商_免费CDN提供商_高防CDN',
			'keywords'=>'DNS,DNS解析,免费DNS,智能DNS,免费智能DNS,高防DNS,抗攻击DNS,防劫持,域名解析,免费CDN,高防CDN,防CC攻击,CDN网站加速',
			'description'=>'自主研发智能DNS解析系统,技术领先,抗攻击力强,支持负载均衡,宕机自动切换,支持SSL,隐藏服务器ip,批量解析。'
		);
		$this->_tpl->assign('seo',$seo);

		return $this->_tpl->fetch('public/host.html');
	}
	public function server()
	{
		$this->_tpl->assign('action','product');
		$this->_tpl->assign('user',getRole('user'));
		$seo = array(
			'title'=>'企业服务，免费DNS_高防DNS_智能DNS_DNS解析_免费智能DNS解析服务商_免费CDN提供商_高防CDN',
			'keywords'=>'DNS,DNS解析,免费DNS,智能DNS,免费智能DNS,高防DNS,抗攻击DNS,防劫持,域名解析,免费CDN,高防CDN,防CC攻击,CDN网站加速',
			'description'=>'自主研发智能DNS解析系统,技术领先,抗攻击力强,支持负载均衡,宕机自动切换,支持SSL,隐藏源ip,批量解析。'
		);
		$this->_tpl->assign('seo',$seo);
		$this->_tpl->assign('server_active','active');
		return $this->_tpl->fetch('public/server.html');
	}
	public function content()
	{
		$this->_tpl->assign('user',getRole('user'));
		$seo = array(
				'title'=>'联系我们，免费DNS_高防DNS_智能DNS_DNS解析_免费智能DNS解析服务商_免费CDN提供商_高防CDN',
				'keywords'=>'DNS,DNS解析,免费DNS,智能DNS,免费智能DNS,高防DNS,抗攻击DNS,防劫持,域名解析,免费CDN,高防CDN,防CC攻击,CDN网站加速',
				'description'=>'自主研发智能DNS解析系统,技术领先,抗攻击力强,支持负载均衡,宕机自动切换,支持SSL,隐藏真实服务器ip,批量解析。'
		);
		$this->_tpl->assign('seo',$seo);
		$this->_tpl->assign('content_active','active');
		return $this->_tpl->fetch('public/content.html');
	}
	public function login()
	{
		$this->_tpl->assign('action','contact');
		$this->_tpl->assign('user',getRole('user'));
		$seo = array(
				'title'=>'用户登陆，免费DNS_高防DNS_智能DNS_DNS解析_免费智能DNS解析服务商_免费CDN提供商_高防CDN',
				'keywords'=>'DNS,DNS解析,免费DNS,智能DNS,免费智能DNS,高防DNS,抗攻击DNS,防劫持,域名解析,免费CDN,高防CDN,防CC攻击,CDN网站加速',
				'description'=>'自主研发智能DNS解析系统,技术领先,抗攻击力强,支持负载均衡,宕机自动切换,支持SSL,隐藏ip,批量解析。'
		);
		$this->_tpl->assign('seo',$seo);
		$this->_tpl->assign('login_active','active');
		return $this->_tpl->fetch('public/login.html');
	}
	public function reg()
	{
		$this->_tpl->assign('action','contact');
		$this->_tpl->assign('user',getRole('user'));
		$seo = array(
				'title'=>'用户注册，免费DNS_高防DNS_智能DNS_DNS解析_免费智能DNS解析服务商_免费CDN提供商_高防CDN',
				'keywords'=>'DNS,DNS解析,免费DNS,智能DNS,免费智能DNS,高防DNS,抗攻击DNS,防劫持,域名解析,免费CDN,高防CDN,防CC攻击,CDN网站加速',
				'description'=>'自主研发智能DNS解析系统,技术领先,抗攻击力强,支持负载均衡,宕机自动切换,支持SSL,隐藏服务器ip,批量解析。'
		);
		$this->_tpl->assign('seo',$seo);
		$this->_tpl->assign('reg_active','active');
		return $this->_tpl->fetch('public/reg.html');
	}
	public function foot()
	{
		return $this->_tpl->fetch('public/foot.html');
	}
	public function foot2()
	{
		return $this->_tpl->fetch('public/foot2.html');
	}
	public function lock()
	{
		$this->_tpl->assign('action','contact');
		$this->_tpl->assign('user',getRole('user'));
		$seo = array(
				'title'=>'域名不存在 - powered by dnsdun.com',
				'keywords'=>'DNS,DNS解析,免费DNS,智能DNS,免费智能DNS,高防DNS,抗攻击DNS,防劫持,域名解析,免费CDN,高防CDN,防CC攻击,CDN网站加速',
				'description'=>'自主研发智能DNS解析系统,技术领先,抗攻击力强,支持负载均衡,宕机自动切换,支持SSL,隐藏真实ip。'
		);
		$this->_tpl->assign('seo',$seo);
		$this->_tpl->assign('lock_active','active');
		return $this->_tpl->fetch('public/lock.html');
	}
	public function head()
	{		
		$this->_tpl->assign('action','contact');
		$menus[] = 	array('首页','/');
		$menus[] = array('会员中心','?c=user&a=index');
		$this->_tpl->assign("menus",$menus);
		//$this->_tpl->assign('role',getRoles());
		if (strcasecmp($_SERVER['HTTPS'],"ON")==0) {
			$www_head = 'https://';
		} else {
			$www_head = 'http://';
		}
		if(defined(CONTAINER)&&CONTAINER == 1){
			
			$this->_tpl->assign('container',1);
		}
		$www_head.=$_SERVER["HTTP_HOST"].'/';
		$this->_tpl->assign('www_head',$www_head);
		$user = getRole('user');
		$this->_tpl->assign('user',getRole('user'));
		return $this->_tpl->fetch("public/head.html");
	}
	public function left()
	{
		return $this->fetch('public/left.html');
	}
}
