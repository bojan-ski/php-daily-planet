<?php $pageUri = getPagePaths()[0]; ?>

<div class="bookmark-option">
    <?php if ($articleBookmarked): ?>
        <form method="POST" action="/<?= $pageUri ?>/<?= $selectedArticle['id'] ?>/bookmarkFeature">
            <input type="hidden" name="_method" value="DELETE">
            <button type="submit" class="block rounded-md px-6 py-2 bg-gray-500 hover:bg-gray-600 text-white mr-3">
            <i class="fa-solid fa-bookmark"></i>
            </button>
        </form>
    <?php else: ?>
        <form method="POST" action="/<?= $pageUri ?>/<?= $selectedArticle['id'] ?>/bookmarkFeature">
            <button type="submit" class="block rounded-md px-6 py-2 bg-gray-500 hover:bg-gray-600 text-white mr-3">
                <i class="fa-regular fa-bookmark"></i>
            </button>
        </form>
    <?php endif ?>
</div>