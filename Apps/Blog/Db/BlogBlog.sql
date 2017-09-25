CREATE TABLE IF NOT EXISTS `BlogBlog` ( 
`Id` int(11) NOT NULL AUTO_INCREMENT, 
`UserId` INT  NULL ,
`Name` VARCHAR(200)  NULL ,
`Description` TEXT  NULL ,
`Style` INT  NULL ,
`Actif` INT  NULL ,
`AppName` VARCHAR(200)  NULL ,
`AppId` INT  NULL ,
`EntityName` VARCHAR(200)  NULL ,
`EntityId` INT  NULL ,
PRIMARY KEY (`Id`),
CONSTRAINT `ee_user_EeBloBlog` FOREIGN KEY (`UserId`) REFERENCES `ee_user`(`id`)
) ENGINE=InnoDB  DEFAULT CHARACTER SET `utf8`; 