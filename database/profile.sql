CREATE TABLE IF NOT EXISTS `Users` (
    `UserID` int(11) NOT NULL AUTO_INCREMENT,
    `Username` varchar(50) NOT NULL,
    `Password` varchar(250) NOT NULL,
    `Email` varchar(50) NOT NULL,
    PRIMARY KEY (`UserID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;



