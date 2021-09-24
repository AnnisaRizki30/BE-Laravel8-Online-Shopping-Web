<?php
namespace App\Models;
use Tymon\JWTAuth\Contracts\JWTSubject; 
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; 
use Illuminate\Database\Eloquent\Model;

class Customer extends Authenticatable implements JWTSubject
{
 use HasFactory;
 /**
 * fillable
 *
 * @var array
 */
 protected $fillable = [
 'name', 'email', 'email', 'email_verified_at', 'password',
'remember_token'
 ];

 /**
 * invoice
 *
 * @return void
 */
 public function invoices()
 {
 return $this->hasMany(Invoice::class);
 }

 /**
 * reviews
 *
 * @return void
 */
 public function reviews()
 {
 return $this->hasMany(Review::class);
 }

 /**
 * getCreatedAtAttribute
 *
 * @param mixed $date
 * @return void
 */
 public function getCreatedAtAttribute($date)
 {
 $value = Carbon::parse($date);
 $parse = $value->locale('id');
 return $parse->translatedFormat('l, d F Y');
 }
/**
 * Get the identifier that will be stored in the subject claim of the JWT.
 *
 * @return mixed
 */
 public function getJWTIdentifier()
 {
 return $this->getKey();
 }
 /**
 * Return a key value array, containing any custom claims to be added to the JWT.
 *
 * @return array
 */
 public function getJWTCustomClaims()
 {
 return [];
 }

}
