<?php loadPartial('head'); ?>
<?php loadPartial('header'); ?>
<?php loadPartial('navbar'); ?>
<?php loadPartial('popUpMsg'); ?>

<div class="app-authors-page container mx-auto">
    
    <?php loadPartial('addAuthor/authorsNav'); ?>

    <?php if (isset($authorUsers) && !empty($authorUsers)): ?>
        <section class="authors-list overflow-x-auto mb-10">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Account created</th>
                        <th>Remove</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($authorUsers as $user): ?>
                        <tr class="hover">
                            <th><?= $user['id'] ?></th>
                            <td><?= $user['name'] ?></td>
                            <td><?= $user['email'] ?></td>
                            <td><?= $user['created_at'] ?></td>
                            <td>
                                <form method="POST" action="/authors/removeAuthor">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <input type="hidden" name="author_id" value="<?= $user['id'] ?>">
                                    <button type="submit" class="block rounded-md px-4 py-2 bg-red-500 hover:bg-red-600 text-white">
                                        X
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>
    <?php else: ?>
        <h2 class="text-6xl text-center font-semibold mt-20">
            No reader users
        </h2>
    <?php endif ?>
</div>

<?php loadPartial('footer'); ?>