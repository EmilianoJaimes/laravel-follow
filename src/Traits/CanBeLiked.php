<?php

/*
 * This file is part of the overtrue/laravel-follow
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Overtrue\LaravelFollow\Traits;

use Overtrue\LaravelFollow\Follow;

/**
 * Trait CanBeLiked.
 */
trait CanBeLiked
{
    /**
     * Check if user is isLikedBy by given user.
     *
     * @param int $user
     *
     * @return bool
     */
    public function isLikedBy($user)
    {
        return Follow::isRelationExists($this, 'likers', $user);
    }

    /**
     * Return followers.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function likers()
    {
        return $this->morphToMany(config('follow.user_model'), config('follow.morph_prefix'), config('follow.followable_table'))
                    ->wherePivot('relation', '=', Follow::RELATION_LIKE)
                    ->whereNull('deleted_at')
                    ->withPivot('followable_type', 'relation', 'created_at');
    }

    /**
     * Alias of likers.
     *
     * @return mixed
     */
    public function fans()
    {
        return $this->likers();
    }
}
