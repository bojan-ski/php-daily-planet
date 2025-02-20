<?php loadPartial('head'); ?>
<?php loadPartial('header'); ?>
<?php loadPartial('navbar'); ?>
<?php loadPartial('popUpMsg'); ?>

<div class="articles-page container mx-auto">
    <?php if (isset($articles) && !empty($articles)): ?>
        <section class="articles-list mt-10 mb-3">
            <h4 class="text-5xl capitalize text-center font-semibold mb-5">
                <?= $pageTitle ?>
            </h4>

            <?php if (getPagePaths()[0] == 'articles'): ?>
                <form method="POST" action="/articles/search" class="text-center mt-10">
                    <input
                        type="text"
                        name="article_title"
                        placeholder="Enter article title"
                        class="rounded-md w-1/2 md:w-1/3 mb-3 px-4 py-2 border"
                        value="<?= $search ?? '' ?>"
                        required />
                    <?php if (!isset($search)): ?>
                        <button type="submit" class="rounded-md w-1/3 md:w-1/6 bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 focus:outline-none">
                            <i class="fa fa-search"></i> Search
                        </button>
                    <?php else: ?>
                        <a href="/articles" type="button" class="rounded-md w-1/3 md:w-1/6 bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 focus:outline-none">
                            Reset
                        </a>
                    <?php endif ?>
                </form>
            <?php endif ?>

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