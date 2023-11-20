function amagarDiv()
{
	jQuery('#avis3de6').css('display','none');
}
function load()
{
	jQuery('#loading1').css('display','block');
}
function cancelar(id,pas)
{
	location.href='index.php?id=' + id + '&pas=' + pas;
}
function endavant(valor)
{
	jQuery('#valor').val(valor);
	document.form.submit();
}
function opcionsIncorrectes()
{
	history.back(1);
	
}
function isEmpty(val){
	if(jQuery.trim(val).length == 0)
	{
		return true;
	}
	else
	{
		return false;
	}
}

function validarMon()
{
	var e2;
	e2 = jQuery('#valor').val();
	if(isEmpty(e2)){}
	else
	{
		document.formulari.submit();
	}
	
}

$("body").on('keypress',function(event) {
  if (event.which === 13) {
	$('button.endavant').trigger('click');
  }
});


 $("#data1").keyup(function () {
		if (this.value.length == this.maxLength) {
		  $("#data2").focus(); 
		}
});
$("#data2").keyup(function () {
		if (this.value.length == this.maxLength) {
		  $("#data3").focus(); 
		}
});
$("#data3").keyup(function () {
		if (this.value.length == this.maxLength) {
		  $(".endavant").focus(); 
		}
});
function validarOpcions()
{

	if ($('.img-selected').length==3) 
	{
		jQuery('#valor1').val('-1');
		jQuery('#valor2').val('-1');
		jQuery('#valor3').val('-1');
		var posicio = 1;	
		$(".img").each(function(){
			if ( $( this).hasClass("img-selected" ) ) {
				//alert($(this).attr('id'));
				jQuery('#valor' + posicio).val($(this).attr('id'));
				posicio=posicio+1;
			}
		});
		document.form.submit();
	}
	else
	{
		jQuery('#avis3de6').css('display','block');
	}
}

function validarVotacio() {
		document.form.submit();
}