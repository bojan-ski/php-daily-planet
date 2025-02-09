<?php loadPartial('head'); ?>
<?php loadPartial('header'); ?>
<?php loadPartial('navbar'); ?>

<div class="home-page container mx-auto">
    <section class="app-description">

    </section>

    <section class="latest-articles">
        <?php if (empty(isset($articles))): ?>
            <h2 class="text-6xl text-center font-semibold mt-3">
                No news available
            </h2>
        <?php else: ?>
            <h4 class="text-5xl capitalize text-center font-semibold my-3">
                Latest News
            </h4>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 p-5">
                <?php foreach ($articles as $article): ?>
                    <?php loadPartial('articleCard', [
                        'article' => $article
                    ]); ?>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </section>
</div>

<?php loadPartial('footer'); ?>