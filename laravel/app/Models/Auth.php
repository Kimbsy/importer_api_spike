<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Auth extends Model {
  public $timestamps = false;

  protected $table = 'auth';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = ['access_token'];

}
