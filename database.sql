/*
SQLyog Ultimate v13.1.1 (64 bit)
MySQL - 10.4.17-MariaDB : Database - evaluasi
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`evaluasi` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;

USE `evaluasi`;

/*Table structure for table `tb_peserta` */

DROP TABLE IF EXISTS `tb_peserta`;

CREATE TABLE `tb_peserta` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `nopeg` varchar(25) NOT NULL,
  `nama` varchar(80) NOT NULL,
  `bagian` varchar(65) DEFAULT NULL,
  `date_create` datetime NOT NULL,
  `jabatan` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `tb_peserta` */

/*Table structure for table `tb_relasi` */

DROP TABLE IF EXISTS `tb_relasi`;

CREATE TABLE `tb_relasi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `from` int(11) NOT NULL,
  `to` int(11) NOT NULL,
  `status` enum('atasan','rekan') NOT NULL DEFAULT 'atasan',
  `level` enum('1','2') NOT NULL DEFAULT '1',
  `date_create` datetime NOT NULL,
  `date_change` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `tb_relasi` */

/*Table structure for table `tb_user` */

DROP TABLE IF EXISTS `tb_user`;

CREATE TABLE `tb_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uname` varchar(80) NOT NULL,
  `upass` varchar(255) NOT NULL,
  `date_create` datetime NOT NULL,
  `status` enum('admin','user') NOT NULL,
  `isonline` tinyint(1) NOT NULL DEFAULT 0,
  `isaktif` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tb_user` */

insert  into `tb_user`(`id`,`uname`,`upass`,`date_create`,`status`,`isonline`,`isaktif`) values 
(1,'admin1','$2y$10$4QrUgBCy.K9psBjJKVUUVuETKIUtzzOxMPbXAeBfjHs0JpJB.eqX6','2022-03-04 06:54:16','admin',0,1),
(3,'admin2','$2y$10$bEpYXartkoE4ZMwvCuBz4eu8jEqVpEuOHWPJjnODYpDXP5AyR8bfe','2022-03-04 07:43:31','admin',0,1),
(4,'N011111','$2y$10$iyQeVqCTeAvLuJGruDfyx.Sm/wC4KdTMkz1KKQHbX5FlyDEtQFDBe','2022-03-04 14:34:08','user',0,1);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
