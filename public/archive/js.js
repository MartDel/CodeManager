var openmodal = 0;
/**
 * Show a specific element
 * @param  {DOM element} element Element to show
 */
var show_modal = (element) => {
    element.style.display = "block";
    element.style.visbility = "visible";
    element.style.opacity = "1";
    element.style.animation = "0.6s ease 0s ModalComing";
    var www = element.getElementsByTagName("DIV")[0];
    www.style.animation = "0.9s linear 0s ModalComingBoth";
    //www.style.animation = "cubic-bezier(0.165, 0.840, 0.440, 1.000)";
    openmodal = 1;
};

/**
 * Don't show a specific element anymore
 * @param  {DOM element} element Element to erase
 */
var erase_modal = (element) => {
    element.style.animation = "0.6s ease 0s ModalLeaving";
    $(this).one(animationEvent,
        function() {
            element.style.display = 'none';
        });
    openmodal = 0;
};

let animationEvent = whichAnimationEvent();
function whichAnimationEvent() {
    const t,
        el = document.createElement("fakeelement");

    const animations = {
        "animation": "animationend",
        "OAnimation": "oAnimationEnd",
        "MozAnimation": "animationend",
        "WebkitAnimation": "webkitAnimationEnd"
    }

    for (t in animations) {
        if (el.style[t] !== undefined) {
            return animations[t];
        }
    }
}
