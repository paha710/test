/**
 * Created by Павел on 01.04.2016.
 */
'use strict';

const request = require('request');
const cheerio = require('cheerio');

request('http://yandex.ru/', (error, response, body)=> {
    if (!error && response.statusCode == 200) {
        const $ = cheerio.load(body);
        let count_elem = $('#tabnews_newsc > ol > li').length;

        console.log('Новости Яндекса : ');
        for(let i = 0; i < count_elem; i++){
            console.log( '* ' +$('#tabnews_newsc > ol>li').eq(i).text());
        }

    }
});

