<style>
    a {
        text-decoration: none;
    }
    table,table tr, table tr td{border-collapse:collapse;border:1px solid grey; }

</style>

<div style="margin: auto;width: 60%;">

    <div style="margin-left: 50px;height: 20px;padding: 10px 0;">
        <button><a href="<?= $this->createUrl('materials/add') ?>">添加</a></button>&nbsp;&nbsp;
        <button><a href="<?= $this->createUrl('index/index') ?>">返回首页</a></button>
    </div>

    <div style="">
        <table border="1" cellpadding="0" cellspacing="0">
            <tr align="center">
                <td width="80">材料名称</td>
                <td width="80">日期</td>
                <td width="200">供应商</td>
                <td width="80">送货编号</td>
                <td width="80">入库仓号</td>
                <td width="200">今日入库总量（单位：吨）</td>
                <td width="80">材料员</td>
                <td width="80">备注</td>
                <td width="80">操作</td>
            </tr>
            <?php
            foreach ($data as $val) {
                $factoryName = MaterialsHelper::getFactoryName($val['ml_id']);
                $su_id = isset($factoryName[$val['su_id']]) ? $factoryName[$val['su_id']] : '';
                MaterialsHelper::getMaterialsUser();
                ?>
                <tr align="center">
                    <td><?= MaterialsHelper::getMaterialName($val['ml_id']) ?></td>
                    <td><?= toolHelper::timeYmd($val['add_time']) ?></td>
                    <td><?= $su_id ?></td>
                    <td><?= $val['ml_no'] ?></td>
                    <td><?= $val['ku_nums'] ?></td>
                    <td><?= $val['num'] / 1000 ?></td>
                    <td><?= MaterialsHelper::getMaterialsUser($val['user_cl']) ?></td>
                    <td><?= $val['remarks'] ?></td>
                    <td>
                        <button>
                            <a href="<?= $this->createUrl('materials/edit', ['id' => $val['id']]) ?>">修改</a>
                        </button>
                    </td>
                </tr>
            <?php } ?>
            <tr align="center">
                <td colspan="12">
                    <?php
                    $this->widget('CLinkPager', array(
                        'header' => '',
                        'prevPageLabel' => '上一页',
                        'nextPageLabel' => '下一页',
                        'pages' => $pages,
                    ));
                    ?>
                </td>
            </tr>
        </table>
    </div>
</div>


