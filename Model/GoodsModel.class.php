<?php

//如果检测不到该变量则判断为非法访问该文件。
//conntroller都define(定义常量)
//非conntroller都defined(检验常量)
defined('PERMISSION')||exit('非法访问');

class GoodsModel extends Model{
    protected $table = 'info';
    protected $primarykey = 'id';
    //自动过滤
    protected $fields = array(//这里先手动写好，以后再改成自动分析 desc
        'id',
        'name',
        'cat_id',
        'access_amount',
        'info1',
        'info2',
        'info3',
        'info4',
        'img_url_link',
        'img_url',
        'img_url_120x80',
        'img_url_350x220',
        'details',
        'is_on_sale',
        'is_delete',
        'is_best',
        'is_new',
        'is_hot',
        'add_time'
    );
    //自动填充
    protected $_auto = array(
        array('is_new','value',0),
        array('is_best','value',0),
        array('is_hot','value',0),
        array('add_time','function','time')
    );

    //自动验证
    /*
     * 格式 $this->_valid = array(
     *      array('验证的字段名',0/1/2(验证的场景,0：字段有就判断，没有就不判断，
     *            1:必须检查，2：字段有就判断，没有就不判断，值为空不判断。),
     *            '报错信息','require(必须)/in(某几种情况)/between(范围)/
     *            length(某个范围)')
     * );
     */
    protected $_valid = array(
        array('cat_id',1,'请选择分类','between','1,9999'),
        array('cat_id',1,'栏目id必须是整型值','number'),
        array('name',1,'标题必须在50个字符以内','length','1,50'),
        array('info1',1,'信息1必须在30个字符以内','length','1,30'),
        array('info2',1,'信息2必须在30个字符以内','length','1,30'),
        array('info3',2,'信息3必须在30个字符以内','length','0,30'),
        array('info4',1,'信息4必须在30个字符以内','length','1,30'),
        array('details',1,'描述必须在10到10000个字符以内','length','10,10000'),
        array('is_new',0,'is_new只能是0或1','in','0,1'),
        array('is_best',0,'is_best只能是0或1','in','0,1'),
        array('is_hot',0,'is_hot只能是0或1','in','0,1'),
    );

    /*
     * 作用：把商品放到回收站，即is_delete字段置为1
     * parm int id
     * return bool
     */

    public function trash($id){
        return $this->update(array('is_delete'=>1,'is_on_sale'=>0),$id);
    }

    public function getInfo($cat_id = null,$offset=0,$limit=5){//$offset偏移量，$limit=取出的条目
        if(isset($offset) && isset($limit)){
            $limit_sentence = ' limit '.$offset.','. $limit;
        }else{
            $limit_sentence = '';//即无限制，取出所有的数据
        }
        if($cat_id != null){
            $sql = 'select * from '.$this->table.' where is_on_sale=1 and is_delete=0 and cat_id='.$cat_id.' order by add_time desc'.$limit_sentence;
        }else{
            $sql = 'select * from '.$this->table.' where is_on_sale=1 and is_delete=0 order by add_time desc'.$limit_sentence;
        }
        return $this->db->getAll($sql);
    }

    public function edit($data,$id){
        return $this->update($data,$id);
    }

    public function getInfosCount($cat_id = null){
        if($cat_id != null){
            $sql = 'select count(*) from '.$this->table.' where is_on_sale=1 and is_delete=0 and cat_id='.$cat_id;
        }else{
            $sql = 'select count(*) from '.$this->table.' where is_on_sale=1 and is_delete=0';
        }
        return $this->db->getOne($sql);
    }

    public function get_access_amount($id){
        $sql = 'select access_amount from '.$this->table.' where id='.$id;
        return $this->db->getOne($sql);
    }

    public function update_access_amount($count,$id){
        return $this->update(array('access_amount'=>$count),$id);
    }


    public function get_total_page($total_num,$each_page_num){
        if($each_page_num != 0){
            return ceil($total_num/$each_page_num);
        }else{
            return false;
        }
    }

    public function update_offset($offset,$each_page_num){
        return $offset+$each_page_num;
    }

    public function check_page_count($page,$each_page_num){
        $total_num = $this->getInfosCount();
        if($each_page_num != 0){
            return ceil($total_num/$each_page_num);
        }else{
            return false;
        }
    }

    public function recovery($id){
        return $this->update(array('is_delete'=>0,'is_on_sale'=>1),$id);
    }

