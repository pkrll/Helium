-- SQL DUMP
-- Server version: 5.6.22
-- PHP Version: 5.5.24

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
`id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `permissionLevel` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `Roles`
--

CREATE TABLE IF NOT EXISTS `Roles` (
  `id` int(1) NOT NULL,
  `name` varchar(20) NOT NULL,
  `description` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
`id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) DEFAULT NULL,
  `permissionLevel` int(1) NOT NULL
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
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Roles`
--
ALTER TABLE `Roles`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Articles`
--
ALTER TABLE `Articles`
MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT;
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
-- AUTO_INCREMENT for table `Resources`
--
ALTER TABLE `Resources`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
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
