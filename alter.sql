ALTER TABLE `patients`  ADD `gender` ENUM('Mr','Mrs') NULL DEFAULT 'Mr'  AFTER `id`;
ALTER TABLE `patients`  ADD `nationality` VARCHAR(255) NULL  AFTER `phone`,  ADD `iqama_id` VARCHAR(255) NULL  AFTER `nationality`,  ADD `medical_conditions` TEXT NULL  AFTER`iqama_id`;
ALTER TABLE `patients` CHANGE `email` `email` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL;
CREATE TABLE `medicalconditions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `en_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ar_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `medicalconditions`
--

INSERT INTO `medicalconditions` (`id`, `code`, `en_name`, `ar_name`, `created_at`, `updated_at`) VALUES
(1, 'DIABETS', 'Diabets', 'مرض السكر', '2021-06-11 19:09:46', '2021-06-11 19:09:46'),
(2, 'JAUNDICE', 'Jaundice', 'الصفراء', '2021-06-11 19:09:46', '2021-06-11 19:09:46'),
(3, 'HEPATITES', 'Hepatites', 'التهاب الكبد الوبائي', '2021-06-11 19:09:46', '2021-06-11 19:09:46');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `medicalconditions`
--
ALTER TABLE `medicalconditions`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `medicalconditions`
--
ALTER TABLE `medicalconditions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;