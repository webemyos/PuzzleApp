var upload = function(){};

upload.doUpload = function()
{
    //Get The form
    var fileUpload = document.getElementById("fileUpload");

    if(fileUpload.value != '')
    {

        var hdApp = document.getElementById("hdApp");
        var hdIdElement = document.getElementById("hdIdBaseElement");
        var hdIdElement = document.getElementById("hdIdElement");
        var hdCallBack = document.getElementById("hdCallBack");
        var hdAction = document.getElementById("hdAction");
        var hdIdUpload = document.getElementById("hdIdUpload");
        var uploadLoading = document.getElementById("uploadLoading");

        if(uploadLoading != undefined)
        {
            uploadLoading.style.display='block';
        }

        var conteneur = fileUpload.parentNode;
        if(hdIdElement == null)
        {
            var token = hdIdElement.value + Math.round(Math.random() *100);
            hdIdElement.value = token;
        }

        var formUpload = frUpload.contentWindow.document.getElementById('formUpload');

        //Add to the Form
        formUpload.appendChild(fileUpload);
        formUpload.appendChild(hdApp);
        formUpload.appendChild(hdIdElement);
        formUpload.appendChild(hdCallBack);
        formUpload.appendChild(hdAction);
        formUpload.appendChild(hdIdUpload);

        formUpload.submit();

    
        //On Remet les controle pour un autre envoir
        var dvUpload = document.getElementById("dvUpload");

        if(dvUpload != undefined)
        {
            fileUpload.value = "";
            dvUpload.appendChild(fileUpload);
            dvUpload.appendChild(hdApp);
            dvUpload.appendChild(hdIdElement);
            dvUpload.appendChild(hdCallBack);
            dvUpload.appendChild(hdAction);
            dvUpload.appendChild(hdIdUpload);
        }

        setTimeout(function(){
            if(uploadLoading != undefined)
            {
                uploadLoading.style.display='none';
            //On affiche l'image télécharger
        var uploadImages = document.getElementById("uploadImages");
            uploadImages.innerHTML += "<img style='width:100px'  src='../Data/Tmp/"+hdIdElement.value+".jpg' /> ";
        }    }
        , 1000);

        window.setTimeout(hdCallBack.value, 1000);
    }
};
