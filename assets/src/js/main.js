const siteBody = document.getElementById('site-body').dataset.websiteUrl;
const currentPageCategory = document.getElementById('container-category').dataset.postCategory;

const inputElementsYear = document.getElementsByClassName('form-check-input-year');
const inputElementsSerie = document.getElementsByClassName('form-check-input-series');

const templateGrid = document.getElementById('template-grid-content');
const filterBtn = document.getElementById('filterBtn');
const numPosts = document.getElementById('num-posts');

//modal
const modal = document.getElementById('post-modal');
const postModalTitle = document.getElementById('post-modal-title');
const postModalContent = document.getElementById('post-modal-content');
const postModalCloseBtn = document.getElementById('post-modal-close');
const postModalSerie = document.getElementById('post-serie');
const postModalYear = document.getElementById('post-year');
let postCard;

function getCheckValues(inputFields) {
    let counter = 0;
    const checkedValues = new Object;
    for (input of inputFields) {
        if(input.checked) {     
            checkedValues[counter] = input.value;   
            counter++;
        }
    }
    return JSON.stringify(checkedValues);
}

async function fetchPosts(p, y, s) {  
    try {
        let response = await fetch(`${siteBody}/wp-json/apa/v1/posts/${currentPageCategory}/${p}?year=${y}&serie=${s}`);
        let data = await response.json();
        return data;
    } catch(error) {
        console.log(error);
    }
}

function displayFilteredData(posts) {
    templateGrid.innerHTML = '';

    const row = document.createElement('div');
    row.classList.add('post-row');

    const getNumPosts = posts.total;
    numPosts.innerText = getNumPosts;

    const taxonomy = document.createElement('div');
    let counter = 0;
        for(let post of posts.postData) {
            const column = document.createElement('div');
            column.classList.add('post');
            
            column.innerHTML = ` 
            <div class="card card-post" id="exampleModal" data-post-id="${post.id}" data-prev-id="${counter === 0 ? null : posts.postData[counter - 1].id}" data-next-id="${counter === posts.postData.length-1 ? null : posts.postData[counter + 1].id}" data-bs-toggle="modal" data-bs-target="#exampleModal">
                <div class="card-img-top" >
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
            row.appendChild(column);
            counter++;
        }
    templateGrid.appendChild(row);
}

filterBtn.addEventListener('click', () => {
    const year = getCheckValues(inputElementsYear);
    const serie = getCheckValues(inputElementsSerie);
    const page = 1;
    const filterdPosts = fetchPosts(page, year, serie);

    filterdPosts.then(data => {
        if(data) {
           displayFilteredData(data); 
           console.log(data);
        }

    }).catch(error => {
        console.log(error);
    });

})

/**SINGLE POST**/
async function fetchSinglePost(id) {  
    try {
        let response = await fetch(`${siteBody}/wp-json/apa/v1/posts/${id}`);
        let data = await response.json();
        return data;
    } catch(error) {
        console.log(error);
    }
}

function getDOMPosts() {
    postCard = document.getElementsByClassName('card-post');

    for(let post of postCard) {
        post.addEventListener('click', () => {
            console.log(post);
            const postID = post.dataset.postId;
            const prevPostID = post.dataset.prevId ? post.dataset.prevId : null;
            const nextPostID = post.dataset.nextId ?post.dataset.nextId : null;

            const singlePost =  fetchSinglePost(postID);
            singlePost.then(data => {
                if(data) {
                    displaySinglePost(data, prevPostID, nextPostID);
                    console.log(data)
                }
        
            }).catch(error => {
                console.log(error);
            });
        })
    }
}

function displaySinglePost(data, prevID, nextID) {
    postModalTitle.innerText = data[0].title;

    const imgWrapper = document.createElement('div');
    imgWrapper.innerHTML = data[0].content;
    postModalContent.insertAdjacentElement('afterbegin', imgWrapper);

    postModalSerie.innerText = data[0].taxonomies[0].taxName;
    postModalYear.innerText = data[0].taxonomies[1].taxName;

    modal.classList.add('show');
}

// SINGLE POST EVENTS

document.addEventListener("DOMContentLoaded", getDOMPosts());

const mutationObserver = new MutationObserver( entries => {
    getDOMPosts();
});

mutationObserver.observe(templateGrid, {childList: true});

postModalCloseBtn.addEventListener('click', () => {
    modal.classList.remove('show')
})
