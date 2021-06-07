
let refreshButton = document.querySelector('#refresh');
 
refreshButton.addEventListener('click', function() {
    document.querySelector('.captcha-image').setAttribute("src", "captcha.php");
});
