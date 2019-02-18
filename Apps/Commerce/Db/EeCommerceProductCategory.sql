CREATE TABLE IF NOT EXISTS `EeCommerceProductCategory` ( 
`Id` int(11) NOT NULL AUTO_INCREMENT, 
`CommerceId` INT  NULL ,
`Name` VARCHAR(200)  NULL ,
`Description` TEXT  NULL ,
PRIMARY KEY (`Id`),
CONSTRAINT `EeCommerceCommerce_EeCommerceProductCategory` FOREIGN KEY (`CommerceId`) REFERENCES `EeCommerceCommerce`(`Id`)
) ENGINE=InnoDB  DEFAULT CHARACTER SET `utf8`; 