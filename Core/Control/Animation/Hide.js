function Hide()
{
    this.control = "";

    this.Run = function(speed)
    {
        this.control.style.overflow = "hidden";
        this.interval = setInterval(data=>{this.Tick()}, speed);
    };

    this.Tick = function()
    {
        this.control.style.width = this.control.style.width.replace("px", "")  - 10  + "px";
        this.control.style.height = this.control.style.height.replace("px", "")  - 10  + "px";
    
        if(this.control.style.width.replace("px","") <= 0 && this.control.style.height.replace("px","") <= 0)
        {
            window.clearInterval(this.interval);
            this.control.style.display = "none";
        }
    };
};