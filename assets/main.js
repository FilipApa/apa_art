const container = document.getElementById('container');
const websiteURl = container.dataset.websiteUrl;
const postCategory = container.dataset.postCategory;
const filterPostBtn = document.getElementById("filterBtn");
const inputCheckYear = document.getElementsByClassName("form-check-input-year");
const inputCheckSeries = document.getElementsByClassName("form-check-input-series");

console.log(websiteURl);
console.log(postCategory);

async function fetchCategoryPosts() {
    let response = await fetch(`${websiteURl}/wp-json/wp/v2/categories?slug=${postCategory}`);
    let data = await response.json();
    let catID = data[0].id;
    let getCatPost = await fetch(`${websiteURl}/wp-json/wp/v2/posts?categories=${catID}`);
    let catData = await getCatPost.json();
    console.log(catData);
    let taxArray = catData.map(post => post.taxonomy)

    console.log(taxArray)

}

fetchCategoryPosts();