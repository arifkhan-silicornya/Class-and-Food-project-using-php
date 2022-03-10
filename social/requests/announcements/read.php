<?php
$query = $conn->query("SELECT id FROM " . DB_ANNOUNCEMENTS . " WHERE id NOT IN (SELECT announcement_id FROM " . DB_ANNOUNCEMENT_VIEWS . " WHERE account_id=" . $user['id'] . ")");

while ($fetch = $query->fetch_array(MYSQLI_ASSOC))
{
    $query2 = $conn->query("INSERT INTO " . DB_ANNOUNCEMENT_VIEWS . " (account_id,announcement_id) VALUES (" . $user['id'] . "," . $fetch['id'] . ")");
}