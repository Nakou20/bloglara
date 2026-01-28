<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Article
 *
 * @property int $id
 * @property int|null $user_id
 * @property string $title
 * @property string $content
 * @property bool|null $draft
 * @property int|null $likes
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property User|null $user
 * @property Collection|Category[] $categories
 * @property Collection|Tag[] $tags
 * @property Collection|Comment[] $comments
 *
 * @package App\Models
 */
class Article extends Model
{
	use HasFactory;

	protected $table = 'articles';

	protected $casts = [
		'user_id' => 'int',
		'draft' => 'bool',
		'likes' => 'int'
	];

	protected $fillable = [
		'user_id',
		'title',
		'content',
		'draft',
		'likes'
	];

	protected $appends = [
		// expose reading_time if needed in JSON
		// 'reading_time',
	];

	protected static function booted(): void
	{
		static::deleting(function (Article $article) {
			// Détacher les relations many-to-many
			$article->categories()->detach();
			$article->tags()->detach();
			$article->likers()->detach();

			// Supprimer les enfants dépendants
			$article->comments()->delete();
		});
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function categories()
	{
		return $this->belongsToMany(Category::class);
	}

	public function tags()
	{
		return $this->belongsToMany(Tag::class);
	}

	public function comments()
	{
		return $this->hasMany(Comment::class);
	}

	public function likers(): BelongsToMany
	{
		return $this->belongsToMany(User::class, 'article_likes');
	}

	public function getReadingTimeAttribute(): int
	{
		// Compte des mots sur le contenu
		$text = strip_tags((string) $this->content);
		$words = str_word_count($text, 0, 'ÀÂÄÇÉÈÊËÎÏÔÖÙÛÜàâäçéèêëîïôöùûü');
		// Vitesse moyenne: 200 mots/min
		$minutes = (int) ceil(max(1, $words) / 200);
		return max(1, $minutes);
	}

	public function formattedReadingTime(): string
	{
		$m = $this->reading_time;
		return $m <= 1 ? '~1 min de lecture' : "~$m min de lecture";
	}

}
