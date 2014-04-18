--
-- Database: `inventory`
--
--
-- Table structure for table `items`
--

CREATE TABLE IF NOT EXISTS `items` (
  `Asset#` int(3) DEFAULT NULL,
  `hostname` varchar(50) DEFAULT NULL,
  `model` varchar(100) DEFAULT NULL,
  `asset_ID` int(5) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `date_purchased` date DEFAULT NULL,
  `price` int(20) DEFAULT NULL,
  `type` varchar(100) DEFAULT NULL,
  `vendor` varchar(25) DEFAULT NULL,
  `location` varchar(6) DEFAULT NULL,
  `user` varchar(50) DEFAULT NULL,
  `LAN_MAC` varchar(20) DEFAULT NULL,
  `wifi_MAC` varchar(20) DEFAULT NULL,
  `service_tag_serial` varchar(30) DEFAULT NULL,
  `processor` varchar(30) DEFAULT NULL,
  `RAM` varchar(5) DEFAULT NULL,
  `support_expires` varchar(18) DEFAULT NULL,
  `room` varchar(10) DEFAULT NULL,
  `static_IP` varchar(21) DEFAULT NULL,
  `retired` date NOT NULL DEFAULT '0000-00-00',
  `checkout_user` varchar(100) NOT NULL,
  `checkout_date` date NOT NULL DEFAULT '0000-00-00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
