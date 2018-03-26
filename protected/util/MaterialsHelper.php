<?php
class MaterialsHelper
{
    /**
     * 获取材料名称
     */
    public static function getMaterialName($key='')
    {
        $materialName = [
            'cement'=>'水泥',
            'ash'=>'火山灰',
            'gravel'=>'碎石',
            'sand'=>'机制砂',
            'river_sand'=>'河沙',
            'additive'=>'外加剂',
        ];
        if(empty($key)){
            return $materialName;
        }else{
            return isset($materialName[$key]) ? $materialName[$key] : '';
        }
    }

    /**
     * 获取材料对应厂家
     */
    public static function getFactoryName($key='')
    {
        $factoryName = [
            'cement'=>['保山昆钢嘉华水泥有限公司'],//水泥
            'ash'=>['永俊建材有限公司'],//火山灰
            'gravel'=>['腾冲德瑞矿业有限公司'],//碎石
            'sand'=>['腾冲德瑞矿业有限公司'],//机制砂
            'river_sand'=>['腾冲德瑞矿业有限公司'],//河沙
            'additive'=>['云南森博混凝土外加剂有限公司'],//外加剂
        ];
        if(empty($key)){
            return $factoryName;
        }else{
            return isset($factoryName[$key]) ? $factoryName[$key]: '';
        }

    }

    /**
     * 获取材料缸号
     */
    public static function getGh()
    {
        $ghArr = [
            1=>'砂浆(c15)',
            2=>'砂浆(c30)',
            3=>'C15',
            //4=>'C20',
            5=>'C25',
            6=>'C30',
            7=>'C30P6',
            //8=>'C35',
            //9=>'C40',
        ];
        return $ghArr;
    }

    /**
     * 获取材料员
     */
    public static function getMaterialsUser($key='')
    {
        $user= [
            '1'=>'陈光强'
        ];
        if(empty($key)){
            return $user;
        }else{
            return isset($user[$key])?$user[$key]:'';
        }
    }




}