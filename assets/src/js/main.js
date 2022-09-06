const siteBody = document.getElementById( 'site-body' ).dataset.websiteUrl;
const currentPageCategory = document.getElementById( 'container-category' ).dataset.postCategory;

const inputElementsYear = document.getElementsByClassName( 'form-check-input-year' );
const inputElementsSerie = document.getElementsByClassName( 'form-check-input-series' );

const templateGrid = document.getElementById( 'template-grid-content' );
const filterBtn = document.getElementById( 'filterBtn' );
const numPosts = document.getElementById( 'num-posts' );

//modal
const modal = document.getElementById( 'post-modal' );
const postModalTitle = document.getElementById( 'post-modal-title' );
const postModalContent = document.getElementById( 'post-modal-content' );
const postModalSerie = document.getElementById('post-serie');
const postModalYear = document.getElementById( 'post-year' );
const postModalCloseBtn = document.getElementById( 'post-modal-close' );
const postModalPrevBtn = document.getElementById( 'post-modal-prev' );
const postModalNextBtn = document.getElementById( 'post-modal-next' );
const postCads = document.getElementsByClassName('card-post');
let postCard;
let postsIds = [];

function getCheckValues( inputFields ) {
    let counter = 0;
    const checkedValues = new Object;
    for ( input of inputFields ) {
        if( input.checked ) {     
            checkedValues[counter] = input.value;   
            counter++;
        }
    }
    return JSON.stringify( checkedValues );
}

async function fetchPosts(p, y, s) {  
    try {
        let response = await fetch(`${siteBody}/wp-json/apa/v1/posts/${currentPageCategory}/${p}?year=${y}&serie=${s}`);
        let data = await response.json();
        return data;
    } catch( error ) {
        console.log( error );
    }
}

function displayFilteredData( posts ) {
    templateGrid.innerHTML = '';

    const row = document.createElement( 'div' );
    row.classList.add( 'post-row' );

    const getNumPosts = posts.total;
    numPosts.innerText = getNumPosts;

    const taxonomy = document.createElement( 'div' );
    let counter = 0;
        for(let post of posts.postData) {
            const column = document.createElement( 'div' );
            column.classList.add( 'post' );
            
            column.innerHTML = ` 
            <div class="card card-post">
                <div class="card-img-top" data-post-id="${post.id}" >
                    ${post.thumbnail}
                </div>
                <div class="card-body d-flex justify-content-between align-items-center shadow bg-white rounded py-4">
                    <h2 class="card-title fw-semibold fs-4 ps-2 text">
                        ${post.title}
                    </h2>

                    <div>
                
                    ${post.year ? taxonomy.innerText = post.year : ''}
                  
                    ${post.serie ? taxonomy.innerText = post.serie : ''}

                    </div>
                </div>
            </div>    
            `; 
            row.appendChild( column );
            counter++;
        }
    templateGrid.appendChild( row );
}

if(filterBtn) {
    filterBtn.addEventListener( 'click', () => {
        const year = getCheckValues( inputElementsYear );
        const serie = getCheckValues( inputElementsSerie );
        const page = 1;
        const filterdPosts = fetchPosts( page, year, serie );
    
        filterdPosts.then( data => {
            if( data ) {
               displayFilteredData( data ); 
            }
    
        }).catch(error => {
            console.log( error );
        });
    });
}

/**SINGLE POST**/
async function fetchSinglePost( id ) {  
    try {
        let response = await fetch(`${siteBody}/wp-json/apa/v1/posts/${id}`);
        let data = await response.json();
        return data;
    } catch( error ) {
        console.log( error );
    }
}

function displaySinglePost( data ) {
    postModalTitle.innerText = data[0].title;
    postModalContent.replaceChildren();
    const imgWrapper = document.createElement( 'div' );
    imgWrapper.innerHTML = data[0].content;
    postModalContent.insertAdjacentElement( 'afterbegin', imgWrapper );

    postModalSerie.innerText = data[0].serie ? data[0].serie  : '';
    postModalYear.innerText = data[0].year ? data[0].year : '';
 
    let postId = data[0].id;
    postId = postId.toString();
    
    let count = 0;
    let prevId;
    let nextId;
    
 
    for(let post of postsIds) {
        if(postId === post.pId) {

        postsIds[count-1] ? prevId = postsIds[count-1].pId : prevId = null;
        postsIds[count+1] ? nextId = postsIds[count+1].pId : nextId = null;
        }

        count++;
    }

    if(prevId) {
        postModalPrevBtn.hidden = false;
        postModalPrevBtn.setAttribute('data-post-id', prevId );
    } else {
        postModalPrevBtn.hidden = true;
    }

    if(nextId) {
        postModalNextBtn.hidden = false;
        postModalNextBtn.setAttribute('data-post-id', nextId);

    } else {
        postModalNextBtn.hidden = true;
    }

    
    postModalNextBtn.setAttribute('data-post-id', nextId);

    if(!modal.classList.contains('show')) {
        modal.classList.add('show');
    }  
}

function comboFuncFetchDisplayPost( pId ) {
    const singlePost =  fetchSinglePost( pId );
    singlePost.then( data => {
        if( data ) {
            displaySinglePost( data );
        }

    }).catch( error => {
        console.log( error );
    });
}

function getDOMPosts() {
    postCard = document.getElementsByClassName( 'card-img-top' );

        for( let post of postCard ) {
        let postIds = {
            "pId" : post.dataset.postId
        }    
 
        postsIds.push( postIds );
    }

    for( let post of postCard ) {
        post.addEventListener( 'click', () => {
            const postID = post.dataset.postId;

            comboFuncFetchDisplayPost(postID);
        })
    }
}


// SINGLE POST EVENTS
document.addEventListener("DOMContentLoaded", getDOMPosts());

const mutationObserver = new MutationObserver( entries => {
    getDOMPosts();
});

mutationObserver.observe( templateGrid, { childList: true });

postModalCloseBtn.addEventListener( 'click', () => {
    postModalContent.replaceChildren();
    modal.classList.remove( 'show' );
});

postModalPrevBtn.addEventListener('click', () => {
    let pId = postModalPrevBtn.dataset.postId;
    comboFuncFetchDisplayPost( pId );
})

postModalNextBtn.addEventListener('click', () => {
    let pId = postModalNextBtn.dataset.postId;
    comboFuncFetchDisplayPost( pId );
})
