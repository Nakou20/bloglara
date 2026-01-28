<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Tag
 * 
 * @property int $id
 * @property string $name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|Article[] $articles
 *
 * @package App\Models
 */
class Tag extends Model
{
	use HasFactory;
	protected $table = 'tags';

	protected $fillable = [
		'name'
	];

	public function articles()
	{
		return $this->belongsToMany(Article::class);
	}
}
