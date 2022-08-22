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

    console.log(`${siteBody}/wp-json/apa/v1/posts/${currentPageCategory}?year=${year}&serie=${serie}`)
    async function fetchPosts() {
        let response = await fetch(`${siteBody}/wp-json/apa/v1/posts/${currentPageCategory}?year=${year}&serie=${serie}`);
        let data = await response.json();
        console.log(data);
        return data;
    }

    fetchPosts();

})

