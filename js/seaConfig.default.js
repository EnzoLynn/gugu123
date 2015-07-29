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
var global={};global.debug = false;
global.smPx = 992;
