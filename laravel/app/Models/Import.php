<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ImportData;

class Import extends Model {

  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'import';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = ['name'];

  public function createFromCSV($fileHandle)
  {
    $first = true;
    while ($row = fgetcsv($fileHandle))
    {
      if ($first)
      {
        $first = false;
        continue;
      }

      $importData = new ImportData();
      
      $importData->id = NULL;
      $importData->import_id = $this->id;
      $importData->data = $row;
      $importData->serialise();
      $importData->save();
    }
  }

}
