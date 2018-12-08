//
// Preload images
//
var images = [];
function preload_images() {
    for (var i = 0; i < arguments.length; i++) {
        images[i] = new Image();
        images[i].src = preload_images.arguments[i];
    }
}
preload_images(
	"https://nimipet.com/img/nimipet-birth.gif",
	"https://nimipet.com/img/nimipet-dead.gif",
)

//
// Preload sounds
//
var sounds = [];
function preload_sounds() {
    for (var i = 0; i < arguments.length; i++) {
        sounds[i] = new Audio();
        sounds[i].src = preload_sounds.arguments[i];
    }
}
preload_sounds(
	"https://nimipet.com/fx/born.mp3",
	"https://nimipet.com/fx/fed.mp3",
	"https://nimipet.com/fx/food-ready.mp3",
	"https://nimipet.com/fx/grab.mp3",
)