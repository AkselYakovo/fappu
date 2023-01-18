
export function checkScreens(collection, nodeViewport) {
    let parent = nodeViewport.getBoundingClientRect();
    // let offset = 0.25;
    collection.forEach( node => {
        let coords = node.getBoundingClientRect();
        let width = coords.right - coords.left;
        let center =  coords.left + parseInt(width / 2);
        // console.log(parent.right);
        if ( center <= parent.right && !node.active) {
            node.active = true;
            let img = node.querySelector('img.screen__picture');
            img.src = img.getAttribute('data-display');
            let logoimg = node.querySelector('.subsite__logo img');
            logoimg.src = logoimg.getAttribute('data-display');
        }
    })
}


export function setCard(node) {
    let phaseControls = node.querySelectorAll('.content__slidder');
    node.phase = 0; // Initial Phase.

    // Carrousel Phases Handler.
    phaseControls.forEach( phaseNode => {
        phaseNode.addEventListener('click', function(e) {
            switch (node.phase) {
                case 0:
                    phaseControls[0].classList.remove('content__slidder--active');
                    phaseControls[1].classList.add('content__slidder--active');
                    node.classList.toggle('card--second-phase');
                    node.phase = 1;
                    break;
            
                case 1:
                    phaseControls[1].classList.remove('content__slidder--active');
                    phaseControls[0].classList.add('content__slidder--active');
                    node.classList.toggle('card--second-phase');
                    node.phase = 0;
                    break;

                default:
                    console.error('Something Went Broken In Card Component.');
                    break;
            }

        });
    });

    // Buy Button Handler.
    let buyButton = node.querySelector('.content__buybutton');
    buyButton.addEventListener('click', function(e) {
        let disabled = this.classList.contains('button--disabled');
        
        if ( !disabled ) {
            let siteTitle = node.getAttribute('data-display') || 'none';
            let teaseModal = document.querySelector('#modal');
            let teasePicture = `../fappu_admin/assets/teasepics/${siteTitle}.jpg`;
            teaseModal.classList.add('modal--visible');
            teaseModal.classList.remove('modal--hide');
            teaseModal.style.backgroundImage = `url(${teasePicture})`;
            teaseModal.querySelector('.website').innerHTML = siteTitle;
        }

        else {}
    })

    // Carousel Handler.
    let carousel = node.querySelector('.carrousel__pictures');
    let carrouselControls = node.querySelectorAll('.carrousel__control');
    carrouselControls.forEach( controlNode => {
        controlNode.addEventListener('click', function(e) {
            if ( !this.classList.contains('carrousel__control--active') ) {
                let pos = this.getAttribute('data-display');
                node.querySelector('.carrousel__control--active').classList.remove('carrousel__control--active');
                carrouselControls[pos - 1].classList.add('carrousel__control--active');
                carousel.style.transform = `translateX(${ -(carousel.parentElement.offsetWidth * (pos - 1)) }px)`;
                carrouselIndex = pos - 1;
            }
        });
    });
    // let carrouselIndex = 0;

    // ~ Carousel Lazy Load ~
    let carrouselPictures = carousel.querySelectorAll('img');
    const options = {
        root: null,
        threshold: 0.5,
        rootMargin: '50px'
    };
    const carrouselObserver = new IntersectionObserver( function(entries, observer) 
    { 
        entries.forEach( entry => { 
            if ( entry.isIntersecting ) {
                carrouselPictures.forEach( picture => picture.src = picture.getAttribute('data-display') );
                // observer.unobserve(entry);
            }
        })
    }, options );
    carrouselObserver.observe(node);

    // Parent Element And Available Viewport.
    let screensWrap = node.querySelector('.subsites__screens'); // Screens Strip.
    let screensViewport = node.querySelector('.card__subsites');
    let screensCollection = node.querySelectorAll('.subsites__screen');
    //screensCollection.forEach( node => node.active = false );


    // ~ Screens Drag Functionality ~
    screensWrap.addEventListener('mousedown', function(event) {
        let actualPos = {
            X: event.pageX,
            Y: event.pageY
        };
        let transformString = this.style.transform.replace(/\s/g, '\n');
        actualPos.translate = ( /translateX/i.test(this.style.transform) ) 
                              ? transformString.replace(/^((?!translateX\(-?\d{1,5}px\)).)*$/g, '')
                              : 'translateX(0px)';
        // Extract Integer out of the 'Translate' css property.
        let initial = Number.parseInt(actualPos.translate.replace(/(?!-?\d)./g, ''));
        let totalPath = screensWrap.offsetWidth - screensViewport.offsetWidth;
        
        document.onmousemove =  function(e) {
            let newPos = {
                X: (actualPos.X - e.pageX ),
                Y: (actualPos.Y - e.pageY )
            };
            let finalPos =  -( newPos.X - initial );
            
            // Screen's Wrap is on initial position.
            if ( finalPos >= 0 ) {
                screensWrap.style.transform = `translateX(0)px`;    
            }
            // Screen's Wrap is gliding.
            else if ( -(finalPos) >= totalPath ) {
                screensWrap.style.transform = `translateX(${ -totalPath }px)`;
            }
            else {
                screensWrap.style.transform = `translateX(${ finalPos }px)`;
            }

            // Lazy Load Magick!
            checkScreens(screensCollection, node.querySelector('.card__subsites'));
        };

    });
    
    document.addEventListener('mouseup', function(e) {
        document.onmousemove = null;
    })
}



