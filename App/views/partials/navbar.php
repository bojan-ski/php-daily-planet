<?php

use Framework\Session;

?>

<nav class="bg-gray-100 text-center py-2">
    <a href="/" class="nav-link btn btn-ghost text-7xl mx-7">
        Home
    </a>
    <a href="/articles" class="nav-link btn btn-ghost text-xl mx-7">
        Articles
    </a>
    <?php if (Session::exist('user') && Session::get('user')['role'] == 'reader'): ?>
        <?php loadPartial('navLinks/reader'); ?>
    <?php elseif (Session::exist('user') && Session::get('user')['role'] == 'author'): ?>
        <?php loadPartial('navLinks/author'); ?>
    <?php elseif (Session::exist('user') && Session::get('user')['role'] == 'admin'): ?>
        <?php loadPartial('navLinks/admin'); ?>
    <?php endif; ?>
</nav>