<?php

namespace App\Livewire;

use App\Services\LectureService;
use Livewire\Component;
use Livewire\WithPagination;

class LectureReport extends Component
{
    use WithPagination;
    protected $listeners = ['onTherapistChange'=>'setTherapistId'];

    public ?int $therapist_id = null;

    public mixed $start_date;
    public mixed $end_date;

    private mixed $lectures = null;

    protected ?LectureService $lectureService = null ;


    public function __construct()
    {
        $this->lectureService = app(LectureService::class);
    }

    public function setTherapistId(int $therapist_id)
    {
        $this->therapist_id = $therapist_id;
    }
    public function getReport()
    {
        $filters= [
          'therapist_id'=>$this->therapist_id,
          'date_between'=>$this->start_date .'To'.$this->end_date,
        ];

       $this->lectures = $this->lectureService->getLectureReportForTherapist($filters);
    }


    public function render()
    {
        return view('livewire.lecture-report',[
            'lectures'=>$this->lectures
        ]);
    }
}
