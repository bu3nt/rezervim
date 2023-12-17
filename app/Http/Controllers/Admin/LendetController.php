<?php

namespace App\Http\Controllers\Admin;

use SqlFormatter;
use Carbon\Carbon;
use SimpleXMLElement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class LendetController extends Controller
{
    public function canvas_collision()
    {
        return view('admin.lendet.canvas-collision');
    }      
    public function pixijs_hanoi()
    {
        return view('admin.lendet.pixijs-hanoi');
    }  
    public function pixijs_tictactoe()
    {
        return view('admin.lendet.pixijs-tictactoe');
    } 
    public function pgsql_to_xml()
    {  
        return view('admin.lendet.pgsql-to-xml');
    } 
    public function convert_sql_to_xml(Request $request)
    {     
        //$sql = trim($request->input('sql'));
        $file = $request->file('sql');
        $filePath = $file->store('sql_files');      
        $sql = Storage::get($filePath);
        if (Storage::disk('public')->exists($filePath)) {
            Storage::disk('public')->delete($filePath);
        }        
     
        $masterDatabaseConfig = config('database.connections.pgsql');
        $unique_name = 'temp_'.uniqid();
        $newDatabaseName = $unique_name;
        $masterConnection = DB::connection('pgsql');
        $masterConnection->statement("CREATE DATABASE $newDatabaseName");

        config([
            'database.connections.temp_conn' => [
                'driver' => $masterDatabaseConfig['driver'],
                'host' => $masterDatabaseConfig['host'],
                'port' => $masterDatabaseConfig['port'],
                'database' => $newDatabaseName,
                'username' => $masterDatabaseConfig['username'],
                'password' => $masterDatabaseConfig['password'],
            ],
        ]); 

        $tempConnection = DB::connection('temp_conn');

        try {
            SqlFormatter::format($sql);
        } catch (\Exception $e) {
            $errorMessage = $e->getMessage();
            $masterConnection->statement("DROP DATABASE IF EXISTS $newDatabaseName");            
            return redirect()->back()->with('error', "SQL file has an error: $errorMessage");
        }        

        $sql = str_replace(["\r", "\n"], '', $sql);
        $statements = explode(';', $sql);
        $statements = array_filter($statements);

        $statements = array_map(function ($statement) {
            return trim($statement);
        }, $statements);

        foreach($statements as $statement){
            $tempConnection->statement($statement);
        }
        $entities = [];
        $tables = $tempConnection->select("SELECT table_name FROM information_schema.tables WHERE table_schema = 'public' AND table_type = 'BASE TABLE'");
        $tempConnection->disconnect();
        $tableNames = array_column($tables, 'table_name');
        $tempConnection = DB::connection('temp_conn');
        foreach($tableNames as $tableName){
            $tableData = $tempConnection->select("SELECT * FROM {$tableName}");

            // XML LOGIC
            $xml = new SimpleXMLElement('<'.$tableName.'/>');
            foreach ($tableData as $item) {
                $itemXml = $xml->addChild('row');
                $properties = get_object_vars($item); 
                foreach ($properties as $propertyName => $propertyValue) {
                    $itemXml->addChild($propertyName, $propertyValue);
                }
            }
            $xmlString = $xml->asXML();
            $filename = $unique_name . '_' . $tableName.'.xml';
            $filePath = 'xml_files/' . $filename;
            Storage::put($filePath, $xmlString);
            $fileSizeBytes = Storage::disk('public')->size($filePath);
            $fileSize = number_format($fileSizeBytes / 1024, 2);            
            $lastModified = Storage::disk('public')->lastModified($filePath); 
            $timeAgo = Carbon::createFromTimeStamp($lastModified)->diffForHumans();           
            $entity = new \stdClass();
            $entity->name = $tableName;
            $entity->xml = [
                'url' => $filePath,
                'string' => $xmlString,
                'fileName' => $filename,
                'fileSize' => $fileSize,
                'timeAgo' => $timeAgo
            ];

            // XSD LOGIC
            $entity->xsd = [
                'url' => $filePath,
                'string' => $xmlString,
                'fileName' => $filename,
                'fileSize' => $fileSize,
                'timeAgo' => $timeAgo
            ];

            $entities[] = $entity;
        }
        $tempConnection->disconnect();
        $masterConnection->statement("DROP DATABASE IF EXISTS $newDatabaseName");
        $masterConnection->disconnect();        
        //dd($entities);

        return view('admin.lendet.convert-sql-to-xml', compact('entities'));
    }
}