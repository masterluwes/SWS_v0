-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 06, 2025 at 09:25 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `stray_worth_saving`
--

-- --------------------------------------------------------

--
-- Table structure for table `adoption_forms`
--

CREATE TABLE `adoption_forms` (
  `id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `address` text NOT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `birthdate` date NOT NULL,
  `occupation` varchar(100) NOT NULL,
  `status` enum('single','married') NOT NULL,
  `pronouns` enum('she','he','they') NOT NULL,
  `prompted` text DEFAULT NULL,
  `adopt_before` enum('yes','no') NOT NULL,
  `animal_interest` varchar(255) NOT NULL,
  `terms_accepted` tinyint(1) NOT NULL,
  `consent_given` tinyint(1) NOT NULL,
  `submission_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `adoption_status` enum('Pending','Accepted','Rejected') NOT NULL DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `adoption_forms`
--

INSERT INTO `adoption_forms` (`id`, `first_name`, `last_name`, `address`, `phone`, `email`, `birthdate`, `occupation`, `status`, `pronouns`, `prompted`, `adopt_before`, `animal_interest`, `terms_accepted`, `consent_given`, `submission_date`, `adoption_status`) VALUES
(76, 'sa', 'Camacho', 'asd', 'asd', 'rommel@gmail.com', '2025-01-30', 'Worker', 'single', 'she', 'friends', 'no', 'Tenten', 1, 1, '2025-02-03 13:19:38', 'Pending'),
(77, 'Juan', 'Cruz', '123 Tanza Navotas', '0977 264 3692', 'test@gmail.com', '2025-01-28', 'Worker', 'single', 'she', 'social-media, others', 'no', 'lop', 1, 1, '2025-02-03 13:26:43', 'Pending'),
(78, 'John', 'Doe', '234 Tondo Manila', '0977 264 3692', 'jdoe@gmail.com', '2011-02-03', 'Kinder', 'single', 'he', 'website, social-media, others', 'no', 'Tenten', 1, 1, '2025-02-03 13:28:24', 'Pending'),
(79, 'Mary', 'Anna', '123 Cloverleaf Caloocan', '091923456789', 'marydoe@gmail.com', '2000-02-17', 'Teacher', 'single', 'she', 'friends, website, social-media, others', 'yes', 'pol', 1, 1, '2025-02-03 13:29:24', 'Accepted'),
(80, 'Luis Daniel', 'Enriquez', '1213 Gulayan Catmon Malabon', '0977 264 3692', 'itsmeluisdaniel@gmail.com', '2004-05-23', 'Student', 'single', 'he', 'friends, website, social-media, others', 'no', 'Tenten', 1, 1, '2025-02-03 13:34:57', 'Accepted'),
(85, 'Juana', 'Cruza', '555 Dallas Texas', '0977 264 3692', 'jv@gmail.com', '2000-06-08', 'Teacher', 'single', 'she', 'social-media, others', 'no', 'ron', 1, 1, '2025-02-04 12:06:21', 'Pending'),
(86, 'Jane', 'Doe', '234 Tondo Manila', '09772451234', 'jdoe@gmail.com', '2025-02-01', 'Worker', 'single', 'she', 'friends, website, social-media, others', 'no', 'lop', 1, 1, '2025-02-06 06:55:25', 'Accepted');

-- --------------------------------------------------------

--
-- Table structure for table `animals`
--

CREATE TABLE `animals` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `age_years` int(11) NOT NULL,
  `age_months` int(11) NOT NULL,
  `breed` varchar(255) NOT NULL,
  `medical_condition` text DEFAULT NULL,
  `disabilities` text DEFAULT NULL,
  `description` text NOT NULL,
  `gender` enum('Male','Female','Unknown') NOT NULL,
  `adopted` tinyint(1) NOT NULL DEFAULT 0,
  `image_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `animals`
--

INSERT INTO `animals` (`id`, `name`, `age_years`, `age_months`, `breed`, `medical_condition`, `disabilities`, `description`, `gender`, `adopted`, `image_path`, `created_at`) VALUES
(1, 'Tenten', 6, 5, 'Aspin', 'old', 'old', 'Ten-ten is a female dog that has been through so much suffering and pain after she was hacked. All that are over now and Ten-ten is enjoying is stay at the SWS Shelter after treatment and surgery.', 'Male', 0, 'uploads/678df5bf715fb-highlight-adopt.jpg', '2025-01-20 04:05:38'),
(2, 'lop', 5, 6, 'Aspin', 'tt', 'tt', 'tt', 'Male', 1, 'uploads/678df5f0540bd-Slice.jpg', '2025-01-20 06:27:04'),
(4, 'Mark', 3, 2, 'Aspin', 'as', 'ad', 'asd', 'Male', 1, 'uploads/678def50f0b1e-get-involved-logo.jpg', '2025-01-20 06:38:08'),
(5, 'ron', 3, 2, 'Aspin', 'ds', 'dsf', 'sdf', 'Male', 0, 'uploads/678df075d8a49-Chuchu.jpg', '2025-01-20 06:43:01'),
(6, 'pol', 6, 4, 'Aspin', 'dfsd', 'sfsdfxcv', 'swerwercv', 'Male', 0, 'uploads/678e15ae7867d-picachu.jpg', '2025-01-20 09:21:50');

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `subject` varchar(255) NOT NULL,
  `comment` text NOT NULL,
  `submission_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`id`, `first_name`, `last_name`, `email`, `phone`, `subject`, `comment`, `submission_date`) VALUES
