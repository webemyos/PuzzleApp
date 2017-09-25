CREATE TABLE IF NOT EXISTS `BlogCategory` ( 
`Id` int(11) NOT NULL AUTO_INCREMENT, 
`BlogId` INT  NULL ,
`Name` VARCHAR(50)  NULL ,
`Code` VARCHAR(200)  NULL ,
`Description` TEXT  NULL ,
PRIMARY KEY (`Id`),
CONSTRAINT `BlogBlog_BlogCategory` FOREIGN KEY (`BlogId`) REFERENCES `BlogBlog`(`Id`)
) ENGINE=InnoDB  DEFAULT CHARACTER SET `utf8`; 