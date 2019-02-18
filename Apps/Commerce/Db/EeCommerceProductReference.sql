CREATE TABLE IF NOT EXISTS `EeCommerceProductReference` ( 
`Id` int(11) NOT NULL AUTO_INCREMENT, 
`ProductId` INT  NULL ,
`Code` VARCHAR(200)  NULL ,
`Libelle` VARCHAR(200)  NULL ,
`Quantity` INT  NULL ,
PRIMARY KEY (`Id`),
CONSTRAINT `EeCommerceProduct_EeCommerceProductReference` FOREIGN KEY (`ProductId`) REFERENCES `EeCommerceProduct`(`Id`)
) ENGINE=InnoDB  DEFAULT CHARACTER SET `utf8`; 