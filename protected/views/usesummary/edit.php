<?php

$add_time = empty($data['add_time']) || empty(strtotime($data['add_time']))?'':date("Y-m-d",strtotime($data['add_time']));
$materialName = MaterialsHelper::getMaterialName();
$getGh = MaterialsHelper::getGh();
?>
<style>
    a { text-decoration: none; }

    table { margin: auto; }

    table, table tr, table tr td { border-collapse: collapse; border: 1px solid grey; text-align: center; }

    td {height: 30px; }
</style>
<div style="margin: auto;width: 30%;">
    <form action="" method="post">
        <table border="1" method="post">
            <tr>
                <td width="240">日期:</td>
                <td><input type="text" name="add_time" id="add_time" value="<?= $add_time ?>"></td>
            </tr>
            <tr>
                <td>配合比缸号:</td>
                <td><?= $getGh[$data['gh_type']] ?></td>
            </tr>
            <tr>
                <td>生产方量</td>
                <td><input type="text" name="gh_amount" value="<?= $data['gh_amount'] ?>"></td>
            </tr>
            <tr>
                <td>水</td>
                <td><input type="text" name="m_p_water" value="<?= $data['m_p_water'] ?>"></td>
            </tr>
            <?php foreach ($materialName as $key => $val) {
                $name = 'm_p_' . $key;
                ?>
                <tr>
                    <td><?= $val ?></td>
                    <td><input type="text" name="<?= $name ?>" value="<?= $data[$name] ?>"></td>
                </tr>
            <?php } ?>
            <tr>
                <input type="hidden" name="id" value="<?= $id ?>">
                <input type="hidden" name="gh_type" value="<?= $data['gh_type'] ?>">
                <td colspan="2">
                    <button><a href="<?= $this->createUrl('usesummary/index') ?>">返回列表</a></button>&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="submit" value="修改">
                </td>
            </tr>
        </table>
    </form>
</div>

<script>
    laydate.render({
        elem: '#add_time'
    });

</script>