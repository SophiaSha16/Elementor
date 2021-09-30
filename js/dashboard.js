// Clear all session storagre in case we had something there
sessionStorage.clear();

var generateOnlineSection = async function () {
    var onlineSection = document.getElementById("onlineList");
    onlineSection.innerHTML = "";

    var usersJSON = await getAllUsers();

    usersJSON.forEach(user => {
        if (user.isOnline == true) {
            generateUserDiv(user)
            // cache user data
            sessionStorage.setItem("user id: " + user.email, JSON.stringify(user))
        }
    });

}


var getAllUsers = async function () {

    var getResp = await fetch('api/usersListHandler.php');
    var usersJSON = getResp.json();

    return usersJSON;
};


function generateUserDiv(user) {
    var newUserDiv = document.createElement('div');
    newUserDiv.setAttribute("class", "userCard");
    // usually I would have used user's ID that was AI by the DB, but in this case
    // I chose to use the only one-to-one property I had - the email
    newUserDiv.setAttribute("id", user.email);
    newUserDiv.setAttribute('onclick', 'showUserInfo(this.id);');

    var nameDiv = document.createElement('div');
    nameDiv.textContent = "Ueser's name is: " + user.name;

    var entranceTimeDiv = document.createElement('div');
    entranceTimeDiv.textContent = "Last entrance time: " + user.entranceTime;

    var lastUpdateDiv = document.createElement('div');
    lastUpdateDiv.textContent = "Last update time: " + user.lastUpdateTime;

    var IPDiv = document.createElement('div');
    IPDiv.textContent = "User's IP: " + user.IP;


    newUserDiv.appendChild(nameDiv);
    newUserDiv.appendChild(entranceTimeDiv);
    newUserDiv.appendChild(lastUpdateDiv);
    newUserDiv.appendChild(IPDiv);

    document.getElementById("onlineList").appendChild(newUserDiv);
}



// The data for this is supposed to be fetched on click
// but since I can only fetch all users at once
// I decided to use the cached data instead which refreshes every 3 seconds anyway
function showUserInfo(id) {
    let userInfo = JSON.parse(sessionStorage.getItem("user id: " + id));
    createModalContent(userInfo)

    initModal();
}

function createModalContent(userInfo) {
    var modalBody = document.getElementById("chosenUserInfo");
    modalBody.innerHTML = "";

    var nameDiv = document.createElement('div');
    nameDiv.textContent = "Ueser's name is: " + userInfo.name;

    var emailDiv = document.createElement('div');
    emailDiv.textContent = "Ueser's email is: " + userInfo.email;

    var userAgentDiv = document.createElement('div');
    userAgentDiv.textContent = "Ueser's agent is: " + userInfo.userAgent;

    var entranceTimeDiv = document.createElement('div');
    entranceTimeDiv.textContent = "User's entrance time: " + userInfo.entranceTime;

    var visitsCountDiv = document.createElement('div');
    visitsCountDiv.textContent = "The user entered the dashboard: " + userInfo.visitsCount + " times";


    modalBody.appendChild(nameDiv);
    modalBody.appendChild(emailDiv);
    modalBody.appendChild(userAgentDiv);
    modalBody.appendChild(entranceTimeDiv);
    modalBody.appendChild(visitsCountDiv);
}



function initModal() {
    var modal = document.getElementById("myModal");
    modal.style.display = "block";


    var span = document.getElementsByClassName("close")[0];
    span.onclick = function () {
        modal.style.display = "none";
    }

    // allows closing modal by clicking outside of it
    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
}


var autoUpdateOnline = setInterval(generateOnlineSection, 3000);


window.onbeforeunload = function () {
    fetch('api/logout.php');
}

