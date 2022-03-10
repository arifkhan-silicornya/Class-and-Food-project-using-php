<?php
function user_settings() {
global $config, $dbConnect;

$query = "EXPLAIN ". DB_USERS;
$sql_query = mysqli_query($dbConnect, $query);

while ($sql_fetch = mysqli_fetch_assoc($sql_query)) {
    $default_settings[$sql_fetch['Field']] = $sql_fetch['Default'];
}

?>
<form class="content-container" method="post" action="?tab1=user_settings">
    <div class="content-header">User Settings</div>

    <div class="content-wrapper">
        <label>Changes made will only be applied to users registered from now on.</label>
    </div>

    <div class="content-wrapper">
        <div class="label float-left">Comment privacy</div>
        <div class="input float-left">
            <select name="comment_privacy">
                <option value="everyone" <?php if ($default_settings['comment_privacy'] == "everyone") echo 'selected'; ?>>
                    Everyone
                </option>

                <option value="following" <?php if ($default_settings['comment_privacy'] == "following") echo 'selected'; ?>>
                    <?php
                    if ($config['friends'] == true) {
                        echo 'Only user\'s friends';
                    } else {
                        echo 'Only people user follows';
                    }
                    ?>
                </option>
            </select>

            <div class="info">Comment privacy by default</div>
        </div>
        <div class="float-clear"></div>
    </div>

    <div class="content-wrapper">
        <div class="label float-left">Confirm follow requests</div>
        <div class="input float-left">
            <select name="confirm_followers">
                <option value="0" <?php if ($default_settings['confirm_followers'] == 0) echo 'selected'; ?>>
                    No
                </option>

                <option value="1" <?php if ($default_settings['confirm_followers'] == 1) echo 'selected'; ?>>
                    Yes
                </option>
            </select>

            <div class="info">Confirm follow requests privacy by default</div>
        </div>
        <div class="float-clear"></div>
    </div>

    <div class="content-wrapper">
        <div class="label float-left">Follow privacy</div>
        <div class="input float-left">
            <select name="follow_privacy">
                <option value="everyone" <?php if ($default_settings['follow_privacy'] == "everyone") echo 'selected'; ?>>
                    Everyone
                </option>

                <option value="following" <?php if ($default_settings['follow_privacy'] == "following") echo 'selected'; ?>>
                    <?php
                    if ($config['friends'] == true) {
                        echo 'Only user\'s friends';
                    } else {
                        echo 'Only people user follows';
                    }
                    ?>
                </option>
            </select>

            <div class="info">Follow privacy by default</div>
        </div>
        <div class="float-clear"></div>
    </div>

    <div class="content-wrapper">
        <div class="label float-left">Message privacy</div>
        <div class="input float-left">
            <select name="message_privacy">
                <option value="everyone" <?php if ($default_settings['message_privacy'] == "everyone") echo 'selected'; ?>>
                    Everyone
                </option>

                <option value="following" <?php if ($default_settings['message_privacy'] == "following") echo 'selected'; ?>>
                    <?php
                    if ($config['friends'] == true) {
                        echo 'Only user\'s friends';
                    } else {
                        echo 'Only people user follows';
                    }
                    ?>
                </option>
            </select>

            <div class="info">Message privacy by default</div>
        </div>
        <div class="float-clear"></div>
    </div>

    <div class="content-wrapper">
        <div class="label float-left">Timeline post privacy</div>
        <div class="input float-left">
            <select name="timeline_post_privacy">
                <option value="everyone" <?php if ($default_settings['timeline_post_privacy'] == "everyone") echo 'selected'; ?>>
                    Everyone
                </option>

                <option value="following" <?php if ($default_settings['timeline_post_privacy'] == "following") echo 'selected'; ?>>
                    <?php
                    if ($config['friends'] == true) {
                        echo 'Only user\'s friends';
                    } else {
                        echo 'Only people user follows';
                    }
                    ?>
                </option>

                <option value="none" <?php if ($default_settings['timeline_post_privacy'] == "none") echo 'selected'; ?>>
                    No one
                </option>
            </select>

            <div class="info">Who can post on user's timeline privacy by default</div>
        </div>
        <div class="float-clear"></div>
    </div>

    <div class="content-wrapper">
        <div class="label float-left">Post privacy</div>
        <div class="input float-left">
            <select name="post_privacy">
                <option value="everyone" <?php if ($default_settings['post_privacy'] == "everyone") echo 'selected'; ?>>
                    Everyone
                </option>

                <option value="following" <?php if ($default_settings['post_privacy'] == "following") echo 'selected'; ?>>
                    <?php
                    if ($config['friends'] == true) {
                        echo 'Only user\'s friends';
                    } else {
                        echo 'Only people user follows';
                    }
                    ?>
                </option>
            </select>

            <div class="info">Who can see User's posts by default.</div>
        </div>
        <div class="float-clear"></div>
    </div>

    <div class="button-wrapper">
        <input type="submit" name="save_btn" value="Save Changes">
    </div>

    <input type="hidden" name="keep_blank" value="">
    <input type="hidden" name="update_user_settings" value="1">
</form>
<?php } ?>