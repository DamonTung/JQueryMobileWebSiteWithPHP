<?php

define('PERMISSION',true);
//定义一个变量为true，然后在“禁止用户直接地址栏访问的文件”里检测该变量，
//如果检测不到该变量则判断为非法访问该文件。
//conntroller都define(定义常量)
//非conntroller都defined(检验常量)
require('../include/init.php');

//print_r($_POST);exit;
if( !isset($_SESSION['username'])||empty($_SESSION['username']) || !isset($_SESSION['user_id']) || empty($_SESSION['user_id']) ){
    echo '请先<span><a href="../login.php">登录</a></span>';
}elseif(isset($_SESSION['username']) && $_SESSION['username']=='admin' && isset($_SESSION['user_id']) && !empty($_SESSION['user_id']) ){
        //表中有的字段，但传来的字段中没有，所以我们要手动添加，然后同意过滤
        //直接添加再data数组(如：$data['xxxx']=$_POST['xxx']*$_POST['xxx']...)里也可，
        //但最好加到POST数组里，统一过滤一下
        //重量需要2个POST过来的值，但表中是没有这两个字段
        if(!$_POST){
            exit('发布失败，没有接收到数据，如您上传了过大的文件会出现该情况。&nbsp;<span><a href="javascript:history.go(-1);">&#9666;返回上一步</a></span>');
        }
        //添加商品的时间(改：交由_autoFill处理)
        //$_POST['add_time'] = time();

        $data = array();
        $banners = new BannersModel();

        //自动过滤
        $data = $banners->_facade($_POST);
        //print_r($data);

        //自动填充
        $data = $banners->_autoFill($data);
        //print_r($data);

        //自动验证
        if(!$banners->_validate($data)){
            //echo '没通过检验<br/>';
            //print_r($goods->getErr());
            echo '数据不合法<br/>';
            echo implode('<br/>',$banners->getErr());
            echo '&nbsp;<span><a href="javascript:history.go(-1);">&#9666;返回上一步</a></span>';
            exit;
        }

    //上传图片
    $uptools = new UploadTools();
    $uptools->setExt('jpg,jpeg,gif,png,bmp');
    $uptools->setSize(2);
    $img_url_path = '';
    $banners = new BannersModel();
    $banner = $banners->getBanner($_POST['id']);

    if (!$img_url_path = $uptools->upload('img_url')) {
        unset($data['img_url']);
        if($data['img_url_link'] == $banner['img_url'] ){
            unset($data['img_url_link']);
        }else{
            $err = $uptools->getErr();
            if ($err['err_code'] == 4) {
                echo '请上传图片,错误代码：' . $err['err_code'];
                echo '&nbsp;<span><a href="javascript:history.go(-1);">&#9666;返回上一步</a></span>';
            } else {
                echo $err['err_msg'] . ',错误代码：' . $err['err_code'];
                echo '&nbsp;<span><a href="javascript:history.go(-1);">&#9666;返回上一步</a></span>';
            }
            exit;
        }
    }
    if($img_url_path){
        unset($data['img_url_link']);
        $data['img_url'] = $img_url_path;
        //如果原始图上传成功
        //生成小尺寸缩略图120,80
        $img_url = ROOT.$img_url_path;//加上绝对路径
        $img_120x80  = dirname($img_url).'/../thumb_120x80/thumb_120x80_'.basename($img_url);
        $img_350x220  = dirname($img_url).'/../thumb_350x220/thumb_350x220_'.basename($img_url);
        //12x80
        if(ImageTools::thumb($img_url,$img_120x80,120,80)){
            $data['img_url_120x80'] = str_replace(ROOT,'',$img_120x80);
        }
        //350x220
        if(ImageTools::thumb($img_url,$img_350x220,350,220)){
            $data['img_url_350x220'] = str_replace(ROOT,'',$img_350x220);
        }
    }

    if($banners->edit($data,$_POST['id'])){
            header("refresh:5;url=bannerslist.php");
            echo '发布成功,5秒后自动返回Banner列表。';
            echo '&nbsp;<span><a href="javascript:history.go(-1);">&#9666;返回上一步</a></span>';

        }else{
            echo '发布失败!';
            echo '&nbsp;<span><a href="javascript:history.go(-1);">&#9666;返回上一步</a></span>';
        }

}elseif(isset($_SESSION['username']) && $_SESSION['username']!='admin' && isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])){
    echo '您不是管理员，请使用管理员账号进行<span><a href="../login.php">登录</a></span>';
}else{
    header("refresh:5;url=../login.php");
    echo '系统出错,5秒后自动前往用户登录界面。';
}



?>