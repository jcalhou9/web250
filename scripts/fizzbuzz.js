// Jeremy Calhoun
// WEB250-N850 Spring 25

//reset
document.getElementById("reset").onclick = () => {
    document.getElementById("greeting").textContent = "let's go again!";
    ['col1', 'col2', 'col3'].forEach((id) =>
        document.getElementById(id).textContent = ''
);
document.getElementById("output-wrapper").style.display = 'none';
};

//form submit
document.getElementById("form").onsubmit = (event) => {
    event.preventDefault();
    const outputWrapper = document.getElementById("output-wrapper");
    const columns = ['col1', 'col2', 'col3'].map((id) =>
        document.getElementById(id)
    );

    //clear output
    columns.forEach((col) => col.textContent = '');
    outputWrapper.style.display = 'none';

    // get and format name or default
    const firstNameField = document.getElementById("first-name");
    const lastNameField = document.getElementById("last-name");
    let firstName = firstNameField.value.trim();
    let lastName = lastNameField.value.trim();
    let middleInitial = document.getElementById("middle-initial").value.trim();
    const mainWord = document.getElementById("main-word").value.trim();

    // require both if one is filled
    if ((firstName && !lastName) || (!firstName && lastName)) {
        const missingField = firstName ? lastNameField : firstNameField;
        missingField.setCustomValidity("Required");
        missingField.reportValidity();
        return;
    }
    
    // default if both are empty
    if (!firstName && !lastName) {
        firstName = "Guest";
        lastName = "User";
        middleInitial = "";
    }

    const fullName = middleInitial
        ? `${firstName} ${middleInitial}. ${lastName}`
        : `${firstName} ${lastName}`;

    document.getElementById("greeting").textContent = `Welcome to Fizz Buzz, ${fullName}!`;

    // get input values
    const [divisor1, divisor2, divisor3] = ['divisor1', 'divisor2', 'divisor3'].map((id) =>
        parseInt(document.getElementById(id).value, 10)
    );
    const [word1, word2, word3] = ['word1', 'word2', 'word3'].map((id) =>
        document.getElementById(id).value.trim()
    );
    const countLimit = parseInt(document.getElementById("count-limit").value, 10);

    // input validation
    if (isNaN(countLimit) || countLimit < 1) {
        document.getElementById("greeting").textContent = 'please enter a number greater than 0.';
        return;
    }

    // set up divisors
    const divisors = {
        [divisor1]: word1,
        [divisor2]: word2,
        [divisor3]: word3
    };

    function checkDivision(num, divisor) {
        return num % divisor === 0;
    }

    // divide into thirds
    const chunk = Math.ceil(countLimit / 3);

    for (let count = 1; count <= countLimit; count++) {
        let result = '';

        Object.entries(divisors).forEach(([divisor, word]) => {
            if (checkDivision(count, parseInt(divisor, 10))) {
                result += word + ' ';
            }
        });

        if (result === '') {
            result = mainWord;
        }

        const li = document.createElement('li');
        li.textContent = `${count}. ${result.trim()}`;

        const colIndex = Math.floor((count - 1) / chunk);
        columns[colIndex].appendChild(li);
    }

    // show output box
    outputWrapper.style.display = 'block';
};