-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 17, 2025 at 06:03 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `momai_event_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_users`
--

CREATE TABLE `admin_users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_users`
--

INSERT INTO `admin_users` (`id`, `username`, `password`, `email`, `created_at`) VALUES
(2, 'kamal', '$2y$10$twYuCZ5SzlVjd2lSFmhiBOY4gv/slOTX2t60cka7K6NDH2tq.oEVO', 'kamal@momaievent.com', '2025-08-07 18:27:05'),
(3, 'dip', '$2y$10$gLTlrthtK0h2/FlHBAnXlOcfVDVIHoYbqpkoFdFzCklvR1h1AM0wq', 'dip@momaievent.com', '2025-08-07 19:53:04');

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `event_type` varchar(100) NOT NULL,
  `event_date` date NOT NULL,
  `event_time` time DEFAULT NULL,
  `venue` varchar(200) DEFAULT NULL,
  `guest_count` int(11) NOT NULL,
  `budget` decimal(10,2) DEFAULT NULL,
  `services_required` text DEFAULT NULL,
  `special_requirements` text DEFAULT NULL,
  `status` enum('pending','confirmed','in_progress','completed','cancelled') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `user_id`, `event_type`, `event_date`, `event_time`, `venue`, `guest_count`, `budget`, `services_required`, `special_requirements`, `status`, `created_at`) VALUES
(1, 1, 'Decoration with Catering Planning', '2025-08-28', '09:23:00', 'patelnger1', 50, 10000.00, 'Decoration, Catering, Coordination', 'no', 'cancelled', '2025-08-04 12:51:47'),
(2, 4, 'Destination Wedding Decorations', '2025-09-23', '01:33:00', 'uyfytfuvjh', 50, 10000.00, 'Decoration, Catering, Photography', '', 'completed', '2025-09-20 05:00:08'),
(3, 4, 'Birthday Party', '2025-10-14', '02:35:00', 'patelnger1', 522, 50000.00, 'Entertainment', 'aaaa', 'completed', '2025-10-05 05:02:09'),
(4, 15, 'Decoration with Catering Planning', '2025-11-28', '00:12:00', 'uyfytfuvjh', 10000, 50000.00, 'Decoration, Photography, Entertainment, Coordination', '4444', 'completed', '2025-11-16 04:42:05');

-- --------------------------------------------------------

--
-- Table structure for table `decorations`
--

CREATE TABLE `decorations` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `image_path` varchar(255) NOT NULL,
  `category` varchar(100) NOT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `decorations`
--

INSERT INTO `decorations` (`id`, `title`, `description`, `image_path`, `category`, `is_active`, `created_at`) VALUES
(1, 'Elegant Wedding Arch', 'Beautiful floral wedding arch decoration', 'assets/decorations/wedding_arch.jpg', 'Baby Shower', 1, '2025-08-07 18:53:09'),
(2, 'Birthday Balloon Setup', 'Colorful balloon arrangement for birthdays', 'assets/decorations/birthday_balloons.jpg', 'Birthday', 1, '2025-08-07 18:53:09'),
(3, 'Corporate Event Backdrop', 'Professional backdrop for corporate events', 'assets/decorations/corporate_backdrop.jpg', 'Corporate', 1, '2025-08-07 18:53:09'),
(4, 'Baby Shower Decor', 'Cute baby shower decoration setup', 'assets/decorations/baby_shower.jpg', 'Baby Shower', 1, '2025-08-07 18:53:09'),
(5, 'Anniversary Celebration', 'Romantic anniversary decoration', 'assets/decorations/anniversary.jpg', 'Anniversary', 1, '2025-08-07 18:53:09'),
(6, 'Garden Party Setup', 'Beautiful outdoor garden party decoration', 'assets/decorations/garden_party.jpg', 'Other', 1, '2025-08-07 18:53:09'),
(7, 'test', 'new demo', 'assets/decorations/68dfa0bee38fa.jpg', 'Other', 1, '2025-10-03 10:09:02');

-- --------------------------------------------------------

--
-- Table structure for table `decoration_images`
--

CREATE TABLE `decoration_images` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `image_url` varchar(255) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `event_categories`
--

