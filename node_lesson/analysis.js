/**
 * Created by Павел on 28.03.2016.
 */
'use strict';
const colors = require('colors');

const fs = require('fs');
let win = 0;
let loss = 0;
let max_win = 0;
fs.readFile('win.txt',(err,data)=>{
    if(err) throw err;
    let res = data.toString();
    let res_length = data.toString().length;
    for(let i = 0; i < res_length; i++){
        if(res[i]==0){
            win++;
        }else{
            loss++;
        }
    }
    console.log(
         "Количество игр : ".cyan+(loss+win)+"\n",
         "Количество побед : ".green +win+"\n",
         "Количество поражений : ".red+loss+"\n",
         "Отношение побед к поражениям :".grey+((win/loss).toFixed(2))+"\n"
    );
});

