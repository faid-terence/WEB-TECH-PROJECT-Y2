const questions = [
    {
      question: "What does HTML stand for?",
      answers: [
        {
          text: "Hyperlinks and Text Markup Language",
          correct: false,
        },
        {
          text: "Hyper Text Markup Language",
          correct: true,
        },
        {
          text: "Home Tool Markup Language",
          correct: false,
        },
        {
          text: "Hyperlinking Text Management Language",
          correct: false,
        },
      ],
    },
    {
      question: "Which CSS property is used to change the background color of an element?",
      answers: [
        {
          text: "color",
          correct: false,
        },
        {
          text: "background-color",
          correct: true,
        },
        {
          text: "bgcolor",
          correct: false,
        },
        {
          text: "background",
          correct: false,
        },
      ],
    },
    {
      question: "What is the purpose of the JavaScript `map` function?",
      answers: [
        {
          text: "To create new arrays by transforming elements of an existing array",
          correct: true,
        },
        {
          text: "To filter elements of an array based on a condition",
          correct: false,
        },
        {
          text: "To reduce the elements of an array into a single value",
          correct: false,
        },
        {
          text: "To sort the elements of an array in descending order",
          correct: false,
        },
      ],
    },
    {
      question: "Which of the following is NOT a valid way to declare a variable in JavaScript?",
      answers: [
        {
          text: "let myVar = 10;",
          correct: false,
        },
        {
          text: "variable myVar = 10;",
          correct: true,
        },
        {
          text: "const myVar = 10;",
          correct: false,
        },
        {
          text: "var myVar = 10;",
          correct: false,
        },
      ],
    },
    {
      question: "What is the purpose of CSS pseudo-classes?",
      answers: [
        {
          text: "To select and style elements based on their position in the DOM",
          correct: false,
        },
        {
          text: "To select and style elements based on user interactions",
          correct: true,
        },
        {
          text: "To select and style elements based on their class names",
          correct: false,
        },
        {
          text: "To select and style elements based on their attributes",
          correct: false,
        },
      ],
    },
    {
      question: "What does the acronym AJAX stand for?",
      answers: [
        {
          text: "Asynchronous JavaScript and XML",
          correct: true,
        },
        {
          text: "Advanced JSON and XML",
          correct: false,
        },
        {
          text: "Asynchronous JavaScript and XHTML",
          correct: false,
        },
        {
          text: "All JavaScript and XML",
          correct: false,
        },
      ],
    },
    {
      question: "Which of the following is a valid way to include an external JavaScript file in an HTML document?",
      answers: [
        {
          text: "<script src='script.js'></script>",
          correct: true,
        },
        {
          text: "<javascript src='script.js'></javascript>",
          correct: false,
        },
        {
          text: "<js include='script.js'></js>",
          correct: false,
        },
        {
          text: "<link rel='stylesheet' href='script.js'>",
          correct: false,
        },
      ],
    },
    {
      question: "What is the purpose of the `localStorage` object in web browsers?",
      answers: [
        {
          text: "To store session-specific data that persists only until the browser is closed",
          correct: false,
        },
        {
          text: "To store data that can be accessed by any tab or window from the same origin",
          correct: true,
        },
        {
          text: "To store data on a remote server for long-term storage",
          correct: false,
        },
        {
          text: "To store data that is encrypted and secure",
          correct: false,
        },
      ],
    },
    {
      question: "What is the purpose of a CSS reset?",
      answers: [
        {
          text: "To remove all styles from an HTML document",
          correct: false,
        },
        {
          text: "To provide a consistent baseline of styles across different browsers",
          correct: true,
        },
        {
          text: "To add custom styles to HTML elements",
          correct: false,
        },
        {
          text: "To optimize CSS performance in web applications",
          correct: false,
        },
      ],
    },
    {
      question: "In JavaScript, what does the `typeof` operator return for an array?",
      answers: [
        {
          text: "'array'",
          correct: false,
        },
        {
          text: "'object'",
          correct: true,
        },
        {
          text: "'array'",
          correct: false,
        },
        {
          text: "'collection'",
          correct: false,
        },
      ],
    },
  ];
      
  
  const questionElement = document.getElementById("question");
  const answerElements = document.getElementById("answer-buttons");
  const nextButton = document.getElementById("next-btn");
  
  let currentQuestionIndex = 0;
  let score = 0;
  
  function startQuiz() {
    currentQuestionIndex = 0;
    score = 0;
    nextButton.innerHTML = "Next";
    showQuestion();
  }
  function showQuestion() {
    resetState();
    let currentQuestion = questions[currentQuestionIndex];
    let questionNumber = currentQuestionIndex + 1;
    questionElement.innerHTML = questionNumber + "." + currentQuestion.question;
    currentQuestion.answers.forEach((answer) => {
      const button = document.createElement("button");
      button.innerHTML = answer.text;
      button.classList.add("btn");
      answerElements.appendChild(button);
      if (answer.correct) {
        button.dataset.correct = answer.correct;
      }
      button.addEventListener("click", selectAnswer);
    });
  }
  
  function resetState() {
    nextButton.style.display = "none";
    while (answerElements.firstChild) {
      answerElements.removeChild(answerElements.firstChild);
    }
  }
  
  function selectAnswer(event) {
    const selectedBtn = event.target;
    const isCorrect = selectedBtn.dataset.correct === "true";
    if (isCorrect) {
      selectedBtn.classList.add("correct");
      score++;
    } else {
      selectedBtn.classList.add("incorrect");
    }
    Array.from(answerElements.children).forEach((button) => {
      if (button.dataset.correct == "true") {
        button.classList.add("correct");
      }
      button.disabled = true;
    });
    nextButton.style.display = "block";
  }
  
  function showScore() {
    resetState();
    questionElement.innerHTML = `You Scored ${score} out of ${questions.length}!`;
    nextButton.innerHTML = "Retake Quiz";
    nextButton.style.display ="block";
  }
  function handleNextBtn() {
    currentQuestionIndex++;
    if (currentQuestionIndex < questions.length) {
      showQuestion();
    } else {
      showScore();
    }
  }
  
  nextButton.addEventListener("click", () => {
    if (currentQuestionIndex < questions.length) {
      handleNextBtn();
    } else {
      startQuiz();
    }
  });
  
  startQuiz();
  