    public function getGood($id){
        $sql = 'select * from '.$this->table.' where id = '.$id;
        return $this->db->getRow($sql);
    }

    public function getGoods(){
        $sql = 'select * from '.$this->table.' where is_delete=0';
        return $this->db->getAll($sql);
    }

    public function getGoodsDescId(){
        $sql = 'select * from '.$this->table.' where is_delete=0 order by id desc';
        return $this->db->getAll($sql);
    }

    public function getGoodsDescAddtime(){
    $sql = 'select * from '.$this->table.' where is_delete=0 order by add_time desc';
    return $this->db->getAll($sql);
}

    public function getTrash(){
        $sql = 'select * from '.$this->table.' where is_delete=1';
        return $this->db->getAll($sql);
    }

    //随机取出指定条数的最新
    public function getRandNew($n=5){
        $sql = 'select * from '.$this->table.' where is_new = 1 and is_on_sale = 1 and is_delete = 0 order by rand() limit '.$n;
        return $this->db->getAll($sql);
    }
    //随机取出指定条数的热门
    public function getRandHot($n=5){
        $sql = 'select * from '.$this->table.' where is_hot = 1 and is_on_sale = 1 and is_delete = 0 order by rand() limit '.$n;
        return $this->db->getAll($sql);
    }
    //随机取出指定条数的推荐
    public function getRandBest($n=5){
        $sql = 'select * from '.$this->table.' where is_best = 1 and is_on_sale = 1 and is_delete = 0 order by rand() limit '.$n;
        return $this->db->getAll($sql);
    }
    //随机取出指定条数上架的数据
    public function getRandOnSale($n=5){
        $sql = 'select * from '.$this->table.' where is_on_sale = 1 and is_delete = 0 order by rand() limit '.$n;
        return $this->db->getAll($sql);
    }

    //随机取出x条指定栏目下的数据
    public function getCatRandInfo($cat_id,$limit=5){//$limit=取出的条目
        if(isset($limit)){//如果传了$limit，但没有传值，使用上面的默认值
            $limit_sentence = ' limit '.$limit;
        }else{//如果没传$limit
            $limit_sentence = '';//即无限制，取出所有的数据
        }
        $category = new CatModel();
        $cats = $category->select();//取出所有的栏目
        $sons = $category->getCatTree($cats,$cat_id);//取出子孙栏目
        $sub = array();
        $sub[] = $cat_id;//先把传来的$cat_id自身放进去查本栏目下的商品，
        //然后再找出子孙栏目的cat_id，去查其栏目下的商品，
        //如没有子孙栏目，则只需查自身栏目下的商品即可。
        if(!empty($sons)){//有子孙栏目
            foreach($sons as $value){
                $sub[] = $value['cat_id'];
            }
        }
        $in = implode(',',$sub);//用逗号隔开
        $sql = 'select * from '.$this->table.' where cat_id in ('.$in.') and is_on_sale=1 and is_delete=0 order by rand()'.$limit_sentence;
        return $this->db->getAll($sql);
    }

    //取出指定栏目的商品
    /*错误示范：
     * $cat_id = $_GET['cat_id'];
     * $sql = select ... from goods where cat_id = $cat_id;
     * 因为$cat_id对应的栏目有可能是个大栏目，而大栏目下面没有商品。
     * 商品放在了大栏目下面的子栏目里
     * 所以，正确的做法是找出$cat_id的所有子孙栏目，
     * 然后再去查所有$cat_id及其子孙栏目下的商品。
     */
    public function catGoods($cat_id,$offset=0,$limit=5){//$offset偏移量，$limit=取出的条目
        if(isset($offset) && isset($limit)){//如果传了$offset和$limit，但没有传值，使用上面的默认值
            $limit_sentence = ' limit '.$offset.','. $limit;
        }else{//如果没传$offset和$limit
            $limit_sentence = '';//即无限制，取出所有的数据
        }
        $category = new CatModel();
        $cats = $category->select();//取出所有的栏目
        $sons = $category->getCatTree($cats,$cat_id);//取出子孙栏目
        $sub = array();
        $sub[] = $cat_id;//先把传来的$cat_id自身放进去查本栏目下的商品，
                         //然后再找出子孙栏目的cat_id，去查其栏目下的商品，
                         //如没有子孙栏目，则只需查自身栏目下的商品即可。
        if(!empty($sons)){//有子孙栏目
            foreach($sons as $value){
                $sub[] = $value['cat_id'];
            }
        }
        $in = implode(',',$sub);//用逗号隔开
        $sql = 'select * from '.$this->table.' where cat_id in ('.$in.') and is_on_sale=1 and is_delete=0 order by add_time desc'.$limit_sentence;
        return $this->db->getAll($sql);
    }

