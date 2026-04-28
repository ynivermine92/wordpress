Карточка тянулась под конетент ( все карточки были оденаковые вряд )
вряд один картчка будет оденаковая ( не зависемо от контента )

другой ряд будет отличатся ( будет ставиться по своей вывосте кто самый большой ряду )





Растягиваем li
.categories__item {
display: flex;
align-items: stretch;
}
Растягиваем карточку
.categories__item-box {
display: flex;
flex-direction: column;
width: 100%;
}
3. Контент должен тянуться
.categories__item-inner {
display: flex;
flex-direction: column;
flex: 1;
}
4. КЛЮЧЕВОЕ — прижать низ
.categories__wrapper-content {
margin-top: auto;
}



! если нужно будет глянуть hortiqa catalog.scss