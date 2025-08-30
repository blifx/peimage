var __HTTP_HOST = window.location.protocol + "//" + window.location.hostname + "/"; 

function getParamURL(pName){
    var url = new URL(window.location.href);
    return url.searchParams.get(pName);
}