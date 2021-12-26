<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Record;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CalendarController extends Controller
{
    public function index()
    {
        return view('admin.pages.calendar');
    }

    public function records()
    {
        header('Content-type: application/json');

        $tekDate = Carbon::today()->format('Y-m-d');

        $data = Record::whereDate('start', '>=', $tekDate)
            ->orderBy('start', 'asc')
            ->get(['id', 'title', 'start', 'end', 'status', 'all_day']);

        foreach ($data as $elem) {
            switch ($elem->status) {
                case 1:
                    $elem->setAttr('className', "greenEvent");
                    break;
                case 2:
                    $elem->setAttr('className', "yellowEvent");
                    break;
                case 3:
                    $elem->setAttr('className', "redEvent");
                    break;
                case 4:
                    $elem->setAttr('className', "greyEvent");
                    break;
            }
        }

        return response()->json($data);
    }

    public function createRecords(Request $request)
    {

        $data = $request->date;
        $arrRecords = $request->timeRecords;

        foreach ($arrRecords as $record) {

            $date = $request->date . ' ' . $record['value'];
            $arrData = [
                'title' => $record['title'] ? $record['title'] : '',
                'start' => $date,
                'end' => $date,
                'status' => $record['status']
            ];
            $event = Record::create($arrData);
        }

        return response()->json($event);

    }

    public function getDataRecord(Request $request)
    {

        $recordId = $request->recordId;
        $services = Service::all();

        $event = Record::find($recordId);

        $name = '';
        $phone = '';
        $status = '';
        $serviceId = false;

        if ($event) {

            if ($event->user) {
                $name = $event->user->surname . ' ' . $event->user->name;
                $phone = $event->user->phone;
            }


            if ($event->service) {
                $serviceId = $event->service->id;
            }
            $status = $event->status;
        }


        $date = Carbon::create($event->start);

        $data = [
            'date' => $date->format('d.m.Y') . ' ' . $date->format('(D)'),
            'time' => $date->format('H:s'),
            'name' => $name,
            'phone' => $phone,
            'serviceId' => $serviceId,
            'services' => $services,
            'status' => $status,
        ];

        return response()->json($data);

    }

    public function actionWithEvents(Request $request)
    {

        $data = $request->all();
        $record = Record::find($data['recordId']);

        $user = User::where('phone', $data['phone'])->first();

        if (!$user) {

            $arFio = explode(" ", $data['name']);
            $surname = $arFio[0];
            $name = $arFio[1];

            $lastId = User::orderBy('id', 'desc')->get()->first()->id;
            $lastId++;
            $dataUser = [
                'name' => $name,
                'surname' => $surname,
                'phone' => $data['phone'],
                'password' => Hash::make(Str::random(8)),
                'email' => "user$lastId@user.com",
            ];
            $user = User::create($dataUser);

        }

        $record->update([
            'user_id' => $user->id,
            'status' => 3,
            'service_id' => $data['serviceId']
        ]);

        return response()->json($record);
    }

    public function searchAutocomplete(Request $request)
    {
        $query = $request->str;
        $users = User::where('name', 'LIKE', '%'.$query.'%')
            ->orWhere('surname', 'LIKE', '%'.$query.'%')
            ->get();

        $name = [];
        if($users){
            foreach ($users as $user) {
                $name[$user->phone] = $user->surname . ' ' . $user->name;
            }
        }
        return response()->json($name);
    }

    public function confirmRecord(Request $request){
        $recordId = $request->recordId;

        $obRecord = Record::find($recordId);
        $obRecord->update(['status' => 3]);
        return response()->json($obRecord);
    }
    public function cancelRecord(Request $request){
        $recordId = $request->recordId;

        $obRecord = Record::find($recordId);
        $obRecord->update([
            'status' => 1,
            'user_id' => null,
            'service_id' => null,
            ]);
        return response()->json($obRecord);
    }
    public function deleteRecord(Request $request){
        $recordId = $request->recordId;
        $obRecord = Record::find($recordId)->delete();

        return response()->json($obRecord);
    }

}
