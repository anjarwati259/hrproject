<?php 
function getMenu($role){
	$CI = get_instance();
	$CI->load->model('menu_model');
	$dataMenu = $CI->menu_model->getMenu($role);
	$menu = array();
	$isSubmenu = false;
	foreach ($dataMenu as $key => $value) {
		if($value->parent == null){
			$menu['mainMenu'][$key]['menu'] = $value->menu;
			$menu['mainMenu'][$key]['id'] = $value->id;
			$menu['mainMenu'][$key]['url'] = $value->url;
			$menu['mainMenu'][$key]['idParent'] = $value->id;
			$menu['mainMenu'][$key]['isParent'] = $value->is_parent;
			$menu['mainMenu'][$key]['icon'] = $value->icon;
		}else{
			$menu['subMenu'][$key]['menu'] = $value->menu;
			$menu['subMenu'][$key]['id'] = $value->id;
			$menu['subMenu'][$key]['url'] = $value->url;
			$menu['subMenu'][$key]['parent'] = $value->parent;
			// $menu['subMenu'][$key]['isParent'] = $value->is_parent;
			$menu['subMenu'][$key]['icon'] = $value->icon;
			$isSubmenu = true;
		}
	}
	if($isSubmenu == false){
		$menu['subMenu'] = null;
	}
	return $menu;
}

function dateDefault($date)
{
	$indoBulan = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];

	$date    = explode('-', $date);
	$month = (int)$date[1]-1;
	$defaultDate = $date[2] . ' ' . $indoBulan[ $month ] . ' ' . $date[0];
	return $defaultDate;
}

function generateUrl($kode){
	$kode = base64_encode($kode);
    $urlKode = urlencode($kode);
    return $urlKode;
}
