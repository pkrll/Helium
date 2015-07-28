-- SQL DUMP
-- Server version: 5.6.22
-- PHP Version: 5.5.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `Helium`
--

-- --------------------------------------------------------

--
-- Table structure for table `Articles`
--

CREATE TABLE IF NOT EXISTS `Articles` (
`id` int(11) unsigned NOT NULL,
  `author_id` int(11) NOT NULL,
  `category` int(11) NOT NULL,
  `headline` varchar(500) CHARACTER SET utf8 COLLATE utf8_swedish_ci NOT NULL,
  `preamble` text CHARACTER SET utf8 COLLATE utf8_swedish_ci NOT NULL,
  `body` text CHARACTER SET utf8 COLLATE utf8_swedish_ci NOT NULL,
  `fact` text CHARACTER SET utf8 COLLATE utf8_swedish_ci,
  `tags` varchar(500) DEFAULT NULL,
  `theme` int(11) DEFAULT NULL,
  `created` int(11) NOT NULL,
  `published` int(11) DEFAULT NULL,
  `last_edit` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Articles_Categories`
--

CREATE TABLE IF NOT EXISTS `Articles_Categories` (
`id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Articles_Images`
--

CREATE TABLE IF NOT EXISTS `Articles_Images` (
`id` int(11) NOT NULL,
  `image_name` varchar(300) NOT NULL,
  `type` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Articles_Metadata_Images`
--

CREATE TABLE IF NOT EXISTS `Articles_Metadata_Images` (
  `image_id` int(11) NOT NULL,
  `article_id` int(11) unsigned NOT NULL,
  `caption` varchar(255) DEFAULT NULL,
  `type` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Articles_Metadata_Links`
--

CREATE TABLE IF NOT EXISTS `Articles_Metadata_Links` (
  `article_id` int(11) unsigned NOT NULL,
  `linked_article_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Resources`
--

CREATE TABLE IF NOT EXISTS `Resources` (
  `name` varchar(30) NOT NULL,
  `permissionLevel` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Resources`
--

INSERT INTO `Resources` (`name`, `permissionLevel`) VALUES
('Admin:main', 1),
('Articles:archive', 1),
('Articles:create', 1),
('Articles:edit', 1),
('Articles:main', 0),
('Articles:remove', 2),
('Gallery:browse', 1),
('Gallery:main', 1),
('Gallery:upload', 1),
('Settings:main', 3),
('Upload:image', 1),
('Upload:main', 1),
('Upload:remove', 2),
('User:add', 3),
('User:admin', 1),
('User:edit', 3),
('User:main', 0),
('User:permissions', 4),
('User:rights', 4);

-- --------------------------------------------------------

--
-- Table structure for table `Roles`
--

CREATE TABLE IF NOT EXISTS `Roles` (
  `id` int(1) NOT NULL,
  `name` varchar(20) NOT NULL,
  `description` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Roles`
--

INSERT INTO `Roles` (`id`, `name`, `description`) VALUES
(1, 'Writer', 'Can write and edit own posts.'),
(2, 'Editor', 'Can write and edit own and other posts, also edit front page.'),
(3, 'Supereditor', 'Same permissions as editor, but can also manage and add users up to level Editor.'),
(4, 'Owner', 'Has access to everything.');

-- --------------------------------------------------------

--
-- Table structure for table `Users`
--

CREATE TABLE IF NOT EXISTS `Users` (
`id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) DEFAULT NULL,
  `permission` int(1) NOT NULL,
  `image_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Users_Images`
--

CREATE TABLE IF NOT EXISTS `Users_Images` (
`id` int(11) NOT NULL,
  `image_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Articles`
--
ALTER TABLE `Articles`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Articles_Categories`
--
ALTER TABLE `Articles_Categories`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Articles_Images`
--
ALTER TABLE `Articles_Images`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Articles_Metadata_Images`
--
ALTER TABLE `Articles_Metadata_Images`
 ADD PRIMARY KEY (`image_id`,`article_id`), ADD KEY `fk_images_article_id` (`article_id`);

--
-- Indexes for table `Articles_Metadata_Links`
--
ALTER TABLE `Articles_Metadata_Links`
 ADD PRIMARY KEY (`article_id`,`linked_article_id`);

--
-- Indexes for table `Resources`
--
ALTER TABLE `Resources`
 ADD PRIMARY KEY (`name`);

--
-- Indexes for table `Roles`
--
ALTER TABLE `Roles`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Users`
--
ALTER TABLE `Users`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Users_Images`
--
ALTER TABLE `Users_Images`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Articles`
--
ALTER TABLE `Articles`
MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `Articles_Categories`
--
ALTER TABLE `Articles_Categories`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `Articles_Images`
--
ALTER TABLE `Articles_Images`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `Users`
--
ALTER TABLE `Users`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `Users_Images`
--
ALTER TABLE `Users_Images`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `Articles_Metadata_Images`
--
ALTER TABLE `Articles_Metadata_Images`
ADD CONSTRAINT `fk_images_article_id` FOREIGN KEY (`article_id`) REFERENCES `Articles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `Articles_Metadata_Links`
--
ALTER TABLE `Articles_Metadata_Links`
ADD CONSTRAINT `fk_links_article_id` FOREIGN KEY (`article_id`) REFERENCES `Articles` (`id`) ON DELETE CASCADE;
