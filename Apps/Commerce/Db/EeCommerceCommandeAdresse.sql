CREATE TABLE IF NOT EXISTS `EeCommerceCommandeAdresse` ( 
`Id` int(11) NOT NULL AUTO_INCREMENT, 
`TypeId` INT  NULL ,
`CityId` INT  NULL ,
`Name` varchar(30)  NULL ,
`Adress` TEXT  NULL ,
`Complement` TEXT  NULL ,
`CodePostal` varchar(30)  NULL ,
PRIMARY KEY (`Id`)
) ENGINE=InnoDB  DEFAULT CHARACTER SET `utf8`; 