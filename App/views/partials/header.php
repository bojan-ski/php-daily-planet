<?php

use Framework\Session; 

?>

<header class="header" id="header">
    <div class="bg-gray-100 text-right py-2">
        <?php if (Session::exist('user')): ?>
            <form method="POST" action="/logout">
                <button type="submit" class="btn btn-ghost text-xl mx-2">
                    Log Out
                </button>
            </form>
        <?php else: ?>
            <a href="/sign_up" class="btn btn-ghost text-xl mx-2">
                Sign Up
            </a>
            <a href="/sign_in" class="btn btn-ghost text-xl mx-2">
                Sign In
            </a>
        <?php endif; ?>
    </div>

    <div class="app-name text-center my-8">
        <h1 class="text-7xl">
            The Daily Planet
        </h1>
    </div>
</header>

<main id="main" class="main">