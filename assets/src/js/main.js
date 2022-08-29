const siteBody = document.getElementById('site-body').dataset.websiteUrl;
const currentPageCategory = document.getElementById('container-category').dataset.postCategory;
const inputElementsYear = document.getElementsByClassName('form-check-input-year');
const inputElementsSerie = document.getElementsByClassName('form-check-input-series');
const templateGrid = document.getElementById('template-grid-content');
const filterBtn = document.getElementById('filterBtn');
const numPosts = document.getElementById('num-posts');
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
        for(let post of posts.postData) {
            
            const column = document.createElement('div');
            column.classList.add('post');
            
            column.innerHTML = ` 
            <div class="card card-post" data-post-id="${post.id}">
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
function getDOMPosts() {
    postCard = document.getElementsByClassName('card-post');

    for(let post of postCard) {
        post.addEventListener('click', () => {
            console.log(post);
            const postID = post.dataset.postId;
            const singlePost =  fetchSinglePost(postID);
            singlePost.then(data => {
                if(data) {
                  console.log(data); 
                }
        
            }).catch(error => {
                console.log(error);
            });
        })
    }
}

async function fetchSinglePost(id) {  
    try {
        let response = await fetch(`${siteBody}/wp-json/apa/v1/posts/${id}`);
        let data = await response.json();
        return data;
    } catch(error) {
        console.log(error);
    }
}

document.addEventListener("DOMContentLoaded", getDOMPosts());

const mutationObserver = new MutationObserver( entries => {
    getDOMPosts();
});

mutationObserver.observe(templateGrid, {childList: true});


