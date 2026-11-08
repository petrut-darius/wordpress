import { createRoot, useState } from "@wordpress/element";
import "./frontend.scss";
import { useEffect } from "react";

document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll(".paying-attention-update-me")
        .forEach((div) => {
            const root = createRoot(div);
            const data = JSON.parse(div.querySelector("pre").innerHTML);

            root.render(<Quiz {...data} />);

            div.classList.remove("paying-attention-update-me");
        });
});

function Quiz(props) {
    const [isCorrect, setIsCorrect] = useState(undefined);
    const [isCorrectDelayed, setIsCorrectDelayed] = useState(undefined);

    useEffect(() => {
        if(isCorrect === false) {
            setTimeout(() => setIsCorrect(undefined), 2600);
        }

        if(isCorrect === true) {
            setTimeout(() => setIsCorrectDelayed(true), 1000);
        }
    }, [isCorrect]);

    function handleAnswer(index) {
        if(index == props.correctAnswer) {
            setIsCorrect(true);
        }else{
            setIsCorrect(false);
        }
    }

    return (
        <div className="paying-attention-frontend" style={{backgroundColor: props.bgColor, textAlign: props.alingment}}>
            <p>{props.question}</p>
            <ul>
                {props.answers.map((answer, index) => {
                    return (
                        <li className={(isCorrectDelayed === true && index === props.correctAnswer ? "no-click" : "") + (isCorrectDelayed === true && index !== props.correctAnswer ? "fade-incorrect" : "")} onClick={isCorrect === true ? undefined : () => handleAnswer(index)}>
                            {isCorrectDelayed === true && index === props.correctAnswer && (
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" className="bi bi-check" viewBox="0 0 16 16">
                                    <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425z"/>
                                </svg>
                            )}
                            {isCorrectDelayed === true && index !== props.correctAnswer && (
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" className="bi bi-x-lg" viewBox="0 0 16 16">
                                    <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z"/>
                                </svg>
                            )}
                            {answer}
                        </li>
                    );
                })}
            </ul>
            <div className={"correct-message" + (isCorrect ? " correct-message--visible" : "")}>
                <p>That is correct!</p>
            </div>
            <div className={"incorrect-message" + (isCorrect === false ? " incorrect-message--visible" : "")}>
                <p>Sorry, try again!</p>
            </div>
        </div>
    );
}