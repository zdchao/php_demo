<?php
require "nusoap.php";
define ( 'DEBUG', false ); // DEBUG开关,打开设置为true
                       // define('WSDL_URL','https://www.bizcn.com/rrpservices/');
define ( 'WSDL_URL', 'https://test.bizcn.com/rrpservices/' ); // 定义webservice网址,测试环境用test,正式环境用www
function wsdl($parameters) {
	if (isset ( $parameters ['module'] )) {
		$module = $parameters ['module'];
	} else {
		$module = '';
	}
	$method = isset ( $parameters ['method'] ) ? $parameters ['method'] : '';
	$user = array (
			"name" => 'keengo',
			"password" => 'Tf*Stla3' 
	); // 用户名/密码
	                                                  // print_r($parameters);
	                                                  // echo '<br>'. "\n";
	if (! $module || ! $method) {
		switch ($module) {
			case 'checkDomainsService' : // Check-Domain
				$method = 'checkDomains';
				break;
			case 'addDomainService' : // Add Domain
				$method = 'addDomain';
				break;
			case 'renewDomainService' : // renew domain
				$method = 'renewDomain';
				break;
			case 'modDomainOwnerService' : // modify domain owner
				$method = 'modOwner';
				break;
			case 'modDomainAdminService' : // modify administrator of domain
				$method = 'modAdmin';
				break;
			case 'modDomainTechService' : // modify domain tech
				$method = 'modTech';
				break;
			case 'modDomainBillingService' : // modify billing of domain
				$method = 'modBilling';
				break;
			case 'modDomainPasswdService' : // modify domain pass
				$method = 'modPasswd';
				break;
			case 'lockDomainService' : // lock domain
				$method = 'lockDomain';
				break;
			case 'unLockDomainService' : // unlock domain
				$method = 'unLockDomain';
				break;
			case 'addNameserverService' : // add NS
				$method = 'addNameserver';
				break;
			case 'modNameserverService' : // Mod NS
				$method = 'modNameserver';
				break;
			case 'delNameserverService' : // Del NS
				$method = 'delNameserver';
				break;
			case 'infoDomainWhoisService' : // Get Domain info
				$method = 'infoDomainWhois';
				break;
			case 'addDnsDomainService' : // Order DNS service
				$method = 'addDnsDomain';
				break;
			case 'checkDomainExistService' : // Check is Domain in Our database
				$method = 'checkDomainExist';
				break;
			case 'addDnsRecordService' : // Add DNS record
				$method = 'addDnsRecord';
				break;
			case 'modDnsRecordService' : // Mod DNS record
				$method = 'modDnsRecord';
				break;
			case 'delDnsRecordService' : // Del DNS record
				$method = 'delDnsRecord';
				break;
			case 'delDnszoneServiceImpl' : // Del DNS Zone
				$method = 'delDnszone';
				break;
			case 'refreshDnszoneService' : // Refresh DNS record
				$method = 'refreshDnszone';
				break;
			case 'addUrlForwardService' : // Add URL forward
				$method = 'addUrlForward';
				break;
			case 'modUrlForwardService' : // Mod URL forward
				$method = 'modUrlForward';
				break;
			case 'delUrlForwardService' : // Del URL forward
				$method = 'delUrlForward';
				break;
			case 'infoDomainDnsService' : // Get NS
				$method = 'infoDomainDns';
				break;
			case 'infoDomainLockService' : // Get is Domain lock
				$method = 'infoDomainLock';
				break;
			case 'infoDnsRecordService' : // Get DNS record
				$method = 'infoDnsRecord';
				break;
			case 'updateDnszoneService' : // Update DNS record
				$method = 'updateDnszone';
				break;
			case 'modDomainDnsService' : // MOD NS server
				$method = 'modDomainDns';
				break;
			case 'getEppcodeServiceImpl' : // Get Epp ocde
				$method = 'getEppcode';
				break;
			default :
				$values ['code'] = 500;
				$values ["msg"] = 'No specified method';
				return $values;
				break;
		}
	}
	$client = new nusoap_client ( WSDL_URL . $module . '?wsdl', true );
	$err = $client->getError ();
	if ($err) {
		if (DEBUG == true) {
			echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
		} else {
			// If error, return the error message in the value below
			$values ["msg"] = $err;
			return $values;
		}
	}
	$client->setUseCurl ( 0 );
	// if(is_array($parameters)){$parameters['user']=$user;}
	// $user=$parameters['user'];
	$paras = $parameters ['paras'];
	$paras ['user'] = $user;
	$result = $client->call ( $method, $paras );
	if ($client->fault) {
		if (DEBUG == true) {
			echo '<h2>Fault</h2><pre>';
			print_r ( $result );
			echo '</pre>';
		}
		// If error, return the error message in the value below
		$values ["code"] = 500;
		$values ["msg"] = 'API Fault';
		return $values;
	} else {
		$err = $client->getError ();
		if ($err) {
			if (DEBUG == true) {
				echo '<h2>Error</h2><pre>' . $err . '</pre>';
			}
			// If error, return the error message in the value below
			$values ["msg"] = $err;
			return $values;
		} else {
			if (DEBUG == true) {
				echo '<h2>Result</h2><pre>';
				print_r ( $result );
				echo '</pre>';
			}
			if (DEBUG == true) {
				echo '<h2>Request</h2><pre>' . htmlspecialchars ( $client->request, ENT_QUOTES ) . '</pre>';
				echo '<h2>Response</h2><pre>' . htmlspecialchars ( $client->response, ENT_QUOTES ) . '</pre>';
				echo '<h2>Debug</h2><pre>' . htmlspecialchars ( $client->debug_str, ENT_QUOTES ) . '</pre>';
			}
			// If success, return the error message in the value below
			if (isset ( $result ['response'] ) && sizeof ( $result ['response'] ) > 1) {
				$values ['code'] = $result ['response'] ['result'] ['!code'];
				$values ['msg'] = $result ['response'] ['result'] ['msg'];
				$values ['result'] = array_slice ( $result ['response'], 0 );
			} else {
				$values ['code'] = 500;
				$values ['msg'] = 'unknown error';
				if (isset ( $result ['response'] ['result'] )) {
					$values ['code'] = $result ['response'] ['result'] ['!code'];
					$values ['msg'] = $result ['response'] ['result'] ['msg'];
				}
				if (isset ( $result ['result'] )) {
					$values ['code'] = $result ['result'] ['!code'];
					$values ['msg'] = $result ['result'] ['msg'];
				}
			}
			return $values;
		}
	}
}
function return_process($result) {
	if (empty ( $result )) {
		$error = "return is null";
		// If error, return the error message in the value below
		$values ["msg"] = $error;
		$values ["code"] = 500;
		return $values;
	} else {
		return $result;
	}
}
// 查询域名接口
/*
 * Usage:
 *
 * $domain='abcexyy12345678.com';#域名
 * echo '<hr />查询:' . $domain . '<hr>';
 * $result=bizcn_domainCheck($domain);
 * print_r($result);
 */
