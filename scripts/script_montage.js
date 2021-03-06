var displayCam = document.querySelector("#webcam");
var noDisplayCam = document.querySelector("#no_webcam");

var video = document.createElement('video');
var button = document.createElement('button');
var textButton = document.createTextNode("TAKE PICTURE");
var canvas = document.createElement('canvas');
var send = document.createElement('button');
var textSend = document.createTextNode("SAVE MONTAGE");
var montage = document.createElement('button');
var textMontage = document.createTextNode("DISPLAY MONTAGE");

var width = 510;
var height = 510;

displayCam.style.display = "none";
noDisplayCam.style.display = "none";

canvas.id = 'canvas';
canvas.width = width;
canvas.height = height;

send.className = 'button';
send.appendChild(textSend);

montage.className = 'button';
montage.appendChild(textMontage);


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

navigator.mediaDevices.getUserMedia({ video: true }).then(streaming).catch(videoErr);

montage.addEventListener('click', function(ev) {
	displayMontage({
		url: "http://localhost:8080/camagru/index.php?action=displayMontage"
	}, function (res) {
		var data = document.createElement('div');
		var error = res.error;
		var response = res.reponse;

		data.textContent = (error) ? error : response;
	});
});

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
			url: "http://localhost:8080/camagru/index.php?action=upload",
			img: document.getElementById("img")
		}, function (res) {
			var data = document.createElement('div');
			var error = res.error;
			var response = res.response;

			data.textContent = (error) ? error : response;
			displayCam.appendChild(data);
		});
	});
};

function videoErr(err) {

	noDisplayCam.style.display = "block";

	noDisplayCam.appendChild(
			selectImg(inputFile => {
				readImg(inputFile, img => {
					reduceimg(img, imgResult => {
						if (!document.getElementById("img")) {
							noDisplayCam.appendChild(imgResult);
							noDisplayCam.appendChild(send);
						} else {
							old = document.getElementById("img");
							old.parentNode.replaceChild(imgResult, old);
						}
						console.log(this.toString());
					});
				})
			})
			);

	send.addEventListener('click', function(ev) {
		uploadImg({
			url: "http://localhost:8080/camagru/index.php?action=upload",
			img: document.getElementById("img")
		}, function (res) {
			var data = document.createElement('div');
			var error = res.error;
			var response = res.response;

			data.textContent = (error) ? error : response;
			noDisplayCam.appendChild(data);
		});
	});

	console.log(err.name + ": " + err.message);
};

function selectImg(afterSelect) {
	var inputFile = document.createElement('input');

	inputFile.type = 'file';
	inputFile.className = 'button';
	//	inputFile.accept = 'image/*';
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
				afterConversion(img);
			}
		});
		img.src = reader.result;
	});

	reader.readAsDataURL(inputFile.files[0]);
};

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
		afterResizing(imgResult);
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
			return afterUploading({
				error: new Error('XHR connection error for `uploadimg` function.'),
				response: null
			});
		}
		afterUploading({ 
			error: null,
			response: xhr.responseText
		});
	});
	xhr.addEventListener('error', function (test) {
		afterUploading({
			error: new Error('XHR connection error for `uploadimg` function.'),
			response: null
		});
	});
	xhr.send(formData);
};

function displayMontage(options, afterPutFont) {
	var xhr = new XMLHttpRequest();
	url = options.url || new Error('`options.url` parameter invalid for `uploadimg` function.');
	if (url instanceof Error) {
		throw url;
	}
	xhr.open('GET', url, true);
	xhr.addEventListener('load', function () {
		if (xhr.status < 200 && xhr.status >= 400) {
			return afterUploading({
				error: new Error('XHR connection error for `uploadimg` function.'),
				response: null
			});
		}
		afterPutFont({ 
			error: null,
			response: xhr.responseText
		});
	});
	xhr.addEventListener('error', function (test) {
		afterPutFont({
			error: new Error('XHR connection error for `uploadimg` function.'),
			response: null
		});
	});
	xhr.send(null);
}
