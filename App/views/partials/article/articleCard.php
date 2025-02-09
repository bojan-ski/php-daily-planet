<div class="article-card border p-4">
    <h4 class="text-3xl capitalize text-center font-semibold mb-3">
        <?= $article['title'] ?>
    </h4>
    <p class="mb-3">
        <?= $article['description'] ?>
    </p>

    <div class="mb-5">
        <p>
            <span class="font-semibold">Published:</span>
            <?= formateData($article['created_at']) ?>
        </p>
        <p>
            <span class="font-semibold">Category:</span>
            <?= $article['category'] ?>
        </p>
    </div>
    <a href="/articles/<?= $listing['id'] ?>" class="block w-full text-center px-5 py-2.5 border font-medium hover:bg-gray-200">
        Details
    </a>
</div>