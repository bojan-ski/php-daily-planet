<div class="article-card border p-4">
    <h4 class="text-3xl capitalize text-center font-semibold mb-3">
        <?= isset($article['title']) ? checkContent($article['title']) : '' ?>
    </h4>
    <p class="mb-3">
        <?= isset($article['description']) ? checkContent($article['description']) : '' ?>
    </p>

    <div class="mb-5">
        <p>
            <span class="font-semibold">Published:</span>
            <?= isset($article['created_at']) ? formateDate(checkContent($article['created_at'])) : '' ?>
        </p>
    </div>
    <a href="/<?= getPagePaths()[0] . '/' . $article['id'] ?>" class="block rounded-md w-full text-center px-5 py-2.5 border font-medium bg-gray-100 hover:bg-gray-200">
        Read More
    </a>
</div>