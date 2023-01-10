let width = 500,
	height = 0,
	filter = 'none',
	streaming = false;

const video = document.getElementById('video');
const canvas = document.getElementById('canvas');
const photos = document.getElementById('photos');
const photoButton = document.getElementById('photo-button');
const clearButton = document.getElementById('clear-button');
const photoFilter = document.getElementById('photo-filter');

navigator.mediaDevices.getUserMedia({video: true, audio: false}
	)
	.then(function(stream) {
		video.srcObject = stream;
		video.play();
	})
	.catch(function(err) {
		console.log(`Error: ${err}`)
	});
video.addEventListener('canplay', function(e) {
	if (!streaming)
	{
		height = video.videoHeight / (video.videoWidth / width);
		video.setAttribute('width', width);
		video.setAttribute('height', height);
		canvas.setAttribute('height', height);
		canvas.setAttribute('width', width);
		streaming = true;
	}
}, false);
function takePicture() {
	console.log('pic');
}
photoButton.addEventListener('click', function(e) {
	takePicture();
	e.preventDefault();
}, false);