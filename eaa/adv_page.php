
<div id="page-wrapper">
            
            <div class="row" id="div_page">
               
               
               <?php  get_adv_schedual($_SESSION["Current_advisor_id"] , 20)?> 
            
                
            </div>
</div>            

<script>

function load_page(url)
{
	$( "#div_page" ).load(url);	
	
}

</script>