CREATE TABLE `event_categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `event_categories`
--

INSERT INTO `event_categories` (`id`, `name`, `description`, `image_url`, `is_active`, `created_at`) VALUES
(1, 'Destination Wedding Decorations', 'Beautiful wedding decorations for destination weddings', NULL, 1, '2025-08-04 12:12:44'),
(2, 'Decoration with Catering Planning', 'Complete event planning with decoration and catering', NULL, 1, '2025-08-04 12:12:44'),
(3, 'Pick and Drop', 'Transportation services for events', NULL, 1, '2025-08-04 12:12:44'),
(4, 'Birthday Party', 'Birthday celebration decorations and planning', NULL, 1, '2025-08-04 12:12:44'),
(5, 'Baby Shower', 'Baby shower decorations and arrangements', NULL, 1, '2025-08-04 12:12:44'),
(6, 'Event Timeline', 'Professional event timeline planning', NULL, 1, '2025-08-04 12:12:44'),
(7, 'Baby name', 'Your Baby name event planning', NULL, 1, '2025-08-07 18:59:49'),
(8, 'name of the catgegory', 'this is the random category for the other events we can manage on our side surprises no one know about the event what is going on', NULL, 1, '2025-08-31 07:06:47');

-- --------------------------------------------------------

--
-- Table structure for table `gallery`
--

CREATE TABLE `gallery` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `image_url` varchar(255) NOT NULL,
  `category` varchar(50) DEFAULT NULL,
  `is_featured` tinyint(1) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `image_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gallery`
--

INSERT INTO `gallery` (`id`, `title`, `description`, `image_url`, `category`, `is_featured`, `is_active`, `created_at`, `image_path`) VALUES
(14, 'Elegant Wedding Setup', 'Beautiful wedding decoration with white and gold theme featuring elegant floral arrangements, romantic lighting, and luxurious table settings', '', 'Wedding', 1, 1, '2025-08-18 11:01:49', 'assets/gallery/Elegant Wedding Setup.jpg'),
(15, 'Colorful Birthday Party', 'Fun and vibrant birthday party with rainbow theme, colorful balloons, and festive decorations', '', 'Birthday', 1, 1, '2025-08-18 11:01:49', 'assets/gallery/Colorful Birthday Party.jpg'),
(16, 'Corporate Event Hall', 'Professional corporate event setup with modern staging, professional lighting, and business branding', '', 'Corporate', 0, 1, '2025-08-18 11:01:49', 'https://images.unsplash.com/photo-1511578314322-379afb476865?w=500'),
(17, 'Baby Shower Celebration', 'Cute baby shower with pink and blue decorations, adorable themed elements, and sweet treats', '', 'Baby Shower', 1, 1, '2025-08-18 11:01:49', 'assets/gallery/Baby_Shower.jpg'),
(18, 'Anniversary Dinner', 'Romantic anniversary celebration setup with candlelit ambiance, rose petals, and intimate dining', '', 'Anniversary', 0, 1, '2025-08-18 11:01:49', 'https://images.unsplash.com/photo-1464366400600-7168b8af9bc3?w=500'),
(19, 'Garden Wedding', 'Outdoor garden wedding decoration with natural beauty, floral arches, and scenic backdrops', '', 'Wedding', 1, 1, '2025-08-18 11:01:49', 'https://images.unsplash.com/photo-1606216794074-735e91aa2c92?w=500'),
(20, 'Luxury Reception', 'Premium luxury wedding reception with crystal chandeliers, gold accents, and premium linens', '', 'Wedding', 1, 1, '2025-08-18 11:01:49', 'assets/gallery/Luxury_Reception.jpg'),
(21, 'Kids Birthday Theme', 'Themed children birthday party with cartoon characters, colorful decorations, and fun activities', '', 'Birthday', 0, 1, '2025-08-18 11:01:49', 'assets/gallery/baby_party.jpg'),
(22, 'Business Conference', 'Professional business conference setup with modern AV equipment and corporate branding', '', 'Corporate', 0, 1, '2025-08-18 11:01:49', 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?w=500'),
(23, 'Outdoor Baby Shower', 'Beautiful outdoor baby shower with pastel colors, garden setting, and elegant decorations', '', 'Baby Shower', 0, 1, '2025-08-18 11:01:49', 'assets/gallery/Outdoor_Baby_Shower.jpg'),
(25, 'Elegant Event Setup', 'Beautiful event decoration with sophisticated styling and attention to detail.', '', 'event', 0, 1, '2025-10-01 18:55:54', 'assets/gallery/Elegant Event Setup.jpg'),
(26, 'Celebration Styling', 'Memorable celebration decoration with vibrant colors and festive elements.', '', 'celebration', 0, 1, '2025-10-01 18:55:54', 'assets/gallery/Screenshot_2025-05-17-23-12-18-98_1c337646f29875672b5a61192b9010f9.jpg'),
(27, 'Party Decoration', 'Fun and elegant party setup with creative themes and stylish arrangements.', '', 'party', 0, 1, '2025-10-01 18:55:54', 'assets/gallery/Screenshot_2025-06-24-18-44-23-46_1c337646f29875672b5a61192b9010f9.jpg'),
(28, 'Special Occasion', 'Unique and personalized decoration for your most special moments.', '', 'special', 0, 1, '2025-10-01 18:55:54', 'assets/gallery/Screenshot_2025-06-24-18-46-28-90_1c337646f29875672b5a61192b9010f9.jpg'),
(29, 'Luxury Experience', 'Premium luxury event styling with the finest details and exclusive elements.', '', 'luxury', 0, 1, '2025-10-01 18:55:54', 'assets/gallery/Luxury Experience.jpg'),
(30, 'Elegant Ring Ceremony', 'Beautiful floral backdrop and decor for a memorable engagement.', '', 'Engagements', 1, 1, '2025-10-01 19:18:21', 'assets/gallery/engagement_decor.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `inquiries`
--

CREATE TABLE `inquiries` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `subject` varchar(200) DEFAULT NULL,
  `message` text NOT NULL,
  `status` enum('pending','responded','closed') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `event_type` varchar(100) DEFAULT NULL,
  `event_date` date DEFAULT NULL,
  `guests` int(11) DEFAULT NULL,
  `budget` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inquiries`
