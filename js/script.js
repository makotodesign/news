$(function(){
	var newslength=$('.news').length;
	var title=$('#sectitle1').text();
	if(title=='社会ニュース検索結果'){
		$('#sectitle1').append('--'+newslength+'件');
	}

});