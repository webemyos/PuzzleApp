var Animation = function(){};

/**
 * Hide à control
 * @param {*} controlId 
 * @param {*} speed 
 */
Animation.Hide = function(controlId, speed)
{
    var control = document.getElementById(controlId);
    
    var hide = new Hide();
        hide.control = control;
        hide.Run(speed);
};

/**
 * Open à control
 * @param {*} controlId 
 * @param {*} speed 
 * @param {*} width 
 * @param {*} height 
 */
Animation.Open = function(controlId, speed, width, height)
{
    var control = document.getElementById(controlId);
    
    var open = new Open();
        open.control = control;
        open.Run(speed, width, height);
};

/**
 * FadeOut à control
 * @param {*} controlId 
 * @param {*} speed 
 */
Animation.FadeOut = function(controlId, speed, callBack)
{
    var control = document.getElementById(controlId);
    
    var fadeOut = new FadeOut();
    fadeOut.control = control;
    fadeOut.callBack = callBack;
    fadeOut.Run(speed);
};

/**
 * FadeIn à control
 * @param {*} controlId 
 * @param {*} speed 
 */
Animation.FadeIn = function(controlId, speed)
{
    var control = document.getElementById(controlId);
    
    var fadeIn = new FadeIn();
    fadeIn.control = control;
    fadeIn.Run(speed);
};

/**
 * Affiche une notification
 */
Animation.Notify = function(message)
{
    var notification = new Notification();
        notification.Notify(message);
};


/**
 * SlideLeft à control
 * @param {*} controlId 
 * @param {*} speed 
 */
Animation.SlideLeft = function(controlId, speed)
{
    var control = document.getElementById(controlId);
    
    var sladeLeft = new SlideLeft();
    sladeLeft.control = control;
    sladeLeft.Run(speed);
};

/**
 * Open Top
 * @param {*} controlId 
 * @param {*} speed 
 */
Animation.OpenTop = function(controlId, height)
{
    var control = document.getElementById(controlId);
    
    var openTop = new OpenTop();
    openTop.control = control;
    openTop.Run(height);
};
