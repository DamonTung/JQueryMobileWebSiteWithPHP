<?php

//如果检测不到该变量则判断为非法访问该文件。
//conntroller都define(定义常量)
//非conntroller都defined(检验常量)
defined('PERMISSION')||exit('非法访问');

class InfoModel extends Model{
    protected $table = 'info';
    protected $primarykey = 'id';
    //自动过滤
    protected $fields = array(//这里先手动写好，以后再改成自动分析 desc
        'id',
        'name',
        'price',
        'director',
        'area',
        'release_date',
        'desc',
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
        array('name',1,'片名必须在4到100个字符以内','length','4,100'),
        array('price',1,'票价必须在0~200以内','between','0,200'),
        array('director',1,'导演名必须在2到20个字符以内','length','2,20'),
        array('area',1,'地区名必须在2到30个字符以内','length','2,30'),
        //array('release_date',1,'上映时间必须在4到100个字符以内','length','4,100'),
        array('is_new',0,'is_new只能是0或1','in','0,1'),
        array('is_best',0,'is_best只能是0或1','in','0,1'),
        array('is_hot',0,'is_hot只能是0或1','in','0,1')
    );


    /*
     * 作用：把商品放到回收站，即is_delete字段置为1
     * parm int id
     * return bool
     */

    public function trash($id){
        return $this->update(array('is_delete'=>1),$id);
    }

    public function getInfo($offset=0,$limit=5){//$offset偏移量，$limit=取出的条目
        if(isset($offset) && isset($limit)){
            $limit_sentence = ' limit '.$offset.','. $limit;
        }else{
            $limit_sentence = '';//即无限制，取出所有的数据
        }
        $sql = 'select * from '.$this->table.' where is_on_sale=1 and is_delete=0 order by add_time desc'.$limit_sentence;
        return $this->db->getAll($sql);
    }

    public function getInfosCount(){
        $sql = 'select count(*) from '.$this->table.' where is_on_sale=1 and is_delete=0';
        return $this->db->getOne($sql);
    }

    public function get_total_page($total_num,$each_page_num){
        return ceil($total_num/$each_page_num);
    }

    public function update_offset($offset,$each_page_num){
        return $offset+$each_page_num;
    }

    public function check($page,$each_page_num){
        $total_num = $this->getInfosCount();
        if($page > ceil($total_num/$each_page_num)){
            return true;
        }
    }

}

?>