<?php
function comment_verified_badge ($conn, $comment, $uiContent)
{
	$verifiedQuery = $conn->query("SELECT id FROM " . DB_ACCOUNTS . " WHERE id=" . $comment['timeline']['id'] . " AND verified=1");

	if ($verifiedQuery->num_rows == 1)
	{
		$uiBadge = '<span class="comment-verified-badge"><i class="icon-ok"></i></span>';
		$uiContent = str_replace('{{COMMENT_TIMELINE_LINK}}', '{{COMMENT_TIMELINE_LINK}} ' . $uiBadge, $uiContent);
	}

	return $uiContent;
}
\miuan\Addons::register('comment_content_ui_editor', 'comment_verified_badge');

/* CSS */
function comment_verified_badge_css()
{
	return '<style>
	.comment-verified-badge {
		display: inline-block;
		vertical-align: middle;
		background: #2B90B9;
		color: white;
		text-shadow: 0 0 0 white;
		font-size: 7px;
		margin-bottom: 5px;
		padding: 0 1px 1px 2px;
		border: 2px solid white;
		border-radius: 100%;
	}
	</style>';
}
\miuan\Addons::register('head_tags_add_content', 'comment_verified_badge_css');