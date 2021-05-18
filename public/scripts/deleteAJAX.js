let deleteButtons = document.querySelectorAll(".deleteBtn");
deleteButtons.forEach((button) => {
    button.addEventListener("click", async function (event){
        event.preventDefault();
      
        // console.log(button);

        let request = new XMLHttpRequest();
        request.open('GET', button.id ,true);
        request.responseType = 'json';
      
        request.onreadystatechange = function () {
            if (this.readyState === 4 && this.status === 200) {
                let response = request.response;
                // console.log(response);
                let redirect = response.redirect;
                if (redirect == "/account") {
                    window.location.replace(redirect);
                }
                else {
                    var row = button.parentElement.parentElement
                    row.remove();
                }
                console.log(redirect);
            }
        }
      
        request.send();
      });
})
