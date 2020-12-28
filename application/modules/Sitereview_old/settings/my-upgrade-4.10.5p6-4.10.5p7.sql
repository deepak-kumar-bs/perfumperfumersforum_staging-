ALTER TABLE `engine4_sitereview_listings`
 ADD `parent_type` VARCHAR(128) NULL DEFAULT NULL AFTER `body`,
 ADD `parent_id` INT NULL DEFAULT NULL AFTER `parent_type`;