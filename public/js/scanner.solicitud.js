

// function scanWithoutAspriseDialog() {
//     scanner.scan(displayImagesOnPage, {
//         "use_asprise_dialog": false,
//         "output_settings": [
//             {
//                 "type": "return-base64",
//                 "format": "jpg"
//             }
//         ]
//     });
// }

function scanToWebPageAndUpload() {
    scanner.scan(displayImagesOnPage, {
        "twain_cap_setting" : {
            "ICAP_PIXELTYPE" : "TWPT_RGB",
            "ICAP_SUPPORTEDSIZES" : "TWSS_USLETTER"
        },
        "output_settings" : [
            { "type" : "return-base64", "format" : "jpg"}
            // { "type": "upload", "format": "pdf",
            //     "upload_target": {
            //         "url": "https://asprise.com/scan/applet/upload.php?action=dump"
            //     }
            // }
        ]
    });
}




    /** Processes the scan result */
function displayImagesOnPage(successful, mesg, response) {
    if(!successful) { // On error
        console.error('Failed: ' + mesg);
        return;
    }

    if(successful && mesg != null && mesg.toLowerCase().indexOf('user cancel') >= 0) { // User cancelled.
        console.info('User cancelled');
        return;
    }

    var scannedImages = scanner.getScannedImages(response, true, false); // returns an array of ScannedImage
    for(var i = 0; (scannedImages instanceof Array) && i < scannedImages.length; i++) {
        var scannedImage = scannedImages[i];
        processScannedImage(scannedImage);
    }

    var data = JSON.stringify(scannedImages[0]);
    console.log(data);
    console.log(scannedImages[0].src);
    var imageData = scannedImages[0].src;
    document.getElementsByName("scannerInput")[0].setAttribute("value", imageData);
    document.getElementsByName("scannerInputs[]")[0].setAttribute("value", imageData);

}

/** Images scanned so far. */
var imagesScanned = [];

/** Processes a ScannedImage */
function processScannedImage(scannedImage) {
    imagesScanned.push(scannedImage.src);
    var elementImg = scanner.createDomElementFromModel( {
        'name': 'img',
        'attributes': {
            'class': 'scanned',
            'src': scannedImage.src
        }
    });
    // document.getElementById('scannerImages').appendChild(elementImg);
    (document.getElementById('scannerImages') ? document.getElementById('scannerImages') : document.body).appendChild(elementImg);
}



