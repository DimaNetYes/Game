function styleClasses(cntGame) {
    let cnt = document.getElementsByClassName('content')[0];
    let check = 1;
    let endGame = true;
    cnt.addEventListener('click', function () {
        if (event.target.tagName !== 'SPAN') return;
        if(event.target.parentElement.id ==='secundomer') return; //Короче что бы таймер не считался
        if(!endGame) return;
        startStopwatch();
        let dataIndex = event.target.getAttribute('data-index');
        if (dataIndex == check) {
            event.target.classList.remove('spanErrorNone');
            event.target.classList.add('spanCheck'); //Добавление классов
            function displayNone(e) {
                e.classList.add('spanNone');
            }
            setTimeout(displayNone, 2000, event.target);
            check++;
        } else {
            event.target.classList.remove('spanErrorNone');
            event.target.classList.add('spanError');

            function errorNone(e) {
                e.classList.add('spanErrorNone');
                e.classList.remove('spanError');
            }

            setTimeout(errorNone, 1000, event.target);
        }

        if((cntGame + 1) == check){ //Помоему это работает при нажатии последнего числа
            endGame = false;
            stopStopwatch();
        }
    });
}





