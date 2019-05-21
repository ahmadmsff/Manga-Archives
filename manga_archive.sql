-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 21 Bulan Mei 2019 pada 14.43
-- Versi server: 10.3.14-MariaDB
-- Versi PHP: 7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `id9666291_manga`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `author`
--

CREATE TABLE `author` (
  `id_author` int(11) NOT NULL,
  `id_manga` int(11) NOT NULL,
  `id_author_detail` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `author_detail`
--

CREATE TABLE `author_detail` (
  `id_author_detail` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `job` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `chapter`
--

CREATE TABLE `chapter` (
  `id_chapter` int(11) NOT NULL,
  `id_manga` int(11) NOT NULL,
  `chapter` float NOT NULL,
  `release_date` datetime NOT NULL,
  `source` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `genre`
--

CREATE TABLE `genre` (
  `id_genre` int(11) NOT NULL,
  `id_manga` int(11) NOT NULL,
  `id_genre_detail` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `genre_detail`
--

CREATE TABLE `genre_detail` (
  `id_genre_detail` int(11) NOT NULL,
  `name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `genre_detail`
--

INSERT INTO `genre_detail` (`id_genre_detail`, `name`) VALUES
(1, 'Action'),
(2, 'Adventure'),
(3, 'Cars'),
(4, 'Comedy'),
(5, 'Dementia'),
(6, 'Demons'),
(7, 'Doujinshi'),
(8, 'Drama'),
(9, 'Ecchi'),
(10, 'Fantasy'),
(11, 'Game'),
(12, 'Gender Bender'),
(13, 'Harem'),
(14, 'Hentai'),
(15, 'Historical'),
(16, 'Horror'),
(17, 'Josei'),
(18, 'Kids'),
(19, 'Magic'),
(20, 'Martial Arts'),
(21, 'Mature'),
(22, 'Mecha'),
(23, 'Military'),
(24, 'Music'),
(25, 'Mystery'),
(26, 'Parody'),
(27, 'Police'),
(28, 'Psychological'),
(29, 'Romance'),
(30, 'Samurai'),
(31, 'School'),
(32, 'Sci-Fi'),
(33, 'Seinen'),
(34, 'Shoujo'),
(35, 'Shoujo Ai'),
(36, 'Shounen'),
(37, 'Shounen Ai'),
(38, 'Slice of Life'),
(39, 'Space'),
(40, 'Sports'),
(41, 'Super Power'),
(42, 'Supernatural'),
(43, 'Thriller'),
(44, 'Vampire'),
(45, 'Yaoi'),
(46, 'Yuri'),
(47, 'Isekai'),
(49, 'School Life'),
(50, 'Webtoons');

-- --------------------------------------------------------

--
-- Struktur dari tabel `manga`
--

CREATE TABLE `manga` (
  `id_manga` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `source` varchar(255) NOT NULL,
  `type` enum('manga','manhua','manhwa','') NOT NULL,
  `status` enum('airing','complete','','') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `manga_detail`
--

CREATE TABLE `manga_detail` (
  `id_manga_detail` int(11) NOT NULL,
  `id_manga` int(11) NOT NULL,
  `release_date` date DEFAULT NULL,
  `native_title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `views` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `email` varchar(64) NOT NULL,
  `password` varchar(64) NOT NULL,
  `name` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id_user`, `email`, `password`, `name`) VALUES
(1, 'admin@admin.com', '21232f297a57a5a743894a0e4a801fc3', 'Admin');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_history`
--

CREATE TABLE `user_history` (
  `id_user_history` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_manga` int(11) NOT NULL,
  `chapter` float NOT NULL,
  `read_date` date NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `author`
--
ALTER TABLE `author`
  ADD PRIMARY KEY (`id_author`),
  ADD KEY `id_manga` (`id_manga`,`id_author_detail`),
  ADD KEY `id_author_detail` (`id_author_detail`);

--
-- Indeks untuk tabel `author_detail`
--
ALTER TABLE `author_detail`
  ADD PRIMARY KEY (`id_author_detail`);

--
-- Indeks untuk tabel `chapter`
--
ALTER TABLE `chapter`
  ADD PRIMARY KEY (`id_chapter`),
  ADD KEY `id_manga` (`id_manga`);

--
-- Indeks untuk tabel `genre`
--
ALTER TABLE `genre`
  ADD PRIMARY KEY (`id_genre`),
  ADD KEY `id_manga` (`id_manga`,`id_genre_detail`),
  ADD KEY `id_genre_detail` (`id_genre_detail`);

--
-- Indeks untuk tabel `genre_detail`
--
ALTER TABLE `genre_detail`
  ADD PRIMARY KEY (`id_genre_detail`);

--
-- Indeks untuk tabel `manga`
--
ALTER TABLE `manga`
  ADD PRIMARY KEY (`id_manga`);

--
-- Indeks untuk tabel `manga_detail`
--
ALTER TABLE `manga_detail`
  ADD PRIMARY KEY (`id_manga_detail`),
  ADD KEY `id_manga` (`id_manga`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- Indeks untuk tabel `user_history`
--
ALTER TABLE `user_history`
  ADD PRIMARY KEY (`id_user_history`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_manga` (`id_manga`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `author`
--
ALTER TABLE `author`
  MODIFY `id_author` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=373;

--
-- AUTO_INCREMENT untuk tabel `author_detail`
--
ALTER TABLE `author_detail`
  MODIFY `id_author_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=368;

--
-- AUTO_INCREMENT untuk tabel `chapter`
--
ALTER TABLE `chapter`
  MODIFY `id_chapter` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6361;

--
-- AUTO_INCREMENT untuk tabel `genre`
--
ALTER TABLE `genre`
  MODIFY `id_genre` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1167;

--
-- AUTO_INCREMENT untuk tabel `genre_detail`
--
ALTER TABLE `genre_detail`
  MODIFY `id_genre_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT untuk tabel `manga`
--
ALTER TABLE `manga`
  MODIFY `id_manga` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=232;

--
-- AUTO_INCREMENT untuk tabel `manga_detail`
--
ALTER TABLE `manga_detail`
  MODIFY `id_manga_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=232;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `user_history`
--
ALTER TABLE `user_history`
  MODIFY `id_user_history` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=323;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `author`
--
ALTER TABLE `author`
  ADD CONSTRAINT `author_ibfk_1` FOREIGN KEY (`id_author_detail`) REFERENCES `author_detail` (`id_author_detail`),
  ADD CONSTRAINT `author_ibfk_2` FOREIGN KEY (`id_manga`) REFERENCES `manga` (`id_manga`);

--
-- Ketidakleluasaan untuk tabel `chapter`
--
ALTER TABLE `chapter`
  ADD CONSTRAINT `chapter_ibfk_1` FOREIGN KEY (`id_manga`) REFERENCES `manga` (`id_manga`);

--
-- Ketidakleluasaan untuk tabel `genre`
--
ALTER TABLE `genre`
  ADD CONSTRAINT `genre_ibfk_1` FOREIGN KEY (`id_genre_detail`) REFERENCES `genre_detail` (`id_genre_detail`),
  ADD CONSTRAINT `genre_ibfk_2` FOREIGN KEY (`id_manga`) REFERENCES `manga` (`id_manga`);

--
-- Ketidakleluasaan untuk tabel `manga_detail`
--
ALTER TABLE `manga_detail`
  ADD CONSTRAINT `manga_detail_ibfk_1` FOREIGN KEY (`id_manga`) REFERENCES `manga` (`id_manga`);

--
-- Ketidakleluasaan untuk tabel `user_history`
--
ALTER TABLE `user_history`
  ADD CONSTRAINT `user_history_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`),
  ADD CONSTRAINT `user_history_ibfk_2` FOREIGN KEY (`id_manga`) REFERENCES `manga` (`id_manga`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
