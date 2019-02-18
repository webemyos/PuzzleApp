Request = function(){};

/*
* Send the Request Return Promise
*/
Request.Send = function(method, url, data)
{
    return new Promise(function (resolve, reject) {
    var xhr = new XMLHttpRequest();

    xhr.open(method, url);
    xhr.setRequestHeader("content-type", "application/x-www-form-urlencoded; charset=UTF-8");

    xhr.onload = function () {
      if (this.status >= 200 && this.status < 300) {
        resolve(xhr.response);
      } else {
        reject({
          status: this.status,
          statusText: xhr.statusText
        });
      }
    };
    xhr.onerror = function () {
      reject({
        status: this.status,
        statusText: xhr.statusText
      });
    };
    
    if(data != undefined)
    {
      xhr.send(data);
    }
    else
    { 
      xhr.send();
    }
  });
};

/*
 * Send A Get Request
 */
Request.Get = function(url) {

    return Request.Send('Get', url);
};

/*
* Send A Post Request
*/
Request.Post = function(url, data){

  return Request.Send('Post', url, data);
};  
