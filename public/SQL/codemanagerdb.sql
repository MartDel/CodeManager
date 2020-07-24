-- --------------------------------------------------------
-- Hôte :                        localhost
-- Version du serveur:           5.7.24 - MySQL Community Server (GPL)
-- SE du serveur:                Win64
-- HeidiSQL Version:             10.2.0.5599
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Listage de la structure de la base pour codemanager
CREATE DATABASE IF NOT EXISTS `codemanager` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `codemanager`;

-- Listage de la structure de la table codemanager. tasks
CREATE TABLE IF NOT EXISTS `tasks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `description` text,
  `is_done` bit(1) DEFAULT b'0',
  `author` varchar(50) NOT NULL,
  `create_date` datetime NOT NULL,
  `project_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 COMMENT='Represant of all tasks';

-- Listage des données de la table codemanager.tasks : ~2 rows (environ)
/*!40000 ALTER TABLE `tasks` DISABLE KEYS */;
INSERT INTO `tasks` (`id`, `name`, `description`, `is_done`, `author`, `create_date`, `project_id`) VALUES
	(2, 'Première tâche', 'Ceci est ma première tâche tâche tâche tâche tâche tâche tâche tâche tâche tâche tâche tâche tâche tâche tâche tâche tâche tâche tâche tâche tâche tâche tâche tâche tâche tâche tâche tâche tâche tâche tâche tâche tâche tâche tâche tâche tâche tâche tâche tâche tâche tâche tâche tâche tâche tâche tâche tâche tâche tâche tâche tâche tâche tâche tâche tâche tâche tâche tâche tâche tâche tâche tâche tâche tâche tâche tâche tâche tâche tâche tâche tâche tâche tâche tâche tâche tâche tâche tâche tâche tâche tâche tâche tâche tâche tâche ', b'0', 'MartDel', '2020-07-07 23:11:57', 0),
	(3, 'Deuxième tâche', 'Ceci est ma deuxième tâche', b'0', 'MartDel', '2020-07-07 23:12:34', 0);
/*!40000 ALTER TABLE `tasks` ENABLE KEYS */;

-- Listage de la structure de la table codemanager. users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `mail` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 COMMENT='Represent all of website users';

-- Listage des données de la table codemanager.users : ~2 rows (environ)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `pseudo`, `password`, `mail`) VALUES
	(2, 'MartDel', '$2y$10$ddZKzIsatlNj6UtX91N2xe0Iom98mb2Bnm56p1PoYE7RSL1JtTZAG', 'martin-delebecque@outlook.fr'),
	(3, 'test', '$2y$10$mdK.OSBo9rNF3szOpQeBi.X1Hd4GUuYR.7zTJXd/0hS60HH5Le2Ia', 'test@mail.com');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