function bizcn_domainCheck($domain) {
	$cmds = array (
			'name' => array (
					$domain,
					'bb' . $domain 
			) 
	);
	$_params = array (
			"module" => "checkDomainsService",
			"paras" => array (
					'check' => $cmds 
			) 
	);
	$r = wsdl ( $_params );
	print_r($r);
}

// 注册,成功返回true,失败返回false
/*
 * Usage:
 *
 * #生成注册信息数组
 * $infos=array(
 * "First Name"=>'Bizcn',
 * "Last Name"=>'com',
 * "Organization"=>'Bizcn',
 * "Address1"=>'This My Address 1',
 * "Address2"=>'AddRess3',
 * "City"=>'Xiamen2',
 * "State Province"=>'Fujian2',
 * "Country"=>'CN',
 * "Phone"=>'+86.1234567890',
 * "Email Address"=>'test@bizcn.com',
 * "Postcode"=>'361009',
 * );
 *
 * $testpara=array(
 * 'domainname'=>$domain,#域名
 * "regperiod"=>1, #注册年限
 * "contactdetails"=>array(
 * "Registrant"=>$infos,#注册/管理/技术/财务 信息用同一组,也可以另行设定
 * "Admin"=>$infos,
 * "Tech"=>$infos,
 * "Bill"=>$infos,
 * ),
 *
 * "companyname"=>'Organization',#公司名,可用 First Name + Last Name或者Organization
 * "ns1"=>'dns.bizcn.com',
 * "ns2"=>'dns.bizcn.net',
 * # 'lockenabled'=>'locked',
 * # 'ns1'=>'dns.bizcn.com',
 * # 'ns2'=>'dns.cnmsn.net',
 * # 'ns3'=>'f1g1ns1.dnspod.net',
 * # 'ns4'=>'f1g1ns2.dnspod.net',
 * );
 * echo '<hr />注册' . $domain . ':<hr />';
 * $result=bizcn_RegisterDomain($testpara);#注册域名
 * print_r($result);
 */
