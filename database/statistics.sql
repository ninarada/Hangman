CREATE TABLE IF NOT EXISTS `Statistics` (
    `StatID` int(250) NOT NULL AUTO_INCREMENT,
    `Username` varchar(50) NOT NULL,
    `GamesPlayed` int(11) NOT NULL,
    `GamesWon` int(11) NOT NULL,
    `WinsWithNoMistakes` int(11) NOT NULL, 
    `BestWinStreak` int(11) NOT NULL,
    `CurrentWinStreak` int(11) NOT NULL,
    PRIMARY KEY (`StatID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

