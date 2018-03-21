<?php
/**
 * Created by PhpStorm.
 * User: xckj-luoxq
 * Date: 2018/3/21 0021
 * Time: 下午 17:38
 */
$materialName = MaterialsHelper::getMaterialName();
?>

<table border="1" width="100%" height="500">
    <tr>
        <td colspan="9"></td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <?php foreach ($materialName as $val){ ?>
            <td><?= $val ?></td>
        <?php } ?>

        <td></td>
    </tr>
    <tr>
        <td colspan="2">昨日结存</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td colspan="2">今日入库</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>

    <tr>
        <td>配合比缸号</td>
        <td>水</td>
        <?php foreach ($materialName as $val){ ?>
            <td><?= $val ?></td>
        <?php } ?>
        <td>容重</td>
    </tr>
</table>
