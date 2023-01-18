let forms = document.querySelectorAll('form');
forms.forEach( form => {
    form.addEventListener('submit', function(e) {
        e.preventDefault();
    });
})


let selection = document.querySelector('.form-selection-wrapper');

selection.addEventListener('click', function(e) {
    this.classList.toggle('menu-opened');
});

let options = selection.querySelectorAll('.option-list > li');

options.forEach( node => 
{
    node.addEventListener('click', function(e) {
        selection.querySelector('input').value = node.innerHTML;
        selection.setAttribute('data-display', node.getAttribute('data-display'));
    });
});

let emailBar = document.querySelector('input#email');

emailBar.addEventListener('keydown', function(e) {
    let regex = /[A-Za-z0-9]|_|-|@|\.|Backspace|Tab/;
    
    if ( !regex.test(e.key) ) {
        e.preventDefault();
    }
});

let textarea = document.querySelector('textarea');

textarea.addEventListener('keydown', function(e) {
    let regex = /[A-Za-z0-9]|Backspace|Tab|\s|\.|\,/;
    
    if ( e.ctrlKey || !regex.test(e.key) ) {
        e.preventDefault();
    }
});

let submitButton = document.querySelector('button[type="submit"]');

submitButton.addEventListener('click', function(e) {
    let email_flag = /([[A-Za-z0-9]|_|-|]){4,22}\@([A-Za-z]){3,10}\.([A-Za-z]){2,5}(\.([A-Za-z]){2,5})?/i;
    let message_flag = /\s{3}/ig;
    let category = selection.getAttribute('data-display');

    if ( email_flag.test(emailBar.value) 
         && !message_flag.test(textarea.value) 
         && textarea.textLength > 12
         && textarea.textLength <= 140
         && category ) 
    {
        const request = new XMLHttpRequest();
        const data = new FormData();

        data.append('__PUT', '1');
        data.append('__MESSAGE', '1');
        data.append('__EMAIL', emailBar.value.toLowerCase());
        data.append('__CAT', category.toUpperCase());
        data.append('__MSG', textarea.value);

        request.open('POST', './pub.php');
        request.send(data);
        
        request.onloadstart = function(e) {
            emailBar.disabled = 'true';
            textarea.disabled = 'true';
            submitButton.disabled = 'true';
        }

        request.ontimeout = function(e) {
            emailBar.disabled = 'false';
            orderBar.disabled = 'false';
            submitButton.disabled = 'false';
        }

        request.onreadystatechange = function(e) {
            if ( this.readyState == 4 && this.status == 200 ) {
                setTimeout(() => {
                    location = location.href.substr( 0, location.href.indexOf('?') ) + '?message-received-confirmation=true';
                }, 10000);
            }

        }
    }

    else {
        console.log('not fully valid');
    }
});



