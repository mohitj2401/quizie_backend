<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Result</title>
    <style>
        :root {
            --accent: white;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            padding: 0 1em;
            background-color: #f5f5f5;
        }

        .container {
            /* width: 100vw; */
            /* min-height: 100vh; */
        }

        .header {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .header .result {
            margin: 1em 0.5em;
            padding: 0.8em;
            background-color: var(--accent);
            border-radius: 999px;
        }

        .question {
            border-radius: 15px;
            background-color: var(--accent);
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            padding: 1em;
        }

        div.h2 {
            font-weight: bold;
        }

        div h3 {
            color: blue;
            margin: 0.2em;
            margin-bottom: 0;
        }

        .options-container {
            display: flex;
            margin-left: 0.2em;
        }

        .options-container .optionsCol {
            flex: 1;
            font-style: italic;
        }

        .optionsCol p {
            margin: 0.7em 0;
        }

        .answer {
            color: blue;
            margin-left: 0.2em;
        }

        .answer span {
            font-weight: bold;
        }

    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <span class="result">Correct</span>
            <span class="result">InCorrect</span>
            <span class="result">Attempted</span>
            <span class="result">Total</span>
        </div>
        <div class="question">
            <h2>What the hell</h2>
            <h3>Options</h3>
            <div class="options-container">
                <div class="optionsCol">
                    <p>a)</p>
                    <p>b)</p>
                </div>
                <div class="optionsCol">
                    <p>c)</p>
                    <p>d)</p>
                </div>
            </div>
            <p class="answer">Your Answer - ABC</p>
        </div>
    </div>
    <a href="/flutter/pdfview">DWm</a>
</body>

</html>
