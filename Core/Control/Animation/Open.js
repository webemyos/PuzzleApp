function Open()
{
    this.control = "";

    this.Run = function(speed, width, height)
    {
        this.width = width;
        this.height = height;
       
        this.control.style.display = "block";
     
        this.interval = setInterval(data=>{this.Tick()}, speed);

    };

    this.Tick = function()
    {
         controlWidth =  parseInt(this.control.style.width);
         controlHeight =   parseInt(this.control.style.height); 
   
        if(controlWidth <= this.width)
        {
           this.control.style.width = (controlWidth  + 10)  + "px";
        }

        if(controlHeight <= this.height)
        {
           this.control.style.height = (controlHeight  + 10 ) + "px";
        }

        if(controlWidth >= this.width && controlHeight >= this.height)
        {
            window.clearInterval(this.interval);
        }
    };
};