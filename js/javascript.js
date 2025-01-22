const cards = document.querySelectorAll('.card');

cards.forEach(card => {
    card.addEventListener('mouseenter', () => {
        card.style.transform = 'scale(1.05)';
        card.style.transition = 'transform 0.3s ease';
    });

    card.addEventListener('mouseleave', () => {
        card.style.transform = 'scale(1)';
    });
});

const btns = document.querySelectorAll('.btn');

btns.forEach(btn => {
    btn.addEventListener('mouseenter', () => {
        btn.style.transform = 'scale(1.05)';
        btn.style.transition = 'transform 0.3s ease';
    });

    btn.addEventListener('mouseleave', () => {
        btn.style.transform = 'scale(1)';
    });
});

const quizItems = document.querySelectorAll('.quiz-item');

quizItems.forEach(quizItem => {
    quizItem.addEventListener('mouseenter', () => {
        quizItem.style.transform = 'scale(1.05)';
        quizItem.style.transition = 'transform 0.3s ease';
    });

    quizItem.addEventListener('mouseleave', () => {
        quizItem.style.transform = 'scale(1)';
    });
});