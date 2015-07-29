<<<<<<< HEAD
seajs.config({
    base: "/",
    paths: {
        template: '/template',
        css: '/dist/css',
        modules:'/dist/seamodules'
    },
    alias: {
        "jquery": "/dist/seamodules/jquery.sea",
        "handlebars": "/dist/seamodules/handlebars-v3.0.3"
    },
    map: [
        [/^(.*\.(?:css|js))(.*)$/i, '$1?v=20150629']
    ],
    charset: 'utf-8'
});
var global={};global.debug = true;
global.smPx = 992;
=======
seajs.config({
    base: "/",
    paths: {
        template: '/template',
        css: '/dist/css',
        modules:'/dist/seamodules'
    },
    alias: {
        "jquery": "/dist/seamodules/jquery.sea",
        "handlebars": "/dist/seamodules/handlebars-v3.0.3"
    },
    map: [
        [/^(.*\.(?:css|js))(.*)$/i, '$1?v=20150629']
    ],
    charset: 'utf-8'
});
var global={};global.debug = true;
global.smPx = 992;
>>>>>>> 6b111090d3314d695f8afb9a03ff53a8c42bb551
