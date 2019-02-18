function FadeOut()
{
    this.control = "";
    this.callBack = "";

    this.Run = function(speed)
    {
        this.control.style.opacity = 1;
        this.interval = setInterval(data=>{this.Tick()}, speed);
    };

    this.Tick = function()
    {
        this.control.style.opacity = this.control.style.opacity - 0.1;
        
        if(this.control.style.opacity <= 0 )
        {
            window.clearInterval(this.interval);
            this.callBack();
        }
    };
};