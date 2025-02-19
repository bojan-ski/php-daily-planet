<?php loadPartial('head'); ?>
<?php loadPartial('header'); ?>
<?php loadPartial('navbar'); ?>

<div class="app-authors-page container mx-auto">
    
    <?php loadPartial('addAuthor/authorsNav'); ?>

    <section class="add-author flex justify-center items-center w-full md:w-2/3 lg:w-1/2 mx-auto">
        <div class="p-8 w-full">
            <h2 class="text-4xl text-center font-bold mb-4">
                Add Author
            </h2>

            <form method="POST" action="/add_author/addAuthor">
                <div class="mb-4">
                    <input
                        type="text"
                        name="name"
                        placeholder="Full Name"
                        class="w-full px-4 py-2 border focus:outline-none rounded-md"
                        value="<?= $user['name'] ?? '' ?>"
                        required />
                </div>
                <?php if (isset($errors) && !empty($errors['name'])): ?>
                    <?= loadPartial('formErrorMsg', [
                        'error' => $errors['name']
                    ]) ?>
                <?php endif; ?>
                <div class="mb-4">
                    <input
                        type="email"
                        name="email"
                        placeholder="Email Address"
                        class="w-full px-4 py-2 border focus:outline-none rounded-md"
                        value="<?= $user['email'] ?? '' ?>"
                        required />
                </div>
                <?php if (isset($errors) && !empty($errors['email'])): ?>
                    <?= loadPartial('formErrorMsg', [
                        'error' => $errors['email']
                    ]) ?>
                <?php endif; ?>
                <div class="mb-4">
                    <input
                        type="password"
                        name="password"
                        placeholder="Password"
                        class="w-full px-4 py-2 border focus:outline-none rounded-md"
                        required />
                </div>
                <?php if (isset($errors) && !empty($errors['password'])): ?>
                    <?= loadPartial('formErrorMsg', [
                        'error' => $errors['password']
                    ]) ?>
                <?php endif; ?>
                <button
                    type="submit" class="w-full rounded-md bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 focus:outline-none">
                    Register Author
                </button>
            </form>
        </div>
    </section>
</div>

<?php loadPartial('footer'); ?>