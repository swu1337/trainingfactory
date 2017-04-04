--
-- Creating Database
--

CREATE DATABASE IF NOT EXISTS `trainingfactory`
    DEFAULT CHARACTER SET utf8
    DEFAULT COLLATE utf8_general_ci;
SET default_storage_engine=InnoDB;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";

USE `trainingfactory`;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `persons`
--

CREATE TABLE `persons` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `loginname` varchar(20) NOT NULL,
  `password` varchar(65) NOT NULL DEFAULT 'qwerty',
  `firstname` varchar(25) NOT NULL,
  `preprovision` varchar(10) DEFAULT NULL,
  `lastname` varchar(35) NOT NULL,
  `dateofbirth` date NOT NULL,
  `gender` enum('male','female','other') NOT NULL,
  `email_address` varchar(100) NOT NULL,
  `hiring_date` date,
  `salary` decimal(7,2),
  `street` varchar(50),
  `postal_code` varchar(10),
  `place` varchar(35) NULL,
  `role` enum('instructeur','lid') NOT NULL DEFAULT 'lid',
  CONSTRAINT `persons_id_pk` PRIMARY KEY (`id`),
  CONSTRAINT `persons_loginname_uk` UNIQUE(`loginname`),
  CONSTRAINT `persons_email_address_uk` UNIQUE(`loginname`)
) ENGINE=InnoDB;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `trainings`
--

CREATE TABLE `trainings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(255) NOT NULL,
  `duration` time NOT NULL,
  `extra_costs` float DEFAULT NULL,
  CONSTRAINT `trainings_id_pk` PRIMARY KEY (`id`)
) ENGINE=InnoDB;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `lessons`
--

CREATE TABLE `lessons` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `time` time NOT NULL,
  `date` date NOT NULL,
  `location` varchar(50) NOT NULL,
  `max_persons` int(11) NOT NULL,
  `instructor_id` int(11) NOT NULL,
  `training_id` int(11) NOT NULL,
  CONSTRAINT `lessons_id_pk` PRIMARY KEY (`id`)
) ENGINE=InnoDB;


-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `registrations`
--

CREATE TABLE `registrations` (
  `lesson_id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `payment` varchar(30) DEFAULT NULL,
  CONSTRAINT `registrations_lesson_id_member_id_pk` PRIMARY KEY (`lesson_id`, `member_id`)
) ENGINE=InnoDB;

-- --------------------------------------------------------

--
-- Tabelrelatie voor tabel `lessons`
--

ALTER TABLE `lessons`
	ADD CONSTRAINT `lessons_instructor_id_fk`
		FOREIGN KEY (`instructor_id`)
		REFERENCES `persons`(`id`) ON DELETE CASCADE ON UPDATE CASCADE,
	ADD CONSTRAINT `lessons_training_fk`
        FOREIGN KEY (`training_id`)
        REFERENCES `trainings`(`id`) ON DELETE CASCADE ON UPDATE CASCADE;
		
-- --------------------------------------------------------

--
-- Tabelrelatie voor tabel `registrations`
--
		
ALTER TABLE `registrations`
	ADD CONSTRAINT `registrations_lesson_id_fk` 
		FOREIGN KEY (`lesson_id`)
		REFERENCES `lessons`(`id`) ON DELETE CASCADE ON UPDATE CASCADE,
	ADD CONSTRAINT `registrations_member_id_fk` 
		FOREIGN KEY (`member_id`)
		REFERENCES `persons`(`id`) ON DELETE CASCADE ON UPDATE CASCADE;