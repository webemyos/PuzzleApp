CREATE TABLE IF NOT EXISTS `EeCommerceFicheProduct` ( 
`Id` int(11) NOT NULL AUTO_INCREMENT, 
`CategoryId` INT  NULL ,
`Name` VARCHAR(200)  NULL ,
`Code` VARCHAR(200)  NULL ,
`KeyWord` TEXT  NULL ,
`ShortDescription` TEXT  NULL ,
`LongDescription` TEXT  NULL ,
PRIMARY KEY (`Id`),
CONSTRAINT `EeCommerceProductCategory_EeCommerceFicheProduct` FOREIGN KEY (`CategoryId`) REFERENCES `EeCommerceProductCategory`(`Id`)
) ENGINE=InnoDB  DEFAULT CHARACTER SET `utf8`; 