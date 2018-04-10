(function() {

	var stream;
	var video = document.getElementById('video');
	var canvas = document.getElementById('canvas');
	var startButton = document.getElementById('startButton');
	var stopButton = document.getElementById('stopButton');
	width = 300;
	height = 400;


	navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia;
	startButton.onclick = function() {
		if (!navigator.getUserMedia) {
			alert('Sorry, this isn\'t happening for your browser.');
			return;
		}
		navigator.getUserMedia(
				{video: true, audio: true}, 
				function(local) {
					stream = local;
					if (video.mozSrcObject !== undefined) {
						video.mozSrcObject = stream;
					} else {
						video.src = window.URL.createObjectURL(stream);
					}
					video.play();
				},
				function(e) {
					alert('getUserMedia failed: Code ' + e.code);
				}
				);
	}
	document.getElementById('stopButton').onclick = function() {
		if (stream)
			stream.stop();
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
