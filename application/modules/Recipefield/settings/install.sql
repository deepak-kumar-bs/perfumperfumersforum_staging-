INSERT IGNORE INTO `engine4_core_modules` (`name`, `title`, `description`, `version`, `enabled`, `type`) VALUES  ('recipefield', 'Recipefield', 'new recipe field element will get added.', '4.10.4', 1, 'extra');

ALTER TABLE `engine4_sitereview_listingtypes` ADD `listingtype_category` TINYINT(1) NOT NULL DEFAULT '0' AFTER `show_application`;

--
-- Table structure for table `engine4_sitereview_recipeinfo`
--

CREATE TABLE `engine4_sitereview_recipeinfo` (
  `recipeinfo_id` int(11) NOT NULL,
  `listing_id_recipe` int(11) NOT NULL,
  `listing_id_ingredient` int(11) NOT NULL,
  `amount` float NOT NULL,
  `dilution` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `engine4_sitereview_recipeinfo`
--
ALTER TABLE `engine4_sitereview_recipeinfo`
  ADD PRIMARY KEY (`recipeinfo_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `engine4_sitereview_recipeinfo`
--
ALTER TABLE `engine4_sitereview_recipeinfo`
  MODIFY `recipeinfo_id` int(11) NOT NULL AUTO_INCREMENT;