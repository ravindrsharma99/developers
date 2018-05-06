# Oct 30, 2017
# Create table app_user_tokens
CREATE TABLE `app_user_tokens` (
  `id` int(11) NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `device` varchar(50) COLLATE utf8_unicode_ci DEFAULT '',
  `device_token` varchar(256) COLLATE utf8_unicode_ci DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


ALTER TABLE `app_user_tokens`  ADD PRIMARY KEY (`id`);

ALTER TABLE `app_user_tokens`  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

# Add colum fullname in app_users
ALTER TABLE `app_users` ADD `fullname` VARCHAR(255) NULL DEFAULT '' AFTER `deleted_at`; 
ALTER TABLE `app_users` ADD `alias` VARCHAR(255) NULL DEFAULT '' AFTER `fullname`; 
# allow app_user image null
ALTER TABLE `app_users` CHANGE `image` `image` VARCHAR(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT ''; 
# make phone number to 20 characters
ALTER TABLE `app_users` CHANGE `phone` `phone` VARCHAR(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT ''; 

# add social field
ALTER TABLE `app_users` ADD `google_id` VARCHAR(255) NULL DEFAULT '' AFTER `alias`; 
ALTER TABLE `app_users` ADD `facebook_id` VARCHAR(255) NULL DEFAULT '' AFTER `google_id`; 

ALTER TABLE `app_users` CHANGE `firstname` `firstname` VARCHAR(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT ''; 
ALTER TABLE `app_users` CHANGE `lastname` `lastname` VARCHAR(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT ''; 
ALTER TABLE `app_users` CHANGE `password` `password` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT ''; 

# Create table app comment 
CREATE TABLE `app_comments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `app_id` int(11) NOT NULL,
  `comment` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `rating` int(11) NOT NULL DEFAULT '0',
  `created_at` date NOT NULL,
  `updated_at` date NOT NULL,
  `deleted_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

ALTER TABLE `app_comments`  ADD PRIMARY KEY (`id`);

ALTER TABLE `app_comments`  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

# add statistic fields to app table
ALTER TABLE `new_apps` ADD `total_comment` INT(11) NOT NULL DEFAULT '0' AFTER `deleted_at`, ADD `total_download` INT(11) NOT NULL DEFAULT '0' AFTER `total_comment`, ADD `average_rating` INT(11) NOT NULL DEFAULT '0' AFTER `total_download`; 

ALTER TABLE `new_apps` CHANGE `average_rating` `average_rating` FLOAT(10,2) NOT NULL DEFAULT '0'; 

ALTER TABLE `app_users` ADD `cover` VARCHAR(255) NULL DEFAULT '' AFTER `facebook_id`; 


# create table app_downloads
CREATE TABLE `app_downloads` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `app_id` int(11) NOT NULL,
  `price` float(11,2) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

ALTER TABLE `app_downloads`  ADD PRIMARY KEY (`id`);

ALTER TABLE `app_downloads`  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

# add column total_view
ALTER TABLE `new_apps` ADD `total_view` INT(11) NOT NULL DEFAULT '0' AFTER `average_rating`; 

# create table app viewer
CREATE TABLE `app_viewers` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `app_id` int(11) NOT NULL,
  `created_at` date NOT NULL,
  `updated_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
ALTER TABLE `app_viewers`  ADD PRIMARY KEY (`id`);

ALTER TABLE `app_viewers`  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

# add column show_on_home_app, if this = 1 then it will show block with app belong to this category
ALTER TABLE `categories` ADD `show_on_home_app` TINYINT(1) NOT NULL DEFAULT '0' AFTER `deleted_at`; 

# Oct 31, 2017
# fix bug forum when user was deleted
# file: vendor/devdojo/chatter/src/Views/home.blade.php line: 80

# Nov 12, 2017
# create table bt_customers
CREATE TABLE `bt_customers` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `customer_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
ALTER TABLE `bt_customers`  ADD PRIMARY KEY (`id`);
ALTER TABLE `bt_customers`  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

# create table bt_payment_methods
CREATE TABLE `bt_payment_methods` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `bt_customer_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_card_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_method_token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

ALTER TABLE `bt_payment_methods`  ADD PRIMARY KEY (`id`);

ALTER TABLE `bt_payment_methods`  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

# Nov 14, 2017
ALTER TABLE `new_apps` ADD `version_code` INT(11) NOT NULL DEFAULT '1' AFTER `total_view`; 
ALTER TABLE `new_apps` ADD `package_id` VARCHAR(255) NULL DEFAULT '' AFTER `version_code`; 

# Nov 14, 2017
# create table payments
CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `app_id` int(11) NOT NULL,
  `order_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'buy_app',
  `amount` double(11,2) NOT NULL DEFAULT '0.00',
  `user_id` int(11) NOT NULL,
  `owner_id` int(11) NOT NULL,
  `status` enum('pending','failed','success') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `transaction_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `error` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `data` mediumtext COLLATE utf8mb4_unicode_ci,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

ALTER TABLE `payments`  ADD PRIMARY KEY (`id`);

ALTER TABLE `payments`  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

# create table settings
CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `setting_key` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `setting_value` mediumtext COLLATE utf8_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `group_key` varchar(50) COLLATE utf8_unicode_ci DEFAULT '',
  `setting_type` varchar(50) COLLATE utf8_unicode_ci DEFAULT 'text',
  `is_active` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE `settings`  ADD PRIMARY KEY (`id`);
ALTER TABLE `settings`  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

# create table setting groups
CREATE TABLE `setting_groups` (
  `id` int(11) NOT NULL,
  `title` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `group_key` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `color` varchar(50) COLLATE utf8_unicode_ci DEFAULT 'purple'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE `setting_groups`  ADD PRIMARY KEY (`id`);
ALTER TABLE `setting_groups`  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

# create table settiong options
CREATE TABLE `setting_options` (
  `id` int(11) NOT NULL,
  `setting_key` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `option_title` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `option_value` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE `setting_options`  ADD PRIMARY KEY (`id`);
ALTER TABLE `setting_options`  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

# add new columns to payments
ALTER TABLE `payments` ADD `commision_rate` INT(3) NOT NULL DEFAULT '0' AFTER `created_at`, ADD `developer_amount` DOUBLE(11,2) NOT NULL DEFAULT '0' AFTER `commision_rate`, ADD `admin_amount` DOUBLE(11,2) NOT NULL DEFAULT '0' AFTER `developer_amount`; 

# add new columns to web_users
ALTER TABLE `web_users` ADD `balance` DOUBLE(11,2) NOT NULL DEFAULT '0' AFTER `deleted_at`; 
ALTER TABLE `web_users` ADD `withdrawal_pending` DOUBLE(11,2) NOT NULL DEFAULT '0' AFTER `balance`; 

# add new setting 
INSERT INTO `settings` (`id`, `title`, `setting_key`, `setting_value`, `created_at`, `updated_at`, `group_key`, `setting_type`, `is_active`) VALUES (NULL, 'Minimum Withdrawal Amount', 'minimum_withdrawal_amount', '100', CURRENT_TIMESTAMP, '2017-11-16 00:00:00', 'payment_group', 'text', '1');

# add new column to web_users
ALTER TABLE `web_users` ADD `paypal_email` VARCHAR(255) NULL DEFAULT '' AFTER `withdrawal_pending`; 

ALTER TABLE `web_users` ADD `total_earned` DOUBLE(11,2) NOT NULL DEFAULT '0' AFTER `paypal_email`; 
ALTER TABLE `web_users` ADD `total_withdrawal` DOUBLE(11,2) NOT NULL DEFAULT '0' AFTER `total_earned`; 

# change log update user total_earned
UPDATE `web_users` SET `total_earned` = `withdrawal_pending` + `balance`

# Create table withdraw_requests
CREATE TABLE `withdraw_requests` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `amount` double(11,2) NOT NULL,
  `status` enum('pending','success','failed','processing') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `failure_reason` mediumtext COLLATE utf8mb4_unicode_ci,
  `process_date` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `paypal_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

ALTER TABLE `withdraw_requests`  ADD PRIMARY KEY (`id`);

ALTER TABLE `withdraw_requests`  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

# add field to app_download
ALTER TABLE `app_downloads` ADD `developer_amount` DOUBLE(11,2) NOT NULL DEFAULT '0' AFTER `updated_at`, ADD `admin_amount` DOUBLE(11,2) NOT NULL DEFAULT '0' AFTER `developer_amount`; 

# update app download amount
UPDATE `app_downloads` SET `developer_amount` = 0.6 * `price`, `admin_amount` = 0.4 * `price` where `price` > 0 

ALTER TABLE `app_downloads` ADD `commision_rate` INT(10) NOT NULL DEFAULT '60' AFTER `admin_amount`; 

# Nov 17, 2017 add braintree sandbox config
# create braintree configuration group
INSERT INTO `setting_groups` (`id`, `title`, `group_key`, `created_at`, `updated_at`, `color`) VALUES (NULL, 'Paypal Braintree Configuration', 'braintree_configuration', '2017-11-17 00:00:00', '2017-11-17 00:00:00', 'purple');

# add column setting description
ALTER TABLE `settings` ADD `description` MEDIUMTEXT NULL DEFAULT '' AFTER `is_active`; 

# add braintree configure
INSERT INTO `settings` (`id`, `title`, `setting_key`, `setting_value`, `created_at`, `updated_at`, `group_key`, `setting_type`, `is_active`, `description`) VALUES
(NULL, 'Braintree sandbox MerchantId', 'braintree_sandbox_merchantid', '5r5fzqcnzgmzt729', '2017-11-17 03:43:24', '2017-11-16 17:00:00', 'braintree_configuration', 'text', 1, 'Get a new sendbox merchantId <a href=\"https://sandbox.braintreegateway.com/login\">https://sandbox.braintreegateway.com/login</a>'),
(NULL, 'Braintree sandbox Public Key', 'braintree_sandbox_public_key', 'vngjbmbmbccr5zs9', '2017-11-17 03:01:45', '2017-11-16 17:00:00', 'braintree_configuration', 'text', 1, NULL),
(NULL, 'Braintree sandbox Private Key', 'braintree_sandbox_private_key', '4d17d4be2d4a62008eae305f2b94cb31', '2017-11-17 03:01:43', '2017-11-16 17:00:00', 'braintree_configuration', 'text', 1, NULL),
(NULL, 'Braintree Environment', 'braintree_environment', 'sandbox', '2017-11-17 03:47:41', '2017-11-16 17:00:00', 'braintree_configuration', 'select', 1, 'Change to Live mode when you ready for sale and you have live marchant ID'),
(NULL, 'Braintree Live MerchantID', 'braintree_live_merchantid', NULL, '2017-11-17 03:46:01', '2017-11-16 17:00:00', 'braintree_configuration', 'text', 1, 'Get a new Live merchantId <a href=\"https://apply.braintreegateway.com/signup/us\">https://apply.braintreegateway.com/signup/us</a>'),
(NULL, 'Braintree Live Public Key', 'braintree_live_public_key', NULL, '2017-11-17 03:07:13', '2017-11-16 17:00:00', 'braintree_configuration', 'text', 1, NULL),
(NULL, 'Braintree Live Private Key', 'braintree_live_private_key', NULL, '2017-11-17 03:07:53', '2017-11-16 17:00:00', 'braintree_configuration', 'text', 1, NULL);


INSERT INTO `setting_options` (`id`, `setting_key`, `option_title`, `option_value`, `created_at`, `updated_at`) VALUES
(NULL, 'braintree_environment', 'Sandbox', 'sandbox', '2017-11-17 00:00:00', '2017-11-17 00:00:00'),
(NULL, 'braintree_environment', 'Live', 'live', '2017-11-17 00:00:00', '2017-11-17 00:00:00');

# add stripe config
INSERT INTO `setting_groups` (`id`, `title`, `group_key`, `created_at`, `updated_at`, `color`) VALUES
(NULL, 'Stripe Configuration', 'stripe_configuration', '2017-11-20 00:00:00', '2017-11-20 00:00:00', 'purple');

INSERT INTO `settings` (`id`, `title`, `setting_key`, `setting_value`, `created_at`, `updated_at`, `group_key`, `setting_type`, `is_active`, `description`) VALUES (NULL, 'Stripe Client ID', 'stripe_client_id', 'ca_BniZLOlOyy8P9FLUwakgmriqmuqdtCJh', CURRENT_TIMESTAMP, '2017-11-20 00:00:00', 'stripe_configuration', 'text', '1', NULL), (NULL, 'Stripe Client Secret', 'stripe_client_secret', 'sk_test_hXXShFEJaquqLDFkTIFZTahn', CURRENT_TIMESTAMP, '0000-00-00 00:00:00.000000', 'stripe_configuration', 'text', '1', NULL);

# Nov 23, 2017
# add bt_payment_methods user information fields
ALTER TABLE `bt_payment_methods` ADD `name` VARCHAR(255) NULL DEFAULT '' AFTER `created_at`, ADD `country_code` VARCHAR(255) NULL DEFAULT '' AFTER `name`, ADD `postal_code` VARCHAR(255) NULL DEFAULT '' AFTER `country_code`, ADD `phone` VARCHAR(255) NULL AFTER `postal_code`; 

# Dec 16, 2017
ALTER TABLE `new_apps` ADD `is_update` TINYINT(1) NOT NULL DEFAULT '0' AFTER `package_id`, ADD `parent_id` INT(11) NOT NULL DEFAULT '0' AFTER `is_update`, ADD `update_status` ENUM('draft','success') NOT NULL AFTER `parent_id`; 