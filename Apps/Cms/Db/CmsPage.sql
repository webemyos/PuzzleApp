CREATE TABLE IF NOT EXISTS `CmsPage` ( 
`Id` int(11) NOT NULL AUTO_INCREMENT, 
`CmsId` INT  NULL ,
`Name` VARCHAR(200)  NULL ,
`Title` VARCHAR(200)  NULL ,
`Description` TEXT  NULL ,
`Content` TEXT  NULL ,
PRIMARY KEY (`Id`),
CONSTRAINT `CmsCms_CmsPage` FOREIGN KEY (`CmsId`) REFERENCES `CmsCms`(`Id`)
) ENGINE=InnoDB  DEFAULT CHARACTER SET `utf8`; 