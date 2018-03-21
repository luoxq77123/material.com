<table border="1">
    <tr>
        <td>材料名称</td>
        <td>日期</td>
        <td>供应商</td>
        <td>送货编号</td>
        <td>入库仓号</td>
        <td>今日入库总量（单位：吨）</td>
        <td>材料员</td>
        <td>备注</td>
        <td>操作</td>
    </tr>
    <?php
    foreach ($data as $val){
        $factoryName = MaterialsHelper::getFactoryName($val['ml_id']);
        $su_id = isset($factoryName[$val['su_id']])?$factoryName[$val['su_id']]:'';
        MaterialsHelper::getMaterialsUser();
        ?>
    <tr>
        <td><?= MaterialsHelper::getMaterialName($val['ml_id'])?></td>
        <td><?= empty(strtotime($val['add_time'])) ? '' : date("Y-m-d", strtotime($val['add_time'])) ?></td>
        <td><?= $su_id ?></td>
        <td><?= $val['ml_no'] ?></td>
        <td><?= $val['ku_nums'] ?></td>
        <td><?= $val['num']/1000 ?></td>
        <td><?= MaterialsHelper::getMaterialsUser($val['user_cl']) ?></td>
        <td><?= $val['remarks'] ?></td>
        <td><button><a href="<?= $this->createUrl('materials/edit',['id'=> $val['id']]) ?>">修改</a></button></td>
    </tr>
    <?php } ?>
</table>


<?php


$this->widget('CLinkPager',array(
    'header' => '',
    'prevPageLabel' => '上一页',
    'nextPageLabel' => '下一页',
    'pages' => $pages,
));
