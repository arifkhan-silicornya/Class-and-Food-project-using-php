<?php
function announcements() {
global $dbConnect, $config;
?>
<div class="announcement-container">
    <div class="announcement-header">New Announcement</div>
    <form class="announcement-writer-wrapper" method="post" action="?tab1=announcements">
        <textarea name="announcement_text" placeholder="Write a new announcement..."></textarea>
        <button>Add</button>
        <input type="hidden" name="add_new_announcement" value="1">
        <input type="hidden" name="keep_blank" value="">
    </form>
</div>





<?php } ?>