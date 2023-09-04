<?php

namespace App\Http\Controllers;

use App\DataTables\Logs\AuditLogsDataTable;
use App\DataTables\Scopes\Users\Logs;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class UsersController extends Controller
{
    public function download(Media $media,Request $request) {
        try {
            if(!$request->hasValidSignature()){
                abort(401);
            }
            $user = auth()->user();
            /** @var User $user */
            if($media->model()->first() instanceof Message){
                $message = $media->model()->first();
                if ($user->isManager() || $message->user_id == $user->id){
                    // TODO check with permission
                    return response()->file($media->getPath());
                }
            }
        }catch (\Exception $exception){
            abort(404);
        }
    }

    public function getLogs(User $user){
        $dataTable = new AuditLogsDataTable();
        return $dataTable->addScope(new Logs($user))->render('pages.log.audit.index');
    }

    public function openNotification(DatabaseNotification $notification){
        $notification->read_at = now();
        $notification->save();
        if (isset($notification->data['link'])){
            return redirect()->to($notification->data['link']);
        }
    }

}
