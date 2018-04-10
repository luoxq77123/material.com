<?php
$materialName = MaterialsHelper::getMaterialName();
$materialGh = MaterialsHelper::getGh();
?>
<style>
    a{text-decoration: none;}
    table{margin: auto;}
    table,table tr, table tr td{border-collapse:collapse;border:1px solid grey; text-align: center;}
    td{width:100px;height: 30px;}
</style>
<div style="width: ">
    <div style="margin-left: 50px;height: 20px;padding: 10px 0;">
        <button><a href="<?= $this->createUrl('usesummary/add') ?>">添加</a></button>
        &nbsp;&nbsp;
        <button><a href="<?= $this->createUrl('index/index') ?>">返回首页</a></button>
    </div>
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
            <td><?= ToolHelper::timeYmd($val['add_time']) ?></td>
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
            <td>
                <button><a href="<?= $this->createUrl('usesummary/edit',['id'=> $val['id']]) ?>">修改</a></button>
                <button class="index_del" data-id="<?= $val['id']; ?>">
                    <span>删除</span>
                </button>
            </td>
        </tr>
    <?php } ?>
    <tr>
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


<script>
    $('.index_del').on('click', function () {
        var id = $(this).data('id');
        if (confirm("确定删除该记录吗?")) {
            $.ajax({
                url: "<?= $this->createUrl("/usesummary/del") ?>",
                type: "POST",
                dataType: "json",
                data: {id: id},
                success: function (result) {
                    if (result.status == 0) {
                        window.location.reload();
                    } else {
                        layer.open({
                            content: result.msg,
                            skin: 'msg',
                            time: 3 //2秒后自动关闭
                        });
                    }
                }
            })
        }
    })

</script>
