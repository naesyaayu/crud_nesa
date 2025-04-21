# Host: localhost  (Version 5.5.5-10.4.32-MariaDB)
# Date: 2024-12-08 20:05:00
# Generator: MySQL-Front 6.0  (Build 2.20)


#
# Structure for table "barang"
#

DROP TABLE IF EXISTS `barang`;
CREATE TABLE `barang` (
  `id_barang` int(11) NOT NULL AUTO_INCREMENT,
  `nama_barang` varchar(255) NOT NULL,
  `harga` float NOT NULL,
  `stok` int(11) NOT NULL,
  PRIMARY KEY (`id_barang`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

#
# Data for table "barang"
#

INSERT INTO `barang` VALUES (1,'Minyak Goreng',20000,94),(2,'Gula Pasir',12000,50),(3,'Beras',10000,200),(4,'Telur',20000,75),(6,'Royco',4000,31);

#
# Structure for table "transaksi"
#

DROP TABLE IF EXISTS `transaksi`;
CREATE TABLE `transaksi` (
  `id_transaksi` int(11) NOT NULL AUTO_INCREMENT,
  `id_pelanggan` int(11) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `total_harga` float NOT NULL,
  PRIMARY KEY (`id_transaksi`),
  KEY `id_barang` (`id_barang`),
  CONSTRAINT `transaksi_ibfk_1` FOREIGN KEY (`id_barang`) REFERENCES `barang` (`id_barang`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

#
# Data for table "transaksi"
#

INSERT INTO `transaksi` VALUES (1,4,1,3,60000),(2,4,1,3,60000);

#
# Structure for table "user"
#

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','pelanggan') NOT NULL,
  `nama` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `username_2` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

#
# Data for table "user"
#

INSERT INTO `user` VALUES (1,'admin','0192023a7bbd73250516f069df18b500','admin','Administrator'),(2,'pelanggan1','325077d1d7b6fa325b095fb212f3bc42','pelanggan','Budi'),(3,'pelanggan2','325077d1d7b6fa325b095fb212f3bc42','pelanggan','Siti'),(4,'vera','202cb962ac59075b964b07152d234b70','pelanggan','Vera VInanjar');
