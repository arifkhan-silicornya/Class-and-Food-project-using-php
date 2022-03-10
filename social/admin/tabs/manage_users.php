<?php
function manage_users() {
global $config, $dbConnect;
?>
<div class="list-container">
    <div class="list-header">Manage Users</div>
    <div class="search-wrapper"><form method="get" action="?">
        <input type="hidden" name="tab1" value="manage_users">
        <input type="text" name="search_query" placeholder="Search for users by name, username, email or ID"> <input type="submit" value="Search">
    </form></div>
    <div class="user-data-wrapper">
        <div class="float-left span10">
            <strong>ID</strong>
        </div>
        <div class="float-left span30" align="left">
            <strong>Name</strong>
        </div>
        <div class="float-left span40" align="left">
            <strong>Email</strong>
        </div>
        <div class="float-left span20" align="center">
            <strong>Options</strong>
        </div>
        <div class="float-clear"></div>
    </div>
    <div class="manage-user-list-wrapper">
        <?php
        
        if (!empty($_GET['search_query'])) {
            $search_query = SK_secureEncode($_GET['search_query']);
            
            if (is_numeric($search_query)) {
                $query_part = "id=" . $search_query;
            }
            else
            if (preg_match('/@/', $search_query)) {
                $query_part = "email='$search_query'";
            }
            else {
                $query_part = "(username='$search_query' OR name LIKE '%$search_query%')";
            }
            
            $query_one = "SELECT id FROM ". DB_ACCOUNTS ." WHERE $query_part AND type='user' AND id IN (SELECT id FROM ". DB_USERS .") ORDER BY name ASC";
        } else {
            $query_one = "SELECT id FROM ". DB_ACCOUNTS ." WHERE type='user' AND id IN (SELECT id FROM ". DB_USERS .") ORDER BY id DESC LIMIT 20";
        }
        
        $sql_query_one = mysqli_query($dbConnect, $query_one);
        
        while ($account = mysqli_fetch_array($sql_query_one, MYSQLI_ASSOC)) {
        $account = SK_getAccount($account['id']);
        ?>
        <div class="user-data-wrapper manage-user-list" data-user-id="<?php echo $account['id']; ?>">
            <div class="float-left span10">
                <?php echo $account['id']; ?>
            </div>
            <div class="float-left span30" align="left">
                <img src="<?php echo $account['thumbnail_url']; ?>" width="24px" alt="" valign="middle" style="border-radius: 2px;">
                <a href="<?php echo $config['site_url'] . '/index.php?tab1=timeline&id=' . $account['username']; ?>"><?php echo $account['name']; ?></a>
            </div>
            <div class="float-left span40" align="left">
                <?php echo $account['email']; ?>
            </div>
            <div class="float-left span20" align="center">
                <a href="?tab1=edit_user&id=<?php echo $account['id']; ?>">Edit</a> - <a href="?tab1=delete_user&id=<?php echo $account['id']; ?>">Delete</a>
            </div>
            <div class="float-clear"></div>
        </div>
        <?php } ?>
    </div>
    <?php if (!isset($search_query)) { ?>
    <div class="list-wrapper show-more-wrapper" align="center">
        <a onclick="SK_loadMoreUsers();">Show more users</a>
    </div>
    <?php } ?>
</div>
<script src="jquery.js"></script>
<script>
function SK_loadMoreUsers() {
    after_user_id = $('.manage-user-list:last').attr('data-user-id');
    
    show_more_text = $('.show-more-wrapper').find('a').text();
    $('.show-more-wrapper').find('a').text('Loading...');
    
    $.get('ajax.php', {t: 'manage_users', after_user_id: after_user_id}, function (data) {
        
        if (data.status == 200) {
            $('.manage-user-list-wrapper').append(data.html);
            $('.show-more-wrapper').find('a').text(show_more_text);
        }
        else {
            $('.show-more-wrapper').remove();
        }
    });
}
</script>
<?php } ?>