const siteBody = document.getElementById('site-body').dataset.websiteUrl;
const currentPageCategory = document.getElementById('container-category').dataset.postCategory;
const inputElementsYear = document.getElementsByClassName('form-check-input-year');
const inputElementsSerie = document.getElementsByClassName('form-check-input-series');
const filterBtn = document.getElementById('filterBtn');
const numPosts = document.getElementById('num-posts');

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
    const templateGrid = document.getElementById('template-grid-content');
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
            <div class="card">
                <div class="card-img-top" >
                    <a href="${post.link}">
                        ${post.thumbnail}
                    </a>
                    
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
    console.log(filterdPosts);
    filterdPosts.then(data => {
        if(data) {
           displayFilteredData(data); 
            console.log(data)
        }

    }).catch(error => {
        console.log(error);
    });
})

