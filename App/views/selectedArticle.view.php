<?php loadPartial('head'); ?>
<?php loadPartial('header'); ?>
<?php loadPartial('navbar'); ?>

<div class="selected-article-page container mx-auto">

    <div class="mt-10 mb-5">
        <a class="inline-block hover:text-gray-500 hover:underline" href="/articles">
            <i class="fa fa-arrow-alt-circle-left"></i>
            Back
        </a>
    </div>

    <div class="mb-3">
        <h4 class="text-3xl capitalize text-center font-semibold mb-5">
            <?= isset($selectedArticle['title']) ? checkContent($selectedArticle['title']) : '' ?>
        </h4>

        <p class="mb-3">
            <?= isset($selectedArticle['section_one']) ? checkContent($selectedArticle['section_one']) : '' ?>
        </p>
        <p class="mb-3">
            <?= isset($selectedArticle['section_two']) ? checkContent($selectedArticle['section_two']) : '' ?>
        </p>
        <p>
            <?= isset($selectedArticle['section_three']) ? checkContent($selectedArticle['section_three']) : '' ?>
        </p>
    </div>

    <div class="mb-10">
        <p>
            <span class="font-semibold">Author:</span>
            <?= isset($selectedArticleAuthor['name']) ? checkContent($selectedArticleAuthor['name']) : '' ?>
        </p>
        <p>
            <span class="font-semibold">Published:</span>
            <?= isset($selectedArticle['created_at']) ? formateDate(checkContent($selectedArticle['created_at'])) : '' ?>
        </p>
    </div>
</div>

<?php loadPartial('footer'); ?>