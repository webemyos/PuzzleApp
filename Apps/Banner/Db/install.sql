CREATE TABLE IF NOT EXISTS `BannerBanner` ( 
`Id` int(11) NOT NULL AUTO_INCREMENT, 
`Name` TEXT  NULL ,
`Actif` INT  NULL ,
`UserId` INT  NULL ,
PRIMARY KEY (`Id`),
CONSTRAINT `ee_user_BannerBanner` FOREIGN KEY (`UserId`) REFERENCES `ee_user`(`Id`)
) ENGINE=InnoDB  DEFAULT CHARACTER SET `utf8`; 

CREATE TABLE IF NOT EXISTS `BannerContent` ( 
`Id` int(11) NOT NULL AUTO_INCREMENT, 
`BannerId` INT  NULL ,
`Content` TEXT  NULL ,
`Name` VARCHAR(50)  NULL ,
`Actif` INT  NULL ,
PRIMARY KEY (`Id`),
CONSTRAINT `BannerBanner_BannerContent` FOREIGN KEY (`BannerId`) REFERENCES `BannerBanner`(`Id`)
) ENGINE=InnoDB  DEFAULT CHARACTER SET `utf8`; 