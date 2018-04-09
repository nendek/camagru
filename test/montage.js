(function() {

	var stream;
	var video = document.getElementById('video');
	var canvas = document.getElementById('canvas');
	var startbutton = document.getElementById('startbutton');


	navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia;
	startbutton.onclick = function() {
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
						video.src = window.webkitURL.createObjectURL(stream);
					}
					video.play();
				},
				function(e) {
					alert('getUserMedia failed: Code ' + e.code);
				}
				);
	}
//	document.getElementById('MediaStreamStopButton').onclick = function() {
//		if (stream) { stream.stop(); }
//	}

/*
	function takepicture() {
		canvas.width = width;
		canvas.height = height;
		canvas.getContext('2d').drawImage(video, 0, 0, width, height);
		var data = canvas.toDataURL('image/png');
		photo.setAttribute('src', data);
	}

	startbutton.addEventListener('click', function(ev){
		takepicture();
		ev.preventDefault();
	}, false);
*/
})();
