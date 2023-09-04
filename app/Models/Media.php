<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Media extends \Spatie\MediaLibrary\MediaCollections\Models\Media
{
    use HasFactory,LogsActivity;

    public function getTempUrl(): string {
        return URL::temporarySignedRoute('download',now()->addMinutes(5),['media'=> $this->id]) ;
    }
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('media')->logOnlyDirty()->logAll();
    }
}
