var upload = function(){};

upload.doUpload = function()
{
    //Get The form
    var fileUpload = document.getElementById("fileUpload");
    var hdApp = document.getElementById("hdApp");
    var hdIdElement = document.getElementById("hdIdElement");
    var hdCallBack = document.getElementById("hdCallBack");
    var hdAction = document.getElementById("hdAction");
    var hdIdUpload = document.getElementById("hdIdUpload");


    var conteneur = fileUpload.parentNode;

    var formUpload = frUpload.contentWindow.document.getElementById('formUpload');

    //Add to the Form
    formUpload.appendChild(fileUpload);
    formUpload.appendChild(hdApp);
    formUpload.appendChild(hdIdElement);
    formUpload.appendChild(hdCallBack);
    formUpload.appendChild(hdAction);
    formUpload.appendChild(hdIdUpload);

    formUpload.submit();

    conteneur.appendChild(fileUpload);

    window.setTimeout(hdCallBack.value, 1000);
};
