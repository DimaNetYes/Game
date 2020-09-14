//Распределение цифр по полю
function newGame(cntRepeat) {
    function getRandomIntInclusive(min, max) {
        min = Math.ceil(min);
        max = Math.floor(max);
        return Math.floor(Math.random() * (max - min + 1)) + min; //Максимум и минимум включаются
    }

    let cnt = document.getElementsByClassName('content')[0];
    let arrW = [], arrH = [];

    for (let i = 1; i <= cntRepeat; i++) {
        let span = document.createElement('span');
        span.innerHTML = i;
        span.dataset.index = i;
                    //ШИРИНА И ВЫСОТА ОКНА С РАНДОМНЫМИ ЧИСЛАМИ
        arrW[i - 1] = getRandomIntInclusive(0, document.getElementsByClassName('content')[0].offsetWidth -35);  //cSS WIDTH
        arrH[i - 1] = getRandomIntInclusive(0, document.getElementsByClassName('content')[0].offsetHeight -25);  //CSS HEIGHT

        for (let w = 0; w + 1 < arrW.length; w++) {
            if (arrW[w] + 14 <= arrW[i - 1] || arrW[w] - 14 >= arrW[i - 1]) {
                var src = true;
            } else {
                // console.log("BADWW" + arrW[w] + " REALWW: " + arrW[i - 1] + " ЧИСЛО:" + i);
                for (let h = 0; h + 1 < arrH.length; h++) {
                    if (arrH[h] + 14 <= arrH[i - 1] || arrH[h] - 14 >= arrH[i - 1]) {

                    } else {
                        // console.log("BADH" + arrH[h] + " REALH: " + arrH[i - 1] + " ЧИСЛО:" + i);
                        var src = false;
                        break;
                    }
                }
                break;
            }
        }
        if (src !== false) {
            span.style = `left: ${arrW[i - 1]}px; top: ${arrH[i - 1]}px;`;
            cnt.appendChild(span);
        } else {
            i--;
        }
    }
}

    //ОТПРАВКА позиции POST в main.php, через form в script.php
// function positionSend(){
//     document.forms[0].getElementsByTagName('input')[0].value =  document.querySelector('.position').children[0].children[0].innerHTML;//position
// }