<?php

use Framework\FlashMsg;
use Framework\Session;

?>

<?php if (Session::exist('pop_up')): ?>
    <div class="pop-up-msg">
        <div class="pop-up-content">
            <p class="text-2xl font-semibold">
                <?= FlashMsg::displayPopUp('pop_up') ?>
            </p>
        </div>
    </div>
<?php endif; ?>