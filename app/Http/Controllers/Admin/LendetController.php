<?php

namespace App\Http\Controllers\Admin;

use Phpml\Association\Apriori;
use SqlFormatter;
use Carbon\Carbon;
use SimpleXMLElement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Storage;

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
    public function sql_to_xml()
    {
        return view('admin.lendet.sql-to-xml');
    }
    public function upload_sql(Request $request)
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
        $databaseName = $unique_name;
        $masterConnection = DB::connection('pgsql');
        $masterConnection->statement("CREATE DATABASE $databaseName");

        config([
            'database.connections.temp_conn' => [
                'driver' => $masterDatabaseConfig['driver'],
                'host' => $masterDatabaseConfig['host'],
                'port' => $masterDatabaseConfig['port'],
                'database' => $databaseName,
                'username' => $masterDatabaseConfig['username'],
                'password' => $masterDatabaseConfig['password'],
            ],
        ]);

        $tempConnection = DB::connection('temp_conn');

        try {
            SqlFormatter::format($sql);
        } catch (\Exception $e) {
            $errorMessage = $e->getMessage();
            $masterConnection->statement("DROP DATABASE IF EXISTS $databaseName");
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

        $tempConnection->disconnect();
        $masterConnection->disconnect();

        return redirect()->route('admin.lendet.databaze_avancuar.convert_sql_to_xml', compact('databaseName'));
    }

    public function convert_sql_to_xml(Request $request) {
        $databaseName = $request->databaseName;
        $masterDatabaseConfig = config('database.connections.pgsql');
        config([
            'database.connections.temp_conn' => [
                'driver' => $masterDatabaseConfig['driver'],
                'host' => $masterDatabaseConfig['host'],
                'port' => $masterDatabaseConfig['port'],
                'database' => $databaseName,
                'username' => $masterDatabaseConfig['username'],
                'password' => $masterDatabaseConfig['password'],
            ],
        ]);

        $tempConnection = DB::connection('temp_conn');

        $entities = [];
        $tables = $tempConnection->select("SELECT table_name FROM information_schema.tables WHERE table_schema = 'public' AND table_type = 'BASE TABLE'");
        // Get foreign key columns for the specified table
        $tempConnection->disconnect();
        $tableNames = array_column($tables, 'table_name');
        $tempConnection = DB::connection('temp_conn');
        foreach($tableNames as $tableName){
            $tableColumns = $tempConnection->select("SELECT
                column_name, data_type
            FROM information_schema.columns
            WHERE table_name = '{$tableName}'");

            $foreignKeys = $tempConnection->select("SELECT
                kcu.column_name,
                kcu.constraint_name,
                ccu.table_name AS referenced_table_name,
                ccu.column_name AS referenced_column_name
            FROM information_schema.key_column_usage kcu
            JOIN information_schema.table_constraints tc ON tc.constraint_name = kcu.constraint_name
            JOIN information_schema.constraint_column_usage ccu ON ccu.constraint_name = tc.constraint_name
            WHERE kcu.table_name = '{$tableName}' AND kcu.constraint_name LIKE '%_fkey'");
            foreach($foreignKeys as $foreignKey){
                $columns = $tempConnection->select("SELECT column_name
                FROM information_schema.columns
                WHERE table_name = '{$foreignKey->referenced_table_name}'");
                $foreignKey->referenced_table_columns = array_column($columns, 'column_name');
            }

            $entity = new \stdClass();
            $entity->name = $tableName;
            $entity->columns = $tableColumns;
            $entity->foreignKeys = $foreignKeys;

            $entities[] = $entity;
        }

        $tempConnection->disconnect();

        return view('admin.lendet.convert-sql-to-xml', compact('entities', 'databaseName'));
    }

    public function generate_xml(Request $request) {

        $sql = $request->sql;
        $databaseName = $request->databaseName;
        $rrenja = strtolower($request->rrenja);
        $masterDatabaseConfig = config('database.connections.pgsql');
        config([
            'database.connections.temp_conn' => [
                'driver' => $masterDatabaseConfig['driver'],
                'host' => $masterDatabaseConfig['host'],
                'port' => $masterDatabaseConfig['port'],
                'database' => $databaseName,
                'username' => $masterDatabaseConfig['username'],
                'password' => $masterDatabaseConfig['password'],
            ],
        ]);

        $tempConnection = DB::connection('temp_conn');
        try {
            $tableData = $tempConnection->select($sql);
            if ($tableData) {
                $unique_name = 'temp_'.uniqid();
                $targetWord = "from";
                $foundTable = $this->findWordAfter(strtolower($sql), $targetWord);
                $row = $foundTable ? $foundTable : 'row';

                // XSD LOGIC
                $xsdFileName = $unique_name . '_' . $rrenja.'.xsd';
                $xsdFilePath = 'xml_files/' . $xsdFileName;
                $xsdString = '<?xml version="1.0" encoding="UTF-8"?>';
                $xsdString .= '<xs:schema xmlns:xs="http://www.w3.org/2001/XMLSchema">';
                $xsdString .= '<xs:element name="'.$rrenja.'">';
                $xsdString .= '<xs:complexType>';
                $xsdString .= '<xs:sequence>';
                $xsdString .= '<xs:element name="'.$row .'">';
                $xsdString .= '<xs:complexType>';
                $xsdString .= '<xs:sequence>';
                $item = $tableData[0];
                $properties = get_object_vars($item);
                foreach ($properties as $propertyName => $propertyValue) {
                    $xsdString .='<xs:element name="'.$propertyName.'"/>';
                }
                $xsdString .= '</xs:sequence>';
                $xsdString .= '</xs:complexType>';
                $xsdString .= '</xs:element>';
                $xsdString .= '</xs:sequence>';
                $xsdString .= '</xs:complexType>';
                $xsdString .= '</xs:element>';
                $xsdString .= '</xs:schema>';
                Storage::put($xsdFilePath, $xsdString);
                $fileSizeBytes = Storage::disk('public')->size($xsdFilePath);
                $xsdFileSize = number_format($fileSizeBytes / 1024, 2);
                $lastModified = Storage::disk('public')->lastModified($xsdFilePath);
                $xsdTimeAgo = Carbon::createFromTimeStamp($lastModified)->diffForHumans();


                $xsd = [
                    'url' => $xsdFilePath,
                    'string' => $xsdString,
                    'fileName' => $xsdFileName,
                    'fileSize' => $xsdFileSize,
                    'timeAgo' => $xsdTimeAgo
                ];

                // XML LOGIC
                $xml = new SimpleXMLElement('<'.$rrenja.' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNameSpaceSchemaLocation="'.$xsdFileName.'" />');
                foreach ($tableData as $item) {
                    $itemXml = $xml->addChild($row);
                    $properties = get_object_vars($item);
                    foreach ($properties as $propertyName => $propertyValue) {
                        $itemXml->addChild($propertyName, $propertyValue);
                    }
                }
                $xmlString = $xml->asXML();
                $xmlFileName = $unique_name . '_' . $rrenja.'.xml';
                $xmlFilePath = 'xml_files/' . $xmlFileName;
                Storage::put($xmlFilePath, $xmlString);
                $fileSizeBytes = Storage::disk('public')->size($xmlFilePath);
                $xmlFileSize = number_format($fileSizeBytes / 1024, 2);
                $lastModified = Storage::disk('public')->lastModified($xmlFilePath);
                $xmlTimeAgo = Carbon::createFromTimeStamp($lastModified)->diffForHumans();
                $xml = [
                    'url' => $xmlFilePath,
                    'string' => $xmlString,
                    'fileName' => $xmlFileName,
                    'fileSize' => $xmlFileSize,
                    'timeAgo' => $xmlTimeAgo
                ];

                $data = [
                    'success' => true,
                    'xml' => $xml,
                    'xsd' => $xsd
                ];
            } else {
                $data = [
                    'success' => false,
                    'message' => 'Pyetësori përmban gabime. Ju lutem rishikoni dhe provoni përsëri!'
                ];
            }
        } catch (QueryException $exception) {
            $data = [
                'success' => false,
                'error' => $exception->getMessage(),
                'message' => 'Pyetësori përmban gabime. Ju lutem rishikoni dhe provoni përsëri!'
            ];
        }

        return response()->json($data);
    }


    function measureMemoryUsage($variable, $description = '') {
        $memoryBefore = memory_get_usage(true);
        $unused = $variable; // Ensure the variable is used
        $memoryAfter = memory_get_usage(true);
        $memoryUsed = $memoryAfter - $memoryBefore;

        echo $description . " memory usage: " . $memoryUsed . " bytes\n";
    }

    public function apriori() {
        $samples = [['alpha', 'beta', 'epsilon'], ['alpha', 'beta', 'theta'], ['alpha', 'beta', 'epsilon'], ['alpha', 'beta', 'theta']];
        $labels  = [];

        $associator = new Apriori($support = 0.5, $confidence = 0.5);
        $associator->train($samples, $labels);

        // PREDICT
        $associator->predict(['alpha','theta']);
        $associator->predict([['alpha','epsilon'],['beta','theta']]);

        // ASSOCIATING
        $rules = $associator->getRules();

        // FREQUENT ITEMS SETS
        $frequent_items_sets = $associator->apriori();
        dd($frequent_items_sets);
        return view('admin.lendet.apriori', compact('rules', 'frequent_items_sets'));
    }

    private function findWordAfter($haystack, $targetWord) {
        $pos = strpos($haystack, $targetWord);

        if ($pos !== false) {
            $substring = substr($haystack, $pos + strlen($targetWord));
                $matches = [];
            preg_match('/\b(\w+)\b/', $substring, $matches);
            if (isset($matches[1])) {
                return $matches[1];
            }
        }
        return null;
    }

    public function lab_2() : void
    {
        $starti = microtime(true);
        $numri = 35;
        echo "<p>Fibonacci numrat deri tek " . $numri . ": ";
        for ($i = 1; $i <= $numri; $i++) {
            echo $this->fibonacci($i) . " ";
        }
        echo "</p>";
        $fundi = microtime(true);
        $kohaEGjenerimitMicro = $fundi - $starti;
        $kohaEGjenerimitSekonda = $kohaEGjenerimitMicro / 1000000;
        echo "<p>Koha e gjenerimit: " . number_format($kohaEGjenerimitSekonda, 13) . " sekonda</p>";
    }

    private function fibonacci(int $n)
    {
        if ($n < 3) {
            return 1;
        } else {
            return ($this->fibonacci($n - 2) + $this->fibonacci($n - 1));
        }
    }
}
