<?php

//如果检测不到该变量则判断为非法访问该文件。
//conntroller都define(定义常量)
//非conntroller都defined(检验常量)
defined('PERMISSION')||exit('非法访问');

class BannersModel extends Model{
    protected $table = 'banner';
    protected $primarykey = 'id';
    //自动过滤
    protected $fields = array(//这里先手动写好，以后再改成自动分析 desc
        'id',
        'title',
        'href',
        'img_url',
        'img_url_120x80',
        'img_url_350x220',
        'on_banner',
        'add_time',
        'img_url_link'
    );
    //自动填充
    protected $_auto = array(
        array('on_banner','value',0),
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
        array('title',1,'标题必须在50个字符以内','length','1,50'),
        array('href',1,'链接必须在30个字符以内','length','1,150'),
        array('on_banner',0,'on_banner只能是0或1','in','0,1')
    );

    public function getBannersDescAddtimeLimit($limit=5){ //$limit=取出的条目
        if(isset($limit)){
            $limit_sentence = ' limit '. $limit;
        }else{
            $limit_sentence = '';//即无限制，取出所有的数据
        }
        $sql = 'select * from '.$this->table.' order by add_time desc'.$limit_sentence;
        return $this->db->getAll($sql);
    }

    public function edit($data,$id){
        return $this->update($data,$id);
    }

    public function recovery($id){
        return $this->update(array('is_delete'=>0,'is_on_sale'=>1),$id);
    }

    public function getBanner($id){
        $sql = 'select * from '.$this->table.' where id = '.$id;
        return $this->db->getRow($sql);
    }

    public function getBanners(){
        $sql = 'select * from '.$this->table.' where is_delete=0';
        return $this->db->getAll($sql);
    }

    public function getBannersDescId(){
        $sql = 'select * from '.$this->table.' order by id desc';
        return $this->db->getAll($sql);
    }

    public function getBannersDescAddtime(){
    $sql = 'select * from '.$this->table.' order by add_time desc';
    return $this->db->getAll($sql);
    }
}

?>