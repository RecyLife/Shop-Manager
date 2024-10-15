
async function getProducts() {
    const response = await fetch("../api/products.php");
    const products = await response.json();
    if(products.length < 1){
        return
    }
    const productsTitles = Object.keys(products[0]);
    const productsTable = document.getElementById("productsTable");

    console.log(productsTitles)

    const tr = document.createElement("tr");
    let th;
    for (let i = 0; i < productsTitles.length; i++) {
        th = document.createElement("th");
        th.innerText = productsTitles[i];
        tr.appendChild(th);
    }
    productsTable.appendChild(tr);

    for (let i = 0; i < products.length; i++) {
        const tr = document.createElement("tr");

        for (let ii = 0; ii < productsTitles.length; ii++) {
            const th = document.createElement("th");
            th.innerText = products[i][productsTitles[ii]]
            tr.appendChild(th)
        }
        productsTable.appendChild(tr);
    }
}

getProducts();