--

INSERT INTO `inquiries` (`id`, `name`, `email`, `phone`, `subject`, `message`, `status`, `created_at`, `event_type`, `event_date`, `guests`, `budget`) VALUES
(1, 'Dip chetnani', 'dip@gmail.com', '8866323202', 'Destination Wedding Decorations', 'full data', 'responded', '2025-08-07 18:55:39', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_active` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `phone`, `address`, `created_at`, `is_active`) VALUES
(1, 'Dip chetnani', 'dip@gmail.com', 'c2d838580b3d58800f15ac54f32c668d', '8866323206', 'patelnager1,jamnger', '2025-08-04 12:30:11', 1),
(4, 'kamal', 'kamal@gemail.com', '$2y$10$235roywE7RDRzA1kHeIb1OGcs9wp6/vIn3/zQTlNQ7o22tV2Pv4gK', '8866323206', 'bro', '2025-09-20 04:59:01', 1),
(5, 'reetu ', 'rt@gmail.com', '$2y$10$D92o1Q.ZPLTNeAhcgQhbO.72ofcz3xD.0juqoXg2GLZPHk86yHXFa', 'qwqwqw', 'as', '2025-10-04 06:51:17', 1),
(6, 'raj', 'raj@gmail.com', '$2y$10$qCQgYmAXPB3ZsC98f1SOyOkXSI1LYgwdvKAwwUN3u8vVFuRvNa7ke', '8866424234', 'ddadads', '2025-10-21 07:25:09', 1),
(7, 'Deep', 'deep@gmail.com', '$2y$10$nH190hl41eekf2GQhuiJG.04f.RSGfNhYsAHBH0a3Z5Bw95F4lrom', '8866323206', 'okokok', '2025-10-21 07:56:41', 1),
(15, 'shali', 'sa@gmali.com', '$2y$10$V6iJv2s9qpRU01sOXI1DW.4x5kl85sMFXcCxdulnaYmJpiRqZwody', '8866424234', 'sdadadas', '2025-11-16 04:37:40', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_users`
--
ALTER TABLE `admin_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `decorations`
--
ALTER TABLE `decorations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `decoration_images`
--
ALTER TABLE `decoration_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `event_categories`
--
ALTER TABLE `event_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gallery`
--
ALTER TABLE `gallery`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inquiries`
--
ALTER TABLE `inquiries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_users`
--
ALTER TABLE `admin_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `decorations`
--
ALTER TABLE `decorations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `decoration_images`
--
ALTER TABLE `decoration_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `event_categories`
--
ALTER TABLE `event_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `gallery`
--
ALTER TABLE `gallery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `inquiries`
--
ALTER TABLE `inquiries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `decoration_images`
--
ALTER TABLE `decoration_images`
  ADD CONSTRAINT `decoration_images_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `event_categories` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
