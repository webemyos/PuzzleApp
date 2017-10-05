CREATE TABLE IF NOT EXISTS `ProfilCompetence` ( 
`Id` int(11) NOT NULL AUTO_INCREMENT, 
`CategoryId` INT  NULL ,
`Code` VARCHAR(200)  NULL ,
`Name` VARCHAR(200)  NULL ,
PRIMARY KEY (`Id`),
CONSTRAINT `Profil_competenceCategory_Profil_competence` FOREIGN KEY (`CategoryId`) REFERENCES `ProfilCompetenceCategory`(`Id`)
) ENGINE=InnoDB  DEFAULT CHARACTER SET `utf8`; 