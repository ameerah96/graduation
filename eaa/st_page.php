<div id="page-wrapper">
            
            <!-- /.row -->
            <div class="row" id="div_page">
               
               <?php   echo  get_student_info($_SESSION["current_student_id"] ) ; ?> 
               
              
            </div>
</div>            

<script>

function load_page(url)
{
	$( "#div_page" ).load(url);	
	
}

</script>