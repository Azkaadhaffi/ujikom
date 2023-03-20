-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.3.0.6589
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping structure for table app_laundry.tb_detail_transaksi
CREATE TABLE IF NOT EXISTS `tb_detail_transaksi` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_transaksi` int DEFAULT NULL,
  `id_paket` int DEFAULT NULL,
  `qty` double DEFAULT NULL,
  `keterangan` text,
  PRIMARY KEY (`id`),
  KEY `id_transaksi` (`id_transaksi`),
  KEY `id_paket` (`id_paket`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- Dumping data for table app_laundry.tb_detail_transaksi: ~1 rows (approximately)
INSERT INTO `tb_detail_transaksi` (`id`, `id_transaksi`, `id_paket`, `qty`, `keterangan`) VALUES
	(5, 2, 2, 555, 'aaaa');

-- Dumping structure for table app_laundry.tb_member
CREATE TABLE IF NOT EXISTS `tb_member` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) DEFAULT NULL,
  `alamat` text,
  `jenis_kelamin` enum('L','P') DEFAULT NULL,
  `tlp` varchar(15) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Dumping data for table app_laundry.tb_member: ~2 rows (approximately)
INSERT INTO `tb_member` (`id`, `nama`, `alamat`, `jenis_kelamin`, `tlp`) VALUES
	(2, 'asdsa', 'dasdasd', 'L', '213123');

-- Dumping structure for table app_laundry.tb_outlet
CREATE TABLE IF NOT EXISTS `tb_outlet` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) DEFAULT NULL,
  `alamat` text,
  `tlp` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- Dumping data for table app_laundry.tb_outlet: ~2 rows (approximately)
INSERT INTO `tb_outlet` (`id`, `nama`, `alamat`, `tlp`) VALUES
	(3, 'Empang', 'Jalan Empang', '123'),
	(4, 'Ciomas', 'Jalan Raya Ciomas', '123');

-- Dumping structure for table app_laundry.tb_paket
CREATE TABLE IF NOT EXISTS `tb_paket` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_outlet` int NOT NULL DEFAULT '0',
  `jenis` enum('kiloan','selimut','bed_cover','kaos','lainnya') CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `nama_paket` varchar(100) DEFAULT NULL,
  `harga` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_outlet` (`id_outlet`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Dumping data for table app_laundry.tb_paket: ~2 rows (approximately)
INSERT INTO `tb_paket` (`id`, `id_outlet`, `jenis`, `nama_paket`, `harga`) VALUES
	(1, 4, 'kiloan', 'Paket 1kg', 25000),
	(2, 4, 'kiloan', 'Paket 2kg', 50000);

-- Dumping structure for table app_laundry.tb_transaksi
CREATE TABLE IF NOT EXISTS `tb_transaksi` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_outlet` int DEFAULT NULL,
  `kode_invoice` varchar(100) DEFAULT NULL,
  `id_member` int DEFAULT NULL,
  `tgl` datetime DEFAULT NULL,
  `batas_waktu` datetime DEFAULT NULL,
  `tgl_bayar` datetime DEFAULT NULL,
  `biaya_tambahan` int DEFAULT NULL,
  `diskon` double DEFAULT NULL,
  `pajak` int DEFAULT NULL,
  `status` enum('baru','proses','selesai','diambil') DEFAULT NULL,
  `dibayar` enum('dibayar','belum_dibayar') CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `id_user` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_outlet` (`id_outlet`),
  KEY `id_member` (`id_member`),
  KEY `kode_invoice` (`kode_invoice`),
  KEY `id_user` (`id_user`),
  KEY `status` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Dumping data for table app_laundry.tb_transaksi: ~0 rows (approximately)
INSERT INTO `tb_transaksi` (`id`, `id_outlet`, `kode_invoice`, `id_member`, `tgl`, `batas_waktu`, `tgl_bayar`, `biaya_tambahan`, `diskon`, `pajak`, `status`, `dibayar`, `id_user`) VALUES
	(2, 3, '1', 2, '2022-12-16 01:46:44', '2022-12-23 00:00:00', '2022-12-23 00:00:00', 2500, 3, 4, 'baru', 'belum_dibayar', NULL);

-- Dumping structure for table app_laundry.tb_user
CREATE TABLE IF NOT EXISTS `tb_user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) DEFAULT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` text,
  `id_outlet` int NOT NULL DEFAULT '0',
  `role` enum('admin','kasir','owner') DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_outlet` (`id_outlet`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

-- Dumping data for table app_laundry.tb_user: ~3 rows (approximately)
INSERT INTO `tb_user` (`id`, `nama`, `username`, `password`, `id_outlet`, `role`) VALUES
	(1, 'Administrator', 'admin', '21232f297a57a5a743894a0e4a801fc3', 0, 'admin'),
	(8, 'Muhammad Alfarisi', 'alfarisi', '21232f297a57a5a743894a0e4a801fc3', 4, 'owner'),
	(9, 'Eman Supriatna', 'eman', '21232f297a57a5a743894a0e4a801fc3', 4, 'kasir');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
