/**
 * Created by Павел on 28.03.2016.
 */
'use strict';
const colors = require('colors');

const fs = require('fs');
let win = 0;
let loss = 0;
fs.readFile('win.txt', (err, data)=> {
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

    function max_count(v) {
        let m = res[0], count = '', count_win = 0;
        for (let i = 0, j = res_length; i < j; i++) {
            if ((res[i] == m) && res[i] == v) {
                count++;
                if (count > count_win) {
                    count_win++;
                }
            } else {
                count = 1;
            }
            m = res[i];
        }
        return count_win;
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
