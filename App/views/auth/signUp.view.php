<?php loadPartial('head'); ?>
<?php loadPartial('header'); ?>
<?php loadPartial('navbar'); ?>

<div class="sign-up-page container mx-auto">

    <div class="flex justify-center items-center w-full md:w-2/3 lg:w-1/2 mx-auto my-20">
        <div class="p-8 w-full border">

            <h2 class="text-4xl text-center font-bold mb-4">
                Sign Up
            </h2>

            <?= loadPartial('errors', [
                'errors' => $errors ?? []
            ]) ?>

            <form method="POST" action="/sign_up/register">
                <div class="mb-4">
                    <input
                        type="text"
                        name="name"
                        placeholder="Full Name"
                        class="w-full px-4 py-2 border focus:outline-none"
                        value="<?= $user['name'] ?? '' ?>"
                        required />
                </div>
                <div class="mb-4">
                    <input
                        type="email"
                        name="email"
                        placeholder="Email Address"
                        class="w-full px-4 py-2 border focus:outline-none"
                        value="<?= $user['email'] ?? '' ?>" 
                        required/>
                </div>
                <div class="mb-4">
                    <input
                        type="password"
                        name="password"
                        placeholder="Password"
                        class="w-full px-4 py-2 border focus:outline-none" 
                        required/>
                </div>
                <div class="mb-4">
                    <input
                        type="password"
                        name="password_confirmation"
                        placeholder="Confirm Password"
                        class="w-full px-4 py-2 border focus:outline-none" 
                        required/>
                </div>
                <button
                    type="submit" class="w-full bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 focus:outline-none">
                    Register
                </button>
            </form>
        </div>
    </div>

</div>

<?php loadPartial('footer'); ?>