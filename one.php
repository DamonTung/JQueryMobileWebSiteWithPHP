<?php

define('PERMISSION',true);
//定义一个变量为true，然后在“禁止用户直接地址栏访问的文件”里检测该变量，
//如果检测不到该变量则判断为非法访问该文件。
//conntroller都define(定义常量)
//非conntroller都defined(检验常量)
require('./include/init.php');

function isMobile()
{ 
    // 如果有HTTP_X_WAP_PROFILE则一定是移动设备
    if (isset ($_SERVER['HTTP_X_WAP_PROFILE']))
    {
        return true;
    } 
    // 如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息
    if (isset ($_SERVER['HTTP_VIA']))
    { 
        // 找不到为flase,否则为true
        return stristr($_SERVER['HTTP_VIA'], "wap") ? true : false;
    } 
    // 脑残法，判断手机发送的客户端标志,兼容性有待提高
    if (isset ($_SERVER['HTTP_USER_AGENT']))
    {
        $clientkeywords = array ('nokia',
            'sony',
            'ericsson',
            'mot',
            'samsung',
            'htc',
            'sgh',
            'oneplus',
            'lg',
            'sharp',
            'sie-',
            'philips',
            'panasonic',
            'alcatel',
            'lenovo',
            'iphone',
            'ipod',
            'blackberry',
            'meizu',
            'android',
            'netfront',
            'symbian',
            'ucweb',
            'windowsce',
            'palm',
            'operamini',
            'operamobi',
            'openwave',
            'nexusone',
            'cldc',
            'midp',
            'wap',
            'mobile'
            ); 
        // 从HTTP_USER_AGENT中查找手机浏览器的关键字
        if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT'])))
        {
            return true;
        } 
    } 
    // 协议法，因为有可能不准确，放到最后判断
    if (isset ($_SERVER['HTTP_ACCEPT']))
    { 
        // 如果只支持wml并且不支持html那一定是移动设备
        // 如果支持wml和html但是wml在html之前则是移动设备
        if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html'))))
        {
            return true;
        } 
    } 
    return false;
}

if(true){ //  用isMobile()判断用户使用的是不是手机  此处直接true以方便调试
    //$img_css = '';
    //if(isMobile()){
    //  $img_css = '<style>img{ max-width: 100%; }</style>';//如果是手机，给每个img标签都添加这个属性
    //}
	/*<?php if(isset($img_css)){echo $img_css;} ?>*/
    $fields = array(
        'id'
    );

    //过滤其它参数
    foreach ($_GET as $key=>$value) {
        if(!in_array($key,$fields)){
            unset($_GET[$key]);
        }
    }

    $id = isset($_GET['id'])?$_GET['id']+0:0;
    $infos  = new GoodsModel();
    $info = $infos->find($id);
    $access_amount = $infos->get_access_amount($id) + 1;
    if( !($infos->update_access_amount($access_amount,$id)) ){
        exit('抱歉，访问失败，请稍后再访问。');
    }
    //取出树状导航
    $cat = new CatModel();
    $cats = $cat->select();//获取所有栏目
    $sort = $cat->getCatTree($cats,1,1);//排序
	include("./view/mobile/one.html");
}else{
	include("./view/mobile/error.html");
	exit;
}

?>
