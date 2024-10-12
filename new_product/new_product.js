
async function addCategories() {
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

function addSpecification(defaultTitle, defaultValue) {
    const specificationTitleInput = document.createElement("input");
    const specificationValueInput = document.createElement("input");
    
    specificationTitleInput.placeholder = "Specification title"
    specificationTitleInput.value = defaultTitle ?? ""
    specificationTitleInput.classList.add("specificationTitleInput")

    specificationValueInput.value = defaultValue ?? ""
    specificationValueInput.placeholder = "Specification value"
    specificationValueInput.classList.add("specificationValueInput")


    const specificationDiv = document.getElementById("specifications")
    specificationDiv.appendChild(specificationTitleInput)
    specificationDiv.appendChild(specificationValueInput)
    specificationDiv.appendChild(document.createElement("br"))
}

function onFormSubmit() {
    const specificationsResultInput = document.getElementById("specificationsResult");
    const specificationsValuesInputs = document.getElementsByClassName("specificationValueInput")
    const specificationsTitlesInputs = document.getElementsByClassName("specificationTitleInput")

    let result = [];
    
    for (let i = 0; i < specificationsTitlesInputs.length; i++) {
        result.push({"title": specificationsTitlesInputs[i].value, "value": specificationsValuesInputs[i].value})
    }
    
    specificationsResultInput.value = JSON.stringify(result)

}

addCategories();

const DEFAULT_SPECIFICATIONS = ["Famille de processeur", "Mémoire vive", "Capacité SSD", "Fréquence du processeur", "Nombre de cœurs de processeur", ]

for (let i = 0; i < DEFAULT_SPECIFICATIONS.length; i++) {
    addSpecification(DEFAULT_SPECIFICATIONS[i]);
    
}