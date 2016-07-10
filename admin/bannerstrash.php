<?php

define('PERMISSION',true);
//定义一个变量为true，然后在“禁止用户直接地址栏访问的文件”里检测该变量，
//如果检测不到该变量则判断为非法访问该文件。
//conntroller都define(定义常量)
//非conntroller都defined(检验常量)
require('../include/init.php');

/*
 * 接收goods_id
 * 调用trash方法
 */
if( !isset($_SESSION['username'])||empty($_SESSION['username']) || !isset($_SESSION['user_id']) || empty($_SESSION['user_id']) ){
    echo '请先<span><a href="../login.php">登录</a></span>';
}elseif(isset($_SESSION['username']) && $_SESSION['username']=='admin' && isset($_SESSION['user_id']) && !empty($_SESSION['user_id']) ) {
    $id = isset($_GET['id']) ? $_GET['id'] + 0 : 0;
    $banners = new BannersModel();
    if (isset($_GET['act']) && $_GET['act'] == 'delete' && $id) {
        if ($banners->delete($id)) {
            header("refresh:5;url=bannerslist.php");
            echo '成功彻底删除,5秒后自动返回Banner列表。';
            echo '&nbsp;<span><a href="javascript:history.go(-1);">&#9666;返回上一步</a></span>';
        } else {
            echo '删除失败';
            echo '&nbsp;<span><a href="javascript:history.go(-1);">&#9666;返回上一步</a></span>';
        }
    }elseif (isset($_SESSION['username']) && $_SESSION['username'] != 'admin' && isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) {
        echo '您不是管理员，请使用管理员账号进行<span><a href="../login.php">登录</a></span>';
    } else {
        header("refresh:5;url=../login.php");
        echo '系统出错,5秒后自动前往用户登录界面。';
    }
}
?>