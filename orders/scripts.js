
async function getOrders() {
    const response = await fetch("../api/orders.php");
    const products = await response.json();
    if(products.length < 1){
        return
    }
    const productsTitles = Object.keys(products[0]);
    const productsTable = document.getElementById("ordersTable");
    productsTable.innerHTML = "";
    console.log(productsTitles)

    tr = document.createElement("tr");
    let th;
    for (let i = 0; i < productsTitles.length; i++) {
        th = document.createElement("th");
        th.innerText = productsTitles[i];
        tr.appendChild(th);
    }
    th = document.createElement("th");
    th.innerText = "mark as done";
    tr.appendChild(th);

    th = document.createElement("th");
    th.innerText = "detail page";
    tr.appendChild(th);

    productsTable.appendChild(tr);

    for (let i = 0; i < products.length; i++) {
        const tr = document.createElement("tr");
        if(!products[i].done == 1 || !document.getElementById("showOnlyUndone").checked){
            for (let ii = 0; ii < productsTitles.length; ii++) {
                const th = document.createElement("th");
                th.innerText = products[i][productsTitles[ii]]
                tr.appendChild(th)
            }
    
            th = document.createElement("th");
            console.log(products[i].ID)
            th.innerHTML = `<a href='../api/order_done.php?id=${products[i].ID}'>mark as done/undone</a>`
            tr.appendChild(th)

            th = document.createElement("th");
            console.log(products[i].ID)
            th.innerHTML = `<a href='order?id=${products[i].ID}'>detail page<a>`
            tr.appendChild(th)
    
            productsTable.appendChild(tr);
        }

    }
}


getOrders();

document.getElementById("showOnlyUndone").addEventListener("change", ()=> getOrders())