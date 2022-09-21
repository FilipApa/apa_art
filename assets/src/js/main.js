const siteBody = document.getElementById( 'site-body' ).dataset.websiteUrl;
const currentPageCategory = document.getElementById( 'container-category' ).dataset.postCategory;

//for filter
const inputElementsYear = document.getElementsByClassName( 'form-check-input-year' );
const inputElementsSerie = document.getElementsByClassName( 'form-check-input-series' );
const templateGrid = document.getElementById( 'template-grid-content' );
const filterBtn = document.getElementById( 'filterBtn' );
const numPosts = document.getElementById( 'num-posts' );

//for modal
const modal = document.getElementById( 'post-modal' );
const postModalTitle = document.getElementById( 'post-modal-title' );
const postModalContent = document.getElementById( 'post-modal-content' );
const postModalSerie = document.getElementById('post-serie');
const postModalYear = document.getElementById( 'post-year' );
const postModalCloseBtn = document.getElementById( 'post-modal-close' );
const postModalPrevBtn = document.getElementById( 'post-modal-prev' );
const postModalNextBtn = document.getElementById( 'post-modal-next' );
const postCads = document.getElementsByClassName( 'card-post' );

//dropdown nav
const navDropdown = document.getElementById('nav-dropdown');

navDropdown.addEventListener('click', function() {
    showDropdown( '#nav-dropdown' );
});

//for load more
const loadMoreBtn = document.getElementById('post-load-more');
let postsPage = 1;

//for posts
let postCard;
let postsIds = [];
let serie = '';
let year = '';

//DROPDOWN
function showDropdown(target) {
    let targetElement = document.querySelector(`${target} + .dropdown`);
    targetElement.classList.toggle('show');
};

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

//GET POSTS
async function fetchPosts(p, y, s) {  
    try {
        let response = await fetch(`${siteBody}/wp-json/apa/v1/filter/${currentPageCategory}?page=${p}&year=${y}&serie=${s}`);
        console.log(`${siteBody}/wp-json/apa/v1/filter/${currentPageCategory}?page=${p}&year=${y}&serie=${s}`);
        let data = await response.json();
        return data;
    } catch( error ) {
        console.log( error );
    }
}

//DISPLAY POSTS
function displayPosts( posts ) {
    templateGrid.innerHTML = '';

    const getNumPosts = posts.total;
    numPosts.innerText = getNumPosts;

    const taxonomy = document.createElement( 'div' );
        for(let post of posts.postData) {
            const column = document.createElement( 'div' );
            column.classList.add( 'post' );
            
            column.innerHTML = ` 
            <div class="card">
                <div class="card-img-top" data-post-id="${post.id}" >
                    ${post.thumbnail}
                </div>
                <div class="card-body">
                    <h2 class="card-title">
                        ${post.title}
                    </h2>

                    <div>
                
                    ${post.year ? taxonomy.innerText = post.year : ''}
                  
                    ${post.serie ? taxonomy.innerText = post.serie : ''}

                    </div>
                </div>
            </div>    
            `; 
            templateGrid.appendChild( column );
        }
}

//SINGLE POST
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

function fetchDisplayPost( pId ) {
    const singlePost =  fetchSinglePost( pId );
    singlePost.then( data => {
        if( data ) {
            displaySinglePost( data );
        }

    }).catch( error => {
        console.log( error );
    });
}

//SET POSTS IDS TO STATE POST IDS
function getDOMPosts() {
    postCard = document.getElementsByClassName( 'card-img-top' );
        postsIds = [];
        for( let post of postCard ) {
        let postIds = {
            "pId" : post.dataset.postId
        }    
 
        postsIds.push( postIds );
    }

    for( let post of postCard ) {
        post.addEventListener( 'click', () => {
            const postID = post.dataset.postId;
            console.log(postID);
            fetchDisplayPost(postID);
        })
    }
}

// LOAD MORE POSTS
function loadMorePosts() {
    postsPage++;
    const posts = fetchPosts(postsPage, year, serie);
    posts.then( posts => {
        const taxonomy = document.createElement( 'div' );
        const pages = posts.pages;

        if(postsPage > pages) {
            loadMoreBtn.disabled = true;
            loadMoreBtn.innerText = 'No more posts'
        }else {
            loadMoreBtn.disabled = false;
            loadMoreBtn.innerText = 'Load more'
            for(let post of posts.postData) {
                const column = document.createElement( 'div' );
                column.classList.add( 'post' );
                
                column.innerHTML = ` 
                <div class="card">
                    <div class="card-img-top" data-post-id="${post.id}" >
                        ${post.thumbnail}
                    </div>
                    <div class="card-body">
                        <h2 class="card-title">
                            ${post.title}
                        </h2>
    
                        <div>
                    
                        ${post.year ? taxonomy.innerText = post.year : ''}
                      
                        ${post.serie ? taxonomy.innerText = post.serie : ''}
    
                        </div>
                    </div>
                </div>    
                `; 
                templateGrid.appendChild( column );
            }
        } 
    });
}

// EVENTS

// DOM CHANGES EVENTS
document.addEventListener("DOMContentLoaded", getDOMPosts());

const mutationObserver = new MutationObserver( entries => {
    getDOMPosts();
});

mutationObserver.observe( templateGrid, { childList: true });

// SINGLE POST EVENTS
postModalCloseBtn.addEventListener( 'click', () => {
    postModalContent.replaceChildren();
    modal.classList.remove( 'show' );
});

postModalPrevBtn.addEventListener('click', () => {
    let pId = postModalPrevBtn.dataset.postId;
    fetchDisplayPost( pId );
})

postModalNextBtn.addEventListener('click', () => {
    let pId = postModalNextBtn.dataset.postId;
    fetchDisplayPost( pId );
})

//FILTER POSTS EVENT
if(filterBtn) {
    filterBtn.addEventListener( 'click', () => {
        year = getCheckValues( inputElementsYear );
        serie = getCheckValues( inputElementsSerie );
        postsPage = 1;
        loadMoreBtn.disabled = false;
        loadMoreBtn.innerText = 'Load more'
        const filterdPosts = fetchPosts( postsPage, year, serie );
        
        filterdPosts.then( data => {
            if( data ) {
               displayPosts( data ); 
            }
    
        }).catch(error => {
            console.log( error );
        });
    });
}

//LOAD MORE EVENT
if(loadMoreBtn) {
    loadMoreBtn.addEventListener('click', () => {
        loadMorePosts();
    });
};

