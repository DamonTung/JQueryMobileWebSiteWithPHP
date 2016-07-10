<?php

define('PERMISSION',true);
//定义一个变量为true，然后在“禁止用户直接地址栏访问的文件”里检测该变量，
//如果检测不到该变量则判断为非法访问该文件。
//conntroller都define(定义常量)
//非conntroller都defined(检验常量)
require('../../include/init.php');

$fields = array(
    'id',
    'name',
    'format',
    'offset',
    'limit',
    'page',
    'cat_id',
    'keywords'
);

//过滤其它参数
foreach ($_GET as $key=>$value) {
    if(!in_array($key,$fields)){
        unset($_GET[$key]);
    }
}
$id = isset($_GET['id'])?$_GET['id']+0:0;
$offset = isset($_GET['offset'])?$_GET['offset']+0:false;
$limit = isset($_GET['limit'])?$_GET['limit']+0:false;
$format = isset($_GET['format'])?$_GET['format']:'json';
$name = isset($_GET['name']);
$page = isset($_GET['page'])?$_GET['page']+0:null;
$cat_id = isset($_GET['cat_id'])?$_GET['cat_id']+0:null;
$keywords = isset($_GET['keywords'])?$_GET['keywords']:null;

if( isset($_GET['id']) || isset($_GET['offset']) || isset($_GET['page']) || isset($_GET['limit']) || isset($_GET['format']) || isset($_GET['name']) ){

    function createXML($arr, $xml) {
        foreach($arr as $k=>$v) {
            if(is_array($v)) {
                $x = $xml->addChild($k);
                create($v, $x);
            }else $xml->addChild($k, $v);
        }
    }

    function print_result($format,$info){
        if($format=='xml'){
            $xml = simplexml_load_string('<!DOCTYPE results [
                                            <!ENTITY nbsp " ">
                                            <!ENTITY copy "©">
                                            <!ENTITY reg "®">
                                            <!ENTITY trade "™">
                                            <!ENTITY mdash "—">
                                            <!ENTITY ldquo "“">
                                            <!ENTITY rdquo "”">
                                            <!ENTITY pound "£">
                                            <!ENTITY yen "¥">
                                            <!ENTITY euro "€">
                                            ]>
                                            <results/>');
            createXML($info, $xml);
            header('Content-type:text/xml');
            echo $xml->saveXML();
        }elseif($format=='json'){

        /**************************************************************
         *
         *	使用特定function对数组中所有元素做处理
         *	@param	string	&$array		要处理的字符串
         *	@param	string	$function	要执行的函数
         *	@return boolean	$apply_to_keys_also		是否也应用到key上
         *	@access public
         *
         *************************************************************/
        function arrayRecursive(&$array, $function, $apply_to_keys_also = false)
        {
            static $recursive_counter = 0;
            if (++$recursive_counter > 1000) {
                die('possible deep recursion attack');
            }
            foreach ($array as $key => $value) {
                if (is_array($value)) {
                    arrayRecursive($array[$key], $function, $apply_to_keys_also);
                } else {
                    $array[$key] = $function($value);
                }

                if ($apply_to_keys_also && is_string($key)) {
                    $new_key = $function($key);
                    if ($new_key != $key) {
                        $array[$new_key] = $array[$key];
                        unset($array[$key]);
                    }
                }
            }
            $recursive_counter--;
        }

        /**************************************************************
         *
         *	将数组转换为JSON字符串（兼容中文）
         *	@param	array	$array		要转换的数组
         *	@return string		转换得到的json字符串
         *	@access public
         *
         *************************************************************/
        function JSON($array) {
            arrayRecursive($array, 'urlencode', true);
            $json = json_encode($array);
            return urldecode($json);
        }
        header('Content-type:text/json');
        echo JSON($info);
        }elseif($format == 'html'){
            $html = '';
            foreach($info as $k=>$v){
                $html = $html.'<li><a href="one.php?id='.$v['id'].'"><img src="'.$v['img_url'].'" alt=""><h2>'.$v['name'].'</h2><h3>'.$v['info1'].'</h3><p><span class="'.'text-no">'.$v['info2'].'</span></p><p><span class="'.'text-no">'.$v['info3'].'</span></p></a><p class="'.'desc-normal"'.'><span class="'.'left-aside">'.$v['info4'].'</span></p></li>';
            }
            header('Content-type:text/html;charset=utf8');
            echo $html;
        }
    }

    $infos  = new GoodsModel();

    if($id){
        $info = $infos->find($id);
        print_result($format,$info);
    }elseif($name){
        $info = $infos->find($name);
        print_result($format,$info);
    }elseif($offset !== false || $limit !== false){
        $infolist = $infos->getInfo($offset,$limit);
        $data = array();
        foreach($infolist as $k=>$v){
            foreach($v as $key=>$value){
                $data[$v['id']] = $v;
            }
        }
        print_result($format,$data);
    }elseif($page && $cat_id==null && $keywords==null){
        $each_page_num = 5;
        $total_num = $infos->getInfosCount();//总条数
        $total_page = $infos->get_total_page($total_num,$each_page_num);//总页数
        $offset = ($page-1)*$each_page_num;//偏移量,跳过了($page-1)*$each_page_num条
        $infolist = $infos->getInfo($offset,$each_page_num);
        $data = array();
        foreach($infolist as $k=>$v){
            foreach($v as $key=>$value){
                $data[$v['id']] = $v;
            }
        }
        print_result($format,$data);
    }elseif($page && $cat_id && $keywords==null){
        $each_page_num = 5;
        $total_num = $infos->getInfosCount($cat_id);//总条数
        $total_page = $infos->get_total_page($total_num,$each_page_num);//总页数
        $offset = ($page-1)*$each_page_num;//偏移量,跳过了($page-1)*$each_page_num条
        $infolist = $infos->catGoods($cat_id,$offset,$each_page_num);

        //print_r($total_num.$total_page.$offset);exit;
        $data = array();
        foreach($infolist as $k=>$v){
            foreach($v as $key=>$value){
                $data[$v['id']] = $v;
            }
        }
        print_result($format,$data);
    }elseif($page && $cat_id==null && $keywords){
        $each_page_num = 5;
        $total_num = $infos->select_goods_by_keyword($keywords,null,null,null,'count');//总条数
        $total_page = $infos->get_total_page($total_num,$each_page_num);//总页数
        $offset = ($page-1)*$each_page_num;//偏移量,跳过了($page-1)*$each_page_num条
        $infolist = $infos->select_goods_by_keyword($keywords,$offset,$each_page_num,null,'data');
        //print_r($infolist);exit;
        $data = array();
        foreach($infolist as $k=>$v){
            foreach($v as $key=>$value){
                $data[$v['id']] = $v;
            }
        }
        print_result($format,$data);
    }elseif($page  && $cat_id && $keywords){
        $each_page_num = 5;
        $total_num = $infos->select_goods_by_keyword($keywords,null,null,$cat_id,'count');//总条数
        $total_page = $infos->get_total_page($total_num,$each_page_num);//总页数
        $offset = ($page-1)*$each_page_num;//偏移量,跳过了($page-1)*$each_page_num条
        $infolist = $infos->select_goods_by_keyword($keywords,$offset,$each_page_num,$cat_id,'data');
        //print_r($infolist);exit;
        $data = array();
        foreach($infolist as $k=>$v){
            foreach($v as $key=>$value){
                $data[$v['id']] = $v;
            }
        }
        print_result($format,$data);
    }

}else{
    exit("请输入正确的参数!<br>[format不传默认json]：");
}

?>