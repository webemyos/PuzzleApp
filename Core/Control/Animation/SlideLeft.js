function SlideLeft()
{
    this.control = "";

    this.Run = function(speed)
    {
        this.control.style.position = 'relative';
        this.control.style.margin = "0px";
        this.control.style.opacity = 1;
    };
};