<?php

class DeleteController extends MiscellaneousController
{
   /**
    * Delete Data Based On ID
    * 
    * @param string|int
    * @return int
    */
   public function deleteAll($table, $id)
   {
      $sql_code = "DELETE FROM {$table} WHERE id=:ID";

      $query = $this->connection->prepare($sql_code);
      $values = array(
         ':ID' => $id
      );

      try {
         if ($query->execute($values)) {
            $deletedRowNumber = $query->rowCount();
            return $deletedRowNumber;
         } else {
            throw new Exception();
         }
      } catch (Exception $e) {
         return false;
      }
   }

   

   /**
    * Delete Multiple Data Based on ID's
    * 
    * @param string|int
    * @return int
    */
   public function deleteMultiple($table, $id)
   {
      $sql_code = "DELETE FROM {$table} WHERE `id` IN ({$id})";
      $query = $this->connection->prepare($sql_code);

      try {
         if ($query->execute()) {
            $deletedRowNumber = $query->rowCount();
            return $deletedRowNumber;
         } else {
            throw new Exception();
         }
      } catch (Exception $e) {
         return false;
      }
   }
}
