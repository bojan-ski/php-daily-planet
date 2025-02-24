<?php

use Framework\Session;

?>

<?php loadPartial('head'); ?>
<?php loadPartial('header'); ?>
<?php loadPartial('navbar'); ?>
<?php loadPartial('popUpMsg'); ?>

<div class="selected-article-page container mx-auto">
    <div class="mt-10 mb-5 flex align-center justify-between">
        <a class="back-btn cursor-pointer block rounded-md px-6 py-2 bg-gray-500 hover:bg-gray-600 text-white" href="/<?= getPagePaths()[0] ?>">
            <i class="fa-solid fa-arrow-left"></i>
        </a>

        <?php if (Session::exist('user')): ?>
            <?php if (Session::get('user')['role'] == 'reader'): ?>
                <?php loadPartial('selectedArticle/bookmarkOption', [
                    'selectedArticle' => $selectedArticle,
                    'articleBookmarked' => $articleBookmarked
                ]); ?>
            <?php else: ?>
                <?php loadPartial('selectedArticle/permissionOptions', [
                    'selectedArticle' => $selectedArticle
                ]); ?>
            <?php endif ?>
        <?php endif ?>
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
            <?= isset($selectedArticle['created_at']) ? formatDate(checkContent($selectedArticle['created_at'])) : '' ?>
        </p>
    </div>
</div>

<?php loadPartial('footer'); ?>