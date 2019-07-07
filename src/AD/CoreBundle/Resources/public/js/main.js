var dropzone = new Dropzone ("#dropzone-easyadmin", {
  autoQueue: false,
  parallelUploads: 3,
  chunking: false,
  resizeQuality: 0.6,
});


dropzone.on("addedfile", function(origFile) {
  var MAX_WIDTH  = 700;
  var MAX_HEIGHT = 700;

  var reader = new FileReader();

  // Convert file to img

  reader.addEventListener("load", function(event) {

    var origImg = new Image();
    origImg.src = event.target.result;

    origImg.addEventListener("load", function(event) {

      var width  = event.target.width;
      var height = event.target.height;


      // Don't resize if it's small enough

      if (width <= MAX_WIDTH && height <= MAX_HEIGHT) {
        dropzone.enqueueFile(origFile);
        return;
      }


      // Calc new dims otherwise

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


      // Resize

      var canvas = document.createElement('canvas');
      canvas.width = width;
      canvas.height = height;

      var ctx = canvas.getContext("2d");
      ctx.drawImage(origImg, 0, 0, width, height);

      var resizedFile = base64ToFile(canvas.toDataURL(), origFile);


      // Replace original with resized

      var origFileIndex = dropzone.files.indexOf(origFile);
      dropzone.files[origFileIndex] = resizedFile;


      // Enqueue added file manually making it available for
      // further processing by dropzone

      dropzone.enqueueFile(resizedFile);
    });
  });

  reader.readAsDataURL(origFile);
});




function base64ToFile(dataURI, origFile) {
	  var byteString, mimestring;

	  if(dataURI.split(',')[0].indexOf('base64') !== -1 ) {
	    byteString = atob(dataURI.split(',')[1]);
	  } else {
	    byteString = decodeURI(dataURI.split(',')[1]);
	  }

	  mimestring = dataURI.split(',')[0].split(':')[1].split(';')[0];

	  var content = new Array();
	  for (var i = 0; i < byteString.length; i++) {
	    content[i] = byteString.charCodeAt(i);
	  }

	  var newFile = new File(
	    [new Uint8Array(content)], origFile.name, {type: mimestring}
	  );


	  // Copy props set by the dropzone in the original file

	  var origProps = [ 
	    "upload", "status", "previewElement", "previewTemplate", "accepted" 
	  ];

	  $.each(origProps, function(i, p) {
	    newFile[p] = origFile[p];
	  });

	  return newFile;
	}