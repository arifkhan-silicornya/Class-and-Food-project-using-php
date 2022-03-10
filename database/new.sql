-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 17, 2020 at 09:09 PM
-- Server version: 10.4.6-MariaDB
-- PHP Version: 7.3.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `new`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `id` int(11) NOT NULL,
  `about` text COLLATE utf8_unicode_ci NOT NULL,
  `active` int(1) NOT NULL DEFAULT 0,
  `avatar_id` int(11) NOT NULL DEFAULT 0,
  `cover_id` int(11) NOT NULL DEFAULT 0,
  `cover_position` int(5) NOT NULL DEFAULT 0,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `email_verification_key` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `email_verified` int(1) NOT NULL DEFAULT 0,
  `language` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `last_logged` int(12) NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `time` int(12) NOT NULL DEFAULT 0,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `timezone` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `type` enum('user','page','group') COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `verified` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `about`, `active`, `avatar_id`, `cover_id`, `cover_position`, `email`, `email_verification_key`, `email_verified`, `language`, `last_logged`, `name`, `password`, `time`, `timestamp`, `timezone`, `type`, `username`, `verified`) VALUES
(1, '', 1, 49, 26, 0, 'dffdff@a.com', '619ebc7e5dcbe4a380c1e5f4b16e88dd', 0, '', 1600974233, 'rtyurtyr', 'e3e2958ab84084380a6d9c739dd68425', 1598560862, '2020-09-24 19:03:53', '', 'user', 'tytryrtdyt', 0),
(2, '', 1, 0, 0, 0, 'gfdgd@a.com', 'bccb8fcdfff2464cab159da5950c0130', 0, '', 1598607325, 'gfdxcgfdgdg', 'f7b054cb9ced2d69ed18cfb9fc6311a9', 1598606743, '2020-08-28 09:35:25', '', 'user', 'dgfgdfgfdg', 0),
(3, 'fd', 1, 0, 0, 0, 'dfdfdd@yoursite.com', '', 0, '', 0, 'dfddf', '78dcbac182bd15e44748c3aabbe46985', 1598616980, '2020-08-28 12:16:20', '', 'page', 'dfdfdd', 0),
(4, 'lkjnlkjn', 1, 0, 0, 0, 'kjnkjnkj@yoursite.com', '', 0, '', 0, '74841', '885a5b5c941e3ea67f5897b6929c1334', 1598619173, '2020-08-28 12:52:53', '', 'page', 'kjnkjnkj', 0),
(5, '', 1, 0, 0, 0, 'gghdh@a.com', '82bb90655e2ea7a0137ed74cd4e89d69', 0, '', 1598623363, 'hfjfj', '2869eee6cfea027b3387c118fd266864', 1598623321, '2020-09-18 13:47:58', '', 'user', 'bbfbfbdyg', 0),
(6, 'hfhfhf', 1, 0, 0, 0, 'fhfhfhfh@yoursite.com', '', 0, '', 0, 'jcjhff', '3ed4a355ae2c982bee9db3b986b126d5', 1598623362, '2020-08-28 14:02:42', '', 'page', 'fhfhfhfh', 0),
(7, '', 1, 0, 0, 0, 'sadsdjksd@a.com', 'b5f2f3c1c14d1de398bd1fbca9c4789c', 0, '', 1598716781, 'xfggfgfg', '591aa08969e892162851f98c4d813c00', 1598715715, '2020-09-17 22:18:53', '', 'user', 'fggffdgff', 0),
(8, 'fhfghfghfhf', 1, 0, 0, 0, 'hfghfghfghf@yoursite.com', '', 0, '', 0, 'fthfhhf', '2604ff37f401845d37420b379df25432', 1598715730, '2020-08-29 15:42:10', '', 'group', 'hfghfghfghf', 0),
(9, 'fgtyhfgyhfghfghf', 1, 0, 0, 0, 'uftuyhrfyufrtgyftyh@yoursite.com', '', 0, '', 0, 'fyujfhftr', 'dc547665c82c8080209eae6e5fb20e67', 1598716161, '2020-08-29 15:49:21', '', 'page', 'uftuyhrfyufrtgyftyh', 0),
(10, 'ffhghf', 1, 52, 0, 0, 'hfhfghfghfgh@yoursite.com', '', 0, '', 0, 'fghfghfgh', '043294bb739c248f59d594ac87081766', 1598716171, '2020-08-30 14:51:20', '', 'page', 'hfhfghfghfgh', 0),
(11, 'fghhfgh', 1, 0, 0, 0, 'hgfhhfhfgh@yoursite.com', '', 0, '', 0, 'ghfdhg', '6ef9bcb3abeda44511028d3386349fd8', 1598716302, '2020-08-29 15:51:42', '', 'group', 'hgfhhfhfgh', 0),
(12, 'bhjnbjffffffffgd', 1, 0, 0, 0, 'jjbnjnjbhjb@yoursite.com', '', 0, '', 0, 'bh jmj', '570e7e7032b80cc90032a5d9d4d8bd91', 1598964210, '2020-09-20 20:56:34', '', 'page', 'jjbnjnjbhjb', 0),
(13, '', 1, 0, 0, 0, 'hzhzhz@a.com', 'f25234590cce09963274a178f4a75aa4', 0, '', 1599950946, 'xhhxhx', '50cac8f7b6c7a0701fbda0faf918d0da', 1599950932, '2020-09-12 22:49:06', '', 'user', 'zbxbxbxb', 0),
(14, '', 1, 0, 0, 0, 'maruf@a.com', '05152799fc8de5206daf976b328959e3', 0, '', 1600285588, 'Aminul Islam Maruf', 'b04415b8b0a0d8c4f2fd34dc0d4ec9a0', 1600285551, '2020-09-16 19:46:28', '', 'user', 'maruf', 0),
(15, '', 1, 0, 0, 0, 'rokon@a.com', '563f74b59d2cf9e917b405f67bad880a', 0, '', 1600288038, 'Abidur Rahman Rokon', 'b04415b8b0a0d8c4f2fd34dc0d4ec9a0', 1600287996, '2020-09-16 20:27:18', '', 'user', 'rokon', 0),
(16, '', 1, 0, 0, 0, 'shovon@a.com', '8d61587d203c3368245815514b2a0e0d', 0, '', 1600288086, 'Nafis Fuad Shovon', 'b04415b8b0a0d8c4f2fd34dc0d4ec9a0', 1600288078, '2020-09-16 20:28:06', '', 'user', 'shovon', 0),
(17, '', 1, 0, 0, 0, 'badhan@a.com', '958c33d62954b12d75317ce9ec27ed80', 0, '', 1600288160, 'Meharub Hossain Badhan', 'b04415b8b0a0d8c4f2fd34dc0d4ec9a0', 1600288129, '2020-09-16 20:29:20', '', 'user', 'badhan', 0),
(18, '', 1, 0, 0, 0, 'ygttgtg@a.com', '0ec413ad2852cd985436be1dd2c7f08f', 0, '', 1600644159, 'cgbcvgf', 'b6c46c0988dbfdd801ac57bbf7425aab', 1600642124, '2020-09-20 23:22:39', '', 'user', 'dfgtdfgdf', 0),
(19, 'ghjnghghnhgn', 1, 0, 0, 0, 'ghhjgh@yoursite.com', '', 0, '', 0, 'ghgmmgmhnhg', '43a24c9421b9341f9dafe04ee7599cd0', 1600699648, '2020-09-21 14:47:45', '', 'page', 'ghhjghhn', 0),
(35, '', 1, 53, 0, 0, 'maruf102@a.com', '7fdb5659e43d21ee581a7eff6f4f16c0', 0, '', 1602874966, 'Arif Khan', '52a324278027b33f1515757c05b34504', 1602354052, '2020-10-16 19:02:46', '', 'user', 'maruf123', 0),
(36, '', 1, 0, 0, 0, 'mrf201@a.com', 'e66b9a028961a9076471a7b9cacd223a', 0, '', 1602875605, 'maruf', '108811a28f171a2ccb6d95ae76e07a36', 1602875541, '2020-10-16 19:13:25', '', 'user', 'marf120', 0),
(37, '', 1, 0, 0, 0, 'shanto@a.com', 'e9faa0a2cec87ae87dd3b1c98e5586c8', 0, '', 1602961773, 'shanto', '9db90d7bc7d4a5ac0a4ca02123db9f42', 1602875972, '2020-10-17 19:09:33', '', 'user', 'shanto', 0);

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `id` int(11) NOT NULL,
  `text` text COLLATE utf8_unicode_ci NOT NULL,
  `time` int(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `announcements`
--

INSERT INTO `announcements` (`id`, `text`, `time`) VALUES
(1, 'cghgf', 1600379322),
(2, 'cghgf', 1600380297),
(3, 'ghh', 1600381152),
(4, 'ghh', 1600381217),
(5, 'bjkjhkh', 1600439371),
(6, 'jkkkjhkhk', 1600439373),
(7, 'jkjkj', 1600439375);

-- --------------------------------------------------------

--
-- Table structure for table `announcement_views`
--

CREATE TABLE `announcement_views` (
  `id` int(11) NOT NULL,
  `account_id` int(11) DEFAULT NULL,
  `announcement_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `announcement_views`
--

INSERT INTO `announcement_views` (`id`, `account_id`, `announcement_id`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 3),
(4, 1, 4),
(5, 1, 5),
(6, 1, 6),
(7, 1, 7),
(8, 18, 1),
(9, 18, 2),
(10, 18, 3),
(11, 18, 4),
(12, 18, 5),
(13, 18, 6),
(14, 18, 7),
(15, 35, 1),
(16, 35, 2),
(17, 35, 3),
(18, 35, 4),
(19, 35, 5),
(20, 35, 6),
(21, 35, 7),
(22, 37, 1),
(23, 37, 2),
(24, 37, 3),
(25, 37, 4),
(26, 37, 5),
(27, 37, 6),
(28, 37, 7);

-- --------------------------------------------------------

--
-- Table structure for table `commentlikes`
--

CREATE TABLE `commentlikes` (
  `id` int(11) NOT NULL,
  `active` int(1) NOT NULL DEFAULT 0,
  `post_id` int(11) NOT NULL,
  `time` int(12) NOT NULL,
  `timeline_id` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `commentlikes`
--

INSERT INTO `commentlikes` (`id`, `active`, `post_id`, `time`, `timeline_id`, `timestamp`) VALUES
(1, 1, 3, 1600699695, 1, '2020-09-21 14:48:15');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `active` int(1) NOT NULL DEFAULT 0,
  `media_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `text` text COLLATE utf8_unicode_ci NOT NULL,
  `time` int(12) NOT NULL,
  `timeline_id` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `active`, `media_id`, `post_id`, `text`, `time`, `timeline_id`, `timestamp`) VALUES
(1, 1, 0, 33, 'fgf', 1598799048, 10, '2020-08-30 14:50:48'),
(2, 1, 0, 33, 'fghfg', 1598799100, 10, '2020-08-30 14:51:40'),
(3, 1, 0, 55, 'hikh', 1600699691, 1, '2020-09-21 14:48:11');

-- --------------------------------------------------------

--
-- Table structure for table `configurations`
--

CREATE TABLE `configurations` (
  `ad_place_hashtag` text NOT NULL,
  `ad_place_home` text NOT NULL,
  `ad_place_messages` text NOT NULL,
  `ad_place_search` text NOT NULL,
  `ad_place_timeline` text NOT NULL,
  `admin_password` varchar(255) NOT NULL DEFAULT 'e9aada4fd797d65069187d7a961691cc',
  `admin_username` varchar(255) NOT NULL DEFAULT 'marvelkit',
  `captcha` int(1) NOT NULL DEFAULT 0,
  `censored_words` varchar(255) NOT NULL DEFAULT 'racist,retard',
  `chat` int(1) NOT NULL DEFAULT 0,
  `comment_character_limit` int(10) NOT NULL DEFAULT 0,
  `email` varchar(150) NOT NULL DEFAULT 'no-reply@website.com',
  `email_verification` int(1) NOT NULL DEFAULT 0,
  `friends` int(1) NOT NULL DEFAULT 0,
  `language` varchar(50) NOT NULL DEFAULT 'english',
  `message_character_limit` int(10) NOT NULL DEFAULT 0,
  `reg_req_about` int(1) NOT NULL DEFAULT 0,
  `reg_req_birthday` int(1) NOT NULL DEFAULT 0,
  `reg_req_currentcity` int(1) NOT NULL DEFAULT 0,
  `reg_req_hometown` int(1) NOT NULL DEFAULT 0,
  `reset_time` int(12) NOT NULL,
  `site_name` varchar(150) NOT NULL DEFAULT 'Site Name',
  `site_title` varchar(150) NOT NULL DEFAULT 'Site Title',
  `smooth_links` int(1) NOT NULL DEFAULT 0,
  `story_character_limit` int(10) NOT NULL DEFAULT 0,
  `theme` varchar(100) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `configurations`
--

INSERT INTO `configurations` (`ad_place_hashtag`, `ad_place_home`, `ad_place_messages`, `ad_place_search`, `ad_place_timeline`, `admin_password`, `admin_username`, `captcha`, `censored_words`, `chat`, `comment_character_limit`, `email`, `email_verification`, `friends`, `language`, `message_character_limit`, `reg_req_about`, `reg_req_birthday`, `reg_req_currentcity`, `reg_req_hometown`, `reset_time`, `site_name`, `site_title`, `smooth_links`, `story_character_limit`, `theme`) VALUES
('', 'fghdhj', '', '', '', 'e9aada4fd797d65069187d7a961691cc', 'marvelkit', 0, '', 0, 0, 'no-reply@website.com', 0, 0, '', 0, 0, 0, 0, 0, 1600381975, 'dfgdfg', 'dfgdg', 0, 0, 'grape');

-- --------------------------------------------------------

--
-- Table structure for table `followers`
--

CREATE TABLE `followers` (
  `id` int(11) NOT NULL,
  `active` int(1) NOT NULL DEFAULT 0,
  `is_chatting` int(1) NOT NULL DEFAULT 0,
  `follower_id` int(11) NOT NULL,
  `following_id` int(11) NOT NULL,
  `time` int(255) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `followers`
--

INSERT INTO `followers` (`id`, `active`, `is_chatting`, `follower_id`, `following_id`, `time`, `timestamp`) VALUES
(1, 1, 0, 1, 3, 1598616980, '2020-08-28 12:16:20'),
(2, 1, 0, 1, 4, 1598619173, '2020-08-28 12:52:53'),
(3, 1, 0, 5, 6, 1598623362, '2020-08-28 14:02:42'),
(4, 1, 0, 7, 8, 1598715730, '2020-08-29 15:42:10'),
(5, 1, 0, 7, 9, 1598716161, '2020-08-29 15:49:21'),
(6, 1, 0, 1, 10, 1598716171, '2020-08-29 15:49:31'),
(8, 1, 0, 1, 6, 1598718400, '2020-08-29 16:26:40'),
(9, 1, 0, 1, 7, 1598718483, '2020-08-29 16:28:03'),
(10, 1, 0, 1, 5, 1598718485, '2020-08-29 16:28:05'),
(11, 1, 0, 1, 2, 1598719857, '2020-08-29 16:50:57'),
(12, 1, 0, 1, 9, 1598723080, '2020-08-29 17:44:40'),
(13, 0, 0, 1, 8, 1598723082, '2020-08-29 17:44:42'),
(14, 1, 0, 1, 12, 1598964210, '2020-09-01 12:43:30'),
(15, 1, 0, 1, 15, 1600617232, '2020-09-20 15:53:52'),
(17, 1, 0, 1, 11, 1600633193, '2020-09-20 20:19:53'),
(18, 1, 0, 1, 19, 1600699648, '2020-09-21 14:47:28'),
(20, 1, 0, 37, 35, 1602880033, '2020-10-16 20:27:13');

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` int(11) NOT NULL,
  `add_privacy` varchar(15) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'members',
  `group_privacy` varchar(15) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'open',
  `timeline_post_privacy` varchar(15) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'members'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `add_privacy`, `group_privacy`, `timeline_post_privacy`) VALUES
(8, 'members', 'closed', 'members'),
(11, 'members', 'closed', 'members');

-- --------------------------------------------------------

--
-- Table structure for table `group_admins`
--

CREATE TABLE `group_admins` (
  `id` int(11) NOT NULL,
  `active` int(1) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `group_admins`
--

INSERT INTO `group_admins` (`id`, `active`, `admin_id`, `group_id`) VALUES
(1, 1, 7, 8),
(2, 1, 1, 11);

-- --------------------------------------------------------

--
-- Table structure for table `hashtags`
--

CREATE TABLE `hashtags` (
  `id` int(11) NOT NULL,
  `hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tag` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `last_trend_time` int(12) NOT NULL,
  `trend_use_num` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `id` int(255) NOT NULL,
  `type` varchar(25) NOT NULL,
  `keyword` varchar(100) NOT NULL,
  `text` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `type`, `keyword`, `text`) VALUES
(507, 'english', 'site_description', 'Connect and share with the people that matters to you.'),
(508, 'english', 'sign_up_label', 'Sign Up'),
(509, 'english', 'fullname_label', 'Full name'),
(510, 'english', 'username_label', 'Username'),
(511, 'english', 'password_label', 'Password'),
(512, 'english', 'email_label', 'E-mail'),
(514, 'english', 'gender_label', 'Gender'),
(515, 'english', 'birthday_label', 'Birthday'),
(516, 'english', 'location_label', 'Current City'),
(517, 'english', 'hometown_label', 'Hometown'),
(518, 'english', 'captcha_label', 'Type the letters in the captcha'),
(519, 'english', 'gender_male_label', 'Male'),
(520, 'english', 'gender_female_label', 'Female'),
(521, 'english', 'login_id_label', 'Username or e-mail'),
(522, 'english', 'home_label', 'Home'),
(523, 'english', 'notification_label', 'Notifications'),
(524, 'english', 'message_label', 'Message'),
(525, 'english', 'header_search_textarea_label', 'Search for people, trends, pages and groups'),
(526, 'english', 'header_search_header_label', 'Search Results'),
(527, 'english', 'header_search_all_results_label', 'See all results'),
(528, 'english', 'notification_header_label', 'Notifications'),
(529, 'english', 'more_header_label', 'More'),
(530, 'english', 'my_profile_label', 'My Profile'),
(531, 'english', 'my_pages_groups_label', 'My Pages &amp; Groups'),
(532, 'english', 'more_settings_label', 'Settings'),
(533, 'english', 'follow_suggestions_label', 'Suggestions'),
(534, 'english', 'follow_requests_label', 'Follow requests'),
(535, 'english', 'following_label', 'Following'),
(536, 'english', 'followers_label', 'Followers'),
(537, 'english', 'liked_pages_label', 'Liked pages'),
(538, 'english', 'groups_joined_label', 'Groups Joined'),
(539, 'english', 'chat_label', 'Chat'),
(540, 'english', 'chat_search_label', 'Search for online friends'),
(541, 'english', 'messages_label', 'Messages'),
(542, 'english', 'messages_search_label', 'Search'),
(543, 'english', 'view_previous_messages_label', 'View previous messages'),
(544, 'english', 'no_messages_to_show_label', 'No messages to show'),
(545, 'english', 'write_a_message_label', 'Write a message'),
(546, 'english', 'edit_profile_label', 'Edit Profile'),
(547, 'english', 'change_avatar_label', 'Change avatar'),
(548, 'english', 'change_cover_label', 'Change cover'),
(549, 'english', 'reposition_cover_label', 'Reposition cover'),
(550, 'english', 'reposition_drag_label', 'Drag to reposition'),
(551, 'english', 'privacy_label', 'Privacy'),
(552, 'english', 'user_location_label', 'Lives in'),
(553, 'english', 'user_hometown_label', 'From'),
(554, 'english', 'filters_header', 'Post Filters'),
(555, 'english', 'filter_label_all', 'All'),
(556, 'english', 'filter_label_texts', 'Texts'),
(557, 'english', 'filter_label_photos', 'Photos'),
(558, 'english', 'filter_label_videos', 'Videos'),
(559, 'english', 'filter_label_music', 'Music'),
(560, 'english', 'filter_label_places', 'Places'),
(561, 'english', 'filter_label_likes', 'Likes'),
(562, 'english', 'filter_label_shares', 'Shares'),
(563, 'english', 'filter_label_post_by_others', 'Post by Others'),
(564, 'english', 'post_textarea_header_label', 'What&#039;s going on?'),
(565, 'english', 'post_textarea_label', 'Write something... #hashtags @mentions'),
(566, 'english', 'comment_textarea_label', 'Write a comment... Press Enter to post'),
(567, 'english', 'people_likes_this_label', 'people likes this'),
(568, 'english', 'liked_people_label', 'People who like this'),
(569, 'english', 'shared_people_label', 'People who shared this'),
(570, 'english', 'no_likes_label', 'No likes yet!'),
(571, 'english', 'no_shares_label', 'No shares yet!'),
(572, 'english', 'delete_post_label', 'Delete post'),
(573, 'english', 'view_all_comments_label', 'View all comments'),
(574, 'english', 'view_previous_posts_label', 'View previous posts'),
(575, 'english', 'page_create_label', 'Create Page'),
(576, 'english', 'page_category_label', 'Category'),
(577, 'english', 'description_label', 'Description'),
(578, 'english', 'page_name_textarea_label', 'Name of your page'),
(579, 'english', 'page_username_textarea_label', 'Username, e.g. YouTubeOfficial'),
(580, 'english', 'page_description_textarea_label', 'Write about your page...'),
(581, 'english', 'page_name_label', 'Name'),
(582, 'english', 'pages_name_label', 'Name'),
(583, 'english', 'address_label', 'Address'),
(584, 'english', 'awards_label', 'Awards'),
(585, 'english', 'phone_label', 'Phone'),
(586, 'english', 'products_label', 'Products'),
(587, 'english', 'pages_admin_roles_label', 'Admin Roles'),
(588, 'english', 'pages_add_admins_label', 'Add admins'),
(589, 'english', 'pages_likes_label', 'Page Likes'),
(590, 'english', 'pages_message_privacy', 'Allow people to send messages to Page'),
(591, 'english', 'pages_timeline_post_privacy', 'Allow people to post on Page&#039;s timeline'),
(592, 'english', 'group_create_label', 'Create Group'),
(593, 'english', 'group_name_textarea_label', 'Name of your group'),
(594, 'english', 'group_username_textarea_label', 'Username, e.g. Germany_Supporters_Group'),
(595, 'english', 'group_description_textarea_label', 'Write about your group...'),
(596, 'english', 'group_name_label', 'Name'),
(597, 'english', 'group_add_members_label', 'Add Members'),
(598, 'english', 'group_admins_label', 'Admins'),
(599, 'english', 'group_members_label', 'Members'),
(600, 'english', 'group_requests_label', 'Requests'),
(601, 'english', 'group_settings_label', 'Group Settings'),
(602, 'english', 'group_add_privacy_label', 'Who can add members to this group?'),
(603, 'english', 'group_timeline_post_privacy_label', 'Who can post on this group'),
(604, 'english', 'open_group_description', 'Anyone can see and join the group'),
(605, 'english', 'closed_group_description', 'Anyone can see and request to join the group. Requests can be accepted or declined by admins'),
(606, 'english', 'secret_group_description', 'Only members can access the group'),
(607, 'english', 'manage_pages_header_label', 'Pages You Manage'),
(608, 'english', 'no_managed_pages_label', 'You do not have any pages to manage'),
(609, 'english', 'manage_groups_header_label', 'Groups You Manage'),
(610, 'english', 'no_managed_groups_label', 'You do not have any groups to manage'),
(611, 'english', 'settings_label', 'Settings'),
(612, 'english', 'general_settings_label', 'General Settings'),
(613, 'english', 'privacy_settings_label', 'Privacy Settings'),
(614, 'english', 'timeline_avatar_label', 'Timeline Avatar'),
(615, 'english', 'timeline_cover_label', 'Timeline Cover'),
(616, 'english', 'confirm_follow_request_label', 'Confirm request when someone follows you'),
(617, 'english', 'follow_privacy_label', 'Who can follow you'),
(618, 'english', 'message_privacy_label', 'Who can message you'),
(619, 'english', 'comment_privacy_label', 'Who can comment on your posts'),
(620, 'english', 'timeline_post_privacy_label', 'Who can post on your timeline'),
(621, 'english', 'current_password_label', 'Current password'),
(622, 'english', 'new_password_label', 'New password'),
(623, 'english', 'update_password_label', 'Update password'),
(624, 'english', 'search_header_label', 'Search'),
(625, 'english', 'search_textarea_label', 'Search using name, username, email or ID'),
(626, 'english', 'search_result_header_label', 'Search results'),
(627, 'english', 'hashtag_search_header_label', 'See what&#039;s happening!'),
(628, 'english', 'hashtag_search_textarea_label', 'Search for posts using #hashtag'),
(629, 'english', 'terms_about_label', 'About'),
(630, 'english', 'terms_contact_label', 'Contact'),
(631, 'english', 'terms_privacy_label', 'Privacy Policy'),
(632, 'english', 'terms_tos_label', 'Terms of Use'),
(633, 'english', 'terms_disclaimer_label', 'Disclaimer'),
(634, 'english', 'about_us_label', 'About Us'),
(635, 'english', 'contact_us_label', 'Contact Us'),
(636, 'english', 'save_changes_button', 'Save Changes'),
(637, 'english', 'upload_button', 'Upload'),
(638, 'english', 'delete_button', 'Delete'),
(639, 'english', 'admin_link_label', 'Admin'),
(640, 'english', 'languages_label', 'Languages'),
(641, 'english', 'logout', 'Log Out'),
(642, 'english', 'menu_label', 'Menu'),
(643, 'english', 'refresh_label', 'Refresh'),
(644, 'english', 'january', 'January'),
(645, 'english', 'february', 'February'),
(646, 'english', 'march', 'March'),
(647, 'english', 'april', 'April'),
(648, 'english', 'may', 'May'),
(649, 'english', 'june', 'June'),
(650, 'english', 'july', 'July'),
(651, 'english', 'august', 'August'),
(652, 'english', 'september', 'September'),
(653, 'english', 'october', 'October'),
(654, 'english', 'november', 'November'),
(655, 'english', 'december', 'December'),
(656, 'english', 'accept', 'Accept'),
(657, 'english', 'accepting', 'Accepting'),
(658, 'english', 'add', 'Add'),
(659, 'english', 'added', 'Added'),
(660, 'english', 'adding', 'Adding'),
(661, 'english', 'added_all_followers_to_page', 'You have added all your followers as admins of this Page.'),
(662, 'english', 'admin', 'Admin'),
(663, 'english', 'admin_editor_difference', 'Editors have same abilities as Admins except they cannot add or remove any admins or editors.'),
(664, 'english', 'cancel', 'Cancel'),
(665, 'english', 'cannot_reply_to_conversation', 'You cannot reply to this conversation'),
(666, 'english', 'changes_saved', 'Changes saved!'),
(667, 'english', 'chat_new_update_alert', 'New!'),
(668, 'english', 'closed_group', 'Closed Group'),
(669, 'english', 'comments', 'Comments'),
(670, 'english', 'creating', 'Creating'),
(671, 'english', 'day', 'Day'),
(672, 'english', 'decline', 'Decline'),
(673, 'english', 'declining', 'Declining'),
(674, 'english', 'edit_label', 'Edit'),
(675, 'english', 'editor', 'Editor'),
(676, 'english', 'error_bad_captcha', 'Your captcha is incorrect.'),
(677, 'english', 'error_bad_login', 'Invalid username and/or password.'),
(678, 'english', 'error_empty_login', 'Please fill in all login details.'),
(679, 'english', 'error_empty_registration', 'Please fill in all registration details.'),
(680, 'english', 'error_verify_email', 'Please verify your email first.'),
(681, 'english', 'everyone', 'Everyone'),
(682, 'english', 'follow_button_label', 'Follow'),
(683, 'english', 'forgot_password', 'Forgot Password'),
(684, 'english', 'group_intro_header', 'Learn more about Groups'),
(685, 'english', 'group_intro_list1_header', 'Share different things with different people'),
(686, 'english', 'group_intro_list1_description', 'Groups let you share things with the people who will care about them most. By creating a group for each of the important parts of your life — family, teammates, coworkers — you decide who sees what you share.'),
(687, 'english', 'group_intro_list2_header', 'Who can you add to a group?'),
(688, 'english', 'group_intro_list2_description', 'You can add anyone you are following/are friends with.'),
(689, 'english', 'group_intro_list3_header', 'Who can join your group?'),
(690, 'english', 'group_intro_list3_description', 'Anyone can join your group if your group&#039;s privacy is set to Open. For Closed groups, anyone can request to join but requests have to be accepted by admins first. Secret groups are not visible to anyone but only the members of the group.'),
(691, 'english', 'group_label', 'Groups'),
(692, 'english', 'groups_label', 'Groups'),
(693, 'english', 'header_following_label', 'Following'),
(694, 'english', 'header_join_label', 'Join'),
(695, 'english', 'join_button_label', 'Join'),
(696, 'english', 'leave_button_label', 'Joined'),
(697, 'english', 'like_button_label', 'Like'),
(698, 'english', 'likes_label', 'Likes'),
(699, 'english', 'likes_this_label', 'likes this'),
(700, 'english', 'log_in', 'Log In'),
(701, 'english', 'log_in_facebook', 'Login with Facebook'),
(702, 'english', 'month', 'Month'),
(703, 'english', 'no', 'No'),
(704, 'english', 'no_admins', 'There are no admins.'),
(705, 'english', 'no_follow_requests', 'does not have any follow requests.'),
(706, 'english', 'no_followers', 'has no followers yet.'),
(707, 'english', 'no_followers_to_add_to_group', 'You do not have any followers to add to this group.'),
(708, 'english', 'no_followers_to_add_to_page', 'You do not have any followers to add as an admin of this Page.'),
(709, 'english', 'no_followings', 'has not followed anyone yet.'),
(710, 'english', 'no_groups_joined', 'has not joined any groups yet.'),
(711, 'english', 'no_liked_pages', 'has not liked any pages yet.'),
(712, 'english', 'no_notifications', 'You do not have any notifications'),
(713, 'english', 'no_one', 'No one'),
(714, 'english', 'no_result_found', 'No result found!'),
(715, 'english', 'open_group', 'Open Group'),
(716, 'english', 'page_intro_header', 'About Pages'),
(717, 'english', 'page_intro_list1_header', 'Brand your Page'),
(718, 'english', 'page_intro_list1_description', 'Add a unique cover photo and showcase your most important news on your Page timeline.'),
(719, 'english', 'page_intro_list2_header', 'Connect with a wide range of people'),
(720, 'english', 'page_intro_list2_description', 'Post new updates so people who cares knows what&#039;s going on and what matters.'),
(721, 'english', 'password_reset_mail_confirm', 'We have sent you an e-mail with instructions to reset your password. Please check your inbox.'),
(722, 'english', 'password_reset_mail_unknown', 'We could not recognize your username/e-mail.'),
(723, 'english', 'passwords_not_match', 'Passwords do not match.'),
(724, 'english', 'people_i_follow', 'People I Follow'),
(725, 'english', 'please_wait', 'Please wait'),
(726, 'english', 'post_button', 'Post'),
(727, 'english', 'post_follow_button_label', 'Get notifications'),
(728, 'english', 'post_followers_label', 'Followers'),
(729, 'english', 'post_unfollow_button_label', 'Stop notifications'),
(730, 'english', 'post_like_button_label', 'Like'),
(731, 'english', 'post_not_exist', 'This story does not exist anymore.'),
(732, 'english', 'post_unlike_button_label', 'Unlike'),
(733, 'english', 'posts_label', 'Posts'),
(734, 'english', 'post_publisher_soundcloud_placeholder', 'What are you listening?'),
(735, 'english', 'post_publisher_youtube_placeholder', 'What are you watching?'),
(736, 'english', 'post_publisher_googlemap_placeholder', 'Where are you?'),
(737, 'english', 'processing', 'Processing'),
(738, 'english', 'remove', 'Remove'),
(739, 'english', 'removing', 'Removing'),
(740, 'english', 'report', 'Report'),
(741, 'english', 'repositioning', 'Repositioning'),
(742, 'english', 'reset', 'Reset'),
(743, 'english', 'reset_password_label', 'Reset Password'),
(744, 'english', 'reset_password_reset', 'Request Password Reset'),
(745, 'english', 'request_sent_label', 'Requested'),
(746, 'english', 'requests_label', 'Requests'),
(747, 'english', 'save_position_label', 'Save Position'),
(748, 'english', 'search_button', 'Search'),
(749, 'english', 'searching', 'Searching...'),
(750, 'english', 'secret_group', 'Secret Group'),
(751, 'english', 'share_button_label', 'Share'),
(752, 'english', 'shares_label', 'Shares'),
(753, 'english', 'shared_this_label', 'shared this'),
(754, 'english', 'tagged_on_this_label', 'was tagged on this'),
(755, 'english', 'timezone', 'Timezone'),
(756, 'english', 'trending_header_label', 'Trending!'),
(757, 'english', 'unfollow_button_label', 'Following'),
(758, 'english', 'unlike_button_label', 'Liked'),
(759, 'english', 'unshare_button_label', 'Unshare'),
(760, 'english', 'upload_photo', 'Upload Photo'),
(761, 'english', 'uploaded', 'Uploaded'),
(762, 'english', 'uploading', 'Uploading'),
(763, 'english', 'verification_email_sent', 'Registration successful. We have sent you an email. Please check your inbox/spam to verify your email ID.'),
(764, 'english', 'year', 'Year'),
(765, 'english', 'yes', 'Yes'),
(767, 'english', 'accepted_friend_request', 'accepted your friend request'),
(768, 'english', 'accepted_group_join_request', 'accepted your request to join the group {group_name}'),
(769, 'english', 'add_as_friend_button', 'Add as friend'),
(770, 'english', 'added_all_followings_to_page', 'You have added all your followings as admins of this Page.'),
(771, 'english', 'added_all_friends_to_page', 'You have added all your friends as admins of this Page.'),
(772, 'english', 'added_to_group', 'added you to the group &quot;{group_name}&quot;'),
(773, 'english', 'album_create_label', 'Create Album'),
(774, 'english', 'albums', 'Albums'),
(775, 'english', 'commented_on_post', 'commented on your post &quot;{post}&quot;'),
(776, 'english', 'commented_on_user_post', 'commented on {user}&#039;s post &quot;{post}...&quot;'),
(777, 'english', 'create', 'Create'),
(778, 'english', 'following_you_plural', 'and {count} others are following you.'),
(779, 'english', 'following_you_singular', 'is following you.'),
(780, 'english', 'friends_button', 'Friends'),
(781, 'english', 'friends_label', 'Friends'),
(782, 'english', 'friends_requests_label', 'Friend Requests'),
(783, 'english', 'header_friends_label', 'Friends'),
(784, 'english', 'likes_your_post', 'likes your post &quot;{post}...&quot;'),
(785, 'english', 'made_group_admin', 'made you an admin of the group &quot;{group_name}&quot;'),
(786, 'english', 'made_page_admin', 'made you an admin of their Page'),
(787, 'english', 'mentioned_in_comment', 'mentioned you in a comment'),
(788, 'english', 'mentioned_in_post', 'mentioned you in a post'),
(789, 'english', 'my_friends', 'My Friends'),
(790, 'english', 'no_friends', 'has no friends yet!'),
(791, 'english', 'no_friends_to_add_to_group', 'You do not have any friends to add to this group.'),
(792, 'english', 'no_friends_to_add_to_page', 'You do not have any friends to add as an admin of this Page.'),
(793, 'english', 'notif_other_people', 'and {count} others'),
(794, 'english', 'post_privacy', 'Who can see your posts'),
(795, 'english', 'posted_on_timeline', 'posted on your timeline'),
(796, 'english', 'shared_your_post', 'shared your post &quot;{post}...&quot;'),
(797, 'english', 'site_description_paragraph', 'Never miss a thing out! Keep in touch with your fans, customers or loved ones all the time!'),
(798, 'english', 'go_mobile_description', 'Heading Out? Go Mobile!'),
(799, 'english', 'go_mobile_description_paragraph', 'One website for all devices. Whether you use desktop, tablet or smartphone, keep in touch with your friends!'),
(800, 'english', 'trending_description', 'Know what&#039;s happening!'),
(801, 'english', 'trending_description_paragraph', 'Stay ahead of the world. Keep an eye on what&#039;s trending around!'),
(802, 'english', 'all_rights_reserved', 'All rights reserved'),
(803, 'english', 'announcements', 'Announcements'),
(804, 'english', 'close_chat', 'Close chat'),
(805, 'english', 'connect_with_fb', 'Connect with Facebook'),
(806, 'english', 'copyright', 'Copyright'),
(807, 'english', 'create_an_album', 'Create album'),
(808, 'english', 'description_of_album', 'Description'),
(809, 'english', 'delete_album', 'Delete Album'),
(810, 'english', 'delete_photo', 'Delete Photo'),
(811, 'english', 'invalid_token', 'Invalid token'),
(812, 'english', 'keep_me_logged_in', 'Keep me logged in'),
(813, 'english', 'name_of_album', 'Name of album'),
(814, 'english', 'name_of_album_label', 'Name'),
(815, 'english', 'no_friends_online', 'None of your friends are online right now.'),
(816, 'english', 'no_followers_online', 'None of the people you follow are online right now.'),
(817, 'english', 'oops', 'Oops!'),
(818, 'english', 'no_search_result', 'No result found for your search.'),
(819, 'english', 'photos_selected', 'photo(s) selected'),
(820, 'english', 'upload_photos', 'Upload Photos'),
(821, 'english', 'welcome_to_sitename', 'Welcome to %sitename%'),
(822, 'english', 'close', 'Close'),
(823, 'english', 'likes_your_comment', 'likes your comment &quot;{comment}...&quot;'),
(824, 'english', 'delete_comment_label', 'Delete comment'),
(825, 'english', 'no_user_found', 'No user found.'),
(826, 'english', 'incorrect_password', 'Incorrect password.'),
(827, 'english', 'username_available', 'Username available!'),
(828, 'english', 'username_this_is_you', 'This is you!'),
(829, 'english', 'username_not_available', 'Username not available!'),
(830, 'english', 'username_requirements', 'Username should atleast be 4 characters, cannot be only numbers, can contain alphabets [A-Z], numbers [0-9] and underscores (_) only.'),
(831, 'english', 'view_more', 'View more'),
(832, 'english', 'loading', 'Loading...'),
(833, 'english', 'no_more_recipients', 'No more recipients'),
(834, 'english', 'email_notifications_label', 'Email Notifications'),
(835, 'english', 'email_notification_comment_label', 'E-mail me when someone comments on my posts'),
(836, 'english', 'email_notification_postlike_label', 'E-mail me when someone likes my post'),
(837, 'english', 'email_notification_postshare_label', 'E-mail me when someone shares my post'),
(838, 'english', 'email_notification_follow_label', 'E-mail me when someone follows me'),
(839, 'english', 'email_notification_friendrequest_label', 'E-mail me when someone sends me a friend request'),
(840, 'english', 'email_notification_groupjoined_label', 'E-mail me when someone wants to join my group'),
(841, 'english', 'email_notification_pagelike_label', 'E-mail me when someone likes my page'),
(842, 'english', 'email_notification_message_label', 'E-mail me when someone messages me'),
(843, 'english', 'email_notification_timelinepost_label', 'E-mail me when someone posts on my timeline'),
(844, 'english', 'error_email_exists', 'An account with this e-mail is already registered.'),
(845, 'english', 'new_comment_email_subject', '{user} has commented on your post'),
(846, 'english', 'new_like_email_subject', '{user} has liked your post'),
(847, 'english', 'new_share_email_subject', '{user} has shared your post'),
(848, 'english', 'new_follower_email_subject', '{user} is following you'),
(849, 'english', 'new_friend_request_email_subject', '{user} has sent you a friend request'),
(850, 'english', 'new_groupmember_email_subject', '{user} has joined your group'),
(851, 'english', 'new_grouprequest_email_subject', '{user} wants to join your group'),
(852, 'english', 'new_message_email_subject', '{user} messaged you'),
(853, 'english', 'new_pagelike_email_subject', '{user} has liked your page'),
(854, 'english', 'new_timelinepost_email_subject', '{user} posted on your timeline'),
(855, 'english', 'liked_your_page', '{user} has liked your page: {page}'),
(856, 'english', 'joined_your_group', '{user} has joined your group: {group}'),
(857, 'english', 'requested_to_join_your_group', '{user} requested to join your group: {group}'),
(858, 'english', 'posted_on_page_timeline', 'has posted on your page {page}&#039;s timeline'),
(859, 'english', 'pcat_local_business_or_place', 'Local Business or Place'),
(860, 'english', 'pcat_airport', 'Airport'),
(861, 'english', 'pcat_arts_entertainment_nightlife', 'Arts/Entertainment/Nightlife'),
(862, 'english', 'pcat_attractions_things_to_do', 'Attractions/Things to Do'),
(863, 'english', 'pcat_automotive', 'Automotive'),
(864, 'english', 'pcat_bank_financial_services', 'Bank/Financial Services'),
(865, 'english', 'pcat_bar', 'Bar'),
(866, 'english', 'pcat_book_store', 'Book Store'),
(867, 'english', 'pcat_business_services', 'Business Services'),
(868, 'english', 'pcat_church_religious_organization', 'Church/Religious Organization'),
(869, 'english', 'pcat_club', 'Club'),
(870, 'english', 'pcat_community_government', 'Community/Government'),
(871, 'english', 'pcat_concert_venue', 'Concert Venue'),
(872, 'english', 'pcat_doctor', 'Doctor'),
(873, 'english', 'pcat_education', 'Education'),
(874, 'english', 'pcat_event_planning_event_services', 'Event Planning/Event Services'),
(875, 'english', 'pcat_food_grocery', 'Food/Grocery'),
(876, 'english', 'pcat_health_medical_pharmacy', 'Health/Medical/Pharmacy'),
(877, 'english', 'pcat_home_improvement', 'Home Improvement'),
(878, 'english', 'pcat_hospital_clinic', 'Hospital/Clinic'),
(879, 'english', 'pcat_hotel', 'Hotel'),
(880, 'english', 'pcat_landmark', 'Landmark'),
(881, 'english', 'pcat_lawyer', 'Lawyer'),
(882, 'english', 'pcat_library', 'Library'),
(883, 'english', 'pcat_local_business', 'Local Business'),
(884, 'english', 'pcat_middle_school', 'Middle School'),
(885, 'english', 'pcat_movie_theater', 'Movie Theater'),
(886, 'english', 'pcat_museum_art_gallery', 'Museum/Art Gallery'),
(887, 'english', 'pcat_outdoor_gear_sporting_goods', 'Outdoor Gear/Sporting Goods'),
(888, 'english', 'pcat_pet_services', 'Pet Services'),
(889, 'english', 'pcat_professional_services', 'Professional Services'),
(890, 'english', 'pcat_public_places', 'Public Places'),
(891, 'english', 'pcat_real_estate', 'Real Estate'),
(892, 'english', 'pcat_restaurant_cafe', 'Restaurant/Cafe'),
(893, 'english', 'pcat_school', 'School'),
(894, 'english', 'pcat_shopping_retail', 'Shopping/Retail'),
(895, 'english', 'pcat_spas_beauty_personal_care', 'Spas/Beauty/Personal Care'),
(896, 'english', 'pcat_sports_venue', 'Sports Venue'),
(897, 'english', 'pcat_sports_recreation_activities', 'Sports/Recreation/Activities'),
(898, 'english', 'pcat_tours_sightseeing', 'Tours/Sightseeing'),
(899, 'english', 'pcat_transportation', 'Transportation'),
(900, 'english', 'pcat_university', 'University'),
(901, 'english', 'pcat_company__organization_or_institution', 'Company, Organization or Institution'),
(902, 'english', 'pcat_aerospace_defense', 'Aerospace/Defense'),
(903, 'english', 'pcat_automobiles_and_parts', 'Automobiles and Parts'),
(904, 'english', 'pcat_bank_financial_institution', 'Bank/Financial Institution'),
(905, 'english', 'pcat_biotechnology', 'Biotechnology'),
(906, 'english', 'pcat_cause', 'Cause'),
(907, 'english', 'pcat_chemicals', 'Chemicals'),
(908, 'english', 'pcat_community_organization', 'Community Organization'),
(909, 'english', 'pcat_company', 'Company'),
(910, 'english', 'pcat_computers_technology', 'Computers/Technology'),
(911, 'english', 'pcat_consulting_business_services', 'Consulting/Business Services'),
(912, 'english', 'pcat_energy_utility', 'Energy/Utility'),
(913, 'english', 'pcat_engineering_construction', 'Engineering/Construction'),
(914, 'english', 'pcat_farming_agriculture', 'Farming/Agriculture'),
(915, 'english', 'pcat_food_beverages', 'Food/Beverages'),
(916, 'english', 'pcat_government_organization', 'Government Organization'),
(917, 'english', 'pcat_health_beauty', 'Health/Beauty'),
(918, 'english', 'pcat_health_medical_pharmaceuticals', 'Health/Medical/Pharmaceuticals'),
(919, 'english', 'pcat_industrials', 'Industrials'),
(920, 'english', 'pcat_insurance_company', 'Insurance Company'),
(921, 'english', 'pcat_internet_software', 'Internet/Software'),
(922, 'english', 'pcat_legal_law', 'Legal/Law'),
(923, 'english', 'pcat_media_news_publishing', 'Media/News/Publishing'),
(924, 'english', 'pcat_mining_materials', 'Mining/Materials'),
(925, 'english', 'pcat_non_governmental_organization__ngo_', 'Non-Governmental Organization (NGO)'),
(926, 'english', 'pcat_non_profit_organization', 'Non-Profit Organization'),
(927, 'english', 'pcat_organization', 'Organization'),
(928, 'english', 'pcat_political_organization', 'Political Organization'),
(929, 'english', 'pcat_political_party', 'Political Party'),
(930, 'english', 'pcat_retail_and_consumer_merchandise', 'Retail and Consumer Merchandise'),
(931, 'english', 'pcat_small_business', 'Small Business'),
(932, 'english', 'pcat_telecommunication', 'Telecommunication'),
(933, 'english', 'pcat_transport_freight', 'Transport/Freight'),
(934, 'english', 'pcat_travel_leisure', 'Travel/Leisure'),
(935, 'english', 'pcat_brand_or_product', 'Brand or Product'),
(936, 'english', 'pcat_appliances', 'Appliances'),
(937, 'english', 'pcat_baby_goods_kids_goods', 'Baby Goods/Kids Goods'),
(938, 'english', 'pcat_bags_luggage', 'Bags/Luggage'),
(939, 'english', 'pcat_board_game', 'Board Game'),
(940, 'english', 'pcat_building_materials', 'Building Materials'),
(941, 'english', 'pcat_camera_photo', 'Camera/Photo'),
(942, 'english', 'pcat_cars', 'Cars'),
(943, 'english', 'pcat_clothing', 'Clothing'),
(944, 'english', 'pcat_commercial_equipment', 'Commercial Equipment'),
(945, 'english', 'pcat_computers', 'Computers'),
(946, 'english', 'pcat_drugs', 'Drugs'),
(947, 'english', 'pcat_electronics', 'Electronics'),
(948, 'english', 'pcat_furniture', 'Furniture'),
(949, 'english', 'pcat_games_toys', 'Games/Toys'),
(950, 'english', 'pcat_home_decor', 'Home Decor'),
(951, 'english', 'pcat_household_supplies', 'Household Supplies'),
(952, 'english', 'pcat_jewelry_watches', 'Jewelry/Watches'),
(953, 'english', 'pcat_kitchen_cooking', 'Kitchen/Cooking'),
(954, 'english', 'pcat_office_supplies', 'Office Supplies'),
(955, 'english', 'pcat_patio_garden', 'Patio/Garden'),
(956, 'english', 'pcat_pet_supplies', 'Pet Supplies'),
(957, 'english', 'pcat_phone_tablet', 'Phone/Tablet'),
(958, 'english', 'pcat_product_service', 'Product/Service'),
(959, 'english', 'pcat_software', 'Software'),
(960, 'english', 'pcat_tools_equipment', 'Tools/Equipment'),
(961, 'english', 'pcat_video_game', 'Video Game'),
(962, 'english', 'pcat_vitamins_supplements', 'Vitamins/Supplements'),
(963, 'english', 'pcat_website', 'Website'),
(964, 'english', 'pcat_wine_spirits', 'Wine/Spirits'),
(965, 'english', 'pcat_artist__band_or_public_figure', 'Artist, Band or Public Figure'),
(966, 'english', 'pcat_actor_director', 'Actor/Director'),
(967, 'english', 'pcat_artist', 'Artist'),
(968, 'english', 'pcat_athlete', 'Athlete'),
(969, 'english', 'pcat_author', 'Author'),
(970, 'english', 'pcat_business_person', 'Business Person'),
(971, 'english', 'pcat_chef', 'Chef'),
(972, 'english', 'pcat_coach', 'Coach'),
(973, 'english', 'pcat_comedian', 'Comedian'),
(974, 'english', 'pcat_dancer', 'Dancer'),
(975, 'english', 'pcat_designer', 'Designer'),
(976, 'english', 'pcat_entertainer', 'Entertainer'),
(977, 'english', 'pcat_entrepreneur', 'Entrepreneur'),
(978, 'english', 'pcat_fictional_character', 'Fictional Character'),
(979, 'english', 'pcat_government_official', 'Government Official'),
(980, 'english', 'pcat_journalist', 'Journalist'),
(981, 'english', 'pcat_movie_character', 'Movie Character'),
(982, 'english', 'pcat_musician_band', 'Musician/Band'),
(983, 'english', 'pcat_news_personality', 'News Personality'),
(984, 'english', 'pcat_pet', 'Pet'),
(985, 'english', 'pcat_photographer', 'Photographer'),
(986, 'english', 'pcat_politician', 'Politician'),
(987, 'english', 'pcat_producer', 'Producer'),
(988, 'english', 'pcat_public_figure', 'Public Figure'),
(989, 'english', 'pcat_teacher', 'Teacher'),
(990, 'english', 'pcat_writer', 'Writer'),
(991, 'english', 'pcat_entertainment', 'Entertainment'),
(992, 'english', 'pcat_album', 'Album'),
(993, 'english', 'pcat_amateur_sports_team', 'Amateur Sports Team'),
(994, 'english', 'pcat_book', 'Book'),
(995, 'english', 'pcat_book_series', 'Book Series'),
(996, 'english', 'pcat_concert_tour', 'Concert Tour'),
(997, 'english', 'pcat_magazine', 'Magazine'),
(998, 'english', 'pcat_movie', 'Movie'),
(999, 'english', 'pcat_music_award', 'Music Award'),
(1000, 'english', 'pcat_music_chart', 'Music Chart'),
(1001, 'english', 'pcat_music_video', 'Music Video'),
(1002, 'english', 'pcat_professional_sports_team', 'Professional Sports Team'),
(1003, 'english', 'pcat_radio_station', 'Radio Station'),
(1004, 'english', 'pcat_record_label', 'Record Label'),
(1005, 'english', 'pcat_school_sports_team', 'School Sports Team'),
(1006, 'english', 'pcat_song', 'Song'),
(1007, 'english', 'pcat_sports_league', 'Sports League'),
(1008, 'english', 'pcat_studio', 'Studio'),
(1009, 'english', 'pcat_tv_channel', 'TV Channel'),
(1010, 'english', 'pcat_tv_network', 'TV Network'),
(1011, 'english', 'pcat_tv_show', 'TV Show'),
(1012, 'english', 'pcat_tv_movie_award', 'TV/Movie Award'),
(1013, 'english', 'user_follow_suggestions_label', 'People You May Know'),
(1014, 'english', 'page_like_suggestions_label', 'Pages You May Like'),
(1015, 'english', 'group_join_suggestions_label', 'Groups You May Join'),
(1016, 'english', 'deactivate_account_label', 'Deactivate account'),
(4109, 'english', '404_error', '&#60;h2&#62;Sorry, this page isn&#39;t available&#60;/h3&#62;&#60;br&#62;&#60;h3&#62;The link you followed may be broken, or the page may have been removed.&#60;/h5&#62;'),
(5146, 'english', 'about_label', 'About'),
(5154, 'english', 'deactivate_account_confirm_message', 'Are you sure you want to deactivate your account?'),
(5162, 'english', 'deactivate_account_button', 'Yes, deactivate'),
(5170, 'english', 'account_deactivated', 'Your account has been deactivated! You will be logged out shortly.'),
(5178, 'english', 'something_went_wrong', 'Oops! Something went wrong. Please try again.'),
(5186, 'english', 'reaction_wow_label', 'Wow'),
(5194, 'english', 'reaction_haha_label', 'Haha'),
(5202, 'english', 'reaction_sad_label', 'Sad'),
(5210, 'english', 'reaction_angry_label', 'Angry'),
(5218, 'english', 'reaction_love_label', 'Love'),
(5226, 'english', 'new_reaction_email_subject', '{user} has reacted to your post'),
(5234, 'english', 'reacted_to_your_post', 'reacted to your post &quot;{post}...&quot;'),
(5242, 'english', 'reactions_label', 'Reactions'),
(5250, 'english', 'terms_developers_label', 'Developers'),
(5258, 'english', 'api_documentation_label', 'API Documentation'),
(5776, 'english', 'api_version_label', 'API Version');

-- --------------------------------------------------------

--
-- Table structure for table `media`
--

CREATE TABLE `media` (
  `id` int(11) NOT NULL,
  `active` int(1) NOT NULL DEFAULT 0,
  `album_id` int(11) NOT NULL DEFAULT 0,
  `descr` text COLLATE utf8_unicode_ci NOT NULL,
  `extension` varchar(4) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'none',
  `name` text COLLATE utf8_unicode_ci NOT NULL,
  `post_id` int(11) NOT NULL,
  `temp` int(1) NOT NULL DEFAULT 1,
  `timeline_id` int(11) NOT NULL,
  `type` enum('photo','album') COLLATE utf8_unicode_ci NOT NULL,
  `url` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `media`
--

INSERT INTO `media` (`id`, `active`, `album_id`, `descr`, `extension`, `name`, `post_id`, `temp`, `timeline_id`, `type`, `url`) VALUES
(9, 1, 0, 'fgjhhgjhgj', 'none', 'gyujghj', 0, 0, 1, 'album', ''),
(10, 1, 9, '', 'jpg', 'wallpaperflare.com_wallpaper.jpg', 13, 0, 1, 'photo', 'photos/2020/08/XddmC_10_d3d9446802a44259755d38e6d163e820'),
(11, 1, 0, 'fghgfvhfgh', 'none', 'vgjhnvn', 0, 0, 1, 'album', ''),
(12, 1, 11, '', 'jpg', 'wallpaperflare.com_wallpaper.jpg', 15, 0, 1, 'photo', 'photos/2020/08/Jfoyb_12_c20ad4d76fe97759aa27a0c99bff6710'),
(13, 1, 0, 'fghgfvhfgh', 'none', 'vgjhnvn', 0, 0, 1, 'album', ''),
(14, 1, 13, '', 'png', 'F_20200612141982Qtv3Sb.png', 17, 0, 1, 'photo', 'photos/2020/08/pKCjJ_14_aab3238922bcc25a6f606eb525ffdc56'),
(15, 1, 0, 'fghgfvhfgh', 'none', 'vgjhnvn', 0, 0, 1, 'album', ''),
(16, 1, 15, '', 'png', 'F_20200612141982Qtv3Sb.png', 19, 0, 1, 'photo', 'photos/2020/08/dqvXp_16_c74d97b01eae257e44aa9d5bade97baf'),
(17, 1, 15, '', 'jpg', 'wallpaperflare.com_wallpaper.jpg', 21, 0, 1, 'photo', 'photos/2020/08/Uwwo5_17_70efdf2ec9b086079795c442636b55fb'),
(18, 1, 0, 'fghgfvhfgh', 'none', 'vgjhnvn', 0, 0, 1, 'album', ''),
(19, 1, 18, '', 'png', 'F_20200612141982Qtv3Sb.png', 23, 0, 1, 'photo', 'photos/2020/08/CsJR8_19_1f0e3dad99908345f7439f8ffabdffc4'),
(20, 1, 0, 'fghgfvhfgh', 'none', 'gfhgfh', 0, 0, 1, 'album', ''),
(21, 1, 20, '', 'png', 'F_20200612141982Qtv3Sb.png', 25, 0, 1, 'photo', 'photos/2020/08/vRRDw_21_3c59dc048e8850243be8079a5c74d079'),
(22, 1, 20, '', 'jpg', 'wallpaperflare.com_wallpaper.jpg', 27, 0, 1, 'photo', 'photos/2020/08/sdIgS_22_b6d767d2f8ed5d21a44b0e5886680cb9'),
(25, 1, 0, '', 'jpg', 'wallpaperflare.com_wallpaper.jpg', 0, 0, 1, 'photo', 'photos/2020/08/rAaSN_25_8e296a067a37563370ded05f5a3bf3ec'),
(26, 1, 0, '', 'jpg', 'wallpaperflare.com_wallpaper.jpg', 0, 0, 0, 'photo', 'photos/2020/08/HHjz2_26_4e732ced3463d06de0ca9a15b6153677'),
(27, 1, 0, '', 'jpg', 'wallpaperflare.com_wallpaper.jpg', 0, 0, 1, 'photo', 'photos/2020/08/ArEJG_27_02e74f10e0327ad868d138f2b4fdd6f0'),
(28, 1, 0, '', 'jpg', 'wallpaperflare.com_wallpaper.jpg', 0, 0, 1, 'photo', 'photos/2020/08/AWGmn_28_33e75ff09dd601bbe69f351039152189'),
(29, 1, 0, '', 'jpg', 'wallpaperflare.com_wallpaper.jpg', 0, 0, 1, 'photo', 'photos/2020/08/5RRt2_29_6ea9ab1baa0efb9e19094440c317e21b'),
(30, 1, 0, '', 'jpg', 'ryzen-wallp.jpg', 0, 0, 1, 'photo', 'photos/2020/08/RUk7R_30_34173cb38f07f89ddbebc2ac9128303f'),
(31, 1, 0, '', 'jpg', 'ryzen-wallp.jpg', 0, 0, 1, 'photo', 'photos/2020/08/iVXnC_31_c16a5320fa475530d9583c34fd356ef5'),
(32, 1, 0, '', 'jpg', 'ryzen-wallp.jpg', 0, 0, 1, 'photo', 'photos/2020/08/tHOq1_32_6364d3f0f495b6ab9dcf8d3b5c6e0b01'),
(33, 1, 0, '', 'jpg', 'ryzen-wallp.jpg', 0, 0, 1, 'photo', 'photos/2020/08/cVaVX_33_182be0c5cdcd5072bb1864cdee4d3d6e'),
(34, 1, 0, '', 'jpg', 'ryzen-wallp.jpg', 0, 0, 1, 'photo', 'photos/2020/08/tR98O_34_e369853df766fa44e1ed0ff613f563bd'),
(35, 1, 0, '', 'jpg', 'ryzen-wallp.jpg', 0, 0, 1, 'photo', 'photos/2020/08/Soqmy_35_1c383cd30b7c298ab50293adfecb7b18'),
(36, 1, 0, '', 'jpg', 'amd-ryzen-72700x-am4-protsessor-ryzen-riazan-riazhenka-kukur.jpg', 0, 0, 1, 'photo', 'photos/2020/08/FIJan_36_19ca14e7ea6328a42e0eb13d585e4c22'),
(37, 1, 0, '', 'jpg', 'amd-ryzen-72700x-am4-protsessor-ryzen-riazan-riazhenka-kukur.jpg', 0, 0, 1, 'photo', 'photos/2020/08/nQ5ja_37_a5bfc9e07964f8dddeb95fc584cd965d'),
(38, 1, 0, '', 'jpg', 'amd-ryzen-72700x-am4-protsessor-ryzen-riazan-riazhenka-kukur.jpg', 0, 0, 1, 'photo', 'photos/2020/08/MXjGP_38_a5771bce93e200c36f7cd9dfd0e5deaa'),
(39, 1, 0, '', 'jpg', 'ryzen-wallp.jpg', 0, 0, 1, 'photo', 'photos/2020/08/ef9bY_39_d67d8ab4f4c10bf22aa353e27879133c'),
(40, 1, 0, '', 'jpg', 'amd-ryzen-72700x-am4-protsessor-ryzen-riazan-riazhenka-kukur.jpg', 0, 0, 1, 'photo', 'photos/2020/08/nI675_40_d645920e395fedad7bbbed0eca3fe2e0'),
(41, 1, 0, '', 'jpg', 'ryzen-wallp.jpg', 0, 0, 1, 'photo', 'photos/2020/08/hHiBS_41_3416a75f4cea9109507cacd8e2f2aefc'),
(42, 1, 0, '', 'jpg', 'ryzen-wallp.jpg', 0, 0, 1, 'photo', 'photos/2020/08/4YrmD_42_a1d0c6e83f027327d8461063f4ac58a6'),
(43, 1, 0, '', 'jpg', 'ryzen-wallp.jpg', 0, 0, 1, 'photo', 'photos/2020/08/vRj6u_43_17e62166fc8586dfa4d1bc0e1742c08b'),
(44, 1, 0, '', 'jpg', 'amd-ryzen-72700x-am4-protsessor-ryzen-riazan-riazhenka-kukur.jpg', 0, 0, 1, 'photo', 'photos/2020/08/3Wyvo_44_f7177163c833dff4b38fc8d2872f1ec6'),
(45, 1, 0, '', 'jpg', 'ryzen-wallp.jpg', 0, 0, 1, 'photo', 'photos/2020/08/HOgiR_45_6c8349cc7260ae62e3b1396831a8398f'),
(46, 1, 0, '', 'jpg', 'wallpaperflare.com_wallpaper.jpg', 0, 0, 1, 'photo', 'photos/2020/08/y6RnK_46_d9d4f495e875a2e075a1a4a6e1b9770f'),
(47, 1, 0, '', 'jpg', 'amd-ryzen-72700x-am4-protsessor-ryzen-riazan-riazhenka-kukur.jpg', 0, 0, 1, 'photo', 'photos/2020/08/L83nC_47_67c6a1e7ce56d3d6fa748ab6d9af3fd7'),
(48, 1, 0, '', 'jpg', 'wallpaperflare.com_wallpaper.jpg', 0, 0, 1, 'photo', 'photos/2020/08/S2Ysf_48_642e92efb79421734881b53e1e1b18b6'),
(49, 1, 0, '', 'jpg', 'ryzen-wallp.jpg', 0, 0, 1, 'photo', 'photos/2020/08/fgbFg_49_f457c545a9ded88f18ecee47145a72c0'),
(50, 1, 0, '', 'jpg', 'amd-ryzen-72700x-am4-protsessor-ryzen-riazan-riazhenka-kukur.jpg', 0, 0, 1, 'photo', 'photos/2020/08/fCpLH_50_c0c7c76d30bd3dcaefc96f40275bdc0a'),
(51, 1, 0, '', 'jpg', 'amd-ryzen-72700x-am4-protsessor-ryzen-riazan-riazhenka-kukur.jpg', 0, 0, 1, 'photo', 'photos/2020/08/8wlxq_51_2838023a778dfaecdc212708f721b788'),
(52, 1, 0, '', 'jpg', 'ryzen-wallp.jpg', 0, 0, 1, 'photo', 'photos/2020/08/FjHwY_52_9a1158154dfa42caddbd0694a4e9bdc8'),
(53, 1, 0, '', 'jpg', 'Koala.jpg', 0, 0, 35, 'photo', 'photos/2020/10/T88aQ_53_d82c8d1619ad8176d665453cfb2e55f0');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `active` int(1) NOT NULL DEFAULT 0,
  `media_id` int(11) NOT NULL DEFAULT 0,
  `recipient_id` int(11) NOT NULL DEFAULT 0,
  `seen` int(12) NOT NULL DEFAULT 0,
  `text` text COLLATE utf8_unicode_ci NOT NULL,
  `time` int(12) NOT NULL,
  `timeline_id` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `active`, `media_id`, `recipient_id`, `seen`, `text`, `time`, `timeline_id`, `timestamp`) VALUES
(8, 1, 27, 10, 1600631359, '', 1598721452, 1, '2020-09-20 19:49:19'),
(9, 1, 0, 10, 1600631358, 'rtyrt', 1598721912, 1, '2020-09-20 19:49:18'),
(10, 1, 0, 10, 1600631358, 'ftytyty', 1598721913, 1, '2020-09-20 19:49:18'),
(11, 1, 0, 10, 1600631358, 'ftytfyf', 1598721915, 1, '2020-09-20 19:49:18'),
(12, 1, 29, 10, 1600631358, '', 1598723143, 1, '2020-09-20 19:49:18'),
(13, 1, 0, 10, 1600631358, 'fcghfc', 1598966054, 1, '2020-09-20 19:49:18');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `active` int(1) NOT NULL,
  `notifier_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `seen` int(12) NOT NULL,
  `text` text COLLATE utf8_unicode_ci NOT NULL,
  `time` int(12) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `timeline_id` int(11) NOT NULL,
  `type` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'none',
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `active`, `notifier_id`, `post_id`, `seen`, `text`, `time`, `timestamp`, `timeline_id`, `type`, `url`) VALUES
(1, 1, 1, 0, 0, 'rtyurtyr has liked your page: jcjhff', 1598718400, '2020-08-29 16:26:40', 5, 'pagelike', 'index.php?tab1=timeline&id=6'),
(2, 1, 1, 0, 0, 'is following you.', 1598718483, '2020-08-29 16:28:03', 7, 'following', 'index.php?tab1=timeline&tab2=followers&id=7'),
(3, 1, 1, 0, 0, 'is following you.', 1598718485, '2020-08-29 16:28:05', 5, 'following', 'index.php?tab1=timeline&tab2=followers&id=5'),
(4, 1, 1, 0, 0, 'is following you.', 1598719857, '2020-08-29 16:50:57', 2, 'following', 'index.php?tab1=timeline&tab2=followers&id=2'),
(5, 1, 1, 0, 0, 'rtyurtyr has liked your page: fyujfhftr', 1598723080, '2020-08-29 17:44:40', 7, 'pagelike', 'index.php?tab1=timeline&id=9'),
(6, 1, 1, 0, 0, 'rtyurtyr requested to join your group: fthfhhf', 1598723082, '2020-08-29 17:44:42', 7, 'grouprequest', 'index.php?tab1=timeline&id=8'),
(9, 1, 1, 36, 0, 'posted on your timeline', 1600382159, '2020-09-17 22:35:59', 15, 'timeline_wall_post', 'index.php?tab1=story&id=36'),
(10, 1, 1, 0, 0, 'is following you.', 1600617232, '2020-09-20 15:53:52', 15, 'following', 'index.php?tab1=timeline&tab2=followers&id=15'),
(11, 1, 37, 0, 0, 'is following you.', 1602880033, '2020-10-16 20:27:13', 35, 'following', 'index.php?tab1=timeline&tab2=followers&id=35'),
(14, 1, 37, 67, 0, 'likes your post &quot;vdsfgdgdggdgdgdgdgdgdg...&quot;', 1602954209, '2020-10-17 17:03:29', 35, 'like', 'index.php?tab1=story&id=67');

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` int(11) NOT NULL,
  `address` text COLLATE utf8_unicode_ci NOT NULL,
  `awards` text COLLATE utf8_unicode_ci NOT NULL,
  `category_id` int(11) NOT NULL,
  `message_privacy` varchar(15) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'none',
  `phone` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `products` text COLLATE utf8_unicode_ci NOT NULL,
  `timeline_post_privacy` varchar(15) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'everyone',
  `website` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `address`, `awards`, `category_id`, `message_privacy`, `phone`, `products`, `timeline_post_privacy`, `website`) VALUES
(3, 'mnbmbmg', 'gmmgmm', 3, 'everyone', 'gmgmgmgm', 'gmgmm', 'everyone', ''),
(4, '', '', 8, 'everyone', '', '', 'everyone', ''),
(6, '', '', 40, 'everyone', '', '', 'everyone', ''),
(9, '', '', 2, 'everyone', '', '', 'everyone', ''),
(10, '', '', 2, 'everyone', '', '', 'everyone', ''),
(12, 'ggfdgfdgdg', 'gdfgdfgd', 2, 'everyone', '', '', 'everyone', ''),
(19, 'nghngn', 'ghnhgn', 2, 'none', '', '', 'everyone', '');

-- --------------------------------------------------------

--
-- Table structure for table `page_admins`
--

CREATE TABLE `page_admins` (
  `id` int(11) NOT NULL,
  `active` int(1) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `page_id` int(11) NOT NULL,
  `role` varchar(15) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `page_admins`
--

INSERT INTO `page_admins` (`id`, `active`, `admin_id`, `page_id`, `role`) VALUES
(1, 1, 1, 3, 'admin'),
(2, 1, 1, 4, 'admin'),
(3, 1, 5, 6, 'admin'),
(4, 1, 7, 9, 'admin'),
(5, 1, 1, 10, 'admin'),
(6, 1, 1, 12, 'admin'),
(7, 1, 1, 19, 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `page_categories`
--

CREATE TABLE `page_categories` (
  `id` int(11) NOT NULL,
  `active` int(1) NOT NULL,
  `category_id` int(11) NOT NULL,
  `name` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `page_categories`
--

INSERT INTO `page_categories` (`id`, `active`, `category_id`, `name`) VALUES
(1, 1, 0, 'pcat_local_business_or_place'),
(2, 1, 1, 'pcat_airport'),
(3, 1, 1, 'pcat_arts_entertainment_nightlife'),
(4, 1, 1, 'pcat_attractions_things_to_do'),
(5, 1, 1, 'pcat_automotive'),
(6, 1, 1, 'pcat_bank_financial_services'),
(7, 1, 1, 'pcat_bar'),
(8, 1, 1, 'pcat_book_store'),
(9, 1, 1, 'pcat_business_services'),
(10, 1, 1, 'pcat_church_religious_organization'),
(11, 1, 1, 'pcat_club'),
(12, 1, 1, 'pcat_community_government'),
(13, 1, 1, 'pcat_concert_venue'),
(14, 1, 1, 'pcat_doctor'),
(15, 1, 1, 'pcat_education'),
(16, 1, 1, 'pcat_event_planning_event_services'),
(17, 1, 1, 'pcat_food_grocery'),
(18, 1, 1, 'pcat_health_medical_pharmacy'),
(19, 1, 1, 'pcat_home_improvement'),
(20, 1, 1, 'pcat_hospital_clinic'),
(21, 1, 1, 'pcat_hotel'),
(22, 1, 1, 'pcat_landmark'),
(23, 1, 1, 'pcat_lawyer'),
(24, 1, 1, 'pcat_library'),
(25, 1, 1, 'pcat_local_business'),
(26, 1, 1, 'pcat_middle_school'),
(27, 1, 1, 'pcat_movie_theater'),
(28, 1, 1, 'pcat_museum_art_gallery'),
(29, 1, 1, 'pcat_outdoor_gear_sporting_goods'),
(30, 1, 1, 'pcat_pet_services'),
(31, 1, 1, 'pcat_professional_services'),
(32, 1, 1, 'pcat_public_places'),
(33, 1, 1, 'pcat_real_estate'),
(34, 1, 1, 'pcat_restaurant_cafe'),
(35, 1, 1, 'pcat_school'),
(36, 1, 1, 'pcat_shopping_retail'),
(37, 1, 1, 'pcat_spas_beauty_personal_care'),
(38, 1, 1, 'pcat_sports_venue'),
(39, 1, 1, 'pcat_sports_recreation_activities'),
(40, 1, 1, 'pcat_tours_sightseeing'),
(41, 1, 1, 'pcat_transportation'),
(42, 1, 1, 'pcat_university'),
(43, 1, 0, 'pcat_company__organization_or_institution'),
(44, 1, 43, 'pcat_aerospace_defense'),
(45, 1, 43, 'pcat_automobiles_and_parts'),
(46, 1, 43, 'pcat_bank_financial_institution'),
(47, 1, 43, 'pcat_biotechnology'),
(48, 1, 43, 'pcat_cause'),
(49, 1, 43, 'pcat_chemicals'),
(50, 1, 43, 'pcat_church_religious_organization'),
(51, 1, 43, 'pcat_community_organization'),
(52, 1, 43, 'pcat_company'),
(53, 1, 43, 'pcat_computers_technology'),
(54, 1, 43, 'pcat_consulting_business_services'),
(55, 1, 43, 'pcat_education'),
(56, 1, 43, 'pcat_energy_utility'),
(57, 1, 43, 'pcat_engineering_construction'),
(58, 1, 43, 'pcat_farming_agriculture'),
(59, 1, 43, 'pcat_food_beverages'),
(60, 1, 43, 'pcat_government_organization'),
(61, 1, 43, 'pcat_health_beauty'),
(62, 1, 43, 'pcat_health_medical_pharmaceuticals'),
(63, 1, 43, 'pcat_industrials'),
(64, 1, 43, 'pcat_insurance_company'),
(65, 1, 43, 'pcat_internet_software'),
(66, 1, 43, 'pcat_legal_law'),
(67, 1, 43, 'pcat_media_news_publishing'),
(68, 1, 43, 'pcat_middle_school'),
(69, 1, 43, 'pcat_mining_materials'),
(70, 1, 43, 'pcat_non_governmental_organization__ngo_'),
(71, 1, 43, 'pcat_non_profit_organization'),
(72, 1, 43, 'pcat_organization'),
(73, 1, 43, 'pcat_political_organization'),
(74, 1, 43, 'pcat_political_party'),
(75, 1, 43, 'pcat_retail_and_consumer_merchandise'),
(76, 1, 43, 'pcat_school'),
(77, 1, 43, 'pcat_small_business'),
(78, 1, 43, 'pcat_telecommunication'),
(79, 1, 43, 'pcat_transport_freight'),
(80, 1, 43, 'pcat_travel_leisure'),
(81, 1, 43, 'pcat_university'),
(82, 1, 0, 'pcat_brand_or_product'),
(83, 1, 82, 'pcat_appliances'),
(84, 1, 82, 'pcat_baby_goods_kids_goods'),
(85, 1, 82, 'pcat_bags_luggage'),
(86, 1, 82, 'pcat_board_game'),
(87, 1, 82, 'pcat_building_materials'),
(88, 1, 82, 'pcat_camera_photo'),
(89, 1, 82, 'pcat_cars'),
(90, 1, 82, 'pcat_clothing'),
(91, 1, 82, 'pcat_commercial_equipment'),
(92, 1, 82, 'pcat_computers'),
(93, 1, 82, 'pcat_drugs'),
(94, 1, 82, 'pcat_electronics'),
(95, 1, 82, 'pcat_food_beverages'),
(96, 1, 82, 'pcat_furniture'),
(97, 1, 82, 'pcat_games_toys'),
(98, 1, 82, 'pcat_health_beauty'),
(99, 1, 82, 'pcat_home_decor'),
(100, 1, 82, 'pcat_household_supplies'),
(101, 1, 82, 'pcat_jewelry_watches'),
(102, 1, 82, 'pcat_kitchen_cooking'),
(103, 1, 82, 'pcat_office_supplies'),
(104, 1, 82, 'pcat_outdoor_gear_sporting_goods'),
(105, 1, 82, 'pcat_patio_garden'),
(106, 1, 82, 'pcat_pet_supplies'),
(107, 1, 82, 'pcat_phone_tablet'),
(108, 1, 82, 'pcat_product_service'),
(109, 1, 82, 'pcat_software'),
(110, 1, 82, 'pcat_tools_equipment'),
(111, 1, 82, 'pcat_video_game'),
(112, 1, 82, 'pcat_vitamins_supplements'),
(113, 1, 82, 'pcat_website'),
(114, 1, 82, 'pcat_wine_spirits'),
(115, 1, 0, 'pcat_artist__band_or_public_figure'),
(116, 1, 115, 'pcat_actor_director'),
(117, 1, 115, 'pcat_artist'),
(118, 1, 115, 'pcat_athlete'),
(119, 1, 115, 'pcat_author'),
(120, 1, 115, 'pcat_business_person'),
(121, 1, 115, 'pcat_chef'),
(122, 1, 115, 'pcat_coach'),
(123, 1, 115, 'pcat_comedian'),
(124, 1, 115, 'pcat_dancer'),
(125, 1, 115, 'pcat_designer'),
(126, 1, 115, 'pcat_entertainer'),
(127, 1, 115, 'pcat_entrepreneur'),
(128, 1, 115, 'pcat_fictional_character'),
(129, 1, 115, 'pcat_government_official'),
(130, 1, 115, 'pcat_journalist'),
(131, 1, 115, 'pcat_movie_character'),
(132, 1, 115, 'pcat_musician_band'),
(133, 1, 115, 'pcat_news_personality'),
(134, 1, 115, 'pcat_pet'),
(135, 1, 115, 'pcat_photographer'),
(136, 1, 115, 'pcat_politician'),
(137, 1, 115, 'pcat_producer'),
(138, 1, 115, 'pcat_public_figure'),
(139, 1, 115, 'pcat_teacher'),
(140, 1, 115, 'pcat_writer'),
(141, 1, 0, 'pcat_entertainment'),
(142, 1, 141, 'pcat_album'),
(143, 1, 141, 'pcat_amateur_sports_team'),
(144, 1, 141, 'pcat_book'),
(145, 1, 141, 'pcat_book_series'),
(146, 1, 141, 'pcat_book_store'),
(147, 1, 141, 'pcat_concert_tour'),
(148, 1, 141, 'pcat_concert_venue'),
(149, 1, 141, 'pcat_fictional_character'),
(150, 1, 141, 'pcat_library'),
(151, 1, 141, 'pcat_magazine'),
(152, 1, 141, 'pcat_movie'),
(153, 1, 141, 'pcat_movie_character'),
(154, 1, 141, 'pcat_movie_theater'),
(155, 1, 141, 'pcat_music_award'),
(156, 1, 141, 'pcat_music_chart'),
(157, 1, 141, 'pcat_music_video'),
(158, 1, 141, 'pcat_professional_sports_team'),
(159, 1, 141, 'pcat_radio_station'),
(160, 1, 141, 'pcat_record_label'),
(161, 1, 141, 'pcat_school_sports_team'),
(162, 1, 141, 'pcat_song'),
(163, 1, 141, 'pcat_sports_league'),
(164, 1, 141, 'pcat_sports_venue'),
(165, 1, 141, 'pcat_studio'),
(166, 1, 141, 'pcat_tv_channel'),
(167, 1, 141, 'pcat_tv_network'),
(168, 1, 141, 'pcat_tv_show'),
(169, 1, 141, 'pcat_tv_movie_award');

-- --------------------------------------------------------

--
-- Table structure for table `plugins`
--

CREATE TABLE `plugins` (
  `id` int(11) NOT NULL,
  `active` int(1) NOT NULL DEFAULT 0,
  `folder` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `postfollows`
--

CREATE TABLE `postfollows` (
  `id` int(11) NOT NULL,
  `active` int(1) NOT NULL DEFAULT 0,
  `post_id` int(11) NOT NULL DEFAULT 0,
  `time` int(12) NOT NULL,
  `timeline_id` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `postfollows`
--

INSERT INTO `postfollows` (`id`, `active`, `post_id`, `time`, `timeline_id`, `timestamp`) VALUES
(1, 1, 1, 1598567348, 1, '2020-08-27 22:29:08'),
(2, 1, 2, 1598569306, 1, '2020-08-27 23:01:46'),
(3, 1, 3, 1598569306, 1, '2020-08-27 23:01:46'),
(4, 1, 4, 1598569318, 1, '2020-08-27 23:01:58'),
(5, 1, 5, 1598569318, 1, '2020-08-27 23:01:58'),
(6, 1, 6, 1598569328, 1, '2020-08-27 23:02:08'),
(7, 1, 7, 1598569328, 1, '2020-08-27 23:02:08'),
(8, 1, 8, 1598569409, 1, '2020-08-27 23:03:29'),
(9, 1, 9, 1598569409, 1, '2020-08-27 23:03:29'),
(10, 1, 10, 1598569413, 1, '2020-08-27 23:03:33'),
(11, 1, 11, 1598569413, 1, '2020-08-27 23:03:33'),
(12, 1, 12, 1598570294, 1, '2020-08-27 23:18:14'),
(13, 1, 13, 1598607880, 1, '2020-08-28 09:44:40'),
(14, 1, 14, 1598607880, 1, '2020-08-28 09:44:40'),
(15, 1, 15, 1598608010, 1, '2020-08-28 09:46:50'),
(16, 1, 16, 1598608010, 1, '2020-08-28 09:46:50'),
(17, 1, 17, 1598608077, 1, '2020-08-28 09:47:57'),
(18, 1, 18, 1598608077, 1, '2020-08-28 09:47:57'),
(19, 1, 19, 1598608142, 1, '2020-08-28 09:49:02'),
(20, 1, 20, 1598608142, 1, '2020-08-28 09:49:02'),
(21, 1, 21, 1598608147, 1, '2020-08-28 09:49:07'),
(22, 1, 22, 1598608147, 1, '2020-08-28 09:49:07'),
(23, 1, 23, 1598608224, 1, '2020-08-28 09:50:24'),
(24, 1, 24, 1598608224, 1, '2020-08-28 09:50:24'),
(25, 1, 25, 1598608237, 1, '2020-08-28 09:50:37'),
(26, 1, 26, 1598608237, 1, '2020-08-28 09:50:37'),
(27, 1, 27, 1598608247, 1, '2020-08-28 09:50:47'),
(28, 1, 28, 1598608247, 1, '2020-08-28 09:50:47'),
(29, 1, 29, 1598608367, 1, '2020-08-28 09:52:47'),
(30, 1, 30, 1598608367, 1, '2020-08-28 09:52:47'),
(31, 1, 31, 1598623331, 5, '2020-08-28 14:02:11'),
(32, 1, 32, 1598716352, 1, '2020-08-29 15:52:32'),
(33, 1, 33, 1598799042, 1, '2020-08-30 14:50:42'),
(34, 1, 34, 1599941865, 1, '2020-09-12 20:17:45'),
(35, 1, 35, 1600382141, 1, '2020-09-17 22:35:41'),
(36, 1, 36, 1600382159, 1, '2020-09-17 22:35:59'),
(37, 1, 37, 1600615979, 1, '2020-09-20 15:32:59'),
(38, 1, 38, 1600631322, 1, '2020-09-20 19:48:42'),
(39, 1, 39, 1600632343, 1, '2020-09-20 20:05:43'),
(40, 1, 40, 1600642035, 1, '2020-09-20 22:47:15'),
(41, 1, 41, 1600642138, 18, '2020-09-20 22:48:58'),
(42, 1, 42, 1600642438, 1, '2020-09-20 22:53:58'),
(43, 1, 43, 1600642707, 1, '2020-09-20 22:58:27'),
(44, 1, 44, 1600642727, 1, '2020-09-20 22:58:47'),
(45, 1, 45, 1600642888, 1, '2020-09-20 23:01:28'),
(46, 1, 46, 1600642911, 1, '2020-09-20 23:01:51'),
(47, 1, 47, 1600642961, 1, '2020-09-20 23:02:41'),
(48, 1, 48, 1600643007, 1, '2020-09-20 23:03:27'),
(49, 1, 49, 1600643347, 1, '2020-09-20 23:09:07'),
(50, 1, 50, 1600643524, 1, '2020-09-20 23:12:04'),
(51, 1, 51, 1600643610, 1, '2020-09-20 23:13:30'),
(52, 1, 52, 1600643999, 1, '2020-09-20 23:19:59'),
(53, 1, 53, 1600644112, 1, '2020-09-20 23:21:52'),
(54, 1, 54, 1600644127, 1, '2020-09-20 23:22:07'),
(55, 1, 55, 1600699549, 1, '2020-09-21 14:45:49'),
(56, 1, 56, 1600699770, 1, '2020-09-21 14:49:30'),
(57, 1, 57, 1600699848, 1, '2020-09-21 14:50:48'),
(58, 1, 58, 1600699868, 1, '2020-09-21 14:51:08'),
(59, 1, 59, 1600700046, 1, '2020-09-21 14:54:06'),
(60, 1, 60, 1600700159, 1, '2020-09-21 14:55:59'),
(61, 1, 61, 1600706521, 1, '2020-09-21 16:42:01'),
(62, 1, 62, 1600706650, 1, '2020-09-21 16:44:10'),
(63, 1, 63, 1600706725, 1, '2020-09-21 16:45:25'),
(64, 1, 64, 1600707054, 1, '2020-09-21 16:50:54'),
(65, 1, 65, 1600709214, 1, '2020-09-21 17:26:54'),
(66, 1, 66, 1600711864, 1, '2020-09-21 18:11:04'),
(67, 1, 67, 1602354162, 35, '2020-10-10 18:22:42');

-- --------------------------------------------------------

--
-- Table structure for table `postlikes`
--

CREATE TABLE `postlikes` (
  `id` int(11) NOT NULL,
  `active` int(1) NOT NULL DEFAULT 0,
  `post_id` int(11) NOT NULL DEFAULT 0,
  `reaction` varchar(8) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'like',
  `time` int(12) NOT NULL,
  `timeline_id` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `postlikes`
--

INSERT INTO `postlikes` (`id`, `active`, `post_id`, `reaction`, `time`, `timeline_id`, `timestamp`) VALUES
(1, 1, 1, 'love', 1598567372, 1, '2020-08-27 22:29:32'),
(55, 1, 36, 'idea', 1600641870, 1, '2020-09-20 22:44:30'),
(72, 1, 37, 'angry', 1600641904, 1, '2020-09-20 22:45:04'),
(75, 1, 35, 'haha', 1600641919, 1, '2020-09-20 22:45:19'),
(79, 1, 38, 'love', 1600642011, 1, '2020-09-20 22:46:51'),
(82, 1, 39, 'haha', 1600642031, 1, '2020-09-20 22:47:11'),
(93, 1, 40, 'angry', 1600642070, 1, '2020-09-20 22:47:50'),
(141, 1, 42, 'idea', 1600642700, 1, '2020-09-20 22:58:20'),
(142, 1, 43, 'curious', 1600642709, 1, '2020-09-20 22:58:29'),
(143, 1, 44, 'curious', 1600642729, 1, '2020-09-20 22:58:49'),
(147, 1, 45, 'clap', 1600642907, 1, '2020-09-20 23:01:47'),
(149, 1, 46, 'clap', 1600642917, 1, '2020-09-20 23:01:57'),
(150, 1, 47, 'idea', 1600642966, 1, '2020-09-20 23:02:46'),
(151, 1, 48, 'curious', 1600643013, 1, '2020-09-20 23:03:33'),
(171, 1, 49, 'idea', 1600643519, 1, '2020-09-20 23:11:59'),
(176, 1, 50, 'curious', 1600643532, 1, '2020-09-20 23:12:12'),
(191, 1, 41, 'curious', 1600643769, 18, '2020-09-20 23:16:09'),
(214, 1, 51, 'inapprop', 1600644077, 1, '2020-09-20 23:21:17'),
(219, 1, 52, 'wow', 1600644084, 1, '2020-09-20 23:21:24'),
(242, 1, 54, 'inapprop', 1600699200, 1, '2020-09-21 14:40:00'),
(243, 1, 53, 'inapprop', 1600699494, 1, '2020-09-21 14:44:54'),
(248, 1, 55, 'inapprop', 1600699577, 1, '2020-09-21 14:46:17'),
(249, 1, 56, 'inapprop', 1600699773, 1, '2020-09-21 14:49:33'),
(250, 1, 57, 'inapprop', 1600699850, 1, '2020-09-21 14:50:50'),
(276, 1, 58, 'inapprop', 1600699979, 1, '2020-09-21 14:52:59'),
(282, 1, 59, 'clap', 1600700142, 1, '2020-09-21 14:55:42'),
(301, 1, 60, 'like', 1600706517, 1, '2020-09-21 16:41:57'),
(326, 1, 61, 'like', 1600706551, 1, '2020-09-21 16:42:31'),
(337, 1, 62, 'curious', 1600706719, 1, '2020-09-21 16:45:19'),
(353, 1, 63, 'curious', 1600706861, 1, '2020-09-21 16:47:41'),
(367, 1, 64, 'bad', 1600708953, 1, '2020-09-21 17:22:33'),
(519, 1, 65, 'angry', 1600722818, 1, '2020-09-21 21:13:38'),
(525, 1, 67, 'like', 1602354192, 35, '2020-10-10 18:23:12'),
(528, 1, 67, 'wow', 1602954209, 37, '2020-10-17 17:03:29');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `active` int(1) NOT NULL DEFAULT 0,
  `activity_text` text COLLATE utf8_unicode_ci NOT NULL,
  `google_map_name` text COLLATE utf8_unicode_ci NOT NULL,
  `hidden` int(1) NOT NULL DEFAULT 0,
  `link_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `link_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `media_id` int(11) NOT NULL DEFAULT 0,
  `post_id` int(11) NOT NULL DEFAULT 0,
  `privacy` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'public',
  `recipient_id` int(11) NOT NULL DEFAULT 0,
  `shared` int(1) NOT NULL DEFAULT 0,
  `soundcloud_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `soundcloud_uri` text COLLATE utf8_unicode_ci NOT NULL,
  `text` text COLLATE utf8_unicode_ci NOT NULL,
  `time` int(12) NOT NULL,
  `timeline_id` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `youtube_video_id` text COLLATE utf8_unicode_ci NOT NULL,
  `youtube_title` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `active`, `activity_text`, `google_map_name`, `hidden`, `link_title`, `link_url`, `media_id`, `post_id`, `privacy`, `recipient_id`, `shared`, `soundcloud_title`, `soundcloud_uri`, `text`, `time`, `timeline_id`, `timestamp`, `youtube_video_id`, `youtube_title`) VALUES
(13, 1, '', '', 1, '', '', 10, 13, 'public', 0, 0, '', '', '', 1598607880, 1, '2020-08-28 09:44:40', '', ''),
(15, 1, '', '', 1, '', '', 12, 15, 'public', 0, 0, '', '', '', 1598608010, 1, '2020-08-28 09:46:50', '', ''),
(17, 1, '', '', 1, '', '', 14, 17, 'public', 0, 0, '', '', '', 1598608077, 1, '2020-08-28 09:47:57', '', ''),
(19, 1, '', '', 1, '', '', 16, 19, 'public', 0, 0, '', '', '', 1598608142, 1, '2020-08-28 09:49:02', '', ''),
(21, 1, '', '', 1, '', '', 17, 21, 'public', 0, 0, '', '', '', 1598608147, 1, '2020-08-28 09:49:07', '', ''),
(23, 1, '', '', 1, '', '', 19, 23, 'public', 0, 0, '', '', '', 1598608224, 1, '2020-08-28 09:50:24', '', ''),
(25, 1, '', '', 1, '', '', 21, 25, 'public', 0, 0, '', '', '', 1598608237, 1, '2020-08-28 09:50:37', '', ''),
(27, 1, '', '', 1, '', '', 22, 27, 'public', 0, 0, '', '', '', 1598608247, 1, '2020-08-28 09:50:47', '', ''),
(31, 1, '', '', 0, '', '', 0, 31, 'friends', 0, 0, '', '', 'nfnnfn', 1598623331, 5, '2020-08-28 14:02:11', '', ''),
(41, 1, '', '', 0, '', '', 0, 41, 'friends', 0, 0, '', '', 'strfgf', 1600642138, 18, '2020-09-20 22:48:58', '', ''),
(65, 1, '', '', 0, '', '', 0, 65, 'friends', 0, 0, '', '', 'frdgd', 1600709214, 1, '2020-09-21 17:26:54', '', ''),
(66, 1, '', '', 0, '', '', 0, 66, 'public', 0, 0, '', '', 'xccxv', 1600711864, 1, '2020-09-21 18:11:04', '', ''),
(67, 1, '', '', 0, '', '', 0, 67, 'public', 0, 0, '', '', 'vdsfgdgdggdgdgdgdgdgdg', 1602354162, 35, '2020-10-10 18:22:42', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `postshares`
--

CREATE TABLE `postshares` (
  `id` int(11) NOT NULL,
  `active` int(1) NOT NULL DEFAULT 0,
  `post_id` int(11) NOT NULL DEFAULT 0,
  `time` int(12) NOT NULL,
  `timeline_id` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `id` int(11) NOT NULL,
  `active` int(1) NOT NULL,
  `post_id` int(11) NOT NULL,
  `reporter_id` int(11) NOT NULL,
  `status` int(1) NOT NULL DEFAULT 0,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `type` enum('story','comment') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'story'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `story_music_uploads`
--

CREATE TABLE `story_music_uploads` (
  `id` int(255) NOT NULL,
  `story_id` int(255) NOT NULL,
  `url` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `story_video_uploads`
--

CREATE TABLE `story_video_uploads` (
  `id` int(255) NOT NULL,
  `story_id` int(255) NOT NULL,
  `url` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `birthday` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '1-1-1990',
  `comment_privacy` varchar(15) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'everyone',
  `confirm_followers` int(1) NOT NULL DEFAULT 0,
  `current_city` text COLLATE utf8_unicode_ci NOT NULL,
  `follow_privacy` varchar(15) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'everyone',
  `gender` varchar(6) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'male',
  `hometown` text COLLATE utf8_unicode_ci NOT NULL,
  `mailnotif_comment` tinyint(1) NOT NULL DEFAULT 1,
  `mailnotif_postlike` tinyint(1) NOT NULL DEFAULT 1,
  `mailnotif_postshare` tinyint(1) NOT NULL DEFAULT 1,
  `mailnotif_follow` tinyint(1) NOT NULL DEFAULT 1,
  `mailnotif_friendrequests` tinyint(1) NOT NULL DEFAULT 1,
  `mailnotif_groupjoined` tinyint(1) NOT NULL DEFAULT 1,
  `mailnotif_message` tinyint(1) NOT NULL DEFAULT 1,
  `mailnotif_pagelike` tinyint(1) NOT NULL DEFAULT 1,
  `mailnotif_timelinepost` tinyint(1) NOT NULL DEFAULT 1,
  `message_privacy` varchar(15) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'everyone',
  `post_privacy` varchar(15) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'everyone',
  `timeline_post_privacy` varchar(15) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'everyone'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `birthday`, `comment_privacy`, `confirm_followers`, `current_city`, `follow_privacy`, `gender`, `hometown`, `mailnotif_comment`, `mailnotif_postlike`, `mailnotif_postshare`, `mailnotif_follow`, `mailnotif_friendrequests`, `mailnotif_groupjoined`, `mailnotif_message`, `mailnotif_pagelike`, `mailnotif_timelinepost`, `message_privacy`, `post_privacy`, `timeline_post_privacy`) VALUES
(1, '1-1-1990', 'everyone', 1, '', 'everyone', 'male', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 'everyone', 'everyone', 'everyone'),
(2, '1-1-1990', 'everyone', 0, '', 'everyone', 'male', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 'everyone', 'everyone', 'everyone'),
(5, '1-1-1990', 'everyone', 0, '', 'everyone', 'male', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 'everyone', 'everyone', 'everyone'),
(7, '1-1-1990', 'everyone', 0, '', 'everyone', 'male', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 'everyone', 'everyone', 'everyone'),
(13, '1-1-1990', 'everyone', 0, '', 'everyone', 'male', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 'everyone', 'everyone', 'everyone'),
(14, '1-1-1990', 'everyone', 0, '', 'everyone', 'male', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 'everyone', 'everyone', 'everyone'),
(15, '1-1-1990', 'everyone', 0, '', 'everyone', 'male', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 'everyone', 'everyone', 'everyone'),
(16, '1-1-1990', 'everyone', 0, '', 'everyone', 'male', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 'everyone', 'everyone', 'everyone'),
(17, '1-1-1990', 'everyone', 0, '', 'everyone', 'male', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 'everyone', 'everyone', 'everyone'),
(18, '1-1-1990', 'everyone', 0, '', 'everyone', 'male', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 'everyone', 'everyone', 'everyone'),
(35, '1-1-1990', 'everyone', 0, '', 'everyone', 'male', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 'everyone', 'everyone', 'everyone'),
(36, '1-1-1990', 'everyone', 0, '', 'everyone', 'male', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 'everyone', 'everyone', 'everyone'),
(37, '1-1-1920', 'everyone', 0, '', 'everyone', 'male', '', 1, 1, 1, 1, 1, 1, 1, 1, 1, 'everyone', 'everyone', 'everyone');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `name` (`name`),
  ADD KEY `password` (`password`),
  ADD KEY `type` (`type`);

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `announcement_views`
--
ALTER TABLE `announcement_views`
  ADD PRIMARY KEY (`id`),
  ADD KEY `account_id` (`account_id`),
  ADD KEY `announcement_id` (`announcement_id`);

--
-- Indexes for table `commentlikes`
--
ALTER TABLE `commentlikes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_id` (`post_id`),
  ADD KEY `timeline_id` (`timeline_id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_id` (`post_id`),
  ADD KEY `timeline_id` (`timeline_id`);

--
-- Indexes for table `configurations`
--
ALTER TABLE `configurations`
  ADD KEY `admin_password_2` (`admin_password`,`admin_username`,`captcha`,`censored_words`,`chat`),
  ADD KEY `comment_character_limit_2` (`comment_character_limit`,`email`,`email_verification`,`friends`,`language`,`message_character_limit`),
  ADD KEY `reg_req_about_2` (`reg_req_about`,`reg_req_birthday`,`reg_req_currentcity`,`reg_req_hometown`,`site_name`,`site_title`,`smooth_links`,`story_character_limit`,`theme`);

--
-- Indexes for table `followers`
--
ALTER TABLE `followers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `follower_id` (`follower_id`),
  ADD KEY `following_id` (`following_id`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `group_privacy` (`group_privacy`);

--
-- Indexes for table `group_admins`
--
ALTER TABLE `group_admins`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admin_id` (`admin_id`),
  ADD KEY `group_id` (`group_id`);

--
-- Indexes for table `hashtags`
--
ALTER TABLE `hashtags`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `hash` (`hash`),
  ADD KEY `tag` (`tag`);

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `media`
--
ALTER TABLE `media`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `recipient_id` (`recipient_id`),
  ADD KEY `seen` (`seen`),
  ADD KEY `timeline_id` (`timeline_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `seen` (`seen`),
  ADD KEY `timeline_id` (`timeline_id`),
  ADD KEY `type` (`type`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `page_admins`
--
ALTER TABLE `page_admins`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admin_id` (`admin_id`),
  ADD KEY `page_id` (`page_id`);

--
-- Indexes for table `page_categories`
--
ALTER TABLE `page_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `plugins`
--
ALTER TABLE `plugins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `postfollows`
--
ALTER TABLE `postfollows`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_id` (`post_id`),
  ADD KEY `timeline_id` (`timeline_id`);

--
-- Indexes for table `postlikes`
--
ALTER TABLE `postlikes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_id` (`post_id`),
  ADD KEY `timeline_id` (`timeline_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `recipient_id` (`recipient_id`),
  ADD KEY `timeline_id` (`timeline_id`);

--
-- Indexes for table `postshares`
--
ALTER TABLE `postshares`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_id` (`post_id`),
  ADD KEY `timeline_id` (`timeline_id`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_id` (`post_id`),
  ADD KEY `reporter_id` (`reporter_id`),
  ADD KEY `type` (`type`);

--
-- Indexes for table `story_music_uploads`
--
ALTER TABLE `story_music_uploads`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `story_id` (`story_id`);

--
-- Indexes for table `story_video_uploads`
--
ALTER TABLE `story_video_uploads`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `story_id` (`story_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `announcement_views`
--
ALTER TABLE `announcement_views`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `commentlikes`
--
ALTER TABLE `commentlikes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `followers`
--
ALTER TABLE `followers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `group_admins`
--
ALTER TABLE `group_admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `hashtags`
--
ALTER TABLE `hashtags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5783;

--
-- AUTO_INCREMENT for table `media`
--
ALTER TABLE `media`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `page_admins`
--
ALTER TABLE `page_admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `page_categories`
--
ALTER TABLE `page_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=170;

--
-- AUTO_INCREMENT for table `plugins`
--
ALTER TABLE `plugins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `postfollows`
--
ALTER TABLE `postfollows`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `postlikes`
--
ALTER TABLE `postlikes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=529;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `postshares`
--
ALTER TABLE `postshares`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `story_music_uploads`
--
ALTER TABLE `story_music_uploads`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `story_video_uploads`
--
ALTER TABLE `story_video_uploads`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
