<?php
class Paging
{
  // Properties
  include "koneksi.php";
  public $page;
  public $table;

  // Methods
  function show_paging($table, $page)
  {
    $this->page = $page;
  }
}
