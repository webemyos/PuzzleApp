CREATE TABLE IF NOT EXISTS `BlogArticle` ( 
`Id` int(11) NOT NULL AUTO_INCREMENT, 
`BlogId` INT  NULL ,
`UserId` INT  NULL ,
`CategoryId` INT  NULL ,
`Actif` INT  NULL ,
`Name` VARCHAR(200)  NULL ,
`Code` VARCHAR(200)  NULL ,
`KeyWork` TEXT  NULL ,
`Description` TEXT  NULL ,
`Content` TEXT  NULL ,
`DateCreated` DATE  NULL ,
PRIMARY KEY (`Id`),
CONSTRAINT `BlogBlog_BlogArticle` FOREIGN KEY (`BlogId`) REFERENCES `BlogBlog`(`Id`),
CONSTRAINT `ee_user_BlogArticle` FOREIGN KEY (`UserId`) REFERENCES `ee_user`(`Id`)
) ENGINE=InnoDB  DEFAULT CHARACTER SET `utf8`; 