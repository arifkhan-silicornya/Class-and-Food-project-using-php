<?php
function manage_pages() {
global $config, $dbConnect;
?>
<div class="list-container">
    <div class="list-header">Manage Pages</div>
    <div class="search-wrapper"><form method="get" action="?">
        <input type="hidden" name="tab1" value="manage_pages">
        <input type="text" name="search_query" placeholder="Search for pages by name, username or ID"> <input type="submit" value="Search">
    </form></div>
    <div class="user-data-wrapper">
        <div class="float-left span10">
            <strong>ID</strong>
        </div>
        <div class="float-left span30" align="left">
            <strong>Name</strong>
        </div>
        <div class="float-left span40" align="left">
            <strong>Likes</strong>
        </div>
        <div class="float-left span20" align="center">
            <strong>Options</strong>
        </div>
        <div class="float-clear"></div>
    </div>
    <div class="manage-page-list-wrapper">
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
            
            $query_one = "SELECT id FROM ". DB_ACCOUNTS ." WHERE $query_part AND type='page' AND id IN (SELECT id FROM ". DB_PAGES .") ORDER BY name ASC";
        } else {
            $query_one = "SELECT id FROM ". DB_ACCOUNTS ." WHERE type='page' AND id IN (SELECT id FROM ". DB_PAGES .") ORDER BY id DESC LIMIT 20";
        }
        
        $sql_query_one = mysqli_query($dbConnect, $query_one);
        
        while ($page = mysqli_fetch_array($sql_query_one, MYSQLI_ASSOC)) {
        $page = SK_getAccount($page['id']);
        ?>
        <div class="user-data-wrapper manage-page-list" data-page-id="<?php echo $page['id']; ?>">
            <div class="float-left span10">
                <?php echo $page['id']; ?>
            </div>
            <div class="float-left span30" align="left">
                <img src="<?php echo $page['thumbnail_url']; ?>" width="24px" alt="" valign="middle" style="border-radius: 2px;">
                <a href="<?php echo $config['site_url'] . '/index.php?tab1=timeline&id=' . $page['username']; ?>"><?php echo $page['name']; ?></a>
            </div>
            <div class="float-left span40" align="left">
                <?php
                $query_two = "SELECT id FROM ". DB_FOLLOWERS ." WHERE following_id=" . $page['id'];
                $sql_query_two = mysqli_query($dbConnect, $query_two);
                echo mysqli_num_rows($sql_query_two);
                ?>
            </div>
            <div class="float-left span20" align="center">
                <a href="?tab1=edit_page&id=<?php echo $page['id']; ?>">Edit</a> - <a href="?tab1=delete_page&id=<?php echo $page['id']; ?>">Delete</a>
            </div>
            <div class="float-clear"></div>
        </div>
        <?php } ?>
    </div>
    <?php if (!isset($search_query)) { ?>
    <div class="list-wrapper show-more-wrapper" align="center">
        <a onclick="SK_loadMorePages();">Show more pages</a>
    </div>
    <?php } ?>
</div>
<script src="jquery.js"></script>
<script>
function SK_loadMorePages() {
    after_page_id = $('.manage-page-list:last').attr('data-page-id');
    
    show_more_text = $('.show-more-wrapper').find('a').text();
    $('.show-more-wrapper').find('a').text('Loading...');
    
    $.get('ajax.php', {t: 'manage_pages', after_page_id: after_page_id}, function (data) {
        
        if (data.status == 200) {
            $('.manage-page-list-wrapper').append(data.html);
            $('.show-more-wrapper').find('a').text(show_more_text);
        }
        else {
            $('.show-more-wrapper').remove();
        }
    });
}
</script>
<?php } ?>