<?php
//nosaukums kas rādas cilnes nosaukumā
function add_meta_title ($string)
{
	$CI =& get_instance();
	$CI->data['meta_title'] = e($string) . ' - ' . $CI->data['meta_title'];
}
//uri kā parametrs
function btn_edit ($uri)
{
	//atgriež saiti, kas norāda uz uri
	return anchor($uri, '<i class="icon-edit"></i>');
}
//uri kā parametrs
function btn_delete ($uri)
{
	//atgriež saiti, kas norāda uz uri
	return anchor($uri, '<i class="icon-remove"></i>', array(
		//uz klikšķi parāda js ziņojumu
		'onclick' => "return confirm('Vai tiešām dzēst?');"
	));
}
function article_link($article){
	return 'article/' . intval($article->id) . '/' . e($article->slug);
}

function shop_link($shop){
	return 'shop/' . intval($shop->id) . '/' . e($shop->slug);
}

//lai varētu piekļūt no visām lapām uz šiem linkiem
function article_links($articles){
	$string = '<ul>';
	foreach ($articles as $article) {
		$url = article_link($article);
		$string .= '<li>';
		$string .= '<h3>' . anchor($url, e($article->title)) .  ' ›</h3>';
		$string .= '<p class="pubdate">' . e($article->pubdate) . '</p>';
		$string .= '</li>';
	}
	$string .= '</ul>';
	return $string;
}
//linki, tikai angliski (raksti)
function article_links_eng($articles){
	$string = '<ul>';
	foreach ($articles as $article) {
		$url = article_link($article);
		$string .= '<li>';
		$string .= '<h3>' . anchor($url, e($article->title_eng)) .  ' ›</h3>';
		$string .= '<p class="pubdate">' . e($article->pubdate) . '</p>';
		$string .= '</li>';
	}
	$string .= '</ul>';
	return $string;
}
function shop_links($shop){
	$string = '<ul>';
	foreach ($shops as $shop) {
		$url = shop_link($shop);
		$string .= '<li>';
		$string .= '<h3>' . anchor($url, $shop->title) .  ' ›</h3>';
		$string .= '<p class="pubdate">' . $shop->pubdate . '</p>';

		$string .= '</li>';
	}
	$string .= '</ul>';
	return $string;
}

function get_excerpt($article, $numwords = 50){
	$string = '';
	//satur url uz pilno rakstu
	//no video bija vēl piemērs:
	$url = article_link($article);

	//virsraksts, anchor uz url, ko iaveidoja iepriekšējā rindiņā, virsraksts būs teksts
	
	$string .= '<h2>' . anchor($url, $article->title) .  '</h2>'; //Virsraksts
	$string .= img(array('src' => 'images/'. $article->thumbnail)) ;

	$string .= '<p class="pubdate">' . $article->pubdate . '</p>'; //hvz vai vajadzigs
	//paragrāfs, iekšā atrodas article body, strip_tags-aizvieto html tagus
	$string .= '<p>' . limit_to_numwords(strip_tags($article->body), $numwords) . '</p>'; //teksts
	//anchor tag saucās read more;paragrāfam
	$string .= '<p>' . anchor($url, 'Lasīt vairāk') . '</p>'; //read more

	return $string;
}

function get_excerpt_eng($article, $numwords = 50){
	$string = '';
	//satur url uz pilno rakstu
	//no video bija vēl piemērs:
	$url = article_link($article);

	//virsraksts, anchor uz url, ko iaveidoja iepriekšējā rindiņā, virsraksts būs teksts
	
	$string .= '<h2>' . anchor($url, $article->title_eng) .  '</h2>'; //Virsraksts
	$string .= img(array('src' => 'images/'. $article->thumbnail)) ;

	$string .= '<p class="pubdate">' . $article->pubdate . '</p>'; //hvz vai vajadzigs
	//paragrāfs, iekšā atrodas article body, strip_tags-aizvieto html tagus
	$string .= '<p>' . limit_to_numwords(strip_tags($article->body_eng), $numwords) . '</p>'; //teksts
	//anchor tag saucās read more;paragrāfam
	$string .= '<p>' . anchor($url, 'Read more') . '</p>'; //read more

	return $string;
}

