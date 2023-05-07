
--
-- Database: `demo` and php web application user
DROP DATABASE demo;
CREATE DATABASE demo;
GRANT USAGE ON *.* TO 'root'@'localhost' IDENTIFIED BY '';
GRANT ALL PRIVILEGES ON demo.* TO 'root'@'localhost';
FLUSH PRIVILEGES;

USE demo;
--
-- Table structure for table `photos`
--

CREATE TABLE IF NOT EXISTS `photos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` varchar(255) NOT NULL,
  `price` int(10) NOT NULL,
  `date` date NOT NULL,
  `img` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `photos`
--

INSERT INTO `photos` (`id`, `name`, `description`, `price`, `date`, `img`) VALUES
(1, 'The Sun', 'I love three things in this world. Sun, moon and you. Sun for moring, moon for night, and you forever. ', 50, '2019-07-11', 'The Sun.png'),
(2, 'The Moon', 'Cross the stars over the moon to meet your better self.', 65, '2022-09-09', 'The Moon.png'),
(3, 'The Sky', 'Here on earth，joy is yours. Four food, but a bowl of human fireworks.', 80, '2021-05-26', 'The Sky.png');