function bizcn_RegisterDomain($params) {
	$domainname = $params ["domainname"];
	$regperiod = $params ["regperiod"];
	$nameserver1 = $params ["ns1"];
	$nameserver2 = $params ["ns2"];
	// Registrant Details
	$RegistrantFirstName = $params ["contactdetails"] ["Registrant"] ["First Name"];
	$RegistrantLastName = $params ["contactdetails"] ["Registrant"] ["Last Name"];
	$RegistrantCompanyName = $params ["contactdetails"] ["Registrant"] ["Organization"];
	if (empty ( $RegistrantCompanyName ))
		$RegistrantCompanyName = $RegistrantFirstName . " " . $RegistrantLastName;
	$RegistrantAddress1 = $params ["contactdetails"] ["Registrant"] ["Address1"];
	$RegistrantAddress2 = $params ["contactdetails"] ["Registrant"] ["Address2"];
	$RegistrantCity = $params ["contactdetails"] ["Registrant"] ["City"];
	$RegistrantStateProvince = $params ["contactdetails"] ["Registrant"] ["State Province"];
	$RegistrantPostalCode = $params ["contactdetails"] ["Registrant"] ["Postcode"];
	$RegistrantCountry = $params ["contactdetails"] ["Registrant"] ["Country"];
	$RegistrantEmailAddress = $params ["contactdetails"] ["Registrant"] ["Email Address"];
	$RegistrantPhone = $params ["contactdetails"] ["Registrant"] ["Phone"];
	// Admin Details
	$AdminFirstName = $params ["contactdetails"] ["Admin"] ["First Name"];
	$AdminLastName = $params ["contactdetails"] ["Admin"] ["Last Name"];
	$AdminAddress1 = $params ["contactdetails"] ["Admin"] ["Address1"];
	$AdminAddress2 = $params ["contactdetails"] ["Admin"] ["Address2"];
	$AdminCity = $params ["contactdetails"] ["Admin"] ["City"];
	$AdminStateProvince = $params ["contactdetails"] ["Admin"] ["State Province"];
	$AdminPostalCode = $params ["contactdetails"] ["Admin"] ["Postcode"];
	$AdminCountry = $params ["contactdetails"] ["Admin"] ["Country"];
	$AdminEmailAddress = $params ["contactdetails"] ["Admin"] ["Email Address"];
	$AdminPhone = $params ["contactdetails"] ["Admin"] ["Phone"];
	// Tech Details
	$TechFirstName = $params ["contactdetails"] ["Tech"] ["First Name"];
	$TechLastName = $params ["contactdetails"] ["Tech"] ["Last Name"];
	$TechAddress1 = $params ["contactdetails"] ["Tech"] ["Address1"];
	$TechAddress2 = $params ["contactdetails"] ["Tech"] ["Address2"];
	$TechCity = $params ["contactdetails"] ["Tech"] ["City"];
	$TechStateProvince = $params ["contactdetails"] ["Tech"] ["State Province"];
	$TechPostalCode = $params ["contactdetails"] ["Tech"] ["Postcode"];
	$TechCountry = $params ["contactdetails"] ["Tech"] ["Country"];
	$TechEmailAddress = $params ["contactdetails"] ["Tech"] ["Email Address"];
	$TechPhone = $params ["contactdetails"] ["Tech"] ["Phone"];
	// Bill Details
	$BillFirstName = $params ["contactdetails"] ["Bill"] ["First Name"];
	$BillLastName = $params ["contactdetails"] ["Bill"] ["Last Name"];
	$BillAddress1 = $params ["contactdetails"] ["Bill"] ["Address1"];
	$BillAddress2 = $params ["contactdetails"] ["Bill"] ["Address2"];
	$BillCity = $params ["contactdetails"] ["Bill"] ["City"];
	$BillStateProvince = $params ["contactdetails"] ["Bill"] ["State Province"];
	$BillPostalCode = $params ["contactdetails"] ["Bill"] ["Postcode"];
	$BillCountry = $params ["contactdetails"] ["Bill"] ["Country"];
	$BillEmailAddress = $params ["contactdetails"] ["Bill"] ["Email Address"];
	$BillPhone = $params ["contactdetails"] ["Bill"] ["Phone"];
	
	$DnsIp1 = $params ["dns_ip1"];
	$DnsIp2 = $params ["dns_ip2"];
	// Put your code to register domain here
	$_params = array (
			"module" => "addDomainService",
			'paras' => array (
					'create' => array (
							"domainname" => $domainname,
							"term" => $regperiod,
							"dns_host1" => $nameserver1,
							"dns_host2" => $nameserver2,
							"dom_org" => $RegistrantCompanyName, // $RegistrantFirstName." ".$RegistrantLastName, modify by beeyon 2010-07-22
							"dom_fn" => $RegistrantFirstName,
							"dom_ln" => $RegistrantLastName,
							"dom_adr1" => $RegistrantAddress1 . ' ' . $RegistrantAddress2,
							"dom_ct" => $RegistrantCity,
							"dom_st" => $RegistrantStateProvince,
							"dom_co" => $RegistrantCountry,
							"dom_ph" => $RegistrantPhone,
							"dom_fax" => $RegistrantPhone,
							"dom_pc" => $RegistrantPostalCode,
							"dom_em" => $RegistrantEmailAddress,
							
							"admi_fn" => $AdminFirstName,
							"admi_ln" => $AdminLastName,
							"admi_adr1" => $AdminAddress1 . ' ' . $AdminAddress2,
							"admi_ct" => $AdminCity,
							"admi_st" => $AdminStateProvince,
							"admi_co" => $AdminCountry,
							"admi_ph" => $AdminPhone,
							"admi_fax" => $AdminPhone,
							"admi_pc" => $AdminPostalCode,
							"admi_em" => $AdminEmailAddress,
							
							"tech_fn" => $TechFirstName,
							"tech_ln" => $TechLastName,
							"tech_adr1" => $TechAddress1 . ' ' . $TechAddress2,
							"tech_ct" => $TechCity,
							"tech_st" => $TechStateProvince,
							"tech_co" => $TechCountry,
							"tech_ph" => $TechPhone,
							"tech_fax" => $TechPhone,
							"tech_pc" => $TechPostalCode,
							"tech_em" => $TechEmailAddress,
							
							"bill_fn" => $BillFirstName,
							"bill_ln" => $BillLastName,
							"bill_adr1" => $BillAddress1 . ' ' . $BillAddress2,
							"bill_ct" => $BillCity,
							"bill_st" => $BillStateProvince,
							"bill_co" => $BillCountry,
							"bill_ph" => $BillPhone,
							"bill_fax" => $BillPhone,
							"bill_pc" => $BillPostalCode,
							"bill_em" => $BillEmailAddress,
							
							"dns_ip1" => '8.8.8.8',
							"dns_ip2" => '8.8.8.9' 
					) 
			) 
	);
	
	$result = wsdl ( $_params );
	$result = return_process ( $result );
	if ($result ['code'] == 200) {
		return true;
	} else {
		return array (
				'error' => $result ['msg'] 
		);
	}
}

