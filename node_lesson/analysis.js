/**
 * Created by Павел on 28.03.2016.
 */
'use strict';
const colors = require('colors');
const fs = require('fs');

//значения побед и поражений по умолчанию
let win = 0;
let loss = 0;

fs.readFile('log.txt', (err, data)=> {
    if (err) throw err;
    let res = data.toString();
    let res_length = data.toString().length;
    for (let i = 0; i < res_length; i++) {
        if (res[i] == 0) {
            win++;
        } else {
            loss++;
        }
    }
// функция возвращает мак.серии, v = значение победы или поражения
    function max_count(v) {

        // значения по умолчанию m = начальный символ, count = счетчик,
        // count_series = счетчик серии
        let m = res[0], count = '', count_series = 0;
        for (let i = 0, j = res_length; i < j; i++) {

            // если символ равен предыдущему и равен значению v,
            // увеличиваем счетчик на 1 и если он больше счетчика серии
            // увеличиваем счетчик серии на 1

            if ((res[i] == m) && res[i] == v) {
                count++;
                if (count > count_series) {
                    count_series++;
                }
            } else {
                // сбрасываем счетчик
                count = 1;
            }
            // присваеваем начальному символу текущее значение
            m = res[i];
        }
        return count_series;
    }

    console.log(
        "Количество игр : ".cyan + (loss + win) + "\n",
        "Количество побед : ".green + win + "\n",
        "Количество поражений : ".red + loss + "\n",
        "макс.серия побед :" + max_count(1) + "\n",
        "макс.серия поражений :" + max_count(0) + "\n",
        "Отношение побед к поражениям :".grey + ((win / loss).toFixed(2)) + "\n"
    );

});
