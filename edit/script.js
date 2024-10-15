function findGetParameter(parameterName) {
    var result = null,
        tmp = [];
    var items = location.search.substring(1).split("&");
    for (var index = 0; index < items.length; index++) {
        tmp = items[index].split("=");
        if (tmp[0] === parameterName) result = decodeURIComponent(tmp[1]);
    }
    return result;
}

async function getCategories() {
    const response = await fetch("../api/categories.php");
    const categories = await response.json();
    const categorySelector = document.getElementById("categorySelector");
    console.log(categories)
    for (let i = 0; i < categories.length; i++) {
        const optionElement = document.createElement("option");
        optionElement.innerText = categories[i].title
        optionElement.value = categories[i].ID
        categorySelector.appendChild(optionElement)
        console.log(categorySelector)
        
    }
}

async function addDefaultsValues(){
    const id = findGetParameter("id");
    const response = await fetch("../api/product.php?id=" + id);
    const product = await response.json();
    
    document.getElementById("titleInput").value = product.title;
    document.getElementById("priceInput").value = product.price;
    document.getElementById("quantityInput").value = product.quantity;
    document.getElementById("categorySelector").value = product.category_ID

    for (let i = 0; i < product.specifications.length; i++) {
        addSpecification(product.specifications[i].title, product.specifications[i].value_)
    }

}

function addSpecification(defaultTitle, defaultValue) {
    const specificationTitleInput = document.createElement("input");
    const specificationValueInput = document.createElement("input");
    
    specificationTitleInput.placeholder = "Specification title"
    specificationTitleInput.value = defaultTitle ?? ""
    specificationTitleInput.classList.add("specificationTitleInput")
    console.log(defaultValue);
    specificationValueInput.value = defaultValue ?? ""
    specificationValueInput.placeholder = "Specification value"
    specificationValueInput.classList.add("specificationValueInput")


    const specificationDiv = document.getElementById("specifications")
    specificationDiv.appendChild(specificationTitleInput)
    specificationDiv.appendChild(specificationValueInput)
    specificationDiv.appendChild(document.createElement("br"))
}

getCategories().then(() => {
    addDefaultsValues();
});

