// index.php coding part.
if ( document.querySelector('.toolbar__search input') ) {
    let toolbar = document.querySelector('.toolbar__search input')
    toolbar.addEventListener('focus', (event) => {
        if( event.path )
            event.path[1].classList.add('toolbar--focused');
        else 
            event.target.parentElement.classList.add('toolbar--focused');
    });
    
    toolbar.addEventListener('blur', (event) => {
        // console.log(event)
        if( event.path ) 
            event.path[1].classList.remove('toolbar--focused');
        else 
            event.target.parentElement.classList.remove('toolbar--focused');
    });
}

// reclaim.php coding part.
if ( document.querySelector('#id__order') ) {
    let emailBar = document.querySelector('#email');

    emailBar.addEventListener('keydown', function(e) {
        let regex = /[A-Za-z0-9]|_|-|@|\.|Backspace|Tab/;
        
        if ( !regex.test(e.key) ) {
            e.preventDefault();
        }
    });

    emailBar.addEventListener('focusout', function(e) {
        let data = this.value;
        let regex = /([[A-Za-z0-9]|_|-|]){4,22}\@([A-Za-z]){3,10}\.([A-Za-z]){2,5}(\.([A-Za-z]){2,5})?/i

        if ( !regex.test(data) ) {
            this.isValid = false;
        }
        else {
            this.isValid = true;
        }
    });

    let submitButton = document.querySelector('#send');

    submitButton.addEventListener('click', function(e) {
        e.preventDefault();

        if ( emailBar.isValid && orderBar.isValid && option.checked ) {
            let promise = new Promise( function(resolve, reject ) 
            {
                const request = new XMLHttpRequest();
                const data = new FormData();

                data.append('__PUT', '1');
                data.append('__RECLAIM', '1');
                data.append('__ID', orderBar.value.toUpperCase());
                data.append('__EMAIL', emailBar.value.toLowerCase());
                data.append('__IP', hiddenOption.value);

                request.open('POST', './pub.php');
                request.send(data);
                
                request.onloadstart = function(e) {
                    emailBar.disabled = 'true';
                    orderBar.disabled = 'true';
                    submitButton.disabled = 'true';
                }

                request.ontimeout = function(e) {
                    emailBar.disabled = 'false';
                    orderBar.disabled = 'false';
                    submitButton.disabled = 'false';
                }

                request.onreadystatechange = function(e) {
                    if ( this.readyState == 4 && this.status == 200 ) {
                        setTimeout(function() {
                            location.href = location.pathname + '?show_completion_dialog=1';
                        }, 30000);
                    }

                }
            });
        }
    });

    let orderBar =  document.querySelector('#id__order');
    orderBar.addEventListener('keydown', function(e) {
        let regex = /[A-Fa-f0-9]|-|Backspace|Tab|X/i;
        
        if ( !regex.test(e.key) ) {
            e.preventDefault();
        }
    });

    orderBar.addEventListener('focusout', function(e) {
        let data = this.value;
        let regex = /X[A-Fa-f0-9]{2}-[A-Fa-f0-9]{5}/i

        if ( !regex.test(data) ) {
            this.isValid = false;
        }
        else {
            this.isValid = true;
        }
    });

    let option = document.querySelector('input[name="email__agreement"]');

    let hiddenOption = document.querySelector('input[name="XAX"]');
}





let checkBoxes = document.querySelectorAll('input[type="checkbox"]');
checkBoxes.forEach( box => {
    if ( box.parentElement.classList.contains('check_statement') ) 
        box.addEventListener('change', function(e) {
            if ( e.returnValue ) 
                this.parentElement.classList.toggle('row--onfocus');
            else 
                this.parentElement.classList.toggle('row--onfocus');
        });
});


