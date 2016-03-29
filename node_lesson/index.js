/**
 * Created by Павел on 26.03.2016.
 */

'use strict';
const beep = require('beepbeep');
beep();

const colors = require('colors');

const readline = require('readline');

const  rl = readline.createInterface({
    input: process.stdin,
    output: process.stdout
});

const fs = require('fs');

rl.question('Введите ваше имя :',(answer)=>{
    console.log('Привет,' + answer.yellow);

    rl.setPrompt('Введи число "1" или "2" (exit чтобы выйти) :');
    rl.prompt();

    rl.on('line',(number)=>{
        const random_number = Math.ceil(Math.random()*2);
        if(number == random_number){
            fs.appendFile('log.txt',1,(err)=>{
                if(err) throw err;
                console.log('Вы выиграли!'.green);
            });
        }else if(number.toLocaleLowerCase().trim() === 'exit'){
                rl.close();
        }

        else{
            fs.appendFile('log.txt',0,(err)=>{
                if(err) throw err;
                console.error('Вы проиграли!'.red);
            });
        }

    });

});


