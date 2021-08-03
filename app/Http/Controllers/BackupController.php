<?php

namespace App\Http\Controllers;

use Log;
use Alert;
use Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
//new
use Illuminate\Support\Facades\File;
use App\Library\Services\DbHelperTools;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Response;

class BackupController extends Controller
{
    const PATH_TO_JSON_DATA = "backups/datas/";
    public function export(){
        $DbHelperTools=new DbHelperTools();
        $data = [
            't0' => ['service_categories' => $DbHelperTools->getDatasFromTableToArray('service_categories')],
            't1' => ['services' => $DbHelperTools->getDatasFromTableToArray('services')],  
            't2' => ['pr_tooths' => $DbHelperTools->getDatasFromTableToArray('pr_tooths')],  
         ];
         $data = json_encode($data);
         $backupFileName = time() . '_datas.json';
         $fileNameToDownload = 'datas.json';
        //put backup file
        $path = self::PATH_TO_JSON_DATA.'backup';
        if(!File::exists($path)) {
            File::makeDirectory($path, 0755, true, true);
        } 
        File::put(public_path($path.'/'.$backupFileName),$data);
        //put file 
        File::put(public_path(self::PATH_TO_JSON_DATA.$fileNameToDownload),$data);
        return Response::download(public_path(self::PATH_TO_JSON_DATA.$fileNameToDownload));
    }
    public function import(){
        $path = self::PATH_TO_JSON_DATA."datas.json";
        $json = json_decode(file_get_contents($path), true);
        foreach($json as $key => $datas){
            foreach($datas as $table => $rows){
                echo '------------------'.$table.'--------------------<br>';
                DB::table($table)->insert($rows);
            }
        }
        return true;
    }
    public function clear(){
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        //t1
        DB::table('services')->truncate();
        //t0
        DB::table('service_categories')->truncate();
        //
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        echo '<h1>Datas cleared</h1>';
        exit();
    }
    public function importCategories(){
        $path = self::PATH_TO_JSON_DATA."service_categories.json";
        $DbHelperTools=new DbHelperTools();
        $json = json_decode(file_get_contents($path), true);
        foreach($json as $key => $data){
            $DbHelperTools->manageServiceCategorie($data);
        }
        return true;
    }
    public function importServices(){
        $path = self::PATH_TO_JSON_DATA."services.json";
        $DbHelperTools=new DbHelperTools();
        $json = json_decode(file_get_contents($path), true);
        //dd($json);
        foreach($json as $key => $data){
            $DbHelperTools->manageService($data);
        }
        return true;
    }
    public function index()
    {
        $backupFolder=env('BACKUP_FOLDER');
        //$disk = Storage::disk(config('laravel-backup.backup.destination.disks')[0]);
        $disk = Storage::disk('local');
        

        //$files = $disk->files(config('laravel-backup.backup.name'));
        $files = $disk->files($backupFolder);
        
        $backups = [];
        // make an array of backup files, with their filesize and creation date
        foreach ($files as $k => $f) {
            // only take the zip files into account
            if (substr($f, -4) == '.zip' && $disk->exists($f)) {
                $backups[] = [
                    'file_path' => $f,
                    //'file_name' => str_replace(config('laravel-backup.backup.name') . '/', '', $f),
                    'file_name' => str_replace($backupFolder.'/', '', $f),
                    'file_size' => $disk->size($f),
                    'last_modified' => $disk->lastModified($f),
                ];
            }
        }
        // reverse the backups, so the newest one would be on top
        $backups = array_reverse($backups);
        //dd($backups);

        return view("backup.backups")->with(compact('backups'));
    }
    public function create()
    {
        try {
            /* only database backup*/
           Artisan::call('backup:run --only-db');
            /* all backup */
            /* Artisan::call('backup:run'); */
            $output = Artisan::output();
            Log::info("Backpack\BackupManager -- new backup started \r\n" . $output);
            session()->flash('success', 'Successfully created backup!');
            return redirect()->back();
            } catch (Exception $e) {
                    session()->flash('danger', $e->getMessage());
                    return redirect()->back();
            }
    }

    /**
     * Downloads a backup zip file.
     *
     * TODO: make it work no matter the flysystem driver (S3 Bucket, etc).
     */
    public function download($file_name)
    {
        $backupFolder=env('BACKUP_FOLDER');
        $file = $backupFolder.'/' . $file_name;
        $disk = Storage::disk('local');
        if ($disk->exists($file)) {
            return response()->download(storage_path("app/{$file}"));
        } else {
            abort(404, "The backup file doesn't exist.");
        }
    }

    /**
     * Deletes a backup file.
     */
    public function delete($file_name)
    {
        $backupFolder=env('BACKUP_FOLDER');
        $success = false;
        $disk = Storage::disk('local');
        if ($disk->exists($backupFolder . '/' . $file_name)) {
            $disk->delete($backupFolder . '/' . $file_name);
            $success = true;
        } else {
            abort(404, "The backup file doesn't exist.");
        }
        return response()->json(['success'=>$success]);
    }
}
