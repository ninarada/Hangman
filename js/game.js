var alphabet = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H',
        'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S',
        'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];

var isTheGameStarted = 0; //game starts after first letter was picked

window.onload = newGame;

window.onbeforeunload = playerLeftGame;

function newGame(){
    let dashed, title;
    let title2;
    let livesLift;
    let chosenCategory;
    let filename;
    let letters;
    let containingLetter;
    let tempDashed;
    
    chosenCategory = document.querySelector('#categoryName').getAttribute('data-category');
    console.log('Category:      ' + chosenCategory);
    filename = categoryNameToFilename(chosenCategory);
    console.log('Filename:      ' + filename);

    if(filename != 'categories/movies.txt' && filename != 'categories/tvshows.txt' && filename != 'categories/countries.txt' 
    && filename != 'categories/cities.txt' && filename != 'categories/food.txt' && filename != 'categories/celebrities.txt') {
      console.log('error loading file');
      return -1;
    }

    title = getRandomTitle(filename);

    console.log('Title:      ' + title); 

    title2 = title;
    title = title.toUpperCase();

    dashed = titleToDash(title);
    livesLift = livesAndCategory(chosenCategory);
    //console.log(livesLift);
    makingKeyboard();

    letters = document.querySelectorAll('.letters');

    letters.forEach(function(element) {
        element.addEventListener('click', function(e) {
        
            element.classList.add('guessedLetters');
            element.classList.remove('letters');
            isTheGameStarted = 1;

            tempDashed = dashed;
            dashed = checkLetter(element.innerText, title, dashed); //check if the picked letter is in title
            containingLetter = checkStrings(tempDashed, dashed); // 1 - same, wrong letter; 0 - correct letter, 
            document.getElementById('guess-words').innerHTML = dashed;

            if(containingLetter != 0) { //if title doesn't contains that letter
              livesLift--;
              updatingLives(livesLift);
              draw(livesLift);
              if(livesLift == 0) {
                playerLostGame();
                draw(0);
                setTimeout(gameOver(title2), 400);
              }
            } else if(containingLetter == 0) {
              if(checkStrings(dashed, title)== 1) { //check if user won
                isTheGameStarted = 0;
                if(livesLift == 7) {
                  playerWonGameWithNoMistakes();
                } else {
                  playerWonGame();
                }
                setTimeout(gameWon, 300);
            };
            }

        });
    });
}

function getRandomTitle(filestring){
  let randomTitle;
  $.ajax({
      url:"API.php",    //the page containing php script
      type: "post",    //request type,
      data: {action: "getRandomTitle", arg: filestring},
      success:function(output){
          randomTitle = output;
      },
      async: false
  });
  return randomTitle;
}

function categoryNameToFilename(string) {
    let file = string.toLowerCase();
    let tempFile = 'categories/';
    
    file = file.replaceAll(' ', '');
    file = tempFile.concat(file);
    file = file.concat('.txt');

    return file;
}

function checkLetter(letter, title, titleDashed) {
    for(let i = 0; i< title.length; i++){
      if(title[i] == letter) {
        titleDashed = titleDashed.substring(0, i) + letter + titleDashed.substring(i + '_'.length);
      } 
    }
    return titleDashed;
}

function checkStrings(str1, str2){
    if (str1 == str2) {
      return 1;
    } else {
      return 0;
    }
}

function gameOver (correctAnswer) {
    document.getElementById('game-over').style.display= 'flex';
    document.getElementById('correct-answer').innerHTML = 'The correct answer was: ' + correctAnswer;
}
  
function gameWon() {
    document.getElementById('game-won').style.display= 'flex';
}

/*--------------connection with php to update statistics---------------*/

function playerLeftGame (){
  $.ajax({
    url:"API.php",    
    type: "post",    
    data: {action: "playerLeftGame", arg: isTheGameStarted},
    success:function(output){
        //console.log(output);
    },
    async: true
  });
}

function playerLostGame(){
    $.ajax({
      url:"API.php",    
      type: "post",    
      data: {action : "playerLostGame"},
      success:function(output){
          //console.log(output);
      },
      async: false
    });
}
  
function playerWonGame(){
    $.ajax({
      url:"API.php",    
      type: "post",    
      data: {action: "playerWonGame"},
      success:function(output){
          //console.log(output);
      },
      async: false
    });

}

function playerWonGameWithNoMistakes(){
    $.ajax({
      url:"API.php",    
      type: "post",    
      data: {action: "playerWonGameWithNoMistakes"},
      success:function(output){
          //console.log(output);
      },
      async: false
    });
}

/*--------------filling guessing container---------------*/

function titleToDash(title){
    let titleDashed = title;

    for(let i = 0; i< title.length; i++){
        if(title[i] !== ' ' && title[i] !== '\r' && title[i] !== '\n') {
            if(title[i] === ',' || title[i] === ':' || title[i] === '.' || title[i] === '–' || title[i] === "'" || title[i] === '?' || title[i] === '!' || title[i] === '&') {
                titleDashed = titleDashed.substring(0, i) + title[i] + title.substring(i + '_'.length);
            } else {
                titleDashed = titleDashed.substring(0, i) + '_' + title.substring(i + '_'.length);
            }
        } 
    }

    document.getElementById('guess-words').innerHTML = titleDashed;

    return titleDashed;
}

function livesAndCategory(category) {
    let lives = 7;
    let livesText = document.getElementById('lives').innerHTML;
    let categoryText = document.getElementById('categoryName').innerHTML;

    document.getElementById('lives').innerHTML = livesText + lives;

    document.getElementById('categoryName').innerHTML = categoryText + category;

    return lives;
}

function updatingLives(lives) {
    document.getElementById('lives').innerHTML = 'Lives left:' + lives;
    
    return lives;
}

function makingKeyboard(){
    for (let i = 0; i < alphabet.length; i++) {
      const letters = document.createElement('span');
      const letter = document.createTextNode(alphabet[i]);

      letters.className = 'letters';
      letters.appendChild(letter);
      document.getElementById('buttons').appendChild(letters);
    }
}

/*--------------drawing---------------*/

function draw(counter) {
    var canvas = document.getElementById('hangman');
    var ctx = canvas.getContext('2d');
  
    if(counter === 6) {
      /*----hanger----*/
      ctx.moveTo(100,300);
      ctx.lineTo(250,300);
      ctx.stroke();
      ctx.moveTo(175,300);
      ctx.lineTo(175,50);
      ctx.stroke();
      ctx.moveTo(175,50);
      ctx.lineTo(300,50);
      ctx.stroke();
      ctx.moveTo(300,50);
      ctx.lineTo(300,80);
      ctx.stroke();
    } else if (counter === 5) {
      /*----head----*/
      ctx.beginPath();
      ctx.arc(300, 100, 20, 0, 2 * Math.PI);
      ctx.stroke();
    } else if (counter == 4) {
      /*----body----*/
      ctx.moveTo(300,120);
      ctx.lineTo(300,200);
      ctx.stroke();
    } else if (counter === 3) {
      /*----arm 1----*/
      ctx.moveTo(300,140);
      ctx.lineTo(280,160);
      ctx.stroke();
    } else if (counter === 2) {
      /*----arm 2----*/
      ctx.moveTo(300,140);
      ctx.lineTo(320,160);
      ctx.stroke();
    } else if (counter === 1) {
      /*----leg 1----*/
      ctx.moveTo(300,200);
      ctx.lineTo(280,220);
      ctx.stroke();
    } else if (counter === 0) {
      /*----leg 2----*/
      ctx.moveTo(300,200);
      ctx.lineTo(320,220);
      ctx.stroke();
    } 
}