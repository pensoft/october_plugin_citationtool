<?php namespace Pensoft\CitationTool\Components;

use Carbon\Carbon;
use Cms\Classes\ComponentBase;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use October\Rain\Support\Facades\Flash;
use Pensoft\CitationTool\Models\Citation;
use RainLab\User\Models\User;
use System\Models\File;
use ValidationException;
use System\Classes\MediaLibrary;
use Auth;


class Form extends ComponentBase
{
    public function componentDetails(): array
    {
        return [
            'name'        => 'Form Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties(): array
    {
        return [];
    }

    public function onRun(): void
    {
        $user = Auth::getUser();
        if($user){
            $this->page['from_user'] = $user->id;
            $this->page['individuals'] = $this->individuals();
        }else{
            return;
        }

    }


    public function individuals()
    {
        $users = User::where('is_activated', true)->get();
        return $users;
    }

    public function onSubmit(){
        $user = Auth::getUser();

        if(!$user->id){
            return Redirect::to('/');
        }
        $validator = Validator::make(
            $form = request()->all(), [
                'title' => 'required',
                'authors' => 'required',
                'year' => 'required|integer',
                'attachment' => 'max:2000',
            ]
        );

        if($validator->fails()){
            throw new ValidationException($validator);
        }

        $title = request()->input('title');
        $authors = request()->input('authors');
        $year = request()->input('year');
        $journal_title = request()->input('journal_title');
        $publisher = request()->input('publisher');
        $pages = request()->input('pages');
        $volume_issue = request()->input('volume_issue');
        $doi = request()->input('doi');
        $place = request()->input('place');

        $date = Carbon::now();

        $citation = new Citation();
        $citation->title = $title;
        $citation->authors = $authors;
        $citation->year = $year.'-'.$date->month.'-'.$date->day;
        $citation->journal_title = $journal_title;
        $citation->publisher = $publisher;
        $citation->pages = $pages;
        $citation->volume_issue = $volume_issue;
        $citation->doi = $doi;
        $citation->place = $place;

        $attachment = request()->file('attachment');
        if($attachment){
            $file = $attachment;

            $maxFileSize = $file->getMaxFilesize();
            $file_name = $file->getClientOriginalName();
            $file_size = $file->getSize();
            $content_type = $file->getMimeType();
            if($file->getSize() > 3807119){
                Flash::error($file_name.' is too big!');
                return;
            }
        }

        $citation->file_upload= $attachment;

        $citation->save();





        Flash::success('Thank you!');
        return Redirect::to('/citations');
    }

    public function onFileUpload(){
        $formData = request()->all();
        $files = $formData['attachment'];
        $output = '';
        foreach ($files as $f) {
            $file = (new File())->fromPost($f);
            if($file->getExtension() == 'docx' || $file->getExtension() == 'doc'){
                $mediaFileName = 'files_doc.svg';
            }else if($file->getExtension() == 'pdf'){
                $mediaFileName = 'files_pdf.svg';
            }else{
                $mediaFileName = 'files_file.svg';
            }
            $output .= '<img src="' . MediaLibrary::url($mediaFileName) . '" style="width: 30px; float: left; margin-right: 8px;"> '. $file->getFilename().' <br>';
        }

        return  [
            '#attachmentPreview' => $output
        ];
    }
}
