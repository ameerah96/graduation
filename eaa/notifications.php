
<div class="row" >
<div class="col-lg-1"></div>
<div class="col-lg-10">
                    <div class="panel panel-default" >
                        <div class="panel-heading">
                        All Notifications
                        
                       
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body"  >
                        <div class="col-lg-12"  >
                        
                        
                        
                        <br>
                        
                        <table width="100%" class="table table-striped table-bordered table-hover"  >
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Subject </th>
                                        <th>Message</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php


$sql = "SELECT *   FROM notifications n   where user_id = ".$_SESSION[CurrentUserId]." ORDER BY n_date DESC " ; 

 
$r_s = mysql_query($sql) ;



$c = 0 ; 
 
while($q = mysql_fetch_array($r_s))
{
?>
<tr >
    <td><a href="?p=notifications&notification_id=<?=$q[notification_id]?>" > <?=$q[n_date]?></a></td>
    <td><a href="?p=notifications&notification_id=<?=$q[notification_id]?>" ><?=$q[subject]?></a></td>
    <td><a href="?p=notifications&notification_id=<?=$q[notification_id]?>" ><?=substr($q[message],0,100)?></a></td>
    
</tr>
<?php	
if(isset($_GET[notification_id])&& $_GET[notification_id]==$q[notification_id])
{
?>
<tr >
    <td colspan="3"> <?=str_replace('***',"'", $q[message])?> </td>
    </tr>
<?php	
}

}
?>
                                </tbody>
                            </table>
                        </div>
                        
                       
                    </div>
                    
                </div>


</div>
 