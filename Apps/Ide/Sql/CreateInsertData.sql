-- --------------------------------------------------------
--
-- Structure de la table `ee_app`
--

CREATE TABLE IF NOT EXISTS `ee_app` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Code` varchar(45) NOT NULL,
  `Deletable` tinyint(1) NOT NULL,
  `AssociatedFile` varchar(255) DEFAULT NULL,
  `CategoryId` int(11) DEFAULT NULL,
  `Note` int(11) DEFAULT NULL,
  `DateAdd` date DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  ;

-- --------------------------------------------------------
--
-- Structure de la table `ee_appcategory`
--

CREATE TABLE IF NOT EXISTS `ee_appcategory` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Code` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;

--
-- Contenu de la table `ee_appcategory`
--

INSERT INTO `ee_appcategory` (`Code`) VALUES
('BUREAU'),
('OUTIL'),
('JEUX'),
('DIVERTISSEMENT');

-- --------------------------------------------------------
--
-- Structure de la table `ee_appcategory_lang`
--

CREATE TABLE IF NOT EXISTS `ee_appcategory_lang` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `CategoryId` int(11) NOT NULL,
  `LangId` int(11) NOT NULL,
  `Libelle` varchar(105) DEFAULT NULL,
  PRIMARY KEY (`Id`),
  KEY `appcategoryLang_parameter` (`CategoryId`),
  KEY `appcategoryLang_lang` (`LangId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;

--
-- Contenu de la table `ee_appcategory_lang`
--

INSERT INTO `ee_appcategory_lang` (`Id`, `CategoryId`, `LangId`, `Libelle`) VALUES
(1, 1, 1, 'Bureautique'),
(2, 2, 1, 'Outil'),
(3, 3, 1, 'Jeux'),
(4, 4, 1, 'Divertissement');

-- --------------------------------------------------------
--
-- Structure de la table `ee_app_lang`
--

CREATE TABLE IF NOT EXISTS `ee_app_lang` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `AppId` int(11) NOT NULL,
  `LangId` int(11) NOT NULL,
  `Libelle` text,
  `Description` text,
  `Notice` text,
  `Title` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`Id`),
  KEY `appLangs_app` (`AppId`),
  KEY `appLang_lang` (`LangId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;


-- --------------------------------------------------------
--
-- Structure de la table `ee_bug`
--

CREATE TABLE IF NOT EXISTS `ee_bug` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `AppWidget` varchar(255) NOT NULL,
  `Navigateur` varchar(45) NOT NULL,
  `Commentaire` text NOT NULL,
  `State` varchar(45) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  ;

-- --------------------------------------------------------
--
-- Structure de la table `ee_comment`
--

CREATE TABLE IF NOT EXISTS `ee_comment` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `AppWidget` varchar(255) NOT NULL,
  `Navigateur` varchar(45) NOT NULL,
  `Commentaire` text NOT NULL,
  `State` varchar(45) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------
--
-- Structure de la table `ee_city`
--

CREATE TABLE IF NOT EXISTS `ee_city` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(45) NOT NULL,
  `Insee` varchar(45) DEFAULT NULL,
  `Code_postal` varchar(45) DEFAULT NULL,
  `Altitude` int(11) DEFAULT NULL,
  `Longitude` float DEFAULT NULL,
  `Latitude` float DEFAULT NULL,
  `CodePays` varchar(45) DEFAULT NULL,
  `NOMADMIN1` varchar(45) DEFAULT NULL,
  `CODEADMIN1` varchar(45) DEFAULT NULL,
  `NOMADMIN2` varchar(45) DEFAULT NULL,
  `NOMADMIN3` varchar(45) DEFAULT NULL,
  `ACURANCY` varchar(45) DEFAULT NULL,
  `CODEADMIN2` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  ;

-- --------------------------------------------------------

--
-- Structure de la table `stat_app`
--

CREATE TABLE IF NOT EXISTS `stat_app` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Adresse` varchar(20) NOT NULL,
  `App` varchar(255) NOT NULL,
  `Navigator` varchar(255) NOT NULL,
  `UserId` varchar(255) NOT NULL,
  `DateCreate` datetime DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  ;

-- --------------------------------------------------------
--
-- Structure de la table `stat_front`
--

CREATE TABLE IF NOT EXISTS `stat_front` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Adresse` varchar(20) NOT NULL,
  `Url` varchar(255) NOT NULL,
  `Navigator` varchar(255) NOT NULL,
  `UserId` varchar(255) NOT NULL,
  `DateCreate` datetime DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  ;


-- --------------------------------------------------------
--
-- Structure de la table `stat_widget`
--

CREATE TABLE IF NOT EXISTS `stat_widget` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Adresse` varchar(20) NOT NULL,
  `Widget` varchar(255) NOT NULL,
  `Navigator` varchar(255) NOT NULL,
  `UserId` varchar(255) NOT NULL,
  `DateCreate` datetime DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  ;

-- --------------------------------------------------------

--
-- Structure de la table `ee_user`
--

CREATE TABLE IF NOT EXISTS `ee_user` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `GroupId` int(11) NOT NULL,
  `Email` varchar(45) NOT NULL,
  `Pseudo` varchar(45) DEFAULT NULL,
  `PassWord` varchar(45) NOT NULL,
  `Name` varchar(45) NOT NULL,
  `FirstName` varchar(45) NOT NULL,
  `Sexe` tinyint(1) NOT NULL,
  `BirthDate` date DEFAULT NULL,
  `CountryId` int(11) DEFAULT NULL,
  `CityId` int(11) DEFAULT NULL,
  `Phone` varchar(45) DEFAULT NULL,
  `Image` varchar(200) DEFAULT NULL,
  `ImageMini` varchar(250) NOT NULL,
  `DateCreate` date DEFAULT NULL,
  `DateChange` date DEFAULT NULL,
  `Serveur` varchar(45) DEFAULT NULL,
  `DateConnect` datetime DEFAULT NULL,
  `FacebookId` bigint(20) NOT NULL,
  `Position` int(11) DEFAULT NULL,
  PRIMARY KEY (`Id`),
  KEY `user_group` (`GroupId`),
  KEY `user_country` (`CountryId`),
  KEY `user_city` (`CityId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  ;

-- --------------------------------------------------------
--
-- Structure de la table `ee_country`
--

CREATE TABLE IF NOT EXISTS `ee_country` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Code` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ;

-- --------------------------------------------------------
--
-- Structure de la table `ee_country_lang`
--

CREATE TABLE IF NOT EXISTS `ee_country_lang` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `CountryId` int(11) NOT NULL,
  `LangId` int(11) NOT NULL,
  `Libelle` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`Id`),
  KEY `countryLang_country` (`CountryId`),
  KEY `countryLang_lang` (`LangId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ;

-- --------------------------------------------------------
--
-- Structure de la table `ee_datatext`
--

CREATE TABLE IF NOT EXISTS `ee_datatext` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Code` varchar(100) NOT NULL,
  `Title` varchar(50) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;

-- --------------------------------------------------------
--
-- Structure de la table `ee_datatext_lang`
--

CREATE TABLE IF NOT EXISTS `ee_datatext_lang` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TextId` int(11) NOT NULL,
  `LangId` int(11) NOT NULL,
  `Text` text NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `Text-Text` (`TextId`),
  KEY `Text-Lang` (`LangId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;

-- --------------------------------------------------------
--
-- Structure de la table `ee_group`
--

CREATE TABLE IF NOT EXISTS `ee_group` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(50) NOT NULL,
  `SectionId` int(11) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `Group-Section` (`SectionId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;

-- --------------------------------------------------------

--
-- Structure de la table `ee_lang`
--

CREATE TABLE IF NOT EXISTS `ee_lang` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Code` varchar(10) NOT NULL,
  `Name` varchar(25) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;

-- --------------------------------------------------------

--
-- Structure de la table `ee_lang_code`
--

CREATE TABLE IF NOT EXISTS `ee_lang_code` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Code` varchar(50) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1252 ;

-- Element multilangue

CREATE TABLE IF NOT EXISTS `ee_lang_element` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `CodeId` int(11) NOT NULL,
  `LangId` int(11) NOT NULL,
  `Libelle` text NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `Code-element` (`CodeId`),
  KEY `Lang-element` (`LangId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `ee_section`
--

CREATE TABLE IF NOT EXISTS `ee_section` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(50) NOT NULL,
  `Directory` varchar(50) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;



--
-- Contenu de la table `ee_group`
--

INSERT INTO `ee_group` (`Id`, `Name`, `SectionId`) VALUES
(1, 'Root', 1),
(2, 'Membre', 2);



--
-- Contenu de la table `ee_lang`
--

INSERT INTO `ee_lang` (`Id`, `Code`, `Name`) VALUES
(1, 'Fr', 'Francais'),
(2, 'En', 'Anglais');


--
-- Contenu de la table `ee_section`
--

INSERT INTO `ee_section` (`Id`, `Name`, `Directory`) VALUES
(1, 'Root', 'Root/'),
(2, 'Membre', 'Membre/');

--
-- Contenu de la table `ee_user`
--

INSERT INTO `ee_user` (`GroupId`, `Email`, `Pseudo`, `PassWord`, `Name`, `FirstName`, `Sexe`, `BirthDate`, `CountryId`, `CityId`, `Phone`, `Image`, `ImageMini`, `DateCreate`, `DateChange`, `Serveur`, `DateConnect`, `FacebookId`, `Position`) VALUES
(2, 'jerome.oliva@gmail.com', '', '603edc5ad257edd10764ca5261b6d356', 'Oliva', 'jerome', 1, '1980-01-20', 0, 188, '', '../Data/User/19ca14e7ea6328a42e0eb13d585e4c22/Files/Images/Profil/profil.jpg', '', '2012-09-25', NULL, 'Data', '0000-00-00 00:00:00', 0, 1);

--
-- Contraintes pour les tables exportées
--
--
-- Contraintes pour la table `ee_appcategory_lang`
--

ALTER TABLE `ee_appcategory_lang`
  ADD CONSTRAINT `appcategoryLang_parameter` FOREIGN KEY (`CategoryId`) REFERENCES `ee_appcategory` (`Id`),
  ADD CONSTRAINT `appCategoyLang_lang` FOREIGN KEY (`LangId`) REFERENCES `ee_lang` (`Id`);

--
-- Contraintes pour la table `ee_app_lang`
--

ALTER TABLE `ee_app_lang`
  ADD CONSTRAINT `appLang_app` FOREIGN KEY (`AppId`) REFERENCES `ee_app` (`Id`),
  ADD CONSTRAINT `appLang_lang` FOREIGN KEY (`LangId`) REFERENCES `ee_lang` (`Id`);

--
-- Contraintes pour la table `ee_country_lang`
--

ALTER TABLE `ee_country_lang`
  ADD CONSTRAINT `countryLang_country` FOREIGN KEY (`CountryId`) REFERENCES `ee_country` (`Id`),
  ADD CONSTRAINT `countryLang_lang` FOREIGN KEY (`LangId`) REFERENCES `ee_lang` (`Id`);

--
-- Contraintes pour la table `ee_datatext_lang`
--

ALTER TABLE `ee_datatext_lang`
  ADD CONSTRAINT `Text-Lang` FOREIGN KEY (`LangId`) REFERENCES `ee_lang` (`Id`),
  ADD CONSTRAINT `Text-Text` FOREIGN KEY (`TextId`) REFERENCES `ee_datatext` (`Id`);

--
-- Contraintes pour la table `ee_group`
--

ALTER TABLE `ee_group`
  ADD CONSTRAINT `Group-Section` FOREIGN KEY (`SectionId`) REFERENCES `ee_section` (`Id`);

--
-- Contraintes pour la table `ee_lang_element`
--

ALTER TABLE `ee_lang_element`
  ADD CONSTRAINT `Code-element` FOREIGN KEY (`CodeId`) REFERENCES `ee_lang_code` (`Id`),
  ADD CONSTRAINT `Lang-element` FOREIGN KEY (`LangId`) REFERENCES `ee_lang` (`Id`);

--
-- Contraintes pour la table `ee_user`
--

ALTER TABLE `ee_user`
  ADD CONSTRAINT `user_group` FOREIGN KEY (`GroupId`) REFERENCES `ee_group` (`Id`);