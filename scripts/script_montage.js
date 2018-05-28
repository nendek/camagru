(function() {

	var canvas = document.querySelector('#canvas');
	navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia;
	width = 640;
	height = 480;

	if (navigator.getUserMedia) {
		navigator.getUserMedia({ video: true },
			function(stream) {
				var video = document.querySelector('video');
				video.src = window.URL.createObjectURL(stream);
				video.onloadedmetadata = function(e) {
					video.play();
				};
			},
			function(err) {
				console.log("The following error occurred: " + err.name);
			}
		);
	} else {
		console.log("getUserMedia not supported");
	}

	function takepicture() {
		canvas.width = width;
		canvas.height = height;
		canvas.getContext('2d').drawImage(video, 0, 0, width, height);
		var data = canvas.toDataURL('image/png');
		photo.setAttribute('src', data);
	}
	takepicButton.addEventListener('click', function(ev){
		takepicture();
		ev.preventDefault();
	}, false);

})();
