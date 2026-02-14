<?php

namespace App\Services;

use App\Models\UserActivity;
use Illuminate\Support\Facades\Auth;

class ActivityTracker
{
    public static function log(string $type, string $title, string $description = null, $relatedModel = null)
    {
        if (!Auth::check()) {
            return;
        }

        UserActivity::create([
            'user_id' => Auth::id(),
            'activity_type' => $type,
            'title' => $title,
            'description' => $description,
            'related_type' => $relatedModel ? get_class($relatedModel) : null,
            'related_id' => $relatedModel ? $relatedModel->id : null,
        ]);
    }
}
