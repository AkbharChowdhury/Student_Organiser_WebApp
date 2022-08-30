let coursework_title = module_id_search = '';
const courseworkList = document.getElementById('courseworkList');
let page = 1; // for pagination

window.onload = loadCourseworkData(); // populate the product list

document.querySelector('#module_id_search').addEventListener('change', function() {
    module_id_search = this.value;
    page = 1;
    loadCourseworkData();
});

// live search bar
document.querySelector('#coursework_title').addEventListener('keyup', function() {
    coursework_title = this.value;
    page = 1;
    loadCourseworkData();
});

async function loadCourseworkData() {
    try {
        const response = await fetch('coursework_search.inc.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: new URLSearchParams({
                module_id_search: module_id_search,
                coursework_title: coursework_title,
                page: page,
            }),
        });

        const data = await response.text();
        courseworkList.innerHTML = data;
    } catch (error) {
        console.error(`There was a problem fetching the coursework list ${error.message}`);
    }
}

function getPage(pageNumber) {
    page = pageNumber;
    loadCourseworkData();
}
// used for modal
async function getProductID(productID, productName) {
    try {
        const response = await fetch('view_product.inc.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: new URLSearchParams({
                product_id: productID
            }),
        });
        const data = await response.text();

        document.querySelector('#productName').textContent = productName;
        document.querySelector('#productInfo').innerHTML = data;
    } catch (error) {
        console.error(
            `there was a problem fetching product details ${error.message}`
        );
    }
}