export function createCards(objs) {
    let cards = [];

    for(let i in objs) 
    {
        let card = document.createElement('div');
        card.classList.add('card');
        
        let carrouselImages = '';
        for(let index of [1,2,3]) 
            carrouselImages += `<figure>
                                    <img src="../fappu_admin/assets/thumbs/${objs[i]['SITE_CODE']}/blur/${objs[i]['SITE_TITLE']}_${index}.jpg" 
                                    alt="${objs[i]['SITE_TITLE']} Promotional Picture #${index}" 
                                    data-display="../fappu_admin/assets/thumbs/${objs[i]['SITE_CODE']}/${objs[i]['SITE_TITLE']}_${index}.jpg"; ">
                                </figure>
                                `;

        let screensArray = objs[i]['CHILDREN'].split('/');
        let screens = '';
        for(let screen of screensArray)
            screens += `
                        <figure class="subsites__screen">
                            <img class="screen__picture" src="../fappu_admin/assets/screens/${objs[i]['SITE_CODE']}/blur/${screen}.jpg" alt="${screen} Included Website Picture"
                            data-display="../fappu_admin/assets/screens/${objs[i]['SITE_CODE']}/${screen}.jpg" draggable="false">
                            <figure class="subsite__logo">
                                <img src="../fappu_admin/assets/subsites_logos/${objs[i]['SITE_CODE']}/blur/${screen}.png" alt="${screen} LOGO"
                                data-display="../fappu_admin/assets/subsites_logos/${objs[i]['SITE_CODE']}/${screen}.png" draggable="false">
                            </figure>
                        </figure>
                    `;

        card.innerHTML = `
                        <div class="card__carrousel">
                            <div class="carrousel__pictures">
                                ${carrouselImages}
                            </div>
                            <div class="carrousel__controls">
                                <figure class="carrousel__control carrousel__control--active" data-display="1"></figure>
                                <figure class="carrousel__control" data-display="2"></figure>
                                <figure class="carrousel__control" data-display="3"></figure>
                            </div>
                        </div>

                        <div class="card__content">
                            <header class="content__header">
                                <h2 class="content__sitecode">${objs[i]['SITE_CODE']}</h2>
                                <span class="content__link">${objs[i]['SITE_URL']}</span>
                            </header>
                            <div class="content__price">
                                <h3 class="content__subtitle">PRECIO ORIGINAL:</h3>
                                <span class="content__montlyprice">$${objs[i]['ORIGINAL_PRICE']}.00 MXN/MES</span>
                            </div>
                            <div class="content__price content__price--emphazised">
                                <h3 class="content__subtitle">NUESTRA OFERTA:</h3>
                                <span class="content__montlyprice">$${objs[i]['OFFER_PRICE']}.00 MXN/MES</span>
                            </div>
                            <button class="content__buybutton" type="button">COMPRAR</button>
                            <div class="content__slidders">
                                <figure class="content__slidder content__slidder--active"></figure>
                                <figure class="content__slidder"></figure>
                            </div>
                        </div>

                        <div class="card__subsites">
                            <small class="subsites__subtitle">SITIOS INCLUIDOS:</small>

                            <div class="subsites__screens">
                                ${screens}
                            </div>
                        </div>

                        <figure class="card__status"></figure>
                        </div>
                        `;
        setCard(card);
        card['SITE_TITLE'] = objs[i]['SITE_TITLE'];
        cards.push(card);
    }

    return cards;
}