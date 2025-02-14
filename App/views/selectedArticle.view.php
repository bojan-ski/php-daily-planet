<?php

use Framework\HasPermission;

?>
<?php loadPartial('head'); ?>
<?php loadPartial('header'); ?>
<?php loadPartial('navbar'); ?>

<div class="selected-article-page container mx-auto">

    <div class="mt-10 mb-5 flex align-center justify-between">
        <a class="block px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white" href="/articles">
            Back
        </a>

        <?php if (HasPermission::isAllowed($selectedArticle['user_id'])): ?>
            <div class="flex align-center">
                <a class="block px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white mr-3" href="/articles">
                    Edit
                </a>

                <form action="" method="POST">
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit" class="block px-4 py-2 bg-red-500 hover:bg-red-600 text-white">
                        Delete
                    </button>
                </form>
            </div>
        <?php endif; ?>
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