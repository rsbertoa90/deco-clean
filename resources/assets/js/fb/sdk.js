

window.fbAsyncInit = function () {
        FB.init({
            appId: '447979732292392',
            cookie: true,
            xfbml: true,
            version: 'v3.1'
        });

        FB.AppEvents.logPageView();

    };

(function (d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) {
        return;
    }
    js = d.createElement(s);
    js.id = id;
    js.src = "https://connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk')); 

var statusChangeCallback = (response) => {
    if (response.status == 'connected')
    {
        window.location.replace('/home');
    }
}

FB.getLoginStatus(function (response) {
    statusChangeCallback(response);
});