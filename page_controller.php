<?php
include_once("page_model.php");
  class PagesController {
    public function home() {
		
		  function addWhere($where, $add, $and = true) {
    if ($where) {
      if ($and) $where .= " AND $add";
      else $where .= " OR $add";
    }
    else $where = $add;
    return $where;
  }
  if (!empty($_GET["filter"])) {
    $where = "";
    //if ($_GET["price_start"]) $where = addWhere($where, "`price` >= '".htmlspecialchars($_POST["price_start"]))."'";
    //if ($_GET["price_end"]) $where = addWhere($where, "`price` <= '".htmlspecialchars($_POST["price_end"]))."'";
    //if ($_GET["manufacturers"]) $where = addWhere($where, "`manufacturer` IN (".htmlspecialchars(implode(",", $_GET["manufacturers"])).")");
    if ($_GET["page_status"]) $where = addWhere($where, "`page_status`= '".htmlspecialchars($_GET["page_status"]))."'";
   $query = "SELECT * FROM `newpages`";
   if ($where) $query .= " WHERE $where ORDER BY `id` DESC";
   
$records_per_page=10;
$paginate = new paginate();
$newquery = $paginate->paging($query,$records_per_page);
      require_once('views/pages/home.php');

  } else {
		
$query = "SELECT * FROM newpages ORDER BY `id` DESC";       
$records_per_page=10;
$paginate = new paginate();
$newquery = $paginate->paging($query,$records_per_page);
      require_once('views/pages/home.php');
    }
	}

    public function error() {
      require_once('views/pages/error.php');
    }
  }
?>
