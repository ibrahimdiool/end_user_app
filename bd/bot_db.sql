-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : lun. 19 sep. 2022 à 13:09
-- Version du serveur : 10.4.24-MariaDB
-- Version de PHP : 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `bot_db`
--

-- --------------------------------------------------------

--
-- Structure de la table `encour`
--

CREATE TABLE `encour` (
  `id` int(11) NOT NULL,
  `chatId` bigint(20) NOT NULL,
  `servicee` int(11) NOT NULL DEFAULT 0,
  `methode` int(11) NOT NULL DEFAULT 0,
  `phone` int(11) NOT NULL DEFAULT 0,
  `action` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `encour`
--

INSERT INTO `encour` (`id`, `chatId`, `servicee`, `methode`, `phone`, `action`) VALUES
(1, 963258741, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `favorite`
--

CREATE TABLE `favorite` (
  `id` int(11) NOT NULL,
  `marchand` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `chatUser` bigint(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `marchand`
--

CREATE TABLE `marchand` (
  `id` int(11) NOT NULL,
  `token` varchar(254) NOT NULL,
  `tokenAll` varchar(5000) NOT NULL,
  `chatId` bigint(20) NOT NULL,
  `marchandCode` int(11) NOT NULL,
  `mail` varchar(100) NOT NULL,
  `otpMail` int(11) NOT NULL DEFAULT 0,
  `passe` varchar(2000) DEFAULT NULL,
  `passe1` varchar(2000) DEFAULT NULL,
  `phone` bigint(20) NOT NULL DEFAULT 0,
  `bename` varchar(100) NOT NULL,
  `statut` varchar(50) NOT NULL DEFAULT 'not verify',
  `average` float NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `marchand`
--

INSERT INTO `marchand` (`id`, `token`, `tokenAll`, `chatId`, `marchandCode`, `mail`, `otpMail`, `passe`, `passe1`, `phone`, `bename`, `statut`, `average`) VALUES
(1, 'assjfu5d8vkfofr7vkds4vkgf4d;f4d4gf,v8', '', 1000000054, 852146, 'nonomoyenn@gmail.com', 0, NULL, NULL, 0, 'no name', 'not verify', 0),
(2, 'api_live.4UDet5+nRsTRfFM1KcLjsIZ/SqPruNUZURZqrveR/TdGyzIrUfAvyetjkgMh9DZt', 'eyJhbGciOiJSUzI1NiIsInR5cCI6IkpXVCIsImtpZCI6IlFrSTVPVUV5UkRNMU5ETTNSalZFUlVWRlJUTXpNRE16TjBFeE5rUTBNekZEUkRRek1qQkJOQSJ9.eyJodHRwOi8vand0LmRpb29sLmNvbS91c2VybmFtZSI6Im5vbm9tb3llbm5fZ21haWxfY29tIiwiaHR0cDovL2p3dC5kaW9vbC5jb20vdXNlcl9pZCI6ImF1dGgwfDYyY2ZlMWE1ZmNkYTIwNjBhOGVlNDExMCIsImh0dHA6Ly9qd3QuZGlvb2wuY29tL3Byb2ZpbCI6InByaW1hcnlfb3duZXIiLCJodHRwOi8vand0LmRpb29sLmNvbS9lbWFpbCI6Im5vbm9tb3llbm5AZ21haWwuY29tIiwiaHR0cDovL2p3dC5kaW9vbC5jb20vZW1haWxfdmVyaWZpZWQiOnRydWUsImh0dHA6Ly9qd3QuZGlvb2wuY29tL3JvbGVzIjpbInNjcmVlbjpkYXNoYm9hcmQiLCJ2aWV3OmFjdGl2ZWFnZW50cyIsImVkaXQ6YWRkTmV3U2hvcCIsInNjcmVlbjpwYXltZW50dGVybWluYWwiLCJlZGl0OnBheW1lbnQiLCJzY3JlZW46aGlzdG9yeSIsInNjcmVlbjp0cmFuc2FjdGlvbnMiLCJ2aWV3OnBvVHJhbnNhY3Rpb25IaXN0b3J5Iiwidmlldzp0cmFuc2FjdGlvbkhpc3RvcnkiLCJleHBvcnQ6cG9UcmFuc2FjdGlvbkhpc3RvcnkiLCJleHBvcnQ6dHJhbnNhY3Rpb25IaXN0b3J5Iiwic2NyZWVuOmxlZGdlciIsInZpZXc6TGVkZ2VyIiwic2NyZWVuOmFkZHJlc3Nib29rIiwidmlldzpnZXRBZGRyZXNzQm9vayIsImVkaXQ6YWRkTmV3Q29udGFjdCIsInZpZXc6Y2hlY2tEaW9vbEFjY291bnQiLCJlZGl0Om1vZGlmeUNvbnRhY3QiLCJlZGl0OmRlbGV0ZUNvbnRhY3QiLCJlZGl0OmFkZHJlc3NCb29rVHJhbnNmZXIiLCJzY3JlZW46Y293b3JrZXJzIiwidmlldzpzZWVDb3dvcmtlcnNMaXN0IiwiZWRpdDpkaW9vbF90cmFuc2ZlciIsInZpZXc6dXNlcklkQnlFbWFpbCIsInNjcmVlbjpzZXR0aW5ncyIsInNjcmVlbjphZ2VudHMiLCJ2aWV3OnNlZUNvd29ya2Vyc0xpc3QiLCJlZGl0OmFzc2lnblNob3BUb0FnZW50IiwiZWRpdDpkZWFzc2lnblNob3BUb0FnZW50IiwiZWRpdDppbnZpdGVOZXdBZ2VudCIsImVkaXQ6Y2FuY2VsTmV3QWdlbnRJbnZpdGUiLCJ2aWV3OmNoaWxkcmVuRmVlc1JldmVudWVEaXN0cmlidXRpb24iLCJlZGl0OnVwZGF0ZUFnZW50c1JldmVudWVNYXJnaW4iLCJlZGl0OmJsb2NrVW5ibG9ja0FnZW50IiwiZWRpdDpyZXNldFBhc3N3b3JkIiwiZWRpdDpyZXNldFZlcmlmaWNhdGlvbkVtYWlsIiwic2NyZWVuOnRlYW0iLCJ2aWV3OnNlZUFsbFRlYW1tYXRlcyIsImVkaXQ6aW52aXRlTmV3VXNlciIsImVkaXQ6YmxvY2tVbmJsb2NrVXNlciIsImVkaXQ6Y2FuY2VsTmV3VXNlckludml0ZSIsInNjcmVlbjphY2NvdW50cyIsInZpZXc6YmFsYW5jZSIsImVkaXQ6YWRkRnVuZHMiLCJlZGl0OndpdGhkcmF3RnVuZHMiLCJlZGl0OnJlZGVlbSIsImVkaXQ6d2l0aGRyYXdSZXZlbnVlIiwiZWRpdDpwYXlSZXZlbnVlRGViaXQiLCJzY3JlZW46c2V0dGluZ3MiLCJzY3JlZW46cGF5bWVudE1ldGhvZHMiLCJ2aWV3OnBheW1lbnRNZXRob2RzIiwiZWRpdDphZGRFeHRlcm5hbERlZmF1bHRBY2NvdW50IiwiZWRpdDpzZXREZWZhdWx0QWNjb3VudCIsImVkaXQ6YXJjaGl2ZUV4dGVybmFsRGVmYXVsdEFjY291bnQiLCJzY3JlZW46c2V0dGluZ3MiLCJzY3JlZW46c2hvcHMiLCJ2aWV3OnNlZUFsbFNob3BMaXN0IiwiZWRpdDphZGROZXdTaG9wIiwiZWRpdDp1cGRhdGVTaG9wIiwiZWRpdDphcmNoaXZlU2hvcCIsImVkaXQ6cmVhY3RpdmF0ZUFyY2hpdmVkU2hvcCIsInNjcmVlbjpzZXR0aW5ncyIsInNjcmVlbjpwcm9maWxlIiwidmlldzpwZXJzb25hbEluZm8iLCJ2aWV3OmJ1c2luZXNzRW50aXR5SW5mbyIsImVkaXQ6Y2hhbmdlUGFzc3dvcmQiLCJlZGl0OmNoYW5nZUVtYWlsIiwiZWRpdDpjaGFuZ2VVc2VyUGljdHVyZSIsImVkaXQ6dXBkYXRlVXNlckluZm8iLCJ2aWV3OnVzZXJJbmZvQnlVc2VySWQiLCJ2aWV3OmVtYWlscyIsImVkaXQ6dXBsb2FkQnVzaW5lc3NEb2MiLCJ2aWV3OmNoZWNrQnVzaW5lc3NEb2NzIiwiZWRpdDp1cGxvYWRGaWxlIiwiZWRpdDp1cGxvYWRGaWxlcyIsImVkaXQ6ZGVsZXRlRmlsZSIsImVkaXQ6ZGVsZXRlQnVzaW5lc3NEb2MiLCJ2aWV3OmRvd25sb2FkRmlsZSIsImVkaXQ6dHJhbnNmZXJLWUNmb3JtIiwidmlldzpzZWVBbGxBcGlTYW5kYm94VG9rZW5zIiwic2NyZWVuOnRva2VuQXBpIiwiZWRpdDpjcmVhdGVTYW5kYm94QVBJVG9rZW5zIiwidmlldzpzZWVBbGxBcGlTYW5kYm94VG9rZW5zIiwiZWRpdDpyZXZva2VTYW5kYm94QVBJVG9rZW5zIiwiZWRpdDphc3NpZ25TaG9wVG9BZ2VudCIsInZpZXc6c2VlQWxsQXBpVG9rZW5zIiwiZWRpdDpjcmVhdGVMaXZlQVBJVG9rZW5zIiwiZWRpdDpyZXZva2VMaXZlQVBJVG9rZW5zIl0sImh0dHA6Ly9qd3QuZGlvb2wuY29tL2lzTTJNVG9rZW4iOmZhbHNlLCJodHRwOi8vand0LmRpb29sLmNvbS9lbnZpcm9ubWVudCI6IiIsImh0dHA6Ly9qd3QuZGlvb2wuY29tL3BhcmVudElkIjpudWxsLCJodHRwOi8vand0LmRpb29sLmNvbS9pc0RlbW9Vc2VyIjpmYWxzZSwiaXNzIjoiaHR0cHM6Ly9hdXRoLmRpb29sLmNvbS8iLCJzdWIiOiJhdXRoMHw2MmNmZTFhNWZjZGEyMDYwYThlZTQxMTAiLCJhdWQiOlsiaHR0cHM6Ly8xMjcuMC4wLjE6ODA4MC9kaW9vbC9hcGkvdjEiLCJodHRwczovL215bW9uZXltb2JpbGUuZXUuYXV0aDAuY29tL3VzZXJpbmZvIl0sImlhdCI6MTY2MjQ3OTQwNiwiZXhwIjoxNjY1MDcxNDA2LCJhenAiOiJrcW1ORUk3Q0JEOXVBUlQyZXBabGVTMXZBNjRIbGQxTyIsInNjb3BlIjoib3BlbmlkIHByb2ZpbGUgZW1haWwiLCJwZXJtaXNzaW9ucyI6W119.auwv5SXyveWmBQBRI1-lpVjKt7X7JFN7_LYzHn4XafuAbOCLGwZb6XkMbRBEiKgeStBX8fAoSWrGxUsH5f21SprU8AkzgtvHF518N94R_AIrlGPffOP0zHvwCOhps5pDvTDbanfjr5KCGJQZ6VbgdZYx5hce6ZaQuDzpBqAtOiQWo0-81NI0EdsCnUnCPedJITAauSJELeG8oNhgHF3G48C9cakmzAFQGFErRSFoQEvzQGJAv2MqwfEH6TVtzq17kYJkiY1VY6YxezW3-5qykk9eY2e1g0nFPrUoitsNfUsTTyhlny3XdgBRciEdbMrZrHLUcoBOfs0KtzDIsvLlBg', 2029198256, 852, 'nonomoyenn@gmail.com', 0, NULL, NULL, 0, 'Ibrahim Group inc', 'verify', 0);

-- --------------------------------------------------------

--
-- Structure de la table `transaction`
--

CREATE TABLE `transaction` (
  `id` int(11) NOT NULL,
  `servicee` int(11) NOT NULL,
  `refInterne` varchar(100) NOT NULL,
  `refExterne` varchar(100) NOT NULL,
  `phone` int(11) NOT NULL,
  `amount` int(11) NOT NULL DEFAULT 0,
  `datee` int(11) NOT NULL,
  `chatId` bigint(11) NOT NULL,
  `marchand` int(11) NOT NULL,
  `methode` int(11) NOT NULL DEFAULT 0,
  `reference` varchar(100) DEFAULT NULL,
  `statut` int(11) NOT NULL DEFAULT 100,
  `noteApp` int(11) NOT NULL DEFAULT 10,
  `favorite` int(11) NOT NULL DEFAULT 0,
  `avisApp` varchar(200) DEFAULT NULL,
  `noteMarchand` int(11) NOT NULL DEFAULT 10,
  `avisMarchand` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `transaction`
--

INSERT INTO `transaction` (`id`, `servicee`, `refInterne`, `refExterne`, `phone`, `amount`, `datee`, `chatId`, `marchand`, `methode`, `reference`, `statut`, `noteApp`, `favorite`, `avisApp`, `noteMarchand`, `avisMarchand`) VALUES
(1, 1, '475jj', '20221025124803 jjjj', 652222222, 500, 16254755, 7854, 1, 0, 'd', 0, 0, 0, NULL, 10, NULL),
(2, 1, '075jj', '00221025124803 jjjj', 650000002, 500, 16254755, 78500, 1, 0, 'd', 0, 0, 0, NULL, 10, NULL),
(71, 1, 'd', 'd', 0, 0, 1663522929, 20291982560, 1, 0, NULL, 100, 10, 0, NULL, 10, NULL),
(72, 1, 'd', 'd', 0, 0, 1663541576, 57351886210, 1, 0, NULL, 100, 10, 0, NULL, 10, NULL),
(73, 1, 'd', 'd', 0, 0, 1663542111, 57351886210, 1, 0, NULL, 100, 10, 0, NULL, 10, NULL);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `encour`
--
ALTER TABLE `encour`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `favorite`
--
ALTER TABLE `favorite`
  ADD PRIMARY KEY (`id`),
  ADD KEY `marchand` (`marchand`);

--
-- Index pour la table `marchand`
--
ALTER TABLE `marchand`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_transaction_marchand` (`marchand`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `encour`
--
ALTER TABLE `encour`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT pour la table `favorite`
--
ALTER TABLE `favorite`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `marchand`
--
ALTER TABLE `marchand`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT pour la table `transaction`
--
ALTER TABLE `transaction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `favorite`
--
ALTER TABLE `favorite`
  ADD CONSTRAINT `favorite_ibfk_1` FOREIGN KEY (`marchand`) REFERENCES `marchand` (`id`);

--
-- Contraintes pour la table `transaction`
--
ALTER TABLE `transaction`
  ADD CONSTRAINT `fk_transaction_marchand` FOREIGN KEY (`marchand`) REFERENCES `marchand` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
