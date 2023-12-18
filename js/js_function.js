function clear_info(element) {
	$(element).html('');
}
	
function add_listener(element, list) {
	/*element.addEventListener("cut", function(){
		search_set(list);
	}, false);
	element.addEventListener("kaypress", function(){
		search_set(list);
	}, false);*/
	element.addEventListener("input", function(){
		search_set(list);
	}, false);
	/*element.addEventListener("keyup", function(){
		search_set(list);
	}, false);
	element.addEventListener("paste", function(){
		search_set(list);
	}, false);
	element.addEventListener("serach", function(){
		search_set(list);
	}, false);*/
}

function search_set(file){

    search = ($('#searchset').val());
        
    $.post(file+".php", {search: search})
       .done(function(data){
			$("#tb_set").html(data);
        })
        .fail(function(){
			$("#tb_set").html(info_er);
       });

}

function add_PN(mess){
	clear_info('.help-block');
	pn = $('#tb_pn').val();
	
	$.post("editset_addPN.php",{pn: pn})
		.done(function(data){
			$('#tb_set').append(data);
		})
		.fail(function(){
			$('.help-block').eq(0).html(mess);
		});
}

function pn_action_edit(mess){
    id = $('tr:hover').attr('id');
    id_tr = id.replace('tb_tr_','');
    new_sn = $('#tb_sn_'+id_tr).val();
    
    $.post("editset_editsn.php", {id_his: id, sn: new_sn})
            .done(function(data){
                $('#tb_set').append(data);
            })
            .fail(function(){
                $('.help-block').eq(0).html(mess);
            });
   
}

function pn_action_remove(mess){
    id = $('tr:hover').attr('id');
    
    $.post("editset_removepn.php", {id_his: id})
            .done(function(data){
                $('#tb_set').append(data);
            })
            .fail(function(){
                $('.help-block').eq(0).html(mess);
            });
   
}
