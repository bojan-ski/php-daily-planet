<?php

use Framework\Session;

?>

<nav class="bg-gray-100 text-center py-2">
    <div class="block lg:hidden">
        <div class="dropdown">
            <div tabindex="0" role="button" class="btn btn-ghost">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M4 6h16M4 12h8m-8 6h16" />
                </svg>
            </div>
            <div
                tabindex="0"
                class="dropdown-content bg-base-100 rounded-box z-[10] w-72 p-2 shadow">
                <a href="/" class="nav-link btn btn-ghost text-7xl mx-7">
                    Home
                </a>
                <a href="/articles" class="nav-link btn btn-ghost text-xl mx-7">
                    Articles
                </a>
                <?php if (Session::exist('user') && Session::get('user')['role'] == 'reader'): ?>
                    <?php loadPartial('navbar/reader'); ?>
                <?php elseif (Session::exist('user') && Session::get('user')['role'] == 'author'): ?>
                    <?php loadPartial('navbar/author'); ?>
                <?php elseif (Session::exist('user') && Session::get('user')['role'] == 'admin'): ?>
                    <?php loadPartial('navbar/admin'); ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="hidden lg:block">
        <a href="/" class="nav-link btn btn-ghost text-7xl mx-7">
            Home
        </a>
        <a href="/articles" class="nav-link btn btn-ghost text-xl mx-7">
            Articles
        </a>
        <?php if (Session::exist('user') && Session::get('user')['role'] == 'reader'): ?>
            <?php loadPartial('navbar/reader'); ?>
        <?php elseif (Session::exist('user') && Session::get('user')['role'] == 'author'): ?>
            <?php loadPartial('navbar/author'); ?>
        <?php elseif (Session::exist('user') && Session::get('user')['role'] == 'admin'): ?>
            <?php loadPartial('navbar/admin'); ?>
        <?php endif; ?>
    </div>
</nav>