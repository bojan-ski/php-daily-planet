<?php loadPartial('head'); ?>
<?php loadPartial('header'); ?>
<?php loadPartial('navbar'); ?>

<div class="edit-selected-article-page container mx-auto">
    <div class="my-10">
        <h2 class="text-4xl text-center font-bold mb-7">
            Edit Article
        </h2>

        <form method="POST" action="/articles/edit/<?= $selectedArticle['id'] ?>">
            <input type="hidden" name="_method" value="PUT">
            <div class="mb-4 text-center">
                <input
                    type="text"
                    name="title"
                    placeholder="Title"
                    class="text-center w-full md:w-2/3 lg:w-1/2 px-4 py-2 border-b focus:outline-none"
                    minlength="5"
                    maxlength="25"
                    value="<?= $selectedArticle['title'] ?? '' ?>"
                     />
            </div>
            <?php if (isset($errors) && !empty($errors['title'])): ?>
                <?= loadPartial('formErrorMsg', [
                    'error' => $errors['title']
                ]) ?>
            <?php endif; ?>
            <div class="mb-4">
                <textarea
                    name="description"
                    placeholder="Description"
                    class="w-full px-4 py-2 border focus:outline-none"
                    rows="3"
                    minlength="50"
                    maxlength="250"
                    ><?= $selectedArticle['description'] ?? '' ?></textarea>
            </div>
            <?php if (isset($errors) && !empty($errors['description'])): ?>
                <?= loadPartial('formErrorMsg', [
                    'error' => $errors['description']
                ]) ?>
            <?php endif; ?>
            <div class="mb-4">
                <textarea
                    name="section_one"
                    placeholder="Content - section one"
                    class="w-full px-4 py-2 border focus:outline-none"
                    rows="10"
                    minlength="500"
                    maxlength="2000"
                    ><?= $selectedArticle['section_one'] ?? '' ?></textarea>
            </div>
            <?php if (isset($errors) && !empty($errors['section_one'])): ?>
                <?= loadPartial('formErrorMsg', [
                    'error' => $errors['section_one']
                ]) ?>
            <?php endif; ?>

            <?php if (isset($selectedArticle['section_two']) && !empty($selectedArticle['section_two'])): ?>
                <div class="mb-4">
                    <textarea
                        name="section_two"
                        placeholder="Content - section two"
                        class="section_two w-full px-4 py-2 border focus:outline-none"
                        rows="10"
                        minlength="500"
                        maxlength="2000"><?= $selectedArticle['section_two'] ?? '' ?></textarea>
                </div>
                <?php if (isset($errors) && !empty($errors['section_two'])): ?>
                    <?= loadPartial('formErrorMsg', [
                        'error' => $errors['section_two']
                    ]) ?>
                <?php endif; ?>
            <?php endif; ?>

            <?php if (isset($selectedArticle['section_three']) && !empty($selectedArticle['section_three'])): ?>
                <div class="mb-4">
                    <textarea
                        name="section_three"
                        placeholder="Content - section three"
                        class="section_three w-full px-4 py-2 border focus:outline-none"
                        rows="10"
                        minlength="500"
                        maxlength="2000"><?= $selectedArticle['section_three'] ?? '' ?></textarea>
                </div>
                <?php if (isset($errors) && !empty($errors['section_three'])): ?>
                    <?= loadPartial('formErrorMsg', [
                        'error' => $errors['section_three']
                    ]) ?>
                <?php endif; ?>
            <?php endif; ?>

            <button
                type="submit" class="uppercase w-full rounded-md bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 focus:outline-none">
                Edit
            </button>
        </form>
    </div>
</div>

<?php loadPartial('footer'); ?>