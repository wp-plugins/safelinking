/**
* Safelinking javascript file (c) 2013 Safelinking.net
*/

var aObj;

function safelinking_initialise()
{
	var links = encodeURIComponent(document.getElementById("safelinking-links").value);
	if(links === "")
	{
		alert("Please specify some links to protect");
	}
	else
	{
        	request = safelinkingUrl + 'api?output=json&cookie-options=1&links-to-protect=' + links;
        	aObj = new JSONscriptRequest(request);
        	aObj.buildScriptTag();
        	aObj.addScriptTag();
	}
}

window.addEventListener('load', safelinking_user_init, false);

function safelinking_user_init() {
	request = safelinkingUrl + 'api?mode=getLoggedInUser&callback=userLogin';
    aObj = new JSONscriptRequest(request);
    aObj.buildScriptTag();
    aObj.addScriptTag();
}

function userLogin(json) {
	var html;
	if(json.loggedIn) {
		html = '(Logged in as <a href="' + safelinkingUrl + 'ucp">' + json.username + '</a>)';
	} else {
		html = ' - <a href="' + safelinkingUrl + 'login" target="_blank">Login to ' + safelinkingName+ '</a>';
	}
	document.getElementById('safelinking-user').innerHTML = html;
	aObj.removeScriptTag();
}

function callbackfunc(jsonData) 
{
	if(jsonData.p_links != null && jsonData.p_links != "")
	{
		if(document.getElementById("comment") != null)
		{
			document.getElementById("comment").value += '\n<a href="' + jsonData.p_links + '">' + jsonData.p_links + '</a>';
		}
		else if(document.getElementById("content_ifr") != null)
		{
			document.getElementById("content_ifr").contentWindow.document.getElementsByTagName("body")[0].innerHTML += "<a href='" + jsonData.p_links + "'>" + jsonData.p_links + "</a>";
		}
		else
		{
			document.getElementById("content").value += '\n<a href="' + jsonData.p_links + '">' + jsonData.p_links + '</a>';
		}
		document.getElementById("safelinking-links").value = "";
	}
	else
	{
		alert("There was an error protecting your links.");
	}
	aObj.removeScriptTag();
}


//Thanks to http://www.xml.com/pub/a/2005/12/21/json-dynamic-script-tag.html
function JSONscriptRequest(fullUrl) 
{
    this.fullUrl = fullUrl; 
    this.noCacheIE = '&noCacheIE=' + (new Date()).getTime();
    this.headLoc = document.getElementsByTagName("head").item(0);
    this.scriptId = 'JscriptId' + JSONscriptRequest.scriptCounter++;
}

JSONscriptRequest.scriptCounter = 1;

JSONscriptRequest.prototype.buildScriptTag = function () 
{
        this.scriptObj = document.createElement("script");
        this.scriptObj.setAttribute("type", "text/javascript");
        this.scriptObj.setAttribute("charset", "utf-8");
        this.scriptObj.setAttribute("src", this.fullUrl + this.noCacheIE);
        this.scriptObj.setAttribute("id", this.scriptId);
}
 
JSONscriptRequest.prototype.removeScriptTag = function () 
{
	this.headLoc.removeChild(this.scriptObj);  
}


JSONscriptRequest.prototype.addScriptTag = function () 
{
	this.headLoc.appendChild(this.scriptObj);
}