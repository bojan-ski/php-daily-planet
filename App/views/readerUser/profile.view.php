<?php loadPartial('head'); ?>
<?php loadPartial('header'); ?>
<?php loadPartial('navbar'); ?>

<div class="profile-page container mx-auto">
    <section class="profile-data mt-10 border-b pb-2 mb-5">
        <h2 class="text-4xl font-bold text-center mb-3">
            My profile data
        </h2>

        <?php if (isset($user)): ?>
            <div class="flex justify-between">
                <div>
                    <p class="text-lg mb-1 capitalize">
                        <span class="font-semibold">Username:</span> <?= $user['name'] ?? '' ?>
                    </p>
                    <p class="text-lg mb-1">
                        <span class="font-semibold">Email:</span> <?= $user['email'] ?? '' ?>
                    </p>
                </div>

                <form method="POST">
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit" class="block px-4 py-2 bg-red-500 hover:bg-red-600 text-white">
                        Delete account
                    </button>
                </form>
            </div>
        <?php endif; ?>
    </section>

    <section class="user-bookmarked-articles mb-10">
        <?php if (isset($bookmarkedArticles) && !empty($bookmarkedArticles)): ?>
            <h4 class="text-4xl capitalize text-center font-semibold mb-3">
                Bookmarked Articles
            </h4>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 p-5">
                <?php foreach ($bookmarkedArticles as $article): ?>
                    <?php loadPartial('articleCard', [
                        'article' => $article
                    ]); ?>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <h2 class="text-5xl text-center font-semibold">
                You have no bookmarked articles
            </h2>
        <?php endif ?>
    </section>
</div>

<?php loadPartial('footer'); ?>