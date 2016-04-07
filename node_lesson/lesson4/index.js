/**
 * Created by Павел on 04.04.2016.
 */
'use strict';

const request = require('request');
const cheerio = require('cheerio');
const express = require('express');
const app = express();
const cookieParser = require('cookie-parser');
const session = require('express-session');
app.use(cookieParser());
app.use(session({
    secret: 'keyboard cat',
    saveUninitialized:true,
    resave:true
}));

const bodyParser = require('body-parser');
app.use(bodyParser.json());
const templating = require('consolidate');

app.engine('hbs', templating.handlebars);
app.set('view engine', 'hbs');
app.set('views', __dirname + '/views');

app.get('/', (req, res)=> {
    res.render('index');

});

app.use(bodyParser.urlencoded({extended: false}));


app.post('/news', (req, res)=> {
    function request_brauser(address, selector, title) {
        request(address, (error, response, body)=> {
            if (!error && response.statusCode == 200) {
                const $ = cheerio.load(body);
                let count_elem = $(selector).length;
                for (let i = 0; i < count && i < count_elem; i++) {
                    news[i] = $(selector).eq(i).text();
                }
            }
            res.render('index', {
                name: title,
                news: news
            });
        });
    }

    let cat = req.body.news;
    let count = req.body.count_news;
    let news = [];
    if (cat == 'yandex') {
        let address = 'http://news.yandex.ru';
        let selector = '.story';
        let title = 'Новости Yandex.ru';
        request_brauser(address, selector, title);
    } else if (cat === 'ria') {
        let address = 'http://ria.ru';
        let selector = '.day_news_items_row';
        let title = 'Новости RIA';
        request_brauser(address, selector, title);
    } else if (cat == 'life') {
        let address = 'http://lifenews.ru/';
        let selector = '.publication';
        let title = 'Новости LifeNews';
        request_brauser(address, selector, title);
    }
});


app.listen(5000);