(11, 'Juan', 'Cruz', 'jcruz@gmail.com', '0977 264 3692', 'Test', 'test', '2025-02-03 09:38:29'),
(14, 'Rhainier Jr.', 'Avelino', 'test@gmail.com', '123', '123', '123', '2025-02-03 09:50:23'),
(16, 'Pyarrha', 'Besana', 'pb@gmail.com', '09682556825', 'I want to adopt', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In gravida hendrerit tortor. Maecenas molestie ultrices erat, eget gravida lorem cursus laoreet. Vestibulum volutpat, arcu in semper ultrices, purus nisi porta dolor, et gravida nunc purus sit amet magna. In hac habitasse platea dictumst. Aenean non lectus vel lacus posuere vestibulum.', '2025-02-03 10:33:57'),
(17, 'Rommel', 'Camacho Jr', 'rommel@gmail.com', '09772451234', 'Hello', 'Test', '2025-02-03 13:36:39'),
(18, 'Luis Daniel', 'Enriquez', 'itsmeluisdaniel@gmail.com', '0977 264 3692', 'Donation of Goods', 'Hello! I want to donate goods like food and such. Can I please inquire about it? Thank you.', '2025-02-04 05:01:21'),
(19, 'Juan', 'Enriquez', 'test123@gmail.com', '0977 264 3692', 'Lorem Ipsum', 'asdaddwa3fasc a ftbtthr', '2025-02-06 07:13:19');

-- --------------------------------------------------------

--
-- Table structure for table `content_management`
--

CREATE TABLE `content_management` (
  `id` int(11) NOT NULL,
  `page` varchar(255) NOT NULL,
  `section` varchar(255) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `content_management`
--

INSERT INTO `content_management` (`id`, `page`, `section`, `title`, `content`, `image_path`, `url`) VALUES
(1, 'homepage', 'home_banner', 'We are Strays Worth Savings', 'Dedicated to rescuing and protecting stray animals, we strive to give them a chance at a better life. Together, we can create a compassionate community for all.', 'homebanner.jpg', NULL),
(2, 'homepage', 'nav_section', 'About Us', 'Learn more about our mission to protect and rescue stray animals.', 'logo1.png', '#about-us'),
(3, 'homepage', 'nav_section', 'Adopt a Pet', 'Find your perfect furry friend and give them a forever home.', 'adopt-a-pet-logo.jpg', 'adopt.php'),
(4, 'homepage', 'nav_section', 'Get Involved', 'Join us by volunteering or donating.', 'get-involved-logo.jpg', 'getinvolved.php'),
(5, 'homepage', 'nav_section', 'Success Stories', 'Celebrate heartwarming stories of rescued animals.', 'success-logo.jpg', 'success-stories.php'),
(6, 'homepage', 'nav_section', 'Events & Campaign', 'Discover upcoming events and campaigns to support our cause.', 'events-logo.jpg', 'events-campaign.php'),
(7, 'homepage', 'nav_section', 'Contact Us', 'Reach out to us for more information.', 'contact-logo.jpg', 'contact.html'),
(8, 'homepage', 'highlights', 'Kokey is looking for a loving home', 'Kokey is looking for a loving forever home. We are seeking vaccination-compliant adopters who value the health and well-being of our rescues.', 'highlight-adopt.jpg', 'adopt.php'),
(9, 'homepage', 'highlights', 'Fundraising for MICO', 'SWS is raising ₱7,000 to support the rescue and initial vet care of Mico, a Shih Tzu in desperate need. Reported by advocate Rhiki Tiktak, Mico\'s owner c...', 'highlight-fundraising.jpg', 'getinvolved.php'),
(10, 'homepage', 'highlights', 'Update on Granny', 'Granny, the senior dog hit by a vehicle and found crying in pain, remains under treatment and care. She is currently being assessed to determine if surgery is...', 'highlight-success.jpg', ''),
(11, 'homepage', 'about_us', 'History', 'Founded in 2019, SWS is an SEC-registered animal foundation that rescues stray dogs and cats, particularly cases that are severe, in order to rehabilitate them and have them healthy enough for adoption. Our shelter is based in Tanauan, Batangas. At Strays Worth Saving, we are committed to giving stray animals the care and attention they deserve. Through rescue, rehabilitation, and adoption, we aim to provide them with a better future. You can make an impact by adopting a pet, making a donation, or volunteering your time. Together, we can build a compassionate community where every stray finds safety, love, and belonging.', 'About-us-history.jpg', NULL),
(12, 'homepage', 'about_us', 'Vision', 'It is the vision of SWS to eventually have a stray-free country through spaying and neutering.', 'about-us-vision.jpg', NULL),
(13, 'homepage', 'about_us', 'Missions', 'It is the mission of SWS to be able to save strays in pain and brink of death, to take them off the streets, have them treated, and find them the ideal home with loving parents.', 'About-us-mission.jpg', NULL),
(14, 'adopt', 'adopt_sec', 'Adopt a Pet', 'Give a stray a second chance at life. Explore our list of adoptable pets and find your perfect companion today!\r\n\r\n\r\nSince these animals have endured challenging lives before being rescued, it\'s essential to ensure they are adopted by caring individuals who will provide them with the love and safety they deserve. Here\'s the application process:\r\n\r\n     1.\r\n     2.\r\n     3.\r\n     4.\r\n     5.\r\n     6.', '', ''),
(15, 'adopt', 'adopt_faq', 'What is the adoption fee?', 'The adoption fee covers the cost of vaccinations, spaying/neutering, and other medical expenses.', '', NULL),
(16, 'adopt', 'adopt_faq', 'Can I adopt more than one pet?', 'Yes, you can adopt more than one pet, but it\'s important to ensure that you can provide adequate care for all pets.', '', NULL),
(20, 'adopt', 'adopt_faq', 'test', 'testsss', NULL, NULL),
(25, 'adopt', 'adopt_faq', 'art', 'ap', NULL, NULL),
(26, 'success', 'Success Stories', 'Success Stories', '  Every rescue has a story to tell. Our Success Stories blog shares the heartwarming journeys of the animals we’ve saved  \r\n—from their struggles to their triumphs in finding forever homes.', 'About-us-mission.jpg', ''),
(27, 'events', 'Events and Campaigns', 'Join Our Events and Campaigns', 'Take part in our events and campaigns to support our mission.', 'eventscampaigsnbanner.jpg', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `donations`
--

CREATE TABLE `donations` (
  `id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `bank` varchar(50) NOT NULL,
  `proof_of_payment` varchar(255) NOT NULL,
  `submission_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `donations`
--

INSERT INTO `donations` (`id`, `first_name`, `last_name`, `email`, `phone`, `amount`, `bank`, `proof_of_payment`, `submission_date`) VALUES
(10, '', '', '', '091923456789', 80.00, 'Paymaya/Coins.ph/Gcash', 'uploads/1738670925_gcash2.jpg', '2025-02-04 12:08:45'),
(13, '', '', '', '', 50.00, 'Paypal', 'uploads/1738772766_gcash2.jpg', '2025-02-05 16:26:06'),
(15, '', '', '', '', 30.00, 'Paymaya/Coins.ph/Gcash', 'uploads/1738819419_gcash2.jpg', '2025-02-06 05:23:39'),
(16, '', '', '', '', 200.00, 'Paymaya/Coins.ph/Gcash', 'uploads/1738824485_gcash2.jpg', '2025-02-06 06:48:05'),
(18, '', '', '', '', 20.00, 'Paymaya/Coins.ph/Gcash', 'uploads/1738828658_gcash2.jpg', '2025-02-06 07:57:38');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `location` varchar(255) NOT NULL,
  `participants` int(11) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `archived` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `title`, `description`, `date`, `start_time`, `end_time`, `location`, `participants`, `image_path`, `archived`) VALUES
(1, 'Adoption Drives', 'Join us for a heartwarming adoption drive where you can meet and adopt lovely pets.', '2024-12-12', '14:00:00', '19:00:00', 'Main Time Square near C-5 Shopsss', 150, 'success-logo.jpg', 1),
(2, 'Charity Walks', 'Participate in our charity walk to support animal shelters and raise awareness.', '2025-01-28', '09:00:00', '11:00:00', 'Central Park', 200, 'highlight-success.jpg', 1),
(3, 'Awareness Campaign', 'Learn about animal rights and how you can help in our awareness campaign.', '2025-01-29', '10:00:00', '12:00:00', 'Downtown Convention Center', 100, 'adopt-a-pet-logo.jpg', 1),
(4, 'Fundraising Gala', 'Join our fundraising gala to support our mission and enjoy an evening of entertainment.', '2025-05-15', '19:00:00', '22:00:00', 'Grand Hotel Ballroom', 300, 'depositphotos_227724992-stock-illustration-image-available-icon-flat-vector.jpg', 0),
(5, 'Pet Training Workshop', 'Attend our pet training workshop to learn tips and tricks for training your pets.', '2025-06-12', '14:00:00', '16:00:00', 'City Hall Auditorium', 120, 'depositphotos_227724992-stock-illustration-image-available-icon-flat-vector.jpg', 0),
(6, 'Volunteer Meetup', 'Meet fellow volunteers and share your experiences in our volunteer meetup.', '2025-07-15', '17:00:00', '19:00:00', 'Volunteer Center', 80, 'depositphotos_227724992-stock-illustration-image-available-icon-flat-vector.jpg', 0),
(7, 'Meet with Furbabies', 'Spend time with lovable, adoptable pets waiting for their forever homes.', '2024-12-07', '10:00:00', '14:00:00', 'Tanauan Hall', 100, 'adopt_bembem.jpg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `fundraising_donations`
--

CREATE TABLE `fundraising_donations` (
  `id` int(11) NOT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `bank` varchar(255) DEFAULT NULL,
  `proof_of_payment` varchar(255) DEFAULT NULL,
  `fundraising_name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fundraising_donations`
--

INSERT INTO `fundraising_donations` (`id`, `first_name`, `last_name`, `email`, `phone`, `amount`, `bank`, `proof_of_payment`, `fundraising_name`, `created_at`) VALUES
(30, '', '', '', '', 5.00, 'Paymaya/Coins.ph/Gcash', 'uploads/gcash2.jpg', '5PHP FUND DRIVE FOR GRANNY!', '2025-02-05 12:26:14'),
(31, '', '', '', '', 1.00, 'Paymaya/Coins.ph/Gcash', 'uploads/gcash2.jpg', 'FUNDRAISING FOR GENERAL', '2025-02-05 12:27:01'),
(34, '', '', '', '', 2.00, 'Paymaya/Coins.ph/Gcash', 'uploads/gcash2.jpg', '5 FUND DRIVE FOR SWS SHELTER RESCUES!', '2025-02-05 12:29:18'),
(35, '', '', '', '', 4.00, 'Paymaya/Coins.ph/Gcash', 'uploads/gcash2.jpg', 'FUNDRAISING FOR CHUCKY!', '2025-02-05 12:30:42'),
(37, '', '', '', '', 3.00, 'Paymaya/Coins.ph/Gcash', 'uploads/sample-gcash-receipt.jpg', 'HELP GHOST!', '2025-02-05 12:35:47'),
(38, '', '', '', '', 6.00, 'Paymaya/Coins.ph/Gcash', 'uploads/sample-gcash-receipt.jpg', 'JUSTICE FOR HOLLY', '2025-02-05 12:42:07'),
(39, '', '', '', '', 7.00, 'Paymaya/Coins.ph/Gcash', 'uploads/sample-gcash-receipt.jpg', 'FUNDRAISING FOR JADE', '2025-02-05 12:48:41'),
(40, '', '', '', '', 8.00, 'Paymaya/Coins.ph/Gcash', 'uploads/gcash2.jpg', 'FUNDRAISING FOR MARINA', '2025-02-05 12:55:34'),
(41, '', '', '', '', 9.00, 'Paymaya/Coins.ph/Gcash', 'uploads/gcash2.jpg', 'HELP ROSS!', '2025-02-05 13:03:50'),
(43, '', '', '', '', 10.00, 'Paypal', 'uploads/gcash2.jpg', 'FUNDRAISING FOR SIA THE CAT', '2025-02-05 13:23:35'),
(44, '', '', '', '', 20.00, 'Paypal', 'uploads/sample-gcash-receipt.jpg', 'FUNDRAISING FOR SIA THE CAT', '2025-02-05 13:23:57'),
(45, '', '', '', '', 20.00, 'Paymaya/Coins.ph/Gcash', 'uploads/gcash2.jpg', '5PHP FUND DRIVE FOR GRANNY!', '2025-02-05 13:24:51'),
(46, '', '', '', '', 2.00, 'BDO', 'uploads/sample-gcash-receipt.jpg', 'FUNDRAISING FOR MARINA', '2025-02-05 13:35:46'),
(47, '', '', '', '', 25.00, 'Paymaya/Coins.ph/Gcash', 'uploads/gcash2.jpg', '5PHP FUND DRIVE FOR GRANNY!', '2025-02-06 07:04:37'),
(48, '', '', '', '', 50.00, 'Paymaya/Coins.ph/Gcash', 'uploads/gcash2.jpg', 'HELP GHOST!', '2025-02-06 07:41:49');

-- --------------------------------------------------------

--
-- Table structure for table `stories`
--

CREATE TABLE `stories` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `date_added` datetime NOT NULL,
  `archived` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stories`
--

INSERT INTO `stories` (`id`, `title`, `content`, `image`, `date_added`, `archived`) VALUES
(1, 'Lizzy, adopted by Ms. Lhai, needs your help once again!', 'Lizzy, a rescue dog, had her legs broken by abuse and needed two expensive surgeries to repair them. Now, the metal plates in her legs are causing issues, requiring more surgeries. Her adopter can’t afford the costs, so SWS is helping again. We need donations to cover the expenses and ensure Lizzy stays healthy. Please help!', 'adopt_josie.jpg', '2025-01-10 00:00:00', 0),
(2, 'Update on Snow!', 'Snow is still getting her weekly chemotherapy shots for her big genital TVT. Her tumor is showing great improvement but is not out of the woods yet. She would need 2-3 chemotherapy shots (at ₱2,500 each) to fully heal. Please pray for Snows recovery.', 'Snow.jpg', '2025-01-10 00:00:00', 0),
(3, 'Update on Ross!', 'Ross (Mama dog hit by a vehicle needed jaw surgery) is still confined and under post operation recovery. She is showing little improvement but she still has a long way to go. Please pray for Rosss recovery. As this is another expensive and lengthy vetting, we badly need your support. Please donate for Ross so that we can cover her entire bill please. Thank you and God bless!', 'Ross.jpg', '2024-06-10 00:00:00', 1),
(4, 'Thank you, AirAsia Philippines!', 'We’d like to extend our many thanks to AirAsia Philippines for visiting our shelter last January 10 and donating various supplies, including dog food, shampoo, towels and other cleaning materials. We appreciate that you chose our shelter and we hope that you continue to support foundations such as ours.', 'stories-dec2024.jpg', '2024-10-10 00:00:00', 1),
(5, 'Update on Bruiser!', 'Bruiser (dog found very malnourished and is having difficulty walking) is still getting all the meds and treatment needed. He is gaining a little weight and is showing little improvement. He can now stand but he still has difficulty walking, please pray for Bruisers quick and safe recovery.', 'Bruiser.jpg', '2024-12-10 00:00:00', 1),
(6, 'Update on Macky!', 'Macky (dog found with missing foot with bones exposed) is still under post operation recovery and is getting all the meds and treatment needed after his surgery. He is showing improvement and will soon be up for adoption. Please pray for Mackys continuous recovery.', 'Macky.jpg', '2024-12-10 00:00:00', 1),
(7, 'Aiko gets adopted by Ms. Pammy!', 'Aiko’s case was referred to SWS by a concerned animal lover. Aiko is a mixed Husky that might possibly be owned. Regardless, she was almost hit by a vehicle that is why the one who posted about her tied her up. SWS arranged her rescue and since December 19, Aiko was brought to Vetlink Vet Clinic for tests and treatment. Thankfully, Aiko is negative for distemper and heartworm. She has mild anemia and other blood test results are not normal, though not worrisome. Meds and treatment are administered.', 'Pammy.jpg', '2024-11-10 00:00:00', 1),
(8, 'test2', 'test', 'Boss.jpg', '2025-01-26 00:00:00', 0),
(9, 'test1', 'test2', 'Shawie.jpg', '2024-12-11 00:00:00', 0),
(10, 'test3', 'testing', 'adopt_slice.jpg', '2024-12-20 00:00:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','staff') NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `gender` enum('Male','Female','Other') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `email`, `first_name`, `last_name`, `gender`) VALUES
(1, 'admin', 'admin', 'admin', NULL, '', '', 'Male'),
(3, 'staff2', 'staff2', 'staff', NULL, '', '', 'Male'),
(6, 'admin10', '$2y$10$OhPkcjy1djgdsEQeMkjoeOnHIbwHS7WyqPakFr5uRK.rpggGXp0Ky', 'admin', NULL, '', '', 'Male'),
(7, 'test_admin', '$2y$10$p5Ol77gjloJtmPUKAfykpOHQxWbzZDuokL828cbmUML3byOIs/rBS', 'admin', 'test@gmail.com', 'sample', 'admin', 'Male'),
(8, 'test', '$2y$10$Ldgw4tcZMHkrHLUeihJZeuh6MkhfE2iZnxRO8t/agmo/OyKzwgKsK', 'admin', 'test@gmail.com', 'John', 'Doe', 'Male');

-- --------------------------------------------------------

--
-- Table structure for table `volunteers`
--

CREATE TABLE `volunteers` (
  `id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `submission_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('Pending','Accepted','Rejected') NOT NULL DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `volunteers`
--

INSERT INTO `volunteers` (`id`, `first_name`, `last_name`, `email`, `submission_date`, `status`) VALUES
(20, 'John Dave', 'Cruz III', 'test123@gmail.com', '2025-02-02 17:34:33', 'Accepted'),
(26, 'Juan Dela', 'Cruz III', 'jcruz@gmail.com', '2025-02-03 09:29:42', 'Accepted'),
(27, 'John', 'Doe', 'test@gmail.com', '2025-02-05 07:51:46', 'Pending'),
(28, 'John', 'Doe', 'jdoe@gmail.com', '2025-02-06 07:07:33', 'Pending');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `adoption_forms`
--
ALTER TABLE `adoption_forms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `animals`
--
ALTER TABLE `animals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `content_management`
--
ALTER TABLE `content_management`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `donations`
--
ALTER TABLE `donations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fundraising_donations`
--
ALTER TABLE `fundraising_donations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stories`
--
ALTER TABLE `stories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `volunteers`
--
ALTER TABLE `volunteers`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `adoption_forms`
--
ALTER TABLE `adoption_forms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT for table `animals`
--
ALTER TABLE `animals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `content_management`
--
ALTER TABLE `content_management`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `donations`
--
ALTER TABLE `donations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `fundraising_donations`
--
ALTER TABLE `fundraising_donations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `stories`
--
ALTER TABLE `stories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `volunteers`
--
ALTER TABLE `volunteers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
