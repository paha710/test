/**
 * Created by Павел on 01.04.2016.
 */

'use strict';
const request = require('request');
const urlutils = require('url');
const url = 'https://translate.yandex.net/api/v1.5/tr.json/translate?';
const readline = require('readline');

const rl = readline.createInterface({
    input:process.stdin,
    output:process.stdout
});

rl.question('Введите слова для которого нужен перевод :',(word)=>{
    const params = urlutils.parse(url,true);
    delete params.search;
    params.query = {
        key: 'trnsl.1.1.20160401T044012Z.0810654dd11dc339.021be22c5a797427a989981e3f4fd1b8d9854217',
        text: word,
        lang: 'en-ru',
        format: 'plain'
    };
    const new_url = urlutils.format(params);

    request(new_url,(error,response,body)=>{
        if(!error && response.statusCode == 200){
            let res = JSON.parse(body);
           console.log(word +' => '+ res.text[0]);
        }
    });
rl.close();
});
