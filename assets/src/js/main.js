const siteBody = document.getElementById('site-body').dataset.websiteUrl;
const currentPageCategory = document.getElementById('container-category').dataset.postCategory;
const inputElementsYear = document.getElementsByClassName('form-check-input-year');
const inputElementsSerie = document.getElementsByClassName('form-check-input-series');
const filterBtn = document.getElementById('filterBtn');
 
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

filterBtn.addEventListener('click', () => {
    const year = getCheckValues(inputElementsYear);
    const serie = getCheckValues(inputElementsSerie);

    async function fetchPosts() {
        
        try {
            let response = await fetch(`${siteBody}/wp-json/apa/v1/posts/${currentPageCategory}?year=${year}&serie=${serie}`);
            let data = await response.json();
            return data;
        } catch(error) {
            console.log(error);
        }
    }

    const filterdPosts = fetchPosts();
    filterdPosts.then(data => {
        if(data) {
            console.log(data);
        }

    }).catch(error => {
        console.log(error);
    });
})

