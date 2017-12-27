<?php
class paginate
{
     public function dataview($query)
     {
		 $db = Db::getInstance();
         $stmt = $db->prepare($query);
         $stmt->execute();
         if($stmt->rowCount()>0)
         {
                while($row=$stmt->fetch(PDO::FETCH_ASSOC))
                {
      echo '<div class="media">';
	  echo '<div style="border: 0px solid blue; width: 100px; height: 100px; margin: 10px; overflow: hidden;">';
	  echo '<img class="mr-3" src="';
	  echo $row['page_image'];
	  echo '" style="min-width: 100px; height: 100px;" />';
	  echo '</div>';
      echo '<div class="media-body">';
      echo '<h5 class="mt-0">';
	  echo '<a href="?controller=posts&action=show&id=';
	  echo $row['id'];
	  echo '">';
	  echo $row['page_name'];
	  echo '</a>';
	  echo '</h5>';
	  echo '<table>';
	  echo '<tr>';
      echo '<td>';
	  echo '<small>';
	  echo 'категория: ';
	  echo '<a href="">';
	  echo $row['page_status'];
	  echo '</a>';
	  echo '&nbsp;';
	  echo '</td>';
      echo '<td>';
	  echo '</small>';
	  echo '<small>';
	  echo 'Сумма: ';
	  echo '<a href="">';
	  echo $row['amount'];
	  echo '</a>';
	  echo '&nbsp;';
	  echo '</td>';
      echo '<td>';
	  echo '</small>';
	  echo '<small>';
	  echo 'Автор: ';
	  echo '<a href="?controller=userpage&action=index&id=';
	  echo $row['user_id'];
	  echo '">';
	  echo $row['createdBy'];
	  echo '</a>';
      echo '&nbsp;';
	  echo '</td>';
	  echo '<td>';
	  echo '</small>';
	  echo '<small>';
 	  echo 'Дата: ';
	  echo '<a href="">';
	  echo date("D, F j, Y", strtotime($row['page_date']));
	  echo '</a>';
	  echo '&nbsp;';
	  echo '</small>';
	  echo '<small>';
	  echo '</td>';
      echo '</tr>';
      echo '</table>';
      echo mb_substr($row['page_content'], 0, 250); 
      echo '...';
      echo ' </div>';
      echo '</div>';
      echo'<br>';
                }
         }
         else
         {

         }
 }
 public function paging($query,$records_per_page)
 {
        $starting_position=0;
        if(isset($_GET["page_no"]))
        {
             $starting_position=($_GET["page_no"]-1)*$records_per_page;
        }
        $query2=$query." limit $starting_position,$records_per_page";
        return $query2;
 }
 public function paginglink($query,$records_per_page)
 {
	 $db = Db::getInstance();
        $self = $_SERVER['PHP_SELF'];
        $stmt = $db->prepare($query);
        $stmt->execute();
        $total_no_of_records = $stmt->rowCount();
        if($total_no_of_records > 0)
        {
            $total_no_of_pages=ceil($total_no_of_records/$records_per_page);
            $current_page=1;
            if(isset($_GET["page_no"]))
            {
               $current_page=$_GET["page_no"];   
            }
            if($current_page!=1)
            { 
               $previous =$current_page-1;
			   echo "<li class='page-item'>";
               echo "<a class='page-link' href='".$self."?controller=pages&action=home&page_no=1'>First</a>";
			   echo "</li>";
			   echo "<li class='page-item'>";
               echo "<a class='page-link' href='".$self."?controller=pages&action=home&page_no=".$previous."'>Previous</a>";
               echo "</li>";
			}
	if (!isset($_GET["page_no"])) {
		$active = 1;
	} else {
		$active = $_GET["page_no"];
	}		
			
			
  
  $count_show_pages = 10;
  if ($total_no_of_pages > 1) { 
    $left = $active - 1;
    $right = $total_no_of_pages - $active;
    if ($left < floor($count_show_pages / 2)) $start = 1;
    else $start = $active - floor($count_show_pages / 2);
    $end = $start + $count_show_pages - 1;
    if ($end > $total_no_of_pages) {
      $start -= ($end - $total_no_of_pages);
      $end = $total_no_of_pages;
      if ($start < 1) $start = 1;
    }
  } else {
	  $start = 1;
	  $end = 1;
  }
            for($i = $start; $i <= $end; $i++)
            {
			if($i==$current_page)
            {
				echo "<li class='page-item'>";
                echo "<a class='page-link' href='".$self."?controller=pages&action=home&page_no=".$i."' style='color:red;text-decoration:none'>".$i."<span class='sr-only'>(current)</span></a>";
                echo "</li>";
			}
            else
            {
				echo "<li class='page-item'>";
                echo "<a class='page-link' href='".$self."?controller=pages&action=home&page_no=".$i."'>".$i."<span class='sr-only'>(current)</span></a>";
				echo "</li>";
            }
   }
   if($current_page!=$total_no_of_pages)
   {
        $next=$current_page+1;
		echo "<li class='page-item'>";
        echo "<a class='page-link' href='".$self."?controller=pages&action=home&page_no=".$next."'>Next</a>";
		echo "</li>";
		echo "<li class='page-item'>";
        echo "<a class='page-link' href='".$self."?controller=pages&action=home&page_no=".$total_no_of_pages."'>Last</a>";
		echo "</li>";
   }
  }
 }
}