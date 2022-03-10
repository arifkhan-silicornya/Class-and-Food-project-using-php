<?php
function manage_reports() {
global $config, $dbConnect;

?>
<div class="list-container">
    <div class="list-header">Manage Reports</div>
    <div class="user-data-wrapper">
        <div class="float-left span10">
            <strong>ID</strong>
        </div>
        <div class="float-left span30" align="left">
            <strong>Reported By</strong>
        </div>
        <div class="float-left span20" align="left">
            <strong>Post</strong>
        </div>
        <div class="float-left span15" align="left">
            <strong>Status</strong>
        </div>
        <div class="float-left span25" align="center">
            <strong>Action</strong>
        </div>
        <div class="float-clear"></div>
    </div>
    <div class="manage-report-list-wrapper">
        <?php
        
        $query_two = "SELECT * FROM " . DB_REPORTS . " WHERE active=1 ORDER BY id DESC LIMIT 20";
        $sql_query_two = mysqli_query($dbConnect, $query_two);
        
        while ($report = mysqli_fetch_assoc($sql_query_two))
        {
        $reporter = SK_getAccount($report['reporter_id']);
        $post = SK_getPost($report['post_id'], $report['type']);
        ?>
        <div class="user-data-wrapper manage-report-list<?php if ($report['status'] == 0) echo ' unseen'; ?>" data-report-id="<?php echo $report['id']; ?>">
            <div class="float-left span10">
                <?php echo $report['id']; ?>
            </div>
            <div class="float-left span30" align="left">
                <img src="<?php echo $reporter['thumbnail_url']; ?>" width="24px" alt="" valign="middle" style="border-radius: 2px;">
                <a href="<?php echo $config['site_url'] . '/index.php?tab1=timeline&id=' . $reporter['username']; ?>"><?php echo $reporter['name']; ?></a>
            </div>
            <div class="float-left span20" align="left">
                <a href="<?php echo $config['site_url']; ?>/?tab1=story&id=<?php echo $post['post_id'] . '#' . $post['type'] .'_' . $post['id']; ?>">Show Post</a>
            </div>
            <div class="float-left span15" align="left">
                <?php if ($report['status'] == 1) echo 'Marked safe';
                else if ($report['status'] == 2) echo 'Deleted';
                else echo 'Pending';
                
                ?>
            </div>
            <div class="float-left span25" align="center">
                <?php if ($report['status'] == 0) { ?>
                <a href="?tab1=manage_reports&id=<?php echo $report['id']; ?>&action=mark_safe">Mark Safe</a> - 
                <a href="?tab1=manage_reports&id=<?php echo $report['id']; ?>&action=delete">Delete Post</a>
                <?php } else { ?>
                None
                <?php } ?>
            </div>
            <div class="float-clear"></div>
        </div>
        <?php
        } ?>
    </div>
    <?php if (!isset($search_query)) { ?>
    <div class="list-wrapper show-more-wrapper" align="center">
        <a onclick="SK_loadMoreReports();">Show more reports</a>
    </div>
    <?php } ?>
</div>
<script src="jquery.js"></script>
<script>
function SK_loadMoreReports() {
    after_report_id = $('.manage-report-list:last').attr('data-report-id');
    
    show_more_text = $('.show-more-wrapper').find('a').text();
    $('.show-more-wrapper').find('a').text('Loading...');
    
    $.get('ajax.php', {t: 'manage_reports', after_report_id: after_report_id}, function (data) {
        
        if (data.status == 200) {
            $('.manage-report-list-wrapper').append(data.html);
            $('.show-more-wrapper').find('a').text(show_more_text);
        }
        else {
            $('.show-more-wrapper').remove();
        }
    });
}
</script>
<?php } ?>