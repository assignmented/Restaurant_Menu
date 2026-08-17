-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 22, 2026 at 09:59 PM
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
-- Database: `the_black_perch`
--

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `brand_id` int(11) NOT NULL,
  `brand_cat_id` int(11) NOT NULL,
  `brand_subcat_id` int(11) NOT NULL,
  `brand_name` varchar(255) NOT NULL,
  `brand_status` enum('0','1') NOT NULL DEFAULT '1',
  `brand_image` varchar(255) NOT NULL,
  `brand_tstamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`brand_id`, `brand_cat_id`, `brand_subcat_id`, `brand_name`, `brand_status`, `brand_image`, `brand_tstamp`) VALUES
(1, 1, 1, 'Salads', '1', '', '2026-07-22 18:54:30'),
(2, 1, 1, 'Soups', '1', '', '2026-07-22 18:54:30'),
(3, 1, 1, 'Tamu Bites', '1', '', '2026-07-22 18:54:30'),
(4, 2, 2, 'Breakfast', '1', '', '2026-07-22 18:54:30'),
(5, 3, 3, 'Black Perch Signature', '1', '', '2026-07-22 18:54:30'),
(6, 3, 3, 'Brewed Coffee', '1', '', '2026-07-22 18:54:30'),
(7, 3, 3, 'Espresso Bar', '1', '', '2026-07-22 18:54:30'),
(8, 3, 3, 'Non - Coffee and Seasonals', '1', '', '2026-07-22 18:54:30'),
(9, 3, 4, 'Boba Bubble Fruit Teas', '1', '', '2026-07-22 18:54:30'),
(10, 3, 4, 'Boba Milk Teas', '1', '', '2026-07-22 18:54:30'),
(11, 3, 4, 'Frappes', '1', '', '2026-07-22 18:54:30'),
(12, 3, 4, 'Slushies', '1', '', '2026-07-22 18:54:30'),
(13, 3, 5, 'Ice Cream', '1', '', '2026-07-22 18:54:30'),
(14, 3, 5, 'Ice Cream Sundae', '1', '', '2026-07-22 18:54:30'),
(15, 3, 6, 'Classic Mojitos', '1', '', '2026-07-22 18:54:30'),
(16, 3, 6, 'Coladas', '1', '', '2026-07-22 18:54:30'),
(17, 3, 6, 'Fruity Mojitos', '1', '', '2026-07-22 18:54:30'),
(18, 3, 6, 'Tropical Mojitos', '1', '', '2026-07-22 18:54:30'),
(19, 4, 7, 'Beer Cans', '1', '', '2026-07-22 18:54:30'),
(20, 4, 8, 'Beers', '1', '', '2026-07-22 18:54:30'),
(21, 4, 9, 'Brandy', '1', '', '2026-07-22 18:54:30'),
(22, 4, 10, 'Gin Tower', '1', '', '2026-07-22 18:54:30'),
(23, 4, 10, 'Rum Tower', '1', '', '2026-07-22 18:54:30'),
(24, 4, 10, 'Vodka Tower', '1', '', '2026-07-22 18:54:30'),
(25, 4, 11, 'Alcoholic Slushes', '1', '', '2026-07-22 18:54:30'),
(26, 4, 11, 'Black Perch Signature', '1', '', '2026-07-22 18:54:30'),
(27, 4, 11, 'Coffee Cocktails', '1', '', '2026-07-22 18:54:30'),
(28, 4, 11, 'Gin Cocktails', '1', '', '2026-07-22 18:54:30'),
(29, 4, 11, 'Rum Cocktails', '1', '', '2026-07-22 18:54:30'),
(30, 4, 11, 'Tequila Cocktails', '1', '', '2026-07-22 18:54:30'),
(31, 4, 11, 'Vodka Cocktails', '1', '', '2026-07-22 18:54:30'),
(32, 4, 11, 'Whiskey and Bourbon Cocktails', '1', '', '2026-07-22 18:54:30'),
(33, 4, 11, 'Wine and Sparkling Cocktails', '1', '', '2026-07-22 18:54:30'),
(34, 4, 12, 'Cognac', '1', '', '2026-07-22 18:54:30'),
(35, 4, 13, 'Gin', '1', '', '2026-07-22 18:54:30'),
(36, 4, 13, 'Vodka', '1', '', '2026-07-22 18:54:30'),
(37, 4, 14, 'Liquor', '1', '', '2026-07-22 18:54:30'),
(38, 4, 15, 'Tequila', '1', '', '2026-07-22 18:54:30'),
(39, 4, 16, 'Tots', '1', '', '2026-07-22 18:54:30'),
(40, 4, 17, 'Whiskey', '1', '', '2026-07-22 18:54:30'),
(41, 4, 18, 'Dry Red Wine', '1', '', '2026-07-22 18:54:30'),
(42, 4, 18, 'Dry White Wine', '1', '', '2026-07-22 18:54:30'),
(43, 4, 18, 'Sparkling Wine', '1', '', '2026-07-22 18:54:30'),
(44, 4, 18, 'Sweet Red Wine', '1', '', '2026-07-22 18:54:30'),
(45, 4, 18, 'Sweet White Wine', '1', '', '2026-07-22 18:54:30'),
(46, 5, 19, 'Entrees', '1', '', '2026-07-22 18:54:30'),
(47, 5, 20, 'Non-Veg Main Course', '1', '', '2026-07-22 18:54:30'),
(48, 5, 20, 'Non-Veg Starter', '1', '', '2026-07-22 18:54:30'),
(49, 5, 20, 'Veg Main Course', '1', '', '2026-07-22 18:54:30'),
(50, 5, 20, 'Veg Starter', '1', '', '2026-07-22 18:54:30'),
(51, 5, 21, 'Platters', '1', '', '2026-07-22 18:54:30'),
(52, 5, 22, 'Sea Food', '1', '', '2026-07-22 18:54:30'),
(53, 5, 23, 'Side Dishes', '1', '', '2026-07-22 18:54:30'),
(54, 5, 24, 'Black Perch Signature', '1', '', '2026-07-22 18:54:30'),
(55, 5, 25, 'Swahili Dishes', '1', '', '2026-07-22 18:54:30'),
(56, 6, 26, 'Burgers', '1', '', '2026-07-22 18:54:30'),
(57, 6, 26, 'Pizzas', '1', '', '2026-07-22 18:54:30'),
(58, 6, 26, 'Sandwiches', '1', '', '2026-07-22 18:54:30'),
(59, 7, 27, 'Soft Drink', '1', '', '2026-07-22 18:54:30'),
(60, 3, 28, 'Milkshakes', '1', '', '2026-07-22 18:54:30'),
(61, 3, 28, 'Smoothies', '1', '', '2026-07-22 18:54:30');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `cat_id` int(11) NOT NULL,
  `cat_name` varchar(255) NOT NULL,
  `cat_status` enum('0','1') NOT NULL DEFAULT '1',
  `cat_image` varchar(255) NOT NULL,
  `cat_tstamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`cat_id`, `cat_name`, `cat_status`, `cat_image`, `cat_tstamp`) VALUES
(1, 'Appetizers and Soups', '1', 'appetizers.webp', '2026-07-19 14:48:39'),
(2, 'Breakfast', '1', 'breakfast.webp', '2026-07-20 14:48:39'),
(3, 'Coffee Shop and Ice Cream', '1', 'coffee.webp', '2026-07-21 14:48:39'),
(4, 'Happy Hour', '1', 'happy_hour.webp', '2026-07-22 14:48:39'),
(5, 'Main Course', '1', 'swahili_dishes.webp', '2026-07-23 14:48:39'),
(6, 'Pizza, Burgers and Sandwiches', '1', 'pizzas.webp', '2026-07-24 14:48:39'),
(7, 'Soft Drinks', '1', 'soft_drink.webp', '2026-07-25 14:48:39');

-- --------------------------------------------------------

--
-- Table structure for table `favourites`
--

CREATE TABLE `favourites` (
  `fav_id` int(11) NOT NULL,
  `fav_user_id` int(11) NOT NULL,
  `fav_item_id` int(11) NOT NULL,
  `fav_tstamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `item_id` int(11) NOT NULL,
  `item_cat_id` int(11) NOT NULL,
  `item_subcat_id` int(11) NOT NULL,
  `item_brand_id` int(11) NOT NULL,
  `item_name` varchar(255) NOT NULL,
  `item_time` varchar(50) NOT NULL DEFAULT '25',
  `item_rating` varchar(5) NOT NULL DEFAULT '4.6',
  `item_review` int(11) NOT NULL DEFAULT 140,
  `item_image` varchar(255) NOT NULL,
  `item_status` enum('0','1') NOT NULL DEFAULT '1',
  `item_price` varchar(11) NOT NULL,
  `item_description` text NOT NULL,
  `item_tstamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`item_id`, `item_cat_id`, `item_subcat_id`, `item_brand_id`, `item_name`, `item_time`, `item_rating`, `item_review`, `item_image`, `item_status`, `item_price`, `item_description`, `item_tstamp`) VALUES
