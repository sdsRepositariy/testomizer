//Layot settings
var layoutSettings = {
    sidebarWidth: 270,
    breackpoint: 992,
    duration: 200,
    desktop: false
};

//Check if initial values stored in cookie, if so set initial state for
//desktop version.
var sidebarLeftPos = getCookie("sidebarLeftPos");
var navbarLeftPos = getCookie("navbarLeftPos");

if (window.innerWidth >= layoutSettings.breackpoint) { 
    if (sidebarLeftPos != null || navbarLeftPos != null) {
        var appStyleNode = document.createElement("style");

        var storedStyle  =  "@media (min-width: "+layoutSettings.breackpoint+"px) {"; 
        storedStyle     +=      ".app-sidebar {";
        storedStyle     +=          "left: "+sidebarLeftPos+"px;";
        storedStyle     +=      "}";
        storedStyle     +=      ".app-navbar, .app-container {";
        storedStyle     +=          "left: "+navbarLeftPos+"px;";
        storedStyle     +=      "}"; 
        storedStyle     +=  "}";

        var appStyleTextNode = document.createTextNode(storedStyle);

        appStyleNode.appendChild(appStyleTextNode);

        document.head.appendChild(appStyleNode);
    }

    layoutSettings.desktop = true;
}

function getCookie(name){
    var cook = document.cookie;
    var cookAr = cook.split("; ");
    var find = "";
    for (var i=0; i<cookAr.length; i++){
        if(cookAr[i].indexOf(name+"=")==0){
            find = decodeURIComponent(cookAr[i].slice(cookAr[i].indexOf("=")+1));
            break;
        }
    }
    return find;
}