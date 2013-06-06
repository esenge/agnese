<!-- no github -->
<?php
echo get_ol($pages);
//rekursīva funkcija , ņem par parametru par masīvu un nosaka, vai tas ir bērns vai nē
function get_ol ($array, $child = FALSE)
{
	//tukša rinda
	$str = '';
	//pārbauda vai masīvā atrodas elementi
	if (count($array)) {
		//ja nav bērns, tad piešķir klasi sortable, savādāk vnk ol tag
		$str .= $child == FALSE ? '<ol class="sortable">' : '<ol>';
		//ktram masīva elementam
		foreach ($array as $item) {
			//atver li tagus, tad divu
			$str .= '<li id="list_' . $item['id'] .'">';
			$str .= '<div>' . $item['title'] .'</div>';
			
			//pārbauda vai eksistē bērni
			if (isset($item['children']) && count($item['children'])) {
				//izsauc šo funkciju vēlreiz
				$str .= get_ol($item['children'], TRUE);
			}
			
			$str .= '</li>' . PHP_EOL;
		}
		
		$str .= '</ol>' . PHP_EOL;
	}
	
	return $str;
}
?>

<script>
$(document).ready(function(){

    $('.sortable').nestedSortable({
        handle: 'div',
        items: 'li',
        toleranceElement: '> div',
        maxLevels: 2
    });

});
</script>