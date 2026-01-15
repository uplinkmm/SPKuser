<?php

namespace App\Traits;

use App\Models\Notification;
use InvalidArgumentException;
use App\Http\Action\Notifying;
use App\Models\PersonFcmToken;
use App\Models\NotificationPerson;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Notification as NotificationQueue;

trait SendNotification
{


    public function send($model, $people, $data)
    {
        $morphMapName = RelationMorphName($model);
        $data['type'] = $morphMapName;
        // $personMapName = RelationMorphName($people);
        $people = $this->normalizeToCollection($people);
        $notification = Notification::create([
            'title' => $data['title'],
            'preview' => $data['body'],
            'date_time' => now(),
            'notificationable_id' => $model->id,
            'notificationable_type' => $morphMapName,
            'createdable_id' => $morphMapName=='customer' ? $model->id :UserData()->id,
            'createdable_type' => 'customer',
        ]);
        

        $notificationPersons = [];
        foreach ($people as $person) {
            $personMorphMapName = RelationMorphName($person);
            $notificationPersons[] = [
                'notification_id' => $notification->id,
                'personable_id' => $person->id,
                'personable_type' => $personMorphMapName,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        NotificationPerson::insert($notificationPersons);
        // Send notification using Notification facade
        NotificationQueue::send($people, new Notifying($data));
    }

    protected function normalizeToCollection($people)
    {
        // If $people is not already a collection, convert it to one
        if ($people instanceof Model) {
            return collect([$people]);
        } elseif (is_array($people)) {
            return collect($people);
        } elseif ($people instanceof Collection) {
            return $people;
        } else {
            throw new InvalidArgumentException('People should be a Model, array, or Collection.');
        }
    }

    public function getTokensByPerson($person_ids, $type)
    {
        return PersonFcmToken::whereIn('personable_id', $person_ids)
            ->where('personable_type', $type)
            ->pluck('fcm_token')->toArray();
    }
}
