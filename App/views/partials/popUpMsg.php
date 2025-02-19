<?php

use Framework\Session;

?>

<?php if (Session::exist('pop_up')): ?>
    <div class="pop-up-msg">
        <div class="pop-up-content">
            <p class="text-2xl font-semibold">
                <?= Session::displayPopUp('pop_up') ?>
            </p>
        </div>
    </div>
<?php endif; ?>