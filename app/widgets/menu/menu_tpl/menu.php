<!-- // меню, которое используется по умолчанию если не пeредал ничего пользователь -->
<!-- каждую категорию мы пропускаем через этот шаблон -->
<li>
    <a href="?id=<?= $id; ?>"><?= $category['title']; ?></a>
    <?php
    if (isset($category['childs'])) : ?>
        <ul>
            <?= $this->getMenuHtml($category['childs']); ?>
        </ul>
    <?php endif; ?>
</li>