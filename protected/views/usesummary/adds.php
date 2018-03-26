<?php

$materialName = MaterialsHelper::getMaterialName();
$materialGh = MaterialsHelper::getGh();
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
    <?php
        foreach ($materialGh as $key=>$val){
    ?>
            <tr bgcolor="green">
                <td><?= $val ?></td>
                <td><input type="text" name=""></td>
                <td><input type="text" name=""></td>
                <td><input type="text" name=""></td>
                <td><input type="text" name=""></td>
                <td><input type="text" name=""></td>
                <td><input type="text" name=""></td>
                <td><input type="text" name=""></td>
                <td><input type="text" name=""></td>
            </tr>
            <tr>
                <td>今日方量</td>
                <td bgcolor="yellow"><input type="text" name=""></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>今日用量</td>
                <td></td>
                <td><input type="text" name=""></td>
                <td><input type="text" name=""></td>
                <td><input type="text" name=""></td>
                <td><input type="text" name=""></td>
                <td><input type="text" name=""></td>
                <td><input type="text" name=""></td>
                <td><input type="text" name=""></td>
            </tr>
    <?php
        }
    ?>
</table>