// 使用联系人模板注册,成功返回true,失败返回false
/*
 * Usage:
 *
 * $params["domainname"] = "testreg1.com";//注册的域名
 * $params["regperiod"] = 1;//注册年限
 * $params["ns1"] = "ns1.cnmsn.com";//NS服务器1
 * $params["ns2"] = "ns2.cnmsn.com";//NS服务器2
 * $params["contid"] = "bizyl806501431ne";//联系人模板ID
 * $params["price"] = 0;//如果是高价域名则需要带这个价格参数并且值必须大于或等于checkPremium返回的price
 * $result = bizcn_RegisterDomainByID($params);
 * print_r($result);
 *
 */
function bizcn_RegisterDomainByID($params) {
	$domainname = $params ["domainname"];
	$regperiod = $params ["regperiod"];
	$nameserver1 = $params ["ns1"];
	$nameserver2 = $params ["ns2"];
	$contid = $params ["contid"];
	$price = $params ["price"];
	// Put your code to register domain here
	$_params = array (
			"module" => "domainService",
			"method" => "addDomainByID",
			'paras' => array (
					"domainname" => $domainname,
					"term" => $regperiod,
					"dns_host1" => $nameserver1,
					"dns_host2" => $nameserver2,
					"contid" => $contid,
					"price" => $price 
			) 
	);
	
	$result = wsdl ( $_params );
	$result = return_process ( $result );
	if ($result ['code'] == 200) {
		return true;
	} else {
		return array (
				'error' => $result ['msg'] 
		);
	}
}

function bizcn_domainAuditQuery(){
	$_params = array(
			"module" => "domainService",
			"method" => "domainAuditQuery",
			'paras' => array (
					"domainname" =>"zhudechao123.xyz",
			) 
	);
	$result = wsdl ( $_params );
	$result = return_process ( $result );
	print_r($result);
}
bizcn_domainCheck();

?>