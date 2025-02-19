<?php $pageUri = getPagePaths()[0]; ?>

<div class="bookmark-option">
    <?php if ($articleBookmarked): ?>
        <form method="POST" action="/<?= $pageUri ?>/<?= $selectedArticle['id'] ?>/bookmarkFeature">
            <input type="hidden" name="_method" value="DELETE">
            <button type="submit" class="block rounded-md px-4 py-2 bg-red-500 hover:bg-red-600 text-white mr-3">
                Remove Bookmark
            </button>
        </form>
    <?php else: ?>
        <form method="POST" action="/<?= $pageUri ?>/<?= $selectedArticle['id'] ?>/bookmarkFeature">
            <button type="submit" class="block rounded-md px-4 py-2 bg-green-500 hover:bg-green-600 text-white mr-3">
                Bookmark
            </button>
        </form>
    <?php endif ?>
</div>