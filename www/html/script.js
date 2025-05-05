const articles = document.querySelectorAll('.article'); 
const leftArrow = document.querySelector('.left-arrow');
const rightArrow = document.querySelector('.right-arrow');

let currentIndex = 1; 

function updateHighlight() {
    articles.forEach((article, index) => {
        const relativeIndex = (index - currentIndex + articles.length) % articles.length;

        article.classList.remove('highlighted');
        article.style.opacity = '0.5';
        article.style.transform = 'scale(1)';
        article.style.order = relativeIndex; 

        if (relativeIndex === 1) {
            article.classList.add('highlighted');
            article.style.opacity = '1';
            article.style.transform = 'scale(1.3)';
        }
    });
}

function moveLeft() {
    currentIndex = (currentIndex - 1 + articles.length) % articles.length; 
    updateHighlight();
}

function moveRight() {
    currentIndex = (currentIndex + 1) % articles.length;
    updateHighlight();
}

// Připojení funkcí k šipkám
leftArrow.addEventListener('click', moveLeft);
rightArrow.addEventListener('click', moveRight);

updateHighlight();

/*Výpočet:
Odečte od aktuálního indexu (index) index prostředního článku (currentIndex)
přičte délku pole článků a použije operaci modulo (%), aby zůstala výsledná hodnota v rozsahu od 0 do articles.length - 1.



Praktický příklad:
A:(0, -1 + 3) % 3 = 2
B:(1, -1 + 3) % 3 = 0
C:(2, -1 + 3) % 3 = 1
To znamená že článek B bude zvýrazněn.*/
