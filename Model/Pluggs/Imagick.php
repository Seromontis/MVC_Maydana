<?
/*
	"AUTHOR":"Matheus Mayana",
	"CREATED_DATA": "28/07/2018",
	"MODEL": "Imagick",
	"LAST EDIT": "28/07/2018",
	"VERSION":"0.0.1"
*/

class Model_Pluggs_Imagick {

	function __construct(){

	}

	function generateView($img, $width = WIDTH_VIEW, $height = HEIGHT_VIEW, $quality = 70){

		if(is_file($img)){

			$imagick = new Imagick(realpath($img));
			$imagick->setImageFormat('jpg');
			$imagick->setImageCompression(Imagick::COMPRESSION_JPEG);
			$imagick->setImageCompressionQuality($quality);
			$imagick->thumbnailImage($width, $height, false, false);
			$filename_no_ext = trim(explode('/origin/', $img)[1], FORMATO_THUMBS);

			if(file_put_contents(URL_IMG_VEICULOS.$filename_no_ext.FORMATO_THUMBS, $imagick) === false) {

				throw new Exception("Could not put contents.");
			}

			return true;

		}else{

			throw new Exception("No valid image provided with {$img}.");
		}
	}

	function generateThumbnail($img, $width = WIDTH_THUMB, $height = HEIGHT_THUMB, $quality = 90){

		if(is_file($img)){

			$imagick = new Imagick(realpath($img));
			$imagick->setImageFormat('jpg');
			$imagick->setImageCompression(Imagick::COMPRESSION_JPEG);
			$imagick->setImageCompressionQuality($quality);
			$imagick->thumbnailImage($width, $height, false, false);
			$filename_no_ext = trim(explode('/origin/', $img)[1], FORMATO_THUMBS);

			if(file_put_contents(URL_IMG_VEICULOS_THUMBS.$filename_no_ext.SUBNOME_THUMBS.FORMATO_THUMBS, $imagick) === false) {

				throw new Exception("Could not put contents.");
			}

			return true;

		}else{

			throw new Exception("No valid image provided with {$img}.");
		}
	}
}
