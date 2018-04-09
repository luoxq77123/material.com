<style>
    a{margin:auto;text-decoration: none;margin-right:20px; }
    button{margin: auto;width: 100px;padding:5px;}
</style>
<div style="width: 80%;margin: auto;margin-top: 20%">
    <div style="margin: auto;width: 60%;text-align: center;">

        <a href="<?= $this->createUrl('materials/index') ?>"><button>材料入库</button></a>
        <a href="<?= $this->createUrl('usesummary/index') ?>"><button>材料使用</button></a>
        <a href="<?= $this->createUrl('usesummary/mexport') ?>"><button>记录导出</button></a>

    </div>

</div>