<?php

namespace App\Imports;

use App\Models\Participant;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ParticipantsImport implements ToCollection, WithHeadingRow
{
    use Importable;

    // here ToCollection, withHeadingRow gives an error by default, to romeve this error we have to refresh our vs-code or we can do close the code editor and re open the ediitor
    /**
     * @param Collection $collection
     */
    public $eventId;
    public $participantTypeId;

    public function __construct($eventId, $participantTypeId)
    {
        $this->eventId = $eventId;
        $this->participantTypeId = $participantTypeId;
    }


    // public function rules(): array
    // {
    //     return [
    //         'name' => 'required',
    //         'affiliated_institute' => 'nullable',
    //         'post' => 'nullable',
    //         'event_id' => 'required|numeric',
    //         'participant_type_id' => 'required|numeric',
    //     ];
    // }

    public function collection(Collection $rows)
    {

        foreach ($rows as $row) {
            Participant::create([
                'event_id' => $this->eventId,
                'participant_type_id' => $this->participantTypeId,

                'name' => $row['name'],

                'affilated_institute' => $row['affilated_institute'],

                'post' => $row['post']
            ]);
        }
    }
    
}
