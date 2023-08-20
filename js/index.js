// add event to category buttons on index page

var categories = document.querySelectorAll('.categories-label');

for(let i=0; i < categories.length; i++) {
    var category = categories[i];
    // add an event listener to each category button and define what happens on a click event
	category.addEventListener('click', chooseCategory);
}


async function chooseCategory (e){
    category = e.currentTarget.textContent; // clicked category
    saveChosenCategory(category);
}

function saveChosenCategory(categoryName) {
    $.ajax({
        url:"API.php",    //the page containing php script
        type: "post",    //request type,
        data: {action : "saveChosenCategory", arg: categoryName},
        success:function(output){
            //console.log(output);
        },
        async: false
    });
}