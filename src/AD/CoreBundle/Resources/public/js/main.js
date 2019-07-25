var dropzone = new Dropzone("#dropzone-easyadmin", {
	autoQueue : false,
	parallelUploads : 3,
	chunking : false,
	resizeQuality : 0.6,
});


var dropzoneUnique = new Dropzone("#dropzone-easyadmin-alone", {
	autoQueue : false,
	parallelUploads : 1,
	chunking : false,
	resizeQuality : 0.6,
	maxFiles: 1,
});




function getOrientation(file, callback) {
	var reader = new FileReader();
	reader.onload = function(e) {

		var view = new DataView(e.target.result);
		if (view.getUint16(0, false) != 0xFFD8) {
			return callback(-2);
		}
		var length = view.byteLength, offset = 2;
		while (offset < length) {
			if (view.getUint16(offset + 2, false) <= 8)
				return callback(-1);
			var marker = view.getUint16(offset, false);
			offset += 2;
			if (marker == 0xFFE1) {
				if (view.getUint32(offset += 2, false) != 0x45786966) {
					return callback(-1);
				}

				var little = view.getUint16(offset += 6, false) == 0x4949;
				offset += view.getUint32(offset + 4, little);
				var tags = view.getUint16(offset, little);
				offset += 2;
				for (var i = 0; i < tags; i++) {
					if (view.getUint16(offset + (i * 12), little) == 0x0112) {
						return callback(view.getUint16(offset + (i * 12) + 8,
								little));
					}
				}
			} else if ((marker & 0xFF00) != 0xFF00) {
				break;
			} else {
				offset += view.getUint16(offset, false);
			}
		}
		return callback(-1);
	};
	reader.readAsArrayBuffer(file);
}

dropzone.on("addedfile", function(origFile) {
	var MAX_WIDTH = 700;
	var MAX_HEIGHT = 700;

	var reader = new FileReader();

	// Convert file to img

	reader.addEventListener("load", function(event) {

		var origImg = new Image();
		origImg.src = event.target.result;

		origImg.addEventListener("load", function(event) {

			var width = event.target.width;
			var height = event.target.height;

			getOrientation(origFile,
				function(orientation) {
				// Don't resize if it's small enough

				if (width > MAX_WIDTH && height > MAX_HEIGHT) {
					if (width > height) {
						if (width > MAX_WIDTH) {
							height *= MAX_WIDTH / width;
							width = MAX_WIDTH;
						}
					} else {
						if (height > MAX_HEIGHT) {
							width *= MAX_HEIGHT / height;
							height = MAX_HEIGHT;
						}
					}
				}
				// Resize & rotate
				
				var degree = 0;
				switch (orientation) {
					case 3:
						degree = 180;
						break;
					case 6:
						degree = 90;
						break;
					case 8:
						degree = 90;
						break;
				}

				var canvas = document.createElement('canvas');
				canvas.width = width;
				canvas.height = height;

				var ctx = canvas.getContext("2d");
				ctx.translate(canvas.width/2, canvas.height/2);
				ctx.rotate(Math.PI / 180 *degree);
				
				
				ctx.drawImage(origImg,-width/2,-height/2, width, height);
				
				
				var resizedFile = base64ToFile(canvas.toDataURL(), origFile);

				// Replace original with resized

				var origFileIndex = dropzone.files.indexOf(origFile);
				dropzone.files[origFileIndex] = resizedFile;

				// Enqueue added file manually making it available for
				// further processing by dropzone

				dropzone.enqueueFile(resizedFile);
					});

			
		});
	});

	reader.readAsDataURL(origFile);
});





dropzoneUnique.on("addedfile", function(origFile) {
	var MAX_WIDTH = 700;
	var MAX_HEIGHT = 700;

	var reader = new FileReader();

	// Convert file to img

	reader.addEventListener("load", function(event) {

		var origImg = new Image();
		origImg.src = event.target.result;

		origImg.addEventListener("load", function(event) {

			var width = event.target.width;
			var height = event.target.height;

			getOrientation(origFile,
				function(orientation) {
				// Don't resize if it's small enough

				if (width > MAX_WIDTH && height > MAX_HEIGHT) {
					if (width > height) {
						if (width > MAX_WIDTH) {
							height *= MAX_WIDTH / width;
							width = MAX_WIDTH;
						}
					} else {
						if (height > MAX_HEIGHT) {
							width *= MAX_HEIGHT / height;
							height = MAX_HEIGHT;
						}
					}
				}
				// Resize & rotate
				
				var degree = 0;
				switch (orientation) {
					case 3:
						degree = 180;
						break;
					case 6:
						degree = 90;
						break;
					case 8:
						degree = 90;
						break;
				}

				var canvas = document.createElement('canvas');
				canvas.width = width;
				canvas.height = height;

				var ctx = canvas.getContext("2d");
				ctx.translate(canvas.width/2, canvas.height/2);
				ctx.rotate(Math.PI / 180 *degree);
				
				
				ctx.drawImage(origImg,-width/2,-height/2, width, height);
				
				
				var resizedFile = base64ToFile(canvas.toDataURL(), origFile);

				// Replace original with resized

				var origFileIndex = dropzoneUnique.files.indexOf(origFile);
				dropzoneUnique.files[origFileIndex] = resizedFile;

				// Enqueue added file manually making it available for
				// further processing by dropzone

				dropzoneUnique.enqueueFile(resizedFile);
					});

			
		});
	});

	reader.readAsDataURL(origFile);
});

function base64ToFile(dataURI, origFile) {
	var byteString, mimestring;

	if (dataURI.split(',')[0].indexOf('base64') !== -1) {
		byteString = atob(dataURI.split(',')[1]);
	} else {
		byteString = decodeURI(dataURI.split(',')[1]);
	}

	mimestring = dataURI.split(',')[0].split(':')[1].split(';')[0];

	var content = new Array();
	for (var i = 0; i < byteString.length; i++) {
		content[i] = byteString.charCodeAt(i);
	}

	var newFile = new File([ new Uint8Array(content) ], origFile.name, {
		type : mimestring
	});

	// Copy props set by the dropzone in the original file

	var origProps = [ "upload", "status", "previewElement", "previewTemplate",
			"accepted" ];

	$.each(origProps, function(i, p) {
		newFile[p] = origFile[p];
	});

	return newFile;
}


