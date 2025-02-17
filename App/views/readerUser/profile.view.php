<?php loadPartial('head'); ?>
<?php loadPartial('header'); ?>
<?php loadPartial('navbar'); ?>

<div class="profile-page container mx-auto">
    <section class="profile-data mt-10 border-b pb-3 mb-3">
        <h2 class="text-4xl font-bold text-center mb-5">
            My profile data
        </h2>

        <div class="flex justify-between">
            <?php if (isset($user)): ?>
                <div>
                    <p class="mb-1">
                        <span class="font-semibold">Username:</span> <?= $user['name'] ?? '' ?>
                    </p>
                    <p class="mb-1">
                        <span class="font-semibold">Email:</span> <?= $user['email'] ?? '' ?>
                    </p>
                </div>
            <?php endif; ?>

            <form method="POST">
                <input type="hidden" name="_method" value="DELETE">
                <button type="submit" class="block px-4 py-2 bg-red-500 hover:bg-red-600 text-white">
                    Delete account
                </button>
            </form>
        </div>
    </section>

    <section class="user-bookmarked-articles mb-10 border">
        Bookmarked 
    </section>
</div>

<?php loadPartial('footer'); ?>