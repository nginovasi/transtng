# ************************************************************
# Sequel Ace SQL dump
# Version 20046
#
# https://sequel-ace.com/
# https://github.com/Sequel-Ace/Sequel-Ace
#
# Host: localhost (MySQL 8.0.32)
# Database: trans_tangerang
# Generation Time: 2023-04-13 07:33:09 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
SET NAMES utf8mb4;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE='NO_AUTO_VALUE_ON_ZERO', SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table absensi
# ------------------------------------------------------------

DROP TABLE IF EXISTS `absensi`;

CREATE TABLE `absensi` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `nik` varchar(20) DEFAULT '0',
  `time_in` time DEFAULT NULL,
  `time_out` time DEFAULT NULL,
  `time_in_jdwl` time DEFAULT NULL COMMENT 'jam sesuai jadwal masuk',
  `time_out_jdwl` time DEFAULT NULL COMMENT 'jam sesuai jadwal pulang',
  `jenis` int DEFAULT '0' COMMENT 'id jenis',
  `log_tmpstmp` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `ket_in` longtext COMMENT 'keterangan_terlabat_masuk',
  `data_uri_in` longtext,
  `data_uri_out` longtext,
  `lng_in` varchar(30) DEFAULT '0',
  `lng_out` varchar(30) DEFAULT '0',
  `lat_in` varchar(30) DEFAULT '0',
  `lat_out` varchar(30) DEFAULT '0',
  `ip` varchar(20) DEFAULT '0',
  `flag` int DEFAULT '0' COMMENT '0: aktif ; 1 hapus',
  `log_delete` datetime DEFAULT NULL,
  `ket_out` longtext COMMENT 'keterangan terlambat pulang',
  `is_lembur` int DEFAULT '0',
  `log_mulai` datetime DEFAULT NULL,
  `log_selesai` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `nik` (`nik`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table absensi_informasi
# ------------------------------------------------------------

DROP TABLE IF EXISTS `absensi_informasi`;

CREATE TABLE `absensi_informasi` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(50) DEFAULT NULL,
  `isi` longtext,
  `flag` int DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table absensi_jadwal
# ------------------------------------------------------------

DROP TABLE IF EXISTS `absensi_jadwal`;

CREATE TABLE `absensi_jadwal` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `nik` varchar(30) DEFAULT '0',
  `id_jenis` int DEFAULT '0',
  `id_user` int DEFAULT '0',
  `log` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `1` int DEFAULT '0',
  `2` int DEFAULT '0',
  `3` int DEFAULT '0',
  `4` int DEFAULT '0',
  `5` int DEFAULT '0',
  `6` int DEFAULT '0',
  `7` int DEFAULT '0',
  `8` int DEFAULT '0',
  `9` int DEFAULT '0',
  `10` int DEFAULT '0',
  `11` int DEFAULT '0',
  `12` int DEFAULT '0',
  `13` int DEFAULT '0',
  `14` int DEFAULT '0',
  `15` int DEFAULT '0',
  `16` int DEFAULT '0',
  `17` int DEFAULT '0',
  `18` int DEFAULT '0',
  `19` int DEFAULT '0',
  `20` int DEFAULT '0',
  `21` int DEFAULT '0',
  `22` int DEFAULT '0',
  `23` int DEFAULT '0',
  `24` int DEFAULT '0',
  `25` int DEFAULT '0',
  `26` int DEFAULT '0',
  `27` int DEFAULT '0',
  `28` int DEFAULT '0',
  `29` int DEFAULT '0',
  `30` int DEFAULT '0',
  `31` int DEFAULT '0',
  `keterangan` longtext,
  `flag` int DEFAULT '0',
  `bulan` date DEFAULT NULL,
  `divisi` int DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `bulan` (`bulan`,`nik`,`id_jenis`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table absensi_jam
# ------------------------------------------------------------

DROP TABLE IF EXISTS `absensi_jam`;

CREATE TABLE `absensi_jam` (
  `id_jam` int unsigned NOT NULL AUTO_INCREMENT,
  `id` int NOT NULL,
  `jam_masuk` time DEFAULT NULL,
  `jam_selesai` time DEFAULT NULL,
  `keterangan` varchar(50) DEFAULT NULL,
  `flag` int DEFAULT '0',
  `is_shift` int DEFAULT '0',
  `next_day` int DEFAULT '0',
  UNIQUE KEY `id_jam` (`id_jam`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table absensi_jenis
# ------------------------------------------------------------

DROP TABLE IF EXISTS `absensi_jenis`;

CREATE TABLE `absensi_jenis` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `jenis` varchar(50) DEFAULT NULL,
  `is_shift` int DEFAULT '0' COMMENT '0: tidak shift / 1 :shift',
  `ket` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table absensi_lokasi_log
# ------------------------------------------------------------

DROP TABLE IF EXISTS `absensi_lokasi_log`;

CREATE TABLE `absensi_lokasi_log` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `nik` int DEFAULT '0',
  `lat` varchar(30) DEFAULT '0',
  `lng` varchar(30) DEFAULT '0',
  `tanggal` datetime DEFAULT NULL,
  `baterai` varchar(10) DEFAULT '',
  `tipe_os` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nik` (`nik`,`lat`,`lng`,`tanggal`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table absensi_pool
# ------------------------------------------------------------

DROP TABLE IF EXISTS `absensi_pool`;

CREATE TABLE `absensi_pool` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `nm_pool` varchar(100) DEFAULT NULL,
  `id_lokasi` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table absensi_set_tracking
# ------------------------------------------------------------

DROP TABLE IF EXISTS `absensi_set_tracking`;

CREATE TABLE `absensi_set_tracking` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `time` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table absensi_user
# ------------------------------------------------------------

DROP TABLE IF EXISTS `absensi_user`;

CREATE TABLE `absensi_user` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `nama_pegawai` varchar(100) DEFAULT NULL,
  `jabatan` varchar(30) DEFAULT NULL,
  `nik` varchar(20) DEFAULT NULL,
  `id_jenis` int DEFAULT NULL,
  `pass` varchar(40) DEFAULT NULL,
  `tgl_lahir` varchar(10) DEFAULT NULL,
  `pass_ori` varchar(40) DEFAULT NULL,
  `id_lokasi` int DEFAULT '0',
  `flag` int DEFAULT '0',
  `id_pool` int DEFAULT '0',
  `divisi` int DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `nik` (`nik`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table astrapay
# ------------------------------------------------------------

DROP TABLE IF EXISTS `astrapay`;

CREATE TABLE `astrapay` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `order_id` varchar(30) DEFAULT NULL,
  `no_transaction` varchar(30) DEFAULT NULL,
  `open_bill_id` varchar(30) DEFAULT NULL,
  `id_bus` varchar(7) DEFAULT NULL,
  `id_pta` int DEFAULT NULL,
  `shift` int DEFAULT NULL,
  `tid` varchar(30) DEFAULT NULL,
  `fcm_token` text,
  `token` varchar(150) DEFAULT NULL,
  `request` text,
  `amount` int DEFAULT NULL,
  `tr_type` varchar(30) DEFAULT NULL,
  `status` int NOT NULL DEFAULT '0',
  `response` text,
  `imei` varchar(20) DEFAULT NULL,
  `date_insert` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `isprint` int NOT NULL DEFAULT '0',
  `ket` varchar(20) DEFAULT 'Qris',
  PRIMARY KEY (`id`),
  UNIQUE KEY `order_id` (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table astrapay_account
# ------------------------------------------------------------

DROP TABLE IF EXISTS `astrapay_account`;

CREATE TABLE `astrapay_account` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `client_id` varchar(60) DEFAULT NULL,
  `signature` varchar(1024) DEFAULT NULL,
  `account` varchar(13) DEFAULT NULL,
  `merchant_user_id` varchar(200) DEFAULT NULL,
  `callback_time` varchar(30) DEFAULT NULL,
  `name_account` varchar(50) DEFAULT NULL,
  `balance` varchar(30) DEFAULT NULL,
  `isconnect` varchar(1) DEFAULT '1' COMMENT '0: dissconnect, 1: connect',
  `response_data` varchar(1024) DEFAULT NULL,
  `date_insert` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table astrapay_callback
# ------------------------------------------------------------

DROP TABLE IF EXISTS `astrapay_callback`;

CREATE TABLE `astrapay_callback` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `client_id` varchar(255) DEFAULT NULL,
  `merchant_transaction_id` varchar(255) DEFAULT NULL,
  `astrapay_transaction_id` varchar(255) DEFAULT NULL,
  `amount` int DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `callback_time` varchar(255) DEFAULT NULL,
  `callback_security` varchar(255) DEFAULT NULL,
  `date_insert` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `response` varchar(1024) DEFAULT NULL,
  `param` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table astrapay_dev
# ------------------------------------------------------------

DROP TABLE IF EXISTS `astrapay_dev`;

CREATE TABLE `astrapay_dev` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `order_id` varchar(30) DEFAULT NULL,
  `no_transaction` varchar(30) DEFAULT NULL,
  `open_bill_id` varchar(30) DEFAULT NULL,
  `id_bus` varchar(7) DEFAULT NULL,
  `id_pta` int DEFAULT NULL,
  `shift` int DEFAULT NULL,
  `tid` varchar(30) DEFAULT NULL,
  `fcm_token` text,
  `token` varchar(150) DEFAULT NULL,
  `request` text,
  `amount` int DEFAULT NULL,
  `tr_type` varchar(30) DEFAULT NULL,
  `status` int NOT NULL DEFAULT '0',
  `response` text,
  `imei` varchar(20) DEFAULT NULL,
  `date_insert` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `isprint` int NOT NULL DEFAULT '0',
  `ket` varchar(20) DEFAULT 'Qris',
  PRIMARY KEY (`id`),
  UNIQUE KEY `order_id` (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table astrapay_rfnd_wco
# ------------------------------------------------------------

DROP TABLE IF EXISTS `astrapay_rfnd_wco`;

CREATE TABLE `astrapay_rfnd_wco` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `order_id` varchar(30) DEFAULT NULL,
  `response` text,
  `status` varchar(10) DEFAULT NULL,
  `trxId` varchar(20) DEFAULT NULL,
  `amount` varchar(11) DEFAULT NULL,
  `date_insert` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table astrapay_wco
# ------------------------------------------------------------

DROP TABLE IF EXISTS `astrapay_wco`;

CREATE TABLE `astrapay_wco` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `order_id` varchar(50) DEFAULT NULL,
  `no_transaction` varchar(50) DEFAULT NULL,
  `nohp` varchar(1024) DEFAULT NULL,
  `id_user` int unsigned DEFAULT NULL,
  `merchant_user_id` varchar(200) DEFAULT NULL,
  `id_bus` varchar(7) DEFAULT NULL,
  `id_pta` varchar(11) DEFAULT NULL,
  `shift` varchar(2) DEFAULT NULL,
  `tid` varchar(30) DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL,
  `request` text,
  `request_astra` text,
  `amount` int DEFAULT NULL,
  `tr_type` varchar(30) DEFAULT NULL,
  `status` int NOT NULL DEFAULT '0',
  `response` text,
  `date_insert` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `date_refund` datetime DEFAULT NULL,
  `dateprint` datetime DEFAULT NULL,
  `isprint` varchar(1) NOT NULL DEFAULT '0',
  `imei` varchar(16) DEFAULT NULL,
  `ket` varchar(20) DEFAULT 'AstraPay WCO',
  `nominal_ticket` varchar(11) DEFAULT '0',
  `is_cashback` varchar(1) DEFAULT '0',
  `is_discount` varchar(1) DEFAULT '0',
  `is_persen` varchar(1) DEFAULT '0',
  `potongan` varchar(11) DEFAULT '0',
  `expired_promo` date DEFAULT NULL,
  `keterangan_promo` varchar(100) DEFAULT NULL,
  `payment_pis` varchar(255) DEFAULT NULL,
  `tiket_pis` varchar(255) DEFAULT NULL,
  `tike_pis` varchar(255) DEFAULT NULL,
  `jenis` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `order_id` (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table astrapay_wco_status
# ------------------------------------------------------------

DROP TABLE IF EXISTS `astrapay_wco_status`;

CREATE TABLE `astrapay_wco_status` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `status` int DEFAULT NULL,
  `order_id` varchar(30) DEFAULT NULL,
  `date_insert` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `req` text,
  `res` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table bca_kevin
# ------------------------------------------------------------

DROP TABLE IF EXISTS `bca_kevin`;

CREATE TABLE `bca_kevin` (
  `id` int NOT NULL AUTO_INCREMENT,
  `filename` varchar(100) DEFAULT NULL,
  `sttl_count` varchar(20) DEFAULT NULL,
  `sttl_amount` varchar(20) DEFAULT NULL,
  `paid_count` varchar(20) DEFAULT NULL,
  `paid_amount` varchar(11) DEFAULT NULL,
  `dif_count` varchar(11) DEFAULT NULL,
  `dif_amount` varchar(11) DEFAULT NULL,
  `reason` varchar(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `NewIndex1` (`filename`),
  KEY `NewIndex2` (`sttl_count`),
  KEY `NewIndex3` (`sttl_amount`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table bus_location
# ------------------------------------------------------------

DROP TABLE IF EXISTS `bus_location`;

CREATE TABLE `bus_location` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_bus` varchar(8) NOT NULL DEFAULT '',
  `latitude` double NOT NULL,
  `longitude` double NOT NULL,
  `speed` double NOT NULL,
  `timestam` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `log` double(16,2) NOT NULL,
  `idkoridor` int DEFAULT NULL,
  `istrip_a` tinyint DEFAULT '1' COMMENT '1=trip_a - trip_b, 2=trip_b - trip_a',
  `degree` double(16,2) NOT NULL DEFAULT '0.00',
  `data_usage` double NOT NULL,
  `battery` double NOT NULL,
  `imei` varchar(16) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_bus` (`id_bus`),
  KEY `idx_timestamp` (`timestam`),
  KEY `idbustmstamp` (`id_bus`,`timestam`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table ci_sessions
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ci_sessions`;

CREATE TABLE `ci_sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(45) NOT NULL DEFAULT '0',
  `user_agent` text NOT NULL,
  `last_activity` int unsigned NOT NULL DEFAULT '0',
  `user_data` text,
  PRIMARY KEY (`session_id`),
  KEY `last_activity_idx` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table databis
# ------------------------------------------------------------

DROP TABLE IF EXISTS `databis`;

CREATE TABLE `databis` (
  `id` int NOT NULL AUTO_INCREMENT,
  `kode_bus` varchar(8) NOT NULL DEFAULT '',
  `jenpos` tinyint NOT NULL DEFAULT '0',
  `id_shelter` bigint DEFAULT NULL,
  `idpos` int DEFAULT NULL,
  `nama` varchar(35) DEFAULT NULL,
  `label` varchar(35) DEFAULT NULL,
  `grppos` varchar(5) DEFAULT NULL,
  `merk` varchar(50) DEFAULT NULL,
  `serial` varchar(50) DEFAULT NULL,
  `koridor` varchar(5) DEFAULT NULL COMMENT 'I,II,III,IV,V,VI',
  `nopol` varchar(10) DEFAULT NULL,
  `is_jummed` tinyint NOT NULL DEFAULT '0',
  `is_broken` tinyint NOT NULL DEFAULT '0',
  `is_patient` tinyint NOT NULL DEFAULT '0',
  `is_crime` tinyint NOT NULL DEFAULT '0',
  `is_accident` tinyint NOT NULL DEFAULT '0',
  `date_report` datetime DEFAULT NULL,
  `ovo_mid` varchar(20) DEFAULT NULL,
  `ovo_tid` varchar(20) DEFAULT NULL,
  `storeCode` varchar(20) DEFAULT NULL,
  `storeName` varchar(20) DEFAULT NULL,
  `isactive` tinyint NOT NULL DEFAULT '1',
  `color` varchar(15) NOT NULL DEFAULT '#0D47A1',
  `store_code` varchar(255) DEFAULT NULL,
  `store_name` varchar(255) DEFAULT NULL,
  `imei` varchar(16) DEFAULT NULL,
  `cpid` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `kode_bus1` (`kode_bus`),
  KEY `idx_koridor` (`koridor`),
  KEY `koridor_nama` (`nama`,`koridor`),
  KEY `grppos` (`grppos`),
  KEY `kode_bus` (`kode_bus`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;



# Dump of table databis_ami
# ------------------------------------------------------------

DROP TABLE IF EXISTS `databis_ami`;

CREATE TABLE `databis_ami` (
  `kodebus` varchar(255) DEFAULT NULL,
  `jalur` varchar(255) DEFAULT NULL,
  `plat` varchar(255) DEFAULT NULL,
  `nolambung` int DEFAULT NULL,
  `asal` varchar(255) DEFAULT NULL,
  `cpid` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table databis_copy
# ------------------------------------------------------------

DROP TABLE IF EXISTS `databis_copy`;

CREATE TABLE `databis_copy` (
  `id` int NOT NULL AUTO_INCREMENT,
  `kode_bus` varchar(8) NOT NULL DEFAULT '',
  `jenpos` tinyint NOT NULL DEFAULT '0',
  `id_shelter` bigint DEFAULT NULL,
  `nama` varchar(35) DEFAULT NULL,
  `grppos` varchar(5) DEFAULT NULL,
  `merk` varchar(50) DEFAULT NULL,
  `serial` varchar(50) DEFAULT NULL,
  `koridor` varchar(5) DEFAULT NULL COMMENT 'I,II,III,IV,V,VI',
  `nopol` varchar(10) DEFAULT NULL,
  `is_jummed` tinyint NOT NULL DEFAULT '0',
  `is_broken` tinyint NOT NULL DEFAULT '0',
  `is_patient` tinyint NOT NULL DEFAULT '0',
  `is_crime` tinyint NOT NULL DEFAULT '0',
  `is_accident` tinyint NOT NULL DEFAULT '0',
  `date_report` datetime DEFAULT NULL,
  `ovo_mid` varchar(20) DEFAULT NULL,
  `ovo_tid` varchar(20) DEFAULT NULL,
  `storeCode` varchar(20) DEFAULT NULL,
  `storeName` varchar(20) DEFAULT NULL,
  `isactive` tinyint NOT NULL DEFAULT '1',
  `color` varchar(15) NOT NULL DEFAULT '#0D47A1',
  `store_code` varchar(255) DEFAULT NULL,
  `store_name` varchar(255) DEFAULT NULL,
  `imei` varchar(16) DEFAULT NULL,
  `cpid` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `kode_bus1` (`kode_bus`),
  KEY `idx_koridor` (`koridor`),
  KEY `koridor_nama` (`nama`,`koridor`),
  KEY `grppos` (`grppos`),
  KEY `kode_bus` (`kode_bus`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;



# Dump of table databis_jtt
# ------------------------------------------------------------

DROP TABLE IF EXISTS `databis_jtt`;

CREATE TABLE `databis_jtt` (
  `PLAT` varchar(255) DEFAULT NULL,
  `NOKIR` varchar(255) DEFAULT NULL,
  `NOMESIN` varchar(255) DEFAULT NULL,
  `NORANGKA` varchar(255) DEFAULT NULL,
  `NOBODY` int DEFAULT NULL,
  `KOR` varchar(255) DEFAULT NULL,
  `MERK` varchar(255) DEFAULT NULL,
  `TAHUN` int DEFAULT NULL,
  `COLOR` varchar(255) DEFAULT NULL,
  `kodebus` varchar(10) DEFAULT NULL,
  `cpid` int NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table databis_tjog
# ------------------------------------------------------------

DROP TABLE IF EXISTS `databis_tjog`;

CREATE TABLE `databis_tjog` (
  `nama` varchar(255) DEFAULT NULL,
  `nopol` varchar(255) DEFAULT NULL,
  `kor` varchar(255) DEFAULT NULL,
  `imei` bigint DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table datakartu
# ------------------------------------------------------------

DROP TABLE IF EXISTS `datakartu`;

CREATE TABLE `datakartu` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `no_kartu` varchar(20) NOT NULL DEFAULT '',
  `no_kartu_lama` varchar(20) DEFAULT NULL,
  `jenis` varchar(20) DEFAULT NULL,
  `nama` varchar(30) DEFAULT NULL,
  `tempat_lahir` varchar(16) DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `jenis_kelamin` varchar(20) DEFAULT NULL,
  `identitas` varchar(20) DEFAULT NULL,
  `alamat` varchar(50) DEFAULT NULL,
  `no_telp` varchar(16) DEFAULT NULL,
  `pekerjaan` varchar(20) DEFAULT NULL,
  `nama_perusahaan` varchar(16) DEFAULT NULL,
  `deposit` decimal(10,0) DEFAULT NULL,
  `keterangan` varchar(60) DEFAULT NULL,
  `iduser` bigint DEFAULT NULL,
  `idbus` varchar(8) DEFAULT NULL,
  `tmstamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `akhir` varchar(255) DEFAULT NULL,
  `mulai` varchar(255) DEFAULT NULL,
  `is_replace` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `NoKartu` (`no_kartu`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;



# Dump of table djikstra_shelter
# ------------------------------------------------------------

DROP TABLE IF EXISTS `djikstra_shelter`;

CREATE TABLE `djikstra_shelter` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `id_shelter_start` int DEFAULT NULL,
  `id_shelter_finish` int DEFAULT NULL,
  `jarak` int DEFAULT NULL,
  `koridor` varchar(11) DEFAULT NULL,
  `log_input` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table general
# ------------------------------------------------------------

DROP TABLE IF EXISTS `general`;

CREATE TABLE `general` (
  `id` bigint NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table gopay_transaksi
# ------------------------------------------------------------

DROP TABLE IF EXISTS `gopay_transaksi`;

CREATE TABLE `gopay_transaksi` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `order_id` varchar(30) DEFAULT NULL,
  `no_transaction` varchar(20) DEFAULT NULL,
  `status_code` int DEFAULT NULL,
  `status_message` text,
  `transaction_id` varchar(40) DEFAULT NULL,
  `gross_amount` double(11,2) DEFAULT NULL,
  `transaction_status` varchar(11) DEFAULT NULL,
  `transaction_time` datetime DEFAULT NULL,
  `transaction_type` varchar(20) DEFAULT NULL,
  `fraud_status` text,
  `qr_url` text,
  `redirect_url` text,
  `id_pta` int DEFAULT NULL,
  `shift` int DEFAULT NULL,
  `id_bus` varchar(8) DEFAULT NULL,
  `latitude` double DEFAULT NULL,
  `longitude` double DEFAULT NULL,
  `imei` varchar(20) DEFAULT NULL,
  `response` text,
  `isprint` int DEFAULT NULL,
  `fcm_token` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `order_id` (`order_id`),
  KEY `transaction_id` (`transaction_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DELIMITER ;;
/*!50003 SET SESSION SQL_MODE="NO_AUTO_VALUE_ON_ZERO" */;;
/*!50003 CREATE */ /*!50017 DEFINER=`transjog`@`%` */ /*!50003 TRIGGER `tr_gopay_transaksi_b_upd` BEFORE UPDATE ON `gopay_transaksi` FOR EACH ROW begin
	IF old.transaction_status<>new.transaction_status THEN
		IF old.transaction_status='settlement' THEN
			set new.transaction_status='settlement';
		END IF;
	END IF;
end */;;
/*!50003 SET SESSION SQL_MODE="NO_AUTO_VALUE_ON_ZERO" */;;
/*!50003 CREATE */ /*!50017 DEFINER=`dplk`@`%` */ /*!50003 TRIGGER `tr_gopay_transkasi_a_upd` AFTER UPDATE ON `gopay_transaksi` FOR EACH ROW BEGIN
	IF(new.transaction_status='settlement' and old.transaction_status!='settlement') THEN
		INSERT INTO transaksibis(NoKartu,notrx,Tanggal,Jam,Kredit,Bis,Lokasi,Arah,Jenis,imei)
		SELECT new.order_id,new.no_transaction,DATE(new.transaction_time),TIME(new.transaction_time)
		,new.gross_amount,MID(new.no_transaction,1,LENGTH(new.no_transaction)-10)
		,IF(TIME(new.transaction_time)>TIME('12:00:00'),2,1)
		,new.id_pta,new.transaction_type,new.imei ON DUPLICATE KEY UPDATE NoKartu=VALUES(NoKartu),
		notrx=VALUES(notrx),Tanggal=VALUES(Tanggal),Jam=VALUES(Jam),Kredit=VALUES(Kredit),Bis=VALUES(Bis)
		,Arah=VALUES(Arah),Jenis=VALUES(Jenis),imei=VALUES(imei);
	END IF;
    END */;;
DELIMITER ;
/*!50003 SET SESSION SQL_MODE=@OLD_SQL_MODE */;


# Dump of table izin
# ------------------------------------------------------------

DROP TABLE IF EXISTS `izin`;

CREATE TABLE `izin` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `nik` varchar(50) DEFAULT NULL,
  `tgl_mulai` date DEFAULT NULL,
  `tgl_selesai` date DEFAULT NULL,
  `id_jenis_izin` int DEFAULT NULL,
  `ket` text,
  `flag` int DEFAULT '0' COMMENT 'flag=0 pending,flag=1 diterima,flag="2" ditolak',
  `lampiran` longtext,
  `log` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `is_old` int DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table jabatan
# ------------------------------------------------------------

DROP TABLE IF EXISTS `jabatan`;

CREATE TABLE `jabatan` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `nama_divisi` varchar(100) DEFAULT NULL,
  `jabatan` longtext,
  `nm_excel` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table jenis_izin
# ------------------------------------------------------------

DROP TABLE IF EXISTS `jenis_izin`;

CREATE TABLE `jenis_izin` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table linkaja
# ------------------------------------------------------------

DROP TABLE IF EXISTS `linkaja`;

CREATE TABLE `linkaja` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `order_id` varchar(30) DEFAULT NULL,
  `no_transaction` varchar(30) DEFAULT NULL,
  `id_bus` varchar(8) DEFAULT NULL,
  `id_pta` int DEFAULT NULL,
  `shift` int DEFAULT NULL,
  `fcm_token` text,
  `signature` varchar(128) DEFAULT NULL,
  `payload` text,
  `amount` int DEFAULT NULL,
  `tr_type` varchar(30) DEFAULT NULL,
  `status` int NOT NULL DEFAULT '0',
  `response` text,
  `imei` varchar(20) DEFAULT NULL,
  `date_insert` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `isprint` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `order_id` (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table linkaja_notif
# ------------------------------------------------------------

DROP TABLE IF EXISTS `linkaja_notif`;

CREATE TABLE `linkaja_notif` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `merchant` varchar(50) DEFAULT NULL,
  `terminal` varchar(30) DEFAULT NULL,
  `pwd` varchar(30) DEFAULT NULL,
  `trx_type` varchar(30) DEFAULT NULL,
  `trx_date` varchar(30) DEFAULT NULL,
  `trx_id` varchar(30) DEFAULT NULL,
  `msisdn` varchar(30) DEFAULT NULL,
  `msg` varchar(30) DEFAULT NULL,
  `amount` int DEFAULT NULL,
  `response` text,
  `date_insert` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `msg` (`msg`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table linkaja_paid
# ------------------------------------------------------------

DROP TABLE IF EXISTS `linkaja_paid`;

CREATE TABLE `linkaja_paid` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `notrx` varchar(11) NOT NULL,
  `paid_date` date DEFAULT NULL,
  `completion_time` varchar(255) DEFAULT NULL,
  `initiation_time` varchar(255) DEFAULT NULL,
  `detail` varchar(100) DEFAULT NULL,
  `trx_status` varchar(12) DEFAULT NULL,
  `currency` varchar(10) DEFAULT NULL,
  `paid_amount` varchar(11) DEFAULT NULL,
  `withdraw` varchar(25) DEFAULT NULL,
  `last_balance` varchar(11) DEFAULT NULL,
  `reason_type` varchar(255) DEFAULT NULL,
  `opposite_party` varchar(255) DEFAULT NULL,
  `trx_id` varchar(255) DEFAULT NULL,
  `date_insert` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `notrx_2` (`notrx`),
  KEY `completion_time` (`completion_time`),
  KEY `trx_time` (`notrx`,`completion_time`),
  KEY `completion_time_2` (`completion_time`,`trx_status`),
  KEY `trx_id` (`trx_id`),
  KEY `notrx` (`notrx`,`trx_id`),
  KEY `paid_date` (`paid_date`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table linkaja_wco
# ------------------------------------------------------------

DROP TABLE IF EXISTS `linkaja_wco`;

CREATE TABLE `linkaja_wco` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `order_id` varchar(50) DEFAULT NULL,
  `no_transaction` varchar(50) DEFAULT NULL,
  `nohp` varchar(14) DEFAULT NULL,
  `id_user` int unsigned DEFAULT NULL,
  `id_bus` varchar(7) DEFAULT NULL,
  `id_pta` int DEFAULT NULL,
  `shift` int DEFAULT NULL,
  `tid` varchar(30) DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL,
  `request` text,
  `amount` int DEFAULT NULL,
  `tr_type` varchar(30) DEFAULT NULL,
  `status` int NOT NULL DEFAULT '0' COMMENT '0=Pending, 1=Sukses, 2=Refund',
  `response` text,
  `date_insert` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `date_refund` datetime DEFAULT NULL,
  `dateprint` datetime DEFAULT NULL,
  `isprint` int NOT NULL DEFAULT '0' COMMENT '0 = blm dicetak,1: dicetak,2:dibatalkan',
  `imei` varchar(16) DEFAULT NULL,
  `ket` varchar(20) DEFAULT 'WCO',
  PRIMARY KEY (`id`),
  UNIQUE KEY `order_id` (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table log_failedtrx
# ------------------------------------------------------------

DROP TABLE IF EXISTS `log_failedtrx`;

CREATE TABLE `log_failedtrx` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `imei` varchar(16) DEFAULT NULL,
  `idpta` int DEFAULT NULL,
  `idbus` varchar(8) DEFAULT NULL,
  `bank` varchar(20) DEFAULT NULL,
  `tmstamp` datetime DEFAULT NULL,
  `msg` text,
  `handling` varchar(150) DEFAULT NULL,
  `prority` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table log_imeid
# ------------------------------------------------------------

DROP TABLE IF EXISTS `log_imeid`;

CREATE TABLE `log_imeid` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `nrp` varchar(30) DEFAULT NULL,
  `imei` varchar(16) DEFAULT NULL,
  `tmstamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `appversion` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_imeid` (`nrp`,`imei`,`tmstamp`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table log_imeid_dev
# ------------------------------------------------------------

DROP TABLE IF EXISTS `log_imeid_dev`;

CREATE TABLE `log_imeid_dev` (
  `nrp` varchar(30) DEFAULT NULL,
  `imei` varchar(16) DEFAULT NULL,
  `tmstamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `appversion` varchar(30) DEFAULT NULL,
  UNIQUE KEY `idx_imeid` (`nrp`,`imei`,`tmstamp`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table log_import_sttl
# ------------------------------------------------------------

DROP TABLE IF EXISTS `log_import_sttl`;

CREATE TABLE `log_import_sttl` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `bank` varchar(30) DEFAULT NULL,
  `jmlsttl` int DEFAULT NULL,
  `datesttl` varchar(100) DEFAULT NULL,
  `dateinsert` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `user` int DEFAULT NULL,
  `filename` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table log_info_kartu
# ------------------------------------------------------------

DROP TABLE IF EXISTS `log_info_kartu`;

CREATE TABLE `log_info_kartu` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `no_kartu` varchar(20) DEFAULT NULL,
  `jenis` varchar(20) DEFAULT NULL,
  `saldo` int DEFAULT NULL,
  `nama` varchar(30) DEFAULT NULL,
  `jenis_kelamin` varchar(20) DEFAULT NULL,
  `no_telp` varchar(16) DEFAULT NULL,
  `iduser` int DEFAULT NULL,
  `imei` varchar(16) DEFAULT NULL,
  `tmstamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table log_logout
# ------------------------------------------------------------

DROP TABLE IF EXISTS `log_logout`;

CREATE TABLE `log_logout` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `tmstamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `notes` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table log_logout_dev
# ------------------------------------------------------------

DROP TABLE IF EXISTS `log_logout_dev`;

CREATE TABLE `log_logout_dev` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `tmstamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `notes` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table log_post
# ------------------------------------------------------------

DROP TABLE IF EXISTS `log_post`;

CREATE TABLE `log_post` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `datapost` text,
  `tmstamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ip` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table log_post_gopay
# ------------------------------------------------------------

DROP TABLE IF EXISTS `log_post_gopay`;

CREATE TABLE `log_post_gopay` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `origin` varchar(20) DEFAULT NULL,
  `datapost` text,
  `res` text,
  `tmstamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ip` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `origin` (`origin`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table log_post_ovo
# ------------------------------------------------------------

DROP TABLE IF EXISTS `log_post_ovo`;

CREATE TABLE `log_post_ovo` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `origin` varchar(20) DEFAULT NULL,
  `datapost` text,
  `res` text,
  `tmstamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ip` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `origin` (`origin`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table log_post_transaksi
# ------------------------------------------------------------

DROP TABLE IF EXISTS `log_post_transaksi`;

CREATE TABLE `log_post_transaksi` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `origin` varchar(20) DEFAULT NULL,
  `datapost` longtext,
  `res` text,
  `tmstamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ip` varchar(20) DEFAULT NULL,
  `jenis` varchar(20) DEFAULT NULL,
  `imei` varchar(32) DEFAULT NULL,
  `idpta` varchar(10) DEFAULT NULL,
  `idbus` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `origin` (`origin`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table log_post2
# ------------------------------------------------------------

DROP TABLE IF EXISTS `log_post2`;

CREATE TABLE `log_post2` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `origin` varchar(20) DEFAULT NULL,
  `datapost` text,
  `res` text,
  `tmstamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ip` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `origin` (`origin`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table log_sim_replace
# ------------------------------------------------------------

DROP TABLE IF EXISTS `log_sim_replace`;

CREATE TABLE `log_sim_replace` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `kode_alat` int DEFAULT NULL,
  `old_sim` varchar(13) DEFAULT NULL,
  `new_sim` varchar(13) DEFAULT NULL,
  `date_replace` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table log_sttlbni
# ------------------------------------------------------------

DROP TABLE IF EXISTS `log_sttlbni`;

CREATE TABLE `log_sttlbni` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `username` varchar(15) DEFAULT NULL,
  `tgl` date DEFAULT NULL,
  `ip` varchar(30) DEFAULT NULL,
  `tmstamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table log_sttlbrizzi
# ------------------------------------------------------------

DROP TABLE IF EXISTS `log_sttlbrizzi`;

CREATE TABLE `log_sttlbrizzi` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `username` varchar(15) DEFAULT NULL,
  `tgl` date DEFAULT NULL,
  `ip` varchar(30) DEFAULT NULL,
  `tmstamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table log_sttltcash
# ------------------------------------------------------------

DROP TABLE IF EXISTS `log_sttltcash`;

CREATE TABLE `log_sttltcash` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `username` varchar(15) DEFAULT NULL,
  `tgl` date DEFAULT NULL,
  `ip` varchar(30) DEFAULT NULL,
  `tmstamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table log_user
# ------------------------------------------------------------

DROP TABLE IF EXISTS `log_user`;

CREATE TABLE `log_user` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `ip` varchar(30) DEFAULT NULL,
  `lastlogin` datetime DEFAULT NULL,
  `useragent` text,
  `tmstamp` datetime DEFAULT NULL,
  `username` varchar(30) DEFAULT NULL,
  `ket` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table log_wifi
# ------------------------------------------------------------

DROP TABLE IF EXISTS `log_wifi`;

CREATE TABLE `log_wifi` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `imei` varchar(32) DEFAULT NULL,
  `tmstamp` datetime DEFAULT NULL,
  `idpta` bigint DEFAULT NULL,
  `ip` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table m_instansi_detail
# ------------------------------------------------------------

DROP TABLE IF EXISTS `m_instansi_detail`;

CREATE TABLE `m_instansi_detail` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `instansi_detail_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `is_deleted` char(1) NOT NULL DEFAULT '0',
  `instansi_detail_id` int unsigned DEFAULT NULL,
  `kode` varchar(255) DEFAULT NULL,
  `lokprov_id` int DEFAULT NULL,
  `user_web_role_id` int unsigned DEFAULT NULL,
  `multiple_lokprov_id` varchar(15) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int DEFAULT NULL,
  `last_edited_at` timestamp NULL DEFAULT NULL,
  `last_edited_by` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `instansi_detail_instansi_detail_ibfk` (`instansi_detail_id`),
  KEY `lokprov_id` (`lokprov_id`),
  KEY `parent_role_isdeleted` (`instansi_detail_id`,`user_web_role_id`,`is_deleted`),
  KEY `kode_id` (`kode`,`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


DELIMITER ;;
/*!50003 SET SESSION SQL_MODE="STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION" */;;
/*!50003 CREATE */ /*!50017 DEFINER=`transhubdat`@`%` */ /*!50003 TRIGGER `tr_instansi_detail_b_upd` BEFORE UPDATE ON `m_instansi_detail` FOR EACH ROW BEGIN
	IF(old.id<>new.id) then
  	update m_user_web set instansi_detail_id=NEW.id
  	WHERE instansi_detail_id=OLD.id;
   end if;
END */;;
DELIMITER ;
/*!50003 SET SESSION SQL_MODE=@OLD_SQL_MODE */;


# Dump of table m_shelter_penumpang
# ------------------------------------------------------------

DROP TABLE IF EXISTS `m_shelter_penumpang`;

CREATE TABLE `m_shelter_penumpang` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `nama_selter` varchar(100) DEFAULT NULL,
  `order` int DEFAULT NULL,
  `koridor` int DEFAULT NULL,
  `is_deleted` int DEFAULT '0',
  `date_insert` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table m_user_mobile
# ------------------------------------------------------------

DROP TABLE IF EXISTS `m_user_mobile`;

CREATE TABLE `m_user_mobile` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `user_mobile_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `user_mobile_email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `user_mobile_phone` varchar(20) DEFAULT NULL,
  `user_mobile_otp` varchar(6) DEFAULT NULL,
  `user_mobile_otp_expired` datetime DEFAULT NULL,
  `user_mobile_type` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL COMMENT 'Android or iOS',
  `user_mobile_photo` varchar(100) DEFAULT NULL,
  `user_mobile_uid` varchar(512) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `user_mobile_fcm` varchar(1024) DEFAULT NULL,
  `user_mobile_jitsi` varchar(100) DEFAULT NULL,
  `user_mobile_rating` int DEFAULT '0',
  `user_mobile_version` varchar(20) DEFAULT NULL COMMENT 'versi apps',
  `user_mobile_role` int NOT NULL DEFAULT '1' COMMENT 's_user_mobile_role',
  `user_mobile_is_dev` char(1) DEFAULT '0',
  `is_deleted` char(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int unsigned DEFAULT NULL,
  `last_edited_at` datetime DEFAULT NULL,
  `last_edited_by` int unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `created_by` (`created_by`),
  KEY `last_edited_by` (`last_edited_by`),
  KEY `user_mobile_username` (`user_mobile_name`),
  KEY `user_mobile_email` (`user_mobile_email`),
  KEY `is_deleted` (`is_deleted`),
  KEY `user_type` (`user_mobile_type`),
  KEY `user_jitsi` (`user_mobile_jitsi`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

LOCK TABLES `m_user_mobile` WRITE;
/*!40000 ALTER TABLE `m_user_mobile` DISABLE KEYS */;

INSERT INTO `m_user_mobile` (`id`, `user_mobile_name`, `user_mobile_email`, `user_mobile_phone`, `user_mobile_otp`, `user_mobile_otp_expired`, `user_mobile_type`, `user_mobile_photo`, `user_mobile_uid`, `user_mobile_fcm`, `user_mobile_jitsi`, `user_mobile_rating`, `user_mobile_version`, `user_mobile_role`, `user_mobile_is_dev`, `is_deleted`, `created_at`, `created_by`, `last_edited_at`, `last_edited_by`)
VALUES
	(1,'Super Admin','admin@mail.com','081295385911',NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,1,'0','0','2023-04-06 16:03:42',NULL,NULL,NULL);

/*!40000 ALTER TABLE `m_user_mobile` ENABLE KEYS */;
UNLOCK TABLES;

DELIMITER ;;
/*!50003 SET SESSION SQL_MODE="STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION" */;;
/*!50003 CREATE */ /*!50017 DEFINER=`transhubdat`@`%` */ /*!50003 TRIGGER `b_update` BEFORE UPDATE ON `m_user_mobile` FOR EACH ROW BEGIN
	IF(OLD.user_mobile_jitsi='1' AND NEW.user_mobile_jitsi!='1') THEN
	SET NEW.user_mobile_type='iOS';
  END IF;	
END */;;
DELIMITER ;
/*!50003 SET SESSION SQL_MODE=@OLD_SQL_MODE */;


# Dump of table m_user_web
# ------------------------------------------------------------

DROP TABLE IF EXISTS `m_user_web`;

CREATE TABLE `m_user_web` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `user_web_username` varchar(30) DEFAULT NULL,
  `user_web_password` varchar(32) DEFAULT NULL,
  `user_web_email` varchar(50) DEFAULT NULL,
  `user_web_phone` varchar(14) DEFAULT NULL,
  `user_web_name` varchar(50) DEFAULT NULL,
  `user_web_role_id` int unsigned DEFAULT NULL,
  `user_mobile_id` int unsigned DEFAULT NULL,
  `instansi_detail_id` int DEFAULT NULL,
  `user_web_nik` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `user_web_photo` varchar(1024) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `is_deleted` char(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int unsigned DEFAULT NULL,
  `last_edited_at` datetime DEFAULT NULL,
  `last_edited_by` int unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_web_username` (`user_web_username`,`is_deleted`),
  UNIQUE KEY `user_web_email` (`user_web_email`,`is_deleted`),
  KEY `created_by` (`created_by`),
  KEY `last_edited_by` (`last_edited_by`),
  KEY `user_web_role_id` (`user_web_role_id`),
  KEY `user_mobile_id` (`user_mobile_id`),
  KEY `instansi_detail_id` (`instansi_detail_id`),
  KEY `instansi_id` (`instansi_detail_id`,`id`),
  CONSTRAINT `m_user_web_ibfk_1` FOREIGN KEY (`user_web_role_id`) REFERENCES `s_user_web_role` (`id`),
  CONSTRAINT `m_user_web_ibfk_2` FOREIGN KEY (`user_mobile_id`) REFERENCES `m_user_mobile` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

LOCK TABLES `m_user_web` WRITE;
/*!40000 ALTER TABLE `m_user_web` DISABLE KEYS */;

INSERT INTO `m_user_web` (`id`, `user_web_username`, `user_web_password`, `user_web_email`, `user_web_phone`, `user_web_name`, `user_web_role_id`, `user_mobile_id`, `instansi_detail_id`, `user_web_nik`, `user_web_photo`, `is_deleted`, `created_at`, `created_by`, `last_edited_at`, `last_edited_by`)
VALUES
	(1,'mitra','8cb434427d957c2870d053075c857670','admin@mail.com','088888888','Admin Super',1,NULL,NULL,NULL,NULL,'0','2022-11-23 12:10:15',1,'2023-02-22 19:17:59',1);

/*!40000 ALTER TABLE `m_user_web` ENABLE KEYS */;
UNLOCK TABLES;

DELIMITER ;;
/*!50003 SET SESSION SQL_MODE="STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION" */;;
/*!50003 CREATE */ /*!50017 DEFINER=`transhubdat`@`%` */ /*!50003 TRIGGER `tr_user_web_b_upd` BEFORE UPDATE ON `m_user_web` FOR EACH ROW BEGIN
	IF NEW.is_deleted>0 THEN
  		SET NEW.is_deleted = (select ifnull(max(is_deleted),1)+1 from m_user_web where (user_web_email=NEW.user_web_email or user_web_username=NEW.user_web_username ) and is_deleted>0); 
   END IF;
   
   IF OLD.user_web_email != NEW.user_web_email AND NEW.user_mobile_id IS NOT NULL THEN
   		UPDATE m_user_mobile 
   		SET user_mobile_email = NEW.user_web_email
   		WHERE id = OLD.user_mobile_id;
   END IF;
END */;;
DELIMITER ;
/*!50003 SET SESSION SQL_MODE=@OLD_SQL_MODE */;


# Dump of table mandiri_corection
# ------------------------------------------------------------

DROP TABLE IF EXISTS `mandiri_corection`;

CREATE TABLE `mandiri_corection` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `card_number` varchar(20) DEFAULT NULL,
  `fail_id_pta` varchar(10) DEFAULT NULL,
  `fail_imei` varchar(20) DEFAULT NULL,
  `fail_bus` varchar(10) DEFAULT NULL,
  `cor_id_pta` varchar(10) DEFAULT NULL,
  `cor_imei` varchar(20) DEFAULT NULL,
  `cor_bus` varchar(10) DEFAULT NULL,
  `cor_time` timestamp NULL DEFAULT NULL,
  `cor_count` int NOT NULL DEFAULT '0',
  `is_correct` int NOT NULL DEFAULT '0',
  `date_insert` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table mandiri_corection_log
# ------------------------------------------------------------

DROP TABLE IF EXISTS `mandiri_corection_log`;

CREATE TABLE `mandiri_corection_log` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `id_cor` varchar(11) DEFAULT NULL,
  `card_number` varchar(20) DEFAULT NULL,
  `id_pta` varchar(10) DEFAULT NULL,
  `imei` varchar(20) DEFAULT NULL,
  `bus` varchar(10) DEFAULT NULL,
  `event` int NOT NULL DEFAULT '0',
  `is_correct` int NOT NULL DEFAULT '0',
  `date_insert` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table mobile_log_login
# ------------------------------------------------------------

DROP TABLE IF EXISTS `mobile_log_login`;

CREATE TABLE `mobile_log_login` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `id_user` int DEFAULT NULL,
  `uid` varchar(50) DEFAULT '',
  `log` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table mobile_log_search
# ------------------------------------------------------------

DROP TABLE IF EXISTS `mobile_log_search`;

CREATE TABLE `mobile_log_search` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `id_user` int NOT NULL,
  `id_shelter` int NOT NULL,
  `latloc` varchar(15) NOT NULL DEFAULT '',
  `longloc` varchar(15) NOT NULL DEFAULT '',
  `log` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table mobile_slide
# ------------------------------------------------------------

DROP TABLE IF EXISTS `mobile_slide`;

CREATE TABLE `mobile_slide` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `filename` varchar(100) DEFAULT NULL,
  `log_input` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `iduser` int DEFAULT NULL,
  `ip` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table mobile_user
# ------------------------------------------------------------

DROP TABLE IF EXISTS `mobile_user`;

CREATE TABLE `mobile_user` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) DEFAULT '',
  `email` varchar(100) DEFAULT '',
  `pic` varchar(300) DEFAULT '-',
  `uid` varchar(50) DEFAULT '-',
  `mobile_type` varchar(10) DEFAULT '',
  `log` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table ngi_laporan_gangguan
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ngi_laporan_gangguan`;

CREATE TABLE `ngi_laporan_gangguan` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `imei` varchar(40) DEFAULT NULL,
  `username_pta` varchar(50) DEFAULT NULL,
  `date_insert` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `bis` varchar(11) DEFAULT NULL,
  `koridor` varchar(11) DEFAULT NULL,
  `penanganan` longtext,
  `ket` longtext,
  `ip` varchar(20) DEFAULT NULL,
  `iduser` int DEFAULT NULL,
  `filename` longtext,
  `ttd` longtext,
  `flag` int DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table ngi_license
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ngi_license`;

CREATE TABLE `ngi_license` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `imei` varchar(30) DEFAULT NULL,
  `enkripsi` text,
  `iduser` bigint DEFAULT NULL,
  `tmstamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unik` (`imei`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DELIMITER ;;
/*!50003 SET SESSION SQL_MODE="STRICT_TRANS_TABLES,NO_ENGINE_SUBSTITUTION" */;;
/*!50003 CREATE */ /*!50017 DEFINER=`root`@`localhost` */ /*!50003 TRIGGER `tr_bf_in_imei` BEFORE INSERT ON `ngi_license` FOR EACH ROW BEGIN
set new.enkripsi=md5(new.imei);
END */;;
DELIMITER ;
/*!50003 SET SESSION SQL_MODE=@OLD_SQL_MODE */;


# Dump of table ngi_shelter
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ngi_shelter`;

CREATE TABLE `ngi_shelter` (
  `id` int(4) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) DEFAULT NULL,
  `idpos` varchar(5) DEFAULT NULL,
  `latitude` varchar(32) DEFAULT NULL,
  `longitude` varchar(32) DEFAULT NULL,
  `koridor` varchar(11) DEFAULT NULL,
  `kor` varchar(20) DEFAULT NULL,
  `kategori` varchar(10) DEFAULT NULL,
  `date_` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `author` int NOT NULL DEFAULT '0',
  `addr` text,
  `urut` int NOT NULL DEFAULT '0',
  `rad_lat` double NOT NULL DEFAULT '0',
  `rad_lng` double NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idpos` (`idpos`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table ngi_shelter_baru
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ngi_shelter_baru`;

CREATE TABLE `ngi_shelter_baru` (
  `id_shelter` bigint NOT NULL AUTO_INCREMENT,
  `nama_selter` varchar(40) DEFAULT NULL,
  `idpos` varchar(5) DEFAULT NULL,
  `latitude` varchar(10) DEFAULT NULL,
  `longitude` varchar(10) DEFAULT NULL,
  `koridor` varchar(11) DEFAULT NULL,
  `kor` varchar(20) DEFAULT NULL,
  `kategori` varchar(10) DEFAULT NULL,
  `date_` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `author` int NOT NULL DEFAULT '0',
  `addr` text,
  `urut` int NOT NULL DEFAULT '0',
  `rad_lat` double NOT NULL DEFAULT '0',
  `rad_lng` double NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_shelter`),
  KEY `idpos` (`idpos`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table ngi_shelter_jog
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ngi_shelter_jog`;

CREATE TABLE `ngi_shelter_jog` (
  `id` int DEFAULT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `kor` varchar(255) DEFAULT NULL,
  `lat` varchar(255) DEFAULT NULL,
  `lng` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table ngi_update
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ngi_update`;

CREATE TABLE `ngi_update` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `osversion` varchar(10) NOT NULL,
  `version` varchar(10) NOT NULL,
  `isupdate` int NOT NULL DEFAULT '0',
  `tmstamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `url` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unik` (`osversion`,`version`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table onesignal_trx
# ------------------------------------------------------------

DROP TABLE IF EXISTS `onesignal_trx`;

CREATE TABLE `onesignal_trx` (
  `id` int NOT NULL,
  `last_trx` bigint NOT NULL DEFAULT '0',
  `cur_trx` bigint NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table ovo_reqtrans
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ovo_reqtrans`;

CREATE TABLE `ovo_reqtrans` (
  `trxid` bigint NOT NULL AUTO_INCREMENT,
  `merchant_inv` varchar(20) NOT NULL,
  `loyalty_id` varchar(16) DEFAULT NULL,
  `random` varchar(10) DEFAULT NULL,
  `refnum` bigint DEFAULT NULL,
  `ms` varchar(100) DEFAULT NULL,
  `jenis` varchar(20) DEFAULT NULL,
  `amount` double(16,0) NOT NULL DEFAULT '0',
  `phone` varchar(16) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `fullname` varchar(40) DEFAULT NULL,
  `gender` varchar(1) DEFAULT NULL,
  `level` varchar(10) DEFAULT NULL,
  `point` double(16,0) NOT NULL DEFAULT '0',
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `flag` tinyint NOT NULL DEFAULT '0',
  `req` text,
  `res` text,
  `mid` varchar(20) DEFAULT NULL,
  `tid` varchar(20) DEFAULT NULL,
  `merchantid` varchar(10) DEFAULT NULL,
  `storecode` varchar(20) DEFAULT NULL,
  `batchno` varchar(20) DEFAULT NULL,
  `imei` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`trxid`,`merchant_inv`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table ovo_reqtrans_dev
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ovo_reqtrans_dev`;

CREATE TABLE `ovo_reqtrans_dev` (
  `trxid` bigint NOT NULL AUTO_INCREMENT,
  `merchant_inv` varchar(20) NOT NULL,
  `loyalty_id` varchar(16) DEFAULT NULL,
  `random` varchar(10) DEFAULT NULL,
  `refnum` bigint DEFAULT NULL,
  `ms` varchar(100) DEFAULT NULL,
  `jenis` varchar(20) DEFAULT NULL,
  `amount` double(16,0) NOT NULL DEFAULT '0',
  `phone` varchar(16) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `fullname` varchar(40) DEFAULT NULL,
  `gender` varchar(1) DEFAULT NULL,
  `level` varchar(10) DEFAULT NULL,
  `point` double(16,0) NOT NULL DEFAULT '0',
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `flag` tinyint NOT NULL DEFAULT '0',
  `req` text,
  `res` text,
  `mid` varchar(20) DEFAULT NULL,
  `tid` varchar(20) DEFAULT NULL,
  `merchantid` varchar(10) DEFAULT NULL,
  `storecode` varchar(20) DEFAULT NULL,
  `batchno` varchar(20) DEFAULT NULL,
  `imei` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`trxid`,`merchant_inv`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table ovo_reversal
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ovo_reversal`;

CREATE TABLE `ovo_reversal` (
  `revid` bigint NOT NULL AUTO_INCREMENT,
  `merchantInvoice` varchar(30) DEFAULT NULL,
  `req` text,
  `res` text,
  `tmstamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `imei` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`revid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table ovo_reversal_dev
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ovo_reversal_dev`;

CREATE TABLE `ovo_reversal_dev` (
  `revid` bigint NOT NULL AUTO_INCREMENT,
  `merchantInvoice` varchar(30) DEFAULT NULL,
  `req` text,
  `res` text,
  `tmstamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `imei` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`revid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table ovo_voidlog
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ovo_voidlog`;

CREATE TABLE `ovo_voidlog` (
  `voidid` bigint NOT NULL AUTO_INCREMENT,
  `merchantInvoice` varchar(30) DEFAULT NULL,
  `req` text,
  `res` text,
  `tmstamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`voidid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table ovo_voidlog_dev
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ovo_voidlog_dev`;

CREATE TABLE `ovo_voidlog_dev` (
  `voidid` bigint NOT NULL AUTO_INCREMENT,
  `merchantInvoice` varchar(30) DEFAULT NULL,
  `req` text,
  `res` text,
  `tmstamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`voidid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table passwd_alat
# ------------------------------------------------------------

DROP TABLE IF EXISTS `passwd_alat`;

CREATE TABLE `passwd_alat` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `passwd` varchar(6) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table pegawai
# ------------------------------------------------------------

DROP TABLE IF EXISTS `pegawai`;

CREATE TABLE `pegawai` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nama_pegawai` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(60) NOT NULL DEFAULT '',
  `email` varchar(100) DEFAULT NULL,
  `telp` varchar(100) DEFAULT '',
  `nip` varbinary(50) DEFAULT '',
  `role` varchar(10) DEFAULT '2',
  `idjab` bigint DEFAULT NULL,
  `ip` varchar(20) DEFAULT NULL,
  `lastlogin` datetime DEFAULT NULL,
  `useragent` text,
  `tmstamp` datetime DEFAULT NULL,
  `login` datetime DEFAULT NULL,
  `logout` datetime DEFAULT NULL,
  `filename` longtext,
  `id_divisi` int DEFAULT NULL,
  `enabled` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unik` (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table pengaduan_data
# ------------------------------------------------------------

DROP TABLE IF EXISTS `pengaduan_data`;

CREATE TABLE `pengaduan_data` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `pta` int NOT NULL,
  `jenis_pengaduan` varchar(30) NOT NULL DEFAULT '',
  `keterangan` varchar(100) NOT NULL DEFAULT '',
  `foto` varchar(200) NOT NULL DEFAULT '',
  `user` int NOT NULL,
  `lat_user` varchar(20) NOT NULL DEFAULT '',
  `long_user` varchar(20) NOT NULL DEFAULT '',
  `log` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table pengaduan_jenis
# ------------------------------------------------------------

DROP TABLE IF EXISTS `pengaduan_jenis`;

CREATE TABLE `pengaduan_jenis` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `jenis` varchar(30) NOT NULL DEFAULT '',
  `log` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table pengaduan_user
# ------------------------------------------------------------

DROP TABLE IF EXISTS `pengaduan_user`;

CREATE TABLE `pengaduan_user` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(50) NOT NULL DEFAULT '',
  `username` varchar(30) NOT NULL DEFAULT '',
  `password` varchar(30) NOT NULL DEFAULT '',
  `log` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table petugas
# ------------------------------------------------------------

DROP TABLE IF EXISTS `petugas`;

CREATE TABLE `petugas` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(30) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `avatar` varchar(200) DEFAULT NULL,
  `active` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table pis_banner
# ------------------------------------------------------------

DROP TABLE IF EXISTS `pis_banner`;

CREATE TABLE `pis_banner` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `img_dir` varchar(300) DEFAULT NULL,
  `text_content` varchar(500) DEFAULT NULL,
  `active` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table pis_banner_config
# ------------------------------------------------------------

DROP TABLE IF EXISTS `pis_banner_config`;

CREATE TABLE `pis_banner_config` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `time` varchar(11) DEFAULT NULL,
  `is_active` int DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table pis_faq_cat
# ------------------------------------------------------------

DROP TABLE IF EXISTS `pis_faq_cat`;

CREATE TABLE `pis_faq_cat` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `kategori` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table pis_faq_content
# ------------------------------------------------------------

DROP TABLE IF EXISTS `pis_faq_content`;

CREATE TABLE `pis_faq_content` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `kat_faq` int DEFAULT NULL,
  `Q` varchar(1024) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `A` varchar(1024) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table pis_information
# ------------------------------------------------------------

DROP TABLE IF EXISTS `pis_information`;

CREATE TABLE `pis_information` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `judul` varchar(40) DEFAULT NULL,
  `banner` varchar(1024) DEFAULT NULL,
  `deskripsi` varchar(1024) DEFAULT NULL,
  `date_insert` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `is_active` tinyint(1) DEFAULT '1',
  `is_deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table pis_lokasi
# ------------------------------------------------------------

DROP TABLE IF EXISTS `pis_lokasi`;

CREATE TABLE `pis_lokasi` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) DEFAULT NULL,
  `active` tinyint(1) DEFAULT '1' COMMENT '1= aktiv, 0= non aktiv',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table pis_mobile_log_login
# ------------------------------------------------------------

DROP TABLE IF EXISTS `pis_mobile_log_login`;

CREATE TABLE `pis_mobile_log_login` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `id_user` int DEFAULT NULL,
  `uid` varchar(50) DEFAULT '',
  `log` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table pis_mobile_user
# ------------------------------------------------------------

DROP TABLE IF EXISTS `pis_mobile_user`;

CREATE TABLE `pis_mobile_user` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) DEFAULT '',
  `email` varchar(100) DEFAULT '',
  `pic` varchar(300) DEFAULT '-',
  `uid` varchar(50) DEFAULT '-',
  `fcm_token` varchar(1024) DEFAULT NULL,
  `favorite` varchar(200) DEFAULT NULL,
  `mobile_type` varchar(10) DEFAULT '',
  `is_rating` tinyint DEFAULT '0',
  `app_vers` varchar(10) DEFAULT NULL,
  `log` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `is_deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table pis_mobile_version
# ------------------------------------------------------------

DROP TABLE IF EXISTS `pis_mobile_version`;

CREATE TABLE `pis_mobile_version` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `versi` varchar(20) DEFAULT NULL,
  `code` varchar(10) DEFAULT NULL,
  `tipe_os` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;



# Dump of table pis_pariwisata
# ------------------------------------------------------------

DROP TABLE IF EXISTS `pis_pariwisata`;

CREATE TABLE `pis_pariwisata` (
  `id` double unsigned NOT NULL AUTO_INCREMENT,
  `nama_wisata` varchar(300) DEFAULT NULL,
  `alamat` blob,
  `jam_buka` time DEFAULT NULL,
  `jam_tutup` time DEFAULT NULL,
  `lat` varchar(90) DEFAULT NULL,
  `lng` varchar(90) DEFAULT NULL,
  `image` blob,
  `overview` blob,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table pis_pariwisata_gallery
# ------------------------------------------------------------

DROP TABLE IF EXISTS `pis_pariwisata_gallery`;

CREATE TABLE `pis_pariwisata_gallery` (
  `id` int NOT NULL AUTO_INCREMENT,
  `image` longtext,
  `idreview` int DEFAULT NULL,
  `loginsert` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `usermobile` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table pis_pariwisata_review
# ------------------------------------------------------------

DROP TABLE IF EXISTS `pis_pariwisata_review`;

CREATE TABLE `pis_pariwisata_review` (
  `id` int NOT NULL AUTO_INCREMENT,
  `idpariwisata` int DEFAULT NULL,
  `review` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `usermobile` int DEFAULT NULL,
  `tgl` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `rating` int DEFAULT NULL,
  `code` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table pis_payment_control
# ------------------------------------------------------------

DROP TABLE IF EXISTS `pis_payment_control`;

CREATE TABLE `pis_payment_control` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `text_message` varchar(100) DEFAULT NULL,
  `status` int NOT NULL DEFAULT '0' COMMENT '1 Active : 0 Non-Active',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table pis_payment_informasi
# ------------------------------------------------------------

DROP TABLE IF EXISTS `pis_payment_informasi`;

CREATE TABLE `pis_payment_informasi` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `nama` text,
  `is_active` tinyint DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table pis_payment_ketentuan
# ------------------------------------------------------------

DROP TABLE IF EXISTS `pis_payment_ketentuan`;

CREATE TABLE `pis_payment_ketentuan` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `nama` text,
  `is_active` int DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table pis_popup_banner
# ------------------------------------------------------------

DROP TABLE IF EXISTS `pis_popup_banner`;

CREATE TABLE `pis_popup_banner` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `type_banner` tinyint(1) DEFAULT NULL COMMENT '1 : img only, 2: img and text',
  `event` enum('home','tiket') DEFAULT NULL,
  `count` tinyint(1) DEFAULT NULL COMMENT 'berapa kali muncul',
  `img_dir` varchar(200) DEFAULT NULL,
  `description` varchar(100) DEFAULT NULL,
  `url_redirect` varchar(200) DEFAULT NULL,
  `expired` date DEFAULT NULL,
  `date_insert` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `active` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1 : active, 0 : nonactive',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table pis_popup_banner_user
# ------------------------------------------------------------

DROP TABLE IF EXISTS `pis_popup_banner_user`;

CREATE TABLE `pis_popup_banner_user` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `id_user` int DEFAULT NULL,
  `id_banner` int DEFAULT NULL,
  `date_insert` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table pis_rating_on_off
# ------------------------------------------------------------

DROP TABLE IF EXISTS `pis_rating_on_off`;

CREATE TABLE `pis_rating_on_off` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table pis_tarif_promo
# ------------------------------------------------------------

DROP TABLE IF EXISTS `pis_tarif_promo`;

CREATE TABLE `pis_tarif_promo` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `potongan` decimal(11,0) DEFAULT NULL,
  `is_cashback` varchar(1) DEFAULT NULL,
  `is_discount` varchar(1) DEFAULT NULL,
  `is_persen` varchar(1) DEFAULT NULL,
  `keterangan` varchar(100) DEFAULT NULL,
  `date_expired` date DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table pis_user_rating
# ------------------------------------------------------------

DROP TABLE IF EXISTS `pis_user_rating`;

CREATE TABLE `pis_user_rating` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `id_user` int DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `rating` varchar(10) DEFAULT NULL,
  `review` varchar(1024) DEFAULT NULL,
  `type` varchar(10) DEFAULT NULL,
  `versi` varchar(10) DEFAULT NULL,
  `ip` varchar(30) DEFAULT NULL,
  `log_insert` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;



# Dump of table pta_log
# ------------------------------------------------------------

DROP TABLE IF EXISTS `pta_log`;

CREATE TABLE `pta_log` (
  `idlog` bigint NOT NULL AUTO_INCREMENT,
  `idpta` bigint DEFAULT NULL,
  `id_bus` varchar(8) DEFAULT NULL,
  `shiftpta` int NOT NULL DEFAULT '0',
  `tmstamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `log` varchar(30) DEFAULT NULL COMMENT 'login/logout',
  `idkoridor` varchar(30) DEFAULT NULL,
  `ket` longtext,
  PRIMARY KEY (`idlog`),
  KEY `id_bus` (`id_bus`),
  KEY `idpta` (`idpta`),
  KEY `shiftpta` (`shiftpta`),
  KEY `tglx` (`tmstamp`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table pta_log_dev
# ------------------------------------------------------------

DROP TABLE IF EXISTS `pta_log_dev`;

CREATE TABLE `pta_log_dev` (
  `idlog` bigint NOT NULL AUTO_INCREMENT,
  `idpta` bigint DEFAULT NULL,
  `id_bus` varchar(8) DEFAULT NULL,
  `shiftpta` int NOT NULL DEFAULT '0',
  `tmstamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `log` varchar(30) DEFAULT NULL COMMENT 'login/logout',
  `idkoridor` int DEFAULT NULL,
  PRIMARY KEY (`idlog`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table pta_log_history
# ------------------------------------------------------------

DROP TABLE IF EXISTS `pta_log_history`;

CREATE TABLE `pta_log_history` (
  `idlog` bigint NOT NULL AUTO_INCREMENT,
  `idpta` bigint DEFAULT NULL,
  `id_bus` varchar(8) DEFAULT NULL,
  `shiftpta` int NOT NULL DEFAULT '0',
  `tmstamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `log` varchar(30) DEFAULT NULL COMMENT 'login/logout',
  `idkoridor` int DEFAULT NULL,
  PRIMARY KEY (`idlog`),
  KEY `id_bus` (`id_bus`),
  KEY `idpta` (`idpta`),
  KEY `shiftpta` (`shiftpta`),
  KEY `tglx` (`tmstamp`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table query
# ------------------------------------------------------------

DROP TABLE IF EXISTS `query`;

CREATE TABLE `query` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `keterangan` varchar(100) DEFAULT NULL,
  `kategory` varchar(50) DEFAULT NULL,
  `query` text,
  `catatan` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table ref_absensi
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ref_absensi`;

CREATE TABLE `ref_absensi` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `jenis_petugas` varchar(100) DEFAULT NULL,
  `id_jenis` int DEFAULT NULL,
  `abs_late` varchar(10) DEFAULT NULL,
  `abs_close` varchar(11) DEFAULT NULL,
  `abs_open` varchar(11) DEFAULT NULL,
  `shift` int DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table ref_bank
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ref_bank`;

CREATE TABLE `ref_bank` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(32) DEFAULT NULL,
  `is_active` int DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table ref_imei
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ref_imei`;

CREATE TABLE `ref_imei` (
  `imei` varchar(20) NOT NULL,
  `date_start` datetime DEFAULT NULL,
  `date_exp` datetime DEFAULT NULL,
  `date_last` datetime DEFAULT NULL,
  PRIMARY KEY (`imei`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table ref_imei_kor_5_6
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ref_imei_kor_5_6`;

CREATE TABLE `ref_imei_kor_5_6` (
  `imei` varchar(255) DEFAULT NULL,
  `koridor` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table ref_imei_mesin_2017
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ref_imei_mesin_2017`;

CREATE TABLE `ref_imei_mesin_2017` (
  `no` varchar(255) DEFAULT NULL,
  `imei` varchar(255) DEFAULT NULL,
  `nobox` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table ref_jab
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ref_jab`;

CREATE TABLE `ref_jab` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `kdjab` varchar(2) NOT NULL,
  `jab` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;



# Dump of table ref_jab2
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ref_jab2`;

CREATE TABLE `ref_jab2` (
  `idjab` int NOT NULL,
  `jab` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`idjab`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table ref_koridor
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ref_koridor`;

CREATE TABLE `ref_koridor` (
  `id` int NOT NULL AUTO_INCREMENT,
  `kor_induk` int DEFAULT NULL,
  `kode_koridor` char(10) DEFAULT NULL,
  `koridor` varchar(5) DEFAULT NULL,
  `rute` varchar(150) DEFAULT NULL,
  `idpos` int DEFAULT NULL,
  `iduser` bigint DEFAULT NULL,
  `createon` datetime DEFAULT NULL,
  `tmstamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ip` varchar(30) DEFAULT NULL,
  `trip_a` varchar(20) DEFAULT NULL,
  `trip_b` varchar(20) DEFAULT NULL,
  `storename` varchar(10) DEFAULT NULL,
  `mid` varchar(16) DEFAULT NULL,
  `trayek` varchar(255) DEFAULT NULL,
  `color` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `koridor` (`koridor`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table ref_lokasi_absen
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ref_lokasi_absen`;

CREATE TABLE `ref_lokasi_absen` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `nm_lokasi` varchar(50) DEFAULT NULL,
  `longitude` varchar(30) DEFAULT NULL,
  `latitude` varchar(30) DEFAULT NULL,
  `id_jenis` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table ref_midtid
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ref_midtid`;

CREATE TABLE `ref_midtid` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `imei` varchar(16) NOT NULL,
  `bni_mid` varchar(15) NOT NULL DEFAULT '' COMMENT 'koridor',
  `bni_tid` varchar(8) NOT NULL DEFAULT '' COMMENT 'mesin',
  `bri_procode` varchar(6) NOT NULL DEFAULT '',
  `bri_mid` varchar(15) NOT NULL DEFAULT '' COMMENT 'koridor',
  `bri_tid` varchar(8) NOT NULL DEFAULT '' COMMENT 'mesin',
  `bca_mid` varchar(15) DEFAULT NULL,
  `bca_tid` varchar(8) DEFAULT NULL,
  `tcash_mid` varchar(15) NOT NULL DEFAULT '' COMMENT 'koridor',
  `tcash_tid` varchar(8) NOT NULL DEFAULT '' COMMENT 'mesin',
  `isactive` tinyint NOT NULL DEFAULT '0',
  `ovo_mid` varchar(15) NOT NULL DEFAULT '',
  `ovo_tid` varchar(8) NOT NULL DEFAULT '',
  `mdr_mid` varchar(8) NOT NULL DEFAULT '',
  `mdr_tid` varchar(8) NOT NULL DEFAULT '',
  `mdr_pin_code` varchar(16) NOT NULL DEFAULT '',
  `mdr_sam_operator` varchar(4) NOT NULL DEFAULT '',
  `mdr_sam_uid` varchar(14) NOT NULL DEFAULT '',
  `astra_tid` varchar(15) DEFAULT NULL,
  `nomor_bus` varchar(5) DEFAULT NULL,
  `notes` text,
  `token` text,
  `tmstamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `marry_code` varchar(100) NOT NULL DEFAULT '',
  `kmt_sam_id` varchar(16) NOT NULL,
  `kmt_sam_config` varchar(1268) NOT NULL,
  `nomor_telp` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unik` (`imei`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table ref_midtid_bck
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ref_midtid_bck`;

CREATE TABLE `ref_midtid_bck` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `imei` varchar(16) NOT NULL,
  `bni_mid` varchar(15) NOT NULL DEFAULT '' COMMENT 'koridor',
  `bni_tid` varchar(8) NOT NULL DEFAULT '' COMMENT 'mesin',
  `bri_procode` varchar(6) NOT NULL DEFAULT '',
  `bri_mid` varchar(15) NOT NULL DEFAULT '' COMMENT 'koridor',
  `bri_tid` varchar(8) NOT NULL DEFAULT '' COMMENT 'mesin',
  `bca_mid` varchar(15) DEFAULT NULL,
  `bca_tid` varchar(8) DEFAULT NULL,
  `tcash_mid` varchar(15) NOT NULL DEFAULT '' COMMENT 'koridor',
  `tcash_tid` varchar(8) NOT NULL DEFAULT '' COMMENT 'mesin',
  `isactive` tinyint NOT NULL DEFAULT '0',
  `ovo_mid` varchar(15) NOT NULL DEFAULT '',
  `ovo_tid` varchar(8) NOT NULL DEFAULT '',
  `mdr_mid` varchar(8) NOT NULL DEFAULT '',
  `mdr_tid` varchar(8) NOT NULL DEFAULT '',
  `mdr_pin_code` varchar(16) NOT NULL DEFAULT '',
  `mdr_sam_operator` varchar(4) NOT NULL DEFAULT '',
  `mdr_sam_uid` varchar(14) NOT NULL DEFAULT '',
  `nomor_bus` varchar(5) DEFAULT NULL,
  `notes` text,
  `token` text,
  `tmstamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `marry_code` varchar(100) NOT NULL DEFAULT '',
  `marry_code_bck` varchar(100) NOT NULL,
  `nomor_telp` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unik` (`imei`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table ref_midtid_bri
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ref_midtid_bri`;

CREATE TABLE `ref_midtid_bri` (
  `procode` int DEFAULT NULL,
  `lokasi` varchar(255) DEFAULT NULL,
  `mid` varchar(255) DEFAULT NULL,
  `tid` int DEFAULT NULL,
  `no_rek` varchar(255) DEFAULT NULL,
  `nama_rek` varchar(255) DEFAULT NULL,
  `operator` varchar(255) DEFAULT NULL,
  `kode_alat` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table ref_midtid_copy
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ref_midtid_copy`;

CREATE TABLE `ref_midtid_copy` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `imei` varchar(16) NOT NULL,
  `bni_mid` varchar(15) NOT NULL DEFAULT '' COMMENT 'koridor',
  `bni_tid` varchar(8) NOT NULL DEFAULT '' COMMENT 'mesin',
  `bri_procode` varchar(6) NOT NULL DEFAULT '',
  `bri_mid` varchar(15) NOT NULL DEFAULT '' COMMENT 'koridor',
  `bri_tid` varchar(8) NOT NULL DEFAULT '' COMMENT 'mesin',
  `tcash_mid` varchar(15) NOT NULL DEFAULT '' COMMENT 'koridor',
  `tcash_tid` varchar(8) NOT NULL DEFAULT '' COMMENT 'mesin',
  `isactive` tinyint NOT NULL DEFAULT '0',
  `ovo_mid` varchar(15) NOT NULL DEFAULT '',
  `ovo_tid` varchar(8) NOT NULL DEFAULT '',
  `mdr_mid` varchar(8) NOT NULL DEFAULT '',
  `mdr_tid` varchar(8) NOT NULL DEFAULT '',
  `mdr_pin_code` varchar(16) NOT NULL DEFAULT '',
  `mdr_sam_operator` varchar(4) NOT NULL DEFAULT '',
  `mdr_sam_uid` varchar(14) NOT NULL DEFAULT '',
  `nomor_bus` varchar(5) DEFAULT NULL,
  `notes` text,
  `token` text,
  `tmstamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `marry_code` varchar(255) NOT NULL,
  `nomor_telp` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unik` (`imei`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table ref_midtid_dev
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ref_midtid_dev`;

CREATE TABLE `ref_midtid_dev` (
  `imei` varchar(16) NOT NULL,
  `bni_mid` varchar(15) DEFAULT NULL COMMENT 'koridor',
  `bni_tid` varchar(8) DEFAULT NULL COMMENT 'mesin',
  `bri_mid` varchar(15) DEFAULT NULL COMMENT 'koridor',
  `bri_tid` varchar(8) DEFAULT NULL COMMENT 'mesin',
  `tcash_mid` varchar(15) DEFAULT NULL COMMENT 'koridor',
  `tcash_tid` varchar(8) DEFAULT NULL COMMENT 'mesin',
  `tmstamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `marry_code` varchar(255) DEFAULT NULL,
  `notes` text,
  `isactive` tinyint NOT NULL DEFAULT '0',
  `ovo_mid` varchar(15) DEFAULT NULL,
  `ovo_tid` varchar(8) DEFAULT NULL,
  `token` text,
  PRIMARY KEY (`imei`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table ref_midtid_gpn
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ref_midtid_gpn`;

CREATE TABLE `ref_midtid_gpn` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `imei` varchar(16) NOT NULL,
  `bni_mid` varchar(15) NOT NULL DEFAULT '' COMMENT 'koridor',
  `bni_tid` varchar(8) NOT NULL DEFAULT '' COMMENT 'mesin',
  `bri_procode` varchar(6) NOT NULL DEFAULT '',
  `bri_mid` varchar(15) NOT NULL DEFAULT '' COMMENT 'koridor',
  `bri_tid` varchar(8) NOT NULL DEFAULT '' COMMENT 'mesin',
  `bca_mid` varchar(15) DEFAULT NULL,
  `bca_tid` varchar(8) DEFAULT NULL,
  `tcash_mid` varchar(15) NOT NULL DEFAULT '' COMMENT 'koridor',
  `tcash_tid` varchar(8) NOT NULL DEFAULT '' COMMENT 'mesin',
  `isactive` tinyint NOT NULL DEFAULT '0',
  `ovo_mid` varchar(15) NOT NULL DEFAULT '',
  `ovo_tid` varchar(8) NOT NULL DEFAULT '',
  `mdr_mid` varchar(8) NOT NULL DEFAULT '',
  `mdr_tid` varchar(8) NOT NULL DEFAULT '',
  `mdr_pin_code` varchar(16) NOT NULL DEFAULT '',
  `mdr_sam_operator` varchar(4) NOT NULL DEFAULT '',
  `mdr_sam_uid` varchar(14) NOT NULL DEFAULT '',
  `nomor_bus` varchar(5) DEFAULT NULL,
  `notes` text,
  `token` text,
  `tmstamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `marry_code` varchar(100) NOT NULL DEFAULT '',
  `nomor_telp` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unik` (`imei`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table ref_midtidbca
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ref_midtidbca`;

CREATE TABLE `ref_midtidbca` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `mid` varchar(15) DEFAULT NULL,
  `tid` varchar(15) DEFAULT '',
  `merchant` varchar(20) DEFAULT NULL,
  `bus` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table ref_midtidbni
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ref_midtidbni`;

CREATE TABLE `ref_midtidbni` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `MID` varchar(255) DEFAULT NULL,
  `TID` varchar(255) DEFAULT NULL,
  `KOR` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table ref_midtidbni2
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ref_midtidbni2`;

CREATE TABLE `ref_midtidbni2` (
  `MID` varchar(15) DEFAULT NULL,
  `TID` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table ref_midtidbri_kor_5_6
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ref_midtidbri_kor_5_6`;

CREATE TABLE `ref_midtidbri_kor_5_6` (
  `tid` varchar(255) DEFAULT NULL,
  `koridor` varchar(255) DEFAULT NULL,
  `mid` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table ref_midtidbrizzi
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ref_midtidbrizzi`;

CREATE TABLE `ref_midtidbrizzi` (
  `procode` varchar(255) DEFAULT NULL,
  `transportasi` varchar(255) DEFAULT NULL,
  `merchantname` varchar(255) DEFAULT NULL,
  `mid` varchar(255) DEFAULT NULL,
  `tid` varchar(255) DEFAULT NULL,
  `namamerchant` varchar(255) DEFAULT NULL,
  `norek` varchar(255) DEFAULT NULL,
  `namarek` varchar(255) DEFAULT NULL,
  `operator` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table ref_midtidovo
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ref_midtidovo`;

CREATE TABLE `ref_midtidovo` (
  `koridor` varchar(255) DEFAULT NULL,
  `rute` varchar(255) DEFAULT NULL,
  `storename` varchar(255) DEFAULT NULL,
  `storecode` varchar(255) DEFAULT NULL,
  `bus` varchar(255) DEFAULT NULL,
  `busname` varchar(255) DEFAULT NULL,
  `ovo_mid` varchar(255) DEFAULT NULL,
  `ovo_tid` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table ref_module
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ref_module`;

CREATE TABLE `ref_module` (
  `idmodule` int NOT NULL AUTO_INCREMENT,
  `module` varchar(30) DEFAULT NULL,
  `urlmodule` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`idmodule`),
  UNIQUE KEY `unik` (`module`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;



# Dump of table ref_narasi_tiket
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ref_narasi_tiket`;

CREATE TABLE `ref_narasi_tiket` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `headers` longtext,
  `footers` longtext,
  `gambar` int DEFAULT '0',
  `created_by` int NOT NULL,
  `last_edited_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `last_edited_by` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `ref_narasi_tiket` WRITE;
/*!40000 ALTER TABLE `ref_narasi_tiket` DISABLE KEYS */;

INSERT INTO `ref_narasi_tiket` (`id`, `headers`, `footers`, `gambar`, `created_by`, `last_edited_at`, `created_at`, `last_edited_by`)
VALUES
	(1,'@TransTangerang','Transit berlaku selama | tidak meninggalkan halte | Jika transaksi bermasalah | silahkan hubungi | 08129999222',0,1,NULL,'2023-04-06 13:58:42',NULL);

/*!40000 ALTER TABLE `ref_narasi_tiket` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table ref_pos
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ref_pos`;

CREATE TABLE `ref_pos` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(50) DEFAULT NULL,
  `active` int DEFAULT '1',
  `jenis` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table ref_tenant
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ref_tenant`;

CREATE TABLE `ref_tenant` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nama` (`nama`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `ref_tenant` WRITE;
/*!40000 ALTER TABLE `ref_tenant` DISABLE KEYS */;

INSERT INTO `ref_tenant` (`id`, `nama`)
VALUES
	(1,'AstraPay'),
	(2,'Brizzi'),
	(3,'E-Money'),
	(4,'Flazz'),
	(5,'GoPay'),
	(6,'Kartu BRT'),
	(7,'LinkAja'),
	(8,'Regular(Cash)'),
	(9,'TapCash');

/*!40000 ALTER TABLE `ref_tenant` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table ref_trip
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ref_trip`;

CREATE TABLE `ref_trip` (
  `idtrip` int NOT NULL AUTO_INCREMENT,
  `trip` varchar(50) DEFAULT NULL,
  `koridor` varchar(5) DEFAULT NULL,
  PRIMARY KEY (`idtrip`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table rekon_summary
# ------------------------------------------------------------

DROP TABLE IF EXISTS `rekon_summary`;

CREATE TABLE `rekon_summary` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `date` date DEFAULT NULL,
  `tenant` varchar(10) DEFAULT NULL,
  `transaction_record` int DEFAULT NULL,
  `settlement_record` int DEFAULT NULL,
  `generated_record` int DEFAULT NULL,
  `notes` varchar(100) DEFAULT NULL,
  `log` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `err_generated_record` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table route_plan
# ------------------------------------------------------------

DROP TABLE IF EXISTS `route_plan`;

CREATE TABLE `route_plan` (
  `id_shelter_start` int NOT NULL,
  `id_shelter` int NOT NULL,
  `id_shelter_finish` int NOT NULL,
  `sort` int DEFAULT NULL,
  `point_distance` varchar(10) DEFAULT NULL,
  `point_time` varchar(10) DEFAULT NULL,
  UNIQUE KEY `id_route_plan` (`id_shelter_start`,`id_shelter`,`id_shelter_finish`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table s_log_privilege
# ------------------------------------------------------------

DROP TABLE IF EXISTS `s_log_privilege`;

CREATE TABLE `s_log_privilege` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `log_action` varchar(10) DEFAULT NULL,
  `log_url` varchar(30) DEFAULT NULL,
  `log_param` varchar(1024) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `log_result` varchar(20) DEFAULT NULL,
  `log_ip` varchar(20) DEFAULT NULL,
  `log_user_agent` varchar(100) DEFAULT NULL,
  `user_web_id` int DEFAULT NULL,
  `is_deleted` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int unsigned DEFAULT NULL,
  `last_edited_at` datetime DEFAULT NULL,
  `last_edited_by` int unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `created_by` (`created_by`),
  KEY `last_edited_by` (`last_edited_by`),
  KEY `is_deleted` (`is_deleted`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

LOCK TABLES `s_log_privilege` WRITE;
/*!40000 ALTER TABLE `s_log_privilege` DISABLE KEYS */;

INSERT INTO `s_log_privilege` (`id`, `log_action`, `log_url`, `log_param`, `log_result`, `log_ip`, `log_user_agent`, `user_web_id`, `is_deleted`, `created_at`, `created_by`, `last_edited_at`, `last_edited_by`)
VALUES
	(149340,'login','/transtng/auth/action/login','{\"x_token\":\"fbc47c51ed707dc05514fa3a1d56f1d3\",\"username\":\"mitra\",\"password\":\"6f6b220c7cdad5267bdf12a6d90c620d\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-04 14:23:33',NULL,NULL,NULL),
	(149341,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"fbc47c51ed707dc05514fa3a1d56f1d3\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-04 14:50:00',NULL,NULL,NULL),
	(149342,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"fbc47c51ed707dc05514fa3a1d56f1d3\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-04 14:55:12',NULL,NULL,NULL),
	(149343,'login','/transtng/auth/action/login','{\"x_token\":\"fbc47c51ed707dc05514fa3a1d56f1d3\",\"username\":\"mitra\",\"password\":\"6f6b220c7cdad5267bdf12a6d90c620d\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-04 14:55:22',NULL,NULL,NULL),
	(149344,'login','/transtng/auth/action/login','{\"x_token\":\"fbc47c51ed707dc05514fa3a1d56f1d3\",\"username\":\"mitra\",\"password\":\"6f6b220c7cdad5267bdf12a6d90c620d\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-04 14:55:46',NULL,NULL,NULL),
	(149345,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"fbc47c51ed707dc05514fa3a1d56f1d3\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-04 14:56:16',NULL,NULL,NULL),
	(149346,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_parent\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"fbc47c51ed707dc05514fa3a1d56f1d3\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-04 14:56:21',NULL,NULL,NULL),
	(149347,'login','/transtng/auth/action/login','{\"x_token\":\"fbc47c51ed707dc05514fa3a1d56f1d3\",\"username\":\"mitra\",\"password\":\"6f6b220c7cdad5267bdf12a6d90c620d\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-04 14:57:19',NULL,NULL,NULL),
	(149348,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"user_web_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"user_web_email\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"user_web_username\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"user_web_role_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"instansi_detail_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"user_web_nik\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"user_web_photo\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-04 14:59:35',NULL,NULL,NULL),
	(149349,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"fbc47c51ed707dc05514fa3a1d56f1d3\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-04 14:59:49',NULL,NULL,NULL),
	(149350,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_parent\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"fbc47c51ed707dc05514fa3a1d56f1d3\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-04 14:59:53',NULL,NULL,NULL),
	(149351,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"fbc47c51ed707dc05514fa3a1d56f1d3\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-04 15:01:01',NULL,NULL,NULL),
	(149352,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_parent\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"fbc47c51ed707dc05514fa3a1d56f1d3\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-04 15:01:22',NULL,NULL,NULL),
	(149353,'insert','/transtng/administrator/action','{\"id\":\"\",\"x_token\":\"fbc47c51ed707dc05514fa3a1d56f1d3\",\"module_id\":\"1\",\"menu_id\":\"6\",\"menu_name\":\"Setting Tarif Tiket\",\"menu_url\":\"mantarif\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-04 15:01:46',NULL,NULL,NULL),
	(149354,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_parent\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"fbc47c51ed707dc05514fa3a1d56f1d3\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-04 15:01:46',NULL,NULL,NULL),
	(149355,'insert','/transtng/administrator/action','{\"delete\":\"\",\"x_token\":\"fbc47c51ed707dc05514fa3a1d56f1d3\",\"iduser\":\"1\",\"id\":[\"1\",\"2\",\"0\",\"3\",\"4\",\"5\"],\"idmenu\":[\"1\",\"2\",\"64\",\"3\",\"4\",\"5\"],\"check_all\":[\"1\",\"1\",\"1\",\"1\",\"1\",\"1\"],\"v\":[\"1\",\"1\",\"1\",\"1\",\"1\",\"1\"],\"i\":[\"1\",\"1\",\"1\",\"1\",\"1\",\"1\"],\"e\":[\"1\",\"1\",\"1\",\"1\",\"1\",\"1\"],\"d\":[\"1\",\"1\",\"1\",\"1\",\"1\",\"1\"],\"o\":[\"1\",\"1\",\"1\",\"1\",\"1\",\"1\"]}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-04 15:01:55',NULL,NULL,NULL),
	(149356,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_parent\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"fbc47c51ed707dc05514fa3a1d56f1d3\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-04 15:02:06',NULL,NULL,NULL),
	(149357,'insert','/transtng/administrator/action','{\"id\":\"\",\"x_token\":\"fbc47c51ed707dc05514fa3a1d56f1d3\",\"module_id\":\"1\",\"menu_id\":\"6\",\"menu_name\":\"Setting Narasi Tiket\",\"menu_url\":\"narasitiket\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-04 15:02:33',NULL,NULL,NULL),
	(149358,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_parent\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"fbc47c51ed707dc05514fa3a1d56f1d3\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-04 15:02:33',NULL,NULL,NULL),
	(149359,'insert','/transtng/administrator/action','{\"id\":\"\",\"x_token\":\"fbc47c51ed707dc05514fa3a1d56f1d3\",\"module_id\":\"1\",\"menu_id\":\"6\",\"menu_name\":\"Data Pegawai\",\"menu_url\":\"manpegawai\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-04 15:03:11',NULL,NULL,NULL),
	(149360,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_parent\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"fbc47c51ed707dc05514fa3a1d56f1d3\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-04 15:03:12',NULL,NULL,NULL),
	(149361,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_parent\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"fbc47c51ed707dc05514fa3a1d56f1d3\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-04 15:03:33',NULL,NULL,NULL),
	(149362,'insert','/transtng/administrator/action','{\"delete\":\"\",\"x_token\":\"fbc47c51ed707dc05514fa3a1d56f1d3\",\"iduser\":\"1\",\"id\":[\"1\",\"2\",\"8\",\"0\",\"0\",\"3\",\"4\",\"5\"],\"idmenu\":[\"1\",\"2\",\"64\",\"65\",\"66\",\"3\",\"4\",\"5\"],\"check_all\":[\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\"],\"v\":[\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\"],\"i\":[\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\"],\"e\":[\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\"],\"d\":[\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\"],\"o\":[\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\"]}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-04 15:03:41',NULL,NULL,NULL),
	(149363,'login','/transtng/auth/action/login','{\"x_token\":\"fbc47c51ed707dc05514fa3a1d56f1d3\",\"username\":\"mitra\",\"password\":\"6f6b220c7cdad5267bdf12a6d90c620d\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-04 15:03:49',NULL,NULL,NULL),
	(149364,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_parent\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"fbc47c51ed707dc05514fa3a1d56f1d3\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-04 15:04:12',NULL,NULL,NULL),
	(149365,'insert','/transtng/administrator/action','{\"id\":\"\",\"x_token\":\"fbc47c51ed707dc05514fa3a1d56f1d3\",\"module_id\":\"1\",\"menu_id\":\"6\",\"menu_name\":\"Jalur & Bus\\/Halte\",\"menu_url\":\"#\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-04 15:05:08',NULL,NULL,NULL),
	(149366,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_parent\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"fbc47c51ed707dc05514fa3a1d56f1d3\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-04 15:05:08',NULL,NULL,NULL),
	(149367,'insert','/transtng/administrator/action','{\"delete\":\"\",\"x_token\":\"fbc47c51ed707dc05514fa3a1d56f1d3\",\"iduser\":\"1\",\"id\":[\"1\",\"2\",\"8\",\"9\",\"10\",\"0\",\"3\",\"4\",\"5\"],\"idmenu\":[\"1\",\"2\",\"64\",\"65\",\"66\",\"67\",\"3\",\"4\",\"5\"],\"check_all\":[\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\"],\"v\":[\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\"],\"i\":[\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\"],\"e\":[\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\"],\"d\":[\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\"],\"o\":[\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\"]}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-04 15:05:18',NULL,NULL,NULL),
	(149368,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_parent\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"fbc47c51ed707dc05514fa3a1d56f1d3\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-04 15:05:22',NULL,NULL,NULL),
	(149369,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_parent\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"10\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"fbc47c51ed707dc05514fa3a1d56f1d3\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-04 15:05:29',NULL,NULL,NULL),
	(149370,'edit','/transtng/administrator/action','{\"id\":\"67\",\"x_token\":\"fbc47c51ed707dc05514fa3a1d56f1d3\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-04 15:05:54',NULL,NULL,NULL),
	(149371,'insert','/transtng/administrator/action','{\"id\":\"67\",\"x_token\":\"fbc47c51ed707dc05514fa3a1d56f1d3\",\"module_id\":\"1\",\"menu_id\":\"\",\"menu_name\":\"Jalur & Bus\\/Halte\",\"menu_url\":\"#\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-04 15:06:00',NULL,NULL,NULL),
	(149372,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_parent\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"fbc47c51ed707dc05514fa3a1d56f1d3\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-04 15:06:00',NULL,NULL,NULL),
	(149373,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_parent\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"10\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"fbc47c51ed707dc05514fa3a1d56f1d3\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-04 15:06:08',NULL,NULL,NULL),
	(149374,'edit','/transtng/administrator/action','{\"id\":\"67\",\"x_token\":\"fbc47c51ed707dc05514fa3a1d56f1d3\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-04 15:06:10',NULL,NULL,NULL),
	(149375,'insert','/transtng/administrator/action','{\"id\":\"67\",\"x_token\":\"fbc47c51ed707dc05514fa3a1d56f1d3\",\"module_id\":\"1\",\"menu_id\":\"\",\"menu_name\":\"Manajemen Jalur & Bus\\/Halte\",\"menu_url\":\"#\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-04 15:06:20',NULL,NULL,NULL),
	(149376,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_parent\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"fbc47c51ed707dc05514fa3a1d56f1d3\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-04 15:06:20',NULL,NULL,NULL),
	(149377,'login','/transtng/auth/action/login','{\"x_token\":\"fbc47c51ed707dc05514fa3a1d56f1d3\",\"username\":\"mitra\",\"password\":\"6f6b220c7cdad5267bdf12a6d90c620d\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-04 15:06:25',NULL,NULL,NULL),
	(149378,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_parent\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"fbc47c51ed707dc05514fa3a1d56f1d3\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-04 15:06:30',NULL,NULL,NULL),
	(149379,'insert','/transtng/administrator/action','{\"id\":\"\",\"x_token\":\"fbc47c51ed707dc05514fa3a1d56f1d3\",\"module_id\":\"1\",\"menu_id\":\"67\",\"menu_name\":\"Manajemen Pos\",\"menu_url\":\"manpos\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-04 15:06:59',NULL,NULL,NULL),
	(149380,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_parent\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"fbc47c51ed707dc05514fa3a1d56f1d3\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-04 15:06:59',NULL,NULL,NULL),
	(149381,'insert','/transtng/administrator/action','{\"id\":\"\",\"x_token\":\"fbc47c51ed707dc05514fa3a1d56f1d3\",\"module_id\":\"1\",\"menu_id\":\"67\",\"menu_name\":\"Manajemen Jalur\",\"menu_url\":\"manjalur\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-04 15:07:21',NULL,NULL,NULL),
	(149382,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_parent\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"fbc47c51ed707dc05514fa3a1d56f1d3\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-04 15:07:21',NULL,NULL,NULL),
	(149383,'insert','/transtng/administrator/action','{\"id\":\"\",\"x_token\":\"fbc47c51ed707dc05514fa3a1d56f1d3\",\"module_id\":\"1\",\"menu_id\":\"67\",\"menu_name\":\"Manajemen Bus\",\"menu_url\":\"manbus\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-04 15:07:41',NULL,NULL,NULL),
	(149384,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_parent\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"fbc47c51ed707dc05514fa3a1d56f1d3\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-04 15:07:41',NULL,NULL,NULL),
	(149385,'insert','/transtng/administrator/action','{\"delete\":\"\",\"x_token\":\"fbc47c51ed707dc05514fa3a1d56f1d3\",\"iduser\":\"1\",\"id\":[\"1\",\"2\",\"8\",\"9\",\"10\",\"3\",\"4\",\"5\",\"0\",\"0\",\"0\"],\"idmenu\":[\"1\",\"2\",\"64\",\"65\",\"66\",\"3\",\"4\",\"5\",\"68\",\"69\",\"70\"],\"check_all\":[\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\"],\"v\":[\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\"],\"i\":[\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\"],\"e\":[\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\"],\"d\":[\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\"],\"o\":[\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\"]}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-04 15:07:52',NULL,NULL,NULL),
	(149386,'login','/transtng/auth/action/login','{\"x_token\":\"fbc47c51ed707dc05514fa3a1d56f1d3\",\"username\":\"mitra\",\"password\":\"6f6b220c7cdad5267bdf12a6d90c620d\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-04 15:07:57',NULL,NULL,NULL),
	(149387,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_parent\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"fbc47c51ed707dc05514fa3a1d56f1d3\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-04 15:08:32',NULL,NULL,NULL),
	(149388,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_parent\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"10\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"fbc47c51ed707dc05514fa3a1d56f1d3\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-04 15:08:35',NULL,NULL,NULL),
	(149389,'edit','/transtng/administrator/action','{\"id\":\"67\",\"x_token\":\"fbc47c51ed707dc05514fa3a1d56f1d3\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-04 15:08:39',NULL,NULL,NULL),
	(149390,'login','/transtng/auth/action/login','{\"x_token\":\"fbc47c51ed707dc05514fa3a1d56f1d3\",\"username\":\"mitra\",\"password\":\"6f6b220c7cdad5267bdf12a6d90c620d\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-04 15:10:08',NULL,NULL,NULL),
	(149391,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"user_web_role_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"fbc47c51ed707dc05514fa3a1d56f1d3\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-04 15:19:30',NULL,NULL,NULL),
	(149392,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"jenis\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"tarif\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"fbc47c51ed707dc05514fa3a1d56f1d3\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-04 15:49:27',NULL,NULL,NULL),
	(149393,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"jenis\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"tarif\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"fbc47c51ed707dc05514fa3a1d56f1d3\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-04 15:50:29',NULL,NULL,NULL),
	(149394,'insert','/transtng/administrator/action','{\"id\":\"\",\"x_token\":\"fbc47c51ed707dc05514fa3a1d56f1d3\",\"jenis\":\"Transit\",\"tarif\":\"0\",\"deposit\":\"0\",\"iscashless\":\"0\",\"isaktif\":\"1\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-04 15:52:28',NULL,NULL,NULL),
	(149395,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"jenis\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"tarif\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"fbc47c51ed707dc05514fa3a1d56f1d3\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-04 15:53:00',NULL,NULL,NULL),
	(149396,'insert','/transtng/administrator/action','{\"id\":\"\",\"x_token\":\"fbc47c51ed707dc05514fa3a1d56f1d3\",\"jenis\":\"Transit\",\"tarif\":\"0\",\"deposit\":\"0\",\"iscashless\":\"0\",\"isaktif\":\"1\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-04 15:53:12',NULL,NULL,NULL),
	(149397,'insert','/transtng/administrator/action','{\"id\":\"\",\"x_token\":\"fbc47c51ed707dc05514fa3a1d56f1d3\",\"jenis\":\"Transit\",\"tarif\":\"0\",\"deposit\":\"0\",\"iscashless\":\"0\",\"isaktif\":\"1\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-04 15:53:40',NULL,NULL,NULL),
	(149398,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"jenis\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"tarif\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"fbc47c51ed707dc05514fa3a1d56f1d3\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-04 15:53:45',NULL,NULL,NULL),
	(149399,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"jenis\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"tarif\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"fbc47c51ed707dc05514fa3a1d56f1d3\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-04 15:54:36',NULL,NULL,NULL),
	(149400,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"jenis\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"tarif\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"fbc47c51ed707dc05514fa3a1d56f1d3\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-04 15:54:47',NULL,NULL,NULL),
	(149401,'insert','/transtng/administrator/action','{\"id\":\"\",\"x_token\":\"fbc47c51ed707dc05514fa3a1d56f1d3\",\"jenis\":\"Transit\",\"tarif\":\"0\",\"deposit\":\"0\",\"iscashless\":\"0\",\"isaktif\":\"1\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-04 15:54:59',NULL,NULL,NULL),
	(149402,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"jenis\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"tarif\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"fbc47c51ed707dc05514fa3a1d56f1d3\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-04 15:55:25',NULL,NULL,NULL),
	(149403,'insert','/transtng/administrator/action','{\"id\":\"\",\"x_token\":\"fbc47c51ed707dc05514fa3a1d56f1d3\",\"jenis\":\"Transit\",\"tarif\":\"0\",\"deposit\":\"0\",\"is_cashless\":\"0\",\"isaktif\":\"1\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-04 15:55:33',NULL,NULL,NULL),
	(149404,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"jenis\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"tarif\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"fbc47c51ed707dc05514fa3a1d56f1d3\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-04 15:55:48',NULL,NULL,NULL),
	(149405,'insert','/transtng/administrator/action','{\"id\":\"\",\"x_token\":\"fbc47c51ed707dc05514fa3a1d56f1d3\",\"jenis\":\"Transit\",\"tarif\":\"0\",\"deposit\":\"0\",\"is_cashless\":\"0\",\"is_aktif\":\"1\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-04 15:55:56',NULL,NULL,NULL),
	(149406,'insert','/transtng/administrator/action','{\"id\":\"\",\"x_token\":\"fbc47c51ed707dc05514fa3a1d56f1d3\",\"jenis\":\"Transit\",\"tarif\":\"0\",\"deposit\":\"0\",\"is_cashless\":\"0\",\"is_aktif\":\"1\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-04 15:56:53',NULL,NULL,NULL),
	(149407,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"jenis\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"tarif\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"fbc47c51ed707dc05514fa3a1d56f1d3\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-04 15:57:01',NULL,NULL,NULL),
	(149408,'edit','/transtng/administrator/action','{\"id\":\"1\",\"x_token\":\"fbc47c51ed707dc05514fa3a1d56f1d3\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-04 15:57:21',NULL,NULL,NULL),
	(149409,'insert','/transtng/administrator/action','{\"id\":\"1\",\"x_token\":\"fbc47c51ed707dc05514fa3a1d56f1d3\",\"jenis\":\"Transit\",\"tarif\":\"0\",\"deposit\":\"0\",\"is_cashless\":\"0\",\"is_aktif\":\"1\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-04 15:57:26',NULL,NULL,NULL),
	(149410,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"jenis\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"tarif\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"fbc47c51ed707dc05514fa3a1d56f1d3\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-04 16:00:18',NULL,NULL,NULL),
	(149411,'edit','/transtng/administrator/action','{\"id\":\"1\",\"x_token\":\"fbc47c51ed707dc05514fa3a1d56f1d3\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-04 16:00:19',NULL,NULL,NULL),
	(149412,'insert','/transtng/administrator/action','{\"id\":\"1\",\"x_token\":\"fbc47c51ed707dc05514fa3a1d56f1d3\",\"jenis\":\"Transit\",\"tarif\":\"0\",\"deposit\":\"0\",\"is_cashless\":\"0\",\"is_aktif\":\"1\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-04 16:00:23',NULL,NULL,NULL),
	(149413,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"jenis\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"tarif\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"fbc47c51ed707dc05514fa3a1d56f1d3\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-04 16:00:23',NULL,NULL,NULL),
	(149414,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"jenis\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"tarif\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"fbc47c51ed707dc05514fa3a1d56f1d3\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-04 16:02:38',NULL,NULL,NULL),
	(149415,'edit','/transtng/administrator/action','{\"id\":\"1\",\"x_token\":\"fbc47c51ed707dc05514fa3a1d56f1d3\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-04 16:02:40',NULL,NULL,NULL),
	(149416,'edit','/transtng/administrator/action','{\"id\":\"1\",\"x_token\":\"fbc47c51ed707dc05514fa3a1d56f1d3\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-04 16:02:43',NULL,NULL,NULL),
	(149417,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"jenis\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"tarif\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"fbc47c51ed707dc05514fa3a1d56f1d3\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-04 16:02:47',NULL,NULL,NULL),
	(149418,'edit','/transtng/administrator/action','{\"id\":\"1\",\"x_token\":\"fbc47c51ed707dc05514fa3a1d56f1d3\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-04 16:02:49',NULL,NULL,NULL),
	(149419,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"jenis\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"tarif\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"fbc47c51ed707dc05514fa3a1d56f1d3\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-04 16:03:03',NULL,NULL,NULL),
	(149420,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"jenis\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"tarif\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"fbc47c51ed707dc05514fa3a1d56f1d3\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-04 16:03:37',NULL,NULL,NULL),
	(149421,'edit','/transtng/administrator/action','{\"id\":\"1\",\"x_token\":\"fbc47c51ed707dc05514fa3a1d56f1d3\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-04 16:03:38',NULL,NULL,NULL),
	(149422,'insert','/transtng/administrator/action','{\"id\":\"1\",\"x_token\":\"fbc47c51ed707dc05514fa3a1d56f1d3\",\"jenis\":\"Transit\",\"tarif\":\"0\",\"deposit\":\"0\",\"is_cashless\":\"0\",\"is_aktif\":\"1\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-04 16:03:43',NULL,NULL,NULL),
	(149423,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"jenis\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"tarif\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"fbc47c51ed707dc05514fa3a1d56f1d3\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-04 16:03:43',NULL,NULL,NULL),
	(149424,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"jenis\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"tarif\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"fbc47c51ed707dc05514fa3a1d56f1d3\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-04 16:04:08',NULL,NULL,NULL),
	(149425,'edit','/transtng/administrator/action','{\"id\":\"1\",\"x_token\":\"fbc47c51ed707dc05514fa3a1d56f1d3\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-04 16:04:09',NULL,NULL,NULL),
	(149426,'insert','/transtng/administrator/action','{\"id\":\"1\",\"x_token\":\"fbc47c51ed707dc05514fa3a1d56f1d3\",\"jenis\":\"Transit\",\"tarif\":\"0\",\"deposit\":\"0\",\"is_cashless\":\"0\",\"is_aktif\":\"1\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-04 16:04:12',NULL,NULL,NULL),
	(149427,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"jenis\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"tarif\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"fbc47c51ed707dc05514fa3a1d56f1d3\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-04 16:04:12',NULL,NULL,NULL),
	(149428,'edit','/transtng/administrator/action','{\"id\":\"1\",\"x_token\":\"fbc47c51ed707dc05514fa3a1d56f1d3\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-04 16:04:36',NULL,NULL,NULL),
	(149429,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"jenis\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"tarif\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"fbc47c51ed707dc05514fa3a1d56f1d3\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-04 16:04:39',NULL,NULL,NULL),
	(149430,'edit','/transtng/administrator/action','{\"id\":\"1\",\"x_token\":\"fbc47c51ed707dc05514fa3a1d56f1d3\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-04 16:04:41',NULL,NULL,NULL),
	(149431,'insert','/transtng/administrator/action','{\"id\":\"1\",\"x_token\":\"fbc47c51ed707dc05514fa3a1d56f1d3\",\"jenis\":\"Transit\",\"tarif\":\"0\",\"deposit\":\"0\",\"is_cashless\":\"0\",\"is_aktif\":\"1\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-04 16:04:43',NULL,NULL,NULL),
	(149432,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"jenis\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"tarif\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"fbc47c51ed707dc05514fa3a1d56f1d3\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-04 16:04:43',NULL,NULL,NULL),
	(149433,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"jenis\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"tarif\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"fbc47c51ed707dc05514fa3a1d56f1d3\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-04 16:04:44',NULL,NULL,NULL),
	(149434,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"jenis\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"tarif\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"fbc47c51ed707dc05514fa3a1d56f1d3\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-04 16:05:50',NULL,NULL,NULL),
	(149435,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"jenis\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"tarif\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"fbc47c51ed707dc05514fa3a1d56f1d3\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-04 16:06:44',NULL,NULL,NULL),
	(149436,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"jenis\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"tarif\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"fbc47c51ed707dc05514fa3a1d56f1d3\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-04 16:09:12',NULL,NULL,NULL),
	(149437,'login','/transtng/auth/action/login','{\"x_token\":\"7a791560d624d2e93f273f17894ae0c7\",\"username\":\"mitra\",\"password\":\"6f6b220c7cdad5267bdf12a6d90c620d\"}','Akses Diberikan','::1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/111.0.',1,'0','2023-04-05 09:28:07',NULL,NULL,NULL),
	(149438,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"jenis\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"tarif\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"7a791560d624d2e93f273f17894ae0c7\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-05 09:29:16',NULL,NULL,NULL),
	(149439,'login','/transtng/auth/action/login','{\"x_token\":\"b931ae4781305d4812bf2ba6df8a1278\",\"username\":\"mitra\",\"password\":\"6f6b220c7cdad5267bdf12a6d90c620d\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-05 12:57:11',NULL,NULL,NULL),
	(149440,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"jenis\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"tarif\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"b931ae4781305d4812bf2ba6df8a1278\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-05 12:57:15',NULL,NULL,NULL),
	(149441,'insert','/transtng/administrator/action','{\"id\":\"\",\"x_token\":\"b931ae4781305d4812bf2ba6df8a1278\",\"jenis\":\"Umum\",\"tarif\":\"3600\",\"deposit\":\"3500\",\"is_cashless\":\"0\",\"is_aktif\":\"1\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-05 13:45:31',NULL,NULL,NULL),
	(149442,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"jenis\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"tarif\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"b931ae4781305d4812bf2ba6df8a1278\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-05 13:45:31',NULL,NULL,NULL),
	(149443,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"jenis\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"tarif\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"b931ae4781305d4812bf2ba6df8a1278\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-05 13:45:31',NULL,NULL,NULL),
	(149444,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"b931ae4781305d4812bf2ba6df8a1278\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-05 13:47:23',NULL,NULL,NULL),
	(149445,'insert','/transtng/administrator/action','{\"id\":\"\",\"x_token\":\"b931ae4781305d4812bf2ba6df8a1278\",\"module_name\":\"NGI MENU\",\"module_url\":\"ngi\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-05 13:47:36',NULL,NULL,NULL),
	(149446,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"b931ae4781305d4812bf2ba6df8a1278\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-05 13:47:36',NULL,NULL,NULL),
	(149447,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_parent\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"b931ae4781305d4812bf2ba6df8a1278\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-05 13:47:38',NULL,NULL,NULL),
	(149448,'insert','/transtng/administrator/action','{\"id\":\"\",\"x_token\":\"b931ae4781305d4812bf2ba6df8a1278\",\"module_id\":\"2\",\"menu_id\":\"\",\"menu_name\":\"NGI MENU\",\"menu_url\":\"#\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-05 13:48:23',NULL,NULL,NULL),
	(149449,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_parent\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"b931ae4781305d4812bf2ba6df8a1278\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-05 13:48:23',NULL,NULL,NULL),
	(149450,'insert','/transtng/administrator/action','{\"id\":\"\",\"x_token\":\"b931ae4781305d4812bf2ba6df8a1278\",\"module_id\":\"2\",\"menu_id\":\"71\",\"menu_name\":\"Software Lisensi\",\"menu_url\":\"softwarelicense\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-05 13:48:48',NULL,NULL,NULL),
	(149451,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_parent\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"b931ae4781305d4812bf2ba6df8a1278\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-05 13:48:48',NULL,NULL,NULL),
	(149452,'insert','/transtng/administrator/action','{\"delete\":\"\",\"x_token\":\"b931ae4781305d4812bf2ba6df8a1278\",\"iduser\":\"1\",\"id\":[\"1\",\"2\",\"8\",\"9\",\"10\",\"3\",\"4\",\"5\",\"12\",\"13\",\"14\",\"0\"],\"idmenu\":[\"1\",\"2\",\"64\",\"65\",\"66\",\"3\",\"4\",\"5\",\"68\",\"69\",\"70\",\"72\"],\"check_all\":[\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\"],\"v\":[\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\"],\"i\":[\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\"],\"e\":[\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\"],\"d\":[\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\"],\"o\":[\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\"],\"idmodule\":{\"2\":\"2\"}}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-05 13:49:04',NULL,NULL,NULL),
	(149453,'login','/transtng/auth/action/login','{\"x_token\":\"b931ae4781305d4812bf2ba6df8a1278\",\"username\":\"mitra\",\"password\":\"6f6b220c7cdad5267bdf12a6d90c620d\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-05 13:49:09',NULL,NULL,NULL),
	(149454,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_parent\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"b931ae4781305d4812bf2ba6df8a1278\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-05 13:49:19',NULL,NULL,NULL),
	(149455,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_parent\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"n\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"b931ae4781305d4812bf2ba6df8a1278\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-05 13:49:23',NULL,NULL,NULL),
	(149456,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_parent\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"ngi\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"b931ae4781305d4812bf2ba6df8a1278\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-05 13:49:25',NULL,NULL,NULL),
	(149457,'edit','/transtng/administrator/action','{\"id\":\"71\",\"x_token\":\"b931ae4781305d4812bf2ba6df8a1278\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-05 13:49:27',NULL,NULL,NULL),
	(149458,'insert','/transtng/administrator/action','{\"id\":\"71\",\"x_token\":\"b931ae4781305d4812bf2ba6df8a1278\",\"module_id\":\"2\",\"menu_id\":\"\",\"menu_name\":\"Alat-alat\",\"menu_url\":\"#\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-05 13:49:41',NULL,NULL,NULL),
	(149459,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_parent\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"ngi\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"b931ae4781305d4812bf2ba6df8a1278\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-05 13:49:41',NULL,NULL,NULL),
	(149460,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_parent\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"b931ae4781305d4812bf2ba6df8a1278\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-05 13:49:43',NULL,NULL,NULL),
	(149461,'login','/transtng/auth/action/login','{\"x_token\":\"b931ae4781305d4812bf2ba6df8a1278\",\"username\":\"mitra\",\"password\":\"6f6b220c7cdad5267bdf12a6d90c620d\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-05 13:49:46',NULL,NULL,NULL),
	(149462,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_parent\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"b931ae4781305d4812bf2ba6df8a1278\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-05 13:56:07',NULL,NULL,NULL),
	(149463,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_parent\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"10\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"b931ae4781305d4812bf2ba6df8a1278\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-05 13:56:13',NULL,NULL,NULL),
	(149464,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"jenis\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"tarif\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"b931ae4781305d4812bf2ba6df8a1278\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-05 14:03:13',NULL,NULL,NULL),
	(149465,'insert','/transtng/administrator/action','{\"id\":\"\",\"x_token\":\"b931ae4781305d4812bf2ba6df8a1278\",\"jenis\":\"TransTangerang Umum\",\"tarif\":\"3000\",\"deposit\":\"2500\",\"is_cashless\":\"0\",\"is_aktif\":\"1\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-05 14:04:51',NULL,NULL,NULL),
	(149466,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"jenis\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"tarif\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"b931ae4781305d4812bf2ba6df8a1278\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-05 14:04:51',NULL,NULL,NULL),
	(149467,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"jenis\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"tarif\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"b931ae4781305d4812bf2ba6df8a1278\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-05 14:04:51',NULL,NULL,NULL),
	(149468,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"jenis\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"tarif\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"b931ae4781305d4812bf2ba6df8a1278\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-05 14:04:53',NULL,NULL,NULL),
	(149469,'login','/transtng/auth/action/login','{\"x_token\":\"81e8187af98b74ca10f20e90c683c245\",\"username\":\"mitra\",\"password\":\"6f6b220c7cdad5267bdf12a6d90c620d\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-06 09:20:48',NULL,NULL,NULL),
	(149470,'login','/transtng/auth/action/login','{\"x_token\":\"81e8187af98b74ca10f20e90c683c245\",\"username\":\"mitra\",\"password\":\"6f6b220c7cdad5267bdf12a6d90c620d\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-06 09:24:18',NULL,NULL,NULL),
	(149471,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"jenis\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"tarif\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"81e8187af98b74ca10f20e90c683c245\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-06 09:30:30',NULL,NULL,NULL),
	(149472,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"jenis\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"tarif\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"81e8187af98b74ca10f20e90c683c245\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-06 09:31:38',NULL,NULL,NULL),
	(149473,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"jenis\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"tarif\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"81e8187af98b74ca10f20e90c683c245\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-06 09:32:14',NULL,NULL,NULL),
	(149474,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"jenis\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"tarif\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"81e8187af98b74ca10f20e90c683c245\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-06 09:32:49',NULL,NULL,NULL),
	(149475,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"jenis\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"tarif\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"81e8187af98b74ca10f20e90c683c245\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-06 09:33:37',NULL,NULL,NULL),
	(149476,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"jenis\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"tarif\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"81e8187af98b74ca10f20e90c683c245\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-06 09:34:21',NULL,NULL,NULL),
	(149477,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"jenis\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"tarif\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"81e8187af98b74ca10f20e90c683c245\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-06 09:34:34',NULL,NULL,NULL),
	(149478,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"jenis\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"tarif\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"81e8187af98b74ca10f20e90c683c245\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-06 09:34:49',NULL,NULL,NULL),
	(149479,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"jenis\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"tarif\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"81e8187af98b74ca10f20e90c683c245\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-06 09:35:13',NULL,NULL,NULL),
	(149480,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"jenis\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"tarif\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"81e8187af98b74ca10f20e90c683c245\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-06 09:35:31',NULL,NULL,NULL),
	(149481,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"jenis\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"tarif\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"81e8187af98b74ca10f20e90c683c245\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-06 09:36:35',NULL,NULL,NULL),
	(149482,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"jenis\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"tarif\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"81e8187af98b74ca10f20e90c683c245\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-06 09:36:42',NULL,NULL,NULL),
	(149483,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"jenis\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"tarif\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"81e8187af98b74ca10f20e90c683c245\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-06 09:38:12',NULL,NULL,NULL),
	(149484,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"jenis\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"tarif\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"81e8187af98b74ca10f20e90c683c245\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-06 09:38:29',NULL,NULL,NULL),
	(149485,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"jenis\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"tarif\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"81e8187af98b74ca10f20e90c683c245\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-06 09:38:52',NULL,NULL,NULL),
	(149486,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"jenis\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"tarif\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"81e8187af98b74ca10f20e90c683c245\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-06 09:39:23',NULL,NULL,NULL),
	(149487,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"jenis\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"tarif\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"81e8187af98b74ca10f20e90c683c245\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-06 09:41:15',NULL,NULL,NULL),
	(149488,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"jenis\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"tarif\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"81e8187af98b74ca10f20e90c683c245\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-06 09:41:37',NULL,NULL,NULL),
	(149489,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"jenis\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"tarif\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"81e8187af98b74ca10f20e90c683c245\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-06 09:43:14',NULL,NULL,NULL),
	(149490,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"jenis\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"tarif\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"81e8187af98b74ca10f20e90c683c245\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-06 09:44:37',NULL,NULL,NULL),
	(149491,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"jenis\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"tarif\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"81e8187af98b74ca10f20e90c683c245\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-06 09:45:46',NULL,NULL,NULL),
	(149492,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"jenis\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"tarif\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"81e8187af98b74ca10f20e90c683c245\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-06 09:46:10',NULL,NULL,NULL),
	(149493,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"jenis\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"tarif\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"81e8187af98b74ca10f20e90c683c245\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-06 09:46:23',NULL,NULL,NULL),
	(149494,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_parent\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"81e8187af98b74ca10f20e90c683c245\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-06 09:46:38',NULL,NULL,NULL),
	(149495,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"81e8187af98b74ca10f20e90c683c245\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-06 09:46:39',NULL,NULL,NULL),
	(149496,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"user_web_role_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"81e8187af98b74ca10f20e90c683c245\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-06 09:46:46',NULL,NULL,NULL),
	(149497,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"user_web_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"user_web_email\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"user_web_username\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"user_web_role_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"instansi_detail_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"user_web_nik\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"user_web_photo\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-06 09:46:50',NULL,NULL,NULL),
	(149498,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"user_web_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"user_web_email\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"user_web_username\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"user_web_role_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"instansi_detail_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"user_web_nik\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"user_web_photo\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-06 09:46:54',NULL,NULL,NULL),
	(149499,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"user_web_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"user_web_email\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"user_web_username\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"user_web_role_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"instansi_detail_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"user_web_nik\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"user_web_photo\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-06 09:48:24',NULL,NULL,NULL),
	(149500,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"user_web_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"user_web_email\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"user_web_username\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"user_web_role_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"instansi_detail_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"user_web_nik\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"user_web_photo\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-06 09:48:52',NULL,NULL,NULL),
	(149501,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"user_web_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"user_web_email\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"user_web_username\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"user_web_role_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"instansi_detail_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"user_web_nik\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"user_web_photo\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-06 09:49:12',NULL,NULL,NULL),
	(149502,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"user_web_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"user_web_email\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"user_web_username\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"user_web_role_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"instansi_detail_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"user_web_nik\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"user_web_photo\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-06 09:51:24',NULL,NULL,NULL),
	(149503,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"user_web_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"user_web_email\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"user_web_username\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"user_web_role_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"instansi_detail_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"user_web_nik\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"user_web_photo\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-06 10:02:06',NULL,NULL,NULL),
	(149504,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"user_web_role_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"81e8187af98b74ca10f20e90c683c245\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-06 10:02:47',NULL,NULL,NULL),
	(149505,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"jenis\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"tarif\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"81e8187af98b74ca10f20e90c683c245\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-06 10:03:28',NULL,NULL,NULL),
	(149506,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"jenis\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"tarif\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"81e8187af98b74ca10f20e90c683c245\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-06 10:03:29',NULL,NULL,NULL),
	(149507,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"jenis\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"tarif\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"81e8187af98b74ca10f20e90c683c245\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-06 10:03:32',NULL,NULL,NULL),
	(149508,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"jenis\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"tarif\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"81e8187af98b74ca10f20e90c683c245\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-06 10:06:26',NULL,NULL,NULL),
	(149509,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"jenis\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"tarif\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"81e8187af98b74ca10f20e90c683c245\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-06 10:07:52',NULL,NULL,NULL),
	(149510,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"jenis\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"tarif\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"81e8187af98b74ca10f20e90c683c245\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-06 10:11:07',NULL,NULL,NULL),
	(149511,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"jenis\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"tarif\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"81e8187af98b74ca10f20e90c683c245\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-06 10:11:52',NULL,NULL,NULL),
	(149512,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"jenis\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"tarif\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"81e8187af98b74ca10f20e90c683c245\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-06 10:18:40',NULL,NULL,NULL),
	(149513,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"jenis\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"tarif\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"81e8187af98b74ca10f20e90c683c245\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-06 10:21:43',NULL,NULL,NULL),
	(149514,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"jenis\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"tarif\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"81e8187af98b74ca10f20e90c683c245\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-06 10:26:09',NULL,NULL,NULL),
	(149515,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"jenis\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"tarif\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"81e8187af98b74ca10f20e90c683c245\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-06 10:26:51',NULL,NULL,NULL),
	(149516,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"jenis\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"tarif\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"81e8187af98b74ca10f20e90c683c245\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-06 10:29:39',NULL,NULL,NULL),
	(149517,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"jenis\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"tarif\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"81e8187af98b74ca10f20e90c683c245\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-06 11:07:29',NULL,NULL,NULL),
	(149518,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"jenis\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"tarif\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"81e8187af98b74ca10f20e90c683c245\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-06 11:14:24',NULL,NULL,NULL),
	(149519,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"jenis\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"tarif\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"81e8187af98b74ca10f20e90c683c245\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-06 11:18:39',NULL,NULL,NULL),
	(149520,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"jenis\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"tarif\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"81e8187af98b74ca10f20e90c683c245\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-06 11:19:28',NULL,NULL,NULL),
	(149521,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"jenis\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"tarif\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"6a29d223e9c934953f229937e9d773b6\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-06 11:44:10',NULL,NULL,NULL),
	(149522,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"jenis\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"tarif\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"6a29d223e9c934953f229937e9d773b6\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-06 11:47:49',NULL,NULL,NULL),
	(149523,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"jenis\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"tarif\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"6a29d223e9c934953f229937e9d773b6\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-06 11:49:47',NULL,NULL,NULL),
	(149524,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"jenis\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"tarif\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"6a29d223e9c934953f229937e9d773b6\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-06 11:52:44',NULL,NULL,NULL),
	(149525,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"jenis\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"tarif\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"6a29d223e9c934953f229937e9d773b6\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-06 11:53:01',NULL,NULL,NULL),
	(149526,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"jenis\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"tarif\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"6a29d223e9c934953f229937e9d773b6\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-06 11:54:37',NULL,NULL,NULL),
	(149527,'edit','/transtng/administrator/action','{\"id\":\"2\",\"x_token\":\"6a29d223e9c934953f229937e9d773b6\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-06 11:54:48',NULL,NULL,NULL),
	(149528,'insert','/transtng/administrator/action','{\"id\":\"2\",\"x_token\":\"6a29d223e9c934953f229937e9d773b6\",\"jenis\":\"Umum\",\"tarif\":\"3600\",\"deposit\":\"3500\",\"nama_tenant\":\"1\",\"is_cashless\":\"1\",\"is_aktif\":\"0\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-06 11:55:11',NULL,NULL,NULL),
	(149529,'insert','/transtng/administrator/action','{\"id\":\"2\",\"x_token\":\"6a29d223e9c934953f229937e9d773b6\",\"jenis\":\"Umum\",\"tarif\":\"3600\",\"deposit\":\"3500\",\"nama_tenant\":\"1\",\"is_cashless\":\"1\",\"is_aktif\":\"0\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-06 11:56:38',NULL,NULL,NULL),
	(149530,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"jenis\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"tarif\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"6a29d223e9c934953f229937e9d773b6\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-06 11:56:48',NULL,NULL,NULL),
	(149531,'edit','/transtng/administrator/action','{\"id\":\"2\",\"x_token\":\"6a29d223e9c934953f229937e9d773b6\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-06 11:56:51',NULL,NULL,NULL),
	(149532,'insert','/transtng/administrator/action','{\"id\":\"2\",\"x_token\":\"6a29d223e9c934953f229937e9d773b6\",\"jenis\":\"Umum\",\"tarif\":\"3600\",\"deposit\":\"3500\",\"kategori\":\"8\",\"is_aktif\":\"0\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-06 11:57:01',NULL,NULL,NULL),
	(149533,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"jenis\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"tarif\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"6a29d223e9c934953f229937e9d773b6\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-06 11:57:01',NULL,NULL,NULL),
	(149534,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"jenis\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"tarif\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"6a29d223e9c934953f229937e9d773b6\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-06 11:57:01',NULL,NULL,NULL),
	(149535,'edit','/transtng/administrator/action','{\"id\":\"2\",\"x_token\":\"6a29d223e9c934953f229937e9d773b6\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-06 11:57:36',NULL,NULL,NULL),
	(149536,'edit','/transtng/administrator/action','{\"id\":\"2\",\"x_token\":\"6a29d223e9c934953f229937e9d773b6\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-06 11:57:38',NULL,NULL,NULL),
	(149537,'edit','/transtng/administrator/action','{\"id\":\"2\",\"x_token\":\"6a29d223e9c934953f229937e9d773b6\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-06 11:57:39',NULL,NULL,NULL),
	(149538,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"jenis\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"tarif\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"6a29d223e9c934953f229937e9d773b6\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-06 11:57:41',NULL,NULL,NULL),
	(149539,'edit','/transtng/administrator/action','{\"id\":\"2\",\"x_token\":\"6a29d223e9c934953f229937e9d773b6\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-06 11:57:46',NULL,NULL,NULL),
	(149540,'insert','/transtng/administrator/action','{\"id\":\"2\",\"x_token\":\"6a29d223e9c934953f229937e9d773b6\",\"jenis\":\"Umum\",\"tarif\":\"3600\",\"deposit\":\"3500\",\"kategori\":\"8\",\"is_aktif\":\"0\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-06 11:58:04',NULL,NULL,NULL),
	(149541,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"jenis\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"tarif\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"6a29d223e9c934953f229937e9d773b6\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-06 11:58:04',NULL,NULL,NULL),
	(149542,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"jenis\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"tarif\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"6a29d223e9c934953f229937e9d773b6\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-06 11:58:04',NULL,NULL,NULL),
	(149543,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"jenis\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"tarif\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"6a29d223e9c934953f229937e9d773b6\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-06 11:59:42',NULL,NULL,NULL),
	(149544,'edit','/transtng/administrator/action','{\"id\":\"2\",\"x_token\":\"6a29d223e9c934953f229937e9d773b6\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-06 11:59:46',NULL,NULL,NULL),
	(149545,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"jenis\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"tarif\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"6a29d223e9c934953f229937e9d773b6\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-06 11:59:59',NULL,NULL,NULL),
	(149546,'edit','/transtng/administrator/action','{\"id\":\"2\",\"x_token\":\"6a29d223e9c934953f229937e9d773b6\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-06 12:00:00',NULL,NULL,NULL),
	(149547,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"jenis\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"tarif\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"6a29d223e9c934953f229937e9d773b6\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-06 12:01:30',NULL,NULL,NULL),
	(149548,'edit','/transtng/administrator/action','{\"id\":\"2\",\"x_token\":\"6a29d223e9c934953f229937e9d773b6\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-06 12:01:32',NULL,NULL,NULL),
	(149549,'insert','/transtng/administrator/action','{\"id\":\"2\",\"x_token\":\"6a29d223e9c934953f229937e9d773b6\",\"jenis\":\"Umum\",\"tarif\":\"3600\",\"deposit\":\"3500\",\"kategori\":\"8\",\"is_cashless\":\"0\",\"is_aktif\":\"0\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-06 12:01:41',NULL,NULL,NULL),
	(149550,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"jenis\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"tarif\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"6a29d223e9c934953f229937e9d773b6\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-06 12:01:41',NULL,NULL,NULL),
	(149551,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"jenis\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"tarif\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"6a29d223e9c934953f229937e9d773b6\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-06 12:01:41',NULL,NULL,NULL),
	(149552,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"jenis\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"tenant_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"tarif\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"6a29d223e9c934953f229937e9d773b6\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-06 12:05:25',NULL,NULL,NULL),
	(149553,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"jenis\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"tenant_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"tarif\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"6a29d223e9c934953f229937e9d773b6\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-06 12:06:09',NULL,NULL,NULL),
	(149554,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"jenis\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"tenant_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"tarif\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"6a29d223e9c934953f229937e9d773b6\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-06 12:06:18',NULL,NULL,NULL),
	(149555,'edit','/transtng/administrator/action','{\"id\":\"1\",\"x_token\":\"6a29d223e9c934953f229937e9d773b6\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-06 12:06:26',NULL,NULL,NULL),
	(149556,'insert','/transtng/administrator/action','{\"id\":\"1\",\"x_token\":\"6a29d223e9c934953f229937e9d773b6\",\"jenis\":\"Transit\",\"tarif\":\"0\",\"deposit\":\"0\",\"kategori\":\"8\",\"is_cashless\":\"0\",\"is_aktif\":\"0\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-06 12:06:38',NULL,NULL,NULL),
	(149557,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"jenis\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"tenant_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"tarif\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"6a29d223e9c934953f229937e9d773b6\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-06 12:06:38',NULL,NULL,NULL),
	(149558,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"jenis\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"tenant_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"tarif\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"6a29d223e9c934953f229937e9d773b6\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-06 12:06:38',NULL,NULL,NULL),
	(149559,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"jenis\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"tenant_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"tarif\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"6a29d223e9c934953f229937e9d773b6\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-06 12:07:07',NULL,NULL,NULL),
	(149560,'edit','/transtng/administrator/action','{\"id\":\"1\",\"x_token\":\"6a29d223e9c934953f229937e9d773b6\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-06 12:07:10',NULL,NULL,NULL),
	(149561,'insert','/transtng/administrator/action','{\"id\":\"1\",\"x_token\":\"6a29d223e9c934953f229937e9d773b6\",\"jenis\":\"Transit\",\"tarif\":\"0\",\"deposit\":\"0\",\"kategori\":\"8\",\"is_cashless\":\"0\",\"is_aktif\":\"0\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-06 12:07:18',NULL,NULL,NULL),
	(149562,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"jenis\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"tenant_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"tarif\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"6a29d223e9c934953f229937e9d773b6\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-06 12:07:18',NULL,NULL,NULL),
	(149563,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"jenis\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"tenant_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"tarif\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"6a29d223e9c934953f229937e9d773b6\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-06 12:07:18',NULL,NULL,NULL),
	(149564,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"jenis\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"tenant_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"tarif\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"6a29d223e9c934953f229937e9d773b6\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-06 12:07:21',NULL,NULL,NULL),
	(149565,'edit','/transtng/administrator/action','{\"id\":\"1\",\"x_token\":\"6a29d223e9c934953f229937e9d773b6\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-06 12:07:22',NULL,NULL,NULL),
	(149566,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"jenis\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"tenant_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"tarif\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"6a29d223e9c934953f229937e9d773b6\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-06 12:08:42',NULL,NULL,NULL),
	(149567,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"jenis\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"tenant_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"tarif\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"6a29d223e9c934953f229937e9d773b6\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-06 12:13:47',NULL,NULL,NULL),
	(149568,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"jenis\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"tenant_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"tarif\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"6a29d223e9c934953f229937e9d773b6\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-06 12:14:12',NULL,NULL,NULL),
	(149569,'edit','/transtng/administrator/action','{\"id\":\"1\",\"x_token\":\"6a29d223e9c934953f229937e9d773b6\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-06 12:14:14',NULL,NULL,NULL),
	(149570,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"jenis\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"tenant_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"tarif\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"6a29d223e9c934953f229937e9d773b6\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-06 12:14:40',NULL,NULL,NULL),
	(149571,'edit','/transtng/administrator/action','{\"id\":\"1\",\"x_token\":\"6a29d223e9c934953f229937e9d773b6\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-06 12:14:42',NULL,NULL,NULL),
	(149572,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"jenis\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"tenant_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"tarif\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"6a29d223e9c934953f229937e9d773b6\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-06 12:14:53',NULL,NULL,NULL),
	(149573,'edit','/transtng/administrator/action','{\"id\":\"1\",\"x_token\":\"6a29d223e9c934953f229937e9d773b6\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-06 12:14:55',NULL,NULL,NULL),
	(149574,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"jenis\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"tenant_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"tarif\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"6a29d223e9c934953f229937e9d773b6\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-06 12:15:08',NULL,NULL,NULL),
	(149575,'edit','/transtng/administrator/action','{\"id\":\"1\",\"x_token\":\"6a29d223e9c934953f229937e9d773b6\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-06 12:15:09',NULL,NULL,NULL),
	(149576,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"jenis\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"tenant_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"tarif\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"6a29d223e9c934953f229937e9d773b6\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-06 13:15:32',NULL,NULL,NULL),
	(149577,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"jenis\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"tenant_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"tarif\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"6a29d223e9c934953f229937e9d773b6\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-06 13:17:18',NULL,NULL,NULL),
	(149578,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"jenis\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"tenant_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"tarif\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"6a29d223e9c934953f229937e9d773b6\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-06 13:21:04',NULL,NULL,NULL),
	(149579,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"jenis\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"tenant_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"tarif\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"6a29d223e9c934953f229937e9d773b6\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-06 13:21:06',NULL,NULL,NULL),
	(149580,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"header\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"footer\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"2533cab0290d87884567c96ddafcc073\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-06 13:50:36',NULL,NULL,NULL),
	(149581,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"header\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"footer\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"2533cab0290d87884567c96ddafcc073\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-06 13:51:39',NULL,NULL,NULL),
	(149582,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"header\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"footer\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"2533cab0290d87884567c96ddafcc073\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-06 13:52:36',NULL,NULL,NULL),
	(149583,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"header\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"footer\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"2533cab0290d87884567c96ddafcc073\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-06 13:52:44',NULL,NULL,NULL),
	(149584,'insert','/transtng/administrator/action','{\"id\":\"\",\"x_token\":\"2533cab0290d87884567c96ddafcc073\",\"header\":\"@TransTangerang\",\"footer\":\"Transit berlaku selama | tidak meninggalkan halte | Jika transaksi bermasalah | silahkan hubungi | 081299992222\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-06 13:53:51',NULL,NULL,NULL),
	(149585,'insert','/transtng/administrator/action','{\"id\":\"\",\"x_token\":\"2533cab0290d87884567c96ddafcc073\",\"header\":\"@TransTangerang\",\"footer\":\"Transit berlaku selama | tidak meninggalkan halte | Jika transaksi bermasalah | silahkan hubungi | 081299992222\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-06 13:54:26',NULL,NULL,NULL),
	(149586,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"header\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"footer\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"2533cab0290d87884567c96ddafcc073\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-06 13:54:31',NULL,NULL,NULL),
	(149587,'insert','/transtng/administrator/action','{\"id\":\"\",\"x_token\":\"2533cab0290d87884567c96ddafcc073\",\"header\":\"@TransTangerang\",\"footer\":\"Transit berlaku selama | tidak meninggalkan halte | Jika transaksi bermasalah | silahkan hubungi | 08129999222\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-06 13:55:06',NULL,NULL,NULL),
	(149588,'insert','/transtng/administrator/action','{\"id\":\"\",\"x_token\":\"2533cab0290d87884567c96ddafcc073\",\"header\":\"@TransTangerang\",\"footer\":\"Transit berlaku selama | tidak meninggalkan halte | Jika transaksi bermasalah | silahkan hubungi | 08129999222\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-06 13:56:07',NULL,NULL,NULL),
	(149589,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"headers\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"footer\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"2533cab0290d87884567c96ddafcc073\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-06 13:56:14',NULL,NULL,NULL),
	(149590,'insert','/transtng/administrator/action','{\"id\":\"\",\"x_token\":\"2533cab0290d87884567c96ddafcc073\",\"headers\":\"@TransTangerang\",\"footers\":\"Transit berlaku selama | tidak meninggalkan halte | Jika transaksi bermasalah | silahkan hubungi | 08129999222\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-06 13:56:27',NULL,NULL,NULL),
	(149591,'insert','/transtng/administrator/action','{\"id\":\"\",\"x_token\":\"2533cab0290d87884567c96ddafcc073\",\"headers\":\"@TransTangerang\",\"footers\":\"Transit berlaku selama | tidak meninggalkan halte | Jika transaksi bermasalah | silahkan hubungi | 08129999222\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-06 13:58:42',NULL,NULL,NULL),
	(149592,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"headers\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"footer\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"2533cab0290d87884567c96ddafcc073\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-06 13:58:42',NULL,NULL,NULL),
	(149593,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"headers\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"footer\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"2533cab0290d87884567c96ddafcc073\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-06 13:58:42',NULL,NULL,NULL),
	(149594,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"headers\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"footer\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"2533cab0290d87884567c96ddafcc073\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-06 13:58:47',NULL,NULL,NULL),
	(149595,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"headers\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"footers\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"2533cab0290d87884567c96ddafcc073\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-06 13:59:03',NULL,NULL,NULL),
	(149596,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"headers\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"footers\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"2533cab0290d87884567c96ddafcc073\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-06 14:02:57',NULL,NULL,NULL),
	(149597,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"headers\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"footers\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"2533cab0290d87884567c96ddafcc073\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-06 14:15:30',NULL,NULL,NULL),
	(149598,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"headers\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"footers\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"2533cab0290d87884567c96ddafcc073\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-06 15:16:29',NULL,NULL,NULL),
	(149599,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"headers\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"footers\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"2533cab0290d87884567c96ddafcc073\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-06 15:23:01',NULL,NULL,NULL),
	(149600,'login','/transtng/auth/action/login','{\"x_token\":\"ec993c0712e59d654fd599fcf2044222\",\"username\":\"mitra\",\"password\":\"6f6b220c7cdad5267bdf12a6d90c620d\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-10 09:14:52',NULL,NULL,NULL),
	(149601,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"headers\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"footers\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"ec993c0712e59d654fd599fcf2044222\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-10 09:15:52',NULL,NULL,NULL),
	(149602,'login','/transtng/auth/action/login','{\"x_token\":\"0b1e46b9f814db796c630f66088cee63\",\"username\":\"mitra\",\"password\":\"6f6b220c7cdad5267bdf12a6d90c620d\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-10 12:35:15',NULL,NULL,NULL),
	(149603,'login','/transtng/auth/action/login','{\"x_token\":\"eafd05d1e17563bd524da62b33acce60\",\"username\":\"mitra\",\"password\":\"6f6b220c7cdad5267bdf12a6d90c620d\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-11 09:10:09',NULL,NULL,NULL),
	(149604,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"eafd05d1e17563bd524da62b33acce60\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-11 09:25:16',NULL,NULL,NULL),
	(149605,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"eafd05d1e17563bd524da62b33acce60\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-11 09:25:41',NULL,NULL,NULL),
	(149606,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"eafd05d1e17563bd524da62b33acce60\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-11 09:25:57',NULL,NULL,NULL),
	(149607,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"nama_pegawai\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"telp\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"eafd05d1e17563bd524da62b33acce60\"}','Akses Ditolak','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-11 10:32:48',NULL,NULL,NULL),
	(149608,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"nama_pegawai\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"telp\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"eafd05d1e17563bd524da62b33acce60\"}','Akses Ditolak','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-11 10:49:22',NULL,NULL,NULL),
	(149609,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"fullname\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"telp\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"eafd05d1e17563bd524da62b33acce60\"}','Akses Ditolak','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-11 10:54:58',NULL,NULL,NULL),
	(149610,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"fullname\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"telp\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"eafd05d1e17563bd524da62b33acce60\"}','Akses Ditolak','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-11 11:02:22',NULL,NULL,NULL),
	(149611,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"fullname\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"telp\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"eafd05d1e17563bd524da62b33acce60\"}','Akses Ditolak','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-11 11:03:43',NULL,NULL,NULL),
	(149612,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"fullname\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"telp\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"eafd05d1e17563bd524da62b33acce60\"}','Akses Ditolak','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-11 11:03:54',NULL,NULL,NULL),
	(149613,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"fullname\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"telp\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"eafd05d1e17563bd524da62b33acce60\"}','Akses Ditolak','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-11 11:04:41',NULL,NULL,NULL),
	(149614,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"fullname\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"telp\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"eafd05d1e17563bd524da62b33acce60\"}','Akses Ditolak','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-11 11:05:19',NULL,NULL,NULL),
	(149615,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"fullname\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"telp\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"eafd05d1e17563bd524da62b33acce60\"}','Akses Ditolak','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-11 11:08:10',NULL,NULL,NULL),
	(149616,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"fullname\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"telp\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"eafd05d1e17563bd524da62b33acce60\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-11 11:08:18',NULL,NULL,NULL),
	(149617,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"fullname\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"telp\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"eafd05d1e17563bd524da62b33acce60\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-11 11:09:03',NULL,NULL,NULL),
	(149618,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"fullname\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"telp\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"eafd05d1e17563bd524da62b33acce60\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-11 11:09:11',NULL,NULL,NULL),
	(149619,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"fullname\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"telp\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"eafd05d1e17563bd524da62b33acce60\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-11 11:09:49',NULL,NULL,NULL),
	(149620,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"fullname\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"telp\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"50f26766239b24905d59416800806ced\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-11 11:10:21',NULL,NULL,NULL),
	(149621,'insert','/transtng/administrator/action','{\"id\":\"\",\"x_token\":\"50f26766239b24905d59416800806ced\",\"fullname\":\"REYNALDO\",\"username\":\"rcrz__\",\"password\":\"6f6b220c7cdad5267bdf12a6d90c620d\",\"idjab\":\"5\",\"jabtext\":\"PRAMUGARA\",\"email\":\"koesanto.r@gmail.com\",\"noktp\":\"3674041708960008\",\"phone\":\"+6281295385911\",\"cob\":\"TANGERANG\",\"dob\":\"2023-04-11\",\"addr\":\"JALAN CITANDUY C2\\/10 SARUA PERMAI, SARUA, CIPUTAT, TANGERANG SELATAN, BANTEN - 15414\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-11 11:10:48',NULL,NULL,NULL),
	(149622,'insert','/transtng/administrator/action','{\"id\":\"\",\"x_token\":\"50f26766239b24905d59416800806ced\",\"fullname\":\"REYNALDO\",\"username\":\"rcrz__\",\"password\":\"6f6b220c7cdad5267bdf12a6d90c620d\",\"idjab\":\"5\",\"jabtext\":\"PRAMUGARA\",\"email\":\"koesanto.r@gmail.com\",\"noktp\":\"3674041708960008\",\"phone\":\"+6281295385911\",\"cob\":\"TANGERANG\",\"dob\":\"2023-04-11\",\"addr\":\"JALAN CITANDUY C2\\/10 SARUA PERMAI, SARUA, CIPUTAT, TANGERANG SELATAN, BANTEN - 15414\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-11 11:12:50',NULL,NULL,NULL),
	(149623,'insert','/transtng/administrator/action','{\"id\":\"\",\"x_token\":\"50f26766239b24905d59416800806ced\",\"fullname\":\"REYNALDO\",\"username\":\"rcrz__\",\"password\":\"6f6b220c7cdad5267bdf12a6d90c620d\",\"idjab\":\"5\",\"jabtext\":\"PRAMUGARA\",\"email\":\"koesanto.r@gmail.com\",\"noktp\":\"3674041708960008\",\"phone\":\"+6281295385911\",\"cob\":\"TANGERANG\",\"dob\":\"2023-04-11\",\"addr\":\"JALAN CITANDUY C2\\/10 SARUA PERMAI, SARUA, CIPUTAT, TANGERANG SELATAN, BANTEN - 15414\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-11 11:13:30',NULL,NULL,NULL),
	(149624,'insert','/transtng/administrator/action','{\"id\":\"\",\"x_token\":\"50f26766239b24905d59416800806ced\",\"fullname\":\"REYNALDO\",\"username\":\"rcrz__\",\"password\":\"6f6b220c7cdad5267bdf12a6d90c620d\",\"idjab\":\"5\",\"jabtext\":\"PRAMUGARA\",\"email\":\"koesanto.r@gmail.com\",\"noktp\":\"3674041708960008\",\"phone\":\"+6281295385911\",\"cob\":\"TANGERANG\",\"dob\":\"2023-04-11\",\"addr\":\"JALAN CITANDUY C2\\/10 SARUA PERMAI, SARUA, CIPUTAT, TANGERANG SELATAN, BANTEN - 15414\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-11 11:14:20',NULL,NULL,NULL),
	(149625,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"fullname\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"telp\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"50f26766239b24905d59416800806ced\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-11 11:14:29',NULL,NULL,NULL),
	(149626,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"fullname\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"telp\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"50f26766239b24905d59416800806ced\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-11 11:15:07',NULL,NULL,NULL),
	(149627,'insert','/transtng/administrator/action','{\"id\":\"\",\"x_token\":\"50f26766239b24905d59416800806ced\",\"fullname\":\"REYNALDO\",\"username\":\"rcrz__\",\"password\":\"6f6b220c7cdad5267bdf12a6d90c620d\",\"idjab\":\"5\",\"jabtext\":\"PRAMUGARA\",\"email\":\"koesanto.r@gmail.com\",\"noktp\":\"3674041708960008\",\"phone\":\"+6281295385911\",\"cob\":\"TANGERANG\",\"dob\":\"2023-04-11\",\"addr\":\"JALAN CITANDUY C2\\/10 SARUA PERMAI, SARUA, CIPUTAT, TANGERANG SELATAN, BANTEN - 15414\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-11 11:15:33',NULL,NULL,NULL),
	(149628,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"fullname\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"telp\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"50f26766239b24905d59416800806ced\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-11 11:31:02',NULL,NULL,NULL),
	(149629,'insert','/transtng/administrator/action','{\"id\":\"\",\"x_token\":\"50f26766239b24905d59416800806ced\",\"fullname\":\"REYNALDO\",\"username\":\"rcrz__\",\"password\":\"6f6b220c7cdad5267bdf12a6d90c620d\",\"idjab\":\"5\",\"jabtext\":\"PRAMUGARA\",\"email\":\"koesanto.r@gmail.com\",\"noktp\":\"3674041708960008\",\"phone\":\"+6281295385911\",\"cob\":\"TANGERANG\",\"dob\":\"2023-04-11\",\"addr\":\"JALAN CITANDUY C2\\/10 SARUA PERMAI, SARUA, CIPUTAT, TANGERANG SELATAN, BANTEN - 15414\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-11 11:31:21',NULL,NULL,NULL),
	(149630,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"fullname\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"telp\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"50f26766239b24905d59416800806ced\"}','Akses Ditolak','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-11 11:31:30',NULL,NULL,NULL),
	(149631,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"fullname\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"telp\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"50f26766239b24905d59416800806ced\"}','Akses Ditolak','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-11 11:31:31',NULL,NULL,NULL),
	(149632,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"fullname\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"telp\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"50f26766239b24905d59416800806ced\"}','Akses Ditolak','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-11 11:31:32',NULL,NULL,NULL),
	(149633,'insert','/transtng/administrator/action','{\"id\":\"\",\"x_token\":\"50f26766239b24905d59416800806ced\",\"fullname\":\"REYNALDO\",\"username\":\"rcrz__\",\"password\":\"6f6b220c7cdad5267bdf12a6d90c620d\",\"idjab\":\"5\",\"jabtext\":\"PRAMUGARA\",\"email\":\"koesanto.r@gmail.com\",\"noktp\":\"3674041708960008\",\"phone\":\"+6281295385911\",\"cob\":\"TANGERANG\",\"dob\":\"2023-04-11\",\"addr\":\"JALAN CITANDUY C2\\/10 SARUA PERMAI, SARUA, CIPUTAT, TANGERANG SELATAN, BANTEN - 15414\"}','Akses Ditolak','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-11 11:31:53',NULL,NULL,NULL),
	(149634,'insert','/transtng/administrator/action','{\"id\":\"\",\"x_token\":\"50f26766239b24905d59416800806ced\",\"fullname\":\"REYNALDO\",\"username\":\"rcrz__\",\"password\":\"6f6b220c7cdad5267bdf12a6d90c620d\",\"idjab\":\"5\",\"jabtext\":\"PRAMUGARA\",\"email\":\"koesanto.r@gmail.com\",\"noktp\":\"3674041708960008\",\"phone\":\"+6281295385911\",\"cob\":\"TANGERANG\",\"dob\":\"2023-04-11\",\"addr\":\"JALAN CITANDUY C2\\/10 SARUA PERMAI, SARUA, CIPUTAT, TANGERANG SELATAN, BANTEN - 15414\"}','Akses Ditolak','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-11 11:32:06',NULL,NULL,NULL),
	(149635,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"fullname\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"telp\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"50f26766239b24905d59416800806ced\"}','Akses Ditolak','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-11 11:32:25',NULL,NULL,NULL),
	(149636,'insert','/transtng/administrator/action','{\"x_token\":\"50f26766239b24905d59416800806ced\",\"fullname\":\"REYNALDO\",\"username\":\"rcrz__\",\"password\":\"6f6b220c7cdad5267bdf12a6d90c620d\",\"idjab\":\"5\",\"jabtext\":\"PRAMUGARA\",\"email\":\"koesanto.r@gmail.com\",\"noktp\":\"3674041708960008\",\"phone\":\"+6281295385911\",\"cob\":\"TANGERANG\",\"dob\":\"2023-04-11\",\"addr\":\"JALAN CITANDUY C2\\/10 SARUA PERMAI, SARUA, CIPUTAT, TANGERANG SELATAN, BANTEN - 15414\"}','Akses Ditolak','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-11 11:32:49',NULL,NULL,NULL),
	(149637,'insert','/transtng/administrator/action','{\"x_token\":\"50f26766239b24905d59416800806ced\",\"fullname\":\"REYNALDO\",\"username\":\"rcrz__\",\"password\":\"6f6b220c7cdad5267bdf12a6d90c620d\",\"idjab\":\"5\",\"jabtext\":\"PRAMUGARA\",\"email\":\"koesanto.r@gmail.com\",\"noktp\":\"3674041708960008\",\"phone\":\"+6281295385911\",\"cob\":\"TANGERANG\",\"dob\":\"2023-04-11\",\"addr\":\"JALAN CITANDUY C2\\/10 SARUA PERMAI, SARUA, CIPUTAT, TANGERANG SELATAN, BANTEN - 15414\"}','Akses Ditolak','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-11 11:36:14',NULL,NULL,NULL),
	(149638,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"fullname\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"telp\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"50f26766239b24905d59416800806ced\"}','Akses Ditolak','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-11 11:43:01',NULL,NULL,NULL),
	(149639,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"fullname\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"telp\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"50f26766239b24905d59416800806ced\"}','Akses Ditolak','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-11 11:45:23',NULL,NULL,NULL),
	(149640,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"headers\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"footers\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"5062e7a3d7636ef585bba6a8a8d17029\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-11 13:32:48',NULL,NULL,NULL),
	(149641,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"jenis\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"tenant_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"tarif\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"5062e7a3d7636ef585bba6a8a8d17029\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-11 13:32:51',NULL,NULL,NULL),
	(149642,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"fullname\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"telp\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"5062e7a3d7636ef585bba6a8a8d17029\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-11 13:38:40',NULL,NULL,NULL),
	(149643,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"5062e7a3d7636ef585bba6a8a8d17029\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-11 15:07:39',NULL,NULL,NULL),
	(149644,'insert','/transtng/administrator/action','{\"id\":\"\",\"x_token\":\"5062e7a3d7636ef585bba6a8a8d17029\",\"module_name\":\"EKSEKUTIF MENU\",\"module_url\":\"eksekutif\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-11 15:08:38',NULL,NULL,NULL),
	(149645,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"5062e7a3d7636ef585bba6a8a8d17029\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-11 15:08:39',NULL,NULL,NULL),
	(149646,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_parent\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"5062e7a3d7636ef585bba6a8a8d17029\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-11 15:08:44',NULL,NULL,NULL),
	(149647,'insert','/transtng/administrator/action','{\"id\":\"\",\"x_token\":\"5062e7a3d7636ef585bba6a8a8d17029\",\"module_id\":\"3\",\"menu_id\":\"\",\"menu_name\":\"Menu Eksekutif\",\"menu_url\":\"#\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-11 15:09:26',NULL,NULL,NULL),
	(149648,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_parent\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"5062e7a3d7636ef585bba6a8a8d17029\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-11 15:09:26',NULL,NULL,NULL);

INSERT INTO `s_log_privilege` (`id`, `log_action`, `log_url`, `log_param`, `log_result`, `log_ip`, `log_user_agent`, `user_web_id`, `is_deleted`, `created_at`, `created_by`, `last_edited_at`, `last_edited_by`)
VALUES
	(149649,'insert','/transtng/administrator/action','{\"id\":\"\",\"x_token\":\"5062e7a3d7636ef585bba6a8a8d17029\",\"module_id\":\"3\",\"menu_id\":\"73\",\"menu_name\":\"Informasi Transaksi 30 Hari Terakhir\",\"menu_url\":\"info30haritransaksi\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-11 15:10:06',NULL,NULL,NULL),
	(149650,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_parent\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"5062e7a3d7636ef585bba6a8a8d17029\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-11 15:10:06',NULL,NULL,NULL),
	(149651,'insert','/transtng/administrator/action','{\"delete\":\"\",\"x_token\":\"5062e7a3d7636ef585bba6a8a8d17029\",\"iduser\":\"1\",\"id\":[\"1\",\"2\",\"8\",\"9\",\"10\",\"3\",\"4\",\"5\",\"12\",\"13\",\"14\",\"15\",\"0\"],\"idmenu\":[\"1\",\"2\",\"64\",\"65\",\"66\",\"3\",\"4\",\"5\",\"68\",\"69\",\"70\",\"72\",\"74\"],\"check_all\":[\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\"],\"v\":[\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\"],\"i\":[\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\"],\"e\":[\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\"],\"d\":[\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\"],\"o\":[\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\"],\"idmodule\":{\"3\":\"3\"}}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-11 15:10:20',NULL,NULL,NULL),
	(149652,'login','/transtng/auth/action/login','{\"x_token\":\"5062e7a3d7636ef585bba6a8a8d17029\",\"username\":\"mitra\",\"password\":\"6f6b220c7cdad5267bdf12a6d90c620d\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-11 15:10:26',NULL,NULL,NULL),
	(149653,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"5062e7a3d7636ef585bba6a8a8d17029\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-11 15:11:31',NULL,NULL,NULL),
	(149654,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"5062e7a3d7636ef585bba6a8a8d17029\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-11 15:11:37',NULL,NULL,NULL),
	(149655,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_parent\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"5062e7a3d7636ef585bba6a8a8d17029\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-11 15:11:38',NULL,NULL,NULL),
	(149656,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_parent\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"5062e7a3d7636ef585bba6a8a8d17029\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-11 15:11:56',NULL,NULL,NULL),
	(149657,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_parent\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"10\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"5062e7a3d7636ef585bba6a8a8d17029\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-11 15:12:00',NULL,NULL,NULL),
	(149658,'edit','/transtng/administrator/action','{\"id\":\"74\",\"x_token\":\"5062e7a3d7636ef585bba6a8a8d17029\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-11 15:12:03',NULL,NULL,NULL),
	(149659,'insert','/transtng/administrator/action','{\"id\":\"74\",\"x_token\":\"5062e7a3d7636ef585bba6a8a8d17029\",\"module_id\":\"3\",\"menu_id\":\"73\",\"menu_name\":\"Transaksi 30 Hari Terakhir\",\"menu_url\":\"info30haritransaksi\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-11 15:12:12',NULL,NULL,NULL),
	(149660,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_parent\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"5062e7a3d7636ef585bba6a8a8d17029\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-11 15:12:12',NULL,NULL,NULL),
	(149661,'login','/transtng/auth/action/login','{\"x_token\":\"5062e7a3d7636ef585bba6a8a8d17029\",\"username\":\"mitra\",\"password\":\"6f6b220c7cdad5267bdf12a6d90c620d\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-11 15:12:17',NULL,NULL,NULL),
	(149662,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_parent\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"5062e7a3d7636ef585bba6a8a8d17029\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-11 15:12:24',NULL,NULL,NULL),
	(149663,'insert','/transtng/administrator/action','{\"id\":\"\",\"x_token\":\"5062e7a3d7636ef585bba6a8a8d17029\",\"module_id\":\"3\",\"menu_id\":\"73\",\"menu_name\":\"Laporan Detail\",\"menu_url\":\"#\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-11 15:12:48',NULL,NULL,NULL),
	(149664,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_parent\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"5062e7a3d7636ef585bba6a8a8d17029\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-11 15:12:48',NULL,NULL,NULL),
	(149665,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_parent\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"5062e7a3d7636ef585bba6a8a8d17029\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-11 15:13:04',NULL,NULL,NULL),
	(149666,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_parent\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"5062e7a3d7636ef585bba6a8a8d17029\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-11 15:13:14',NULL,NULL,NULL),
	(149667,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_parent\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"10\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"5062e7a3d7636ef585bba6a8a8d17029\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-11 15:13:19',NULL,NULL,NULL),
	(149668,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_parent\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"5062e7a3d7636ef585bba6a8a8d17029\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-11 15:15:22',NULL,NULL,NULL),
	(149669,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_parent\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"10\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"5062e7a3d7636ef585bba6a8a8d17029\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-11 15:15:26',NULL,NULL,NULL),
	(149670,'edit','/transtng/administrator/action','{\"id\":\"75\",\"x_token\":\"5062e7a3d7636ef585bba6a8a8d17029\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-11 15:15:29',NULL,NULL,NULL),
	(149671,'insert','/transtng/administrator/action','{\"id\":\"75\",\"x_token\":\"5062e7a3d7636ef585bba6a8a8d17029\",\"module_id\":\"3\",\"menu_id\":\"\",\"menu_name\":\"Laporan Detail\",\"menu_url\":\"#\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-11 15:15:38',NULL,NULL,NULL),
	(149672,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_parent\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"5062e7a3d7636ef585bba6a8a8d17029\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-11 15:15:38',NULL,NULL,NULL),
	(149673,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_parent\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"5062e7a3d7636ef585bba6a8a8d17029\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-11 15:15:56',NULL,NULL,NULL),
	(149674,'insert','/transtng/administrator/action','{\"id\":\"\",\"x_token\":\"5062e7a3d7636ef585bba6a8a8d17029\",\"module_id\":\"3\",\"menu_id\":\"75\",\"menu_name\":\"Transaksi Periodik\",\"menu_url\":\"laptransaksimesinkartu\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-11 15:16:19',NULL,NULL,NULL),
	(149675,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_parent\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"5062e7a3d7636ef585bba6a8a8d17029\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-11 15:16:19',NULL,NULL,NULL),
	(149676,'insert','/transtng/administrator/action','{\"delete\":\"\",\"x_token\":\"5062e7a3d7636ef585bba6a8a8d17029\",\"iduser\":\"1\",\"id\":[\"1\",\"2\",\"8\",\"9\",\"10\",\"3\",\"4\",\"5\",\"12\",\"13\",\"14\",\"15\",\"16\",\"0\"],\"idmenu\":[\"1\",\"2\",\"64\",\"65\",\"66\",\"3\",\"4\",\"5\",\"68\",\"69\",\"70\",\"72\",\"74\",\"76\"],\"check_all\":[\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\"],\"v\":[\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\"],\"i\":[\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\"],\"e\":[\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\"],\"d\":[\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\"],\"o\":[\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\"]}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-11 15:16:27',NULL,NULL,NULL),
	(149677,'login','/transtng/auth/action/login','{\"x_token\":\"5062e7a3d7636ef585bba6a8a8d17029\",\"username\":\"mitra\",\"password\":\"6f6b220c7cdad5267bdf12a6d90c620d\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-11 15:16:35',NULL,NULL,NULL),
	(149678,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_parent\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"5062e7a3d7636ef585bba6a8a8d17029\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-11 15:16:54',NULL,NULL,NULL),
	(149679,'insert','/transtng/administrator/action','{\"id\":\"\",\"x_token\":\"5062e7a3d7636ef585bba6a8a8d17029\",\"module_id\":\"3\",\"menu_id\":\"75\",\"menu_name\":\"Transaksi (PTA)\",\"menu_url\":\"cekpta\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-11 15:17:15',NULL,NULL,NULL),
	(149680,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_parent\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"5062e7a3d7636ef585bba6a8a8d17029\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-11 15:17:15',NULL,NULL,NULL),
	(149681,'insert','/transtng/administrator/action','{\"id\":\"\",\"x_token\":\"5062e7a3d7636ef585bba6a8a8d17029\",\"module_id\":\"3\",\"menu_id\":\"75\",\"menu_name\":\"Transaksi Jalur\",\"menu_url\":\"lapkoridor\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-11 15:17:38',NULL,NULL,NULL),
	(149682,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_parent\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"5062e7a3d7636ef585bba6a8a8d17029\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-11 15:17:38',NULL,NULL,NULL),
	(149683,'insert','/transtng/administrator/action','{\"id\":\"\",\"x_token\":\"5062e7a3d7636ef585bba6a8a8d17029\",\"module_id\":\"3\",\"menu_id\":\"75\",\"menu_name\":\"Data Kartu Baru\",\"menu_url\":\"lapdatakartubaru\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-11 15:18:04',NULL,NULL,NULL),
	(149684,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_parent\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"5062e7a3d7636ef585bba6a8a8d17029\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-11 15:18:04',NULL,NULL,NULL),
	(149685,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"fullname\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"telp\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"5062e7a3d7636ef585bba6a8a8d17029\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-11 15:18:09',NULL,NULL,NULL),
	(149686,'insert','/transtng/administrator/action','{\"delete\":\"\",\"x_token\":\"5062e7a3d7636ef585bba6a8a8d17029\",\"iduser\":\"1\",\"id\":[\"1\",\"2\",\"8\",\"9\",\"10\",\"3\",\"4\",\"5\",\"12\",\"13\",\"14\",\"15\",\"16\",\"17\",\"0\",\"0\",\"0\"],\"idmenu\":[\"1\",\"2\",\"64\",\"65\",\"66\",\"3\",\"4\",\"5\",\"68\",\"69\",\"70\",\"72\",\"74\",\"76\",\"77\",\"78\",\"79\"],\"check_all\":[\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\"],\"v\":[\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\"],\"i\":[\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\"],\"e\":[\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\"],\"d\":[\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\"],\"o\":[\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\"]}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-11 15:18:17',NULL,NULL,NULL),
	(149687,'login','/transtng/auth/action/login','{\"x_token\":\"5062e7a3d7636ef585bba6a8a8d17029\",\"username\":\"mitra\",\"password\":\"6f6b220c7cdad5267bdf12a6d90c620d\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-11 15:18:22',NULL,NULL,NULL),
	(149688,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_parent\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"5062e7a3d7636ef585bba6a8a8d17029\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-11 15:18:39',NULL,NULL,NULL),
	(149689,'insert','/transtng/administrator/action','{\"id\":\"\",\"x_token\":\"5062e7a3d7636ef585bba6a8a8d17029\",\"module_id\":\"3\",\"menu_id\":\"75\",\"menu_name\":\"Riwayat Top Up\",\"menu_url\":\"laptopup\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-11 15:19:43',NULL,NULL,NULL),
	(149690,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_parent\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"5062e7a3d7636ef585bba6a8a8d17029\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-11 15:19:43',NULL,NULL,NULL),
	(149691,'insert','/transtng/administrator/action','{\"id\":\"\",\"x_token\":\"5062e7a3d7636ef585bba6a8a8d17029\",\"module_id\":\"3\",\"menu_id\":\"75\",\"menu_name\":\"Info Penumpang\\/Jam\\/Jalur\",\"menu_url\":\"lappenumpangjamkor\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-11 15:20:14',NULL,NULL,NULL),
	(149692,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_parent\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"5062e7a3d7636ef585bba6a8a8d17029\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-11 15:20:14',NULL,NULL,NULL),
	(149693,'insert','/transtng/administrator/action','{\"id\":\"\",\"x_token\":\"5062e7a3d7636ef585bba6a8a8d17029\",\"module_id\":\"3\",\"menu_id\":\"75\",\"menu_name\":\"Cek Mutasi Kartu\",\"menu_url\":\"cekmutasikartu\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-11 15:20:34',NULL,NULL,NULL),
	(149694,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_parent\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"5062e7a3d7636ef585bba6a8a8d17029\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-11 15:20:34',NULL,NULL,NULL),
	(149695,'insert','/transtng/administrator/action','{\"id\":\"\",\"x_token\":\"5062e7a3d7636ef585bba6a8a8d17029\",\"module_id\":\"3\",\"menu_id\":\"75\",\"menu_name\":\"Rekap Transaksi Per-Pos\",\"menu_url\":\"rekapposharian\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-11 15:20:55',NULL,NULL,NULL),
	(149696,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_parent\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"5062e7a3d7636ef585bba6a8a8d17029\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-11 15:20:55',NULL,NULL,NULL),
	(149697,'insert','/transtng/administrator/action','{\"id\":\"\",\"x_token\":\"5062e7a3d7636ef585bba6a8a8d17029\",\"module_id\":\"3\",\"menu_id\":\"75\",\"menu_name\":\"Laporan Pesanan Tiket\",\"menu_url\":\"lappesantiket\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-11 15:21:29',NULL,NULL,NULL),
	(149698,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_parent\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"5062e7a3d7636ef585bba6a8a8d17029\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-11 15:21:29',NULL,NULL,NULL),
	(149699,'insert','/transtng/administrator/action','{\"id\":\"\",\"x_token\":\"5062e7a3d7636ef585bba6a8a8d17029\",\"module_id\":\"3\",\"menu_id\":\"75\",\"menu_name\":\"Pembaruan Kartu\",\"menu_url\":\"pembaruankartu\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-11 15:21:49',NULL,NULL,NULL),
	(149700,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_parent\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"5062e7a3d7636ef585bba6a8a8d17029\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-11 15:21:49',NULL,NULL,NULL),
	(149701,'insert','/transtng/administrator/action','{\"delete\":\"\",\"x_token\":\"5062e7a3d7636ef585bba6a8a8d17029\",\"iduser\":\"1\",\"id\":[\"1\",\"2\",\"8\",\"9\",\"10\",\"3\",\"4\",\"5\",\"12\",\"13\",\"14\",\"15\",\"16\",\"17\",\"18\",\"19\",\"20\",\"0\",\"0\",\"0\",\"0\",\"0\",\"0\"],\"idmenu\":[\"1\",\"2\",\"64\",\"65\",\"66\",\"3\",\"4\",\"5\",\"68\",\"69\",\"70\",\"72\",\"74\",\"76\",\"77\",\"78\",\"79\",\"80\",\"81\",\"82\",\"83\",\"84\",\"85\"],\"check_all\":[\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\"],\"v\":[\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\"],\"i\":[\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\"],\"e\":[\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\"],\"d\":[\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\"],\"o\":[\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\"]}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-11 15:22:07',NULL,NULL,NULL),
	(149702,'login','/transtng/auth/action/login','{\"x_token\":\"5062e7a3d7636ef585bba6a8a8d17029\",\"username\":\"mitra\",\"password\":\"6f6b220c7cdad5267bdf12a6d90c620d\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-11 15:22:12',NULL,NULL,NULL),
	(149703,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_parent\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"5062e7a3d7636ef585bba6a8a8d17029\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-11 15:22:31',NULL,NULL,NULL),
	(149704,'insert','/transtng/administrator/action','{\"id\":\"\",\"x_token\":\"5062e7a3d7636ef585bba6a8a8d17029\",\"module_id\":\"3\",\"menu_id\":\"\",\"menu_name\":\"Grafik\",\"menu_url\":\"#\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-11 15:23:01',NULL,NULL,NULL),
	(149705,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_parent\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"5062e7a3d7636ef585bba6a8a8d17029\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-11 15:23:01',NULL,NULL,NULL),
	(149706,'insert','/transtng/administrator/action','{\"id\":\"\",\"x_token\":\"5062e7a3d7636ef585bba6a8a8d17029\",\"module_id\":\"3\",\"menu_id\":\"86\",\"menu_name\":\"Transaksi Per-Jenis\",\"menu_url\":\"grafiktransaksimesinkartu\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-11 15:23:20',NULL,NULL,NULL),
	(149707,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_parent\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"5062e7a3d7636ef585bba6a8a8d17029\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-11 15:23:20',NULL,NULL,NULL),
	(149708,'insert','/transtng/administrator/action','{\"delete\":\"\",\"x_token\":\"5062e7a3d7636ef585bba6a8a8d17029\",\"iduser\":\"1\",\"id\":[\"1\",\"2\",\"8\",\"9\",\"10\",\"3\",\"4\",\"5\",\"12\",\"13\",\"14\",\"15\",\"16\",\"17\",\"18\",\"19\",\"20\",\"21\",\"22\",\"23\",\"24\",\"25\",\"26\",\"0\"],\"idmenu\":[\"1\",\"2\",\"64\",\"65\",\"66\",\"3\",\"4\",\"5\",\"68\",\"69\",\"70\",\"72\",\"74\",\"76\",\"77\",\"78\",\"79\",\"80\",\"81\",\"82\",\"83\",\"84\",\"85\",\"87\"],\"check_all\":[\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\"],\"v\":[\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\"],\"i\":[\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\"],\"e\":[\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\"],\"d\":[\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\"],\"o\":[\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\"]}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-11 15:23:31',NULL,NULL,NULL),
	(149709,'login','/transtng/auth/action/login','{\"x_token\":\"5062e7a3d7636ef585bba6a8a8d17029\",\"username\":\"mitra\",\"password\":\"6f6b220c7cdad5267bdf12a6d90c620d\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-11 15:23:35',NULL,NULL,NULL),
	(149710,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_parent\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"5062e7a3d7636ef585bba6a8a8d17029\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-11 15:23:47',NULL,NULL,NULL),
	(149711,'insert','/transtng/administrator/action','{\"id\":\"\",\"x_token\":\"5062e7a3d7636ef585bba6a8a8d17029\",\"module_id\":\"3\",\"menu_id\":\"86\",\"menu_name\":\"Transaksi Jalur\",\"menu_url\":\"grafikkoridor\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-11 15:24:02',NULL,NULL,NULL),
	(149712,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_parent\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"5062e7a3d7636ef585bba6a8a8d17029\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-11 15:24:03',NULL,NULL,NULL),
	(149713,'insert','/transtng/administrator/action','{\"id\":\"\",\"x_token\":\"5062e7a3d7636ef585bba6a8a8d17029\",\"module_id\":\"3\",\"menu_id\":\"86\",\"menu_name\":\"Transaksi Bulanan\",\"menu_url\":\"grafikbulanan\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-11 15:24:29',NULL,NULL,NULL),
	(149714,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_parent\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"5062e7a3d7636ef585bba6a8a8d17029\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-11 15:24:29',NULL,NULL,NULL),
	(149715,'insert','/transtng/administrator/action','{\"delete\":\"\",\"x_token\":\"5062e7a3d7636ef585bba6a8a8d17029\",\"iduser\":\"1\",\"id\":[\"1\",\"2\",\"8\",\"9\",\"10\",\"3\",\"4\",\"5\",\"12\",\"13\",\"14\",\"15\",\"16\",\"17\",\"18\",\"19\",\"20\",\"21\",\"22\",\"23\",\"24\",\"25\",\"26\",\"27\",\"0\",\"0\"],\"idmenu\":[\"1\",\"2\",\"64\",\"65\",\"66\",\"3\",\"4\",\"5\",\"68\",\"69\",\"70\",\"72\",\"74\",\"76\",\"77\",\"78\",\"79\",\"80\",\"81\",\"82\",\"83\",\"84\",\"85\",\"87\",\"88\",\"89\"],\"check_all\":[\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\"],\"v\":[\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\"],\"i\":[\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\"],\"e\":[\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\"],\"d\":[\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\"],\"o\":[\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\"]}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-11 15:24:39',NULL,NULL,NULL),
	(149716,'login','/transtng/auth/action/login','{\"x_token\":\"5062e7a3d7636ef585bba6a8a8d17029\",\"username\":\"mitra\",\"password\":\"6f6b220c7cdad5267bdf12a6d90c620d\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-11 15:24:43',NULL,NULL,NULL),
	(149717,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_parent\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"5062e7a3d7636ef585bba6a8a8d17029\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-11 15:25:12',NULL,NULL,NULL),
	(149718,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_parent\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"7f5d4cdc09f6bf7f1b22038fcf357cc5\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-11 16:07:38',NULL,NULL,NULL),
	(149719,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_parent\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"7f5d4cdc09f6bf7f1b22038fcf357cc5\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-11 16:08:31',NULL,NULL,NULL),
	(149720,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_parent\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"7f5d4cdc09f6bf7f1b22038fcf357cc5\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-11 16:10:14',NULL,NULL,NULL),
	(149721,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_parent\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"7f5d4cdc09f6bf7f1b22038fcf357cc5\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-11 16:10:19',NULL,NULL,NULL),
	(149722,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"7f5d4cdc09f6bf7f1b22038fcf357cc5\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-11 16:10:20',NULL,NULL,NULL),
	(149723,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"7f5d4cdc09f6bf7f1b22038fcf357cc5\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-11 16:12:40',NULL,NULL,NULL),
	(149724,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"7f5d4cdc09f6bf7f1b22038fcf357cc5\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-11 16:14:23',NULL,NULL,NULL),
	(149725,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"7f5d4cdc09f6bf7f1b22038fcf357cc5\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-11 16:14:52',NULL,NULL,NULL),
	(149726,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"7f5d4cdc09f6bf7f1b22038fcf357cc5\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-11 16:14:54',NULL,NULL,NULL),
	(149727,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"7f5d4cdc09f6bf7f1b22038fcf357cc5\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-11 16:14:58',NULL,NULL,NULL),
	(149728,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_parent\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"7f5d4cdc09f6bf7f1b22038fcf357cc5\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-11 16:22:33',NULL,NULL,NULL),
	(149729,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_parent\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"10\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"7f5d4cdc09f6bf7f1b22038fcf357cc5\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-11 16:22:35',NULL,NULL,NULL),
	(149730,'login','/transtng/auth/action/login','{\"x_token\":\"486cb20a6cbb43bc90013ca871782363\",\"username\":\"mitra\",\"password\":\"6f6b220c7cdad5267bdf12a6d90c620d\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-12 09:10:22',NULL,NULL,NULL),
	(149731,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_parent\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"486cb20a6cbb43bc90013ca871782363\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-12 09:10:53',NULL,NULL,NULL),
	(149732,'insert','/transtng/administrator/action','{\"id\":\"\",\"x_token\":\"486cb20a6cbb43bc90013ca871782363\",\"module_id\":\"2\",\"menu_id\":\"71\",\"menu_name\":\"Data Alat\",\"menu_url\":\"data-alat\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-12 09:11:30',NULL,NULL,NULL),
	(149733,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_parent\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"486cb20a6cbb43bc90013ca871782363\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-12 09:11:30',NULL,NULL,NULL),
	(149734,'insert','/transtng/administrator/action','{\"id\":\"\",\"x_token\":\"486cb20a6cbb43bc90013ca871782363\",\"module_id\":\"2\",\"menu_id\":\"71\",\"menu_name\":\"Koreksi Top-Up\",\"menu_url\":\"koreksi-topup\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-12 09:12:04',NULL,NULL,NULL),
	(149735,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_parent\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"486cb20a6cbb43bc90013ca871782363\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-12 09:12:05',NULL,NULL,NULL),
	(149736,'insert','/transtng/administrator/action','{\"id\":\"\",\"x_token\":\"486cb20a6cbb43bc90013ca871782363\",\"module_id\":\"2\",\"menu_id\":\"71\",\"menu_name\":\"Reset Password Petugas\",\"menu_url\":\"reset-password-petugas\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-12 09:12:43',NULL,NULL,NULL),
	(149737,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_parent\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"486cb20a6cbb43bc90013ca871782363\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-12 09:12:43',NULL,NULL,NULL),
	(149738,'insert','/transtng/administrator/action','{\"id\":\"\",\"x_token\":\"486cb20a6cbb43bc90013ca871782363\",\"module_id\":\"2\",\"menu_id\":\"71\",\"menu_name\":\"App Update\",\"menu_url\":\"app-update\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-12 09:13:15',NULL,NULL,NULL),
	(149739,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_parent\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"486cb20a6cbb43bc90013ca871782363\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-12 09:13:15',NULL,NULL,NULL),
	(149740,'insert','/transtng/administrator/action','{\"id\":\"\",\"x_token\":\"486cb20a6cbb43bc90013ca871782363\",\"module_id\":\"2\",\"menu_id\":\"71\",\"menu_name\":\"Laporan Trouble\",\"menu_url\":\"laporantrouble\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-12 09:14:12',NULL,NULL,NULL),
	(149741,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_parent\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"486cb20a6cbb43bc90013ca871782363\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-12 09:14:12',NULL,NULL,NULL),
	(149742,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"486cb20a6cbb43bc90013ca871782363\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-12 09:14:23',NULL,NULL,NULL),
	(149743,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_parent\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"486cb20a6cbb43bc90013ca871782363\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-12 09:14:45',NULL,NULL,NULL),
	(149744,'insert','/transtng/administrator/action','{\"id\":\"\",\"x_token\":\"486cb20a6cbb43bc90013ca871782363\",\"module_id\":\"2\",\"menu_id\":\"\",\"menu_name\":\"Internal Settlement\",\"menu_url\":\"#\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-12 09:15:21',NULL,NULL,NULL),
	(149745,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_parent\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"486cb20a6cbb43bc90013ca871782363\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-12 09:15:21',NULL,NULL,NULL),
	(149746,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_parent\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"486cb20a6cbb43bc90013ca871782363\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-12 09:15:31',NULL,NULL,NULL),
	(149747,'insert','/transtng/administrator/action','{\"id\":\"\",\"x_token\":\"486cb20a6cbb43bc90013ca871782363\",\"module_id\":\"2\",\"menu_id\":\"95\",\"menu_name\":\"Rekon Transaksi\",\"menu_url\":\"lap-rekon-internal\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-12 09:15:52',NULL,NULL,NULL),
	(149748,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_parent\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"486cb20a6cbb43bc90013ca871782363\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-12 09:15:52',NULL,NULL,NULL),
	(149749,'insert','/transtng/administrator/action','{\"delete\":\"\",\"x_token\":\"486cb20a6cbb43bc90013ca871782363\",\"iduser\":\"1\",\"id\":[\"1\",\"2\",\"8\",\"9\",\"10\",\"3\",\"4\",\"5\",\"12\",\"13\",\"14\",\"15\",\"0\",\"0\",\"0\",\"0\",\"0\",\"0\",\"16\",\"17\",\"18\",\"19\",\"20\",\"21\",\"22\",\"23\",\"24\",\"25\",\"26\",\"27\",\"28\",\"29\"],\"idmenu\":[\"1\",\"2\",\"64\",\"65\",\"66\",\"3\",\"4\",\"5\",\"68\",\"69\",\"70\",\"72\",\"90\",\"91\",\"92\",\"93\",\"94\",\"96\",\"74\",\"76\",\"77\",\"78\",\"79\",\"80\",\"81\",\"82\",\"83\",\"84\",\"85\",\"87\",\"88\",\"89\"],\"check_all\":[\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\"],\"v\":[\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\"],\"i\":[\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\"],\"e\":[\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\"],\"d\":[\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-12 09:16:07',NULL,NULL,NULL),
	(149750,'login','/transtng/auth/action/login','{\"x_token\":\"486cb20a6cbb43bc90013ca871782363\",\"username\":\"mitra\",\"password\":\"6f6b220c7cdad5267bdf12a6d90c620d\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-12 09:16:19',NULL,NULL,NULL),
	(149751,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_parent\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"486cb20a6cbb43bc90013ca871782363\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-12 09:20:39',NULL,NULL,NULL),
	(149752,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_parent\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"10\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"486cb20a6cbb43bc90013ca871782363\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-12 09:20:54',NULL,NULL,NULL),
	(149753,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_parent\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"20\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"486cb20a6cbb43bc90013ca871782363\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-12 09:20:59',NULL,NULL,NULL),
	(149754,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_parent\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"30\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"486cb20a6cbb43bc90013ca871782363\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-12 09:21:01',NULL,NULL,NULL),
	(149755,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_parent\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"20\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"486cb20a6cbb43bc90013ca871782363\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-12 09:21:37',NULL,NULL,NULL),
	(149756,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_parent\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"486cb20a6cbb43bc90013ca871782363\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-12 09:21:57',NULL,NULL,NULL),
	(149757,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_parent\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"10\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"486cb20a6cbb43bc90013ca871782363\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-12 09:22:00',NULL,NULL,NULL),
	(149758,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_parent\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"20\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"486cb20a6cbb43bc90013ca871782363\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-12 09:22:06',NULL,NULL,NULL),
	(149759,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_parent\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"486cb20a6cbb43bc90013ca871782363\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-12 09:22:40',NULL,NULL,NULL),
	(149760,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_parent\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"30\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"486cb20a6cbb43bc90013ca871782363\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-12 09:22:44',NULL,NULL,NULL),
	(149761,'edit','/transtng/administrator/action','{\"id\":\"96\",\"x_token\":\"486cb20a6cbb43bc90013ca871782363\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-12 09:22:44',NULL,NULL,NULL),
	(149762,'insert','/transtng/administrator/action','{\"id\":\"96\",\"x_token\":\"486cb20a6cbb43bc90013ca871782363\",\"module_id\":\"2\",\"menu_id\":\"95\",\"menu_name\":\"Rekon Transaksi\",\"menu_url\":\"laprekoninternal\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-12 09:22:51',NULL,NULL,NULL),
	(149763,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_parent\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"486cb20a6cbb43bc90013ca871782363\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-12 09:22:51',NULL,NULL,NULL),
	(149764,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_parent\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"30\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"486cb20a6cbb43bc90013ca871782363\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-12 09:23:04',NULL,NULL,NULL),
	(149765,'edit','/transtng/administrator/action','{\"id\":\"96\",\"x_token\":\"486cb20a6cbb43bc90013ca871782363\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-12 09:23:07',NULL,NULL,NULL),
	(149766,'edit','/transtng/administrator/action','{\"id\":\"95\",\"x_token\":\"486cb20a6cbb43bc90013ca871782363\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-12 09:23:40',NULL,NULL,NULL),
	(149767,'insert','/transtng/administrator/action','{\"id\":\"95\",\"x_token\":\"486cb20a6cbb43bc90013ca871782363\",\"module_id\":\"2\",\"menu_id\":\"\",\"menu_name\":\"<i class=\\\"fa fa-money\\\" aria-hidden=\\\"true\\\"><\\/i> Internal Settlement\",\"menu_url\":\"#\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-12 09:23:51',NULL,NULL,NULL),
	(149768,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_parent\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"486cb20a6cbb43bc90013ca871782363\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-12 09:23:51',NULL,NULL,NULL),
	(149769,'login','/transtng/auth/action/login','{\"x_token\":\"486cb20a6cbb43bc90013ca871782363\",\"username\":\"mitra\",\"password\":\"6f6b220c7cdad5267bdf12a6d90c620d\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-12 09:24:05',NULL,NULL,NULL),
	(149770,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_parent\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"486cb20a6cbb43bc90013ca871782363\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-12 09:24:18',NULL,NULL,NULL),
	(149771,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_parent\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"20\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"486cb20a6cbb43bc90013ca871782363\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-12 09:24:22',NULL,NULL,NULL),
	(149772,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_parent\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"10\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"486cb20a6cbb43bc90013ca871782363\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-12 09:24:24',NULL,NULL,NULL),
	(149773,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_parent\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"30\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"486cb20a6cbb43bc90013ca871782363\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-12 09:24:26',NULL,NULL,NULL),
	(149774,'edit','/transtng/administrator/action','{\"id\":\"95\",\"x_token\":\"486cb20a6cbb43bc90013ca871782363\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-12 09:24:28',NULL,NULL,NULL),
	(149775,'insert','/transtng/administrator/action','{\"id\":\"95\",\"x_token\":\"486cb20a6cbb43bc90013ca871782363\",\"module_id\":\"2\",\"menu_id\":\"\",\"menu_name\":\"Internal Settlement\",\"menu_url\":\"#\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-12 09:25:08',NULL,NULL,NULL),
	(149776,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_parent\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"486cb20a6cbb43bc90013ca871782363\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-12 09:25:08',NULL,NULL,NULL),
	(149777,'login','/transtng/auth/action/login','{\"x_token\":\"486cb20a6cbb43bc90013ca871782363\",\"username\":\"mitra\",\"password\":\"6f6b220c7cdad5267bdf12a6d90c620d\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-12 09:28:17',NULL,NULL,NULL),
	(149778,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"486cb20a6cbb43bc90013ca871782363\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-12 09:29:35',NULL,NULL,NULL),
	(149779,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_parent\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"486cb20a6cbb43bc90013ca871782363\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-12 09:29:37',NULL,NULL,NULL),
	(149780,'insert','/transtng/administrator/action','{\"id\":\"\",\"x_token\":\"486cb20a6cbb43bc90013ca871782363\",\"module_id\":\"3\",\"menu_id\":\"\",\"menu_name\":\"Info Alat\",\"menu_url\":\"#\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-12 09:29:56',NULL,NULL,NULL),
	(149781,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_parent\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"486cb20a6cbb43bc90013ca871782363\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-12 09:29:56',NULL,NULL,NULL),
	(149782,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_parent\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"486cb20a6cbb43bc90013ca871782363\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-12 09:30:04',NULL,NULL,NULL),
	(149783,'insert','/transtng/administrator/action','{\"id\":\"\",\"x_token\":\"486cb20a6cbb43bc90013ca871782363\",\"module_id\":\"3\",\"menu_id\":\"97\",\"menu_name\":\"Informasi Alat\",\"menu_url\":\"dataalat\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-12 09:30:29',NULL,NULL,NULL),
	(149784,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_parent\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"486cb20a6cbb43bc90013ca871782363\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-12 09:30:29',NULL,NULL,NULL),
	(149785,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_parent\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"486cb20a6cbb43bc90013ca871782363\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-12 09:30:32',NULL,NULL,NULL),
	(149786,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"fullname\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"telp\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"486cb20a6cbb43bc90013ca871782363\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-12 09:36:24',NULL,NULL,NULL),
	(149787,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_parent\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"486cb20a6cbb43bc90013ca871782363\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-12 09:39:19',NULL,NULL,NULL),
	(149788,'insert','/transtng/administrator/action','{\"id\":\"\",\"x_token\":\"486cb20a6cbb43bc90013ca871782363\",\"module_id\":\"3\",\"menu_id\":\"97\",\"menu_name\":\"Log Alat Aktif\",\"menu_url\":\"logalataktif\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-12 09:39:45',NULL,NULL,NULL),
	(149789,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_parent\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"486cb20a6cbb43bc90013ca871782363\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-12 09:39:45',NULL,NULL,NULL),
	(149790,'insert','/transtng/administrator/action','{\"delete\":\"\",\"x_token\":\"486cb20a6cbb43bc90013ca871782363\",\"iduser\":\"1\",\"id\":[\"1\",\"2\",\"8\",\"9\",\"10\",\"3\",\"4\",\"5\",\"12\",\"13\",\"14\",\"15\",\"30\",\"31\",\"32\",\"33\",\"34\",\"35\",\"16\",\"17\",\"18\",\"19\",\"20\",\"21\",\"22\",\"23\",\"24\",\"25\",\"26\",\"27\",\"28\",\"29\",\"0\",\"0\"],\"idmenu\":[\"1\",\"2\",\"64\",\"65\",\"66\",\"3\",\"4\",\"5\",\"68\",\"69\",\"70\",\"72\",\"90\",\"91\",\"92\",\"93\",\"94\",\"96\",\"74\",\"76\",\"77\",\"78\",\"79\",\"80\",\"81\",\"82\",\"83\",\"84\",\"85\",\"87\",\"88\",\"89\",\"98\",\"99\"],\"check_all\":[\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\"],\"v\":[\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\"],\"i\":[\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\"],\"e\":[\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\"],\"d\":[\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-12 09:39:57',NULL,NULL,NULL),
	(149791,'login','/transtng/auth/action/login','{\"x_token\":\"486cb20a6cbb43bc90013ca871782363\",\"username\":\"mitra\",\"password\":\"6f6b220c7cdad5267bdf12a6d90c620d\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-12 09:40:05',NULL,NULL,NULL),
	(149792,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_parent\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"486cb20a6cbb43bc90013ca871782363\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-12 09:40:31',NULL,NULL,NULL),
	(149793,'insert','/transtng/administrator/action','{\"id\":\"\",\"x_token\":\"486cb20a6cbb43bc90013ca871782363\",\"module_id\":\"3\",\"menu_id\":\"73\",\"menu_name\":\"Sirkulasi Penumpang\",\"menu_url\":\"sirkulasipenumpang\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-12 09:41:35',NULL,NULL,NULL),
	(149794,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_parent\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"486cb20a6cbb43bc90013ca871782363\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-12 09:41:35',NULL,NULL,NULL),
	(149795,'insert','/transtng/administrator/action','{\"id\":\"\",\"x_token\":\"486cb20a6cbb43bc90013ca871782363\",\"module_id\":\"3\",\"menu_id\":\"73\",\"menu_name\":\"Sirkulasi Penumpang Portabel\",\"menu_url\":\"sirkulasipenumpangportabel\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-12 09:42:01',NULL,NULL,NULL),
	(149796,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_parent\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"486cb20a6cbb43bc90013ca871782363\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-12 09:42:01',NULL,NULL,NULL),
	(149797,'insert','/transtng/administrator/action','{\"delete\":\"\",\"x_token\":\"486cb20a6cbb43bc90013ca871782363\",\"iduser\":\"1\",\"id\":[\"1\",\"2\",\"8\",\"9\",\"10\",\"3\",\"4\",\"5\",\"12\",\"13\",\"14\",\"15\",\"30\",\"31\",\"32\",\"33\",\"34\",\"35\",\"16\",\"0\",\"0\",\"17\",\"18\",\"19\",\"20\",\"21\",\"22\",\"23\",\"24\",\"25\",\"26\",\"27\",\"28\",\"29\",\"36\",\"37\"],\"idmenu\":[\"1\",\"2\",\"64\",\"65\",\"66\",\"3\",\"4\",\"5\",\"68\",\"69\",\"70\",\"72\",\"90\",\"91\",\"92\",\"93\",\"94\",\"96\",\"74\",\"100\",\"101\",\"76\",\"77\",\"78\",\"79\",\"80\",\"81\",\"82\",\"83\",\"84\",\"85\",\"87\",\"88\",\"89\",\"98\",\"99\"],\"check_all\":[\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\"],\"v\":[\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\"],\"i\":[\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\"],\"e\":[\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-12 09:42:27',NULL,NULL,NULL),
	(149798,'login','/transtng/auth/action/login','{\"x_token\":\"486cb20a6cbb43bc90013ca871782363\",\"username\":\"mitra\",\"password\":\"6f6b220c7cdad5267bdf12a6d90c620d\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-12 09:42:34',NULL,NULL,NULL),
	(149799,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_parent\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"486cb20a6cbb43bc90013ca871782363\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-12 09:42:40',NULL,NULL,NULL),
	(149800,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_parent\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"100\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"486cb20a6cbb43bc90013ca871782363\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-12 09:42:51',NULL,NULL,NULL),
	(149801,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_parent\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"486cb20a6cbb43bc90013ca871782363\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-12 09:50:39',NULL,NULL,NULL),
	(149802,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_parent\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"25\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"486cb20a6cbb43bc90013ca871782363\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-12 09:50:55',NULL,NULL,NULL),
	(149803,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_parent\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"100\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"486cb20a6cbb43bc90013ca871782363\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-12 09:50:56',NULL,NULL,NULL),
	(149804,'login','/transtng/auth/action/login','{\"x_token\":\"1dedd609fda4150f1f10bab41cbb3da0\",\"username\":\"mitra\",\"password\":\"6f6b220c7cdad5267bdf12a6d90c620d\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-12 12:27:52',NULL,NULL,NULL),
	(149805,'login','/transtng/auth/action/login','{\"x_token\":\"ced4fb39f1a5312da79b8a03063483fd\",\"username\":\"mitra\",\"password\":\"6f6b220c7cdad5267bdf12a6d90c620d\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-12 12:28:19',NULL,NULL,NULL),
	(149806,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"fullname\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"telp\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"ced4fb39f1a5312da79b8a03063483fd\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-12 13:42:58',NULL,NULL,NULL),
	(149807,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"headers\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"footers\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"ced4fb39f1a5312da79b8a03063483fd\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-12 13:43:06',NULL,NULL,NULL),
	(149808,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"jenis\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"tenant_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"tarif\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"ced4fb39f1a5312da79b8a03063483fd\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-12 13:43:11',NULL,NULL,NULL),
	(149809,'login','/transtng/auth/action/login','{\"x_token\":\"09f210afa1ca2a89a4bdd805adddb9da\",\"username\":\"mitra\",\"password\":\"6f6b220c7cdad5267bdf12a6d90c620d\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-13 09:10:10',NULL,NULL,NULL),
	(149810,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"d3112dba3aaa1d7711aff11eadb4f2e0\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-13 13:55:20',NULL,NULL,NULL),
	(149811,'insert','/transtng/administrator/action','{\"id\":\"\",\"x_token\":\"d3112dba3aaa1d7711aff11eadb4f2e0\",\"module_name\":\"KMT\",\"module_url\":\"kmt\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-13 13:57:19',NULL,NULL,NULL),
	(149812,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"d3112dba3aaa1d7711aff11eadb4f2e0\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-13 13:57:19',NULL,NULL,NULL),
	(149813,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_parent\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"d3112dba3aaa1d7711aff11eadb4f2e0\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-13 13:57:22',NULL,NULL,NULL),
	(149814,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"d3112dba3aaa1d7711aff11eadb4f2e0\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-13 13:57:38',NULL,NULL,NULL),
	(149815,'edit','/transtng/administrator/action','{\"id\":\"4\",\"x_token\":\"d3112dba3aaa1d7711aff11eadb4f2e0\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-13 13:57:40',NULL,NULL,NULL),
	(149816,'insert','/transtng/administrator/action','{\"id\":\"4\",\"x_token\":\"d3112dba3aaa1d7711aff11eadb4f2e0\",\"module_name\":\"SETTLEMENT MENU\",\"module_url\":\"settlement\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-13 13:57:57',NULL,NULL,NULL),
	(149817,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"d3112dba3aaa1d7711aff11eadb4f2e0\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-13 13:57:57',NULL,NULL,NULL),
	(149818,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_parent\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"d3112dba3aaa1d7711aff11eadb4f2e0\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-13 13:58:26',NULL,NULL,NULL),
	(149819,'insert','/transtng/administrator/action','{\"id\":\"\",\"x_token\":\"d3112dba3aaa1d7711aff11eadb4f2e0\",\"module_id\":\"4\",\"menu_id\":\"\",\"menu_name\":\"Menu Settlement\",\"menu_url\":\"#\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-13 13:59:13',NULL,NULL,NULL),
	(149820,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_parent\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"d3112dba3aaa1d7711aff11eadb4f2e0\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-13 13:59:13',NULL,NULL,NULL),
	(149821,'insert','/transtng/administrator/action','{\"id\":\"\",\"x_token\":\"d3112dba3aaa1d7711aff11eadb4f2e0\",\"module_id\":\"4\",\"menu_id\":\"102\",\"menu_name\":\"Cek Settlement\",\"menu_url\":\"cek-settlement\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-13 13:59:30',NULL,NULL,NULL),
	(149822,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_parent\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"d3112dba3aaa1d7711aff11eadb4f2e0\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-13 13:59:30',NULL,NULL,NULL),
	(149823,'insert','/transtng/administrator/action','{\"delete\":\"\",\"x_token\":\"d3112dba3aaa1d7711aff11eadb4f2e0\",\"iduser\":\"1\",\"id\":[\"1\",\"2\",\"8\",\"9\",\"10\",\"3\",\"4\",\"5\",\"12\",\"13\",\"14\",\"15\",\"30\",\"31\",\"32\",\"33\",\"34\",\"35\",\"16\",\"38\",\"39\",\"17\",\"18\",\"19\",\"20\",\"21\",\"22\",\"23\",\"24\",\"25\",\"26\",\"27\",\"28\",\"29\",\"36\",\"37\",\"0\"],\"idmenu\":[\"1\",\"2\",\"64\",\"65\",\"66\",\"3\",\"4\",\"5\",\"68\",\"69\",\"70\",\"72\",\"90\",\"91\",\"92\",\"93\",\"94\",\"96\",\"74\",\"100\",\"101\",\"76\",\"77\",\"78\",\"79\",\"80\",\"81\",\"82\",\"83\",\"84\",\"85\",\"87\",\"88\",\"89\",\"98\",\"99\",\"103\"],\"check_all\":[\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\"],\"v\":[\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\"],\"i\":[\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\"],\"e\":[\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-13 13:59:45',NULL,NULL,NULL),
	(149824,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_parent\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"d3112dba3aaa1d7711aff11eadb4f2e0\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-13 14:00:26',NULL,NULL,NULL),
	(149825,'insert','/transtng/administrator/action','{\"id\":\"\",\"x_token\":\"d3112dba3aaa1d7711aff11eadb4f2e0\",\"module_id\":\"4\",\"menu_id\":\"102\",\"menu_name\":\"Compare Settlement\",\"menu_url\":\"compare-settlement\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-13 14:00:58',NULL,NULL,NULL),
	(149826,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_parent\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"d3112dba3aaa1d7711aff11eadb4f2e0\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-13 14:00:58',NULL,NULL,NULL),
	(149827,'insert','/transtng/administrator/action','{\"id\":\"\",\"x_token\":\"d3112dba3aaa1d7711aff11eadb4f2e0\",\"module_id\":\"4\",\"menu_id\":\"102\",\"menu_name\":\"Laporan Rekonsiliasi\",\"menu_url\":\"lap-rekon\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-13 14:01:18',NULL,NULL,NULL),
	(149828,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_parent\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"d3112dba3aaa1d7711aff11eadb4f2e0\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-13 14:01:18',NULL,NULL,NULL),
	(149829,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_parent\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"40\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"d3112dba3aaa1d7711aff11eadb4f2e0\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-13 14:01:25',NULL,NULL,NULL),
	(149830,'edit','/transtng/administrator/action','{\"id\":\"105\",\"x_token\":\"d3112dba3aaa1d7711aff11eadb4f2e0\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-13 14:01:27',NULL,NULL,NULL),
	(149831,'insert','/transtng/administrator/action','{\"id\":\"105\",\"x_token\":\"d3112dba3aaa1d7711aff11eadb4f2e0\",\"module_id\":\"4\",\"menu_id\":\"102\",\"menu_name\":\"Laporan Rekonsiliasi\",\"menu_url\":\"laprekon\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-13 14:01:33',NULL,NULL,NULL),
	(149832,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_parent\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"d3112dba3aaa1d7711aff11eadb4f2e0\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-13 14:01:33',NULL,NULL,NULL),
	(149833,'insert','/transtng/administrator/action','{\"id\":\"\",\"x_token\":\"d3112dba3aaa1d7711aff11eadb4f2e0\",\"module_id\":\"4\",\"menu_id\":\"102\",\"menu_name\":\"Laporan Pendapatan\",\"menu_url\":\"laporanpendapatan\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-13 14:02:03',NULL,NULL,NULL),
	(149834,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_parent\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"d3112dba3aaa1d7711aff11eadb4f2e0\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-13 14:02:03',NULL,NULL,NULL),
	(149835,'insert','/transtng/administrator/action','{\"id\":\"\",\"x_token\":\"d3112dba3aaa1d7711aff11eadb4f2e0\",\"module_id\":\"4\",\"menu_id\":\"102\",\"menu_name\":\"Import Rek Koran\",\"menu_url\":\"importsettlement\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-13 14:02:38',NULL,NULL,NULL),
	(149836,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_parent\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"d3112dba3aaa1d7711aff11eadb4f2e0\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-13 14:02:38',NULL,NULL,NULL),
	(149837,'insert','/transtng/administrator/action','{\"id\":\"\",\"x_token\":\"d3112dba3aaa1d7711aff11eadb4f2e0\",\"module_id\":\"4\",\"menu_id\":\"102\",\"menu_name\":\"Import File RSF\",\"menu_url\":\"importrsf\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-13 14:03:43',NULL,NULL,NULL),
	(149838,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_parent\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"d3112dba3aaa1d7711aff11eadb4f2e0\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-13 14:03:43',NULL,NULL,NULL),
	(149839,'insert','/transtng/administrator/action','{\"delete\":\"\",\"x_token\":\"d3112dba3aaa1d7711aff11eadb4f2e0\",\"iduser\":\"1\",\"id\":[\"1\",\"2\",\"8\",\"9\",\"10\",\"3\",\"4\",\"5\",\"12\",\"13\",\"14\",\"15\",\"30\",\"31\",\"32\",\"33\",\"34\",\"35\",\"16\",\"38\",\"39\",\"17\",\"18\",\"19\",\"20\",\"21\",\"22\",\"23\",\"24\",\"25\",\"26\",\"27\",\"28\",\"29\",\"36\",\"37\",\"40\",\"0\",\"0\",\"0\",\"0\",\"0\"],\"idmenu\":[\"1\",\"2\",\"64\",\"65\",\"66\",\"3\",\"4\",\"5\",\"68\",\"69\",\"70\",\"72\",\"90\",\"91\",\"92\",\"93\",\"94\",\"96\",\"74\",\"100\",\"101\",\"76\",\"77\",\"78\",\"79\",\"80\",\"81\",\"82\",\"83\",\"84\",\"85\",\"87\",\"88\",\"89\",\"98\",\"99\",\"103\",\"104\",\"105\",\"106\",\"107\",\"108\"],\"check_all\":[\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\"],\"v\":[\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\"],\"i\":[\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\"','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-13 14:03:57',NULL,NULL,NULL),
	(149840,'login','/transtng/auth/action/login','{\"x_token\":\"d3112dba3aaa1d7711aff11eadb4f2e0\",\"username\":\"mitra\",\"password\":\"6f6b220c7cdad5267bdf12a6d90c620d\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-13 14:04:03',NULL,NULL,NULL),
	(149841,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_parent\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"d3112dba3aaa1d7711aff11eadb4f2e0\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-13 14:17:42',NULL,NULL,NULL),
	(149842,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_parent\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"s\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"d3112dba3aaa1d7711aff11eadb4f2e0\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-13 14:17:44',NULL,NULL,NULL),
	(149843,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_parent\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"sett\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"d3112dba3aaa1d7711aff11eadb4f2e0\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-13 14:17:46',NULL,NULL,NULL),
	(149844,'edit','/transtng/administrator/action','{\"id\":\"104\",\"x_token\":\"d3112dba3aaa1d7711aff11eadb4f2e0\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-13 14:17:49',NULL,NULL,NULL),
	(149845,'insert','/transtng/administrator/action','{\"id\":\"104\",\"x_token\":\"d3112dba3aaa1d7711aff11eadb4f2e0\",\"module_id\":\"4\",\"menu_id\":\"102\",\"menu_name\":\"Compare Settlement\",\"menu_url\":\"comparesettlement\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-13 14:17:53',NULL,NULL,NULL),
	(149846,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_parent\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"sett\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"d3112dba3aaa1d7711aff11eadb4f2e0\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-13 14:17:53',NULL,NULL,NULL),
	(149847,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_parent\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"10\",\"length\":\"10\",\"search\":{\"value\":\"sett\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"d3112dba3aaa1d7711aff11eadb4f2e0\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-13 14:17:58',NULL,NULL,NULL),
	(149848,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_parent\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"cek\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"d3112dba3aaa1d7711aff11eadb4f2e0\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-13 14:18:03',NULL,NULL,NULL),
	(149849,'edit','/transtng/administrator/action','{\"id\":\"103\",\"x_token\":\"d3112dba3aaa1d7711aff11eadb4f2e0\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-13 14:18:05',NULL,NULL,NULL),
	(149850,'insert','/transtng/administrator/action','{\"id\":\"103\",\"x_token\":\"d3112dba3aaa1d7711aff11eadb4f2e0\",\"module_id\":\"4\",\"menu_id\":\"102\",\"menu_name\":\"Cek Settlement\",\"menu_url\":\"ceksettlement\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-13 14:18:10',NULL,NULL,NULL),
	(149851,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_parent\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"cek\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"d3112dba3aaa1d7711aff11eadb4f2e0\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-13 14:18:10',NULL,NULL,NULL),
	(149852,'load','/transtng/administrator/action','{\"draw\":\"1\",\"columns\":[{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"module_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_name\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_url\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"menu_parent\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"true\",\"search\":{\"value\":\"\",\"regex\":\"false\"}},{\"data\":\"id\",\"name\":\"\",\"searchable\":\"true\",\"orderable\":\"false\",\"search\":{\"value\":\"\",\"regex\":\"false\"}}],\"order\":[{\"column\":\"0\",\"dir\":\"asc\"}],\"start\":\"0\",\"length\":\"10\",\"search\":{\"value\":\"\",\"regex\":\"false\"},\"filter\":\"\",\"x_token\":\"d3112dba3aaa1d7711aff11eadb4f2e0\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-13 14:18:19',NULL,NULL,NULL),
	(149853,'login','/transtng/auth/action/login','{\"x_token\":\"d3112dba3aaa1d7711aff11eadb4f2e0\",\"username\":\"mitra\",\"password\":\"6f6b220c7cdad5267bdf12a6d90c620d\"}','Akses Diberikan','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Sa',1,'0','2023-04-13 14:18:28',NULL,NULL,NULL);

/*!40000 ALTER TABLE `s_log_privilege` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table s_menu
# ------------------------------------------------------------

DROP TABLE IF EXISTS `s_menu`;

CREATE TABLE `s_menu` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `menu_name` varchar(50) DEFAULT NULL,
  `menu_url` varchar(50) DEFAULT NULL,
  `module_id` int unsigned DEFAULT NULL,
  `menu_id` int unsigned DEFAULT NULL,
  `is_deleted` char(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int unsigned DEFAULT NULL,
  `last_edited_at` datetime DEFAULT NULL,
  `last_edited_by` int unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `created_by` (`created_by`),
  KEY `last_edited_by` (`last_edited_by`),
  KEY `module_id` (`module_id`),
  KEY `menu_id` (`menu_id`),
  KEY `is_deleted` (`is_deleted`),
  CONSTRAINT `s_menu_ibfk_1` FOREIGN KEY (`module_id`) REFERENCES `s_module` (`id`),
  CONSTRAINT `s_menu_ibfk_2` FOREIGN KEY (`menu_id`) REFERENCES `s_menu` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

LOCK TABLES `s_menu` WRITE;
/*!40000 ALTER TABLE `s_menu` DISABLE KEYS */;

INSERT INTO `s_menu` (`id`, `menu_name`, `menu_url`, `module_id`, `menu_id`, `is_deleted`, `created_at`, `created_by`, `last_edited_at`, `last_edited_by`)
VALUES
	(1,'Manajemen Modul','manmodul',1,6,'0','2023-04-04 13:58:40',1,NULL,NULL),
	(2,'Manajemen Menu','manmenu',1,6,'0','2023-04-04 14:02:20',1,NULL,NULL),
	(3,'Manajemen Jenis User','manjenisuser',1,7,'0','2023-04-04 14:02:50',1,NULL,NULL),
	(4,'Manajemen User','manuser',1,7,'0','2023-04-04 14:03:00',1,NULL,NULL),
	(5,'Manajemen Hak Akses','manhakakses',1,7,'0','2023-04-04 14:03:10',1,NULL,NULL),
	(6,'Manajemen Menu & Modul','#',1,NULL,'0','2023-02-17 11:49:27',1,NULL,NULL),
	(7,'Manajemen User','#',1,NULL,'0','2023-02-17 11:50:25',1,NULL,NULL),
	(64,'Setting Tarif Tiket','mantarif',1,6,'0','2023-04-04 15:01:46',1,NULL,NULL),
	(65,'Setting Narasi Tiket','narasitiket',1,6,'0','2023-04-04 15:02:33',1,NULL,NULL),
	(66,'Data Pegawai','manpegawai',1,6,'0','2023-04-04 15:03:11',1,NULL,NULL),
	(67,'Manajemen Jalur & Bus/Halte','#',1,NULL,'0','2023-04-04 15:05:08',1,'2023-04-04 03:06:20',1),
	(68,'Manajemen Pos','manpos',1,67,'0','2023-04-04 15:06:59',1,NULL,NULL),
	(69,'Manajemen Jalur','manjalur',1,67,'0','2023-04-04 15:07:21',1,NULL,NULL),
	(70,'Manajemen Bus','manbus',1,67,'0','2023-04-04 15:07:41',1,NULL,NULL),
	(71,'Alat-alat','#',2,NULL,'0','2023-04-05 13:48:23',1,'2023-04-05 01:49:41',1),
	(72,'Software Lisensi','softwarelicense',2,71,'0','2023-04-05 13:48:48',1,NULL,NULL),
	(73,'Menu Eksekutif','#',3,NULL,'0','2023-04-11 15:09:26',1,NULL,NULL),
	(74,'Transaksi 30 Hari Terakhir','info30haritransaksi',3,73,'0','2023-04-11 15:10:06',1,'2023-04-11 03:12:12',1),
	(75,'Laporan Detail','#',3,NULL,'0','2023-04-11 15:12:48',1,'2023-04-11 03:15:38',1),
	(76,'Transaksi Periodik','laptransaksimesinkartu',3,75,'0','2023-04-11 15:16:19',1,NULL,NULL),
	(77,'Transaksi (PTA)','cekpta',3,75,'0','2023-04-11 15:17:15',1,NULL,NULL),
	(78,'Transaksi Jalur','lapkoridor',3,75,'0','2023-04-11 15:17:38',1,NULL,NULL),
	(79,'Data Kartu Baru','lapdatakartubaru',3,75,'0','2023-04-11 15:18:04',1,NULL,NULL),
	(80,'Riwayat Top Up','laptopup',3,75,'0','2023-04-11 15:19:43',1,NULL,NULL),
	(81,'Info Penumpang/Jam/Jalur','lappenumpangjamkor',3,75,'0','2023-04-11 15:20:14',1,NULL,NULL),
	(82,'Cek Mutasi Kartu','cekmutasikartu',3,75,'0','2023-04-11 15:20:34',1,NULL,NULL),
	(83,'Rekap Transaksi Per-Pos','rekapposharian',3,75,'0','2023-04-11 15:20:55',1,NULL,NULL),
	(84,'Laporan Pesanan Tiket','lappesantiket',3,75,'0','2023-04-11 15:21:29',1,NULL,NULL),
	(85,'Pembaruan Kartu','pembaruankartu',3,75,'0','2023-04-11 15:21:49',1,NULL,NULL),
	(86,'Grafik','#',3,NULL,'0','2023-04-11 15:23:01',1,NULL,NULL),
	(87,'Transaksi Per-Jenis','grafiktransaksimesinkartu',3,86,'0','2023-04-11 15:23:20',1,NULL,NULL),
	(88,'Transaksi Jalur','grafikkoridor',3,86,'0','2023-04-11 15:24:03',1,NULL,NULL),
	(89,'Transaksi Bulanan','grafikbulanan',3,86,'0','2023-04-11 15:24:29',1,NULL,NULL),
	(90,'Data Alat','data-alat',2,71,'0','2023-04-12 09:11:30',1,NULL,NULL),
	(91,'Koreksi Top-Up','koreksi-topup',2,71,'0','2023-04-12 09:12:04',1,NULL,NULL),
	(92,'Reset Password Petugas','reset-password-petugas',2,71,'0','2023-04-12 09:12:43',1,NULL,NULL),
	(93,'App Update','app-update',2,71,'0','2023-04-12 09:13:15',1,NULL,NULL),
	(94,'Laporan Trouble','laporantrouble',2,71,'0','2023-04-12 09:14:12',1,NULL,NULL),
	(95,'Internal Settlement','#',2,NULL,'0','2023-04-12 09:15:21',1,'2023-04-11 21:25:08',1),
	(96,'Rekon Transaksi','laprekoninternal',2,95,'0','2023-04-12 09:15:52',1,'2023-04-11 21:22:51',1),
	(97,'Info Alat','#',3,NULL,'0','2023-04-12 09:29:56',1,NULL,NULL),
	(98,'Informasi Alat','dataalat',3,97,'0','2023-04-12 09:30:29',1,NULL,NULL),
	(99,'Log Alat Aktif','logalataktif',3,97,'0','2023-04-12 09:39:45',1,NULL,NULL),
	(100,'Sirkulasi Penumpang','sirkulasipenumpang',3,73,'0','2023-04-12 09:41:35',1,NULL,NULL),
	(101,'Sirkulasi Penumpang Portabel','sirkulasipenumpangportabel',3,73,'0','2023-04-12 09:42:01',1,NULL,NULL),
	(102,'Menu Settlement','#',4,NULL,'0','2023-04-13 13:59:13',1,NULL,NULL),
	(103,'Cek Settlement','ceksettlement',4,102,'0','2023-04-13 13:59:30',1,'2023-04-13 02:18:10',1),
	(104,'Compare Settlement','comparesettlement',4,102,'0','2023-04-13 14:00:58',1,'2023-04-13 02:17:53',1),
	(105,'Laporan Rekonsiliasi','laprekon',4,102,'0','2023-04-13 14:01:18',1,'2023-04-13 02:01:33',1),
	(106,'Laporan Pendapatan','laporanpendapatan',4,102,'0','2023-04-13 14:02:03',1,NULL,NULL),
	(107,'Import Rek Koran','importsettlement',4,102,'0','2023-04-13 14:02:38',1,NULL,NULL),
	(108,'Import File RSF','importrsf',4,102,'0','2023-04-13 14:03:43',1,NULL,NULL);

/*!40000 ALTER TABLE `s_menu` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table s_module
# ------------------------------------------------------------

DROP TABLE IF EXISTS `s_module`;

CREATE TABLE `s_module` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `module_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `module_url` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `is_deleted` char(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int unsigned DEFAULT NULL,
  `last_edited_at` datetime DEFAULT NULL,
  `last_edited_by` int unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `created_by` (`created_by`),
  KEY `last_edited_by` (`last_edited_by`),
  KEY `is_deleted` (`is_deleted`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

LOCK TABLES `s_module` WRITE;
/*!40000 ALTER TABLE `s_module` DISABLE KEYS */;

INSERT INTO `s_module` (`id`, `module_name`, `module_url`, `is_deleted`, `created_at`, `created_by`, `last_edited_at`, `last_edited_by`)
VALUES
	(1,'Administrator','administrator','0','2022-11-23 12:07:00',1,NULL,NULL),
	(2,'NGI MENU','ngi','0','2023-04-05 13:47:36',1,NULL,NULL),
	(3,'EKSEKUTIF MENU','eksekutif','0','2023-04-11 15:08:38',1,NULL,NULL),
	(4,'SETTLEMENT MENU','settlement','0','2023-04-13 13:57:19',1,'2023-04-13 01:57:57',1);

/*!40000 ALTER TABLE `s_module` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table s_user_mobile_role
# ------------------------------------------------------------

DROP TABLE IF EXISTS `s_user_mobile_role`;

CREATE TABLE `s_user_mobile_role` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `user_mobile_role_name` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `user_mobile_role_code` varchar(4) DEFAULT NULL,
  `is_deleted` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int unsigned DEFAULT NULL,
  `last_edited_at` datetime DEFAULT NULL,
  `last_edited_by` int unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `created_by` (`created_by`),
  KEY `last_edited_by` (`last_edited_by`),
  KEY `is_deleted` (`is_deleted`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;



# Dump of table s_user_web_privilege
# ------------------------------------------------------------

DROP TABLE IF EXISTS `s_user_web_privilege`;

CREATE TABLE `s_user_web_privilege` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `menu_id` int unsigned DEFAULT NULL,
  `user_web_role_id` int unsigned DEFAULT NULL,
  `v` char(1) DEFAULT NULL,
  `i` char(1) DEFAULT NULL,
  `e` char(1) DEFAULT NULL,
  `d` char(1) DEFAULT NULL,
  `o` char(1) DEFAULT NULL,
  `is_deleted` char(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int unsigned DEFAULT NULL,
  `last_edited_at` datetime DEFAULT NULL,
  `last_edited_by` int unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `created_by` (`created_by`),
  KEY `last_edited_by` (`last_edited_by`),
  KEY `user_web_id` (`user_web_role_id`,`v`),
  KEY `menu_id` (`menu_id`),
  KEY `is_deleted` (`is_deleted`),
  CONSTRAINT `s_user_web_privilege_ibfk_1` FOREIGN KEY (`menu_id`) REFERENCES `s_menu` (`id`),
  CONSTRAINT `s_user_web_privilege_ibfk_2` FOREIGN KEY (`user_web_role_id`) REFERENCES `s_user_web_role` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

LOCK TABLES `s_user_web_privilege` WRITE;
/*!40000 ALTER TABLE `s_user_web_privilege` DISABLE KEYS */;

INSERT INTO `s_user_web_privilege` (`id`, `menu_id`, `user_web_role_id`, `v`, `i`, `e`, `d`, `o`, `is_deleted`, `created_at`, `created_by`, `last_edited_at`, `last_edited_by`)
VALUES
	(1,1,1,'1','1','1','1','1','0','2023-04-04 14:52:39',1,'2023-04-13 02:03:58',1),
	(2,2,1,'1','1','1','1','1','0','2023-04-04 14:52:39',1,'2023-04-13 02:03:58',1),
	(3,3,1,'1','1','1','1','1','0','2023-04-04 14:52:39',1,'2023-04-13 02:03:58',1),
	(4,4,1,'1','1','1','1','1','0','2023-04-04 14:52:39',1,'2023-04-13 02:03:58',1),
	(5,5,1,'1','1','1','1','1','0','2023-04-04 14:52:39',1,'2023-04-13 02:03:58',1),
	(6,6,1,'1','1','1','1','1','1','2023-04-04 14:52:39',1,NULL,1),
	(7,7,1,'1','1','1','1','1','1','2023-04-04 14:52:39',1,NULL,1),
	(8,64,1,'1','1','1','1','1','0','2023-04-04 03:01:55',1,'2023-04-13 02:03:58',1),
	(9,65,1,'1','1','1','1','1','0','2023-04-04 03:03:41',1,'2023-04-13 02:03:58',1),
	(10,66,1,'1','1','1','1','1','0','2023-04-04 03:03:41',1,'2023-04-13 02:03:58',1),
	(11,67,1,'1','1','1','1','1','1','2023-04-04 03:05:18',1,NULL,NULL),
	(12,68,1,'1','1','1','1','1','0','2023-04-04 03:07:52',1,'2023-04-13 02:03:58',1),
	(13,69,1,'1','1','1','1','1','0','2023-04-04 03:07:52',1,'2023-04-13 02:03:58',1),
	(14,70,1,'1','1','1','1','1','0','2023-04-04 03:07:52',1,'2023-04-13 02:03:58',1),
	(15,72,1,'1','1','1','1','1','0','2023-04-05 01:49:04',1,'2023-04-13 02:03:58',1),
	(16,74,1,'1','1','1','1','1','0','2023-04-11 03:10:20',1,'2023-04-13 02:03:58',1),
	(17,76,1,'1','1','1','1','1','0','2023-04-11 03:16:28',1,'2023-04-13 02:03:58',1),
	(18,77,1,'1','1','1','1','1','0','2023-04-11 03:18:17',1,'2023-04-13 02:03:58',1),
	(19,78,1,'1','1','1','1','1','0','2023-04-11 03:18:17',1,'2023-04-13 02:03:58',1),
	(20,79,1,'1','1','1','1','1','0','2023-04-11 03:18:17',1,'2023-04-13 02:03:58',1),
	(21,80,1,'1','1','1','1','1','0','2023-04-11 03:22:07',1,'2023-04-13 02:03:58',1),
	(22,81,1,'1','1','1','1','1','0','2023-04-11 03:22:07',1,'2023-04-13 02:03:58',1),
	(23,82,1,'1','1','1','1','1','0','2023-04-11 03:22:07',1,'2023-04-13 02:03:58',1),
	(24,83,1,'1','1','1','1','1','0','2023-04-11 03:22:07',1,'2023-04-13 02:03:58',1),
	(25,84,1,'1','1','1','1','1','0','2023-04-11 03:22:07',1,'2023-04-13 02:03:58',1),
	(26,85,1,'1','1','1','1','1','0','2023-04-11 03:22:07',1,'2023-04-13 02:03:58',1),
	(27,87,1,'1','1','1','1','1','0','2023-04-11 03:23:31',1,'2023-04-13 02:03:58',1),
	(28,88,1,'1','1','1','1','1','0','2023-04-11 03:24:39',1,'2023-04-13 02:03:58',1),
	(29,89,1,'1','1','1','1','1','0','2023-04-11 03:24:39',1,'2023-04-13 02:03:58',1),
	(30,90,1,'1','1','1','1','1','0','2023-04-11 21:16:07',1,'2023-04-13 02:03:58',1),
	(31,91,1,'1','1','1','1','1','0','2023-04-11 21:16:07',1,'2023-04-13 02:03:58',1),
	(32,92,1,'1','1','1','1','1','0','2023-04-11 21:16:07',1,'2023-04-13 02:03:58',1),
	(33,93,1,'1','1','1','1','1','0','2023-04-11 21:16:07',1,'2023-04-13 02:03:58',1),
	(34,94,1,'1','1','1','1','1','0','2023-04-11 21:16:07',1,'2023-04-13 02:03:58',1),
	(35,96,1,'1','1','1','1','1','0','2023-04-11 21:16:07',1,'2023-04-13 02:03:58',1),
	(36,98,1,'1','1','1','1','1','0','2023-04-11 21:39:58',1,'2023-04-13 02:03:58',1),
	(37,99,1,'1','1','1','1','1','0','2023-04-11 21:39:58',1,'2023-04-13 02:03:58',1),
	(38,100,1,'1','1','1','1','1','0','2023-04-11 21:42:27',1,'2023-04-13 02:03:58',1),
	(39,101,1,'1','1','1','1','1','0','2023-04-11 21:42:27',1,'2023-04-13 02:03:58',1),
	(40,103,1,'1','1','1','1','1','0','2023-04-13 01:59:45',1,'2023-04-13 02:03:58',1),
	(41,104,1,'1','1','1','1','1','0','2023-04-13 02:03:58',1,NULL,NULL),
	(42,105,1,'1','1','1','1','1','0','2023-04-13 02:03:58',1,NULL,NULL),
	(43,106,1,'1','1','1','1','1','0','2023-04-13 02:03:58',1,NULL,NULL),
	(44,107,1,'1','1','1','1','1','0','2023-04-13 02:03:58',1,NULL,NULL),
	(45,108,1,'1','1','1','1','1','0','2023-04-13 02:03:58',1,NULL,NULL);

/*!40000 ALTER TABLE `s_user_web_privilege` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table s_user_web_role
# ------------------------------------------------------------

DROP TABLE IF EXISTS `s_user_web_role`;

CREATE TABLE `s_user_web_role` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `user_web_role_name` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `is_deleted` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int unsigned DEFAULT NULL,
  `last_edited_at` datetime DEFAULT NULL,
  `last_edited_by` int unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `created_by` (`created_by`),
  KEY `last_edited_by` (`last_edited_by`),
  KEY `is_deleted` (`is_deleted`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

LOCK TABLES `s_user_web_role` WRITE;
/*!40000 ALTER TABLE `s_user_web_role` DISABLE KEYS */;

INSERT INTO `s_user_web_role` (`id`, `user_web_role_name`, `is_deleted`, `created_at`, `created_by`, `last_edited_at`, `last_edited_by`)
VALUES
	(1,'Super Admin','0','2023-04-04 00:00:00',1,NULL,NULL);

/*!40000 ALTER TABLE `s_user_web_role` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table set_def_module
# ------------------------------------------------------------

DROP TABLE IF EXISTS `set_def_module`;

CREATE TABLE `set_def_module` (
  `iduser` int NOT NULL,
  `idmodule` int NOT NULL,
  PRIMARY KEY (`iduser`,`idmodule`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;



# Dump of table set_module_pegawai
# ------------------------------------------------------------

DROP TABLE IF EXISTS `set_module_pegawai`;

CREATE TABLE `set_module_pegawai` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `iduser` int NOT NULL,
  `idmodule` int NOT NULL,
  `d` tinyint NOT NULL DEFAULT '0',
  `e` tinyint NOT NULL DEFAULT '0',
  `v` tinyint NOT NULL DEFAULT '0',
  `i` tinyint NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `unik` (`iduser`,`idmodule`),
  KEY `FKi6m1lff4pnkg5r35o4o0g282g` (`idmodule`),
  CONSTRAINT `FKi6m1lff4pnkg5r35o4o0g282g` FOREIGN KEY (`idmodule`) REFERENCES `ref_module` (`idmodule`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;



# Dump of table set_rute
# ------------------------------------------------------------

DROP TABLE IF EXISTS `set_rute`;

CREATE TABLE `set_rute` (
  `idkor` int DEFAULT NULL,
  `origin` int DEFAULT NULL,
  `destination` int DEFAULT NULL,
  `korname` varchar(200) DEFAULT NULL,
  `jsondata` longtext
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table signage_runningtext
# ------------------------------------------------------------

DROP TABLE IF EXISTS `signage_runningtext`;

CREATE TABLE `signage_runningtext` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `text` text NOT NULL,
  `log` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `aktif` varchar(10) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table sscn_ngi
# ------------------------------------------------------------

DROP TABLE IF EXISTS `sscn_ngi`;

CREATE TABLE `sscn_ngi` (
  `ROWNUM` bigint NOT NULL,
  `INS_NM` varchar(255) DEFAULT NULL,
  `PENDIDIKAN_NM` varchar(255) DEFAULT NULL,
  `LOKASI_NM` varchar(255) DEFAULT NULL,
  `JENIS_FORMASI_NM` varchar(20) DEFAULT NULL,
  `LINK_WEB_INS_DAFTAR` text,
  `JUM_PENDAFTAR` int NOT NULL DEFAULT '0',
  `JUM_PERJAB` int NOT NULL DEFAULT '0',
  `JAB_NM` varchar(255) DEFAULT NULL,
  `INSERT_DATE` datetime DEFAULT NULL,
  PRIMARY KEY (`ROWNUM`),
  KEY `index_1` (`INS_NM`,`JUM_PENDAFTAR`,`JUM_PERJAB`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table sttl_astrapay_paid
# ------------------------------------------------------------

DROP TABLE IF EXISTS `sttl_astrapay_paid`;

CREATE TABLE `sttl_astrapay_paid` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `val_date` date DEFAULT NULL,
  `trx_date` date DEFAULT NULL,
  `billing_date` date DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `tx` int DEFAULT NULL,
  `arsip_no` varchar(100) DEFAULT NULL,
  `debet` int DEFAULT NULL,
  `kredit` int DEFAULT NULL,
  `balance` int DEFAULT NULL,
  `date_insert` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table sttl_bca
# ------------------------------------------------------------

DROP TABLE IF EXISTS `sttl_bca`;

CREATE TABLE `sttl_bca` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `filename` varchar(50) DEFAULT NULL,
  `header` varchar(10) DEFAULT '',
  `body` varchar(250) DEFAULT NULL,
  `footer` varchar(250) DEFAULT NULL,
  `mid` varchar(15) DEFAULT NULL,
  `tid` varchar(8) DEFAULT NULL,
  `deductres` varchar(200) DEFAULT NULL,
  `notrx` varchar(30) DEFAULT NULL,
  `idpta` int DEFAULT NULL,
  `idbus` varchar(8) DEFAULT NULL,
  `shift` int DEFAULT NULL,
  `imei` varchar(16) DEFAULT NULL,
  `log` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `batch_number` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table sttl_bca_bck
# ------------------------------------------------------------

DROP TABLE IF EXISTS `sttl_bca_bck`;

CREATE TABLE `sttl_bca_bck` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `filename` varchar(50) DEFAULT NULL,
  `header` varchar(10) DEFAULT '',
  `body` varchar(250) DEFAULT NULL,
  `footer` varchar(250) DEFAULT NULL,
  `mid` varchar(15) DEFAULT NULL,
  `tid` varchar(8) DEFAULT NULL,
  `deductres` varchar(200) DEFAULT NULL,
  `notrx` varchar(30) DEFAULT NULL,
  `idpta` int DEFAULT NULL,
  `idbus` varchar(8) DEFAULT NULL,
  `shift` int DEFAULT NULL,
  `imei` varchar(16) DEFAULT NULL,
  `log` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `batch_number` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table sttl_bca_failed
# ------------------------------------------------------------

DROP TABLE IF EXISTS `sttl_bca_failed`;

CREATE TABLE `sttl_bca_failed` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `filename` varchar(50) DEFAULT NULL,
  `header` varchar(10) DEFAULT '',
  `body` varchar(250) DEFAULT NULL,
  `footer` varchar(250) DEFAULT NULL,
  `mid` varchar(15) DEFAULT NULL,
  `tid` varchar(8) DEFAULT NULL,
  `deductres` varchar(200) DEFAULT NULL,
  `notrx` varchar(30) DEFAULT NULL,
  `idpta` int DEFAULT NULL,
  `idbus` varchar(8) DEFAULT NULL,
  `shift` int DEFAULT NULL,
  `imei` varchar(16) DEFAULT NULL,
  `log` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `batch_number` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table sttl_bca_paid
# ------------------------------------------------------------

DROP TABLE IF EXISTS `sttl_bca_paid`;

CREATE TABLE `sttl_bca_paid` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `date_trx` date DEFAULT NULL,
  `description` varchar(100) DEFAULT NULL,
  `noreff` varchar(18) DEFAULT NULL,
  `mid` varchar(9) DEFAULT NULL,
  `tid` varchar(10) DEFAULT NULL,
  `merchant` varchar(30) DEFAULT NULL,
  `date_paid` date DEFAULT NULL,
  `branch` varchar(4) DEFAULT NULL,
  `amount` double DEFAULT NULL,
  `trx_type` varchar(10) DEFAULT NULL,
  `last_balance` double DEFAULT NULL,
  `date_sttl` datetime DEFAULT NULL,
  `sttlnum` varchar(7) DEFAULT NULL,
  `dateinsert` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `is_promo` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table sttl_bca_rsf
# ------------------------------------------------------------

DROP TABLE IF EXISTS `sttl_bca_rsf`;

CREATE TABLE `sttl_bca_rsf` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `mid` varchar(12) DEFAULT NULL,
  `filename` varchar(30) DEFAULT NULL,
  `merchant` varchar(40) DEFAULT NULL,
  `tid` varchar(8) DEFAULT NULL,
  `batchnum` varchar(6) DEFAULT NULL,
  `amount` int DEFAULT NULL,
  `date_sttl` date DEFAULT NULL,
  `datetime_trx` timestamp NULL DEFAULT NULL,
  `cardnum` varchar(16) DEFAULT NULL,
  `tracenum` varchar(6) DEFAULT NULL,
  `isvalid` int DEFAULT NULL COMMENT '0: invalid, 1: valid, 2: duplicate, 3: lc, 4: blocked',
  `mdramount` int DEFAULT NULL,
  `grossamount` int DEFAULT NULL,
  `dateinsert` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table sttl_bni
# ------------------------------------------------------------

DROP TABLE IF EXISTS `sttl_bni`;

CREATE TABLE `sttl_bni` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `no_trx` varchar(20) DEFAULT NULL,
  `sttl_filename` varchar(37) DEFAULT NULL,
  `sttl_header` varchar(26) DEFAULT NULL,
  `sttl_body` text,
  `sttl_footer` varchar(15) DEFAULT NULL,
  `sttl_footercrc` varchar(15) DEFAULT NULL,
  `sttl_tmstamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'field digunakan untuk mencatat kapan data dari alat dikirim ke server, namun ditjogja yg lama pas generate file sttl di update',
  `log` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'field digunakan untuk mencatat kapan data dari alat dikirim ke server',
  `iduser` bigint DEFAULT NULL,
  `sttl_iduser` bigint DEFAULT NULL,
  `sttl_shift` tinyint DEFAULT NULL,
  `sttl_idbus` varchar(8) DEFAULT NULL,
  `isack` tinyint NOT NULL DEFAULT '0',
  `ispaid` tinyint NOT NULL DEFAULT '0',
  `iscrc32` tinyint NOT NULL DEFAULT '0',
  `issttl` tinyint NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx` (`sttl_iduser`,`sttl_shift`,`sttl_idbus`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table sttl_bni_paid
# ------------------------------------------------------------

DROP TABLE IF EXISTS `sttl_bni_paid`;

CREATE TABLE `sttl_bni_paid` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `trx_date` datetime DEFAULT NULL,
  `sttl_date` datetime DEFAULT NULL,
  `mid` varchar(255) DEFAULT NULL,
  `merchant` varchar(255) DEFAULT NULL,
  `tid` int DEFAULT NULL,
  `txn_type` varchar(255) DEFAULT NULL,
  `amount` int DEFAULT NULL,
  `txn_fee` int DEFAULT NULL,
  `grace_fee` int DEFAULT NULL,
  `can` bigint DEFAULT NULL,
  `channel` varchar(255) DEFAULT NULL,
  `auth_code` varchar(255) DEFAULT NULL,
  `rrn` varchar(255) DEFAULT NULL,
  `account_num` varchar(255) DEFAULT NULL,
  `month` int DEFAULT NULL,
  `date` date DEFAULT NULL,
  `filter` varchar(100) DEFAULT NULL,
  `hasil` varchar(30) DEFAULT NULL,
  `year` int DEFAULT NULL,
  `paid_date` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table sttl_bni_paid_a
# ------------------------------------------------------------

DROP TABLE IF EXISTS `sttl_bni_paid_a`;

CREATE TABLE `sttl_bni_paid_a` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `paid_date` datetime DEFAULT NULL,
  `trx_date` date DEFAULT NULL,
  `branch` varchar(255) DEFAULT NULL,
  `journal_no` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `amount` varchar(30) DEFAULT NULL,
  `dc` varchar(255) DEFAULT NULL,
  `balance` varchar(255) DEFAULT NULL,
  `date_insert` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `is_promo` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `paid_date` (`paid_date`,`journal_no`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table sttl_bni_paid_b
# ------------------------------------------------------------

DROP TABLE IF EXISTS `sttl_bni_paid_b`;

CREATE TABLE `sttl_bni_paid_b` (
  `paid_date` varchar(100) DEFAULT NULL,
  `branch` varchar(255) DEFAULT NULL,
  `journal_no` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `amount` varchar(30) DEFAULT NULL,
  `dc` varchar(255) DEFAULT NULL,
  `balance` varchar(255) DEFAULT NULL,
  `date_insert` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table sttl_bni_paid_copy
# ------------------------------------------------------------

DROP TABLE IF EXISTS `sttl_bni_paid_copy`;

CREATE TABLE `sttl_bni_paid_copy` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `trx_date` datetime DEFAULT NULL,
  `sttl_date` datetime DEFAULT NULL,
  `mid` varchar(255) DEFAULT NULL,
  `merchant` varchar(255) DEFAULT NULL,
  `tid` int DEFAULT NULL,
  `txn_type` varchar(255) DEFAULT NULL,
  `amount` int DEFAULT NULL,
  `txn_fee` int DEFAULT NULL,
  `grace_fee` int DEFAULT NULL,
  `can` bigint DEFAULT NULL,
  `channel` varchar(255) DEFAULT NULL,
  `auth_code` varchar(255) DEFAULT NULL,
  `rrn` varchar(255) DEFAULT NULL,
  `account_num` varchar(255) DEFAULT NULL,
  `month` int DEFAULT NULL,
  `date` date DEFAULT NULL,
  `filter` varchar(100) DEFAULT NULL,
  `hasil` varchar(30) DEFAULT NULL,
  `year` int DEFAULT NULL,
  `error` varchar(80) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table sttl_bni_rsf
# ------------------------------------------------------------

DROP TABLE IF EXISTS `sttl_bni_rsf`;

CREATE TABLE `sttl_bni_rsf` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `filename` varchar(100) DEFAULT NULL,
  `header` varchar(26) DEFAULT NULL,
  `date_sttl` date DEFAULT NULL,
  `timetrx` time DEFAULT NULL,
  `isvalid` int DEFAULT NULL,
  `note` varchar(255) DEFAULT NULL,
  `cardnum` varchar(20) DEFAULT NULL,
  `sttl_count` int(6) unsigned zerofill DEFAULT NULL,
  `sttl_res` varchar(2) DEFAULT NULL,
  `batchnum` varchar(4) DEFAULT NULL,
  `mid` varchar(15) DEFAULT NULL,
  `tid` varchar(8) DEFAULT NULL,
  `hash` varchar(10) DEFAULT NULL,
  `dateinsert` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `filename` (`filename`,`header`,`hash`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table sttl_bni_rsf_recon
# ------------------------------------------------------------

DROP TABLE IF EXISTS `sttl_bni_rsf_recon`;

CREATE TABLE `sttl_bni_rsf_recon` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `filename` varchar(100) DEFAULT NULL,
  `date_trx` date DEFAULT NULL,
  `time_trx` time DEFAULT NULL,
  `header` varchar(34) DEFAULT NULL,
  `body` varchar(116) DEFAULT NULL,
  `pursebefore` varchar(6) DEFAULT NULL,
  `purseafter` varchar(6) DEFAULT NULL,
  `balancebefore` double DEFAULT NULL,
  `balanceafter` double DEFAULT NULL,
  `amount` double DEFAULT NULL,
  `isvalid` char(2) DEFAULT NULL,
  `footer` varchar(57) DEFAULT NULL,
  `note` varchar(255) DEFAULT NULL,
  `mid` varchar(15) DEFAULT NULL,
  `tid` varchar(8) DEFAULT NULL,
  `date_recon` date DEFAULT NULL,
  `cardnum` varchar(20) DEFAULT NULL,
  `sttl_count` int(6) unsigned zerofill DEFAULT NULL,
  `sttl_res` varchar(2) DEFAULT NULL,
  `batchnum` varchar(4) DEFAULT NULL,
  `hash` varchar(10) DEFAULT NULL,
  `dateinsert` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table sttl_bri
# ------------------------------------------------------------

DROP TABLE IF EXISTS `sttl_bri`;

CREATE TABLE `sttl_bri` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `no_trx` varchar(20) DEFAULT NULL,
  `sttl_filename` varchar(50) DEFAULT NULL,
  `sttl_header` varchar(26) DEFAULT NULL,
  `sttl_body` varchar(255) DEFAULT '',
  `sttl_footer` varchar(15) DEFAULT NULL,
  `sttl_footercrc` varchar(15) DEFAULT NULL,
  `sttl_tmstamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `iduser` bigint DEFAULT NULL,
  `sttl_iduser` bigint DEFAULT NULL,
  `sttl_shift` tinyint DEFAULT NULL,
  `sttl_idbus` varchar(8) DEFAULT NULL,
  `isack` tinyint NOT NULL DEFAULT '0',
  `ispaid` tinyint NOT NULL DEFAULT '0',
  `iscrc32` tinyint NOT NULL DEFAULT '0',
  `tgl` datetime DEFAULT NULL,
  `issttl` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx` (`sttl_iduser`,`sttl_shift`,`sttl_idbus`),
  KEY `sttl_filename` (`sttl_filename`),
  KEY `sttl_filename_2` (`sttl_filename`,`sttl_body`),
  KEY `sttl_tmstamp` (`sttl_tmstamp`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table sttl_bri_paid
# ------------------------------------------------------------

DROP TABLE IF EXISTS `sttl_bri_paid`;

CREATE TABLE `sttl_bri_paid` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `date` date DEFAULT NULL COMMENT 'paid_date',
  `sttl_date` date DEFAULT NULL COMMENT 'trx_date',
  `trx_ref` varchar(100) DEFAULT NULL,
  `file_1` varchar(20) DEFAULT NULL,
  `body` int DEFAULT NULL,
  `file_2` varchar(11) DEFAULT NULL,
  `shift` varchar(5) DEFAULT NULL,
  `count` int DEFAULT NULL,
  `kredit` int DEFAULT NULL,
  `date_insert` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `is_promo` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `file_1` (`file_1`),
  KEY `file_2` (`file_2`),
  KEY `shift` (`shift`),
  KEY `body` (`body`),
  KEY `file_1_2` (`file_1`,`file_2`,`shift`,`body`),
  KEY `date` (`date`),
  KEY `trx_ref` (`trx_ref`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table sttl_bri_paid_cek
# ------------------------------------------------------------

DROP TABLE IF EXISTS `sttl_bri_paid_cek`;

CREATE TABLE `sttl_bri_paid_cek` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `tanggal` varchar(20) DEFAULT NULL,
  `transaksi` varchar(255) DEFAULT NULL,
  `debet` varchar(255) DEFAULT NULL,
  `kredit` varchar(255) DEFAULT NULL,
  `Saldo` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table sttl_bri_promo
# ------------------------------------------------------------

DROP TABLE IF EXISTS `sttl_bri_promo`;

CREATE TABLE `sttl_bri_promo` (
  `date` date DEFAULT NULL,
  `post` varchar(100) DEFAULT NULL,
  `count` int DEFAULT NULL,
  `kode` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table sttl_bri_rsf
# ------------------------------------------------------------

DROP TABLE IF EXISTS `sttl_bri_rsf`;

CREATE TABLE `sttl_bri_rsf` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `filename` varchar(100) DEFAULT NULL,
  `header` varchar(26) DEFAULT NULL,
  `body` varchar(150) DEFAULT '',
  `date_sttl` date DEFAULT NULL,
  `datetime_trx` timestamp NULL DEFAULT NULL,
  `isvalid` int DEFAULT NULL,
  `cardnum` varchar(16) DEFAULT NULL,
  `amount` int DEFAULT NULL,
  `refnum` varchar(6) DEFAULT NULL,
  `batchnum` varchar(2) DEFAULT NULL,
  `mid` varchar(15) DEFAULT NULL,
  `tid` varchar(8) DEFAULT NULL,
  `hash` varchar(8) DEFAULT NULL,
  `dateinsert` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `body` (`body`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DELIMITER ;;
/*!50003 SET SESSION SQL_MODE="NO_AUTO_VALUE_ON_ZERO" */;;
/*!50003 CREATE */ /*!50017 DEFINER=`transjog`@`%` */ /*!50003 TRIGGER `tr_sbr_b_ins` BEFORE INSERT ON `sttl_bri_rsf` FOR EACH ROW begin
set new.cardnum = LEFT(new.body,16);
set new.amount = MID(new.body,29,8);
set new.refnum = MID(new.body,39,6);
set new.batchnum = MID(new.body,45,2);
set new.mid = MID(new.body,47,15);
set new.tid = MID(new.body,62,8);
set new.hash = MID(new.body,70,8);
end */;;
DELIMITER ;
/*!50003 SET SESSION SQL_MODE=@OLD_SQL_MODE */;


# Dump of table sttl_bri_rsf_bck
# ------------------------------------------------------------

DROP TABLE IF EXISTS `sttl_bri_rsf_bck`;

CREATE TABLE `sttl_bri_rsf_bck` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `filename` varchar(100) DEFAULT NULL,
  `header` varchar(26) DEFAULT NULL,
  `body` varchar(150) DEFAULT '',
  `date_sttl` date DEFAULT NULL,
  `datetime_trx` timestamp NULL DEFAULT NULL,
  `isvalid` int DEFAULT NULL,
  `cardnum` varchar(16) DEFAULT NULL,
  `amount` int DEFAULT NULL,
  `refnum` varchar(6) DEFAULT NULL,
  `batchnum` varchar(2) DEFAULT NULL,
  `mid` varchar(15) DEFAULT NULL,
  `tid` varchar(8) DEFAULT NULL,
  `hash` varchar(8) DEFAULT NULL,
  `dateinsert` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `body` (`body`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table sttl_gopay
# ------------------------------------------------------------

DROP TABLE IF EXISTS `sttl_gopay`;

CREATE TABLE `sttl_gopay` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `payment_type` varchar(20) DEFAULT NULL,
  `transaction_time` varchar(20) DEFAULT NULL,
  `settlement_time` varchar(20) DEFAULT NULL,
  `order_id` varchar(45) DEFAULT NULL,
  `customer_email` varchar(40) DEFAULT NULL,
  `credit_card_number_mask` varchar(20) DEFAULT NULL,
  `refund_amount` double(11,2) DEFAULT NULL,
  `amount` double(11,2) DEFAULT NULL,
  `3d_secure` varchar(20) DEFAULT NULL,
  `card_association` varchar(255) DEFAULT NULL,
  `acquiring_bank` varchar(20) DEFAULT NULL,
  `bank_on_off_us` varchar(20) DEFAULT NULL,
  `transaction_fee` double(11,2) DEFAULT NULL,
  `merchant_has` double(11,2) DEFAULT NULL,
  `refund` varchar(10) DEFAULT NULL,
  `transaction_timestamp` datetime DEFAULT NULL,
  `settlement_timestamp` datetime DEFAULT NULL,
  `date_insert` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `paid_date` date DEFAULT NULL,
  `bill_id` varchar(12) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `order_id` (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table sttl_gopay_bck
# ------------------------------------------------------------

DROP TABLE IF EXISTS `sttl_gopay_bck`;

CREATE TABLE `sttl_gopay_bck` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `payment_type` varchar(20) DEFAULT NULL,
  `transaction_time` varchar(20) DEFAULT NULL,
  `settlement_time` varchar(20) DEFAULT NULL,
  `order_id` varchar(45) DEFAULT NULL,
  `customer_email` varchar(40) DEFAULT NULL,
  `credit_card_number_mask` varchar(20) DEFAULT NULL,
  `refund_amount` double(11,2) DEFAULT NULL,
  `amount` double(11,2) DEFAULT NULL,
  `3d_secure` varchar(20) DEFAULT NULL,
  `card_association` varchar(255) DEFAULT NULL,
  `acquiring_bank` varchar(20) DEFAULT NULL,
  `bank_on_off_us` varchar(20) DEFAULT NULL,
  `transaction_fee` double(11,2) DEFAULT NULL,
  `merchant_has` double(11,2) DEFAULT NULL,
  `refund` varchar(10) DEFAULT NULL,
  `transaction_timestamp` datetime DEFAULT NULL,
  `settlement_timestamp` datetime DEFAULT NULL,
  `date_insert` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `paid_date` date DEFAULT NULL,
  `bill_id` varchar(12) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `order_id` (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table sttl_gopay_paid
# ------------------------------------------------------------

DROP TABLE IF EXISTS `sttl_gopay_paid`;

CREATE TABLE `sttl_gopay_paid` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `val_date` date DEFAULT NULL,
  `trx_date` date DEFAULT NULL,
  `billing_date` date DEFAULT NULL,
  `id_billing` varchar(12) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `tx` int DEFAULT NULL,
  `arsip_no` varchar(100) DEFAULT NULL,
  `debet` int DEFAULT NULL,
  `kredit` int DEFAULT NULL,
  `balance` int DEFAULT NULL,
  `date_insert` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table sttl_kmt
# ------------------------------------------------------------

DROP TABLE IF EXISTS `sttl_kmt`;

CREATE TABLE `sttl_kmt` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `c_trans` varchar(1024) DEFAULT NULL,
  `notrx` varchar(30) DEFAULT NULL,
  `settle_raw_code` varchar(50) DEFAULT NULL,
  `status_code` int DEFAULT NULL,
  `amount` int DEFAULT NULL,
  `saldo` int DEFAULT NULL,
  `request` varchar(1024) DEFAULT NULL,
  `response` varchar(1024) DEFAULT NULL,
  `idpta` int DEFAULT NULL,
  `idbus` varchar(8) DEFAULT NULL,
  `shift` int DEFAULT NULL,
  `imei` varchar(16) DEFAULT NULL,
  `jenis` varchar(50) DEFAULT NULL,
  `log_insert` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `log` varchar(255) DEFAULT NULL,
  `mid` varchar(255) DEFAULT NULL,
  `tid` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unix_trx` (`c_trans`,`notrx`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table sttl_kmt_log
# ------------------------------------------------------------

DROP TABLE IF EXISTS `sttl_kmt_log`;

CREATE TABLE `sttl_kmt_log` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `c_trans` varchar(255) DEFAULT NULL,
  `notrx` varchar(30) DEFAULT NULL,
  `status_code` varchar(5) DEFAULT NULL,
  `settle_raw_code` varchar(50) DEFAULT NULL,
  `amount` int DEFAULT NULL,
  `saldo` int DEFAULT NULL,
  `request` varchar(1024) DEFAULT NULL,
  `response` varchar(1024) DEFAULT NULL,
  `idpta` int DEFAULT NULL,
  `idbus` varchar(8) DEFAULT NULL,
  `shift` int DEFAULT NULL,
  `imei` varchar(16) DEFAULT NULL,
  `jenis` varchar(50) DEFAULT NULL,
  `datetime` varchar(30) DEFAULT NULL,
  `log_insert` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table sttl_linkaja_paid
# ------------------------------------------------------------

DROP TABLE IF EXISTS `sttl_linkaja_paid`;

CREATE TABLE `sttl_linkaja_paid` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `paid_date` datetime DEFAULT NULL,
  `trx_date` date DEFAULT NULL,
  `alias` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `trx_ref` varchar(100) DEFAULT NULL,
  `debit` double(20,2) DEFAULT NULL,
  `credit` double(20,2) DEFAULT NULL,
  `balance` varchar(20) DEFAULT NULL,
  `date_insert` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `is_promo` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table sttl_linkaja_paid_copy
# ------------------------------------------------------------

DROP TABLE IF EXISTS `sttl_linkaja_paid_copy`;

CREATE TABLE `sttl_linkaja_paid_copy` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `paid_date` varchar(100) DEFAULT NULL,
  `trx_date` varchar(100) DEFAULT NULL,
  `alias` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `debit` varchar(20) DEFAULT NULL,
  `credit` varchar(20) DEFAULT NULL,
  `balance` varchar(30) DEFAULT NULL,
  `date_insert` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `is_promo` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table sttl_mandiri
# ------------------------------------------------------------

DROP TABLE IF EXISTS `sttl_mandiri`;

CREATE TABLE `sttl_mandiri` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `filename` varchar(100) DEFAULT NULL,
  `header` varchar(44) DEFAULT '',
  `body` varchar(115) DEFAULT NULL,
  `footer` varchar(12) DEFAULT NULL,
  `mid` varchar(8) DEFAULT NULL,
  `tid` varchar(8) DEFAULT NULL,
  `psam` varchar(4) DEFAULT NULL,
  `notrx` varchar(30) DEFAULT NULL,
  `idpta` int DEFAULT NULL,
  `idbus` varchar(8) DEFAULT NULL,
  `shift` int DEFAULT NULL,
  `log` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `filename` (`filename`),
  KEY `log` (`log`),
  KEY `filename_2` (`filename`,`log`),
  KEY `notrx` (`notrx`),
  KEY `notrxlog` (`notrx`,`log`),
  KEY `notrxlogbody` (`notrx`,`log`,`body`),
  KEY `body` (`body`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DELIMITER ;;
/*!50003 SET SESSION SQL_MODE="NO_AUTO_VALUE_ON_ZERO" */;;
/*!50003 CREATE */ /*!50017 DEFINER=`transjog`@`%` */ /*!50003 TRIGGER `tr_sttl_mandiri_b_del` BEFORE DELETE ON `sttl_mandiri` FOR EACH ROW begin
	replace into sttl_mandiri_copy2
(id,filename,header,body,footer,mid,tid,psam,notrx,idpta,idbus,shift,log)
select old.id,old.filename,old.header,old.body,old.footer,old.mid,old.tid,old.psam,old.notrx,old.idpta,old.idbus,old.shift,old.log;
end */;;
DELIMITER ;
/*!50003 SET SESSION SQL_MODE=@OLD_SQL_MODE */;


# Dump of table sttl_mandiri_check
# ------------------------------------------------------------

DROP TABLE IF EXISTS `sttl_mandiri_check`;

CREATE TABLE `sttl_mandiri_check` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `notes` varchar(255) DEFAULT NULL,
  `q` text,
  `act` text,
  `tmstamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table sttl_mandiri_copy
# ------------------------------------------------------------

DROP TABLE IF EXISTS `sttl_mandiri_copy`;

CREATE TABLE `sttl_mandiri_copy` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `filename` varchar(100) DEFAULT NULL,
  `header` varchar(44) DEFAULT '',
  `body` varchar(100) DEFAULT NULL,
  `footer` varchar(12) DEFAULT NULL,
  `mid` varchar(8) DEFAULT NULL,
  `tid` varchar(8) DEFAULT NULL,
  `psam` varchar(4) DEFAULT NULL,
  `notrx` varchar(30) DEFAULT NULL,
  `idpta` int DEFAULT NULL,
  `idbus` varchar(8) DEFAULT NULL,
  `shift` int DEFAULT NULL,
  `log` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `filename` (`filename`),
  KEY `log` (`log`),
  KEY `filename_2` (`filename`,`log`),
  KEY `notrx` (`notrx`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table sttl_mandiri_copy2
# ------------------------------------------------------------

DROP TABLE IF EXISTS `sttl_mandiri_copy2`;

CREATE TABLE `sttl_mandiri_copy2` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `filename` varchar(100) DEFAULT NULL,
  `header` varchar(44) DEFAULT '',
  `body` varchar(100) DEFAULT NULL,
  `footer` varchar(12) DEFAULT NULL,
  `mid` varchar(8) DEFAULT NULL,
  `tid` varchar(8) DEFAULT NULL,
  `psam` varchar(4) DEFAULT NULL,
  `notrx` varchar(30) DEFAULT NULL,
  `idpta` int DEFAULT NULL,
  `idbus` varchar(8) DEFAULT NULL,
  `shift` int DEFAULT NULL,
  `log` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `filename` (`filename`),
  KEY `log` (`log`),
  KEY `filename_2` (`filename`,`log`),
  KEY `notrx` (`notrx`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table sttl_mandiri_paid
# ------------------------------------------------------------

DROP TABLE IF EXISTS `sttl_mandiri_paid`;

CREATE TABLE `sttl_mandiri_paid` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `date_paid` timestamp NULL DEFAULT NULL,
  `date_trx` datetime DEFAULT NULL,
  `date_body_sttl` varchar(12) DEFAULT NULL,
  `description` text,
  `sttl_file_name` varchar(100) DEFAULT NULL,
  `noref` varchar(100) DEFAULT NULL,
  `amount` int DEFAULT NULL,
  `brance_code` int DEFAULT NULL,
  `date_insert` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `is_promo` int NOT NULL DEFAULT '0',
  `date_paid_col` timestamp NULL DEFAULT NULL COMMENT 'date_paid dari kolom date & time',
  PRIMARY KEY (`id`),
  KEY `date_paid` (`date_paid`),
  KEY `sttl_file_name` (`sttl_file_name`),
  KEY `date_paid_2` (`date_paid`,`sttl_file_name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table sttl_mandiri_report
# ------------------------------------------------------------

DROP TABLE IF EXISTS `sttl_mandiri_report`;

CREATE TABLE `sttl_mandiri_report` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `processing_date` date DEFAULT NULL,
  `trx_date` date DEFAULT NULL,
  `brance_code` varchar(255) DEFAULT NULL,
  `gate` varchar(255) DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL,
  `trx` int DEFAULT NULL,
  `amount` int DEFAULT NULL,
  `amount_paid` int DEFAULT NULL,
  `amount_rek` int DEFAULT NULL,
  `diff` varchar(255) DEFAULT NULL,
  `paid_date_1` varchar(255) DEFAULT NULL,
  `paid_date_2` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table sttl_mandiri_rsf
# ------------------------------------------------------------

DROP TABLE IF EXISTS `sttl_mandiri_rsf`;

CREATE TABLE `sttl_mandiri_rsf` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `filename` varchar(50) DEFAULT NULL,
  `filename2` varchar(1024) DEFAULT NULL,
  `header` varchar(26) DEFAULT NULL,
  `body` varchar(104) DEFAULT '',
  `date_sttl` date DEFAULT NULL,
  `datetime_trx` timestamp NULL DEFAULT NULL,
  `isvalid` int DEFAULT NULL,
  `cardnum` varchar(16) DEFAULT NULL,
  `amount` double DEFAULT NULL,
  `lastbalance` double DEFAULT NULL,
  `mac` varchar(5) DEFAULT NULL,
  `note` varchar(225) DEFAULT NULL,
  `seq` int(6) unsigned zerofill DEFAULT NULL,
  `refnum` varchar(6) DEFAULT NULL,
  `batchnum` varchar(2) DEFAULT NULL,
  `mid` varchar(15) DEFAULT NULL,
  `tid` varchar(8) DEFAULT NULL,
  `hash` varchar(8) DEFAULT NULL,
  `dateinsert` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unimandiri` (`body`,`note`,`isvalid`),
  KEY `filename` (`filename2`),
  KEY `datetime_trx` (`datetime_trx`),
  KEY `body` (`body`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DELIMITER ;;
/*!50003 SET SESSION SQL_MODE="NO_AUTO_VALUE_ON_ZERO" */;;
/*!50003 CREATE */ /*!50017 DEFINER=`transjog`@`%` */ /*!50003 TRIGGER `tr_mandiri_rsf_b_ins` BEFORE INSERT ON `sttl_mandiri_rsf` FOR EACH ROW begin
	set new.filename2 = replace(new.filename2,'.TXT','');
end */;;
DELIMITER ;
/*!50003 SET SESSION SQL_MODE=@OLD_SQL_MODE */;


# Dump of table sttl_tcash
# ------------------------------------------------------------

DROP TABLE IF EXISTS `sttl_tcash`;

CREATE TABLE `sttl_tcash` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `sttl_filename` varchar(50) DEFAULT NULL,
  `sttl_header` varchar(26) DEFAULT NULL,
  `sttl_body` text,
  `sttl_footer` varchar(15) DEFAULT NULL,
  `sttl_footercrc` varchar(15) DEFAULT NULL,
  `sttl_tmstamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `iduser` bigint DEFAULT NULL,
  `sttl_iduser` bigint DEFAULT NULL,
  `sttl_shift` tinyint DEFAULT NULL,
  `sttl_idbus` varchar(8) DEFAULT NULL,
  `isack` tinyint NOT NULL DEFAULT '0',
  `ispaid` tinyint NOT NULL DEFAULT '0',
  `iscrc32` tinyint NOT NULL DEFAULT '0',
  `tgl` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx` (`sttl_iduser`,`sttl_shift`,`sttl_idbus`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table t_penumpang
# ------------------------------------------------------------

DROP TABLE IF EXISTS `t_penumpang`;

CREATE TABLE `t_penumpang` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `id_shelter` int DEFAULT NULL,
  `jam` time DEFAULT NULL,
  `naik` int DEFAULT NULL,
  `turun` int DEFAULT NULL,
  `rit` int DEFAULT NULL,
  `koridor` varchar(5) DEFAULT NULL,
  `bis` varchar(10) DEFAULT NULL,
  `shift` tinyint DEFAULT NULL,
  `date_alat` date DEFAULT NULL,
  `id_pta` int DEFAULT NULL,
  `date_insert` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_shelter` (`id_shelter`,`rit`,`koridor`,`bis`,`date_alat`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table tapinout
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tapinout`;

CREATE TABLE `tapinout` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `idbus` varchar(8) DEFAULT NULL,
  `taptime` datetime DEFAULT NULL,
  `long` varchar(20) DEFAULT NULL,
  `lat` varchar(20) DEFAULT NULL,
  `imei` varchar(40) DEFAULT NULL,
  `idkartu` varchar(30) DEFAULT NULL,
  `datalog` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table tarif
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tarif`;

CREATE TABLE `tarif` (
  `id` int NOT NULL AUTO_INCREMENT,
  `jenis` varchar(18) NOT NULL DEFAULT '',
  `tarif` decimal(11,0) DEFAULT NULL,
  `tarif_normal` decimal(11,0) DEFAULT NULL,
  `deposit` decimal(11,0) NOT NULL DEFAULT '0',
  `is_aktif` int NOT NULL DEFAULT '0',
  `is_cashless` int NOT NULL DEFAULT '0',
  `kategori` int DEFAULT '0',
  `payment_type` int DEFAULT '0' COMMENT '1:Qris,2: WCO',
  `tiket_pis` varchar(50) DEFAULT NULL,
  `payment_pis` varchar(50) DEFAULT NULL,
  `payment_icon_pis` varchar(50) DEFAULT NULL,
  `id_promo_pis` int DEFAULT NULL,
  `created_by` int NOT NULL,
  `last_edited_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `last_edited_by` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `jenis` (`jenis`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

LOCK TABLES `tarif` WRITE;
/*!40000 ALTER TABLE `tarif` DISABLE KEYS */;

INSERT INTO `tarif` (`id`, `jenis`, `tarif`, `tarif_normal`, `deposit`, `is_aktif`, `is_cashless`, `kategori`, `payment_type`, `tiket_pis`, `payment_pis`, `payment_icon_pis`, `id_promo_pis`, `created_by`, `last_edited_at`, `created_at`, `last_edited_by`)
VALUES
	(1,'Transit',0,NULL,0,0,0,8,0,NULL,NULL,NULL,NULL,1,'2023-04-06 00:07:18','2023-04-04 15:59:34',1),
	(3,'TransTangerang Umu',3000,NULL,2500,1,0,0,0,NULL,NULL,NULL,NULL,1,NULL,'2023-04-05 14:04:51',NULL),
	(2,'Umum',3600,NULL,3500,0,0,8,0,NULL,NULL,NULL,NULL,1,'2023-04-06 00:01:41','2023-04-05 13:45:31',1);

/*!40000 ALTER TABLE `tarif` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table tcash_init
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tcash_init`;

CREATE TABLE `tcash_init` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `mandate_id` int DEFAULT NULL,
  `reference_number` varchar(15) DEFAULT NULL,
  `uid` varchar(8) DEFAULT NULL,
  `msisdn` varchar(14) DEFAULT NULL,
  `imei_device` varchar(15) DEFAULT NULL,
  `id_pta` int DEFAULT NULL,
  `request_count` int DEFAULT '1',
  `date_insert` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `is_active` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table tcash_online
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tcash_online`;

CREATE TABLE `tcash_online` (
  `trx_id` varchar(12) NOT NULL,
  `uid` varchar(8) NOT NULL,
  `trx_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `amount` double(16,0) NOT NULL DEFAULT '0',
  `trx_type` tinyint NOT NULL DEFAULT '1',
  `flag` tinyint NOT NULL DEFAULT '2',
  `gateway` varchar(5) NOT NULL DEFAULT 'VFMM',
  `appsid` varchar(5) NOT NULL DEFAULT 'vfmm',
  `pwd` varchar(10) NOT NULL DEFAULT '1234567',
  `mid` varchar(15) NOT NULL DEFAULT '511251525053369',
  `tid` varchar(8) NOT NULL DEFAULT '84667113',
  `ip` varchar(30) DEFAULT NULL,
  `imei` varchar(20) DEFAULT NULL,
  `idpta` bigint DEFAULT NULL,
  `idbus` varchar(8) DEFAULT NULL,
  `shift` tinyint NOT NULL DEFAULT '1',
  `resp_code` varchar(4) DEFAULT NULL,
  `resp_amount` double(16,0) NOT NULL DEFAULT '0',
  `resp_tcashrefnum` varchar(17) DEFAULT NULL,
  `resp_trx_type` tinyint DEFAULT NULL,
  `resp_trx_date` datetime DEFAULT NULL,
  PRIMARY KEY (`trx_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table trafic
# ------------------------------------------------------------

DROP TABLE IF EXISTS `trafic`;

CREATE TABLE `trafic` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_bus` varchar(10) NOT NULL DEFAULT '',
  `intensitas` int NOT NULL,
  `id_petugas` int NOT NULL,
  `latitude` double NOT NULL,
  `longitude` double NOT NULL,
  `speed` double NOT NULL,
  `timestam` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `log` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table transaksi
# ------------------------------------------------------------

DROP TABLE IF EXISTS `transaksi`;

CREATE TABLE `transaksi` (
  `idTransaksi` int NOT NULL AUTO_INCREMENT,
  `ID` varchar(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `Tanggal` date DEFAULT NULL,
  `Jam` time DEFAULT NULL,
  `Latitude` decimal(18,6) DEFAULT NULL,
  `Longitude` decimal(18,6) DEFAULT NULL,
  `Speed` int DEFAULT NULL,
  `Lokasi` varchar(60) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `StatusIO` int DEFAULT NULL,
  `Ketinggian` int DEFAULT NULL,
  `Arah` int DEFAULT NULL,
  `Alarm` int DEFAULT NULL,
  `JenisAlarm` varchar(40) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `AD1` decimal(10,0) NOT NULL,
  `AD2` decimal(10,0) NOT NULL,
  PRIMARY KEY (`idTransaksi`),
  UNIQUE KEY `byIDTglJam` (`ID`,`Tanggal`,`Jam`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;



# Dump of table transaksibis
# ------------------------------------------------------------

DROP TABLE IF EXISTS `transaksibis`;

CREATE TABLE `transaksibis` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `nokartu` varchar(22) NOT NULL DEFAULT '',
  `notrx` varchar(20) DEFAULT NULL,
  `tanggal` date NOT NULL,
  `jam` time NOT NULL,
  `kredit` decimal(11,0) DEFAULT NULL,
  `normal_kredit` decimal(11,0) DEFAULT NULL,
  `saldo` decimal(11,0) DEFAULT NULL,
  `bis` varchar(8) NOT NULL DEFAULT '',
  `status` int DEFAULT NULL,
  `latitude` decimal(18,6) DEFAULT NULL,
  `longitude` decimal(18,6) DEFAULT NULL,
  `lokasi` varchar(80) DEFAULT NULL,
  `speed` int DEFAULT NULL,
  `arah` int DEFAULT NULL,
  `jenis` varchar(20) DEFAULT NULL,
  `imei` varchar(15) DEFAULT NULL,
  `date_insert` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_alat` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_id` (`id`),
  UNIQUE KEY `byNoKartuTglJam` (`nokartu`,`tanggal`,`jam`,`arah`,`imei`),
  KEY `idx_jenis` (`jenis`),
  KEY `idx_tanggal` (`tanggal`),
  KEY `idx_jam` (`jam`),
  KEY `idx_bis` (`bis`),
  KEY `idx_jen_tgl` (`tanggal`,`jenis`),
  KEY `idx_arahbisjenis` (`bis`,`arah`,`jenis`),
  KEY `idx_trx` (`notrx`,`tanggal`,`jenis`),
  KEY `jenis_tgl_jam` (`tanggal`,`jam`,`jenis`),
  KEY `idx_datealat` (`date_alat`),
  KEY `idxsttl` (`notrx`,`tanggal`,`jenis`),
  KEY `notrxjenis` (`notrx`,`jenis`),
  KEY `notrx` (`notrx`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;


DELIMITER ;;
/*!50003 SET SESSION SQL_MODE="NO_AUTO_VALUE_ON_ZERO" */;;
/*!50003 CREATE */ /*!50017 DEFINER=`dplk`@`%` */ /*!50003 TRIGGER `transaksibis_b_ins` BEFORE INSERT ON `transaksibis` FOR EACH ROW begin
	/*if (date(now())!=new.tanggal) then
		set new.date_alat = new.tanggal;
		set new.tanggal = date(now());
	end if;*/
	
	set new.normal_kredit = (select tarif_normal from tarif where jenis = new.jenis);
end */;;
/*!50003 SET SESSION SQL_MODE="NO_AUTO_VALUE_ON_ZERO" */;;
/*!50003 CREATE */ /*!50017 DEFINER=`transjog`@`%` */ /*!50003 TRIGGER `transaksibis_b_upd` BEFORE UPDATE ON `transaksibis` FOR EACH ROW begin
	/*if (date(now())!=new.tanggal) then
		set new.date_alat = new.tanggal;
		set new.tanggal = date(now());
	end if;*/
end */;;
/*!50003 SET SESSION SQL_MODE="NO_AUTO_VALUE_ON_ZERO" */;;
/*!50003 CREATE */ /*!50017 DEFINER=`transjog`@`%` */ /*!50003 TRIGGER `transaksibis_b_del` AFTER DELETE ON `transaksibis` FOR EACH ROW begin
	insert into transaksibis_tmp 
(id,nokartu,notrx,tanggal,jam,kredit,saldo,bis,status,latitude,longitude,lokasi,speed,arah,jenis,imei,date_insert)
select old.id,old.nokartu,old.notrx,old.tanggal,old.jam,old.kredit,old.saldo,old.bis,old.status,old.latitude,old.longitude,old.lokasi,old.speed,old.arah,old.jenis,old.imei,old.date_insert ON DUPLICATE KEY UPDATE id=old.id;
delete from sttl_mandiri where notrx=old.notrx;
end */;;
DELIMITER ;
/*!50003 SET SESSION SQL_MODE=@OLD_SQL_MODE */;


# Dump of table transaksibis_astrapay_dev
# ------------------------------------------------------------

DROP TABLE IF EXISTS `transaksibis_astrapay_dev`;

CREATE TABLE `transaksibis_astrapay_dev` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `nokartu` varchar(22) NOT NULL DEFAULT '',
  `notrx` varchar(20) DEFAULT NULL,
  `tanggal` date NOT NULL,
  `jam` time NOT NULL,
  `kredit` decimal(11,0) DEFAULT NULL,
  `normal_kredit` decimal(11,0) DEFAULT NULL,
  `saldo` decimal(11,0) DEFAULT NULL,
  `bis` varchar(8) NOT NULL DEFAULT '',
  `status` int DEFAULT NULL,
  `latitude` decimal(18,6) DEFAULT NULL,
  `longitude` decimal(18,6) DEFAULT NULL,
  `lokasi` varchar(80) DEFAULT NULL,
  `speed` int DEFAULT NULL,
  `arah` int DEFAULT NULL,
  `jenis` varchar(20) DEFAULT NULL,
  `imei` varchar(15) DEFAULT NULL,
  `date_insert` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_alat` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_id` (`id`),
  UNIQUE KEY `byNoKartuTglJam` (`nokartu`,`tanggal`,`jam`,`arah`,`imei`),
  KEY `idx_jenis` (`jenis`),
  KEY `idx_tanggal` (`tanggal`),
  KEY `idx_jam` (`jam`),
  KEY `idx_bis` (`bis`),
  KEY `idx_jen_tgl` (`tanggal`,`jenis`),
  KEY `idx_arahbisjenis` (`bis`,`arah`,`jenis`),
  KEY `idx_trx` (`notrx`,`tanggal`,`jenis`),
  KEY `jenis_tgl_jam` (`tanggal`,`jam`,`jenis`),
  KEY `idx_datealat` (`date_alat`),
  KEY `idxsttl` (`notrx`,`tanggal`,`jenis`),
  KEY `notrxjenis` (`notrx`,`jenis`),
  KEY `notrx` (`notrx`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;



# Dump of table transaksibis_copy
# ------------------------------------------------------------

DROP TABLE IF EXISTS `transaksibis_copy`;

CREATE TABLE `transaksibis_copy` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `nokartu` varchar(22) NOT NULL DEFAULT '',
  `notrx` varchar(20) DEFAULT NULL,
  `tanggal` date NOT NULL,
  `jam` time NOT NULL,
  `kredit` decimal(11,0) DEFAULT NULL,
  `saldo` decimal(11,0) DEFAULT NULL,
  `bis` varchar(6) NOT NULL DEFAULT '',
  `status` int DEFAULT NULL,
  `latitude` decimal(18,6) DEFAULT NULL,
  `longitude` decimal(18,6) DEFAULT NULL,
  `lokasi` varchar(80) DEFAULT NULL,
  `speed` int DEFAULT NULL,
  `arah` int DEFAULT NULL,
  `jenis` varchar(20) DEFAULT NULL,
  `imei` varchar(15) DEFAULT NULL,
  `date_insert` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_alat` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_id` (`id`),
  UNIQUE KEY `byNoKartuTglJam` (`nokartu`,`tanggal`,`jam`,`arah`,`imei`),
  KEY `idx_jenis` (`jenis`),
  KEY `idx_tanggal` (`tanggal`),
  KEY `idx_jam` (`jam`),
  KEY `idx_bis` (`bis`),
  KEY `idx_jen_tgl` (`tanggal`,`jenis`),
  KEY `idx_arahbisjenis` (`bis`,`arah`,`jenis`),
  KEY `idx_trx` (`notrx`,`tanggal`,`jenis`),
  KEY `jenis_tgl_jam` (`tanggal`,`jam`,`jenis`),
  KEY `idx_datealat` (`date_alat`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;



# Dump of table transaksibis_copy2
# ------------------------------------------------------------

DROP TABLE IF EXISTS `transaksibis_copy2`;

CREATE TABLE `transaksibis_copy2` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `nokartu` varchar(22) NOT NULL DEFAULT '',
  `notrx` varchar(20) DEFAULT NULL,
  `tanggal` date NOT NULL,
  `jam` time NOT NULL,
  `kredit` decimal(11,0) DEFAULT NULL,
  `saldo` decimal(11,0) DEFAULT NULL,
  `bis` varchar(8) NOT NULL DEFAULT '',
  `status` int DEFAULT NULL,
  `latitude` decimal(18,6) DEFAULT NULL,
  `longitude` decimal(18,6) DEFAULT NULL,
  `lokasi` varchar(80) DEFAULT NULL,
  `speed` int DEFAULT NULL,
  `arah` int DEFAULT NULL,
  `jenis` varchar(20) DEFAULT NULL,
  `imei` varchar(15) DEFAULT NULL,
  `date_insert` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_alat` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_id` (`id`),
  UNIQUE KEY `byNoKartuTglJam` (`nokartu`,`tanggal`,`jam`,`arah`,`imei`),
  KEY `idx_jenis` (`jenis`),
  KEY `idx_tanggal` (`tanggal`),
  KEY `idx_jam` (`jam`),
  KEY `idx_bis` (`bis`),
  KEY `idx_jen_tgl` (`tanggal`,`jenis`),
  KEY `idx_arahbisjenis` (`bis`,`arah`,`jenis`),
  KEY `idx_trx` (`notrx`,`tanggal`,`jenis`),
  KEY `jenis_tgl_jam` (`tanggal`,`jam`,`jenis`),
  KEY `idx_datealat` (`date_alat`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;



# Dump of table transaksibis_dev
# ------------------------------------------------------------

DROP TABLE IF EXISTS `transaksibis_dev`;

CREATE TABLE `transaksibis_dev` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `nokartu` varchar(22) NOT NULL DEFAULT '',
  `notrx` varchar(20) DEFAULT NULL,
  `tanggal` date NOT NULL,
  `jam` time NOT NULL,
  `kredit` decimal(11,0) DEFAULT NULL,
  `normal_kredit` decimal(11,0) DEFAULT NULL,
  `saldo` decimal(11,0) DEFAULT NULL,
  `bis` varchar(8) NOT NULL DEFAULT '',
  `status` int DEFAULT NULL,
  `latitude` decimal(18,6) DEFAULT NULL,
  `longitude` decimal(18,6) DEFAULT NULL,
  `lokasi` varchar(80) DEFAULT NULL,
  `speed` int DEFAULT '0',
  `arah` int DEFAULT NULL,
  `jenis` varchar(20) DEFAULT NULL,
  `imei` varchar(15) DEFAULT NULL,
  `date_insert` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_alat` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_id` (`id`),
  UNIQUE KEY `byNoKartuTglJam` (`nokartu`,`tanggal`,`jam`,`arah`,`imei`),
  KEY `idx_jenis` (`jenis`),
  KEY `idx_tanggal` (`tanggal`),
  KEY `idx_jam` (`jam`),
  KEY `idx_bis` (`bis`),
  KEY `idx_jen_tgl` (`tanggal`,`jenis`),
  KEY `idx_arahbisjenis` (`bis`,`arah`,`jenis`),
  KEY `idx_trx` (`notrx`,`tanggal`,`jenis`),
  KEY `jenis_tgl_jam` (`tanggal`,`jam`,`jenis`),
  KEY `idx_datealat` (`date_alat`),
  KEY `idxsttl` (`notrx`,`tanggal`,`jenis`),
  KEY `notrxjenis` (`notrx`,`jenis`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;



# Dump of table transaksibis_tmp
# ------------------------------------------------------------

DROP TABLE IF EXISTS `transaksibis_tmp`;

CREATE TABLE `transaksibis_tmp` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `nokartu` varchar(22) NOT NULL DEFAULT '',
  `notrx` varchar(20) DEFAULT NULL,
  `tanggal` date NOT NULL,
  `jam` time NOT NULL,
  `kredit` decimal(11,0) DEFAULT NULL,
  `normal_kredit` decimal(11,0) DEFAULT NULL,
  `saldo` decimal(11,0) DEFAULT NULL,
  `bis` varchar(8) NOT NULL DEFAULT '',
  `status` int DEFAULT NULL,
  `latitude` decimal(18,6) DEFAULT NULL,
  `longitude` decimal(18,6) DEFAULT NULL,
  `lokasi` varchar(80) DEFAULT NULL,
  `speed` int DEFAULT NULL,
  `arah` int DEFAULT NULL,
  `jenis` varchar(20) DEFAULT NULL,
  `imei` varchar(15) DEFAULT NULL,
  `date_insert` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_alat` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_id` (`id`),
  UNIQUE KEY `byNoKartuTglJam` (`nokartu`,`tanggal`,`jam`,`arah`,`imei`),
  KEY `idx_jenis` (`jenis`),
  KEY `idx_tanggal` (`tanggal`),
  KEY `idx_jam` (`jam`),
  KEY `idx_bis` (`bis`),
  KEY `idx_jen_tgl` (`tanggal`,`jenis`),
  KEY `idx_arahbisjenis` (`bis`,`arah`,`jenis`),
  KEY `idx_trx` (`notrx`,`tanggal`,`jenis`),
  KEY `jenis_tgl_jam` (`tanggal`,`jam`,`jenis`),
  KEY `idx_datealat` (`date_alat`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;



# Dump of table transaksipos
# ------------------------------------------------------------

DROP TABLE IF EXISTS `transaksipos`;

CREATE TABLE `transaksipos` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `no_kartu` varchar(20) DEFAULT NULL,
  `jenis` varchar(20) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `jam` time DEFAULT NULL,
  `deposit` decimal(11,0) DEFAULT NULL,
  `saldo_sebelumnya` decimal(11,0) DEFAULT NULL,
  `lokasi` varchar(60) DEFAULT NULL,
  `idbus` varchar(10) DEFAULT NULL,
  `idpta` varchar(20) DEFAULT NULL,
  `flag` tinyint NOT NULL DEFAULT '0',
  `shift` tinyint(1) NOT NULL DEFAULT '0',
  `imei` varchar(16) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `transaksipos_unik` (`no_kartu`,`jam`,`tanggal`,`idpta`,`shift`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;



# Dump of table user
# ------------------------------------------------------------

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nik` varchar(10) DEFAULT NULL,
  `username` varchar(25) NOT NULL,
  `password` varchar(50) NOT NULL,
  `id_bus` varchar(8) DEFAULT NULL,
  `halte` varchar(50) DEFAULT NULL,
  `fullname` varchar(50) DEFAULT NULL,
  `idjab` varchar(2) NOT NULL DEFAULT '5',
  `t_login` datetime DEFAULT NULL,
  `t_logout` datetime DEFAULT NULL,
  `phone` varchar(32) DEFAULT NULL,
  `filename` text,
  `addr` text,
  `noktp` varchar(21) DEFAULT NULL,
  `updateip` varchar(30) DEFAULT NULL,
  `tmstamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updateby` varchar(20) DEFAULT NULL COMMENT 'pengelola, user',
  `is_promo` int DEFAULT '0',
  `token` text,
  `non_job` int DEFAULT '0',
  `jabtext` varchar(50) DEFAULT NULL,
  `cob` varchar(50) DEFAULT NULL COMMENT 'city of birth',
  `dob` date DEFAULT NULL COMMENT 'date of birth',
  `email` varchar(100) DEFAULT NULL,
  `cpid` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_bus` (`id_bus`),
  KEY `idx_t_login` (`t_login`),
  KEY `idx_t_logout` (`t_logout`),
  KEY `id_user` (`id`,`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table user_halte
# ------------------------------------------------------------

DROP TABLE IF EXISTS `user_halte`;

CREATE TABLE `user_halte` (
  `nama` varchar(255) DEFAULT NULL,
  `username` varchar(25) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `halte` varchar(100) DEFAULT NULL,
  `jab` varchar(255) DEFAULT NULL,
  `idjab` int DEFAULT NULL,
  `cob` varchar(255) DEFAULT NULL,
  `dob` varchar(255) DEFAULT NULL,
  `nik` varchar(255) DEFAULT NULL,
  `jeni` varchar(255) DEFAULT NULL,
  `addr` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table user_pramugara
# ------------------------------------------------------------

DROP TABLE IF EXISTS `user_pramugara`;

CREATE TABLE `user_pramugara` (
  `fullname` varchar(255) DEFAULT NULL,
  `jabtext` varchar(255) DEFAULT NULL,
  `cob` varchar(255) DEFAULT NULL,
  `dob` varchar(255) DEFAULT NULL,
  `dob2` date DEFAULT NULL,
  `noktp` bigint DEFAULT NULL,
  `addr` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `username` varchar(15) DEFAULT NULL,
  `cpid` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table user_pramugari
# ------------------------------------------------------------

DROP TABLE IF EXISTS `user_pramugari`;

CREATE TABLE `user_pramugari` (
  `fullname` varchar(255) DEFAULT NULL,
  `jabtext` varchar(255) DEFAULT NULL,
  `cob` varchar(255) DEFAULT NULL,
  `dob` varchar(255) DEFAULT NULL,
  `dob2` date DEFAULT NULL,
  `noktp` bigint DEFAULT NULL,
  `addr` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `username` varchar(15) DEFAULT NULL,
  `cpid` int NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table user_telegram
# ------------------------------------------------------------

DROP TABLE IF EXISTS `user_telegram`;

CREATE TABLE `user_telegram` (
  `id` int NOT NULL AUTO_INCREMENT,
  `chat_id` varchar(20) DEFAULT NULL,
  `date_insert` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `first_name` varchar(20) DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `last_name` varchar(20) DEFAULT NULL,
  `username` varchar(20) DEFAULT NULL,
  `verified` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;




--
-- Dumping routines (PROCEDURE) for database 'trans_tangerang'
--
DELIMITER ;;

# Dump of PROCEDURE insert_transaksi_query
# ------------------------------------------------------------

/*!50003 DROP PROCEDURE IF EXISTS `insert_transaksi_query` */;;
/*!50003 SET SESSION SQL_MODE="NO_AUTO_VALUE_ON_ZERO"*/;;
/*!50003 CREATE*/ /*!50020 DEFINER=`transjog`@`%`*/ /*!50003 PROCEDURE `insert_transaksi_query`()
BEGIN
    DECLARE i int DEFAULT 30;
    WHILE i <= 30 DO
				INSERT INTO `transaksibis` (`nokartu`, `notrx`, `tanggal`, `jam`, `kredit`, `normal_kredit`, `saldo`, `bis`, `status`, `latitude`, `longitude`, `lokasi`, `speed`, `arah`, `jenis`, `imei`, `date_insert`, `date_alat`)
VALUES
	(CONCAT('60329860879112',i), CONCAT('60329860879112',i), '2022-08-26', '11:56:58', 2700, 2700, 0, '10049', 0, 0.000000, 0.000000, '1', 0, 1467, 'E-Money Umum', '863907040081731', NULL, NULL);


    SET i = i + 1;
    END WHILE;
END */;;

/*!50003 SET SESSION SQL_MODE=@OLD_SQL_MODE */;;
# Dump of PROCEDURE sp_loadAllKmt
# ------------------------------------------------------------

/*!50003 DROP PROCEDURE IF EXISTS `sp_loadAllKmt` */;;
/*!50003 SET SESSION SQL_MODE="NO_AUTO_VALUE_ON_ZERO"*/;;
/*!50003 CREATE*/ /*!50020 DEFINER=`transjog`@`%`*/ /*!50003 PROCEDURE `sp_loadAllKmt`(dateStart varchar(255), dateEnd varchar(255))
BEGIN
	declare conditions varchar(255) default ''; 
	declare finalQuery varchar(16383) default '';
	
	if dateStart is not null then
		set conditions = concat('AND date(a.log_insert) BETWEEN "', dateStart, '" AND "', dateEnd ,'"');
	end if;
		
	SET @finalQuery = CONCAT("select a.c_trans, a.notrx, a.settle_raw_code, a.amount, CONCAT(b.tanggal, ' ',b.jam) as tanggal
								from sttl_kmt a 
								LEFT JOIN transaksibis b 
								ON a.notrx = b.notrx
									  AND a.idpta = b.arah
										WHERE b.jenis LIKE '%KMT%'
									", conditions ,"
									  ORDER BY b.tanggal, b.jam DESC
							"); 
	
		
 	PREPARE stmt FROM @finalQuery;
	EXECUTE stmt;
	DEALLOCATE PREPARE stmt;
END */;;

/*!50003 SET SESSION SQL_MODE=@OLD_SQL_MODE */;;
DELIMITER ;

--
-- Dumping routines (FUNCTION) for database 'trans_tangerang'
--
DELIMITER ;;

# Dump of FUNCTION CAP_FIRST
# ------------------------------------------------------------

/*!50003 DROP FUNCTION IF EXISTS `CAP_FIRST` */;;
/*!50003 SET SESSION SQL_MODE="NO_AUTO_VALUE_ON_ZERO"*/;;
/*!50003 CREATE*/ /*!50020 DEFINER=`transjog`@`%`*/ /*!50003 FUNCTION `CAP_FIRST`(input VARCHAR(255)) RETURNS varchar(255) CHARSET latin1
    DETERMINISTIC
BEGIN
        DECLARE len INT;
        DECLARE i INT;

        SET len   = CHAR_LENGTH(input);
        SET input = LOWER(input);
        SET i = 0;

        WHILE (i < len) DO
            IF (MID(input,i,1) = ' ' OR i = 0) THEN
                IF (i < len) THEN
                    SET input = CONCAT(
                        LEFT(input,i),
                        UPPER(MID(input,i + 1,1)),
                        RIGHT(input,len - i - 1)
                    );
                END IF;
            END IF;
            SET i = i + 1;
        END WHILE;

        RETURN input;
    END */;;

/*!50003 SET SESSION SQL_MODE=@OLD_SQL_MODE */;;
DELIMITER ;

/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
