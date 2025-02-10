<?php loadPartial('head'); ?>
<?php loadPartial('header'); ?>
<?php loadPartial('navbar'); ?>

<div class="home-page container mx-auto">
    <!-- WORK ON -->
    <section class="app-hero mb-5">

        <div class="hero bg-gray-200">
            <div class="hero-content flex-col lg:flex-row-reverse">
                <img
                    src="https://img.daisyui.com/images/stock/photo-1635805737707-575885ab0820.webp"
                    class="max-w-sm rounded-lg shadow-2xl" />
                <div>
                    <h1 class="text-5xl font-bold">Box Office News!</h1>
                    <p class="py-6">
                        Provident cupiditate voluptatem et in. Quaerat fugiat ut assumenda excepturi exercitationem
                        quasi. In deleniti eaque aut repudiandae et a id nisi.
                    </p>
                    <button class="btn btn-primary">Get Started</button>
                </div>
            </div>
        </div>

    </section>

    <!-- WORK ON -->
    <section class="app-description border-b pb-5 mb-5">
        <h4 class="text-5xl capitalize text-center font-semibold mb-3">
            Our mission
        </h4>
        <p class="text-justify">
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Quibusdam, eligendi aliquid! Fugiat molestiae quam soluta cumque! Fugiat aliquam dolorem velit minima aperiam, tempore natus aspernatur rerum enim aliquid placeat, commodi aut recusandae fugit, distinctio provident iure sit deserunt doloribus dolorum quis corporis veritatis ab! Ipsum, voluptates ut. Aliquam voluptas officia repellat id laboriosam iste aliquid consectetur consequuntur molestiae reiciendis, nostrum illum laudantium, cumque quas eaque quis veritatis a. Nobis voluptatum et deleniti sed quibusdam distinctio at sequi dolorum magni. Sit recusandae assumenda exercitationem, molestiae quidem vero id molestias pariatur, facere quia laudantium magnam nobis debitis libero aliquid? Voluptatem, quidem voluptatum!
        </p>
    </section>

    <section class="latest-articles">
        <?php if (empty(isset($articles))): ?>
            <h2 class="text-6xl text-center font-semibold mt-3">
                No news available
            </h2>
        <?php else: ?>
            <h4 class="text-5xl capitalize text-center font-semibold my-3">
                Latest News
            </h4>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 p-5">
                <?php foreach ($articles as $article): ?>
                    <?php loadPartial('articleCard', [
                        'article' => $article
                    ]); ?>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </section>
</div>

<?php loadPartial('footer'); ?>