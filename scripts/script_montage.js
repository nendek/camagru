var canvas = document.querySelector("#canvas");
var displayCam = document.querySelector("#webcam");
var noDisplayCam = document.querySelector("#no_webcam");

var video = document.createElement('video');
var button = document.createElement('button');
var textButton = document.createTextNode("TAKE PICTURE");
var canvas = document.createElement('canvas');

var width = 510;
var height = 510;

var webcamAvailable = false;

displayCam.style.display = "none";
noDisplayCam.style.display = "none";

if (navigator.mediaDevices === undefined) {
	navigator.mediaDevices = {};
}

if (navigator.mediaDevices.getUserMedia === undefined) {
	navigator.mediaDevices.getUserMedia = function(constraints) {

		var getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia;

		if (!getUserMedia) {
			return Promise.reject(new Error('getUserMedia is not implemented in this browser'));
		}

		return new Promise(function(resolve, reject) {
			getUserMedia.call(navigator, constraints, resolve, reject);
		});
	}
}

navigator.mediaDevices.getUserMedia({ video: true })
	.then(streaming)
	.catch(videoErr);

function streaming(stream) {

	displayCam.style.display = "block";

	video.id = 'video';
	video.width = '612';
	video.height = '612';
	video.style = "max-width:100%;background:#111;border:1px solid #666";
	video.autoplay = true;

	button.classiName = 'button';
	button.appendChild(textButton);
	button.addEventListener('click', function(ev){
		reduceImage(video, imageResult => {
			if (!document.getElementById("image")) {
				document.getElementById("webcam").appendChild(imageResult);
			} else {
				old = document.getElementById("image");
				old.parentNode.replaceChild(imageResult, old);
			}
		});
		ev.preventDefault();
	}, false);

	canvas.id = 'canvas';

	document.getElementById("webcam").appendChild(video);
	document.getElementById("webcam").appendChild(button);

	if ("srcObject" in video) {
		video.srcObject = stream;
	} else {
		video.src = window.URL.createObjectURL(stream);
	}
	video.onloadedmetadata = function(e) {
		video.play();
		console.log('video play');
	};
}

function videoErr(err) {

	noDisplayCam.style.display = "block";

	document.getElementById("no_webcam").appendChild(
		selectImg(inputFile => {
			readImg(inputFile, img => {
				reduceImage(img, imageResult => {
					if (!document.getElementById("image")) {
						document.getElementById("no_webcam").appendChild(imageResult);
					} else {
						old = document.getElementById("image");
						old.parentNode.replaceChild(imageResult, old);
					}
					console.log(this.toString());
				});
			})
		})
	);

	console.log(err.name + ": " + err.message);
};

function selectImg(afterSelect) {
	var inputFile = document.createElement('input');

	inputFile.type = 'file';
	inputFile.className = 'button';
	inputFile.accept = 'image/*';
	inputFile.addEventListener('change', function () {
		if (afterSelect) {
			afterSelect(inputFile);
		}
	}, false );

	return inputFile;
};

function readImg(inputFile, afterConversion) {
	var reader = new FileReader();

	reader.addEventListener('load', function() {
		var img = document.createElement('img');

		img.addEventListener('load', function () {
			if (afterConversion) {
				afterConversion(img, reader);
			}
		});
		img.src = reader.result;
	});

	reader.readAsDataURL(inputFile.files[0]);
}

function reduceImage(imageSource, afterResizing) {
	var	imageResult = document.createElement('img'),
		context,
		widthImg = imageSource.width,
		heightImg = imageSource.height;

	imageResult.id = 'image';
	if (widthImg > heightImg) {
		if (widthImg > width) {
			heightImg *= width / widthImg;
			widthImg = width;
		}
	} else {
		if (heightImg > height) {
			widthImg *= height / heightImg;
			heightImg = height;
		}
	}
	if (widthImg < heightImg) {
		if (widthImg < width) {
			heightImg *= widthImg / width;
			widthImg = width;
		}
	} else {
		if (heightImg < height) {
			widthImg *= heightImg / height;
			heightImg = height;
		}
	}

	canvas.width = width;
	canvas.height = height;
	context = canvas.getContext('2d');
	context.drawImage(imageSource, 0, 0, width, height);
	imageResult.addEventListener('load', function () {
		afterResizing(imageResult, canvas);
	});

	imageResult.src = canvas.toDataURL('image/jpg', 0.8);
}

function takePicture() {

	canvas.width = width;
	canvas.height = height;
	canvas.getContext('2d').drawImage(video, 0, 0, width, height);
	var data = canvas.toDataURL('image/png');
	return img.setAttribute('src', data);
};


