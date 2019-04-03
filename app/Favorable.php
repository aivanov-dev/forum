<?php

namespace App;

trait Favorable
{
    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favorited');
    }

    public function favorite()
    {
        $attributes = ['user_id' => auth()->user()->id];

        if ( !$this->favorites()->where($attributes)->exists()) {
            return $this->favorites()->create($attributes);
        }
    }

    public function unfavorite()
    {
        $attributes = ['user_id' => auth()->user()->id];

        $this->favorites()->where($attributes)->delete();
    }

    public function isFavorited()
    {
        //if no one is sign in then trying to get property of non-object because auth()->user() is null
        return $this->favorites()->where('user_id', auth()->user())->exists();
//        return ! !$this->favorites->where('user_id', auth()->user()->id)->count();
    }

    public function getIsFavoritedAttribute()
    {
//        return '22456547';
        return $this->isFavorited();
    }

    public function getFavoritesCountAttribute()
    {
        //DOES NOT WORK FROM TRAIT, WHY? HAD TO DUPLICATE IN MODEL.
        //snake case in propert and singular getFavoritesCountAttribute, not getFavoritesCountAttributes
        return $this->favorites->count();
    }
}