
async function getProducts() {
    const response = await fetch("../api/products.php");
    const products = await response.json();
    if(products.length < 1){
        return
    }
    const productsTitles = Object.keys(products[0]);
    const productsTable = document.getElementById("productsTable");

    console.log(productsTitles)

    tr = document.createElement("tr");
    let th;
    for (let i = 0; i < productsTitles.length; i++) {
        th = document.createElement("th");
        th.innerText = productsTitles[i];
        tr.appendChild(th);
    }
    th = document.createElement("th");
    th.innerText = "product page";
    tr.appendChild(th);

    th = document.createElement("th");
    th.innerText = "edit page";
    tr.appendChild(th);

    th = document.createElement("th");
    th.innerText = "remove product";
    tr.appendChild(th);

    productsTable.appendChild(tr);

    for (let i = 0; i < products.length; i++) {
        const tr = document.createElement("tr");

        for (let ii = 0; ii < productsTitles.length; ii++) {
            const th = document.createElement("th");
            th.innerText = products[i][productsTitles[ii]]
            tr.appendChild(th)
        }
        let th = document.createElement("th");
        th.innerHTML = `<a href="https://shop.recytech.me/detail?id=${products[i].ID}">product page</a>`
        tr.appendChild(th)

        th = document.createElement("th");
        console.log(products[i].ID)
        th.innerHTML = `<a href='../edit?id=${products[i].ID}'>edit</a>`
        tr.appendChild(th)

        th = document.createElement("th");
        console.log(products[i].ID)
        th.innerHTML = `<a href='../api/remove_product.php?id=${products[i].ID}'>remove</a>`
        tr.appendChild(th)

        productsTable.appendChild(tr);
    }
}

getProducts();