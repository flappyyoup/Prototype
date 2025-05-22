-- Create sangla_items table
CREATE TABLE `sangla_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `item_name` varchar(255) NOT NULL,
  `item_type` varchar(50) NOT NULL,
  `brand` varchar(100) NOT NULL,
  `karat` varchar(10) NOT NULL,
  `grams` decimal(10,2) NOT NULL,
  `estimated_value` decimal(10,2) NOT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `branch` varchar(50) NOT NULL,
  `status` enum('active','redeemed','forfeited') NOT NULL DEFAULT 'active',
  `pawn_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `redemption_date` date DEFAULT NULL,
  `interest_rate` decimal(5,2) NOT NULL DEFAULT 3.00,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `sangla_items_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci; 