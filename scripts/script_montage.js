var displayCam = document.querySelector("#webcam");
var noDisplayCam = document.querySelector("#no_webcam");

var video = document.createElement('video');
var button = document.createElement('button');
var textButton = document.createTextNode("TAKE PICTURE");
var canvas = document.createElement('canvas');
var send = document.createElement('button');
var textSend = document.createTextNode("SAVE MONTAGE");

var width = 510;
var height = 510;

displayCam.style.display = "none";
noDisplayCam.style.display = "none";

canvas.id = 'canvas';
canvas.width = width;
canvas.height = height;

send.className = 'button';
send.appendChild(textSend);


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

	button.className = 'button';
	button.appendChild(textButton);
	button.addEventListener('click', function(ev){
		reduceimg(video, imgResult => {
			if (!document.getElementById("img")) {
				displayCam.appendChild(imgResult);
				displayCam.appendChild(send);
			} else {
				old = document.getElementById("img");
				old.parentNode.replaceChild(imgResult, old);
			}
		});
		ev.preventDefault();
	}, false);


	displayCam.appendChild(video);
	displayCam.appendChild(button);


	if ("srcObject" in video) {
		video.srcObject = stream;
	} else {
		video.src = window.URL.createObjectURL(stream);
	}
	video.onloadedmetadata = function(e) {
		video.play();
		console.log('video play');
	};

	send.addEventListener('click', function(ev) {
		uploadImg({
			url: "none",
			img: document.getElementById("img")
		}, function (error, response) {
			var data = document.createElement('div');
			data.textContent = (error) ? error : response;
			displayCam.appendChild(data);
			displayCam.appendChild(imageResult);
		});
	});
}

function videoErr(err) {

	noDisplayCam.style.display = "block";

	noDisplayCam.appendChild(
		selectImg(inputFile => {
			readImg(inputFile, img => {
				reduceimg(img, imgResult => {
					if (!document.getElementById("img")) {
						noDisplayCam.appendChild(imgResult);
					} else {
						old = document.getElementById("img");
						old.parentNode.replaceChild(imgResult, old);
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

function reduceimg(imgSource, afterResizing) {
	var	imgResult = document.createElement('img'),
		context,
		widthImg = imgSource.width,
		heightImg = imgSource.height;

	imgResult.id = 'img';
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

	context = canvas.getContext('2d');
	context.drawImage(imgSource, 0, 0, width, height);
	imgResult.addEventListener('load', function () {
		afterResizing(imgResult, canvas);
	});

	imgResult.src = canvas.toDataURL('image/jpg', 0.8);
}

function uploadImg(options, afterUploading) {
	var xhr = new XMLHttpRequest(),
		formData = new FormData();
	url = options.url || new Error('`options.url` parameter invalid for `uploadimg` function.');
	img = options.img || new Error('`options.img` parameter invalid for `uploadimg` function.');
	if (url instanceof Error) {
		throw url;
	}
	if (img instanceof Error) {
		throw img;
	}
	formData.append('img', img.src);
	xhr.open('POST', url, true);
	xhr.addEventListener('load', function () {
		if (xhr.status < 200 && xhr.status >= 400) {
			return Function.namedParameters(afterUploading, {
				error: new Error('XHR connection error for `uploadimg` function.'),
				response: null
			});
		}
		/**
		 * What do after upload the img.
		 * @callback uploadimg~callback
		 * @param {Error}  [error]    - Return `null` if no error occur else return an `Error` object.
		 * @param {string} [response] - Return the content of XHR response if no error occur, else return `null`.
		 */
		Function.namedParameters(afterUploading, {
			error: null,
			response: xhr.responseText
		});
	});
	xhr.addEventListener('error', function (test) {
		Function.namedParameters(afterUploading, {
			error: new Error('XHR connection error for `uploadimg` function.'),
			response: null
		});
	});
	xhr.send(formData);
}
