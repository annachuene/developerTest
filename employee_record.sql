
SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";



/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `employee`
--



--
-- Table structure for table `employee_record`
--

CREATE TABLE IF NOT EXISTS `employee_record` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `address` varchar(255) NOT NULL,
  `marks` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `birthdate` varchar(255) NOT NULL,
  `streetaddress` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `employee_record`
--

INSERT INTO `student_record` (`id`, `name`, `address`, `marks`) VALUES
(1, 'Akash', 'Noida', 0728419678,'pastov@yahoo.com','27-02-1981','2625 September Street'),
(2, 'Mukesh', 'Delhi', 0728419678,'pastov@yahoo.com','27-02-1981','2625 September Street');
