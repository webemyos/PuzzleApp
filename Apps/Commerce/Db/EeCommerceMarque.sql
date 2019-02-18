CREATE TABLE IF NOT EXISTS `EeCommerceMarque` ( 
`Id` int(11) NOT NULL AUTO_INCREMENT, 
`CommerceId` INT  NULL ,
`Name` VARCHAR(200)  NULL ,
PRIMARY KEY (`Id`),
CONSTRAINT `EeCommerceCommerce_EeCommerceMarque` FOREIGN KEY (`CommerceId`) REFERENCES `EeCommerceCommerce`(`Id`)
) ENGINE=InnoDB  DEFAULT CHARACTER SET `utf8`; 