    public function catGoodsCount($cat_id){
        $category = new CatModel();
        $cats = $category->select();//取出所有的栏目
        $sons = $category->getCatTree($cats,$cat_id);//取出子孙栏目
        $sub = array();
        $sub[] = $cat_id;//先把传来的$cat_id自身放进去查本栏目下的商品，
        //然后再找出子孙栏目的cat_id，去查其栏目下的商品，
        //如没有子孙栏目，则只需查自身栏目下的商品即可。
        if(!empty($sons)){//有子孙栏目
            foreach($sons as $value){
                $sub[] = $value['cat_id'];
            }
        }
        $in = implode(',',$sub);//用逗号隔开
        $sql = 'select count(*) from '.$this->table.' where cat_id in ('.$in.') and is_on_sale=1 and is_delete=0 order by add_time desc';
        return $this->db->getOne($sql);
    }

    public function getCatCountArr(){
        $cat = new CatModel();
        $cat_id_arr = $cat->getAllCatId();
        $count_arr = array();
        foreach($cat_id_arr as $key=>$value){
            $count_arr[$value['cat_id']] = $this->catGoodsCount($value['cat_id']);
        }
        return $count_arr;
    }
	
	public function select_goods_by_keyword($k,$offset=0,$limit=5,$cat_id,$act='data'){
        if(isset($offset) && isset($limit)){//如果传了$offset和$limit，但没有传值，使用上面的默认值
            $limit_sentence = ' limit '.$offset.','. $limit;
        }else{//如果没传$offset和$limit
            $limit_sentence = '';//即无限制，取出所有的数据
        }
        if($cat_id != null){
            $category = new CatModel();
            $cats = $category->select();//取出所有的栏目
            $sons = $category->getCatTree($cats,$cat_id);//取出子孙栏目
            $sub = array();
            $sub[] = $cat_id;//先把传来的$cat_id自身放进去查本栏目下的商品，
            //然后再找出子孙栏目的cat_id，去查其栏目下的商品，
            //如没有子孙栏目，则只需查自身栏目下的商品即可。
            if(!empty($sons)){//有子孙栏目
                foreach($sons as $value){
                    $sub[] = $value['cat_id'];
                }
            }
            $in = implode(',',$sub);//用逗号隔开

            $sql_cat = ' and cat_id in ('.$in.')';
        }else{
            $sql_cat = '';
        }

        $keywords = explode(' ', $k);
        $tmp_keywords = $keywords;
        foreach ($keywords as $key => $value) {
            if (strpos($value, 'new') !== false || strpos($value, '新品') !== false) {
                unset($keywords[$key]);
            }
            if (strpos($value, 'best') !== false || strpos($value, '推荐') !== false) {
                unset($keywords[$key]);
            }
            if (strpos($value, 'hot') !== false || strpos($value, '热门') !== false) {
                unset($keywords[$key]);
            }
        }
        if(!isset($keywords[0])){
            $sql = 'select * from ' . $this->table . ' where name like ' . '"' . '%%"';
        }else{
            $sql = 'select * from ' . $this->table . ' where name like ' . '"' . '%' . $keywords[0] . '%"';
        }

        if (count($keywords) > 1) {
            for ($i = 1; $i < count($keywords); $i++) {
                $sql = $sql . ' and name like ' . '"' . '%' . $keywords[$i] . '%"';
            }
        }
        if (in_array('new', $tmp_keywords) || in_array('新品', $tmp_keywords)) {
            $sql = $sql .$sql_cat.' and is_new = 1 and is_on_sale=1 and is_delete=0 order by add_time desc'.$limit_sentence;
        } elseif (in_array('best', $tmp_keywords) || in_array('推荐', $tmp_keywords)) {
            $sql = $sql .$sql_cat.' and is_best = 1 and is_on_sale=1 and is_delete=0 order by add_time desc'.$limit_sentence;
        } elseif (in_array('hot', $tmp_keywords) || in_array('热门', $tmp_keywords)) {
            $sql = $sql .$sql_cat.' and is_hot = 1 and is_on_sale=1 and is_delete=0 order by add_time desc'.$limit_sentence;
        }
        if($act == 'data'){
            return $this->db->getAll($sql);
        }elseif($act == 'count'){
            return count($this->db->getAll($sql));
        }
    }

}

?>