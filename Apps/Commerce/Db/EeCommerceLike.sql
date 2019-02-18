CREATE TABLE IF NOT EXISTS `EeCommerceLike` ( 
`Id` int(11) NOT NULL AUTO_INCREMENT, 
`UserId` INT  NULL ,
`ProductId` INT  NULL ,
PRIMARY KEY (`Id`),
CONSTRAINT `ee_user_EeCommerceLike` FOREIGN KEY (`UserId`) REFERENCES `ee_user`(`Id`),
CONSTRAINT `EeCommerceProduct_EeCommerceLike` FOREIGN KEY (`ProductId`) REFERENCES `EeCommerceProduct`(`Id`)
) ENGINE=InnoDB  DEFAULT CHARACTER SET `utf8`; 