<?php

function of_head_css() {

$output = '';
$imagepath = get_stylesheet_directory_uri() . "/style/images/";
$skin = of_get_option('skin_select');

if ($body_bg = of_get_option('bg_select') ) {
	$output .= "body {background-image: url($imagepath". $skin ."/" . $body_bg .");}
	#header {background-image: url($imagepath". $skin ."/" . $body_bg .");}\n";
}

if ($bg_color = of_get_option('bg_color') ) {
	$output .= "body, #header {background:" . $bg_color .";}\n";
}

if ($header_height = of_get_option('header_height') ) {
	$output .= ".borderline {padding-top: " . $header_height ."px;}\n";
}

$custom_css = of_get_option('custom_css');
		
		if ($custom_css <> '') {
			$output .= $custom_css . "\n";
		}
		
// Output styles
if ($output <> '') {
	$output = "<!-- Custom Styling -->\n<style type=\"text/css\">\n" . $output . "</style>\n";
	echo $output;
}
	
}
add_action('wp_head', 'of_head_css');

function font_stack($font){
	$stack = '';
	
	switch ( $font ) {
		case 'apparatus':
			$stack .= '"ApparatusSILRegular", Palatino, "Palatino Linotype", serif';
		break;
		case 'lucida':
			$stack .= '"Lucida Grande", "Lucida Sans Unicode", "Trebuchet MS", Helvetica, Arial, sans-serif';
		break;
		case 'arial':
			$stack .= 'Arial, sans-serif';
		break;
		case 'verdana':
			$stack .= 'Verdana, "Verdana Ref", sans-serif';
		break;
		case 'trebuchet':
			$stack .= '"Trebuchet MS", Verdana, "Verdana Ref", sans-serif';
		break;
		case 'georgia':
			$stack .= 'Georgia, serif';
		break;
		case 'times':
			$stack .= 'Times, "Times New Roman", serif';
		break;
		case 'tahoma':
			$stack .= 'Tahoma,Geneva,Verdana,sans-serif';
		break;
		case 'palatino':
			$stack .= '"Palatino Linotype", Palatino, Palladio, "URW Palladio L", "Book Antiqua", Baskerville, "Bookman Old Style", "Bitstream Charter", "Nimbus Roman No9 L", Garamond, "Apple Garamond", "ITC Garamond Narrow", "New Century Schoolbook", "Century Schoolbook", "Century Schoolbook L", Georgia, serif';
		break;
		case 'helvetica':
			$stack .= '"Helvetica Neue", Helvetica, Arial, sans-serif';
		break;
		
		case 'adelle':
			$stack .= 'AdelleBasicBold';
		break;
		case 'aller':
			$stack .= 'AllerRegular';
		break;
		case 'amaranth':
			$stack .= 'AmaranthRegular';
		break;
		case 'arvo':
			$stack .= 'ArvoRegular';
		break;
		case 'bebas':
			$stack .= 'BebasNeueRegular';
		break;
		case 'carto':
			$stack .= 'CartoGothicStdBook';
		break;
		case 'classic':
			$stack .= 'ClassicRoundMedium';
		break;
		case 'comfortaa':
			$stack .= 'ComfortaaRegular';
		break;
		case 'copse':
			$stack .= 'CopseRegular';
		break;
		case 'delicious':
			$stack .= 'DeliciousRoman';
		break;
		case 'folks':
			$stack .= 'FolksRegular';
		break;
		case 'fontin':
			$stack .= 'FontinSansRegular';
		break;
		case 'goudy':
			$stack .= 'SortsMillGoudyRegular';
		break;
		case 'graublau':
			$stack .= 'GraublauWebRegular';
		break;
		case 'kreon':
			$stack .= 'KreonRegular';
		break;
		case 'market':
			$stack .= 'MarketDecoRegular';
		break;
		case 'mavenpro':
			$stack .= 'MavenProMedium';
		break;
		case 'melbourne':
			$stack .= 'MelbourneRegular';
		break;
		case 'mido':
			$stack .= 'MidoMedium';
		break;
		case 'mimic':
			$stack .= 'MimicRegular';
		break;
		case 'museo':
			$stack .= 'Museo500';
		break;
		case 'otari':
			$stack .= 'OtariBold-Limited';
		break;
		case 'podkova':
			$stack .= 'PodkovaRegular';
		break;
		case 'ptsans':
			$stack .= 'PTSansRegular';
		break;
		case 'puritan':
			$stack .= 'Puritan20Normal';
		break;
		case 'qlassik':
			$stack .= 'QlassikMediumRegular';
		break;
		case 'quicksand':
			$stack .= 'QuicksandBold';
		break;
		case 'rokkitt':
			$stack .= 'RokkittRegular';
		break;
		case 'titillium':
			$stack .= 'TitilliumText22L600wt';
		break;
		case 'vegur':
			$stack .= 'VegurRegular';
		break;
		case 'vollkorn':
			$stack .= 'VollkornRegular';
		break;
		
	}
	return $stack;
}

?>