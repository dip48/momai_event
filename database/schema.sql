CREATE DATABASE IF NOT EXISTS momai_event_db;
USE momai_event_db;

-- Admin users table
CREATE TABLE admin_users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Regular users table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(20),
    address TEXT,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Event categories table
CREATE TABLE event_categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    image_url VARCHAR(255),
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Decorations table (updated name)
CREATE TABLE decorations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    description TEXT,
    image_path VARCHAR(255) NOT NULL,
    category VARCHAR(100) NOT NULL,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Gallery table
CREATE TABLE gallery (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    description TEXT,
    image_path VARCHAR(255) NOT NULL,
    category VARCHAR(50),
    is_featured BOOLEAN DEFAULT FALSE,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Bookings table
CREATE TABLE bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    event_type VARCHAR(100) NOT NULL,
    event_date DATE NOT NULL,
    event_time TIME,
    venue VARCHAR(200),
    guest_count INT NOT NULL,
    budget DECIMAL(10,2),
    services_required TEXT,
    special_requirements TEXT,
    status ENUM('pending', 'confirmed', 'in_progress', 'completed', 'cancelled') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Inquiries table (updated for admin interface)
CREATE TABLE inquiries (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    event_type VARCHAR(100),
    event_date DATE,
    guests INT,
    budget DECIMAL(10,2),
    subject VARCHAR(200),
    message TEXT NOT NULL,
    status ENUM('pending', 'responded', 'closed') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert default admin user (password: admin123)
INSERT INTO admin_users (username, password, email) VALUES 
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin@momaievent.com'),
(2, 'kamal', '$2y$10$twYuCZ5SzlVjd2lSFmhiBOY4gv/slOTX2t60cka7K6NDH2tq.oEVO', 'kamal@momaievent.com', '2025-08-07 18:27:05'),
(3, 'dip', '$2y$10$gLTlrthtK0h2/FlHBAnXlOcfVDVIHoYbqpkoFdFzCklvR1h1AM0wq', 'dip@momaievent.com', '2025-08-07 19:53:04');

-- Insert default event categories
INSERT INTO event_categories (name, description, is_active) VALUES 
(1, 'Destination Wedding Decorations', 'Beautiful wedding decorations for destination weddings', NULL, 1, '2025-08-04 12:12:44'),
(2, 'Decoration with Catering Planning', 'Complete event planning with decoration and catering', NULL, 1, '2025-08-04 12:12:44'),
(3, 'Pick and Drop', 'Transportation services for events', NULL, 1, '2025-08-04 12:12:44'),
(4, 'Birthday Party', 'Birthday celebration decorations and planning', NULL, 1, '2025-08-04 12:12:44'),
(5, 'Baby Shower', 'Baby shower decorations and arrangements', NULL, 1, '2025-08-04 12:12:44'),
(6, 'Event Timeline', 'Professional event timeline planning', NULL, 1, '2025-08-04 12:12:44'),
(7, 'Baby name', 'Your Baby name event planning', NULL, 1, '2025-08-07 18:59:49'),
(8, 'name of the catgegory', 'this is the random category for the other events we can manage on our side surprises no one know about the event what is going on', NULL, 1, '2025-08-31 07:06:47');

-- Insert sample gallery images
INSERT INTO gallery (title, description, image_path, category, is_featured, is_active) VALUES
(1, 'Elegant Wedding Setup', 'Beautiful wedding decoration with white and gold theme featuring elegant floral arrangements, romantic lighting, and luxurious table settings', '', 'Wedding', 1, 1, '2025-08-18 11:01:49', 'assets/gallery/Elegant Wedding Setup.jpg'),
(2, 'Colorful Birthday Party', 'Fun and vibrant birthday party with rainbow theme, colorful balloons, and festive decorations', '', 'Birthday', 1, 1, '2025-08-18 11:01:49', 'assets/gallery/Colorful Birthday Party.jpg'),
(3, 'Corporate Event Hall', 'Professional corporate event setup with modern staging, professional lighting, and business branding', '', 'Corporate', 0, 1, '2025-08-18 11:01:49', 'assets/gallery/Corporate Event Hall.jpeg'),
(4, 'Baby Shower Celebration', 'Cute baby shower with pink and blue decorations, adorable themed elements, and sweet treats', '', 'Baby Shower', 1, 1, '2025-08-18 11:01:49', 'assets/gallery/Baby_Shower.jpg'),
(5, 'Anniversary Dinner', 'Romantic anniversary celebration setup with candlelit ambiance, rose petals, and intimate dining', '', 'Anniversary', 0, 1, '2025-08-18 11:01:49', 'assets/gallery/Anniversary Dinner.webp'),
(6, 'Garden Wedding', 'Outdoor garden wedding decoration with natural beauty, floral arches, and scenic backdrops', '', 'Wedding', 1, 1, '2025-08-18 11:01:49', 'assets/gallery/Garden_Wedding1.jpg'),
(7, 'Luxury Reception', 'Premium luxury wedding reception with crystal chandeliers, gold accents, and premium linens', '', 'Wedding', 1, 1, '2025-08-18 11:01:49', 'assets/gallery/Luxury_Reception.jpg'),
(8, 'Kids Birthday Theme', 'Themed children birthday party with cartoon characters, colorful decorations, and fun activities', '', 'Birthday', 0, 1, '2025-08-18 11:01:49', 'assets/gallery/baby_party.jpg'),
(9, 'Business Conference', 'Professional business conference setup with modern AV equipment and corporate branding', '', 'Corporate', 0, 1, '2025-08-18 11:01:49', 'assets/gallery/Business Conference.jpg'),
(10, 'Outdoor Baby Shower', 'Beautiful outdoor baby shower with pastel colors, garden setting, and elegant decorations', '', 'Baby Shower', 0, 1, '2025-08-18 11:01:49', 'assets/gallery/Outdoor_Baby_Shower.jpg'),
(11, 'Elegant Event Setup', 'Beautiful event decoration with sophisticated styling and attention to detail.', '', 'event', 0, 1, '2025-10-01 18:55:54', 'assets/gallery/Elegant Event Setup.jpg'),
(12, 'Celebration Styling', 'Memorable celebration decoration with vibrant colors and festive elements.', '', 'celebration', 0, 1, '2025-10-01 18:55:54', 'assets/gallery/Screenshot_2025-05-17-23-12-18-98_1c337646f29875672b5a61192b9010f9.jpg'),
(13, 'Party Decoration', 'Fun and elegant party setup with creative themes and stylish arrangements.', '', 'party', 0, 1, '2025-10-01 18:55:54', 'assets/gallery/Screenshot_2025-06-24-18-44-23-46_1c337646f29875672b5a61192b9010f9.jpg'),
(14, 'Special Occasion', 'Unique and personalized decoration for your most special moments.', '', 'special', 0, 1, '2025-10-01 18:55:54', 'assets/gallery/Screenshot_2025-06-24-18-46-28-90_1c337646f29875672b5a61192b9010f9.jpg'),
(15, 'Luxury Experience', 'Premium luxury event styling with the finest details and exclusive elements.', '', 'luxury', 0, 1, '2025-10-01 18:55:54', 'assets/gallery/Luxury Experience.jpg'),
(16, 'Elegant Ring Ceremony', 'Beautiful floral backdrop and decor for a memorable engagement.', '', 'Engagements', 1, 1, '2025-10-01 19:18:21', 'assets/gallery/engagement_decor.jpg');

-- Insert sample decorations
INSERT INTO decorations (title, description, image_path, category, is_active) VALUES
(1, 'Elegant Wedding Arch', 'Beautiful floral wedding arch decoration', 'assets/decorations/wedding_arch.jpg', 'Baby Shower', 1, '2025-08-07 18:53:09'),
(2, 'Birthday Balloon Setup', 'Colorful balloon arrangement for birthdays', 'assets/decorations/birthday_balloons.jpg', 'Birthday', 1, '2025-08-07 18:53:09'),
(3, 'Corporate Event Backdrop', 'Professional backdrop for corporate events', 'assets/decorations/corporate_backdrop.jpg', 'Corporate', 1, '2025-08-07 18:53:09'),
(4, 'Baby Shower Decor', 'Cute baby shower decoration setup', 'assets/decorations/baby_shower.jpg', 'Baby Shower', 1, '2025-08-07 18:53:09'),
(5, 'Anniversary Celebration', 'Romantic anniversary decoration', 'assets/decorations/anniversary.jpg', 'Anniversary', 1, '2025-08-07 18:53:09'),
(6, 'Garden Party Setup', 'Beautiful outdoor garden party decoration', 'assets/decorations/garden_party.jpg', 'Other', 1, '2025-08-07 18:53:09'),
(7, 'test', 'new demo', 'assets/decorations/68dfa0bee38fa.jpg', 'Other', 1, '2025-10-03 10:09:02');

INSERT INTO bookings (`id`, `user_id`, `event_type`, `event_date`, `event_time`, `venue`, `guest_count`, `budget`, `services_required`, `special_requirements`, `status`, `created_at`) VALUES
(1, 1, 'Decoration with Catering Planning', '2025-08-28', '09:23:00', 'patelnger1', 50, 10000.00, 'Decoration, Catering, Coordination', 'no', 'cancelled', '2025-08-04 12:51:47'),
(2, 4, 'Destination Wedding Decorations', '2025-09-23', '01:33:00', 'uyfytfuvjh', 50, 10000.00, 'Decoration, Catering, Photography', '', 'pending', '2025-09-20 05:00:08'),
(3, 4, 'Birthday Party', '2025-10-14', '02:35:00', 'patelnger1', 522, 50000.00, 'Entertainment', 'aaaa', 'completed', '2025-10-05 05:02:09');

INSERT INTO `users` (`id`, `name`, `email`, `password`, `phone`, `address`, `created_at`, `is_active`) VALUES
(1, 'Dip chetnani', 'dip@gmail.com', 'c2d838580b3d58800f15ac54f32c668d', '8866323206', 'patelnager1,jamnger', '2025-08-04 12:30:11', 1),
(2, 'kamal', 'kamal@gemail.com', '$2y$10$235roywE7RDRzA1kHeIb1OGcs9wp6/vIn3/zQTlNQ7o22tV2Pv4gK', '8866323206', 'bro', '2025-09-20 04:59:01', 1),
(3, 'reetu ', 'rt@gmail.com', '$2y$10$D92o1Q.ZPLTNeAhcgQhbO.72ofcz3xD.0juqoXg2GLZPHk86yHXFa', 'qwqwqw', 'as', '2025-10-04 06:51:17', 1),
(4, 'raj', 'raj@gmail.com', '$2y$10$qCQgYmAXPB3ZsC98f1SOyOkXSI1LYgwdvKAwwUN3u8vVFuRvNa7ke', '8866424234', 'ddadads', '2025-10-21 07:25:09', 1),
(5, 'Deep', 'deep@gmail.com', '$2y$10$nH190hl41eekf2GQhuiJG.04f.RSGfNhYsAHBH0a3Z5Bw95F4lrom', '8866323206', 'okokok', '2025-10-21 07:56:41', 1),
(6, 'shali', 'sa@gmali.com', '$2y$10$V6iJv2s9qpRU01sOXI1DW.4x5kl85sMFXcCxdulnaYmJpiRqZwody', '8866424234', 'sdadadas', '2025-11-16 04:37:40', 1);
