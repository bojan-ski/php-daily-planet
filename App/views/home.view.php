<?php loadPartial('head'); ?>
<?php loadPartial('header'); ?>
<?php loadPartial('navbar'); ?>

<div class="home-page container mx-auto">
    <section class="app-description">

    </section>

    <section class="latest-articles">
        <h4 class="text-5xl capitalize text-center font-semibold my-3">
            Latest News
        </h4>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 p-5">
            <?php foreach ($articles as $article): ?>
                <?php loadPartial('article/articleCard', [
                    'article' => $article
                ]); ?>
            <?php endforeach; ?>
        </div>
    </section>
</div>

<?php loadPartial('footer'); ?>