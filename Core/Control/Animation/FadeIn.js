function FadeIn()
{
    this.control = "";

    this.Run = function(speed)
    {
        this.control.style.opacity = 1;
        //this.interval = setInterval(data=>{this.Tick()}, speed);
    };

    this.Tick = function()
    {
        this.control.style.opacity = parseFloat(this.control.style.opacity) + 0.1;
        
        if(this.control.style.opacity >= 1 )
        {
            window.clearInterval(this.interval);
        }
    };
};