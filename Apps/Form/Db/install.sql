-- ----------------------- Formulaire -----------------------------------------
CREATE TABLE IF NOT EXISTS `FormForm` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `UserId` int(11) ,
  `Libelle` varchar(500) NOT NULL,
  `Actif` INT(1) NULL ,
  `Commentaire` varchar(500) NOT NULL,
  `AppName` VARCHAR(200)  NULL ,
  `AppId` INT  NULL ,
  `EntityName` VARCHAR(200)  NULL ,
  `EntityId` INT  NULL ,
  PRIMARY KEY (`Id`),
  CONSTRAINT `eeForm_user` FOREIGN KEY (`UserId`) REFERENCES ee_user(`Id`))
  ENGINE=InnoDB  DEFAULT CHARACTER SET `utf8`;

  -- ------------------------ Question du formulaire  ---------------------------
  CREATE TABLE IF NOT EXISTS `FormQuestion` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `FormId` int(11) ,
  `Type` int(11) ,
  `Libelle` varchar(500) ,
  `Commentaire` text NULL,
  PRIMARY KEY (`Id`),
  CONSTRAINT `eeForm_question_form` FOREIGN KEY (`FormId`) REFERENCES FormForm(`Id`))
  ENGINE=InnoDB  DEFAULT CHARACTER SET `utf8`;

  -- ------------------------- Reponse possible ---------
  CREATE TABLE IF NOT EXISTS `FormResponse` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `QuestionId` int(11) ,
  `Value` varchar(500) ,
  `Commentaire` text NULL,
  `Actif` int(1) ,
  PRIMARY KEY (`Id`),
  CONSTRAINT `eeForm_response_question` FOREIGN KEY (`QuestionId`) REFERENCES FormQuestion(`Id`))
  ENGINE=InnoDB  DEFAULT CHARACTER SET `utf8`;

-- -------------------------- Reponse utilisateur --------------------------
CREATE TABLE IF NOT EXISTS `FormResponseUser` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `QuestionId` int(11) ,
  `ResponseId` int(11) ,
  `UserId` int(11) NULL,
  `Value` text NULL,
  `AdresseIp` text NULL,
  PRIMARY KEY (`Id`),
  CONSTRAINT `eeForm_responseUser_question` FOREIGN KEY (`QuestionId`) REFERENCES FormQuestion(`Id`),
  CONSTRAINT `eeForm_response_response` FOREIGN KEY (`ResponseId`) REFERENCES FormResponse(`Id`)
  )
  ENGINE=InnoDB  DEFAULT CHARACTER SET `utf8`;
