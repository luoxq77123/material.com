<?php
$materialName = MaterialsHelper::getMaterialName();
$materialGh = MaterialsHelper::getGh();
?>
<style>
    table{margin: auto;}
</style>
<div style="width: ">
<table border="1">
    <tr>
        <td>生产日期</td>
        <td>配合比缸号</td>
        <td>生产方量</td>
        <td>水</td>
        <?php foreach ($materialName as $val){ ?>
            <td><?= $val ?></td>
        <?php } ?>
        <td>容重</td>
        <td>操作</td>
    </tr>
    <?php foreach($data as $val){ ?>
        <tr>
            <td><?= toolHelper::timeYmd($val['add_time']) ?></td>
            <td><?= isset($materialGh[$val['gh_type']])?$materialGh[$val['gh_type']]:'' ?></td>
            <td><?= $val['gh_amount'] ?></td>
            <td><?= $val['m_p_water'] ?></td>
            <td><?= $val['m_p_cement'] ?></td>
            <td><?= $val['m_p_ash'] ?></td>
            <td><?= $val['m_p_gravel'] ?></td>
            <td><?= $val['m_p_sand'] ?></td>
            <td><?= $val['m_p_river_sand'] ?></td>
            <td><?= $val['m_p_additive'] ?></td>
            <td><?= $val['capacity'] ?></td>
            <td><button><a href="<?= $this->createUrl('usesummary/edit',['id'=> $val['id']]) ?>">修改</a></button></td>
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
?>
</div>