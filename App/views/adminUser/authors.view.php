<?php loadPartial('head'); ?>
<?php loadPartial('header'); ?>
<?php loadPartial('navbar'); ?>

<div class="app-authors-page container mx-auto">
    <?php if (isset($authorUsers) && !empty($authorUsers)): ?>
        <div class="overflow-x-auto my-10">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Account created</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($authorUsers as $user): ?>
                        <tr class="hover">
                            <th><?= $user['id'] ?></th>
                            <td><?= $user['name'] ?></td>
                            <td><?= $user['email'] ?></td>
                            <td><?= $user['created_at'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <h2 class="text-6xl text-center font-semibold mt-20">
            No reader users
        </h2>
    <?php endif ?>
</div>

<?php loadPartial('footer'); ?>