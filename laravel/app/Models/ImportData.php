<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class ImportData extends Model {
  public $timestamps = false;

  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'import_data';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = ['import_id', 'data'];

  public function unserialise()
  {
    $this->data = unserialize($this->data);
  }

  public function serialise()
  {
    $this->data = serialize($this->data);
  }

  public function createFromCSV($file, $importID)
  {
    print_r($file);
  }

}
