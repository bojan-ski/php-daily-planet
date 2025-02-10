<?php loadPartial('head'); ?>
<?php loadPartial('header'); ?>
<?php loadPartial('navbar'); ?>

<div class="error-page container mx-auto">
    <div class="text-center w-1/2 mx-auto mt-24">
        <?php if (isset($errStatus)): ?>
            <h2 class="text-4xl font-semibold mb-3">
                Status: <?= $errStatus ?>
            </h2>
        <?php endif; ?>

        <h1 class="text-6xl font-bold mb-5">
            <?= $errMessage ?>
        </h1>
    </div>
</div>

<?php loadPartial('footer'); ?>