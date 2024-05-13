<?php

namespace App\Listeners;

use UniSharp\LaravelFilemanager\Events\ImageWasUploaded;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ResizeUploadedImage
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(ImageWasUploaded $event)
    {
        $path = $event->path();
        $manager = new ImageManager(new Driver());
        $image = $manager->read($path);
        if ($image->width() < 1200) {
            return;
        }
        $image->resize(1200, 800, function ($constraint) {
            $constraint->aspectRatio();
        })->save($path);
    }
}
