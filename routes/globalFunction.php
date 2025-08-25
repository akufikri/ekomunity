<?php

function toRinggit($amount) {
    return number_format($amount, 2, '.', '');
}

function toRupiah($angka){
	
	$hasil_rupiah = "Rp " . number_format($angka,2,',','.');
	return $hasil_rupiah;
 
}

Route::get('/testrafi', function() {
    return number_format(10, 2, '.', '');
});