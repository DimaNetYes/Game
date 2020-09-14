//СЕКУНДОМЕР

// <fieldset>
//     <legend>Stop Watch</legend>
//     <a href="#" id="start" onclick="startStopwatch()">Start</a>&nbsp;
//
//     <a href="#" id="stop" onclick="stopStopwatch()">Stop</a>&nbsp;
//
//     <a href="#" id="reset" onclick="resetStopwatch()">Reset</a>&nbsp;
//
//     <span id="s_minutes">00</span>:
//     <span id="s_seconds">00</span>:
//     <span id="s_ms">000</span>
// </fieldset>

    let offset = 0,
        paused = true;

    function startStopwatch(evt) {
        if (paused) {
            paused = false;
            offset -= Date.now();
            render();
        }
    }

    function stopStopwatch(evt) {
        if (!paused) {
            paused = true;
            offset += Date.now();
        }
    }

    function resetStopwatch(evt) {
        offset = 0;
        paused = true;
        render();
    }

    function format(value, scale, modulo, padding) {
        value = Math.floor(value / scale) % modulo;
        return value.toString().padStart(padding, 0);
    }

    function render() {
        var value = paused ? offset : Date.now() + offset;

        document.querySelector('#s_ms').textContent = format(value, 1, 1000, 3);
        document.querySelector('#s_seconds').textContent = format(value, 1000, 60, 2)  + " :";
        document.querySelector('#s_minutes').textContent = format(value, 60000, 60, 2)  + " :";



        if(!paused) {
            requestAnimationFrame(render);
        }else{
                //Это отправка времени. К секундомеру не имеет отношения
            let s = document.getElementById('secundomer');
            let arr = [];
            for(let el of s.children){
                arr.push(el.innerHTML.split(":").join(''));  //min, sec, ms
            }

            AJAX('http://mvcgame/www/games/fastDigit', 'POST', arr);
        }
    }

    render();

function AJAX (url, method, data) {
    var xhr = new XMLHttpRequest();
    xhr.open(method, url, true);
            //POST[data]
    // let inp = document.forms[0].elements[0];  //input hidden
    // inp.value = data;
    data = 'time=' + encodeURIComponent(data); //POST[time]

    xhr.onload = function(){
        if(xhr.readyState === 4 && xhr.status === 200){
                     //Позиция игрока с учетом текущего времени
            let jsonPosFirst = this.responseText.indexOf('{');
            let jsonPosLast = this.responseText.indexOf('}');
            let playerPosition = this.responseText.slice(jsonPosFirst+13, jsonPosLast).trim(); // Вырезали число позиции игрока


            // location.href = "http://mvcgame/www/delete";
                    //HTML STYLES
            let info = document.getElementById('info');
            info.style = "display:flex;";
            let positionClass = document.getElementsByClassName('position')[0];
            positionClass.innerHTML = "<span class='signature'>Place: #<p>" + playerPosition + "</p></span>";

                //Это назначение кнопок Repeat и OK
            let repeat = document.getElementById('repeat');
            let ok = document.getElementById('ok');

            repeat.addEventListener('click', function(){
                location.reload();
            });

            // ok.addEventListener('click', function(){
                // location = "http://mvcgame/www/users/main";
            // });

            // console.log(xhr.responseText);
        }else{
            console.log("Ошибка в secundomer.js, AJAX отправки");
        }
    };
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.send(data);
};