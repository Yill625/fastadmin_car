<?php

namespace app\admin\model;

use think\Model;

class Moneyrecord extends Model
{
    // 表名
    protected $name = 'moneyrecord';

    // 自动写入时间戳字段
    protected $autoWriteTimestamp = false;

    // 定义时间戳字段名
    protected $createTime = false;
    protected $updateTime = false;

    // 追加属性
    protected $append = [
        'sign_text'
    ];



    public function getSignList()
    {
        return ['0' => __('消费'),'1'=>'充值'];
    }


    public function getSignTextAttr($value, $data)
    {
        $value = $value ? $value : $data['sign'];
        $list = $this->getSignList();
        return isset($list[$value]) ? $list[$value] : '';
    }

    public function recordMoney($admin_id,$sign,$money,$content)
    {
        $data['admin_id']=$admin_id;
        $data['sign']=$sign;
        $data['content']=$content;
        $data['ctime']=date('Y-m-d H:i:s',time());
        $data['money']=$money;
        return $this->save($data);
    }


}
