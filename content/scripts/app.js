var head = document.getElementsByTagName('head')[0];

var make = document.createElement('link');
make.setAttribute('tea', '/content/make.tea');

head.appendChild(make);

var script = document.createElement('script');
script.type = 'text/javascript';
script.src = '/vendor/boomyjee/teacss/lib/teacss.js';

head.appendChild(script);

var build = function () {
    teacss.build('/content/make.tea', {
        callback: function (files) {
            $.ajax({
                url: location.href,
                type: 'POST',
                data: {
                    js: files['/default.js'],
                    css: files['/default.css']
                },
                success: function (data) {
                    console.log(data);
                }
            });
        }
    });
}