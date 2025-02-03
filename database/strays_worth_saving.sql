-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Jan 29, 2025 at 09:45 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `strays_worth_saving`
--

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `animals`
--

INSERT INTO `animals` (`id`, `name`, `age_years`, `age_months`, `breed`, `medical_condition`, `disabilities`, `description`, `gender`, `adopted`, `image_path`, `created_at`) VALUES
(1, 'Tenten', 6, 5, 'Aspin', 'old', 'old', 'Ten-ten is a female dog that has been through so much suffering and pain after she was hacked. All that are over now and Ten-ten is enjoying is stay at the SWS Shelter after treatment and surgery.', 'Male', 0, 'uploads/678df5bf715fb-highlight-adopt.jpg', '2025-01-20 04:05:38'),
(2, 'lop', 5, 6, 'Aspin', 'tt', 'tt', 'tt', 'Male', 0, 'uploads/678df5f0540bd-Slice.jpg', '2025-01-20 06:27:04'),
(4, 'ssse', 3, 2, 'Aspin', 'as', 'ad', 'asd', 'Male', 0, 'uploads/678def50f0b1e-get-involved-logo.jpg', '2025-01-20 06:38:08'),
(5, 'ron', 3, 2, 'Aspin', 'ds', 'dsf', 'sdf', 'Male', 0, 'uploads/678df075d8a49-Chuchu.jpg', '2025-01-20 06:43:01'),
(6, 'pol', 6, 4, 'Aspin', 'dfsd', 'sfsdfxcv', 'swerwercv', 'Male', 0, 'uploads/678e15ae7867d-picachu.jpg', '2025-01-20 09:21:50'),
(7, 'hert', 3, 4, 'Aspin', 'vcb', 'vcbvbn', 'nbm', 'Male', 0, 'uploads/678e5777247b6-dada.jpg', '2025-01-20 14:02:31');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `content_management`
--

INSERT INTO `content_management` (`id`, `page`, `section`, `title`, `content`, `image_path`, `url`) VALUES
(1, 'homepage', 'home_banner', 'We are Strays Worth Saving', 'Dedicated to rescuing and protecting stray animals, we strive to give them a chance at a better life. Together, we can create a compassionate community for all.', 'homebanner.jpg', NULL),
(2, 'homepage', 'nav_section', 'About Us', 'Learn more about our mission to protect and rescue stray animals.', 'logo1.png', '#about-us'),
(3, 'homepage', 'nav_section', 'Adopt a Pet', 'Find your perfect furry friend and give them a forever home.', 'adopt-a-pet-logo.jpg', 'adopt.php'),
(4, 'homepage', 'nav_section', 'Get Involved', 'Join us by volunteering or donating.', 'get-involved-logo.jpg', 'getinvolved.html'),
(5, 'homepage', 'nav_section', 'Success Stories', 'Celebrate heartwarming stories of rescued animals.', 'success-logo.jpg', 'success-stories.php'),
(6, 'homepage', 'nav_section', 'Events & Campaign', 'Discover upcoming events and campaigns to support our cause.', 'events-logo.jpg', 'events-campaign.php'),
(7, 'homepage', 'nav_section', 'Contact Us', 'Reach out to us for more information.', 'contact-logo.jpg', 'contact.html'),
(8, 'homepage', 'highlights', 'Kokey is looking for a loving home', 'Kokey is looking for a loving forever home. We are seeking vaccination-compliant adopters who value the health and well-being of our rescues.', 'highlight-adopt.jpg', 'adopt.php'),
(9, 'homepage', 'highlights', 'Fundraising for MICO', 'SWS is raising ₱7,000 to support the rescue and initial vet care of Mico, a Shih Tzu in desperate need. Reported by advocate Rhiki Tiktak, Mico\'s owner c...', 'highlight-fundraising.jpg', 'getinvolved.html'),
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `title`, `description`, `date`, `start_time`, `end_time`, `location`, `participants`, `image_path`, `archived`) VALUES
(1, 'Adoption Drivessss', 'Join us for a heartwarming adoption drive where you can meet and adopt lovely pets.sss', '2024-12-12', '14:00:00', '19:00:00', 'Main Time Square near C-5 Shopsss', 150, 'success-logo.jpg', 1),
(2, 'Charity Walks', 'Participate in our charity walk to support animal shelters and raise awareness.', '2025-01-28', '09:00:00', '11:00:00', 'Central Park', 200, 'highlight-success.jpg', 1),
(3, 'Awareness Campaign', 'Learn about animal rights and how you can help in our awareness campaign.', '2025-01-29', '10:00:00', '12:00:00', 'Downtown Convention Center', 100, 'adopt-a-pet-logo.jpg', 0),
(4, 'Fundraising Gala', 'Join our fundraising gala to support our mission and enjoy an evening of entertainment.', '2025-05-15', '19:00:00', '22:00:00', 'Grand Hotel Ballroom', 300, 'media/image4.jpg', 0),
(5, 'Pet Training Workshop', 'Attend our pet training workshop to learn tips and tricks for training your pets.', '2025-06-12', '14:00:00', '16:00:00', 'City Hall Auditorium', 120, 'media/image5.jpg', 0),
(6, 'Volunteer Meetup', 'Meet fellow volunteers and share your experiences in our volunteer meetup.', '2025-07-08', '17:00:00', '19:00:00', 'Volunteer Center', 80, 'media/image6.jpg', 0),
(7, 'test', 'test', '2025-01-23', '10:04:00', '14:04:00', 'test', 100, 'adopt_bembem.jpg', 1);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
  `role` enum('admin','staff') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`) VALUES
(1, 'admin', 'admin', 'admin'),
(2, 'staff', 'staff1', 'staff'),
(3, 'staff2', 'staff2', 'staff');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `animals`
--
ALTER TABLE `animals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `content_management`
--
ALTER TABLE `content_management`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
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
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `animals`
--
ALTER TABLE `animals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `content_management`
--
ALTER TABLE `content_management`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `stories`
--
ALTER TABLE `stories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
