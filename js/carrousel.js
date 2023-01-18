import { setCard, checkScreens, createCards } from './blurryImage.js';
import { sendCardQuery } from './connections.js';

let new_script = document.createElement('script');
new_script.setAttribute('src', './js/form.js');

document.head.appendChild(new_script); // Add New Script Tag..

const main = document.querySelector('main.content');

let savedCardsCollection = {};

let cardsCollection = document.querySelectorAll('div.card');
cardsCollection.forEach(node => {
    setCard(node)
    savedCardsCollection[node.getAttribute('data-display')] = node;
});


let loader = document.querySelector('.card__loader');


// ~ Query Bar Functionality ~
let queryBar = document.querySelector('.toolbar__search input');

queryBar.addEventListener('keydown', function(e) {
    let regex = /[A-Za-z]|Tab|Backspace/;

    if ( !regex.test(e.key) ) 
        e.preventDefault();
    
});

queryBar.addEventListener('keyup', function(e) {
    let query = this.value;
    const regEx = new RegExp(`^.*(${query}).*$`, 'i');
    let isEmpty = true;
        
    main.innerHTML = ''; 
    loader.classList.remove('hidden');

    for (const prop in savedCardsCollection) {
        if ( regEx.test(prop) ) {
            main.append( savedCardsCollection[prop] );
            isEmpty = false;
        }
    }

    if ( isEmpty && this.value != '' ) {
        
        sendCardQuery(query).then( message => {
            let data = JSON.parse(message);

            if ( data ) {
                let cards = createCards(data);
                cards.forEach( card => {
                    if ( !savedCardsCollection[ card['SITE_TITLE'] ] ) {
                        savedCardsCollection[ card['SITE_TITLE'] ] = card;
                        main.append(card);
                    }
                    else if ( savedCardsCollection[ card['SITE_TITLE'] ] ) {
                        console.log(`${card['SITE_TITLE']} Already Exists..`)
                    }
                    
                });

            } else {
                // main.append(teaseCard); <= SOON!
            }
            loader.classList.add('hidden');
        }).catch( err => console.log(err) );
    }

    else if ( this.value == '' ) {
        main.innerHTML = '';
        cardsCollection.forEach( card => {
            main.append(card);
        })
    }


});


// ~ Tease Modal Functionality...
let modal = document.querySelector('#modal');
let modalOverlay = document.querySelector('#modal-overlay');
let emailInput = modal.querySelector('.white-input');
let daForm = modal.querySelector('form');

    // Close Modal Function...
modalOverlay.addEventListener('click', function(e) {
    modal.classList.toggle('modal--visible');
});

emailInput.addEventListener('keydown', function(e) {
    let regex = /[a-zA-Z0-9]|Backspace|-|_|@|\.|/ig;

    if ( !regex.test(e.key) ) {
        e.preventDefault();
    }

});

    // Send Info...
daForm.addEventListener('submit', function(e) {
    e.preventDefault();

    let website = modal.querySelector('.website').innerHTML;
    let userEmail = emailInput.value;

    let request = new XMLHttpRequest();
    let data =  new FormData();

    data.append('__USER_QUEUE', '1');
    data.append('__FOR_WEBSITE', '1');
    data.append('__WEBSITE', website.toUpperCase());
    data.append('__EMAIL', userEmail.toLowerCase());

    request.open('POST', './pub.php');

    setTimeout( () => 
    {
        request.send(data);
    }, 3000 );
    
    
    request.onreadystatechange = () => {
        if ( request.readyState == 4 && request.status == 200 ) {
            modal.classList.toggle('modal--visible');
        }
    }
});



