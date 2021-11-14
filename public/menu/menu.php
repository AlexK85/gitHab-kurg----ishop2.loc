<!-- //этот файл будет назначаться нами из настроек как шаблон для ВИДЖЕТА -->

<?php //$parent = isset($category['childs']); ?>
<li>
    <a href="category/<?= $category['alias']; ?>"><?= $category['title']; ?></a>
    <!-- проверяем если существует $category['childs'] т.е. у данной категории есть потомки -->
    <?php
    if (isset($category['childs'])) : ?>
        <ul>
            <?= $this->getMenuHtml($category['childs']); ?>
        </ul>
    <?php endif; ?>
</li>