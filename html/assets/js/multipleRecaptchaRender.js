var recaptcha1;
var recaptcha2;
var multipleRecaptchaRender = function () {
    recaptcha1 = grecaptcha.render('human-confirmation', {'sitekey':'6LeajhATAAAAAEeSSdQ5capquuM1McWkuQwjqqEZ', 'theme':'light'});
    recaptcha2 = grecaptcha.render('human-confirmation-1', {'sitekey':'6LeajhATAAAAAEeSSdQ5capquuM1McWkuQwjqqEZ', 'theme':'light'});
}
