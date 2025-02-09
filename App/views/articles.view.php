<?php loadPartial('head'); ?>
<?php loadPartial('header'); ?>
<?php loadPartial('navbar'); ?>

<div class="articles-page container mx-auto">
    <section class="articles-list mb-5">
        <h4 class="text-5xl capitalize text-center font-semibold my-3">
            All News
        </h4>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 p-5">
            <?php foreach ($articles as $article): ?>
                <?php loadPartial('article/articleCard', [
                    'article' => $article
                ]); ?>
            <?php endforeach; ?>
        </div>
    </section>

    <section class="mb-5">
        pagination
    </section>
</div>

<?php loadPartial('footer'); ?>