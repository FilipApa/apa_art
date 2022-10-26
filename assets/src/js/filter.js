const siteBody = document.getElementById( 'site-body' ).dataset.websiteUrl;
const currentPageCategory = document.getElementById( 'page-category' ).dataset.postCategory;

//for filter
const inputElementsYear = document.getElementsByClassName( 'form-check-input-year' );
const inputElementsSerie = document.getElementsByClassName( 'form-check-input-series' );
const templateGrid = document.getElementById( 'template-grid-content' );
const numPosts = document.getElementById( 'num-posts' );
const filterBtn = document.getElementById( 'filterBtn' );

const filterDropBtn = document.getElementById( 'filter-section' );
const filterYearBtn = document.getElementById( 'filter-year' );
const filterSerieBtn = document.getElementById( 'filter-series' );

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

//for load more
const loadMoreElement = document.getElementById('load-more-element');
const loadMoreBtn = document.getElementById('post-load-more');

//for reset
const resetBtn = document.getElementById('resetBtn');

//for posts
let postsPage = 1;
let postCard;
let postsIds = [];
let serie = '';
let year = '';

//GET CHECKED VALUES
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

    const hash = '#';
    const taxonomy = document.createElement( 'div' );

        if(Array.isArray(posts.postData) && posts.postData.length ) {

            for(let post of posts.postData) {
                const column = document.createElement( 'div' );
                column.classList.add( 'post' );
    
                column.innerHTML = ` 
                <div class="card">
                    <div class="card-img-top" style="background-image:url(${post.thumbnail})" data-post-id="${post.id}" ></div>
                    <div class="card-body">
                        <h2 class="card-title">
                            ${post.title}
                        </h2>
    
                        <div>
                        <span class="card-tag">
                            ${post.year ? taxonomy.innerText = hash + post.year : ''}
                        </span>
    
                        <span class="card-tag">
                            ${post.serie ? taxonomy.innerText = hash + post.serie : ''}
                        </span>
                        </div>
                    </div>
                </div>    
                `; 
                templateGrid.appendChild(column);
            }
        } else {
            const message = document.createElement( 'span' );
            message.classList.add('posts-error-message');
            message.innerText = "Sorry no posts available";
            templateGrid.appendChild(message);
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
    console.log(postsIds)
    console.log(prevId);
    console.log(nextId)

    if(prevId) {
        postModalPrevBtn.style.visibility = "visible";
        postModalPrevBtn.setAttribute('data-post-id', prevId );
        console.log(true)
    } else {
        postModalPrevBtn.style.visibility = "hidden";
    }

    if(nextId) {
        postModalNextBtn.style.visibility = "visible";
        postModalNextBtn.setAttribute('data-post-id', nextId);

    } else {
        postModalNextBtn.style.visibility = "hidden";
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
            loadMoreBtn.innerText = 'No more pictures'
        }else {
            loadMoreBtn.disabled = false;
            loadMoreBtn.innerText = 'Load more'
            for(let post of posts.postData) {
                const column = document.createElement( 'div' );
                column.classList.add( 'post' );
                
                column.innerHTML = ` 
                <div class="card">
                    <div class="card-img-top" style="background-image:url(${post.thumbnail})" data-post-id="${post.id}" ></div>
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
                templateGrid.appendChild(column);
            }
        } 
    });
}

// EVENTS

// DOM CHANGES EVENTS
document.addEventListener("DOMContentLoaded", getDOMPosts());

const mutationObserver = new MutationObserver( () => {
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

//RESET POSTS
if(resetBtn) {
    resetBtn.addEventListener( 'click', () => {
        postsPage = 1;
        loadMoreBtn.disabled = false;
        loadMoreBtn.innerText = 'Load more'
        const filterdPosts = fetchPosts( postsPage, '', '' );
        
        filterdPosts.then( data => {
            if( data ) {
               displayPosts( data ); 
            }

            [...inputElementsYear].forEach(element => {
                element.checked = false;
            });

            [...inputElementsSerie].forEach(element => {
                element.checked = false;
            });
    
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

//DROPDOWN FILTER

if(filterDropBtn) {
    filterDropBtn.addEventListener('click', function() {
        showDropdown( '#filter-section' );
    });
}

if(filterYearBtn) {
    filterYearBtn.addEventListener('click', function() {
        showDropdown( '#filter-year' );
    });
}

if(filterSerieBtn) {
    filterSerieBtn.addEventListener('click', function() {
        showDropdown( '#filter-series' );
    });
}




