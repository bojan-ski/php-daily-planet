<?php loadPartial('head'); ?>
<?php loadPartial('header'); ?>
<?php loadPartial('navbar'); ?>

<div class="submit-article-page container mx-auto">
    <section class="select-options mt-10 mb-5">
        <div class="form-control">
            <label class="label cursor-pointer">
                <span class="label-text font-bold">Content - section 2</span>
                <input type="checkbox" class="toggle select-option-one" checked="checked" />
            </label>
            <label class="label cursor-pointer">
                <span class="label-text font-bold">Content - section 3</span>
                <input type="checkbox" class="toggle select-option-two" checked="checked" />
            </label>
        </div>
    </section>

    <section class="new-article mb-10">
        <h2 class="text-4xl text-center font-bold mb-7">
            New Article
        </h2>

        <form method="POST" action="/submit_article/submitArticle">
            <div class="mb-4 text-center">
                <input
                    type="text"
                    name="title"
                    placeholder="Title"
                    class="text-center w-full md:w-2/3 lg:w-1/2 px-4 py-2 border-b focus:outline-none"
                    minlength="5"
                    maxlength="25"
                    value="<?= $newArticle['title'] ?? '' ?>"
                    required />
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
                    required><?= $newArticle['description'] ?? '' ?></textarea>
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
                    required><?= $newArticle['section_one'] ?? '' ?></textarea>
            </div>
            <?php if (isset($errors) && !empty($errors['section_one'])): ?>
                <?= loadPartial('formErrorMsg', [
                    'error' => $errors['section_one']
                ]) ?>
            <?php endif; ?>
            <div class="mb-4">
                <textarea
                    name="section_two"
                    placeholder="Content - section two"
                    class="section_two w-full px-4 py-2 border focus:outline-none"
                    rows="10"
                    minlength="500"
                    maxlength="2000"><?= $newArticle['section_two'] ?? '' ?></textarea>
            </div>
            <?php if (isset($errors) && !empty($errors['section_two'])): ?>
                <?= loadPartial('formErrorMsg', [
                    'error' => $errors['section_two']
                ]) ?>
            <?php endif; ?>
            <div class="mb-4">
                <textarea
                    name="section_three"
                    placeholder="Content - section three"
                    class="section_three w-full px-4 py-2 border focus:outline-none"
                    rows="10"
                    minlength="500"
                    maxlength="2000"><?= $newArticle['section_three'] ?? '' ?></textarea>
            </div>
            <?php if (isset($errors) && !empty($errors['section_three'])): ?>
                <?= loadPartial('formErrorMsg', [
                    'error' => $errors['section_three']
                ]) ?>
            <?php endif; ?>
            <button
                type="submit" class="w-full rounded-md bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 focus:outline-none">
                Login
            </button>
        </form>
    </section>
</div>

<?php loadPartial('footer'); ?>