(1, 2, 2, 2, 'Black Perch Breakfast', '15', '4.7', 318, 'breakfast.webp', '1', '500', 'Sautéed liver, soft chapati, fresh spinach, eggs your way, fruit juice.', '0000-00-00 00:00:00'),
(2, 2, 2, 2, 'English Breakfast', '15', '4.8', 242, 'breakfast.webp', '1', '650', 'Coffee, eggs, bacon, baked beans, grilled vegetables, toast.', '0000-00-00 00:00:00'),
(3, 2, 2, 2, 'Granola in Yoghurt', '5', '4.5', 205, 'granola_yoghurt.webp', '1', '350', 'Crunchy granola with smooth yoghurt, fresh fruits, and honey.', '0000-00-00 00:00:00'),
(4, 2, 2, 2, 'Uji Power', '5', '4.4', 431, 'uji_power.webp', '1', '200', 'Nutritious uji power porridge.', '0000-00-00 00:00:00'),
(5, 2, 2, 2, 'Fruit Salad', '5', '4.7', 163, 'fruit_salad.webp', '1', '400', 'Seasonal fruits with ice cream / yoghurt, nuts, honey, sauce of choice.', '0000-00-00 00:00:00'),
(6, 1, 1, 3, 'Beef Samosa (2 pcs)', '12', '4.4', 254, 'beef_samosa.webp', '1', '150', 'Crispy golden samosas filled with seasoned beef mince, onions, and fresh coriander', '0000-00-00 00:00:00'),
(7, 1, 1, 3, 'Beef Sausages (2 pcs)', '12', '4.7', 490, 'beef_sausages.webp', '1', '200', 'Deep fried beef sausages served with a Cole slaw salad', '0000-00-00 00:00:00'),
(8, 1, 1, 3, 'Crispy Fried Drumstick', '12', '4.9', 124, 'crispy_fried_drumsticks.webp', '1', '500', 'Well marinated chicken drumstick, coated with bread crumbs then deep fried', '0000-00-00 00:00:00'),
(9, 1, 1, 3, 'Chicken Lollipop', '12', '4.4', 180, 'chicken_lollipops.webp', '1', '500', 'Crispy chicken lollipops marinated in garlic, ginger, soy, coated with bread crumbs then deep fried', '0000-00-00 00:00:00'),
(10, 1, 1, 3, 'BBQ Chicken Wings', '12', '4.4', 282, 'bbq_chicken_wings.webp', '1', '500', 'Sticky, smoky BBQ glazed chicken wings served hot', '0000-00-00 00:00:00'),
(11, 1, 1, 3, 'Char-Grilled Drumstick', '12', '4.4', 189, 'char_grilled_drumsticks.webp', '1', '300', 'Juicy tender chicken drumstick marinated in aromatic herbs, grilled to perfection for a smoky charred finish', '0000-00-00 00:00:00'),
(12, 1, 1, 3, 'Choma Sausage (1 pc)', '12', '4.7', 483, 'choma_sausages.webp', '1', '150', 'Grilled sausage', '0000-00-00 00:00:00'),
(13, 1, 1, 3, 'Beef Kebab', '12', '4.5', 127, 'beef_kebabs.webp', '1', '300', 'Deep fried beef kebabs seasoned with spices, herbs, and onions', '0000-00-00 00:00:00'),
(14, 1, 1, 3, 'Fish Goujons / Fingers', '12', '4.7', 443, 'fish_fingers.webp', '1', '700', 'Crispy golden fish fingers served with lemon and dipping sauce', '0000-00-00 00:00:00'),
(15, 1, 1, 3, 'Mutura', '12', '4.2', 391, 'mutura.webp', '1', '150', 'Traditional Kenyan sausage', '0000-00-00 00:00:00'),
(16, 1, 1, 1, 'Grilled Chicken Salad', '6', '4.2', 339, 'grilled_chicken_salad.webp', '1', '700', 'Herb marinated grilled chicken breast served on crisp lettuce with fresh tomato, cucumber and lemon olive dressing', '0000-00-00 00:00:00'),
(17, 1, 1, 1, 'Avocado Salad', '6', '4.4', 126, 'avocado_salad.webp', '1', '400', 'Fresh avocado slices tossed with crisp lettuce, tomato, cucumber, red onion, lemon dressing and olive oil', '0000-00-00 00:00:00'),
(18, 1, 1, 1, 'Greek Salad', '6', '4.8', 155, 'greek_salad.webp', '1', '600', 'Classic Greek salad with fresh tomato, cucumber, capsicum, red onion, feta cheese, olives and oregano dressing', '0000-00-00 00:00:00'),
(19, 1, 1, 1, 'Caesar Salad', '6', '4.9', 402, 'caesar_salad.webp', '1', '600', 'Crisp romaine lettuce tossed with croutons, parmesan cheese and classic Caesar dressing', '0000-00-00 00:00:00'),
(20, 1, 1, 2, 'Cream of Butternut Squash Soup', '10', '4.4', 143, 'creamy_butter_squash_soup.webp', '1', '400', 'Smooth creamy soup of roasted butternut squash finished with fresh cream and a touch of ginger', '0000-00-00 00:00:00'),
(21, 1, 1, 2, 'Bone Soup', '10', '4.5', 245, 'bone_soup.webp', '1', '200', 'Rich and flavorful bone broth simmered with fresh veges and herbs', '0000-00-00 00:00:00'),
(22, 1, 1, 2, 'Perch Special Bone Soup', '10', '4.5', 476, 'bone_soup.webp', '1', '500', 'Rich and flavorful bone broth with a piece of Ossobuco simmered with fresh veges and herbs.', '0000-00-00 00:00:00'),
(23, 1, 1, 2, 'Perch Special Chicken Soup', '10', '4.4', 432, 'chicken_soup.webp', '1', '200', 'Clear chicken soup simmered with veges, ginger and herbs<br><br>', '0000-00-00 00:00:00'),
(24, 1, 1, 2, 'Pastina Chicken Soup', '10', '4.2', 273, 'chicken_soup.webp', '1', '400', 'Flavorful chicken broth simmered with delicate pastina pasta, fresh vegs and aromatic herbs', '0000-00-00 00:00:00'),
(25, 5, 24, 54, 'Kienyeji Chicken Wet / Dry Fry', '25', '4.7', 340, 'kienyeji_chicken_wet_dry_fry.webp', '1', '500', 'Authentic free-range chicken prepared wet or dry style', '0000-00-00 00:00:00'),
(26, 5, 24, 54, 'Broiler Chicken Wet / Dry Fry', '25', '4.5', 477, 'broiler_chicken_wet_dry_fry.webp', '1', '400', 'Tender broiler chicken prepared wet or dry style', '0000-00-00 00:00:00'),
(27, 5, 24, 54, 'Grilled Chicken', '25', '4.6', 159, 'grilled_chicken.webp', '1', '750', 'Succulent grilled chicken', '0000-00-00 00:00:00'),
(28, 5, 24, 54, 'Beef Wet Fry / Dry Fry', '25', '4.3', 452, 'beef_wet_fry_dry_fry.webp', '1', '300', 'Tender beef prepared wet or dry style', '0000-00-00 00:00:00'),
(29, 5, 24, 54, 'Goat Wet Fry / Dry Fry', '25', '4.3', 307, 'goat_wet_fry_dry_fry.webp', '1', '300', 'Tender goat meat prepared wet or dry style', '0000-00-00 00:00:00'),
(30, 5, 24, 54, 'Mbuzi Choma', '25', '4.4', 328, 'mbuzi_choma.webp', '1', '600', 'Grilled goat meat, Kenyan style', '0000-00-00 00:00:00'),
(31, 5, 24, 54, 'Grilled Beef Hump (Nundu)', '25', '4.7', 323, 'grilled_beef_hump_(nundu).webp', '1', '700', 'Tender grilled beef hump', '0000-00-00 00:00:00'),
(32, 5, 24, 54, 'Antitheft (Beef Flakes)', '25', '4.9', 439, 'antitheft_(feef_flakes).webp', '1', '900', 'Special seasoned beef flakes', '0000-00-00 00:00:00'),
(33, 5, 24, 54, 'Muguna Special ? Liver Wet / Dry Fry', '25', '4.6', 396, 'muguna_special-liver_wet_dry_fry.webp', '1', '250', 'Spiced liver prepared wet or dry style', '0000-00-00 00:00:00'),
(34, 5, 24, 54, 'Matumbo Wet / Dry Fry', '25', '4.5', 346, 'matumbo_wet_dry_fry.webp', '1', '250', 'Tripe prepared wet or dry style', '0000-00-00 00:00:00'),
(35, 5, 19, 46, 'Chicken Stroganoff', '20', '4.2', 355, 'chicken_stroganoff.webp', '1', '750', 'Creamy chicken stroganoff with mushrooms, onions and paprika in a rich cream sauce', '0000-00-00 00:00:00'),
(36, 5, 19, 46, 'Meru Range Beef Fillet', '20', '4.7', 248, 'meru_range_beef_fillet.webp', '1', '800', 'Juicy grilled beef fillet finished with garlic butter and fresh herbs', '0000-00-00 00:00:00'),
(37, 5, 19, 46, 'Beef Sirloin Steak', '20', '4.3', 398, 'beef_sirloin_steak.webp', '1', '1,000', 'Grilled beef sirloin steak finished with garlic butter and fresh herbs', '0000-00-00 00:00:00'),
(38, 5, 19, 46, 'Lamb Chops', '20', '4.7', 155, 'lamb_chops.webp', '1', '900', 'Juicy lamb chops grilled and finished with garlic butter and fresh herbs', '0000-00-00 00:00:00'),
(39, 5, 19, 46, 'Pork Loin Chops', '20', '4.7', 200, 'pork_loin_chops.webp', '1', '900', 'Juicy pork loin chops grilled and finished with garlic butter and fresh herbs', '0000-00-00 00:00:00'),
(40, 5, 19, 46, 'Pasta Alla Bolognese', '20', '4.4', 130, 'pasta_alla_bolognese.webp', '1', '600', 'Classic spaghetti tossed in a rich beef Bolognese sauce, finished with herbs', '0000-00-00 00:00:00'),
(41, 5, 19, 46, 'Githeri Minji', '20', '4.8', 150, 'githeri.webp', '1', '250', 'Traditional Kenyan beans and corn dish', '0000-00-00 00:00:00'),
(42, 5, 22, 42, 'English Style Tilapia Fillet', '25', '4.6', 429, 'english_style_tilapia_fillet.webp', '1', '600', 'Fresh fish fillet grilled to perfection with garlic, lemon, and fresh herbs', '0000-00-00 00:00:00'),
(43, 5, 22, 42, 'Whole Tilapia (Wet / Dry / Coconut / Deep Fry)', '25', '4.4', 265, 'whole_tilapia.webp', '1', '350', 'Fresh whole tilapia cooked to perfection with garlic, lemon, and fresh herbs', '0000-00-00 00:00:00'),
(44, 5, 22, 42, 'Samaki wa Kupaka', '25', '4.6', 402, 'samaki_wa_kupaka.webp', '1', '600', 'Swahili-style fish in rich coconut sauce', '0000-00-00 00:00:00'),
(45, 5, 20, 48, 'Chilli Chicken', '25', '4.9', 206, 'chilli_chicken.webp', '1', '600', 'Chicken breast cut into cubes, fried in onion, capsicum and green chili', '0000-00-00 00:00:00'),
(46, 5, 20, 48, 'Chicken Tikka', '25', '4.6', 453, 'chicken_tikka.webp', '1', '800', 'Half chicken marinated in yogurt served with salad, mint and hot sauce', '0000-00-00 00:00:00'),
(47, 5, 20, 47, 'Masala Chicken', '25', '4.3', 372, 'masala_chicken.webp', '1', '600', 'Chicken breast cubes cooked in a smooth Indian gravy', '0000-00-00 00:00:00'),
(48, 5, 20, 47, 'Chicken Hariyali', '25', '4.4', 287, 'chicken_hariyali.webp', '1', '650', 'Chicken breast cubes cooked in cashew nuts gravy with mint, tomato and onions', '0000-00-00 00:00:00'),
(49, 5, 20, 47, 'Fish Curry', '25', '4.6', 153, '', '1', '600', 'Marinated grilled fish cooked in a smooth tomato gravy and fresh cream', '0000-00-00 00:00:00'),
(50, 5, 20, 47, 'Chicken Curry', '25', '4.9', 254, 'chicken_curry.webp', '1', '600', 'Boneless chicken cuts cooked in Indian spices and fresh cream', '0000-00-00 00:00:00'),
(51, 5, 20, 47, 'Kashmir Mutton Roganjosh', '25', '4.5', 253, 'kashmir_mutton_roganjosh.webp', '1', '500', 'Fresh mutton chunks in bone with aromatic spices in tomato gravy', '0000-00-00 00:00:00'),
(52, 5, 20, 50, 'Crispy Papadum', '25', '4.7', 472, '', '1', '100', 'Fried, roasted and masala papadum', '0000-00-00 00:00:00'),
(53, 5, 20, 50, 'Pousin Chips', '25', '4.4', 481, '', '1', '300', 'Chipped potatoes in pousin sauce', '0000-00-00 00:00:00'),
(54, 5, 20, 50, 'Kaju Masala', '25', '4.8', 320, '', '1', '650', 'Cashew nuts in gravy or tossed in chilies and capsicum', '0000-00-00 00:00:00'),
(55, 5, 20, 50, 'Chili Paneer', '25', '4.9', 354, '', '1', '750', 'Cottage cheese tossed in capsicum, and onions served dry or in gravy', '0000-00-00 00:00:00'),
(56, 5, 20, 50, 'Paneer Tikka', '25', '4.6', 383, '', '1', '750', 'Cottage cheese marinated in yogurt served with salad and hot sauce', '0000-00-00 00:00:00'),
(57, 5, 20, 49, 'Mutter Paneer', '25', '4.7', 257, '', '1', '800', 'Paneer and peas cooked in gravy seasoned to taste', '0000-00-00 00:00:00'),
(58, 5, 20, 49, 'Malai Kofta', '25', '4.6', 153, '', '1', '800', 'Kofta made up of paneer and cashew nuts cooked in yellow gravy', '0000-00-00 00:00:00'),
(59, 5, 20, 49, 'Aaj Ki Subji', '25', '4.8', 172, '', '1', '600', 'The seasonal vegetables cooked with cumin, yogurt and spices', '0000-00-00 00:00:00'),
(60, 5, 20, 49, 'Dal Makhani', '25', '4.4', 316, '', '1', '650', 'Red kidney beans, black lentils and yellow split bean cooked tender in spices', '0000-00-00 00:00:00'),
(61, 5, 25, 55, 'Beef Pilau', '30', '4.4', 174, 'beef_pilau.webp', '1', '600', 'Fragrant pilau rice cooked with tender beef, pilau spices, onions, garlic, and fresh coriander', '0000-00-00 00:00:00'),
(62, 5, 25, 55, 'Biriani ya Mbuzi', '30', '4.8', 445, 'biriani_ya_mbuzi.webp', '1', '800', 'Fragrant basmati rice cooked with tender goat meat and biriani spices', '0000-00-00 00:00:00'),
(63, 5, 25, 55, 'Maharagwe ya Nazi na Chapati', '30', '4.3', 215, 'maharagwe_ya_nazi_na_chapati.webp', '1', '400', 'Slow cooked beans in creamy coconut sauce served with soft chapatti', '0000-00-00 00:00:00'),
(64, 5, 25, 55, 'Viazi Karai', '30', '4.5', 466, 'Viazi_Karai.webp', '1', '350', 'Golden fried potatoes coated in spiced gram flour batter', '0000-00-00 00:00:00'),
(65, 5, 21, 51, 'Mixed Grill Platter (3 pax)', '35', '4.6', 295, 'mixed_grill_platter.webp', '1', '3,200', 'Grilled chicken (1/2), beef (300g), mbuzi choma (1/2) and sausages (2 pcs) served with fries or wedges, fresh kachumbari and BBQ sauce', '0000-00-00 00:00:00'),
(66, 5, 21, 51, 'Meru Special Platter (5 pax)', '35', '4.6', 135, 'meru_special_platter.webp', '1', '4,200', 'Grilled chicken 1 full, sirloin steak (350g), pork chops (300g) and sausages (2 pairs) served with ugali, fries or wedges, greens, fresh kachumbari and pepper sauce', '0000-00-00 00:00:00'),
(67, 5, 21, 51, 'Wicked Perch Platter (8 pax)', '35', '4.6', 458, 'wicked_perch_platter.webp', '1', '10,000', 'Mbuzi choma (2kg), tender beef fillet (600g), grilled chicken (1.5), and sausages (3 pair) served with ugali, fries or wedges, rice, greens, fresh kachumbari and pepper sauce', '0000-00-00 00:00:00'),
(68, 5, 23, 53, 'Plain Fries', '10', '4.9', 496, 'plain_fries.webp', '1', '200', '', '0000-00-00 00:00:00'),
(69, 5, 23, 53, 'Chips Masala', '10', '4.3', 494, 'chips_masala.webp', '1', '300', '', '0000-00-00 00:00:00'),
(70, 5, 23, 53, 'Plain Rice', '10', '4.6', 183, 'plain_rice.webp', '1', '150', '', '0000-00-00 00:00:00'),
(71, 5, 23, 53, 'Vegetable Rice', '10', '4.9', 437, 'vegetable_rice.webp', '1', '200', '', '0000-00-00 00:00:00'),
(72, 5, 23, 53, 'Mashed Potato', '10', '4.3', 194, 'mashed_potato.webp', '1', '250', '', '0000-00-00 00:00:00'),
(73, 5, 23, 53, 'Chapatti', '10', '4.9', 474, 'chapatti.webp', '1', '100', '', '0000-00-00 00:00:00'),
(74, 5, 23, 53, 'Potato Wedges', '10', '4.2', 268, 'potato_wedges.webp', '1', '300', '', '0000-00-00 00:00:00'),
(75, 5, 23, 53, 'Roast Potatoes', '10', '4.5', 496, 'roast_potatoes.webp', '1', '300', '', '0000-00-00 00:00:00'),
(76, 5, 23, 53, 'Mukimo', '10', '4.8', 248, 'mukimo.webp', '1', '250', '', '0000-00-00 00:00:00'),
(77, 5, 23, 53, 'Ugali', '10', '4.7', 361, 'ugali.webp', '1', '100', '', '0000-00-00 00:00:00'),
(78, 5, 23, 53, 'Saute Potatoes', '10', '4.6', 249, 'saute_potatoes.webp', '1', '300', '', '0000-00-00 00:00:00'),
(79, 5, 23, 53, 'Mixed Veges', '10', '4.9', 433, 'mixed_veges.webp', '1', '200', '', '0000-00-00 00:00:00'),
(80, 5, 23, 53, 'Kachumbari', '10', '4.3', 257, 'kachumbari.webp', '1', '100', '', '0000-00-00 00:00:00'),
(81, 5, 23, 53, 'Guacamole', '10', '4.8', 409, 'guacamole.webp', '1', '250', '', '0000-00-00 00:00:00'),
(82, 5, 23, 53, 'Naan Bread', '10', '4.5', 496, 'naan_bread.webp', '1', '200', '', '0000-00-00 00:00:00'),
(83, 5, 23, 53, 'Cheese Naan', '10', '4.3', 252, 'cheese_naan.webp', '1', '500', '', '0000-00-00 00:00:00'),
(84, 5, 23, 53, 'Tawa / Phulka / Missi Roti', '10', '4.8', 175, 'Tawa_phulka_missi_roti.webp', '1', '150', '', '0000-00-00 00:00:00'),
(85, 5, 23, 53, 'Jeera Rice', '10', '4.8', 450, 'jeera_rice.webp', '1', '250', '', '0000-00-00 00:00:00'),
(86, 6, 26, 56, 'BBQ Chicken Burger', '12', '4.6', 120, 'bbq_chicken_burger.webp', '1', '700', 'Grilled BBQ chicken breast served in a soft bun with fresh lettuce, tomato, and onions', '0000-00-00 00:00:00'),
(87, 6, 26, 56, 'Mighty King Burger (Beef)', '12', '4.4', 489, 'mighty_king_burger_(beef).webp', '1', '950', 'Juicy double beef patty served in a soft bun with fresh lettuce, tomato, onions, and house sauce', '0000-00-00 00:00:00'),
(88, 6, 26, 56, 'Beef Burger', '12', '4.5', 308, 'beef_burger.webp', '1', '750', 'Juicy grilled beef patty served in a soft bun with fresh lettuce, tomato, onions, and house sauce', '0000-00-00 00:00:00'),
(89, 6, 26, 58, 'Ham and Cheese Sandwich', '10', '4.8', 207, 'ham_cheese_sandwich.webp', '1', '550', 'Classic ham and cheese sandwich layered with fresh lettuce, tomato, and creamy mayo', '0000-00-00 00:00:00'),
(90, 6, 26, 58, 'Beef Sandwich', '10', '4.6', 241, 'beef_sandwich.webp', '1', '600', 'Fresh beef sandwich with sliced beef, lettuce, tomato, onion, and creamy dressing', '0000-00-00 00:00:00'),
(91, 6, 26, 57, 'Margherita Pizza', '18', '4.6', 181, 'margherita_pizza.webp', '1', '700', 'Classic Margherita pizza with homemade tomato sauce, fresh mozzarella, olive oil, and basil', '0000-00-00 00:00:00'),
(92, 6, 26, 57, 'Grilled Chicken Pizza', '18', '4.5', 274, 'grilled_chicken_pizza.webp', '1', '900', 'Stone-baked pizza topped with grilled chicken, mozzarella cheese, fresh vegetables and herb tomato sauce', '0000-00-00 00:00:00'),
(93, 6, 26, 57, 'Hawaiian Chicken Pizza', '18', '4.3', 432, 'hawaiian_chicken_pizza.webp', '1', '1,000', 'Stone-baked pizza topped with grilled chicken, mozzarella cheese, pineapple, fresh vegetables and herb tomato sauce', '0000-00-00 00:00:00'),
(94, 6, 26, 57, 'Hawaiian Beef Pizza', '18', '4.3', 474, 'hawaiian_beef_pizza.webp', '1', '1,000', 'Stone-baked pizza topped with grilled beef, mozzarella cheese, pineapple, fresh vegetables and herb tomato sauce', '0000-00-00 00:00:00'),
(95, 6, 26, 57, 'Meat Lovers Pizza', '18', '4.9', 291, 'meat_lovers_pizza.webp', '1', '1,200', 'Hearty pizza loaded with beef, chicken, sausage, mozzarella cheese and fresh vegetables', '0000-00-00 00:00:00'),
(96, 6, 26, 57, 'Sausage Pizza', '18', '4.9', 489, 'Sausage Pizza.webp', '1', '800', 'Stone-baked pizza topped with sausage slices, mozzarella cheese, fresh vegetables and herb tomato sauce', '0000-00-00 00:00:00'),
(97, 3, 3, 5, 'The Perch Black', '4', '4.9', 327, '', '1', '350', 'Espresso poured over tonic water.', '0000-00-00 00:00:00'),
(98, 3, 3, 5, 'Velvet Fog', '4', '4.2', 258, '', '1', '350', 'Lavender honey latte made with oat milk.', '0000-00-00 00:00:00'),
(99, 3, 3, 5, 'Amber Wing', '4', '4.8', 405, '', '1', '350', 'Iced espresso shaken with maple and cinnamon.', '0000-00-00 00:00:00'),
(100, 3, 3, 5, 'Dirty Chai', '4', '4.7', 296, 'dirty_chai.webp', '1', '350', 'Masala chai blended with espresso and steamed milk.', '0000-00-00 00:00:00'),
(101, 3, 3, 7, 'Espresso (Single)', '4', '4.6', 184, 'espresso_(single).webp', '1', '150', 'A single concentrated shot of pure espresso.', '0000-00-00 00:00:00'),
(102, 3, 3, 7, 'Espresso (Double)', '4', '4.6', 158, 'espresso_(double).webp', '1', '200', 'A double shot with a bolder, richer flavor.', '0000-00-00 00:00:00'),
(103, 3, 3, 7, 'Americano', '4', '4.3', 414, 'americano.webp', '1', '250', 'Espresso topped with hot water.', '0000-00-00 00:00:00'),
(104, 3, 3, 7, 'Macchiato', '4', '4.3', 226, 'macchiato.webp', '1', '250', 'Espresso marked with a dollop of foam.', '0000-00-00 00:00:00'),
(105, 3, 3, 7, 'Cortado', '4', '4.2', 358, 'cortado.webp', '1', '200', 'Equal parts espresso and steamed milk.', '0000-00-00 00:00:00'),
(106, 3, 3, 7, 'Flat White / White Coffee', '4', '4.5', 299, 'flat_white_white_coffee.webp', '1', '250', 'Velvety steamed milk over a double espresso.', '0000-00-00 00:00:00'),
(107, 3, 3, 7, 'Cappuccino Single', '4', '4.9', 374, 'cappuccino_single.webp', '1', '250', 'Espresso with steamed milk and thick foam.', '0000-00-00 00:00:00'),
(108, 3, 3, 7, 'Cappuccino Double', '4', '4.5', 359, 'cappuccino_double.webp', '1', '350', 'Stronger cappuccino with double espresso and creamy milk foam.', '0000-00-00 00:00:00'),
(109, 3, 3, 7, 'Latte', '4', '4.4', 407, 'latte.webp', '1', '300', 'Espresso with steamed milk and light foam.', '0000-00-00 00:00:00'),
(110, 3, 3, 7, 'Mocha', '4', '4.6', 284, 'mocha.webp', '1', '350', 'Espresso mixed with chocolate and steamed milk.', '0000-00-00 00:00:00'),
(111, 3, 3, 7, 'Affogato', '4', '4.7', 442, 'affogato.webp', '1', '400', 'Vanilla ice cream drowned in espresso.', '0000-00-00 00:00:00'),
(112, 3, 3, 7, 'Vanilla Latte', '4', '4.4', 478, 'vanilla_latte.webp', '1', '350', 'Espresso with steamed milk and light foam flavoured with vanilla syrup.', '0000-00-00 00:00:00'),
(113, 3, 3, 7, 'Caramel Latte', '4', '4.6', 293, 'caramel_latte.webp', '1', '350', 'Espresso with steamed milk and light foam flavoured with caramel syrup.', '0000-00-00 00:00:00'),
(114, 3, 3, 7, 'Hazelnut Latte', '4', '4.4', 294, 'hazelnut_latte.webp', '1', '350', 'Espresso with steamed milk and light foam flavoured with hazelnut syrup.', '0000-00-00 00:00:00'),
(115, 3, 3, 7, 'Coconut Latte', '4', '4.5', 145, 'coconut_latte.webp', '1', '350', 'Espresso with steamed milk and light foam flavoured with coconut syrup.', '0000-00-00 00:00:00'),
(116, 3, 3, 7, 'Peppermint Latte', '4', '4.6', 186, 'peppermint latte.webp', '1', '350', 'Espresso with steamed milk and light foam flavoured with peppermint syrup.', '0000-00-00 00:00:00'),
(117, 3, 3, 7, 'Latte Macchiato', '4', '4.3', 256, 'latte_macchiato.webp', '1', '300', 'Steamed milk marked with espresso on top.', '0000-00-00 00:00:00'),
(118, 3, 3, 6, 'Pour Over (V60 / Chemex)', '4', '4.5', 464, 'pour_over_(V60_chemex).webp', '1', '350', 'Hand-brewed filter coffee with clarity and brightness.', '0000-00-00 00:00:00'),
(119, 3, 3, 6, 'French Press', '4', '4.7', 220, 'french_press.webp', '1', '350', 'Bold, full-bodied coffee steeped to perfection.', '0000-00-00 00:00:00'),
(120, 3, 3, 6, 'Cold Brew', '4', '4.6', 176, 'cold_brew.webp', '1', '350', 'Slow-steeped coffee served chilled, smooth and low-acid.', '0000-00-00 00:00:00'),
(121, 3, 3, 8, 'Matcha Latte', '4', '4.9', 490, 'matcha_latte.webp', '1', '300', 'Japanese matcha whisked with steamed milk.', '0000-00-00 00:00:00'),
(122, 3, 3, 8, 'Chai Latte', '4', '4.6', 480, 'chai_latte.webp', '1', '250', 'Spiced Kenyan chai blended with steamed milk.', '0000-00-00 00:00:00'),
(123, 3, 3, 8, 'Hot Chocolate', '4', '4.3', 205, 'hot_chocolate.webp', '1', '200', 'Rich chocolate drink topped with foam.', '0000-00-00 00:00:00'),
(124, 3, 3, 8, 'Tea (Black / Green / Herbal)', '4', '4.5', 500, 'tea_(black_green_herbal).webp', '1', '300', 'Black, green, or herbal tea options.', '0000-00-00 00:00:00'),
(125, 3, 5, 13, 'Vanilla Scoop', '3', '4.6', 487, 'vanilla_scoop.webp', '1', '350', '', '0000-00-00 00:00:00'),
(126, 3, 5, 13, 'Strawberry Scoop', '3', '4.8', 139, 'strawberry_scoop.webp', '1', '350', '', '0000-00-00 00:00:00'),
(127, 3, 5, 13, 'Chocolate Scoop', '3', '4.8', 488, 'chocolate_scoop.webp', '1', '350', '', '0000-00-00 00:00:00'),
(128, 3, 5, 13, 'Mango Scoop', '3', '4.7', 240, 'mango_scoop.webp', '1', '350', '', '0000-00-00 00:00:00'),
(129, 3, 5, 14, 'Chocolate Sundae', '3', '4.4', 483, 'chocolate_sundae.webp', '1', '450', '', '0000-00-00 00:00:00'),
(130, 3, 5, 14, 'Caramel Sundae', '3', '4.5', 139, 'caramel_sundae.webp', '1', '450', '', '0000-00-00 00:00:00'),
(131, 3, 5, 14, 'Strawberry Sundae', '3', '4.7', 279, 'strawberry_sundae.webp', '1', '450', '', '0000-00-00 00:00:00'),
(132, 3, 6, 15, 'Classic Virgin Mojito', '5', '4.5', 384, 'classic_virgin_mojito.webp', '1', '350', 'Mint leaves, lime, sugar syrup, soda water.', '0000-00-00 00:00:00'),
(133, 3, 6, 15, 'Ginger Virgin Mojito', '5', '4.4', 226, 'ginger_virgin_mojito.webp', '1', '400', 'Fresh ginger, mint, lime, sugar syrup, soda.', '0000-00-00 00:00:00'),
(134, 3, 6, 15, 'Mint and Lime Cooler', '5', '4.4', 153, 'Mint_&_lime_cooler.webp', '1', '350', 'Extra mint, lime wedges, sugar syrup, soda water.', '0000-00-00 00:00:00'),
(135, 3, 6, 17, 'Strawberry Virgin Mojito', '5', '4.9', 127, 'strawberry_virgin_mojito.webp', '1', '400', 'Muddled strawberries, mint, lime, Sprite.', '0000-00-00 00:00:00'),
(136, 3, 6, 17, 'Passion Fruit Virgin Mojito', '5', '4.6', 405, 'passion_fruit_virgin_mojito.webp', '1', '400', 'Fresh passion fruit pulp, mint, lime, Sprite.', '0000-00-00 00:00:00'),
(137, 3, 6, 17, 'Pineapple Virgin Mojito', '5', '4.6', 151, 'pineapple_virgin_mojito.webp', '1', '400', 'Pineapple juice, mint, lime, Sprite.', '0000-00-00 00:00:00'),
(138, 3, 6, 17, 'Mango Virgin Mojito', '5', '4.5', 407, 'mango_virgin_mojito.webp', '1', '500', 'Mango puree, mint, lime, Sprite.', '0000-00-00 00:00:00'),
(139, 3, 6, 17, 'Watermelon Virgin Mojito', '5', '4.5', 354, 'watermelon_virgin_mojito.webp', '1', '500', 'Fresh watermelon juice, mint, lime, Sprite.', '0000-00-00 00:00:00'),
(140, 3, 6, 17, 'Blueberry Virgin Mojito', '5', '4.8', 151, 'blueberry_virgin_mojito.webp', '1', '500', 'Muddled blueberries, mint, lime, Sprite.', '0000-00-00 00:00:00'),
(141, 3, 6, 17, 'Raspberry Virgin Mojito', '5', '4.3', 298, 'raspberry_virgin_mojito.webp', '1', '500', 'Raspberries, mint, lime, Sprite.', '0000-00-00 00:00:00'),
(142, 3, 6, 17, 'Mixed Berry Mojito', '5', '4.4', 262, 'mixed_berry_mojito.webp', '1', '500', 'Blueberry, raspberry and strawberry mix, mint, lime, Sprite.', '0000-00-00 00:00:00'),
(143, 3, 6, 18, 'Tropical Fusion Mojito', '5', '4.2', 395, 'tropical_fusion_mojito.webp', '1', '500', 'Mango, pineapple, passion fruit blend, mint, lime, soda.', '0000-00-00 00:00:00'),
(144, 3, 6, 18, 'Kiwi Virgin Mojito', '5', '4.9', 276, 'kiwi_virgin_mojito.webp', '1', '500', 'Fresh kiwi, mint, lime, soda.', '0000-00-00 00:00:00'),
(145, 3, 6, 18, 'Cucumber Mint Mojito', '5', '4.2', 280, 'cucumber_mint_mojito.webp', '1', '500', 'Cucumber slices, mint, lime, soda.', '0000-00-00 00:00:00'),
(146, 3, 6, 18, 'Basil Lime Mojito', '5', '4.8', 363, 'basil_lime_mojito.webp', '1', '500', 'Fresh basil, mint, lime, soda.', '0000-00-00 00:00:00'),
(147, 3, 6, 18, 'Hibiscus Mojito', '5', '4.3', 139, 'hibiscus_mojito.webp', '1', '500', 'Hibiscus syrup, mint, lime, soda.', '0000-00-00 00:00:00'),
(148, 3, 6, 18, 'Apple Mojito', '5', '4.5', 317, 'apple_mojito.webp', '1', '500', 'Fresh apple juice, mint, lime, soda.', '0000-00-00 00:00:00'),
(149, 3, 6, 16, 'Virgin Colada', '5', '4.8', 481, 'virgin_colada.webp', '1', '500', 'Coconut cream, pineapple juice, coconut syrup, Pi?a Colada ice cream.', '0000-00-00 00:00:00'),
(150, 3, 6, 16, 'Strawberry Colada', '5', '4.3', 418, 'strawberry_colada.webp', '1', '500', 'Classic colada with strawberry twist.', '0000-00-00 00:00:00'),
(151, 3, 6, 16, 'Blueberry Colada', '5', '4.8', 327, 'blueberry_colada.webp', '1', '500', 'Classic colada with blueberry twist.', '0000-00-00 00:00:00'),
(152, 3, 6, 16, 'Kiwi Colada', '5', '4.9', 364, 'kiwi_colada.webp', '1', '500', 'Classic colada with kiwi twist.', '0000-00-00 00:00:00'),
(153, 3, 6, 16, 'Mango Colada', '5', '4.5', 216, 'mango_colada.webp', '1', '500', 'Classic colada with mango twist.', '0000-00-00 00:00:00'),
(154, 3, 6, 16, 'Peach Colada', '5', '4.4', 299, 'peach_colada.webp', '1', '500', 'Classic colada with peach twist.', '0000-00-00 00:00:00'),
(155, 3, 4, 11, 'Classic Coffee Frappe', '5', '4.4', 465, 'classic_coffee_frappe.webp', '1', '400', 'Blended coffee, milk, ice and sugar.', '0000-00-00 00:00:00'),
(156, 3, 4, 11, 'Caramel Coffee Frappe', '5', '4.8', 414, 'caramel_coffee_frappe.webp', '1', '400', 'Coffee frappe with rich caramel sauce.', '0000-00-00 00:00:00'),
(157, 3, 4, 11, 'Mocha Frappe', '5', '4.8', 121, 'mocha_frappe.webp', '1', '400', 'Coffee blended with chocolate and milk.', '0000-00-00 00:00:00'),
(158, 3, 4, 11, 'Vanilla Coffee Frappe', '5', '4.9', 325, 'vanilla_coffee_frappe.webp', '1', '400', 'Smooth coffee with sweet vanilla flavour.', '0000-00-00 00:00:00'),
(159, 3, 4, 11, 'Chocolate Frappe', '5', '4.6', 127, 'chocolate_frappe.webp', '1', '400', 'Rich chocolate blended with milk and ice.', '0000-00-00 00:00:00'),
(160, 3, 4, 11, 'Oreo Frappe', '5', '4.2', 161, 'oreo_frappe.webp', '1', '400', 'Chocolate frappe blended with crushed oreos.', '0000-00-00 00:00:00'),
(161, 3, 4, 11, 'Strawberry Frappe', '5', '4.9', 120, 'strawberry_frappe.webp', '1', '400', 'Fresh strawberry blended with milk and ice.', '0000-00-00 00:00:00'),
(162, 3, 4, 11, 'Nutella Frappe', '5', '4.2', 465, 'nutella_frappe.webp', '1', '400', 'Chocolate hazelnut blended into a creamy drink.', '0000-00-00 00:00:00'),
(163, 3, 4, 11, 'Mango Frappe', '5', '4.6', 216, 'mango_frappe.webp', '1', '400', 'Sweet mango blended with milk and ice.', '0000-00-00 00:00:00'),
(164, 3, 4, 11, 'Mixed Berry Frappe', '5', '4.9', 395, 'mixed_berry_frappe.webp', '1', '400', 'Berry blend for a sweet and tangy taste.', '0000-00-00 00:00:00'),
(165, 3, 4, 12, 'Blueberry Slush', '5', '4.6', 143, 'blueberry_slush.webp', '1', '300', '', '0000-00-00 00:00:00'),
(166, 3, 4, 12, 'Watermelon Slush', '5', '4.7', 304, 'watermelon_slush.webp', '1', '300', '', '0000-00-00 00:00:00'),
(167, 3, 4, 12, 'Mango Slush', '5', '4.7', 471, 'mango_slush.webp', '1', '300', '', '0000-00-00 00:00:00'),
(168, 3, 4, 12, 'Pineapple Slush', '5', '4.5', 229, 'pineapple_slush.webp', '1', '300', '', '0000-00-00 00:00:00'),
(169, 3, 4, 12, 'Strawberry Slush', '5', '4.8', 219, 'strawberry_slush.webp', '1', '300', '', '0000-00-00 00:00:00'),
(170, 3, 4, 12, 'Lemon Mint Slush', '5', '4.7', 442, 'lemon_mint_slush.webp', '1', '300', '', '0000-00-00 00:00:00'),
(171, 3, 4, 9, 'Raspberry Fruit Tea', '5', '4.5', 250, 'raspberry_fruit_tea.webp', '1', '450', 'Freshly brewed tea with raspberry fruit flavor.', '0000-00-00 00:00:00'),
(172, 3, 4, 9, 'Strawberry Fruit Tea', '5', '4.8', 143, 'strawberry_fruit_tea.webp', '1', '450', 'Freshly brewed tea with strawberry fruit flavor.', '0000-00-00 00:00:00'),
(173, 3, 4, 9, 'Blueberry Fruit Tea', '5', '4.6', 474, 'blueberry_fruit_tea.webp', '1', '450', 'Freshly brewed tea with blueberry fruit flavor.', '0000-00-00 00:00:00'),
(174, 3, 4, 9, 'Lemon Fruit Tea', '5', '4.7', 181, 'lemon_fruit_tea.webp', '1', '450', 'Freshly brewed tea with lemon fruit flavor.', '0000-00-00 00:00:00'),
(175, 3, 4, 9, 'Mango Fruit Tea', '5', '4.7', 189, 'mango_fruit_tea.webp', '1', '450', 'Freshly brewed tea with mango fruit flavor.', '0000-00-00 00:00:00'),
(176, 3, 4, 9, 'Passion Fruit Tea', '5', '4.4', 122, 'passion_fruit_tea.webp', '1', '450', 'Freshly brewed tea with passion fruit flavor.', '0000-00-00 00:00:00'),
(177, 3, 4, 9, 'Watermelon Fruit Tea', '5', '4.8', 455, 'watermelon_fruit_tea.webp', '1', '450', 'Freshly brewed tea with watermelon fruit flavor.', '0000-00-00 00:00:00'),
(178, 3, 4, 9, 'Peach Fruit Tea', '5', '4.8', 381, 'peach_fruit_tea.webp', '1', '450', 'Freshly brewed tea with peach fruit flavor.', '0000-00-00 00:00:00'),
(179, 3, 4, 9, 'Lychee Fruit Tea', '5', '4.4', 220, 'lychee_fruit_tea.webp', '1', '450', 'Freshly brewed tea with lychee fruit flavor.', '0000-00-00 00:00:00'),
(180, 3, 4, 10, 'Caramel Boba Milk Tea', '5', '4.8', 479, 'caramel_boba_milk_tea.webp', '1', '500', 'Creamy milk tea with caramel flavor.', '0000-00-00 00:00:00'),
(181, 3, 4, 10, 'Vanilla Boba Milk Tea', '5', '4.4', 156, 'vanilla_boba_milk_tea.webp', '1', '450', 'Creamy milk tea with vanilla flavor.', '0000-00-00 00:00:00'),
(182, 3, 4, 10, 'Blueberry Boba Milk Tea', '5', '4.3', 360, 'blueberry_boba_milk_tea.webp', '1', '450', 'Creamy milk tea with blueberry flavor.', '0000-00-00 00:00:00'),
(183, 3, 4, 10, 'Strawberry Boba Milk Tea', '5', '4.8', 350, 'strawberry_boba_milk_tea.webp', '1', '450', 'Creamy milk tea with strawberry flavor.', '0000-00-00 00:00:00'),
(184, 3, 4, 10, 'Matcha Boba Milk Tea', '5', '4.9', 232, 'matcha_boba_milk_tea.webp', '1', '450', 'Creamy milk tea with matcha flavor.', '0000-00-00 00:00:00'),
(185, 3, 4, 10, 'Lotus Biscoff Boba Milk Tea', '5', '4.2', 466, 'lotus_biscoff_boba_milk_tea.webp', '1', '640', 'Creamy milk tea with Lotus Biscoff flavor.', '0000-00-00 00:00:00'),
(186, 3, 4, 10, 'Taro Boba Milk Tea', '5', '4.6', 496, 'taro_boba_milk_tea.webp', '1', '450', 'Creamy milk tea with taro flavor.', '0000-00-00 00:00:00'),
(187, 3, 4, 10, 'Coffee Boba Milk Tea', '5', '4.3', 314, 'coffee_boba_milk_tea.webp', '1', '500', 'Creamy milk tea with coffee flavor.', '0000-00-00 00:00:00'),
(188, 3, 4, 10, 'Chocolate Boba Milk Tea', '5', '4.6', 122, 'chocolate_boba_milk_tea.webp', '1', '500', 'Creamy milk tea with chocolate flavor.', '0000-00-00 00:00:00'),
(189, 7, 27, 59, 'Black Perch Water 1ltr', '2', '4.8', 167, '', '1', '150', '', '0000-00-00 00:00:00'),
(190, 7, 27, 59, 'Soda 330ml', '2', '4.7', 411, '', '1', '100', '', '0000-00-00 00:00:00'),
(191, 7, 27, 59, 'Soda 500ml', '2', '4.7', 146, '', '1', '120', '', '0000-00-00 00:00:00'),
(192, 7, 27, 59, 'Delmonte 1Ltr', '2', '4.9', 301, 'delmonte_1ltr.webp', '1', '400', '', '0000-00-00 00:00:00'),
(193, 7, 27, 59, 'Keringet 1Ltr', '2', '4.4', 228, 'keringet_1ltr.webp', '1', '200', '', '0000-00-00 00:00:00'),
(194, 7, 27, 59, 'Keringet Spark 1 Ltr', '2', '4.5', 390, 'keringet_spark_1ltr.webp', '1', '300', '', '0000-00-00 00:00:00'),
(195, 7, 27, 59, 'Lime Juice 700ml', '2', '4.7', 215, '', '1', '300', '', '0000-00-00 00:00:00'),
(196, 7, 27, 59, 'Lime Juice 1500ml', '2', '4.8', 320, '', '1', '500', '', '0000-00-00 00:00:00'),
(197, 7, 27, 59, 'Red Bull', '2', '4.7', 381, 'red_bull.webp', '1', '400', '', '0000-00-00 00:00:00'),
(198, 7, 27, 59, 'Monster', '2', '4.3', 484, 'monster.webp', '1', '400', '', '0000-00-00 00:00:00'),
(199, 7, 27, 59, 'Redbull Watermelon', '2', '4.4', 440, 'redbull_watermelon.webp', '1', '400', '', '0000-00-00 00:00:00'),
(200, 4, 11, 26, 'Black Perch Sour', '2', '4.6', 229, '', '1', '800', 'Grenadine, orange juice, blue curacao, vodka, Sprite.', '0000-00-00 00:00:00'),
(201, 4, 11, 26, 'Midnight Tropic', '2', '4.5', 350, '', '1', '1,000', 'Amarula, coffee liqueur, vodka.', '0000-00-00 00:00:00'),
(202, 4, 11, 29, 'Mojito', '2', '4.8', 369, '', '1', '700', 'White rum, lime juice, sugar syrup, mint leaves, soda water, ice.', '0000-00-00 00:00:00'),
(203, 4, 11, 29, 'Pi?a Colada', '2', '4.8', 129, '', '1', '700', 'White rum, coconut cream, pineapple juice, ice.', '0000-00-00 00:00:00'),
(204, 4, 11, 29, 'Cuba Libre', '2', '4.5', 319, '', '1', '700', 'White rum, Coke, lime juice, ice.', '0000-00-00 00:00:00'),
(205, 4, 11, 29, 'Mai Tai', '2', '4.3', 157, '', '1', '800', 'White rum, dark rum, triple sec, sugar syrup, lime juice, ice.', '0000-00-00 00:00:00'),
(206, 4, 11, 29, 'Daiquiri', '2', '4.4', 477, 'daiquiri.webp', '1', '700', 'White rum, lime juice, sugar syrup, ice.', '0000-00-00 00:00:00'),
(207, 4, 11, 29, 'Dark \'n\' Stormy', '2', '4.3', 134, 'dark_n_stormy.webp', '1', '700', 'Dark rum, ginger beer, lime juice, ice.', '0000-00-00 00:00:00'),
(208, 4, 11, 29, 'Malindi Breeze', '2', '4.7', 427, '', '1', '700', 'White rum, vodka, lime, sugar syrup, tea, ice.', '0000-00-00 00:00:00'),
(209, 4, 11, 31, 'Cosmopolitan', '2', '4.6', 341, '', '1', '700', 'Vodka, triple sec, lime juice, cranberry juice.', '0000-00-00 00:00:00'),
(210, 4, 11, 31, 'Sex on the Beach', '2', '4.7', 476, '', '1', '800', 'Vodka, peach schnapps, orange juice, cranberry juice, ice.', '0000-00-00 00:00:00'),
(211, 4, 11, 31, 'Moscow Mule', '2', '4.2', 206, '', '1', '700', 'Vodka, ginger beer, lime juice, ice.', '0000-00-00 00:00:00'),
(212, 4, 11, 31, 'Long Island Iced Tea', '2', '4.6', 348, 'long_island.webp', '1', '1,000', 'Vodka, tequila, gin, rum, triple sec, Coke, sugar syrup, ice.', '0000-00-00 00:00:00'),
(213, 4, 11, 30, 'Margarita', '2', '4.6', 262, '', '1', '700', 'Tequila, triple sec, lime juice, sugar syrup, ice.', '0000-00-00 00:00:00'),
(214, 4, 11, 30, 'Tequila Sunrise', '2', '4.3', 491, '', '1', '700', 'Tequila, orange juice, grenadine, ice.', '0000-00-00 00:00:00'),
(215, 4, 11, 30, 'Brave Bull', '2', '4.2', 373, '', '1', '800', 'Tequila blanco, Kahlua, ice.', '0000-00-00 00:00:00'),
(216, 4, 11, 28, 'Martini', '2', '4.2', 463, 'matini.webp', '1', '700', 'Gin, dry vermouth, orange slice, ice.', '0000-00-00 00:00:00'),
(217, 4, 11, 28, 'French 75', '2', '4.3', 462, 'french_75.webp', '1', '800', 'Gin, lemon, sugar syrup, sparkling wine, ice.', '0000-00-00 00:00:00'),
(218, 4, 11, 28, 'Gin Fizz', '2', '4.5', 355, 'gin_fizz.webp', '1', '700', 'Gin, lime, sugar syrup, ice, egg white (optional).', '0000-00-00 00:00:00'),
(219, 4, 11, 33, 'Mimosa', '2', '4.8', 359, 'mimosa.webp', '1', '800', 'Orange juice, sparkling wine, orange slice.', '0000-00-00 00:00:00'),
(220, 4, 11, 33, 'Aperol Spritz', '2', '4.6', 175, 'aperal_spritz.webp', '1', '700', 'Sparkling wine, Aperol, soda water, orange slice, ice.', '0000-00-00 00:00:00'),
(221, 4, 11, 33, 'New York Sour', '2', '4.5', 325, 'new_york_sour.webp', '1', '800', 'Bourbon, lime juice, orange bitters, sugar syrup, red wine.', '0000-00-00 00:00:00'),
(222, 4, 11, 32, 'Old Fashioned', '2', '4.2', 243, 'old_fashioned.webp', '1', '800', 'Whiskey, sugar, bitters, water, orange garnish.', '0000-00-00 00:00:00'),
(223, 4, 11, 32, 'Whiskey Sour', '2', '4.7', 310, '', '1', '700', 'Whiskey, lemon juice, sugar syrup, ice.', '0000-00-00 00:00:00'),
(224, 4, 11, 32, 'Manhattan', '2', '4.4', 310, 'manhattan.webp', '1', '800', 'Rye whiskey, sweet vermouth, Angostura bitters.', '0000-00-00 00:00:00'),
(225, 4, 11, 32, 'Blood and Sand', '2', '4.6', 420, '', '1', '800', 'Scotch whiskey, red vermouth, cherry brandy, orange juice.', '0000-00-00 00:00:00'),
(226, 4, 11, 32, 'Rob Roy', '2', '4.2', 435, '', '1', '700', 'Scotch whiskey, red vermouth, Angostura bitters.', '0000-00-00 00:00:00'),
(227, 4, 11, 32, 'Smoky Whiskey Sour', '2', '4.8', 387, 'smoky_sour.webp', '1', '700', 'Whiskey, lemon, maple syrup, egg, Angostura bitters.', '0000-00-00 00:00:00'),
(228, 4, 11, 32, 'Weng Weng', '2', '4.3', 443, '', '1', '1,500', 'Vodka, tequila, brandy, bourbon, scotch, rum, orange, pineapple, grenadine.', '0000-00-00 00:00:00'),
(229, 4, 11, 27, 'Irish Coffee', '2', '4.9', 239, 'irish_coffee.webp', '1', '700', 'Irish whiskey, hot coffee, brown sugar, fresh cream.', '0000-00-00 00:00:00'),
(230, 4, 11, 27, 'Black Russian', '2', '4.5', 303, '', '1', '700', 'Vodka, coffee liqueur.', '0000-00-00 00:00:00'),
(231, 4, 11, 27, 'White Russian', '2', '4.7', 350, '', '1', '700', 'Vodka, coffee liqueur, fresh cream.', '0000-00-00 00:00:00'),
(232, 4, 11, 27, 'Espresso Martini', '2', '4.5', 354, '', '1', '800', 'Vodka, fresh espresso, coffee liqueur, simple syrup.', '0000-00-00 00:00:00'),
(233, 4, 11, 27, 'Mudslide', '2', '4.7', 486, '', '1', '800', 'Vodka, coffee liqueur, Irish cream.', '0000-00-00 00:00:00'),
(234, 4, 11, 27, 'Coffee Negroni', '2', '4.6', 243, '', '1', '700', 'Gin, sweet vermouth, coffee liqueur, Campari.', '0000-00-00 00:00:00'),
(235, 4, 11, 27, 'Cafe Amore', '2', '4.6', 184, '', '1', '700', 'Brandy, coffee, amaretto, whipped cream.', '0000-00-00 00:00:00'),
(236, 4, 11, 27, 'Revolver', '2', '4.6', 465, '', '1', '700', 'Bourbon, coffee liqueur, orange bitters.', '0000-00-00 00:00:00'),
(237, 4, 11, 25, 'Strawberry Daiquiri Slush', '2', '4.8', 390, 'strawberry_daiquiri_splush.webp', '1', '800', 'Strawberry, rum, lime ? frozen daiquiri.', '0000-00-00 00:00:00'),
(238, 4, 11, 25, 'Mango Margarita Slush', '2', '4.3', 370, '', '1', '800', 'Mango, lime, tequila ? frozen margarita.', '0000-00-00 00:00:00'),
(239, 4, 11, 25, 'Tropical Rum Slush', '2', '4.4', 473, '', '1', '800', 'Rum, pineapple, citrus ? tropical frozen blend.', '0000-00-00 00:00:00'),
(240, 4, 11, 25, 'Blue Lagoon Slush', '2', '4.9', 328, '', '1', '800', 'Citrus, blue curacao, vodka ? vibrant frozen cocktail.', '0000-00-00 00:00:00'),
(241, 4, 11, 25, 'Passion Fruit Slush', '2', '4.4', 466, '', '1', '800', 'Passion fruit, rum ? sweet and tangy frozen blend.', '0000-00-00 00:00:00'),
(242, 4, 11, 25, 'Watermelon Vodka Slush', '2', '4.9', 266, '', '1', '800', 'Watermelon, vodka, lime ? light refreshing frozen drink.', '0000-00-00 00:00:00'),
(243, 4, 10, 36, 'Tropical Vodka Sunrise Tower', '2', '4.3', 206, '', '1', '3,500', '500ml vodka, 800ml orange juice, 400ml pineapple juice, 100ml grenadine, Ice', '0000-00-00 00:00:00'),
(244, 4, 10, 36, 'Berry Blast Vodka Tower', '2', '4.9', 226, '', '1', '3,500', '500ml vodka, 600ml cranberry juice, 400ml berry puree, 200ml soda water, Ice', '0000-00-00 00:00:00'),
(245, 4, 10, 36, 'Citrus Vodka Cooler Tower', '2', '4.7', 301, '', '1', '3,500', '500ml vodka, 500ml lemonade, 300ml lime juice, 300ml soda water, Mint leaves, Ice', '0000-00-00 00:00:00'),
(246, 4, 10, 22, 'Classic Gin and Tonic Tower', '2', '4.4', 316, '', '1', '3,000', '500ml gin, 1L tonic water, 100ml lime juice, Cucumber slices, Ice', '0000-00-00 00:00:00'),
(247, 4, 10, 22, 'Pink Gin Spritz Tower', '2', '4.7', 130, '', '1', '3,000', '500ml gin, 500ml strawberry puree, 400ml lemonade, 200ml soda water, Ice', '0000-00-00 00:00:00'),
(248, 4, 10, 23, 'Caribbean Rum Punch Tower', '2', '4.4', 297, '', '1', '4,000', '500ml dark rum, 500ml pineapple juice, 400ml orange juice, 200ml lime juice, 100ml grenadine, Ice', '0000-00-00 00:00:00'),
(249, 4, 10, 23, 'Mojito Tower', '2', '4.4', 200, '', '1', '4,000', '500ml white rum, 1L soda water, 200ml lime juice, 150g sugar syrup, Mint leaves, Ice', '0000-00-00 00:00:00'),
(250, 4, 10, 23, 'Honey Whiskey Lemonade Tower', '2', '4.4', 378, '', '1', '4,000', '500ml whiskey, 700ml lemonade, 200ml fresh lemon juice, 150ml honey syrup, 300ml soda water, Ice', '0000-00-00 00:00:00'),
(251, 4, 10, 23, 'Whiskey Berry Smash Tower', '2', '4.9', 318, '', '1', '3,500', '500ml whiskey, 500ml cranberry juice, 300ml berry puree, 200ml lime juice, 300ml soda water, Mint leaves, Ice', '0000-00-00 00:00:00'),
(252, 4, 10, 23, 'Spiced Apple Whiskey Tower', '2', '4.5', 333, '', '1', '3,500', '500ml whiskey, 800ml apple juice, 200ml cinnamon syrup, 200ml lemon juice, Apple slices, Ice', '0000-00-00 00:00:00'),
(253, 4, 10, 23, 'Pina Tower', '2', '4.9', 269, '', '1', '4,000', '500ml rum, 600ml fresh pineapple juice, 90ml coconut syrup, Coconut cream, Ice', '0000-00-00 00:00:00'),
(254, 4, 10, 23, 'Smoky Citrus Whiskey Tower', '2', '4.3', 369, '', '1', '3,500', '500ml whiskey, 600ml orange juice, 300ml lemon juice, 200ml sugar syrup, 300ml soda water, Orange slices, Ice', '0000-00-00 00:00:00'),
(255, 4, 18, 44, '4Th Street', '2', '4.7', 343, '4th_street_red_750ml.webp', '1', '2,000', '750 ML', '0000-00-00 00:00:00'),
(256, 4, 18, 44, 'Caprice', '2', '4.4', 124, 'caprice_sweet_red_1l.webp', '1', '1,500', '1 LITRE', '0000-00-00 00:00:00'),
(257, 4, 18, 44, 'Casabuena', '2', '4.4', 223, 'casabuena_sweet_red_1l.webp', '1', '1,500', '1 LITRE', '0000-00-00 00:00:00'),
(258, 4, 18, 44, 'Cellar Cask JHB', '2', '4.3', 269, 'cellar_cask_jbh_red_750ml.webp', '1', '2,000', '750 ML', '0000-00-00 00:00:00'),
(259, 4, 18, 44, 'Rosso Nobile Chocolata', '2', '4.6', 462, 'rosso_nobile_chocolata_750ml.webp', '1', '3,500', '750 ML', '0000-00-00 00:00:00'),
(260, 4, 18, 44, 'Rosso Nobile Cherry', '2', '4.3', 136, 'rosso_nobile_cherry_750ml.webp', '1', '3,500', '750 ML', '0000-00-00 00:00:00'),
(261, 4, 18, 44, 'Drostdy Hof', '2', '4.3', 168, 'drostdy_hof_dry_red_750ml.webp', '1', '2,000', '750 ML', '0000-00-00 00:00:00'),
(262, 4, 18, 44, 'Four Cousins', '2', '4.8', 451, 'four_cousins_(red)_750ml.webp', '1', '2,000', '750 ML', '0000-00-00 00:00:00'),
(263, 4, 18, 44, 'Robertson', '2', '4.8', 212, 'robertson_red_750ml.webp', '1', '3,000', '750 ML', '0000-00-00 00:00:00'),
(264, 4, 18, 44, 'Robertson', '2', '4.7', 191, 'robertson_red_750ml.webp', '1', '5,500', '1,500 ML', '0000-00-00 00:00:00'),
(265, 4, 18, 44, 'Ascon', '2', '4.3', 490, 'ascon.webp', '1', '2,500', '750 ML', '0000-00-00 00:00:00'),
(266, 4, 18, 41, 'Caprice', '2', '4.7', 157, 'caprice_sweet_red_1l.webp', '1', '1,500', '1 LITRE', '0000-00-00 00:00:00'),
(267, 4, 18, 41, 'Nederburg Cabernet', '2', '4.6', 186, 'nederburg_cabernet.webp', '1', '3,500', '750 ML', '0000-00-00 00:00:00'),
(268, 4, 18, 41, 'Mucho ma\'s', '2', '4.8', 140, 'mucho_ma\'s.webp', '1', '4,000', '750 ML', '0000-00-00 00:00:00'),
(269, 4, 18, 41, 'Drostdy Hof', '2', '4.3', 356, 'drostdy_hof_dry_red_750ml.webp', '1', '2,000', '750 ML', '0000-00-00 00:00:00'),
(270, 4, 18, 41, 'Ascon', '2', '4.3', 275, 'ascon.webp', '1', '2,500', '750 ML', '0000-00-00 00:00:00'),
(271, 4, 18, 45, '4Th Street', '2', '4.3', 127, '4th_street_red_750ml.webp', '1', '2,000', '750 ML', '0000-00-00 00:00:00'),
(272, 4, 18, 45, 'Caprice', '2', '4.7', 235, 'caprice_sweet_red_1l.webp', '1', '1,500', '1 LITRE', '0000-00-00 00:00:00'),
(273, 4, 18, 45, 'Casabuena', '2', '4.3', 497, 'casabuena_sweet_red_1l.webp', '1', '1,500', '1 LITRE', '0000-00-00 00:00:00'),
(274, 4, 18, 45, 'Caprice', '2', '4.5', 168, 'caprice_sweet_red_1l.webp', '1', '1,500', '1 LITRE', '0000-00-00 00:00:00'),
(275, 4, 18, 45, 'Cellar Cask', '2', '4.8', 440, 'cellar_cask_jbh_red_750ml.webp', '1', '2,000', '750 ML', '0000-00-00 00:00:00'),
(276, 4, 18, 45, 'Drostdy Hof', '2', '4.9', 500, 'drostdy_hof_dry_red_750ml.webp', '1', '2,000', '750 ML', '0000-00-00 00:00:00'),
(277, 4, 18, 45, 'Four Cousins', '2', '4.6', 417, 'four_cousins_(red)_750ml.webp', '1', '2,000', '750 ML', '0000-00-00 00:00:00'),
(278, 4, 18, 45, 'Robertson', '2', '4.3', 294, 'robertson_red_750ml.webp', '1', '3,000', '750 ML', '0000-00-00 00:00:00'),
(279, 4, 18, 45, 'Robertson', '2', '4.6', 338, 'robertson_red_750ml.webp', '1', '5,500', '1,500 ML', '0000-00-00 00:00:00'),
(280, 4, 18, 45, 'Rosso Nobile Vanilla', '2', '4.9', 492, 'rosso_nobile_vanilla_750ml.webp', '1', '3,500', '750 ML', '0000-00-00 00:00:00'),
(281, 4, 18, 42, 'Caprice', '2', '4.3', 378, 'caprice_sweet_red_1l.webp', '1', '1,500', '1 LITRE', '0000-00-00 00:00:00'),
(282, 4, 18, 42, 'Drostdy Hof', '2', '4.5', 247, 'drostdy_hof_dry_red_750ml.webp', '1', '2,000', '750 ML', '0000-00-00 00:00:00'),
(283, 4, 18, 42, 'Moet', '2', '4.6', 407, 'moet.webp', '1', '15,000', '750 ML', '0000-00-00 00:00:00'),
(284, 4, 18, 42, 'Luke Belaire Gold', '2', '4.7', 147, 'luke_belaire_gold_750ml.webp', '1', '9,000', '750 ML', '0000-00-00 00:00:00'),
(285, 4, 18, 42, 'Luke Belaire Luxe', '2', '4.4', 287, 'luke_belaire_luxe_750ml.webp', '1', '9,000', '750 ML', '0000-00-00 00:00:00'),
(286, 4, 18, 42, 'Luke Belaire Luxe Rose', '2', '4.7', 391, 'luke_belair_luxe_rose_750ml.webp', '1', '9,000', '750 ML', '0000-00-00 00:00:00'),
(287, 4, 18, 43, 'Chamdor Red Wine', '2', '4.4', 483, 'chamdor_red.webp', '1', '2,500', '750 ML', '0000-00-00 00:00:00'),
(288, 4, 18, 43, 'Chamdor White Wine', '2', '4.7', 216, 'chamdor_white.webp', '1', '2,500', '750 ML', '0000-00-00 00:00:00'),
(289, 4, 8, 20, 'Balozi', '2', '4.5', 461, 'balozi.webp', '1', '300', '500 ML', '0000-00-00 00:00:00'),
(290, 4, 8, 20, 'Corona Extra Beer', '2', '4.8', 279, 'corona_extra_beer_330ml.webp', '1', '400', '330ML', '0000-00-00 00:00:00'),
(291, 4, 8, 20, 'Desparado Bottle', '2', '4.9', 237, 'desparado_bottle_330ml.webp', '1', '400', '330ML', '0000-00-00 00:00:00'),
(292, 4, 8, 20, 'Guiness Kubwa', '2', '4.3', 384, 'guiness_kubwa.webp', '1', '350', '500 ML', '0000-00-00 00:00:00'),
(293, 4, 8, 20, 'Guiness Smooth', '2', '4.8', 497, 'guiness_smooth.webp', '1', '300', '500 ML', '0000-00-00 00:00:00'),
(294, 4, 8, 20, 'Heineken Zero Bottle', '2', '4.4', 258, 'heineken_zero_bottle_330ml.webp', '1', '300', '330ML', '0000-00-00 00:00:00'),
(295, 4, 8, 20, 'Heineken', '2', '4.6', 309, 'heineken.webp', '1', '400', '330 ML', '0000-00-00 00:00:00'),
(296, 4, 8, 20, 'Hunters Cider Dry', '2', '4.8', 439, 'hunters_cider_dry_330ml.webp', '1', '350', '330ML', '0000-00-00 00:00:00'),
(297, 4, 8, 20, 'Hunters Cider Gold', '2', '4.7', 234, 'hunters_cider_gold_330ml.webp', '1', '350', '330ML', '0000-00-00 00:00:00'),
(298, 4, 8, 20, 'KO Cider', '2', '4.6', 141, 'ko_cider.webp', '1', '350', '330 ML', '0000-00-00 00:00:00'),
(299, 4, 8, 20, 'Kingfisher Strawberry', '2', '4.7', 161, 'kingfisher_strawberry.webp', '1', '300', '330 ML', '0000-00-00 00:00:00'),
(300, 4, 8, 20, 'Manyatta Pineapple', '2', '4.8', 221, 'manyatta_pineapple.webp', '1', '350', '330 ML', '0000-00-00 00:00:00'),
(301, 4, 8, 20, 'Pineapple Punch Bottle', '2', '4.2', 392, 'pineapple_punch_bottle.webp', '1', '300', '330 ML', '0000-00-00 00:00:00'),
(302, 4, 8, 20, 'Pilsner Bold', '2', '4.3', 314, 'pilsner_bold.webp', '1', '300', '500 ML', '0000-00-00 00:00:00'),
(303, 4, 8, 20, 'Pilsner Mfalme', '2', '4.7', 151, 'pilsner_mfalme.webp', '1', '300', '330 ML', '0000-00-00 00:00:00'),
(304, 4, 8, 20, 'Savanna', '2', '4.5', 406, 'savanna_330ml.webp', '1', '400', '330ML', '0000-00-00 00:00:00'),
(305, 4, 8, 20, 'Snapp Apple', '2', '4.4', 498, 'snapp_apple.webp', '1', '300', '330 ML', '0000-00-00 00:00:00'),
(306, 4, 8, 20, 'Smirnoff Ice Black', '2', '4.5', 135, 'smirnoff_ice_black_300ml.webp', '1', '300', '300ML', '2026-07-22 18:55:19'),
(307, 4, 8, 20, 'Tusker Ndimu', '2', '4.7', 241, 'tusker_ndimu.webp', '1', '300', '330 ML', '0000-00-00 00:00:00'),
(308, 4, 8, 20, 'Tusker Cider', '2', '4.3', 345, 'tusker_cider.webp', '1', '300', '500 ML', '0000-00-00 00:00:00'),
(309, 4, 8, 20, 'Tusker Lager', '2', '4.4', 272, 'tusker_lager.webp', '1', '300', '500 ML', '0000-00-00 00:00:00'),
(310, 4, 8, 20, 'Tusker Lite', '2', '4.3', 449, 'tusker_lite.webp', '1', '300', '330 ML', '0000-00-00 00:00:00'),
(311, 4, 8, 20, 'Tusker Malt', '2', '4.9', 305, 'tusker_malt.webp', '1', '300', '330 ML', '0000-00-00 00:00:00'),
(312, 4, 8, 20, 'White Cap Crisp', '2', '4.4', 441, 'white_cap_crisp.webp', '1', '300', '330 ML', '0000-00-00 00:00:00'),
(313, 4, 8, 20, 'White Cap Lager', '2', '4.2', 122, 'white_cap_lager.webp', '1', '300', '500 ML', '0000-00-00 00:00:00'),
(314, 4, 8, 20, 'Windhoek Draught Bottle', '2', '4.4', 137, 'windhoek_draught_bottle_330ml.webp', '1', '300', '330ML', '0000-00-00 00:00:00'),
(315, 4, 8, 20, 'Windhoek Lager Bottle', '2', '4.4', 334, 'windhoek_lager_bottle_330ml.webp', '1', '300', '330ML', '0000-00-00 00:00:00'),
(316, 4, 8, 20, 'Raspberry Bottle', '2', '4.5', 489, 'raspberry_bottle.webp', '1', '300', '330 ML', '0000-00-00 00:00:00'),
(317, 4, 7, 19, 'Balozi Can', '2', '4.8', 307, 'balozi_can.webp', '1', '300', '500 ML', '0000-00-00 00:00:00'),
(318, 4, 7, 19, 'Guarana Can', '2', '4.8', 448, 'guarana_can.webp', '1', '300', '330 ML', '0000-00-00 00:00:00'),
(319, 4, 7, 19, 'Guiness Kubwa Can', '2', '4.2', 285, 'guiness_kubwa_can.webp', '1', '350', '500 ML', '0000-00-00 00:00:00'),
(320, 4, 7, 19, 'Manyatta Can', '2', '4.2', 441, 'manyatta_can.webp', '1', '400', '330 ML', '0000-00-00 00:00:00'),
(321, 4, 7, 19, 'Pineapple Punch Can', '2', '4.4', 447, 'pineapple_punch_can.webp', '1', '300', '330 ML', '0000-00-00 00:00:00'),
(322, 4, 7, 19, 'Smirnoff Ice Black Can', '2', '4.8', 193, 'smirnoff_ice_black_can.webp', '1', '300', '330 ML', '0000-00-00 00:00:00'),
(323, 4, 7, 19, 'Snapp Apple Can', '2', '4.2', 462, 'snapp_apple_can.webp', '1', '300', '330 ML', '0000-00-00 00:00:00'),
(324, 4, 7, 19, 'Tusker Can', '2', '4.2', 318, 'tusker_cider_can.webp', '1', '350', '500 ML', '0000-00-00 00:00:00'),
(325, 4, 7, 19, 'Tusker Cider Can', '2', '4.8', 388, 'tusker_cider_can.webp', '1', '350', '500 ML', '0000-00-00 00:00:00'),
(326, 4, 7, 19, 'Tusker Lite Can', '2', '4.2', 324, 'tusker_lite_can.webp', '1', '350', '500 ML', '0000-00-00 00:00:00'),
(327, 4, 7, 19, 'Tusker Malt Can', '2', '4.4', 366, 'tusker_malt_can.webp', '1', '350', '500 ML', '0000-00-00 00:00:00'),
(328, 4, 7, 19, 'White Cap Can', '2', '4.7', 300, 'white_cap_can.webp', '1', '350', '500 ML', '0000-00-00 00:00:00'),
(329, 4, 7, 19, 'White Crips Can', '2', '4.9', 125, 'white_crips_can.webp', '1', '350', '330 ML', '0000-00-00 00:00:00'),
(330, 4, 7, 19, 'Bavarian Smalt', '2', '4.5', 354, 'bavarian_smalt.webp', '1', '200', '330 ML', '0000-00-00 00:00:00'),
(331, 4, 7, 19, 'Gordons Dry Can', '2', '4.6', 334, 'gordons_dry_can_500ml.webp', '1', '350', '500ML', '0000-00-00 00:00:00');
INSERT INTO `items` (`item_id`, `item_cat_id`, `item_subcat_id`, `item_brand_id`, `item_name`, `item_time`, `item_rating`, `item_review`, `item_image`, `item_status`, `item_price`, `item_description`, `item_tstamp`) VALUES
(332, 4, 7, 19, 'Gordons Pink Can', '2', '4.8', 484, 'gordons_pink_can_500ml.webp', '1', '350', '500ML', '0000-00-00 00:00:00'),
(333, 4, 7, 19, 'Pilsner Can', '2', '4.5', 369, 'pilsner_can.webp', '1', '350', '500 ML', '0000-00-00 00:00:00'),
(334, 4, 7, 19, 'Heineken Can', '2', '4.9', 155, 'heineken_can.webp', '1', '450', '500 ML', '0000-00-00 00:00:00'),
(335, 4, 7, 19, 'Ko Can', '2', '4.4', 317, 'ko_can.webp', '1', '350', '330 ML', '0000-00-00 00:00:00'),
(336, 4, 7, 19, 'Raspberry Ice Can', '2', '4.7', 130, 'raspberry_ice_can.webp', '1', '300', '330 ML', '0000-00-00 00:00:00'),
(337, 4, 7, 19, 'Alvaro', '2', '4.3', 139, 'alvaro.webp', '1', '200', '330 ML', '0000-00-00 00:00:00'),
(338, 4, 13, 36, 'Absolute Vodka', '2', '4.3', 358, 'absolute_vodka_1ltr.webp', '1', '4,000', '1 LITRE', '0000-00-00 00:00:00'),
(339, 4, 13, 36, 'Absolute Vodka', '2', '4.7', 172, 'absolute_vodka_1ltr.webp', '1', '3,000', '750 ML', '0000-00-00 00:00:00'),
(340, 4, 13, 36, 'Smirnoff Vodka', '2', '4.3', 468, 'smirnoff_vodka_1ltr.webp', '1', '3,500', '1 LITRE', '0000-00-00 00:00:00'),
(341, 4, 13, 36, 'Smirnoff Vodka', '2', '4.9', 410, 'smirnoff_vodka_1ltr.webp', '1', '2,500', '750 ML', '0000-00-00 00:00:00'),
(342, 4, 13, 36, 'Ciroc Vodka', '2', '4.7', 218, 'ciroc_vodka.webp', '1', '7,000', '750 ML', '0000-00-00 00:00:00'),
(343, 4, 13, 35, 'Gilbey S Gin', '2', '4.8', 380, 'gilbeys_gin_750ml.webp', '1', '2,500', '750 ML', '0000-00-00 00:00:00'),
(344, 4, 13, 35, 'Gordons Clear', '2', '4.9', 200, 'gordons_clear_1ltr.webp', '1', '3,500', '750 ML', '0000-00-00 00:00:00'),
(345, 4, 13, 35, 'Gordons Pink', '2', '4.4', 464, 'gordons_pink_1ltr.webp', '1', '3,500', '750 ML', '0000-00-00 00:00:00'),
(346, 4, 13, 35, 'Gordons Clear', '2', '4.9', 196, 'gordons_clear_1ltr.webp', '1', '5,000', '1 LITRE', '0000-00-00 00:00:00'),
(347, 4, 13, 35, 'Gordons Pink', '2', '4.5', 237, 'gordons_pink_1ltr.webp', '1', '5,000', '1 LITRE', '0000-00-00 00:00:00'),
(348, 4, 13, 35, 'Gordons Orange', '2', '4.7', 273, 'gordons_orange_700ml.webp', '1', '5,000', '700 ML', '0000-00-00 00:00:00'),
(349, 4, 13, 35, 'Hendricks Gin', '2', '4.7', 444, 'hendricks_gin_1ltr.webp', '1', '8,000', '700 ML', '0000-00-00 00:00:00'),
(350, 4, 13, 35, 'Hendricks Gin', '2', '4.3', 472, 'hendricks_gin_1ltr.webp', '1', '10,000', '1 LITRE', '0000-00-00 00:00:00'),
(351, 4, 13, 35, 'Malty', '2', '4.7', 146, 'malty_750ml.webp', '1', '6,500', '750 ML', '0000-00-00 00:00:00'),
(352, 4, 13, 35, 'Tangueray London Dry', '2', '4.7', 404, 'tangueray_london_dry.webp', '1', '4,500', '750ML', '0000-00-00 00:00:00'),
(353, 4, 13, 35, 'Tangueray London Dry', '2', '4.4', 165, 'tangueray_london_dry.webp', '1', '8,500', '1 LITRE', '0000-00-00 00:00:00'),
(354, 4, 13, 35, 'Tanguery Ten', '2', '4.5', 357, 'tanguery_ten.webp', '1', '7,000', '750 ML', '0000-00-00 00:00:00'),
(355, 4, 13, 35, 'Tanguery Ten', '2', '4.6', 417, 'tanguery_ten.webp', '1', '9,000', '1 LITRE', '0000-00-00 00:00:00'),
(356, 4, 13, 35, 'Tanguery Sevilla', '2', '4.7', 231, 'tanguery_sevilla_750ml.webp', '1', '6,500', '750 ML', '0000-00-00 00:00:00'),
(357, 4, 17, 40, 'Ballantine', '2', '4.7', 202, 'ballantine_1ltr.webp', '1', '4,500', '1 LITRE', '0000-00-00 00:00:00'),
(358, 4, 17, 40, 'Ballantine', '2', '4.9', 392, 'ballantine_1ltr.webp', '1', '3,500', '750 ML', '0000-00-00 00:00:00'),
(359, 4, 17, 40, 'Beefeater Gin', '2', '4.4', 195, 'beefeater _original_gin_750ml.webp', '1', '3,000', '1 LITRE', '0000-00-00 00:00:00'),
(360, 4, 17, 40, 'Beefeater Original Gin', '2', '4.6', 346, 'beefeater _original_gin_750ml.webp', '1', '3,000', '750 ML', '0000-00-00 00:00:00'),
(361, 4, 17, 40, 'Black and White', '2', '4.7', 384, 'black_white.webp', '1', '2,000', '750 ML', '0000-00-00 00:00:00'),
(362, 4, 17, 40, 'Bullet Bourbon', '2', '4.7', 208, 'bullet_bourbon.webp', '1', '6,000', '750 ML', '0000-00-00 00:00:00'),
(363, 4, 17, 40, 'Famous Grouse', '2', '4.4', 492, 'famouse_grouse_1ltr.webp', '1', '3,500', '750 ML', '0000-00-00 00:00:00'),
(364, 4, 17, 40, 'Famous Grouse', '2', '4.7', 500, 'famouse_grouse_1ltr.webp', '1', '4,500', '1 LITRE', '0000-00-00 00:00:00'),
(365, 4, 17, 40, 'Glenlivet 12yrs', '2', '4.6', 233, 'glenlivet_15yrs.webp', '1', '11,000', '750 ML', '0000-00-00 00:00:00'),
(366, 4, 17, 40, 'Glenlivet 15yrs', '2', '4.5', 372, 'glenlivet_15yrs.webp', '1', '14,000', '750 ML', '0000-00-00 00:00:00'),
(367, 4, 17, 40, 'Glenlivet 18yrs', '2', '4.3', 477, 'glenlivet_18yrs.webp', '1', '20,000', '750 ML', '0000-00-00 00:00:00'),
(368, 4, 17, 40, 'Glenlivet Founders', '2', '4.2', 389, 'glenlivet_founders_1ltr.webp', '1', '8,000', '750 ML', '0000-00-00 00:00:00'),
(369, 4, 17, 40, 'Glenfindich 12yrs', '2', '4.4', 486, 'glenfindich_12yrs.webp', '1', '10,000', '750 ML', '0000-00-00 00:00:00'),
(370, 4, 17, 40, 'Glenfindich 15yrs', '2', '4.7', 246, 'glenfindich_15yrs.webp', '1', '15,000', '750 ML', '0000-00-00 00:00:00'),
(371, 4, 17, 40, 'Glenfindich 18yrs', '2', '4.8', 188, 'glenfindich_18yrs.webp', '1', '20,000', '750 ML', '0000-00-00 00:00:00'),
(372, 4, 17, 40, 'Grants', '2', '4.7', 459, 'grants_1ltr.webp', '1', '5,000', '1 LITRE', '0000-00-00 00:00:00'),
(373, 4, 17, 40, 'Grants', '2', '4.7', 312, 'grants_1ltr.webp', '1', '3,500', '750 ML', '0000-00-00 00:00:00'),
(374, 4, 17, 40, 'Grayson', '2', '4.4', 268, 'grayson_750ml.webp', '1', '2,500', '750 ML', '0000-00-00 00:00:00'),
(375, 4, 17, 40, 'Jack Daniels', '2', '4.5', 370, 'jack_daniels _700ml.webp', '1', '6,000', '1 LITRE', '0000-00-00 00:00:00'),
(376, 4, 17, 40, 'Jack Daniels Single Barrel', '2', '4.8', 304, 'jack_daniels_single_barrel.webp', '1', '10,000', '700 ML', '0000-00-00 00:00:00'),
(377, 4, 17, 40, 'Jack Daniels', '2', '4.9', 162, 'jack_daniels _700ml.webp', '1', '5,000', '700 ML', '0000-00-00 00:00:00'),
(378, 4, 17, 40, 'Jack Daniels Honey', '2', '4.5', 345, 'jack_daniels_honey_1litre.webp', '1', '5,000', '1 LITRE', '0000-00-00 00:00:00'),
(379, 4, 17, 40, 'Jack Daniels Fire', '2', '4.7', 184, 'jack_daniels_fire_750ml.webp', '1', '5,000', '700 ML', '0000-00-00 00:00:00'),
(380, 4, 17, 40, 'Jack Daniels Honey', '2', '4.8', 172, 'jack_daniels_honey_1litre.webp', '1', '5,000', '700 ML', '0000-00-00 00:00:00'),
(381, 4, 17, 40, 'Jameson', '2', '4.7', 385, 'jameson_1ltr.webp', '1', '5,000', '1 LITRE', '0000-00-00 00:00:00'),
(382, 4, 17, 40, 'Jameson Black Barrel', '2', '4.5', 493, 'jameson_black_barrel_750ml.webp', '1', '6,500', '750 ML', '0000-00-00 00:00:00'),
(383, 4, 17, 40, 'Jameson', '2', '4.3', 326, 'jameson_1ltr.webp', '1', '4,000', '750 ML', '0000-00-00 00:00:00'),
(384, 4, 17, 40, 'Jw Black', '2', '4.6', 304, 'jw_black_1_ltr.webp', '1', '6,500', '1 LITRE', '0000-00-00 00:00:00'),
(385, 4, 17, 40, 'Jw Black', '2', '4.6', 390, 'jw_black_1_ltr.webp', '1', '3,000', '375 ML', '0000-00-00 00:00:00'),
(386, 4, 17, 40, 'Jw Black', '2', '4.7', 230, 'jw_black_1_ltr.webp', '1', '5,500', '750 ML', '0000-00-00 00:00:00'),
(387, 4, 17, 40, 'John Barr Black', '2', '4.7', 446, 'john_barr_black_1litre.webp', '1', '3,000', '750 ML', '0000-00-00 00:00:00'),
(388, 4, 17, 40, 'John Barr Black', '2', '4.7', 274, 'john_barr_black_1litre.webp', '1', '3,500', '1 LITRE', '0000-00-00 00:00:00'),
(389, 4, 17, 40, 'John Barr Red', '2', '4.5', 173, 'john_barr_red_750ml.webp', '1', '2,500', '750 ML', '0000-00-00 00:00:00'),
(390, 4, 17, 40, 'John Barr Red', '2', '4.4', 181, 'john_barr_red_750ml.webp', '1', '3,000', '1 LITRE', '0000-00-00 00:00:00'),
(391, 4, 17, 40, 'Jw Blonde', '2', '4.5', 421, 'jw_blonde_750ml.webp', '1', '3,500', '750 ML', '0000-00-00 00:00:00'),
(392, 4, 17, 40, 'Jw Blue', '2', '4.4', 197, 'jw_blue_750ml.webp', '1', '47,000', '750 ML', '0000-00-00 00:00:00'),
(393, 4, 17, 40, 'Jw Double Black', '2', '4.5', 225, 'jw_double_black_1ltr.webp', '1', '9,500', '1 LITRE', '0000-00-00 00:00:00'),
(394, 4, 17, 40, 'Jw Double Black', '2', '4.6', 280, 'jw_double_black_1ltr.webp', '1', '7,000', '750 ML', '0000-00-00 00:00:00'),
(395, 4, 17, 40, 'JW Gold reserve', '2', '4.3', 152, 'jw_gold_reserve.webp', '1', '12,000', '750 ML', '0000-00-00 00:00:00'),
(396, 4, 17, 40, 'JW Green Label', '2', '4.7', 497, 'jw_green_label.webp', '1', '12,000', '750 ML', '0000-00-00 00:00:00'),
(397, 4, 17, 40, 'Jw KGV', '2', '4.6', 426, 'jw_kgv_750ml.webp', '1', '130,000', '750 ML', '0000-00-00 00:00:00'),
(398, 4, 17, 40, 'Jw Red', '2', '4.7', 445, 'jw_red_1ltr.webp', '1', '4,000', '1 LITRE', '0000-00-00 00:00:00'),
(399, 4, 17, 40, 'Jw Red', '2', '4.3', 414, 'jw_red_1ltr.webp', '1', '2,000', '375 ML', '0000-00-00 00:00:00'),
(400, 4, 17, 40, 'Jw Red 750Ml', '2', '4.3', 162, 'jw_red_375ml.webp', '1', '3,500', '750 ML', '0000-00-00 00:00:00'),
(401, 4, 17, 40, 'Roe and Co', '2', '4.5', 411, 'roe_&_co.webp', '1', '6,500', '750 ML', '0000-00-00 00:00:00'),
(402, 4, 17, 40, 'Singleton 12Yrs', '2', '4.6', 459, 'singleton_12yrs_700ml.webp', '1', '8,500', '700 ML', '0000-00-00 00:00:00'),
(403, 4, 17, 40, 'Singleton 15Yrs 700Ml', '2', '4.4', 177, 'singleton_15yrs_700ml.webp', '1', '10,500', '700 ML', '0000-00-00 00:00:00'),
(404, 4, 17, 40, 'Singleton 18Yrs', '2', '4.5', 128, 'singleton_18yrs_700ml.webp', '1', '15,000', '700 ML', '0000-00-00 00:00:00'),
(405, 4, 17, 40, 'Southern Comfort', '2', '4.4', 197, 'southern_comfort_1ltr.webp', '1', '4,000', '750 ML', '0000-00-00 00:00:00'),
(406, 4, 17, 40, 'Southern Comfort', '2', '4.6', 203, 'southern_comfort_1ltr.webp', '1', '5,000', '1 LITRE', '0000-00-00 00:00:00'),
(407, 4, 17, 40, 'VAT 69', '2', '4.6', 222, 'vat_69_375ml.webp', '1', '1,500', '375 ML', '0000-00-00 00:00:00'),
(408, 4, 17, 40, 'VAT 69 750 ML', '2', '4.5', 229, 'vat_69_750ml.webp', '1', '2,500', '750 ML', '0000-00-00 00:00:00'),
(409, 4, 17, 40, 'William Lawson', '2', '4.4', 132, 'william_lawson_1ltr.webp', '1', '4,000', '1 LITRE', '0000-00-00 00:00:00'),
(410, 4, 17, 40, 'William Lawson', '2', '4.4', 338, 'william_lawson_1ltr.webp', '1', '3,000', '750 ML', '0000-00-00 00:00:00'),
(411, 4, 17, 40, 'Jack Daniels', '2', '4.9', 285, 'jack_daniels _700ml.webp', '1', '9,000', '1 LITRE', '0000-00-00 00:00:00'),
(412, 4, 17, 40, 'Ballantines 10yrs', '2', '4.4', 347, 'ballantines_10yrs_750ml.webp', '1', '6,000', '750 ML', '0000-00-00 00:00:00'),
(413, 4, 17, 40, 'Glenlivet 12yrs', '2', '4.4', 221, 'glenlivet_15yrs.webp', '1', '15,000', '1 LITRE', '0000-00-00 00:00:00'),
(414, 4, 17, 40, 'Glenlivet Founders', '2', '4.3', 332, 'glenlivet_founders_1ltr.webp', '1', '15,000', '1 LITRE', '0000-00-00 00:00:00'),
(415, 4, 17, 40, 'Cragganmore', '2', '4.3', 336, 'cragganmore_750ml.webp', '1', '8,500', '750 ML', '0000-00-00 00:00:00'),
(416, 4, 12, 34, 'Dusse Vsop', '2', '4.5', 202, 'dusse_vsop_750ml.webp', '1', '18,000', '750 ML', '0000-00-00 00:00:00'),
(417, 4, 12, 34, 'Hennessy Vs', '2', '4.8', 226, 'hennessy vs_1ltr.webp', '1', '8,000', '750 ML', '0000-00-00 00:00:00'),
(418, 4, 12, 34, 'Hennessy Vs 1Ltr', '2', '4.3', 350, 'hennessy vs_1ltr.webp', '1', '14,000', '1 LITRE', '0000-00-00 00:00:00'),
(419, 4, 12, 34, 'Hennessy Vsop', '2', '4.5', 130, 'hennessy vsop_700ml.webp', '1', '13,000', '700 ML', '0000-00-00 00:00:00'),
(420, 4, 12, 34, 'Hennessy Vsop', '2', '4.3', 494, 'hennessy vsop_700ml.webp', '1', '18,000', '1 LITRE', '0000-00-00 00:00:00'),
(421, 4, 12, 34, 'Martel Blueswift', '2', '4.7', 198, 'martel_blueswift_700ml.webp', '1', '14,000', '700 ML', '0000-00-00 00:00:00'),
(422, 4, 12, 34, 'Martel Vs', '2', '4.8', 293, 'martel_vs_1ltr.webp', '1', '8,000', '750 ML', '0000-00-00 00:00:00'),
(423, 4, 12, 34, 'Martel Vs', '2', '4.6', 174, 'martel_vs_1ltr.webp', '1', '12,000', '1 LITRE', '0000-00-00 00:00:00'),
(424, 4, 12, 34, 'Martel Vsop', '2', '4.6', 420, 'martel_vsop_1ltr.webp', '1', '12,000', '750 ML', '0000-00-00 00:00:00'),
(425, 4, 12, 34, 'Martel Vsop', '2', '4.8', 223, 'martel_vsop_1ltr.webp', '1', '18,000', '1 LITRE', '0000-00-00 00:00:00'),
(426, 4, 12, 34, 'Martel Xo', '2', '4.7', 238, 'martel_xo_700ml.webp', '1', '46,000', '700 ML', '0000-00-00 00:00:00'),
(427, 4, 12, 34, 'Martini Rosso Vermouth', '2', '4.8', 177, 'martini_rosso_vermouth_750ml.webp', '1', '3,500', '750 ML', '0000-00-00 00:00:00'),
(428, 4, 12, 34, 'Macallan 12yrs', '2', '4.8', 150, 'macallan_12yrs_750ml.webp', '1', '28,000', '750 ML', '0000-00-00 00:00:00'),
(429, 4, 12, 34, 'Macallan 15yrs', '2', '4.8', 400, 'macallan_15yrs_750ml.webp', '1', '55,000', '750 ML', '0000-00-00 00:00:00'),
(430, 4, 12, 34, 'Remy Martin VSOP', '2', '4.3', 295, 'remy_martin_vsop_700ml.webp', '1', '12,000', '700 ML', '0000-00-00 00:00:00'),
(431, 4, 12, 34, 'Remy Martin', '2', '4.6', 423, 'remy_martin_1ltr.webp', '1', '18,000', '1 LITRE', '0000-00-00 00:00:00'),
(432, 4, 12, 34, 'Havana Club Rhum ANCJO 3 YEARS OLD 40%', '2', '4.6', 254, 'havana_club_rhum_ancjo.webp', '1', '3,000', '750 ML', '0000-00-00 00:00:00'),
(433, 4, 12, 34, 'Hennesy Xo', '2', '4.6', 253, 'hennessy_xo_750ml.webp', '1', '60,000', '750 ML', '0000-00-00 00:00:00'),
(434, 4, 9, 21, 'Viceroy', '2', '4.2', 482, 'viceroy_375ml.webp', '1', '2,500', '750 ML', '0000-00-00 00:00:00'),
(435, 4, 9, 21, 'Viceroy', '2', '4.3', 297, 'viceroy_375ml.webp', '1', '1,500', '375 ML', '0000-00-00 00:00:00'),
(436, 4, 9, 21, 'Myres Rum', '2', '4.4', 251, 'myres_rum_1l.webp', '1', '4,000', '750 ML', '0000-00-00 00:00:00'),
(437, 4, 9, 21, 'Myres Rum', '2', '4.4', 483, 'myres_rum_1l.webp', '1', '5,500', '1 LITRE', '0000-00-00 00:00:00'),
(438, 4, 14, 37, 'Amarula', '2', '4.3', 433, 'amarula_750ml.webp', '1', '3,500', '750 ML', '0000-00-00 00:00:00'),
(439, 4, 14, 37, 'Jaggermeister', '2', '4.4', 450, 'jaggermeister_1ltr.webp', '1', '4,500', '700 ML', '0000-00-00 00:00:00'),
(440, 4, 14, 37, 'Jaggermeister', '2', '4.4', 163, 'jaggermeister_1ltr.webp', '1', '6,000', '1 LITRE', '0000-00-00 00:00:00'),
(441, 4, 14, 37, 'Sheridans', '2', '4.5', 321, 'sheridans_1ltr.webp', '1', '7,500', '1 LITRE', '0000-00-00 00:00:00'),
(442, 4, 14, 37, 'Baileys', '2', '4.2', 311, 'baileys.webp', '1', '5,000', '750 ml', '0000-00-00 00:00:00'),
(443, 4, 14, 37, 'Richot', '2', '4.8', 398, 'richot_750.webp', '1', '2,500', '750 ML', '0000-00-00 00:00:00'),
(444, 4, 14, 37, 'Kahlua', '2', '4.7', 240, 'kahlua.webp', '1', '5,000', '750 ML', '0000-00-00 00:00:00'),
(445, 4, 14, 37, 'Malibu', '2', '4.5', 283, 'malibu.webp', '1', '3,000', '750 ML', '0000-00-00 00:00:00'),
(446, 4, 14, 37, 'Malibu', '2', '4.4', 284, 'malibu.webp', '1', '5,000', '1 LITRE', '0000-00-00 00:00:00'),
(447, 4, 15, 38, 'Camino Gold', '2', '4.3', 480, 'camino_gold.webp', '1', '4,500', '750 ML', '0000-00-00 00:00:00'),
(448, 4, 15, 38, 'Camino Silver', '2', '4.5', 347, 'camino_silver.webp', '1', '4,500', '750 ML', '0000-00-00 00:00:00'),
(449, 4, 15, 38, 'Don Julio 1942', '2', '4.3', 125, 'don_jolio_1942.webp', '1', '48,000', '750 ML', '0000-00-00 00:00:00'),
(450, 4, 15, 38, 'Don Julio Anejo', '2', '4.4', 195, 'don_julio_anejo.webp', '1', '14,000', '750 ML', '0000-00-00 00:00:00'),
(451, 4, 15, 38, 'Don Julio Blanco', '2', '4.7', 320, 'don_julio_blanco.webp', '1', '12,000', '750 ML', '0000-00-00 00:00:00'),
(452, 4, 15, 38, 'Don Julio Rpsdo', '2', '4.4', 489, 'don_julio_rpsdo.webp', '1', '13,000', '750 ML', '0000-00-00 00:00:00'),
(453, 4, 15, 38, 'Jose Cuervo Gold', '2', '4.4', 403, 'jose_cuervo_gold_1ltr.webp', '1', '4,500', '750 ML', '0000-00-00 00:00:00'),
(454, 4, 15, 38, 'Jose Cuervo Silver', '2', '4.5', 167, 'jose_cuervo_silver_1ltr.webp', '1', '4,500', '750 ML', '0000-00-00 00:00:00'),
(455, 4, 15, 38, 'Jose Cuervo Gold', '2', '4.3', 437, 'jose_cuervo_gold_1ltr.webp', '1', '5,500', '1 LITRE', '0000-00-00 00:00:00'),
(456, 4, 15, 38, 'Jose Cuervo Silver', '2', '4.7', 151, 'jose_cuervo_silver_1ltr.webp', '1', '5,500', '1 LITRE', '0000-00-00 00:00:00'),
(457, 4, 15, 38, 'Olmeca Gold', '2', '4.8', 195, 'olmeca_old_750ml.webp', '1', '4,000', '750 ML', '0000-00-00 00:00:00'),
(458, 4, 15, 38, 'Olmeca Tequilla Blanco', '2', '4.4', 291, 'olmeca_tequilla_blanco_750ml.webp', '1', '4,000', '750 ML', '0000-00-00 00:00:00'),
(459, 4, 15, 38, 'Olmeca Chocolate', '2', '4.9', 165, 'olmeca_chocolate.webp', '1', '4,500', '700 ML', '0000-00-00 00:00:00'),
(460, 4, 16, 39, 'JACK DANIELS', '2', '4.7', 124, 'jack_daniels.webp', '1', '300', '', '0000-00-00 00:00:00'),
(461, 4, 16, 39, 'BLACK LABEL', '2', '4.2', 434, 'black_lebel.webp', '1', '300', '', '0000-00-00 00:00:00'),
(462, 4, 16, 39, 'Don Julio Blanco', '2', '4.8', 253, 'tots_don_julio_blanco.webp', '1', '400', '', '0000-00-00 00:00:00'),
(463, 4, 16, 39, 'Camino Gold', '2', '4.3', 373, 'tots_camino_gold.webp', '1', '300', '', '0000-00-00 00:00:00'),
(464, 4, 16, 39, 'Camino Silver', '2', '4.9', 321, 'camino_silver.webp', '1', '250', '', '0000-00-00 00:00:00'),
(465, 4, 16, 39, 'Jose Cuervo Gold', '2', '4.3', 197, 'jose_cuervo_gold.webp', '1', '300', '', '0000-00-00 00:00:00'),
(466, 4, 16, 39, 'Jose Cuervo Silver', '2', '4.3', 431, 'jose_cuervo_silver.webp', '1', '300', '', '0000-00-00 00:00:00'),
(467, 4, 16, 39, 'Tangueray London Dry', '2', '4.8', 268, 'tots_tangueray_london_dry.webp', '1', '400', '', '0000-00-00 00:00:00'),
(468, 4, 16, 39, 'Gordon Silver', '2', '4.5', 415, 'gordon_silver.webp', '1', '300', '', '0000-00-00 00:00:00'),
(469, 4, 16, 39, 'Jameson', '2', '4.4', 436, 'jameson.webp', '1', '300', '', '0000-00-00 00:00:00'),
(470, 4, 16, 39, 'Jaggermeister', '2', '4.9', 143, 'Jaggermeister.webp', '1', '300', '', '0000-00-00 00:00:00'),
(471, 4, 16, 39, 'Southern Comfort', '2', '4.5', 436, 'southern_comfort.webp', '1', '300', '', '0000-00-00 00:00:00'),
(472, 4, 16, 39, 'Gilbeys tots', '2', '4.3', 426, 'gilbeys_tots.webp', '1', '200', '', '0000-00-00 00:00:00'),
(473, 4, 16, 39, 'Olmeca Gold 750ml', '2', '4.7', 446, 'olmeca_gold_750ml.webp', '1', '300', '', '0000-00-00 00:00:00'),
(474, 4, 16, 39, 'Smirnoff Vodka 750Ml', '2', '4.7', 403, 'tots_smirnoff_vodka_750ml.webp', '1', '200', '', '0000-00-00 00:00:00'),
(475, 4, 16, 39, 'JW Red Label', '2', '4.8', 400, 'jw_red_label.webp', '1', '300', '', '0000-00-00 00:00:00'),
(476, 4, 16, 39, 'Sheridans', '2', '4.6', 254, 'sheridans.webp', '1', '300', '', '0000-00-00 00:00:00'),
(477, 4, 16, 39, 'JW Double Black', '2', '4.2', 151, 'jw_double_black.webp', '1', '400', '', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `subcategories`
--

CREATE TABLE `subcategories` (
  `subcat_id` int(11) NOT NULL,
  `subcat_cat_id` int(11) NOT NULL,
  `subcat_name` varchar(255) NOT NULL,
  `subcat_slug` varchar(255) NOT NULL,
  `subcat_status` enum('0','1') NOT NULL DEFAULT '1',
  `subcat_image` varchar(255) NOT NULL,
  `subcat_count` int(11) NOT NULL,
  `subcat_tstamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subcategories`
--

INSERT INTO `subcategories` (`subcat_id`, `subcat_cat_id`, `subcat_name`, `subcat_slug`, `subcat_status`, `subcat_image`, `subcat_count`, `subcat_tstamp`) VALUES
(1, 1, 'Appetizers and Soups', 'Appetizers', '1', 'fa-bowl-food', 19, '2026-07-19 17:37:22'),
(2, 2, 'Breakfast', 'Breakfast', '1', 'fa-egg', 5, '2026-07-19 15:04:37'),
(3, 3, 'Coffee Menu', 'Coffee Menu', '1', 'fa-mug-hot', 28, '2026-07-19 15:04:37'),
(4, 3, 'Frappes, Boba and Slushies', 'Frappes', '1', 'fa-cup-straw', 34, '2026-07-19 17:37:32'),
(5, 3, 'Ice Cream', 'Ice Cream', '1', 'fa-ice-cream', 7, '2026-07-19 15:04:37'),
(6, 3, 'Mojito and Coladas', 'Mojito', '1', 'fa-martini-glass-citrus', 23, '2026-07-19 17:38:09'),
(7, 4, 'Beer Cans', 'Beer Cans', '1', 'fa-beer-mug-empty', 21, '2026-07-19 15:04:37'),
(8, 4, 'Beers', 'Beers', '1', 'fa-beer-mug-empty', 28, '2026-07-19 15:04:37'),
(9, 4, 'Brandy | Rum', 'Brandy | Rum', '1', 'fa-whiskey-glass', 4, '2026-07-19 15:04:37'),
(10, 4, 'Cocktail Towers', 'Cocktail Towers', '1', 'fa-champagne-glasses', 12, '2026-07-19 15:04:37'),
(11, 4, 'Cocktails', 'Cocktails', '1', 'fa-martini-glass', 43, '2026-07-19 15:04:37'),
(12, 4, 'Cognac', 'Cognac', '1', 'fa-whiskey-glass', 18, '2026-07-19 15:04:37'),
(13, 4, 'Gin / Vodka', 'Gin / Vodka', '1', 'fa-martini-glass-empty', 19, '2026-07-19 15:04:37'),
(14, 4, 'Liquor', 'Liquor', '1', 'fa-bottle-droplet', 9, '2026-07-19 15:04:37'),
(15, 4, 'Tequila', 'Tequila', '1', 'fa-whiskey-glass', 13, '2026-07-19 15:04:37'),
(16, 4, 'Tots', 'Tots', '1', 'fa-bowl-rice', 18, '2026-07-19 15:04:37'),
(17, 4, 'Whiskey', 'Whiskey', '1', 'fa-whiskey-glass', 59, '2026-07-19 15:04:37'),
(18, 4, 'Wines', 'Wines', '1', 'fa-wine-glass', 34, '2026-07-19 15:04:37'),
(19, 5, 'Entrees', 'Entrees', '1', 'fa-utensils', 7, '2026-07-19 15:04:37'),
(20, 5, 'Indian Cuisine', 'Indian Cuisine', '1', 'fa-pepper-hot', 16, '2026-07-19 15:04:37'),
(21, 5, 'Platters', 'Platters', '1', 'fa-plate-wheat', 3, '2026-07-19 15:04:37'),
(22, 5, 'Sea Food', 'Sea Food', '1', 'fa-fish', 3, '2026-07-19 15:04:37'),
(23, 5, 'Side Dishes', 'Side Dishes', '1', 'fa-carrot', 18, '2026-07-19 15:04:37'),
(24, 5, 'Signature Course', 'Signature Course', '1', 'fa-star', 10, '2026-07-19 15:04:37'),
(25, 5, 'Swahili Dishes', 'Swahili Dishes', '1', 'fa-bowl-food', 4, '2026-07-19 15:04:37'),
(26, 6, 'Pizza, Burgers and Sandwiches', 'Pizzas', '1', 'fa-pizza-slice (or fa-burger)', 11, '2026-07-19 17:40:03'),
(27, 7, 'Soft Drinks', 'Soft Drinks', '1', 'fa-bottle-water', 11, '2026-07-19 15:04:37'),
(28, 3, 'Milkshakes and Smoothies', 'Milkshakes', '1', 'fa-blender', 17, '2026-07-19 15:04:37');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_email_status` enum('0','1') NOT NULL,
  `user_phone` varchar(20) NOT NULL,
  `user_image` text NOT NULL,
  `user_password` text NOT NULL,
  `user_2fa_status` enum('0','1') NOT NULL DEFAULT '0',
  `user_2fa_code` int(10) NOT NULL,
  `user_reset_token` text NOT NULL,
  `user_token_expiry` datetime NOT NULL,
  `user_terms` enum('0','1') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_privillages`
--

CREATE TABLE `user_privillages` (
  `uspr_id` int(11) NOT NULL,
  `uspr_categories` enum('0','1','3','4','5') NOT NULL,
  `uspr_subcategories` enum('0','1','3','4','5') NOT NULL,
  `uspr_brand` enum('0','1','3','4','5') NOT NULL,
  `uspr_items` enum('0','1','3','4','5') NOT NULL,
  `uspr_users` enum('0','1','3','4','5') NOT NULL,
  `uspr_riders` enum('0','1','3','4','5') NOT NULL,
  `uspr_superadmin` enum('0','1','3','4','5') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`brand_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`cat_id`);

--
-- Indexes for table `favourites`
--
ALTER TABLE `favourites`
  ADD PRIMARY KEY (`fav_id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`item_id`);

--
-- Indexes for table `subcategories`
--
ALTER TABLE `subcategories`
  ADD PRIMARY KEY (`subcat_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `user_privillages`
--
ALTER TABLE `user_privillages`
  ADD PRIMARY KEY (`uspr_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `brand_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `cat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `favourites`
--
ALTER TABLE `favourites`
  MODIFY `fav_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=478;

--
-- AUTO_INCREMENT for table `subcategories`
--
ALTER TABLE `subcategories`
  MODIFY `subcat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_privillages`
--
ALTER TABLE `user_privillages`
  MODIFY `uspr_id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
