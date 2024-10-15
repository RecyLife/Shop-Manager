
async function getIsConnected() {
    const response = await fetch("api/is_connected.php");
    const isConnected = await response.json();
    const connectedUl = document.getElementById("connected");
    const notConnectedUl = document.getElementById("notConnected");
    console.log(isConnected.is_connected)
    if(isConnected.is_connected){
        connectedUl.style.display = "block";
    }else {
        notConnectedUl.style.display  = "block";
    }
}

getIsConnected();