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
    let firstName = document.getElementById("first-name").value.trim();
    const middleInitial = document.getElementById("middle-initial").value.trim();
    let lastName = document.getElementById("last-name").value.trim();
    const mainWord = document.getElementById("main-word").value.trim();
    if (!firstName || !lastName) {
        firstName = "guest";
        lastName = "user";
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