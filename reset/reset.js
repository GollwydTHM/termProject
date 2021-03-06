window.onload = function () {
    document.querySelector("#btnInitial").addEventListener("click", initialState);
    document.querySelector("#btnPopulate").addEventListener("click", populatedState);
};

function initialState() {
    //set all database items and build the table
    let start = confirm("Are you sure you want to reset to initial status?");
    if (start == true) {
        let url = "initialState.php";
        let xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
                let resp = xmlhttp.responseText;
                console.log(resp);
                if (resp.search("ERROR") >= 0) {
                    alert("Error getting Database info");
                } else {
                    alert("database has been reset");
                }
            }
        };
        xmlhttp.open("POST", url, true);
        xmlhttp.send();
    }
}

function populatedState() {
    //set all database items and build the table
    let start = confirm("Are you sure you want to reset to populated status?");
    if (start == true) {
        let url = "populatedState.php";
        let xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
                let resp = xmlhttp.responseText;
                console.log(resp);
                if (resp.search("ERROR") >= 0) {
                    alert("Error getting Database info");
                } else {
                    alert("database has been populated");
                }
            }
        };
        xmlhttp.open("POST", url, true);
        xmlhttp.send();
    }
}