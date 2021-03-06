CREATE TABLE IF NOT EXISTS `CmsCms` ( 
`Id` int(11) NOT NULL AUTO_INCREMENT, 
`Name` VARCHAR(200)  NULL ,
`Description` TEXT  NULL ,
`UserId` INT  NULL ,
`AppName` VARCHAR(200)  NULL ,
`AppId` INT  NULL ,
`EntityName` VARCHAR(200)  NULL ,
`EntityId` INT  NULL ,
PRIMARY KEY (`Id`),
CONSTRAINT `ee_user_CmsCms` FOREIGN KEY (`UserId`) REFERENCES `ee_user`(`Id`)
) ENGINE=InnoDB  DEFAULT CHARACTER SET `utf8`; 

CREATE TABLE IF NOT EXISTS `CmsPage` ( 
`Id` int(11) NOT NULL AUTO_INCREMENT, 
`CmsId` INT  NULL ,
`Name` VARCHAR(200)  NULL ,
`Code` VARCHAR(200)  NULL ,
`Title` VARCHAR(200)  NULL ,
`Description` TEXT  NULL ,
`Content` TEXT  NULL ,
PRIMARY KEY (`Id`),
CONSTRAINT `CmsCms_CmsPage` FOREIGN KEY (`CmsId`) REFERENCES `CmsCms`(`Id`)
) ENGINE=InnoDB  DEFAULT CHARACTER SET `utf8`; 


INSERT INTO EeAppApp(`CategoryId`, `Name`, `Description`) VALUE( 1, "Cms", "Gestionnaires des pages");
INSERT INTO EeAppAdmin(`UserId`, `AppId`) VALUE( 1, 2);