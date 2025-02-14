<?php

use Framework\HasPermission;

?>

<?php if (HasPermission::isAllowed($selectedArticle['user_id'])): ?>
    <div class="flex align-center">

        <?php if (HasPermission::editOption($selectedArticle['status'], $selectedArticle['user_id'])): ?>
            <a class="block px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white mr-3" href="/articles/edit/<?= $selectedArticle['id'] ?>">
                Edit
            </a>
        <?php endif; ?>

        <?php if (HasPermission::approveOption($selectedArticle['status'])): ?>
            <form method="POST">
                <input type="hidden" name="_method" value="PUT">
                <button type="submit" class="block px-4 py-2 bg-green-500 hover:bg-green-600 text-white mr-3">
                    Approve
                </button>
            </form>
        <?php endif; ?>

        <form method="POST">
            <input type="hidden" name="_method" value="DELETE">
            <button type="submit" class="block px-4 py-2 bg-red-500 hover:bg-red-600 text-white">
                Delete
            </button>
        </form>
    </div>
<?php endif; ?>