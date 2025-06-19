/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

CREATE DATABASE IF NOT EXISTS `perpustakaan` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `perpustakaan`;

CREATE TABLE IF NOT EXISTS `jenis` (
  `id` char(36) NOT NULL,
  `nama` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `jenis` (`id`, `nama`) VALUES
	('3ae10485-c68f-4a38-8b68-c97389f4b423', 'Komik'),
	('3b6b631f-cefb-48b4-a983-beccba0750d4', 'Majalah'),
	('ba182dfd-c9df-4c3b-b0b2-741146e1fbc4', 'Novel'),
	('ec7bcb4b-040a-44d8-992e-ea7de509c68c', 'Buku');

CREATE TABLE IF NOT EXISTS `jurusan` (
  `id` char(36) NOT NULL,
  `nama` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `jurusan` (`id`, `nama`) VALUES
	('140ea2a1-7c61-4156-b01d-8fbe12d6881a', 'Biologi'),
	('297583ce-a739-4065-98ab-6a9897961062', 'Teknik Informatika'),
	('6072f083-b4f7-409b-8e70-aa7e39f6eb6e', 'Sistem Informasi'),
	('63f6fa8f-5bf8-4786-b117-c9c98cb3db90', 'Kimia');

CREATE TABLE IF NOT EXISTS `koleksi` (
  `id` char(36) NOT NULL,
  `penerbit_id` char(36) NOT NULL,
  `cover` varchar(255) DEFAULT NULL,
  `judul` text NOT NULL,
  `isbn` varchar(255) DEFAULT NULL,
  `jenis_id` char(36) NOT NULL,
  `pengarang` text NOT NULL,
  `stok` int NOT NULL DEFAULT '0',
  `nomor_rak` varchar(255) NOT NULL,
  `total_halaman` int NOT NULL,
  `tahun_terbit` year NOT NULL,
  `keterangan` text,
  `tanggal_entri` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `koleksi` (`id`, `penerbit_id`, `cover`, `judul`, `isbn`, `jenis_id`, `pengarang`, `stok`, `nomor_rak`, `total_halaman`, `tahun_terbit`, `keterangan`, `tanggal_entri`) VALUES
	('0ac6c983-187f-450a-8b6b-791b23dbd7d1', '56094068-fcf5-4583-a4f3-6fe4348291f2', 'unsplash_9dXSoi6VXEA.png', 'Mengembalikan data hilang', '9786230025006', 'ec7bcb4b-040a-44d8-992e-ea7de509c68c', 'Dedik Kurniawan & Java Creativity', 0, 'BKTK-01', 252, '2021', 'Buku ini tidak hanya membahas cara mengembalikan data yang hilang pada PC dan laptop, tetapi juga mencakup cara mengembalikan foto, video, mp3, kontak, sms, dan pesan Whatsapp yang pernah terhapus pada ponsel android. Sebagai tambahan, diajarkan pula cara membobol dan mengubah password Administrator pada Windows 7, 8, dan 10 yang kadang-kadang harus dilakukan ketika ingin menyelamatkan data dari hard disk atau memperbaiki Windows yang bermasalah.', '2021-08-24 19:07:09'),
	('11196f31-dd2c-4052-82e8-a4bbd0e90cd3', '56094068-fcf5-4583-a4f3-6fe4348291f2', '9786230027291.jpg', 'Dasar Logika Pemrograman Komputer (Update Version)', '9786230027291', 'ec7bcb4b-040a-44d8-992e-ea7de509c68c', 'Abdul Kadir', 0, 'BKTK-01', 432, '2021', 'Sejumlah perubahan telah dilakukan pada edisi revisi. Perangkat lunak yang digunakan telah disesuaikan dengan yang terbaru. Sejumlah tambahan materi pada beberapa bab telah dilakukan. Untuk memperkaya pengetahuan tentang dasar pemrograman komputer, ditambahkan pembahasan yang berisi sejumlah kasus yang dapat dijadikan sebagai latihan untuk menyelesaikan kasus-kasus tersebut.', '2021-08-27 03:37:34'),
	('1619a750-be10-4401-a16d-5b5f0be78204', '56094068-fcf5-4583-a4f3-6fe4348291f2', 'OIP.jpg', 'HTML Untuk Pemula', '9786230024320', 'ec7bcb4b-040a-44d8-992e-ea7de509c68c', 'Jubilee Enterprise', 0, 'BKTK-01', 304, '2021', 'Di dalam buku ini, kami akan mengajari cara membangun website memakai HTML5 dan Javascript secara efektif, singkat, tepat, dan jelas! Pembahasan akan dimulai dari cara menginstal editor gratis dari internet. Setelah itu, akan dibahas topik-topik spesifik, seperti struktur HTML, format teks, list dan background, hyperlink, style sheet, image, penulisan Javascript, pembuatan variable, objek angka dan math, bekerja dengan string, operator perbandingan, null dan undefined, konversi tipe data, object, function, dan framework Javascript Vue seperti data binding.', '2021-08-24 19:05:09'),
	('2397cd39-5f16-4b60-a586-98912790900a', '56094068-fcf5-4583-a4f3-6fe4348291f2', 'unsplash_aZ_MmSmAcjg.png', 'Buku Sakti Google Ads', '9786230023934', 'ec7bcb4b-040a-44d8-992e-ea7de509c68c', 'Su Rahman', 0, 'BKTK-01', 284, '2021', 'Buku ini membahas cara memasang iklan dan melakukan pemasaran dengan Google Ads. Pembahasannya disesuaikan untuk kebutuhan bisnis di Indonesia. Pembayaran Google Ads menggunakan bank transfer sehingga sangat cocok untuk kebutuhan bisnis di Indonesia.', '2021-08-27 03:20:30'),
	('298ae9e0-fdd9-4a4d-b307-3b80adcce225', '56094068-fcf5-4583-a4f3-6fe4348291f2', 'Google Meet.JPG', 'Paduan Google Meet dan Google Classroom', '9786230025938', 'ec7bcb4b-040a-44d8-992e-ea7de509c68c', 'Abdul Rohman', 0, 'BKTK-01', 196, '2021', 'itur lengkap yang dimiliki aplikasi Google Classroom dan Google Meet, kemudahan penggunaan, serta sifatnya yang gratis, membuat keduanya ideal menjadi pilihan para pendidik. Pembelajaran daring ini bisa menggantikan pembelajaran tatap muka yang biasa dilakukan di kelas.', '2021-08-27 03:40:24'),
	('c538a55d-480a-4fdd-b206-859a18044f1a', '56094068-fcf5-4583-a4f3-6fe4348291f2', 'unsplash_O7ygzpAL4Mc.png', 'Aplikasi Andriod Tanpa Coding', '9786230023927', 'ec7bcb4b-040a-44d8-992e-ea7de509c68c', 'Arista Prasetyo Adi', 0, 'BKTK-01', 224, '2021', 'Thunkable dipilih untuk membuat aplikasi di sini. Selain mudah karena hanya mengandalkan drag and drop, Thunkable hanya memerlukan web browser dan koneksi internet untuk membuat aplikasi Android. Thunkable mirip dengan MIT App Invertor, tetapi Thunkable lebih kompleks fiturnya dan dapat digunakan untuk menghasilkan aplikasi Android sekaligus iOS.', '2021-08-27 03:29:16'),
	('cb0e6dda-9717-4a1d-b10b-2637db4acae4', '56094068-fcf5-4583-a4f3-6fe4348291f2', 'Fungsi Formula Excel.JPG', 'Fungsi Formula Excel', '9786230022067', 'ec7bcb4b-040a-44d8-992e-ea7de509c68c', 'Jubilee Enterprise', 0, 'BKUM-01', 272, '2021', 'Buku ini mengupas tip dan trik yang paling lengkap, to-the point, dan mudah dipelajari untuk penggunaan fungsi dan formula MS Excel di Indonesia! Tentu saja, semua diuraikan dalam bahasa sederhana yang singkat dan ringkas. Buku ini dirancang tentu saja untuk Anda! Dalam buku ini, kami akan mengajari Anda menggunakan fungsi dan formula MS Excel sampai mahir.', '2021-08-27 03:34:49'),
	('d3091500-cce3-4983-8e41-97cf5feae270', '56094068-fcf5-4583-a4f3-6fe4348291f2', '9786230027123.jpg', 'Macro Excel untuk Pemula', '9786230027123', 'ec7bcb4b-040a-44d8-992e-ea7de509c68c', 'Yudhy Wicaksono & Solusi Kantor', 0, 'BKTK-01', 392, '2021', 'Belajar Sendiri VBA Macro Excel untuk Pemula ini membahas secara lengkap cara menggunakan VBA Macro secara optimal. Pembahasan diberikan secara sederhana, ringan, dan tidak bertele-tele sehingga sangat cocok digunakan oleh pengguna pemula yang ingin mempelajari dan menguasai VBA Macro Excel dalam waktu singkat. Setiap materi pembahasan disertai contoh kasus yang umum dijumpai sehari-hari sehingga Anda akan diajak langsung praktek, tidak hanya dalam batasan teori.', '2021-08-27 03:42:10'),
	('df2bbfc3-80b1-4b2f-9a77-0b01e76573e1', '56094068-fcf5-4583-a4f3-6fe4348291f2', 'unsplash_Gls5DB9lk6s.png', 'Paduan Coreldraw', '9786230021992', 'ec7bcb4b-040a-44d8-992e-ea7de509c68c', 'Arista Prasetyo Adi', 0, 'BKDS-01', 344, '2021', 'Panduan CorelDraw, Photoshop, dan Camtasia ini membahas langkah demi langkah dimulai dari awal hingga mahir, serta membahas tools atau teknik yang akan sering digunakan saja sehingga tidak terlalu panjang dan membosankan. Jadi, hanya dengan membaca dan mempraktekkan satu buku, Anda akan menguasai tiga aplikasi grafis dan multimedia sekaligus.', '2021-08-27 03:30:20'),
	('f94b1dc0-a816-46be-8776-e0b40568f0ac', '56094068-fcf5-4583-a4f3-6fe4348291f2', '', '10 Juta dari Youtube', '9786230022609', 'ec7bcb4b-040a-44d8-992e-ea7de509c68c', 'Jefferly Helianthusonfri', 10, 'BKUM-01', 204, '2021', '10 Juta Pertama dari YouTube akan memandu Anda memulai dan mengembangkan channel YouTube. Tak hanya itu, Anda juga bisa belajar seputar monetisasi dan menghasilkan income dari channel YouTube.', '2021-08-24 18:59:03');

CREATE TABLE IF NOT EXISTS `koleksi_pustaka` (
  `id` char(36) NOT NULL,
  `koleksi_id` char(36) NOT NULL,
  `konten` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


CREATE TABLE IF NOT EXISTS `koleksi_stok` (
  `id` varchar(36) NOT NULL,
  `koleksi_id` varchar(36) NOT NULL,
  `kode` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `koleksi_stok` (`id`, `koleksi_id`, `kode`) VALUES
	('03ead740-fa9f-44b1-88f5-ccbd61303fc9', 'f94b1dc0-a816-46be-8776-e0b40568f0ac', '10-0006'),
	('09d83713-876b-4c21-bb54-c99240b0df2b', 'cb0e6dda-9717-4a1d-b10b-2637db4acae4', 'FE-02'),
	('169ad6af-6157-4961-b7e2-5d801c22b571', '34e051c4-3b8f-401f-9ea2-10f39fbf458a', 'GM-02'),
	('1eabf529-7d4c-4593-b447-6683fa340042', '298ae9e0-fdd9-4a4d-b307-3b80adcce225', 'GM-03'),
	('2bd58f20-bbf3-444b-849f-7e490b93d884', 'd3091500-cce3-4983-8e41-97cf5feae270', 'ME-03'),
	('2e8f4e1a-9ce6-4cac-b01e-2797d98f699e', '871d3a10-35db-406c-a6f8-e3c7da5c78c2', 'GAD-02'),
	('302cdd7f-6edc-4aa4-9160-992e214445ce', 'cb0e6dda-9717-4a1d-b10b-2637db4acae4', 'FE-04'),
	('30f1d614-1a6e-49b4-9274-29bc5b92a25b', 'd3091500-cce3-4983-8e41-97cf5feae270', 'ME-02'),
	('34b572fd-02c5-474c-b35b-b6e82cf52a46', '11196f31-dd2c-4052-82e8-a4bbd0e90cd3', 'LPK-04'),
	('3b5b6c3f-9b53-40f4-8c9c-50f653015fe0', 'd3091500-cce3-4983-8e41-97cf5feae270', 'ME-01'),
	('409ba38f-78e7-4e70-9c37-cb50c84cdef4', 'f94b1dc0-a816-46be-8776-e0b40568f0ac', '10-0005'),
	('67f01b56-427f-4d0c-b890-1dab5029a050', '11196f31-dd2c-4052-82e8-a4bbd0e90cd3', 'LPK-03'),
	('702437f1-685f-427e-a023-76b8b24352de', 'f94b1dc0-a816-46be-8776-e0b40568f0ac', '10-0008'),
	('84de37b6-9570-489a-9240-c21bedaa2b0a', 'f94b1dc0-a816-46be-8776-e0b40568f0ac', '10-0004'),
	('86b7288e-ba82-45fb-b97c-a2a7b6a8d0f2', '34e051c4-3b8f-401f-9ea2-10f39fbf458a', 'GM-01'),
	('874d02aa-9f72-43a8-9e12-ef58099b5e35', 'f94b1dc0-a816-46be-8776-e0b40568f0ac', '10-0007'),
	('92e595d8-ca3b-4f77-87a0-269e80360c52', '298ae9e0-fdd9-4a4d-b307-3b80adcce225', 'GM-01'),
	('9c4faeb6-c2d5-4ede-9827-a35b9473f971', 'd3091500-cce3-4983-8e41-97cf5feae270', 'ME-04'),
	('a2cf0f0e-75e8-4930-bc0f-a5d9cfff2bf4', 'cb0e6dda-9717-4a1d-b10b-2637db4acae4', 'FE-01'),
	('a41cff45-5673-417c-88bd-e0babefcc3b0', 'f94b1dc0-a816-46be-8776-e0b40568f0ac', '10-0010'),
	('bf74edca-37b0-46d1-8083-55e75def8ff0', 'f94b1dc0-a816-46be-8776-e0b40568f0ac', '10-0009'),
	('c8e7ca1f-96d4-4507-962d-be20112be263', 'f94b1dc0-a816-46be-8776-e0b40568f0ac', '10-0003'),
	('cf67789e-8dbb-44ea-b822-cc18cf930f3a', 'cb0e6dda-9717-4a1d-b10b-2637db4acae4', 'FE-03'),
	('d6816070-4f08-4493-ae25-d58acd804de7', '11196f31-dd2c-4052-82e8-a4bbd0e90cd3', 'LPK-01'),
	('d71eb2a1-1cbc-4653-b033-367fa7086fb5', '871d3a10-35db-406c-a6f8-e3c7da5c78c2', 'GAD-01'),
	('df92e2fe-3ce7-4628-aab6-1dd2ab708b18', '298ae9e0-fdd9-4a4d-b307-3b80adcce225', 'GM-04'),
	('e379a3c2-339b-4cca-ae68-75f02cf0858e', '11196f31-dd2c-4052-82e8-a4bbd0e90cd3', 'LPK-02'),
	('e6eade99-b429-4894-8bfc-8c7bd5bea9d1', '34e051c4-3b8f-401f-9ea2-10f39fbf458a', 'GM-03'),
	('f585b361-be49-4d76-86fc-030edba4f500', 'f94b1dc0-a816-46be-8776-e0b40568f0ac', '10-0002'),
	('f7b4ce91-1cbe-43ca-ba6c-ae7b541b25d7', 'f94b1dc0-a816-46be-8776-e0b40568f0ac', '10-0001'),
	('fa946088-5079-4dbe-a42a-c8ffde3bc7c2', '298ae9e0-fdd9-4a4d-b307-3b80adcce225', 'GM-02');

CREATE TABLE IF NOT EXISTS `kritik_saran` (
  `id` char(36) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `pesan` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `kritik_saran` (`id`, `nama`, `email`, `pesan`) VALUES
	('c36c49a0-612c-49ba-a9b6-619d436dfc17', 'faruq', 'faruq@gmail.com', 'mungkin untuk alertnya bisa pake sweet alert biar lebih bagus');

CREATE TABLE IF NOT EXISTS `peminjaman` (
  `id` char(36) NOT NULL,
  `user_id` char(36) NOT NULL,
  `kode` varchar(255) NOT NULL,
  `jatuh_tempo` date DEFAULT NULL,
  `tanggal_pinjam` date NOT NULL,
  `perpanjangan` int DEFAULT NULL,
  `tanggal_kembali` date DEFAULT NULL,
  `status` enum('pengajuan','ditolak','dipinjam','selesai') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `peminjaman` (`id`, `user_id`, `kode`, `jatuh_tempo`, `tanggal_pinjam`, `perpanjangan`, `tanggal_kembali`, `status`) VALUES
	('02680a49-5715-4a02-ad50-e110858114af', '99eebc32-bc79-4754-9949-92b9ca992225', '250821020716', '2021-08-25', '2021-08-25', 0, '2021-08-27', 'selesai'),
	('026edb4b-3a3e-4bbb-ba86-68161f2ecd88', 'b3481d84-ced4-4968-ad30-7d2872a42b52', '190625202137', '2025-06-28', '2025-06-19', 3, '2025-06-19', 'selesai'),
	('41d8c514-ab24-47d7-9db8-32612e2736e1', 'b3481d84-ced4-4968-ad30-7d2872a42b52', '190625211140', '2025-06-30', '2025-06-19', 5, NULL, 'dipinjam'),
	('526cd65a-03ec-4cc6-a035-efa818bc31d9', '216bed44-55e5-4808-aae8-33c2dc836de2', '250821021808', '2021-08-28', '2021-08-25', NULL, NULL, 'pengajuan'),
	('619e955a-9c6c-4708-a038-de5f30c58f5c', 'f22d8782-86ac-419e-a647-30bcb3e8edc8', '250821021228', '2021-08-28', '2021-08-25', 0, NULL, 'dipinjam'),
	('7ce55a75-f635-4fdc-94df-f5b3ed48f45c', '35e6a358-fa7d-4af5-ab73-4d864cf3d7ec', '270821123000', '2021-08-30', '2021-08-27', NULL, NULL, 'pengajuan'),
	('a1a61518-301f-4625-aa72-822d7a9c0600', '43ea645d-5812-4f84-bf67-bbcf27cfb01e', '260821132848', '2021-08-29', '2021-08-26', 0, NULL, 'dipinjam'),
	('a5c58d2b-4ac7-4eaa-a2f3-6caa618ef3e6', 'b3481d84-ced4-4968-ad30-7d2872a42b52', '190625202129', '2025-06-22', '2025-06-19', 0, '2025-06-19', 'selesai'),
	('beb67c7b-b6b6-427f-82c8-5ec8b74e1d64', '216bed44-55e5-4808-aae8-33c2dc836de2', '250821021801', '2021-08-28', '2021-08-25', NULL, NULL, 'pengajuan'),
	('e03634b0-55ea-4dcb-90c1-97d593c72aee', '35e6a358-fa7d-4af5-ab73-4d864cf3d7ec', '270821123056', '2021-08-30', '2021-08-27', NULL, NULL, 'pengajuan'),
	('e36b581a-33d0-408f-8c8b-b7d28b319d84', '99eebc32-bc79-4754-9949-92b9ca992225', '250821020616', '2021-08-28', '2021-08-25', 0, NULL, 'dipinjam'),
	('e6c81e63-171e-482c-929e-9474ce0f244d', '99eebc32-bc79-4754-9949-92b9ca992225', '250821020301', '2021-08-28', '2021-08-25', 1, NULL, 'dipinjam');

CREATE TABLE IF NOT EXISTS `peminjaman_detail` (
  `id` char(36) NOT NULL,
  `peminjaman_id` char(36) NOT NULL,
  `koleksi_stok_kode` varchar(255) NOT NULL,
  `denda_terlambat` double NOT NULL DEFAULT '0',
  `denda_lainnya` double NOT NULL DEFAULT '0',
  `status` enum('tolak','pinjam','hilang','rusak','lengkap') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `peminjaman_detail` (`id`, `peminjaman_id`, `koleksi_stok_kode`, `denda_terlambat`, `denda_lainnya`, `status`) VALUES
	('2dfb0643-d121-4df6-a6f8-7530170928ac', '41d8c514-ab24-47d7-9db8-32612e2736e1', 'ME-03', 0, 0, 'pinjam'),
	('31dd247a-9726-44ec-a93d-573b54927aed', '7ce55a75-f635-4fdc-94df-f5b3ed48f45c', 'GM-03', 0, 0, 'pinjam'),
	('34518e2a-7807-4ef0-a3d0-6f65d4228694', '41d8c514-ab24-47d7-9db8-32612e2736e1', 'GM-01', 0, 0, 'pinjam'),
	('36dc43a1-9304-43db-a97d-5f44b945831d', '41d8c514-ab24-47d7-9db8-32612e2736e1', '10-0008', 0, 0, 'pinjam'),
	('506cef8c-8641-40b0-a478-ac2e89abc00c', 'a5c58d2b-4ac7-4eaa-a2f3-6caa618ef3e6', '10-0006', 0, 0, 'lengkap'),
	('55f4a070-fb42-451c-93ef-6dd0253f3ee5', 'e6c81e63-171e-482c-929e-9474ce0f244d', 'YTB-02', 0, 0, 'pinjam'),
	('66e95a1c-80a0-4c4f-bccf-8241fd24b3a2', '526cd65a-03ec-4cc6-a035-efa818bc31d9', '', 0, 0, 'pinjam'),
	('6ea697b0-62f8-4478-9d2d-1fcc77615302', '026edb4b-3a3e-4bbb-ba86-68161f2ecd88', '10-0005', 0, 0, 'lengkap'),
	('7606e5c6-a38e-40a2-b533-c1f7124ad966', '526cd65a-03ec-4cc6-a035-efa818bc31d9', '', 0, 0, 'pinjam'),
	('7709215b-a39e-4b53-b5c6-4a2122f94ebb', '619e955a-9c6c-4708-a038-de5f30c58f5c', 'GAD-02', 0, 0, 'pinjam'),
	('8a4b1154-3359-465a-8fde-3885b8640104', 'e36b581a-33d0-408f-8c8b-b7d28b319d84', 'HTM-01', 0, 0, 'pinjam'),
	('8a9eb631-b441-4299-bbe0-a14212f91926', '41d8c514-ab24-47d7-9db8-32612e2736e1', 'FE-02', 0, 0, 'pinjam'),
	('96b56f29-8be0-4936-8dda-97024802b3ef', 'beb67c7b-b6b6-427f-82c8-5ec8b74e1d64', 'DTH-02', 0, 0, 'pinjam'),
	('a2558501-1f59-4f0f-b23b-070b461e8a6e', 'e03634b0-55ea-4dcb-90c1-97d593c72aee', 'CR-01', 0, 0, 'pinjam'),
	('a8cfc74f-f5d4-438b-9285-4f75701dbfea', '41d8c514-ab24-47d7-9db8-32612e2736e1', 'LPK-04', 0, 0, 'pinjam'),
	('aaa9e3a0-a30f-4756-83f5-3a66facd6027', '619e955a-9c6c-4708-a038-de5f30c58f5c', 'HTM-02', 0, 0, 'pinjam'),
	('af4409f8-da48-4da5-9d90-4aced3b890e8', 'e36b581a-33d0-408f-8c8b-b7d28b319d84', 'GAD-01', 0, 0, 'pinjam'),
	('cc121510-2948-4869-b587-9b1c7f0e417a', '7ce55a75-f635-4fdc-94df-f5b3ed48f45c', 'YT-04', 0, 0, 'pinjam'),
	('cce6ff01-9dc5-4944-885b-85d56e5e2db4', 'a1a61518-301f-4625-aa72-822d7a9c0600', 'GM-02', 0, 0, 'pinjam'),
	('cf0a5be8-2ecd-42de-b6a5-444258e07e13', '02680a49-5715-4a02-ad50-e110858114af', 'DTH-01', 10000, 0, 'lengkap'),
	('d164d6a2-14ee-48c9-b0b8-fb26ac85f678', '619e955a-9c6c-4708-a038-de5f30c58f5c', 'YTB-01', 0, 0, 'pinjam'),
	('e83a525b-083f-4662-b569-37db7a600278', 'e03634b0-55ea-4dcb-90c1-97d593c72aee', 'ATC-02', 0, 0, 'pinjam');

CREATE TABLE IF NOT EXISTS `penerbit` (
  `id` char(36) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `telepon` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `alamat` text,
  `website` varchar(255) DEFAULT NULL,
  `tanggal_entri` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `penerbit` (`id`, `nama`, `telepon`, `email`, `alamat`, `website`, `tanggal_entri`) VALUES
	('56094068-fcf5-4583-a4f3-6fe4348291f2', 'Elex Media Komputindo', '02153650110', 'redaksi@elex.media', 'Jl. Palang Merah No 27 - 37 Jakarta Pusat', 'https://elexmedia.id/', '2021-08-27 03:04:22'),
	('7138337e-6d8e-49ab-ab3f-ad55ea53c7ff', 'Andi Publisher', '027456188144', 'naskahbukuandi@gmail.com', 'Jl. Beo 38-40, Demangan, Yogyakarta', 'http://www.andipublisher.com/', '2021-08-27 03:04:59'),
	('80f21c51-d808-4482-bd41-8c31d03c526a', 'Gramedia Pustaka Utama', '02153650110', 'fiksi@gramediapublisher.com', 'Jl. Palmerah Barat No. 29 â€“ 37 Jakarta Pusat', 'http://www.gpu.id/', '2021-08-24 18:57:23'),
	('a7e17721-bb4d-483b-b917-2e80265a0e9a', 'Gramedia Widiasarana Indonesia (Grasindo)', '021871700656', 'red.grasindo@gramediapublishers.com', 'Jl. Pinguin Renang 18 Jakarta Pusat', 'http://www.grasindo.id/', '2021-08-27 03:03:47');

CREATE TABLE IF NOT EXISTS `user` (
  `id` char(36) NOT NULL,
  `jurusan_id` char(36) DEFAULT NULL,
  `role` enum('admin','dosen','mahasiswa') NOT NULL,
  `nama` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `telepon` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `alamat` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `user` (`id`, `jurusan_id`, `role`, `nama`, `email`, `telepon`, `password`, `alamat`) VALUES
	('2b8b9730-1ffb-456e-bccc-f05a2907f4e8', '2b17f179-5676-4938-98b7-de763a22c61f', 'admin', 'Rigen', 'rigen@gmail.com', '082234131242', '$2y$10$9tiyIYoDhVJpB6gvqdyKOelaXy4OQTqdZXyVw9GFYKLJj3Qe.oEcC', 'UIN MAULANA MALIK IBRAHIM MALANG'),
	('b3481d84-ced4-4968-ad30-7d2872a42b52', '297583ce-a739-4065-98ab-6a9897961062', 'mahasiswa', 'faruq', 'faruq@gmail.com', '082234131242', '$2y$10$98cyfbnve565M/cI/9AcHu.nWEX0vi3vPDtayzMMu5IqW66a/5E3u', 'Sukoanyar Jl. Campurdarat Tulungagung');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
