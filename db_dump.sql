CREATE DATABASE IF NOT EXISTS `bpls`;
USE `bpls`;
CREATE TABLE IF NOT EXISTS `businesses` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `has_permit` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
);
INSERT INTO `businesses` ( `user_id`, `name`, `address`, `has_permit`) VALUES
	(3, 'Mekmek Store', 'Lico-an, Barotac Nuevo, Iloilo', 0);
CREATE TABLE IF NOT EXISTS `expiry` (
  `permit_id` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  PRIMARY KEY (`permit_id`)
);
CREATE TABLE IF NOT EXISTS `permit_requests` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `business_id` int(10) unsigned NOT NULL,
  `type` varchar(255) NOT NULL COMMENT 'New, Renewal',
  `date` date NOT NULL DEFAULT curdate(),
  `approved` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'True, False, Expired',
  `business_account_number` varchar(255) NOT NULL,
  `name_of_taxpayers` varchar(255) NOT NULL,
  `telephone_no` varchar(11) NOT NULL,
  `capital` varchar(255) NOT NULL COMMENT 'Ex: 1,000 PHP',
  `address` varchar(255) NOT NULL,
  `barangay_no` varchar(255) NOT NULL,
  `business_trade_name` varchar(255) NOT NULL,
  `business_telephone_no` varchar(255) NOT NULL,
  `fax_no` varchar(255) DEFAULT NULL,
  `commercial_address` varchar(255) NOT NULL,
  `street` varchar(255) DEFAULT NULL,
  `barangay` varchar(255) NOT NULL,
  `main_line_of_business` varchar(255) DEFAULT NULL,
  `main_products_and_services` varchar(255) DEFAULT NULL,
  `barangay_clearance` tinyint(1) unsigned NOT NULL DEFAULT 0 COMMENT 'True, False',
  `no_of_employees` int(10) unsigned NOT NULL DEFAULT 1,
  `public_liability_insurance` tinyint(1) unsigned NOT NULL DEFAULT 0 COMMENT 'True, False',
  `issuing_company` varchar(50) NOT NULL,
  `issuing_company_date` date NOT NULL,
  `dti_reg_no` varchar(255) DEFAULT NULL,
  `sec_reg_no` varchar(255) DEFAULT NULL,
  `proof_of_ownership` varchar(255) DEFAULT NULL,
  `owned` tinyint(1) unsigned NOT NULL DEFAULT 0 COMMENT 'True, False',
  `leased` tinyint(1) unsigned NOT NULL DEFAULT 0 COMMENT 'True, False',
  `ownership_type` varchar(50) NOT NULL COMMENT 'Single Propietorship, Partnership, Corporation',
  `registered_name` varchar(255) NOT NULL,
  `lessors_name` varchar(255) NOT NULL,
  `real_property_tax_receipt_no` varchar(255) NOT NULL,
  `rent_per_month` varchar(255) NOT NULL,
  `period_date` date NOT NULL,
  `area_in_sq_meter` varchar(255) NOT NULL,
  `name_of_applicant` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `business_id` (`business_id`)
);
INSERT INTO `permit_requests` ( `user_id`, `business_id`, `type`, `date`, `approved`, `business_account_number`, `name_of_taxpayers`, `telephone_no`, `capital`, `address`, `barangay_no`, `business_trade_name`, `business_telephone_no`, `fax_no`, `commercial_address`, `street`, `barangay`, `main_line_of_business`, `main_products_and_services`, `barangay_clearance`, `no_of_employees`, `public_liability_insurance`, `issuing_company`, `issuing_company_date`, `dti_reg_no`, `sec_reg_no`, `proof_of_ownership`, `owned`, `leased`, `ownership_type`, `registered_name`, `lessors_name`, `real_property_tax_receipt_no`, `rent_per_month`, `period_date`, `area_in_sq_meter`, `name_of_applicant`) VALUES
	(3, 1, 'Renewal', '2020-03-06', 0, 'BUS-NO-200', 'Taxpayer Name', '100', '2000 php', 'Iloilo', 'BRGY 203', 'Makoi Storey', '200', '', 'Barotac Nuevo', NULL, 'Lico-an', 'Sell Shit', 'Get Shit', 1, 2, 1, 'Maven', '2020-03-05', 'DTI-REG-053', 'SEC-REG-125', 'None at All', 0, 1, 'Sole Propietorship', 'Registered Namuu', 'Lessor\'s Namuu', 'RPTRN-205', '500 dolyars', '2020-03-05', '201 sq m', 'Elian Braga');
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `access_level` tinyint(3) unsigned NOT NULL DEFAULT 1 COMMENT '1 = Applicant, 2 = Admin',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
);
INSERT INTO `users` ( `username`, `password`, `access_level`) VALUES
	('admin', '$2y$10$pv5.fmzFOTpPLyT/1eVIC.91RJxI28IRs4IZ/zuIE70iA4Sf2mz/e', 2),
	('mekkyinblack', '$2y$10$1HgvdW9Nmn9dibIcS6qQbeG5OH2FQUIvArbyEdNOp057j6GB6MDri', 2),
	('elian', '$2y$10$tdLZ.Q2/8EyBl2EVIhRXxuR8jFt9V4Xnvggs4hsUMPuKcNhPQ9r3u', 1);
CREATE TABLE IF NOT EXISTS `user_details` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `contact_number` char(11) NOT NULL,
  `address` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
);
INSERT INTO `user_details` (`user_id`, `first_name`, `last_name`, `contact_number`, `address`, `email`) VALUES
	( 3, 'Elian', 'Braga', '09309488605', 'Lico-an, Barotac Nuevo, Iloilo', 'manlupigelian@gmail.com');