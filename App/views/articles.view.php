<?php loadPartial('head'); ?>
<?php loadPartial('header'); ?>
<?php loadPartial('navbar'); ?>

<div class="articles-page container mx-auto">
    <?php if (isset($articles) && !empty($articles)): ?>
        <section class="articles-list mt-10 mb-3">
            <h4 class="text-5xl capitalize text-center font-semibold mb-5">
                <?= $pageTitle ?>
            </h4>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 p-5">
                <?php foreach ($articles as $article): ?>
                    <?php loadPartial('articleCard', [
                        'article' => $article
                    ]); ?>
                <?php endforeach; ?>
            </div>
        </section>

        <section class="mb-10">
            pagination
        </section>
    <?php else: ?>
        <h2 class="text-6xl text-center font-semibold mt-20">
            No news available
        </h2>
    <?php endif ?>
</div>

<?php loadPartial('footer'); ?>