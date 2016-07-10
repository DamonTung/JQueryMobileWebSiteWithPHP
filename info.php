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
    $fields = array(
        'cat_id',
        'keywords'
    );

    //过滤其它参数
    foreach ($_GET as $key=>$value) {
        if(!in_array($key,$fields)){
            unset($_GET[$key]);
        }
    }
    $cat_id = isset($_GET['cat_id'])?$_GET['cat_id']+0:null;
    $keywords = isset($_GET['keywords'])?$_GET['keywords']:null;
    $infoM  = new GoodsModel();
    $cat = new CatModel();
    $each_page_num = 5;
    $page = 1;//当前页
    if($cat_id && $keywords==null){
        $total_num = $infoM->getInfosCount($cat_id);//总条数
        $total_page = $infoM->get_total_page($total_num,$each_page_num);//总页数
        $offset = ($page-1)*$each_page_num;//偏移量,跳过了($page-1)*$each_page_num条
        $infos = $infoM->catGoods($cat_id,$offset,$each_page_num);//第一页数据
        $cat_one = $cat->find($cat_id);
    }elseif($cat_id==null && $keywords){
        $total_num = $infoM->select_goods_by_keyword($keywords,null,null,null,'count');//总条数
        //print_r($total_num);exit;
        $total_page = $infoM->get_total_page($total_num,$each_page_num);//总页数
        $offset = ($page-1)*$each_page_num;//偏移量,跳过了($page-1)*$each_page_num条
        $infos = $infoM->select_goods_by_keyword($keywords,$offset,$each_page_num,null,'data');//第一页数据
        $tmp_keywords = explode(' ', $keywords);
        $title = '';
        if (in_array('new', $tmp_keywords) || in_array('最新', $tmp_keywords)) {
            $title = '最新';
        } elseif (in_array('best', $tmp_keywords) || in_array('推荐', $tmp_keywords)) {
            $title = '推荐';
        } elseif (in_array('hot', $tmp_keywords) || in_array('热门', $tmp_keywords)) {
            $title = '热门';
        }

        //print_r($infos);exit;
    }elseif($cat_id && $keywords){
        $total_num = $infoM->select_goods_by_keyword($keywords,null,null,$cat_id,'count');//总条数
        //print_r($total_num);exit;
        $total_page = $infoM->get_total_page($total_num,$each_page_num);//总页数
        $offset = ($page-1)*$each_page_num;//偏移量,跳过了($page-1)*$each_page_num条
        $infos = $infoM->select_goods_by_keyword($keywords,$offset,$each_page_num,$cat_id,'data');//第一页数据
        $cat_one = $cat->find($cat_id);
        //print_r($infos);exit;
    }else{
        header("refresh:0;url=./index.php");
        exit('参数有误');
    }
    //取出树状导航
    $cats = $cat->select();//获取所有栏目
    $sort = $cat->getCatTree($cats,1,1);//排序
    //$offset = $infoM->update_offset($offset,$each_page_num);
    //$remainder = $total_page % $each_page_num;//最后一页的条数，补回偏移量
    //print_r($infos);exit;

//    $rand = mt_rand(999,1000000);
    //$is_init = 0;
	include("./view/mobile/info.html");
}else{
	include("./view/mobile/error.html");
	exit;
}



?>