function get_excerpt_shop($shop, $numwords = 20){

	$string = '<p>' . limit_to_numwords(strip_tags($shop->body), $numwords) . '</p>';

	return $string;
}
function get_excerpt_shop_eng($shop, $numwords = 20){

	$string = '<p>' . limit_to_numwords(strip_tags($shop->body_eng), $numwords) . '</p>';

	return $string;
}
//lai zinātu, cik daudz vārdus rādīt get_excerpt() f-jā
function limit_to_numwords($string, $numwords){
	//masīvs, kas veidots no vārdiem, izmantojot explode f-ju pēc atstarpēm, ierobežo vārdu skaitu +1 (atstarpe)
	$excerpt = explode(' ', $string, $numwords + 1);
	//ja vārdu skaits ir lielāks par ierobežojumu
	if (count($excerpt) >= $numwords) {
		//izmet tik daudz, cik ir bijis ierobežojumā
		array_pop($excerpt);
	}
	//tad apvieno masīvu no atstarpēm, un tad izmet excerptu
	$excerpt = implode(' ', $excerpt);
	return $excerpt;
}

 function e($string){
 	return htmlentities($string);
 }

function get_menu ($array, $child = FALSE)
{
	$CI =& get_instance();
	$str = '';
	if (count($array)) {
		$str .= $child == FALSE ? '<ul class="nav">' . PHP_EOL : '<ul class="dropdown-menu">' . PHP_EOL;
		foreach ($array as $item) {
			//ja pirmais segments ir vienāds ar slug, tad true vai false
			$active = $CI->uri->segment(1) == $item['slug'] ? TRUE : FALSE;
			//ja ir bērni un tie ir saskaitāmi
			if (isset($item['children']) && count($item['children'])) {
				$str .= $active ? '<li class="dropdown active">' : '<li class="dropdown">';
				//izveido anchor tag-linku, izsauc site_url f-ju.atgriež absolūto url
				$str .= '<a  class="dropdown-toggle" data-toggle="dropdown" href="' . site_url($item['slug']) . '">' . e($item['title']);
				$str .= '<b class="caret"></b></a>' . PHP_EOL;//rindiņas beigas
				//ja ir bērni izsauc šo f-ju vēlreiz
				$str .= get_menu($item['children'], TRUE);
			}
			//ja nav bērnu, pievieno li ar linku, izmantojot slug
			else {
				$str .= $active ? '<li class="active">' : '<li>';
				$str .= '<a href="' . site_url($item['slug']) . '">' . e($item['title']) . '</a>';
			}
			$str .= '</li>' . PHP_EOL;
		}
		$str .= '</ul>' . PHP_EOL;
	}
	return $str;
}
//izvēlne angļu valodā
function get_menu_eng ($array, $child = FALSE)
{
	$CI =& get_instance();
	$str = '';
	if (count($array)) {
		$str .= $child == FALSE ? '<ul class="nav">' . PHP_EOL : '<ul class="dropdown-menu">' . PHP_EOL;
		foreach ($array as $item) {
			$active = $CI->uri->segment(1) == $item['slug'] ? TRUE : FALSE;
			if (isset($item['children']) && count($item['children'])) {
				$str .= $active ? '<li class="dropdown active">' : '<li class="dropdown">';
				$str .= '<a  class="dropdown-toggle" data-toggle="dropdown" href="' . site_url(e($item['slug'])) . '">' . e($item['title_eng']);
				$str .= '<b class="caret"></b></a>' . PHP_EOL;
				$str .= get_menu_eng($item['children'], TRUE);
			}
			else {
				$str .= $active ? '<li class="active">' : '<li>';
				$str .= '<a href="' . site_url($item['slug']) . '">' . e($item['title_eng']) . '</a>';
			}
			$str .= '</li>' . PHP_EOL;
		}
		$str .= '</ul>' . PHP_EOL;
	}
	return $str;
}
