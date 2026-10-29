ALTER TABLE `pages` ADD `header_component` TEXT NULL AFTER `seo_index`, ADD `header_component_position` VARCHAR(255) NULL AFTER `header_component`, ADD `footer_component` TEXT NULL AFTER `header_component_position`;
ALTER TABLE `visitor_logs` ADD `device` VARCHAR(255) NULL AFTER `updated_at`;
ALTER TABLE `visitor_logs` ADD `platform` VARCHAR(255) NULL AFTER `device`;


CREATE TABLE `widgets` (
    `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `link` VARCHAR(255) NOT NULL,
    `type` VARCHAR(255) NOT NULL,
    `ref_id` BIGINT UNSIGNED NOT NULL,
    `parent_id` BIGINT UNSIGNED DEFAULT NULL,
    `position` INT NOT NULL,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL
);
