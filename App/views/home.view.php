<?php loadPartial('head'); ?>
<?php loadPartial('header'); ?>
<?php loadPartial('navbar'); ?>
<?php loadPartial('popUpMsg'); ?>

<div class="home-page container mx-auto">
    <section class="app-hero mt-5 mb-7">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
            <div>
                <h2 class="mb-5 font-semibold text-7xl">
                    Your Free News
                </h2>
                <p>
                    For decades, <strong>The Daily Planet</strong> has been a pillar of truth, integrity, and fearless journalism, delivering the news that shapes the world. Inspired by the heroic values of <strong>Superman</strong>: truth, justice, and the relentless pursuit of knowledge—we strive to keep our readers informed, enlightened, and empowered. In a time when information flows faster than ever, our mission is to provide clarity, uncover hidden truths, and bring attention to the stories that matter most.
                </p>
                <p>
                    Our journey began with a simple yet powerful goal: to uphold the highest standards of journalism, ensuring that every voice is heard and every perspective explored. From breaking news and investigative reports to in-depth analyses and human interest stories, we remain committed to uncovering facts and delivering balanced, well-researched content. Our newsroom is driven by a passion for storytelling, a dedication to ethical reporting, and an unwavering belief in the power of information to shape the future.
                </p>
                <p>
                    Whether it is politics, business, science, culture, or technology, <strong>The Daily Planet</strong> covers a wide spectrum of topics, ensuring that our readers stay ahead in an ever-changing world. We believe that knowledge is power and that journalism is not just about reporting facts but also about inspiring action, fostering understanding, and igniting conversations that lead to change. With a team of skilled writers, analysts, and investigative reporters, we work tirelessly to separate fact from fiction and provide news that is both reliable and thought-provoking.
                </p>
                <p>
                    But we are more than just a news platform—we are a community. A place where ideas are exchanged, discussions are encouraged, and readers have a voice. In the spirit of <strong>Superman</strong> unwavering dedication to justice, we aim to shine a light on truth, hold those in power accountable, and empower individuals with the knowledge they need to make informed decisions. The world is full of stories waiting to be told, and we are here to tell them with honesty, precision, and passion.
                </p>
                <p>
                    Join us in shaping a world where truth prevails, where journalism remains a force for good, and where every story has the power to make a difference. <strong>The Daily Planet</strong>—because the pursuit of truth never ends.
                </p>

            </div>
            <div>
                <img src="/public/assets/hero.jpg" alt="hero-img" class="mx-auto h-full w-full lg:w-max">
            </div>
        </div>
    </section>

    <section class="app-description border-b pb-5 mb-7">
        <h4 class="text-5xl capitalize text-center font-semibold mb-3">
            Our mission
        </h4>
        <p>
            At The Daily Planet, we believe that knowledge is power and that every story has the potential to inspire change. Our mission is to deliver accurate, insightful, and engaging news that keeps you informed and connected to the world around you. Whether it is breaking headlines, investigative reports, or in-depth features, we are committed to upholding the highest standards of journalism—truth, integrity, and transparency. We cover a wide range of topics, from global events and politics to science, technology, business, and culture. Our team of dedicated writers and editors works tirelessly to bring you well-researched, balanced, and thought-provoking content that sparks meaningful discussions. Stay informed. Stay engaged. Stay inspired. Because every story deserves to be told.
        </p>
    </section>

    <section class="latest-articles mb-10">
        <?php if (empty(isset($articles))): ?>
            <h2 class="text-6xl text-center font-semibold mt-10">
                No new news available
            </h2>
        <?php else: ?>
            <h4 class="text-5xl capitalize text-center font-semibold mb-5">
                Latest News
            </h4>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
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